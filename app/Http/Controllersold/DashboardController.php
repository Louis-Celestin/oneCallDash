<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        if(Auth::user()->usertype == "chefgare" || Auth::user()->usertype == "caissiere")
        {
            return redirect()->route('dashboard-chefdegare');
        }

        $colis = DB::table('colis')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereDate('created_at', date('Y-m-d'))->get();

        

        $req = DB::table('bagage')->where('compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 1)->wheredate('created_at', date('Y-m-d'));
        $todayBagage = $req->orderBy('id', 'DESC')->get(); 
        
        // get list id from bagage  with pluck of request
        $detailBagage = DB::table('detail_bagages')->wherein('bagage_id',$req->pluck('id'))->get();

        $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();
        $users = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();

        $remises = DB::table('remises')
        ->join('bagage', 'remises.bagage_id', 'bagage.id')
        ->join('users', 'remises.agent_id', 'users.id')
        ->join('gare', 'remises.gare_id', 'gare.id')
        ->where('bagage.is_solded', 1)->where('remises.compagnie_id', Auth::user()->compagnie_id)->whereDate('remises.created_at', date('Y-m-d'))->orderBy('bagage.id', 'DESC')->paginate(5);
        
        // dd($detailBagage);
        // dd($remises);
        
        $dates = explode("|", date('Y-m-d'));

        if (count($dates) < 2) {
            $dates[1] = $dates[0];
        }

        return view('index', compact('todayBagage', 'detailBagage', 'gares', 'users', 'remises', 'dates', 'colis'));
    }
}
