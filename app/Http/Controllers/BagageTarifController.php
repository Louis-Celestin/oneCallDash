<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BagageTarif;
use DB;
use Illuminate\Support\Facades\Validator;
use Auth;


class BagageTarifController extends Controller
{
    //
    public function index()
    {
        $tarifs = BagageTarif::where('compagnie_id', Auth::user()->compagnie_id)->get();

        $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();

        // dd($gares);
        return view('tarification-bagages', compact('tarifs', 'gares'));
    }

    public function store(REQUEST $request)
    {
        $validator = Validator::make($request->all(), [
            'gare_id' => 'required|string|max:255',
            'name_bagage' => 'required|string|max:255',
            'montant_bagage' => 'required|numeric|min:0',
            'taille' => 'sometimes',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();
        $validated['compagnie_id'] = Auth::user()->compagnie_id;

        if(BagageTarif::insert($validated))
        {
            return back()->withSuccess("Insertion réussi !");
        }

    }

    public function update(REQUEST $request)
    {
        $validator = Validator::make($request->all(), [
            'gare_id' => 'required|string|max:255',
            'id' => 'required|numeric',
            'name_bagage' => 'required|string|max:255',
            'montant_bagage' => 'required|numeric|min:0',
            'taille' => 'sometimes',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();
        $validated['compagnie_id'] = Auth::user()->compagnie_id;

        if(BagageTarif::where('id', $validated['id'])->where('compagnie_id', Auth::user()->compagnie_id)->update($validated))
        {
            return back()->withSuccess("Mise à jour réussi !");
        }

    }

    public function destroy(int $id)
    {
        $tarif = BagageTarif::where('id', $id)->where('compagnie_id', Auth::user()->compagnie_id)->first();
        if($tarif->delete())
        {
            return back()->withInfo("Suppression réussi !");
        }
    }
}
