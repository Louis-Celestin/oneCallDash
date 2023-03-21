<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remise;
use Illuminate\Support\Facades\Validator;
use Auth, DB;

class RemiseController extends Controller
{
    //
    public function index()
    {
        $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();
        $users = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();


        $remises = session()->has('remises') ? session()->get('remises') : DB::table('remises')
        ->join('bagage', 'remises.bagage_id', 'bagage.id')
        ->join('users', 'remises.agent_id', 'users.id')
        ->join('gare', 'remises.gare_id', 'gare.id')
        ->whereDate('remises.created_at', date('Y-m-d'))
        ->where('remises.compagnie_id', Auth::user()->compagnie_id)
        ->select('bagage.*', 'users.*', 'gare.*', 'remises.*', 'bagage.id as id', 'remises.montant as montant_remises')->orderBy('bagage.id', 'DESC')->get();

        $remisesParAgent = session()->has('remisesParAgent') ? session()->get('remisesParAgent') : DB::table('remises')
        ->join('bagage', 'remises.bagage_id', 'bagage.id')
        ->join('users', 'remises.agent_id', 'users.id')
        ->join('gare', 'remises.gare_id', 'gare.id')
        ->whereDate('remises.created_at', date('Y-m-d'))
        ->where('remises.compagnie_id', Auth::user()->compagnie_id)
        ->select(DB::raw('sum(bagage.nbr_de_bagage) as qte'), 'users.id',  DB::raw('sum(remises.montant) as montant_remises'))->groupBY('users.id')->orderBy('montant_remises', 'DESC')->get();
        
        // dd($remisesParAgent);
        // dd($remises);
        $jour =  DB::table('bagage')->join('remises', 'bagage.id', 'remises.bagage_id')->where('remises.compagnie_id', Auth::user()->compagnie_id)
        ->whereDate('remises.created_at', date('Y-m-d'))
        ->select('bagage.*','remises.*', 'bagage.id as id', 'remises.montant as montant_remises')->orderBy('bagage.id', 'DESC')->get();

        $mois =  DB::table('bagage')->join('remises', 'bagage.id', 'remises.bagage_id')->where('remises.compagnie_id', Auth::user()->compagnie_id)
        ->whereMonth('remises.created_at', date('m'))
        ->select('bagage.*','remises.*', 'bagage.id as id', 'remises.montant as montant_remises')->orderBy('bagage.id', 'DESC')->get();

        $year =  DB::table('bagage')->join('remises', 'bagage.id', 'remises.bagage_id')->where('remises.compagnie_id', Auth::user()->compagnie_id)
        ->whereYear('remises.created_at', date('Y'))
        ->select('bagage.*','remises.*', 'bagage.id as id', 'remises.montant as montant_remises')->orderBy('bagage.id', 'DESC') ->get();

        $detailBagage = DB::table('detail_bagages')
        ->join('remises', 'detail_bagages.bagage_id', 'remises.bagage_id')->get();

        return view('remises', compact('remises', 'detailBagage', 'gares', 'users', 'jour', 'mois', 'year', 'remisesParAgent'));
    }

    function filtre(REQUEST $request)
    {
        

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


        $req = DB::table('remises')
        ->join('bagage', 'remises.bagage_id', 'bagage.id')
        ->join('users', 'remises.agent_id', 'users.id')
        ->join('gare', 'remises.gare_id', 'gare.id')
        ->where('remises.compagnie_id', Auth::user()->compagnie_id);

        $req2 = DB::table('remises')
        ->join('bagage', 'remises.bagage_id', 'bagage.id')
        ->join('users', 'remises.agent_id', 'users.id')
        ->join('gare', 'remises.gare_id', 'gare.id')->where('remises.compagnie_id', Auth::user()->compagnie_id);




        if ($validated['start'] != null) {

            $req->whereDate('remises.created_at', '>=', $validated['start']);
            $req2->whereDate('remises.created_at', '>=', $validated['start']);
            
        }
        else {

            $req->whereDate('remises.created_at', '>=', date('Y-m-d'));
            $req2->whereDate('remises.created_at', '>=', date('Y-m-d'));
        }

        if ($validated['end'] != null) {

            $req->whereDate('remises.created_at', '<=', $validated['end']);
            $req2->whereDate('remises.created_at', '<=', $validated['end']);
        }
        
        // Tri from gare
        if ($validated['gare_id'] != null && $validated['gare_id'] != '*') {

            $req->where('remises.gare_id', $validated['gare_id']);
            $req2->where('remises.gare_id', $validated['gare_id']);
        }
        
        // Tri user
        if ($validated['users_id'] != null && $validated['users_id'] != '*') {

            $req->where('bagage.users_id', $validated['users_id']);
            $req2->where('bagage.users_id', $validated['users_id']);
        }

        $remises = $req->select('bagage.*', 'users.*', 'gare.*', 'remises.*', 'bagage.id as id', 'remises.montant as montant_remises')->orderBy('bagage.id', 'DESC')->get();
        $remisesParAgent = $req2->select(DB::raw('sum(bagage.nbr_de_bagage) as qte'), 'users.id',  DB::raw('sum(remises.montant) as montant_remises'))->groupBY('users.id')->orderBy('montant_remises', 'DESC')->get();




        // dd($remises);
        return back()->withRemises($remises)->with('remisesParAgent',$remisesParAgent)
        ->withStart($validated['start'])
        ->withEnd($validated['end'] != null  ? $validated['end'] : null)
        ->withGare_id($validated['gare_id'] != null && $validated['gare_id'] != '*' ? $validated['gare_id'] : null)
        ->withUsers_id($validated['users_id'] != null && $validated['users_id'] != '*' ? $validated['users_id'] : null);
    }
}
