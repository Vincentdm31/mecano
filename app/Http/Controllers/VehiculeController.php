<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::orderBy('capacity')->paginate(5);

        return view('vehicules.index', ['vehicules' => $vehicules]);
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->except('_token', '_method', 'updated_at');
        $vehicule = Vehicule::find($id);

        foreach ($inputs as $key => $value) {
            $vehicule->$key = $value;
        }

        $vehicule->save();

        return redirect(route('vehicules.index'));
    }

    public function searchVehicule(Request $request)
    {
        $search = $request->get('searchVehicule');

        $vehicules = Vehicule::Where('brand', 'like', '%' . $search . '%')
            ->orWhere('model', 'like', '%' . $search . '%')
            ->orWhere('license_plate', 'like', '%' . $search . '%')
            ->paginate(5);

        return view('vehicules.index', ['vehicules' => $vehicules]);
    }

    public function getVehicles()
    {
        $token = $this->getToken();

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . strval($token)
        ];

        $client = new client();

        $response = $client->get('https://resource.isatis.app/api/vehicule', [
            'headers' => $headers
        ]);

        $response = json_decode($response->getBody());

        foreach ($response as $item) {

            $vehicle = Vehicule::firstOrCreate([
                'id' => $item->Id,
                'brand' => $item->Brand,
                'model' => $item->Model,
                'capacity' => $item->Capacity,
                'license_plate' => $item->Matriculation
            ]);
            
            
            if ($item->Capacity > 34) {
                $vehicle->category = 4;
            } elseif ($item->Capacity > 22) {
                $vehicle->category = 3;
            } elseif ($item->Capacity > 9) {
                $vehicle->category = 2;
            } else{
                $vehicle->category = 1;
            }

            $vehicle->save();
        }

        $duplicates = DB::table('vehicules')
            ->select('license_plate')
            ->groupBy('license_plate')
            ->havingRaw('COUNT(*) > 1')
            ->get();;

        dd($duplicates);

        return redirect(route('vehicules.index'));
    }

    public function getToken()
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $key = "9CD9A62A4D2841A78406A65625212929";

        $client = new client();
        $res = $client->post('https://resource.isatis.app/api/auth/token', [
            'headers' => $headers,
            'json' => $key
        ]);

        $res = json_decode($res->getBody());

        return $res->Token;
    }
}
