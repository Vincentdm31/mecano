<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Facade\FlareClient\Http\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test()
    {

        $response = Http::get('https://my-json-server.typicode.com/typicode/demo/posts');


        foreach (json_decode($response->getBody()) as $item) {

            $vehicule = new Vehicule();
            $vehicule->marque = $item->title;
            $vehicule->modele = "test";
            $vehicule->immat = "testt";
            $vehicule->save();
            // TEST API
        }
    }
}
