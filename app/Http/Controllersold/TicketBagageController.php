<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bagage;
use App\Models\Solde;
use Illuminate\Support\Facades\Validator;
use DB, Auth;

class TicketBagageController extends Controller
{
    //
    public function index()
    {
        $bagages = DB::table('bagage')->where('compagnie_id', Auth::user()->compagnie_id)->where('is_solded', 1)->get();
        return view('lists-tickets', compact('bagages'));
    }


    function UpdateTicketBagage($id)
    {
        $bagage = Bagage::where('id', $id)->first();
        
        if($bagage == null)
        {
            return back()->withWarning("Ce bagage n'existe pas ou vous avez entrez un mauvais code.");
        }
        
        if($bagage->gare_id != Auth::user()->gare_id && Auth::user()->usertype != "admin")
        {
            return back()->withWarning("Vous ne pouvez pas confirmer le paiement dans une autre gare");
        }
        
        $montant = ($bagage->prix * 7/100); // is now double


        DB::table('commission_par_ligne_module')->insert([
            'id_de_reference_module' => $bagage->id,
            'compagnie_id' => $bagage->compagnie_id,
            'gare_id' => $bagage->gare_id,
            'module_id' => 1,
            'user_id' => $bagage->users_id,
            'montant_bagage' => $bagage->prix,
            'montant_commission' => $montant,
        ]);

        if ($bagage->update(['is_solded' => 1])) {

            // On applique la commission de 7%
            $soldeToDay = Solde::whereDate('created_at', date('Y-m-d'))
                            ->where('compagnie_id', $bagage->compagnie_id)
                            ->where('module_id', 1)
                            ->where('gare_id', $bagage->gare_id)->first();
                
            if($soldeToDay != null) {
                Solde::whereDate('created_at',date('Y-m-d'))
                ->where('compagnie_id', $bagage->compagnie_id)
                ->where("module_id", 1)
                ->where('gare_id', $bagage->gare_id)
                ->update([
                    "montant" => DB::raw('montant+'.$montant), 
                ]);
                }else{
                $soldeBag = Solde::create([
                    "compagnie_id" => $bagage->compagnie_id,
                    "module_id" => 1,
                    "gare_id" =>  $bagage->gare_id,
                    "montant"=> $montant,
                    "statut" => "Unsolded"
                    ]);
            }
            return redirect('informations-bagage-payes')->withRef($bagage->ref);
        }
        else
        {
            return back()->withWarning("Le mise à jour n'a pas été éffectué veuillez re-éssayer");
        }

    }

    function InfoBagage()
    {
        if(session()->has("ref"))
        {
            $bagage = DB::table('bagage')->where('ref', session()->get("ref"))->first();
        }
        elseif(session()->has("bagage"))
        {
            $bagage = session()->get("bagage");
        }
        else
        {
            $bagage = null;
        }

        return view('chefdegare.info-bagage', compact('bagage'));
    }

    function SearchBagage(REQUEST $request)
    {
        $validator = Validator::make($request->all(), [
            'ref' => 'required',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();


        
        $bagage = Bagage::where('ref', $validated['ref'])->first();
        if($bagage == null)
        {
            return back()->withWarning("Ce bagage n'existe pas ou vous avez entrez un mauvais code.");
        }
        
        if($bagage->gare_id != Auth::user()->gare_id && Auth::user()->usertype != "admin")
        {
            return back()->withWarning("Vous ne pouvez pas confirmer le paiement dans une autre gare");
        }

        return back()->withBagage($bagage);
    }

    public function BagageImpayes(Request $request)
    {
       // dd(empty($request->start));

        $req=Bagage::where('is_solded', 0)
                    ->where('compagnie_id',Auth::user()->compagnie_id)
                    ->where('gare_id',Auth::user()->gare_id);
        if(!empty($request->start))
            $req->where('created_at', '>=',$request->start);
        if(!empty($request->end))
            $req->where('created_at', '<=',$request->end);
        if(empty($request->start) and empty($request->end))
            $req->where('created_at', '>=',date('Y-m-d'));
        
            $Bagage= $req->get();

        return view('chefdegare.ticket-impaye',compact('Bagage'));
    }
}
