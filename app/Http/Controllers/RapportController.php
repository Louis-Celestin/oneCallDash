<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB, Auth;

class RapportController extends Controller
{
    //
    public function index()
    {
        //dd(DB::table('bagage')->where(['compagnie_id'=>Auth::user()->compagnie_id,'is_solded'=>1])->whereDate('created_at','>=','2023-02-09')->whereDate('created_at','<=','2023-02-28')->sum('bagage.prix'));
        if ((Auth::user()->usertype == "chefgare" || Auth::user()->usertype == "caissiere") && Auth::user()->gare_id != null) {
            $users = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->where('gare_id', Auth::user()->gare_id)->get();
            $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', Auth::user()->gare_id)->get();

            $req = DB::table('bagage')
            ->join('gare', 'bagage.gare_id', 'gare.id')
            ->leftJoin('remises', 'bagage.id', 'remises.bagage_id')
            ->where('bagage.gare_id', Auth::user()->gare_id)
            ->where('gare.compagnie_id', Auth::user()->compagnie_id);

            $req2 = DB::table('bagage')->where('bagage.gare_id', Auth::user()->gare_id);
            $req3 = DB::table('bagage')->where('bagage.gare_id', Auth::user()->gare_id);
        }
        else
        {
            $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();
            $users = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();

            $req = DB::table('bagage')
            ->join('gare', 'bagage.gare_id', 'gare.id')
            ->leftJoin('remises', 'bagage.id', 'remises.bagage_id')
            ->where('gare.compagnie_id', Auth::user()->compagnie_id);


            $req2 = DB::table('bagage');
            $req3 = DB::table('bagage');
           
        }

        // dd($rapportGares);
        

        // if session 
        
        if (session()->has('gare_id')) {

            $req->where('bagage.gare_id', session()->get('gare_id'));
            $req2->where('bagage.gare_id',session()->get('gare_id'));
            $req3->where('bagage.gare_id',session()->get('gare_id'));
        }
        if (session()->has('users_id')) {
            $req->where('bagage.users_id', session()->get('users_id'));
            $req2->where('bagage.users_id',session()->get('users_id'));
            $req3->where('bagage.users_id',session()->get('users_id'));
        }

        if (session()->has('start')) {

            $req->whereDate('bagage.created_at', '>=', session()->get('start'));
            $req2->whereDate('bagage.created_at', '>=', session()->get('start'));
            $req3->whereDate('bagage.created_at', '>=', session()->get('start'));
        }
        else {

            $req->whereDate('bagage.created_at', '>=', date('Y-m-d'));
            $req2->whereDate('bagage.created_at', '>=', date('Y-m-d'));
            $req3->whereDate('bagage.created_at', '>=', date('Y-m-d'));
        }

        if (session()->has('end')) {

            $req->whereDate('bagage.created_at', '<=', session()->get('end'));
            $req2->whereDate('bagage.created_at', '<=', session()->get('end'));
            $req3->whereDate('bagage.created_at', '<=', session()->get('end'));
        }
        
        //dd( $req3);
        $rapportGares = $req->where('bagage.is_solded', 1)->select('gare.id as id', 'gare.nom_gare', DB::raw('count(bagage.id) as qte_impression'), DB::raw('sum(bagage.nbr_de_bagage) as qte_bagage'), DB::raw('sum(bagage.prix) as prix'), DB::raw('sum(remises.montant) as montant_remises'))->groupBy('gare.id', 'nom_gare')->get();
        $rapportType = $req2->where('bagage.is_solded', 1)->where('bagage.compagnie_id', Auth::user()->compagnie_id)->get();
        
       

        //dd($req3->where('bagage.is_solded', 1)->where('compagnie_id', Auth::user()->compagnie_id)->sum('prix'));
        $bagages = $req3->where('bagage.is_solded', 1)->where('bagage.compagnie_id', Auth::user()->compagnie_id)->get();

        $bagagesGroupedByCreatedAt = $req3->where('bagage.is_solded', 1)->where('bagage.compagnie_id', Auth::user()->compagnie_id)
        ->select( DB::raw('DATE(bagage.created_at) as date'), DB::raw('sum(nbr_de_bagage) as nbr_bagages'), DB::raw('count(id) as nbr_tickets'), DB::raw('sum(prix) as prix'))->groupBy('date')->get();

      //  dd($bagages->sum('prix'));
        // dd($rapportGares);
        // $users = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();

        return view('rapport', compact('rapportGares', 'users', 'gares', 'rapportType', 'bagages', 'bagagesGroupedByCreatedAt'));
    }


    // 
    public function filtre(REQUEST $request)
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

        return back()
        ->withStart($validated['start'])
        ->withEnd($validated['end'] != null ? $validated['end'] : null)
        ->withGare_id($validated['gare_id'] != null && $validated['gare_id'] != '*' ? $validated['gare_id'] : null)
        ->withUsers_id($validated['users_id'] != null && $validated['users_id'] != '*' ? $validated['users_id'] : null);
    }
}
