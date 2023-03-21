<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB, Auth;

class GareController extends Controller
{
    //
    public function getGares()
    {
        $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)
        ->where('is_checkpoint', false)
        ->get();
        $users = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();


        return view('gares-lists', compact('gares', 'users'));
    }   


    public function show(int $id)
    {
        $gare = DB::table('gare')->where('id', $id)->where('compagnie_id', Auth::user()->compagnie_id)
        ->where('is_checkpoint', false)
        ->first();
        $users = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();

        return view('edit-gare', compact('gare', 'users'));
    }


    public function update(REQUEST $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'id' => 'bail|required',
            'nom_gare' => 'required|max:255',
            'ville_gare' => 'required',
            'adresse' => 'sometimes',
            'users_id' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Retrieve the validated input...
        $validated = $validator->validated();

        // $validated['users_id'] is null when chefgare not selected
        // dd($validated['users_id']);
        if (DB::table('gare')->where('id', $validated['id'])->update($validated)) {
            # code...
            return redirect('/gares-lists')->withSuccess("La gare $request->nom_gare à été modifiée avec succèss !");
        }
    }
    
    public function showReports(int $id, $user_id, $debut, $fin)
    {
        if (Auth::user()->usertype == "admin" || ((Auth::user()->usertype == "chefgare") && Auth::user()->gare_id != null && $id == Auth::user()->gare_id)) {
            
            $gare = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', $id)->first();

            $req = DB::table('bagage')->where('compagnie_id', Auth::user()->compagnie_id)
            ->where('gare_id', $id)
            ->whereDate('created_at', '>=', $debut)
            ->whereDate('created_at', '<=', $fin);

            $req2 = DB::table('soldes')->where('compagnie_id', Auth::user()->compagnie_id)->where('gare_id', $id)
            ->where('statut', '!=', 'Solded')
            ->whereDate('created_at', '>=', $debut)
            ->whereDate('created_at', '<=', $fin);

            $req3 = DB::table('bagage')
            ->join('users', 'bagage.users_id', 'users.id')
            ->Leftjoin('remises', 'bagage.id', 'remises.bagage_id')
            ->select('users.name as userName', DB::raw('sum(prix) montant'), DB::raw('count(bagage.id) as qte_impression'), DB::raw('sum(bagage.nbr_de_bagage) as qte_bagages'), DB::raw('sum(remises.montant) as mt_remise'))
            ->where('bagage.compagnie_id', Auth::user()->compagnie_id)
            ->where('bagage.gare_id', $id)
            ->whereDate('bagage.created_at', '>=', $debut)
            ->whereDate('bagage.created_at', '<=', $fin);

            $req4 = DB::table('bagage')
            ->join('users', 'bagage.users_id', 'users.id')
            ->leftJoin('remises', 'bagage.id', 'remises.bagage_id')
            ->join('gare', 'bagage.gare_id', 'gare.id')
            ->where('bagage.gare_id', $id)
            ->where('bagage.compagnie_id', Auth::user()->compagnie_id)
            ->whereDate('bagage.created_at', '>=', $debut)
            ->whereDate('bagage.created_at', '<=', $fin);

            // dd($user_id);    
            if ($user_id != '*') {
                $req->where('users_id', $user_id);
                // $req2->where('users_id', $user_id); soldes n'a pas users_id
                $req3->where('bagage.users_id', $user_id);
                $req4->where('bagage.users_id', $user_id);
            }

            
            $bagages = $req->get();
            
            
            $soldes = $req2->get();
            
            
            $userReports = $req3->groupBy('userName')->get();
            // dd($userReports);


            $enrollements = $req4
            ->orderBy('bagage.id', 'DESC')
            ->select('*', 'bagage.created_at as created_at', 'bagage.id as id')
            ->get();



            $req5 = DB::table('bagage')->where('compagnie_id', Auth::user()->compagnie_id)->wheredate('created_at', date('Y-m-d'));
            $dayBagage = $req5->get(); 
            
            // get list id from bagage  with pluck of request
            $detailBagage = DB::table('detail_bagages')->wherein('bagage_id',$req5->pluck('id'))->get();

        }
        else
        {
            return back()->withError("Vous n'êtes pas autorisé à acceder à cette page ! Merci de consulter uniquement, les informations de votre gare.");
        }
        

        return view('gare-reports', compact('gare', 'bagages', 'soldes', 'userReports', 'enrollements', 'debut', 'fin', 'detailBagage','dayBagage'));
    }

    
    public function storeGare(REQUEST $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nom_gare' => 'required|max:255',
            // 'nom_gare' => 'required|unique:posts|max:255',
            'ville_gare' => 'required',
            'adresse' => 'sometimes',
            'users_id' => 'sometimes',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();
        $validated['compagnie_id'] = Auth::user()->compagnie_id;
        $validated['users_id'] =  $validated['users_id'] != null ? $validated['users_id'] : Auth::user()->compagnie_id;

        // $validated['users_id'] is null when chefgare not selected
        // dd($validated['users_id']);
        if (DB::table('gare')->insert($validated)) {
            # code...
            return back()->withSuccess("La gare $request->nom_gare à été ajoutée avec succèss !");
        }
    }
}
