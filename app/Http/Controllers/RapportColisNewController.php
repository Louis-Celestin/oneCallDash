<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class RapportColisNewController extends Controller
{

    public function index(){
        $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();
        $agents = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();

        $colis = DB::table('colis')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereDate('created_at', date('Y-m-d'))->get();

        $colisMonth = DB::table('colis')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereMonth('created_at', date('m'))->get();

        $colisYear = DB::table('colis')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereYear('created_at', date('Y'))->get();

        $colisGroupByGare  = DB::table('colis')
        ->join('gare', 'colis.gare_id_envoi', 'gare.id')
        ->where('colis.compagnie_id', Auth::user()->compagnie_id)
        ->whereDate('colis.created_at', date('Y-m-d'))
        ->select(DB::raw('count(*) as qte_client'), DB::raw('sum(nbre_colis) as qte_colis'), 'gare.id as gare_id', DB::raw('sum(prix) as prix_gare'))->groupBy('gare_id')
        ->get();

       
        return view('rapport_colis', compact('colis', 'colisMonth', 'colisYear', 'colisGroupByGare', 'gares', 'agents'));
    }

public function apercu()
{
    $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();
    $agents = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();

    $colis = DB::table('colis')
    ->where('compagnie_id', Auth::user()->compagnie_id)->whereDate('created_at', date('Y-m-d'))->get();

    $colisMonth = DB::table('colis')
    ->where('compagnie_id', Auth::user()->compagnie_id)->whereMonth('created_at', date('m'))->get();

    $colisYear = DB::table('colis')
    ->where('compagnie_id', Auth::user()->compagnie_id)->whereYear('created_at', date('Y'))->get();

    $reqColisGroupByGare  = DB::table('colis')
    ->join('gare', 'colis.gare_id_envoi', 'gare.id')
    ->where('colis.compagnie_id', Auth::user()->compagnie_id)
    ->whereDate('colis.created_at', date('Y-m-d'));


}

public function details_colis ($date,Request $request)
{
    if (Auth::user()->usertype == "admin") {
        $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();
        $agents = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();
    } else {
        $gares = DB::table('gare')->where('gare.id', Auth::user()->gare_id)->where('compagnie_id', Auth::user()->compagnie_id)->get();
        $agents = DB::table('users')->where('users.gare_id', Auth::user()->gare_id)->where('compagnie_id', Auth::user()->compagnie_id)->get();
    }
    $dates = explode("|", $date);

    if (count($dates) < 2) {
        $dates[1] = $dates[0];
    }


    $colis = DB::table('colis')
  
    ->where('compagnie_id', Auth::user()->compagnie_id)->whereDate('created_at', date('Y-m-d'))->get();

    $colisMonth = DB::table('colis')
    ->where('compagnie_id', Auth::user()->compagnie_id)->whereMonth('created_at', date('m'))->get();

    $colisYear = DB::table('colis')
    ->where('compagnie_id', Auth::user()->compagnie_id)->whereYear('created_at', date('Y'))->get();

    if (Auth::user()->usertype != "admin") {
        $colisYear->where('colis.gare_id_envoi', Auth::user()->gare_id);
        $colisMonth->where('colis.gare_id_envoi', Auth::user()->gare_id);
    } 
    return view('colis.colis_activites', compact('gares', 'agents', 'colis', 'colisMonth', 'colisYear', 'dates'));
    dd($request);
}

}