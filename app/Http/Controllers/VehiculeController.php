<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Facade\FlareClient\Http\Client as HttpClient;
use GuzzleHttp\Client;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class VehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicules = Vehicule::all();
        return view('vehicules.index', ['vehicules' => $vehicules]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehicules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token', 'created_at', 'updated_at');
        $vehicule = new Vehicule();
        foreach ($inputs as $key => $value) {
            $vehicule->$key = $value;
        }

        $vehicule->save();
        return redirect(route('vehicules.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicule  $vehicule
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicule $vehicule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicule  $vehicule
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicule = Vehicule::find($id);
        return view('vehicules.edit', ['vehicule' => $vehicule]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicule = Vehicule::find($id);
        $vehicule->delete();


        return redirect(route('vehicules.index'));
    }

    public function searchVehicule(Request $request)
    {
        $search = $request->get('searchVehicule');

        $vehicules = Vehicule::Where('mark', 'like', '%' . $search . '%')
            ->orWhere('model', 'like', '%' . $search . '%')
            ->orWhere('license_plate', 'like', '%' . $search . '%')
            ->get();
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
                'mark' => $item->Brand,
                'model' => $item->Model,
                'capacity' => $item->Capacity,
                'license_plate' => $item->Matriculation
            ]);

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
