<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\Vehicule;

class VehiculeController extends Controller
{
    //
    public function index()
    {
        $vehicules = DB::table('vehicule')->where('compagnie_id', Auth::user()->compagnie_id)->get();


        return view('nos-vehicules', compact('vehicules'));
    }

    public function store(REQUEST $request)
    {
        
        $validator = Validator::make($request->all(), [
            'nom_vehicule' => 'required|string|max:255',
            'numero_vehicule' => 'required|string',
            'nbre_de_place' => 'required|numeric|min:2',
            'type_de_vehicule' => 'sometimes',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();
        $validated['compagnie_id'] = Auth::user()->compagnie_id;

        if(DB::table('vehicule')->insert($validated))
        {
            return back()->withSuccess("Insertion réussi !");
        }
        else
        {
            return back()->withInfo("Insertion n'a pas été éffectué :/");
        }

    }

    public function update(REQUEST $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'nom_vehicule' => 'required|string|max:255',
            'numero_vehicule' => 'required|string',
            'nbre_de_place' => 'required|numeric|min:2',
            'type_de_vehicule' => 'sometimes',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();
        $validated['compagnie_id'] = Auth::user()->compagnie_id;

        if(Vehicule::where('id', $validated['id'])->where('compagnie_id', Auth::user()->compagnie_id)->update($validated))
        {
            return back()->withSuccess("Mise à jour réussi !");
        }

    }

    public function destroy(int $id)
    {
        $vehicule = Vehicule::where('id', $id)->where('compagnie_id', Auth::user()->compagnie_id)->first();
        if($vehicule->delete())
        {
            return back()->withInfo("Suppression réussi !");
        }
    }
}
