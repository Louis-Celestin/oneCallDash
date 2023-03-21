<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;


class EnrollementController extends Controller
{
    //
    public function index()
    {

        if ((Auth::user()->usertype == "chefgare" || Auth::user()->usertype == "caissiere") && Auth::user()->gare_id != null) {

            $enrollements = DB::table('module_enrollements')->join('gare', 'module_enrollements.id_gare', 'gare.id')
            ->where('module_enrollements.id_compagnie', Auth::user()->compagnie_id)->where('module_enrollements.id_gare', Auth::user()->gare_id)->get();

            $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', Auth::user()->gare_id)->get();
        }
        else
        {
            $enrollements = DB::table('module_enrollements')->join('gare', 'module_enrollements.id_gare', 'gare.id')
            ->where('module_enrollements.id_compagnie', Auth::user()->compagnie_id)->get();

            $gares = DB::table('gare')->where('gare.compagnie_id', Auth::user()->compagnie_id)->get();
        }
        return view('subscribe', compact('enrollements', 'gares'));
    }


    // ENROLLER UNE GARE 
    public function store(REQUEST $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'id_gare' => 'required|string|max:255',
            'id_module' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Retrieve the validated input...
        $validated = $validator->validated();
        $validated['type_offre'] = 0;
        $validated['created_at'] = \Carbon\carbon::now();
        $validated['updated_at'] = Carbon::now();
        $validated['id_compagnie'] = Auth::user()->compagnie_id;
        
        // dd($validated);

        $gare = DB::table('gare')->where('id', $validated['id_gare'])->first();
        $exist = DB::table('module_enrollements')->where('id_gare', $gare->id)->first();

        if ($exist != null) {
            return back()->withWarning('l\'Opération a échouée car la gare '.$gare->nom_gare. ' est déjà abonnée.');
        }
        $enrollements = DB::table('module_enrollements')->insert($validated);
        
        return back()->withSuccess("Opération réussi ! les agents de la gare " . $gare->nom_gare ." peuvent desormais utilisé l'application.");
    }
}
