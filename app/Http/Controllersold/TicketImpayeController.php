<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB, Auth;

class TicketImpayeController extends Controller
{
    //
    function index()
    {
        // $req = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')
        // ->where('bagage.compagnie_id', Auth::user()->compagnie_id);
        // ->where('bagage.is_solded', 0);

        // Duplication pour utilisation differente
        // $req2 = $req; // Tres important sinon $impayesGroupByGare utilisera le champ reduit de $req;

        $impayes = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')
        ->where('bagage.compagnie_id', Auth::user()->compagnie_id)
        // ->where('bagage.is_solded', 0) // on fait le filtre grace au collection dans le blade
        ->orderBy('bagage.id', 'DESC')
        ->get();

        $impayesGroupByGare = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')
        ->where('bagage.compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 0)
        ->select('gare.nom_gare', DB::raw('count(bagage.id) as qte_client'), DB::raw('sum(nbr_de_bagage) as qte_bagage'), DB::raw('sum(prix) as prix_gare'))
        ->groupBy('gare.nom_gare')->get();
        
        return view('tickets-impayes', compact('impayes', 'impayesGroupByGare'));
    }

    function rapportFiltreSoldedIndex($is_solded, $is_fret)
    {
        $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();

        // dd($is_solded ."   " . $is_fret);

        $req = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')
        ->where('bagage.compagnie_id', Auth::user()->compagnie_id)
        ->where('bagage.is_solded', $is_solded)
        ->where('bagage.is_fret', $is_fret);

        $req2 = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')
        ->where('bagage.compagnie_id', Auth::user()->compagnie_id)
        ->where('bagage.is_solded', $is_solded)
        ->where('bagage.is_fret', $is_fret);
            
        if (session()->has('gare_id')) {
            $req->where('bagage.gare_id', session()->get('gare_id'));
            $req2->where('bagage.gare_id', session()->get('gare_id'));
        }
        if (session()->has('users_id')) {
            $req->where('bagage.users_id', session()->get('users_id'));
            $req2->where('bagage.users_id', session()->get('users_id'));
        }
        if (session()->has('start')) {
            $req->whereDate('bagage.created_at', '>=', session()->get('start'));
            $req2->whereDate('bagage.created_at', '>=', session()->get('start'));
        }
        else {
            $req->whereDate('bagage.created_at', '<=', date('Y-m-d'));
            $req2->whereDate('bagage.created_at', '<=', date('Y-m-d'));
        }
        if (session()->has('end')) {
            $req->whereDate('bagage.created_at', '<=', session()->get('end'));
            $req2->whereDate('bagage.created_at', '<=', session()->get('end'));
        }
        $req->select('bagage.*', 'gare.*', 'bagage.created_at as created_at');
        $req2->select('bagage.*', 'gare.*', 'bagage.created_at as created_at');


        $items = $req
        ->orderBy('bagage.id', 'DESC')
        ->get();
        
        $impayesGroupByGare = $req2
        ->select('gare.nom_gare', DB::raw('count(bagage.id) as qte_client'), DB::raw('sum(nbr_de_bagage) as qte_bagage'), DB::raw('sum(prix) as prix_gare'))
        ->groupBy('gare.nom_gare')->get();
        
        return view('rapport-filtre-solded', compact('items', 'impayesGroupByGare', 'is_solded', 'is_fret', 'gares'));
    }

    public function filtreImpayepart(REQUEST $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'start' => 'required|max:255',
            'end' => 'sometimes',
            'gare_id' => 'sometimes',
            'users_id' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Retrieve the validated input...
        $validated = $validator->validated();

        return back()
        ->withStart($validated['start'])
        ->withEnd($validated['end'] != null && $validated['end'] != $validated['start'] ? $validated['end'] : null)
        ->withGare_id($validated['gare_id'] != null && $validated['gare_id'] != '*' ? $validated['gare_id'] : null);
        // ->withUsers_id($validated['users_id'] != null && $validated['users_id'] != '*' ? $validated['users_id'] : null);
    }
}
