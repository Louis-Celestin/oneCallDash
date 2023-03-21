<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Auth;

class FraisDeRouteController extends Controller
{
    //
    function index() {

        //Gares ou gare si chefgare
        $reqGare = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id);

        // Départs 
        $reqDeparts = DB::table('depart_ville_heure')->where('compagnie_id', Auth::user()->compagnie_id);

        //Bagages
        $req = DB::table('bagage')
        ->where('compagnie_id', Auth::user()->compagnie_id)
        ->where('bagage.is_solded', 1);

        //Rapport Bagages DEPART
        $reqBagagesDep = DB::table('bagage')
        ->join('depart_jour', 'bagage.num_depart', 'depart_jour.num_depart')
        ->where('bagage.compagnie_id', Auth::user()->compagnie_id)
        ->where('bagage.created_at', '>=', date('Y-m-d'))
        ->where('bagage.is_solded', 1);

        if (Auth::user()->usertype != "admin") {
            $reqGare->where('id', Auth::user()->gare_id);
            $reqDeparts->where('ville_depart', Auth::user()->gare_id);
            $req->where('bagage.gare_id', Auth::user()->gare_id);
        }

        $req->wheredate('created_at', date('Y-m-d'));

        $gares = $reqGare->get();
        $departs = $reqDeparts->select('nom_depart')->distinct()->get();
        $todayBagage = $req->orderBy('id', 'DESC')->get();
        
        
        $bagageDepartRaopprt = $reqBagagesDep
        ->select('depart_jour.num_depart', DB::raw('SUM(bagage.prix) as sumticket'), DB::raw('SUM(bagage.frais_de_route) as fraisroute'), DB::raw('COUNT(bagage.id) as countticket'), 'bagage.gare_id', DB::raw('DATE(bagage.created_at) as date'))
        ->groupBy('date', 'num_depart', 'gare_id')
        ->get();


        // $remises = DB::table('remises')
        // ->join('bagage', 'remises.bagage_id', 'bagage.id')
        // ->join('users', 'remises.agent_id', 'users.id')
        // ->join('gare', 'remises.gare_id', 'gare.id')
        // ->where('bagage.is_solded', 1)->where('remises.compagnie_id', Auth::user()->compagnie_id)->whereDate('remises.created_at', date('Y-m-d'))->orderBy('bagage.id', 'DESC')->paginate(5);
        
        // dd($departs);
        // dd($remises);
        
        $dates = explode("|", date('Y-m-d'));

        if (count($dates) < 2) {
            $dates[1] = $dates[0];
        }

        return view('index-frais-de-route', compact('todayBagage', 'departs', 'gares', 'dates', 'bagageDepartRaopprt'));

    }


    function search(REQUEST $request)
    {

        dd($request->all());
    }
}
