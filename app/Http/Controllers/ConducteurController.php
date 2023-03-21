<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\Conducteur;

class ConducteurController extends Controller
{
    //
    public function index()
    {
        $conducteurs = Conducteur::where('compagnie_id', Auth::user()->compagnie_id)->get();


        return view('nos-conducteurs', compact('conducteurs'));
    }

    public function store(REQUEST $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nom_conducteur' => 'required|string|max:255',
            'prenom_conducteur' => 'sometimes',
            'tel_conducteur' => 'sometimes',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();
        $validated['compagnie_id'] = Auth::user()->compagnie_id;

        if (Auth::user()->usertype == "admin") {

            if(Conducteur::insert($validated))
            {
                return back()->withSuccess("Insertion réussi !");
            }
            else
            {
                return back()->withInfo("Insertion n'a pas été éffectué :/");
            }
        }
        else {
            return back()->withInfo("Vous n'êtes pas autorisé à apporter des changements.");
        }
        

    }

    public function update(REQUEST $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'nom_conducteur' => 'required|string|max:255',
            'prenom_conducteur' => 'sometimes',
            'tel_conducteur' => 'sometimes',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();
        $validated['compagnie_id'] = Auth::user()->compagnie_id;

        if (Auth::user()->usertype == "admin") {

            if(Conducteur::where('id', $validated['id'])->where('compagnie_id', Auth::user()->compagnie_id)->update($validated))
            {
                return back()->withSuccess("Mise à jour réussi !");
            }
        }
        else {
            return back()->withInfo("Vous n'êtes pas autorisé à apporter des changements.");
        }


        
    }

    public function destroy(int $id)
    {
        $vehicule = Conducteur::where('id', $id)->where('compagnie_id', Auth::user()->compagnie_id)->first();
        if (Auth::user()->usertype == "admin") {

            if($vehicule->delete())
            {
                return back()->withInfo("Suppression réussi !");
            }
        }
        else {
            return back()->withInfo("Vous n'êtes pas autorisé à supprimer des conducteurs.");
        }
        
    }
}
