<?php

namespace App\Http\Controllers\chefdegare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Auth;
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
        
        if (session()->has('date')) {
            $req->whereDate('bagage.created_at', '>=' , session()->get('date'));
            $req->whereDate('bagage.created_at', '<=' , session()->get('date'));
        }
        else
        {
            $req->whereDate('bagage.created_at', '>=' , date('Y-m-d'));
            $req->whereDate('bagage.created_at', '>=' , date('Y-m-d'));
        }
        $rapports = $req->get();
        // dd($rapports);
        return view('chefdegare.rapport-journalier', compact('rapports'));
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
}
