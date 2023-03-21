<?php

namespace App\Http\Controllers\chefdegare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth, DB;

class DashboardController extends Controller
{
    //
    public function index()
    {   
        $bagages = DB::table('bagage')->where('gare_id', Auth::user()->gare_id)->whereDate('created_at', date('Y-m-d'))->orderBy('id', 'DESC')->get();
        $gare = DB::table('gare')->where('id', Auth::user()->gare_id)->first();
        
        return view("chefdegare/index", compact('bagages', 'gare'));
    }
}
