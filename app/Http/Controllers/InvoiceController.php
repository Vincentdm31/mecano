<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function edit($id){

        $intervention = Intervention::find($id);

        return view('invoice.edit', ['intervention' => $intervention]);
    }
}
