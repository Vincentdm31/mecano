<?php

namespace App\Http\Controllers;

use Facade\FlareClient\Http\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test(){

            $response = Http::get('https://my-json-server.typicode.com/typicode/demo/posts');

            dd(json_decode($response->getBody()));
    }
}
