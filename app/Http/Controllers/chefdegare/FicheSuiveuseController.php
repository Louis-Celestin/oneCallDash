<?php

namespace App\Http\Controllers\chefdegare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth, DB;


class FicheSuiveuseController extends Controller
{
    //
    public function index()
    {

        $departsHeureVille = DB::table('depart_ville_heure')->where('ville_depart', Auth::user()->gare_id)->get();
        
        $gare = DB::table('gare')->where('id', Auth::user()->gare_id)->first();

        $req = DB::table('bagage');

        if (session()->has('id')) {
            $req->join('depart_ville_heure', 'bagage.depart_id', 'depart_ville_heure.id')
            ->where('bagage.depart_id', session()->get('id'));

        }
        if(!session()->has('id') && session()->has('date')){
            $nom_depart = DB::table('depart_ville_heure')->where('id',122)->first();
        }
        
        if (session()->has('num_depart')) {
            
            $req->where('bagage.num_depart', session()->get('num_depart'));
        }
        
        if (session()->has('date')) {
            
            $req->whereDate('bagage.created_at', '>=', session()->get('date'))->whereDate('bagage.created_at', '<=', session()->get('date'));
        }

        $req->where('bagage.gare_id', Auth::user()->gare_id)->where('bagage.is_solded', 1)
        ->select('bagage.*', 'depart_ville_heure.heure_depart as heure_depart');

        if (session()->has('id') && session()->has('date')) {
            $liste = $req->get();
            $nom_depart = DB::table('depart_ville_heure')->where('id',session()->get('id'))->first();
        }
        else
        {
            $nom_depart = DB::table('depart_ville_heure')->where('id',122)->first();
            $req = DB::table('bagage')->join('depart_ville_heure', 'bagage.depart_id', 'depart_ville_heure.id')
            ->where('bagage.depart_id', 122)
            ->whereDate('bagage.created_at', '>=', date('Y-m-d'))->whereDate('bagage.created_at', '<=', date('Y-m-d'));
            $liste = $req->get();
        }

        return view('chefdegare.fiche-suiveuse', compact('liste', 'departsHeureVille', 'gare','nom_depart'));
    }
    public function search(REQUEST $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|string|max:255',
            'date' => 'required|date',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();

        return back()
        ->with('id', $validated['id'])
        ->with('date', $validated['date']);
        // $liste = DB::table('bagage')->join()
        // return view('fiche-suiveuse', compact('$liste'));
    }
}
