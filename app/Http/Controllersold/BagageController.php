<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class BagageController extends Controller
{
    //
    public function getTarifications()
    {
       
    }

    public function storeBagageTarif(REQUEST $request)
    {
        dd($request->all());
    }
}
