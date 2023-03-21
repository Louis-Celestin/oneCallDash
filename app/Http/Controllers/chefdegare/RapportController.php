<?php

namespace App\Http\Controllers\chefdegare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Validator;

class RapportController extends Controller
{
    //
    public function index()
    {
        $req =  DB::table('bagage')->join('depart_ville_heure', 'bagage.depart_id', 'depart_ville_heure.id')
        ->where('bagage.compagnie_id', Auth::user()->compagnie_id)
        ->where('bagage.is_solded', 1)
        ->where('bagage.gare_id', Auth::user()->gare_id)
        ->select('depart_ville_heure.nom_depart', 'depart_ville_heure.heure_depart', DB::raw('count(bagage.id) as qte_client'), DB::raw('sum(nbr_de_bagage) as qte_bagage'), DB::raw('sum(prix) as prix_depart'))
        ->groupBy('depart_ville_heure.nom_depart', 'depart_ville_heure.heure_depart');

        $reqcolis=DB::table('colis')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', Auth::user()->gare_id);


        if (session()->has('date')) {

            $req->whereDate('bagage.created_at', '>=' , session()->get('date'));
            $req->whereDate('bagage.created_at', '<=' , session()->get('date'));

            $reqcolis->whereDate('colis.created_at', '>=' , session()->get('date'));
            $reqcolis->whereDate('colis.created_at', '<=' , session()->get('date'));
        }
        else
        {
            $req->whereDate('bagage.created_at', '>=' , date('Y-m-d'));
            $req->whereDate('bagage.created_at', '>=' , date('Y-m-d'));

            $reqcolis->whereDate('colis.created_at', '>=' , date('Y-m-d'));
            $reqcolis->whereDate('colis.created_at', '>=' , date('Y-m-d'));
        }
        $rapports = $req->get();
        $rapportcolis = $reqcolis->get();
        // dd($rapports);
        return view('chefdegare.rapport-journalier', compact('rapports','rapportcolis'));
    }

    public function search(REQUEST $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Retrieve the validated input...
        $validated = $validator->validated();
        return back()->with('date', $validated['date']);
    }

    public function apercu()
    {

        $reqBagage = DB::table('bagage')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereDate('created_at', date('Y-m-d'));

        $reqBagageMonth = DB::table('bagage')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereMonth('created_at', date('m'));

        $reqBagageYear = DB::table('bagage')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereYear('created_at', date('Y'));


        $reqBagageGroupByGare  = DB::table('bagage')
        ->join('gare', 'bagage.gare_id', 'gare.id')
        ->where('bagage.compagnie_id', Auth::user()->compagnie_id)
        ->whereDate('bagage.created_at', date('Y-m-d'));

        // dd($colisGroupByGare);

        $reqGares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id);
        $reqAgents = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id);


        if (Auth::user()->usertype == 'admin') {
            $bagage = $reqBagage->get();
            $bagageMonth = $reqBagageMonth->get();
            $bagageYear = $reqBagageYear->get();
            $bagageGroupByGare = $reqBagageGroupByGare->get();
            $gares = $reqGares->get();
            $agents = $reqAgents->get();
        }
        else {
            $bagage = $reqBagage->where('bagage.gare_id', Auth::user()->gare_id)->get();
            $bagageMonth = $reqBagageMonth->where('bagage.gare_id', Auth::user()->gare_id)->get();
            $bagageYear = $reqBagageYear->where('bagage.gare_id', Auth::user()->gare_id)->get();
            $bagageGroupByGare = $reqBagageGroupByGare->where('gare.id', Auth::user()->gare_id)->get();
            $gares = $reqGares->where('gare.id', Auth::user()->gare_id)->get();
            $agents = $reqAgents->where('users.gare_id', Auth::user()->gare_id)->get();
        }
        return view('chefdegare.vue-ensemble-bagage', compact('bagage', 'bagageMonth', 'bagageYear', 'bagageGroupByGare', 'gares', 'agents'));
    }




}
