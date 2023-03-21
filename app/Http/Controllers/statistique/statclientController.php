<?php

namespace App\Http\Controllers\statistique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
class statclientController extends Controller
{
    public function get_stat_client(Request $request)
    {
        $req = DB::table('bagage')
        ->join('gare', 'bagage.gare_id', 'gare.id')
        ->join('users', 'bagage.users_id', 'users.id')
        ->leftJoin('remises', 'bagage.id', 'remises.bagage_id')
      //  ->where('bagage.gare_id', Auth::user()->gare_id)
        ->where('gare.compagnie_id', Auth::user()->compagnie_id);
        if(!empty($request->start))
        {
            $req->where('bagage.created_at','>=', $request->start);
            session(['start' => $request->start]);
        }
        if(!empty($request->end))
        {
            $req->where('bagage.created_at','<=', $request->end);
            session(['end' => $request->end]);
        }
        if(empty($request->start) && empty($request->end))
        {
            $req->whereDate('bagage.created_at', '>=', date('Y-m-d'));
            session(['start' => date('Y-m-d')]);
                        session(['end' => date('Y-m-d')]);
        }
        if (!empty($request->gare_id))
        {
           // dd( $request->gare_id);
            $req->where('bagage.gare_id', $request->gare_id);
            $nomgare  = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id',$request->gare_id)->get('nom_gare');
            session(['nomgare' => $nomgare[0]->nom_gare]);
        }
        if(empty($request->gare_id))
        {
            session(['nomgare' => 'Toutes les gares']);
        }
        $rapportGares = $req->where('bagage.is_solded', 1)->select('bagage.name_passager','bagage.phone_passager', DB::raw('count(bagage.id) as qte_impression'), DB::raw('sum(bagage.nbr_de_bagage) as qte_bagage'), DB::raw('sum(bagage.prix) as prix'), DB::raw('sum(remises.montant) as montant_remises'))->groupBy( 'bagage.name_passager','bagage.phone_passager')->get();

        $data = ['stat_client' =>$rapportGares,

        'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
    ];
    session(['rapportGares' => $rapportGares]);
    return view('statistique.recap-client',$data);
    }

    public function get_stat_colis_client(){
        return view('statistique.colis.recap-client');
    }
}
