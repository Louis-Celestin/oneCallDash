<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB,Auth;
use  App\Models\DepartVilleHeure;

class DepartController extends Controller
{
    //
    public function index()
    {
        if ((Auth::user()->usertype == "chefgare" || Auth::user()->usertype == "caissiere") && Auth::user()->gare_id != null) {

            $departs = DB::table('depart_ville_heure')->where('compagnie_id', Auth::user()->compagnie_id)->where('ville_depart', Auth::user()->gare_id)->get();
            $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', Auth::user()->gare_id)->get();
        }
        else
        {
            $departs = DB::table('depart_ville_heure')->where('compagnie_id', Auth::user()->compagnie_id)->get();
            $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();
        }

        return view('nos-departs', compact('departs', 'gares'));
    }

    public function store(REQUEST $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nom_depart' => 'required|string|max:255',
            'heure_depart' => 'sometimes|max:255',
            'ville_depart' => 'required|string',
            'ville_destination' => 'sometimes',
            'is_depart_fret' => 'sometimes',
        ]);
 
        // "depart_ville_heure" => "Départ 4"
        // "heure_depart" => "06:15"
        // "ville_depart" => "Adjamé AG"
        // "ville_destination" => "Marché de bouaké"

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();
        $validated['compagnie_id'] = Auth::user()->compagnie_id;

        if ((int)$validated['is_depart_fret'] == 1) {
            $validated['nom_depart'] .= " (FRET)";
        }

        if(DepartVilleHeure::insert($validated))
        {
            return back()->withSuccess("Insertion réussi !");
        }

    }

    // public function update(REQUEST $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'id' => 'required|numeric',
    //         'name_bagage' => 'required|string|max:255',
    //         'montant_bagage' => 'required|numeric|min:0',
    //         'taille' => 'sometimes',
    //     ]);
 
    //     if ($validator->fails()) {
    //         return back()->withErrors($validator)->withInput();
    //     }
 
    //     // Retrieve the validated input...
    //     $validated = $validator->validated();
    //     $validated['compagnie_id'] = Auth::user()->compagnie_id;

    //     if(BagageTarif::where('id', $validated['id'])->update($validated))
    //     {
    //         return back()->withSuccess("Insertion réussi !");
    //     }

    // }

    // public function destroy(int $id)
    // {
    //     $tarif = BagageTarif::where('id', $id)->first();
    //     if($tarif->delete())
    //     {
    //         return back()->withInfo("Suppression réussi !");
    //     }
    // }
}
