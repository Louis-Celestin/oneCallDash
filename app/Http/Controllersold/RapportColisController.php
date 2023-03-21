<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Auth;
use Illuminate\Support\Facades\Validator;

class RapportColisController extends Controller
{
    //
    public function index()
    {
        $colis = DB::table('colis')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereDate('created_at', date('Y-m-d'))->get();

        $colisMonth = DB::table('colis')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereMonth('created_at', date('m'))->get();

        $colisYear = DB::table('colis')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereYear('created_at', date('Y'))->get();


        $colisGroupByGare  = DB::table('colis')
        ->join('gare', 'colis.gare_id_envoi', 'gare.id')
        ->where('colis.compagnie_id', Auth::user()->compagnie_id)
        ->whereDate('colis.created_at', date('Y-m-d'))
        ->select(DB::raw('count(*) as qte_client'), DB::raw('sum(nbre_colis) as qte_colis'), 'gare.id as gare_id', DB::raw('sum(prix) as prix_gare'))->groupBy('gare_id')
        ->get();

        // dd($colisGroupByGare);

        $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();
        $agents = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();
        return view('rapport_colis', compact('colis', 'colisMonth', 'colisYear', 'colisGroupByGare', 'gares', 'agents'));
    }
    //

    public function apercu()
    {

        $reqColis = DB::table('colis')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereDate('created_at', date('Y-m-d'));

        $reqColisMonth = DB::table('colis')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereMonth('created_at', date('m'));

        $reqColisYear = DB::table('colis')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereYear('created_at', date('Y'));


        $reqColisGroupByGare  = DB::table('colis')
        ->join('gare', 'colis.gare_id_envoi', 'gare.id')
        ->where('colis.compagnie_id', Auth::user()->compagnie_id)
        ->whereDate('colis.created_at', date('Y-m-d'));

        // dd($colisGroupByGare);

        $reqGares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id);
        $reqAgents = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id);


        if (Auth::user()->usertype == 'admin') {
            $colis = $reqColis->get();
            $colisMonth = $reqColisMonth->get();
            $colisYear = $reqColisYear->get();
            $colisGroupByGare = $reqColisGroupByGare->select(DB::raw('count(*) as qte_client'), DB::raw('sum(nbre_colis) as qte_colis'), 'gare.id as gare_id', DB::raw('sum(prix) as prix_gare'))->groupBy('gare_id')->get();
            $gares = $reqGares->get();
            $agents = $reqAgents->get();
        }
        else {
            $colis = $reqColis->where('colis.gare_id_envoi', Auth::user()->gare_id)->get();
            $colisMonth = $reqColisMonth->where('colis.gare_id_envoi', Auth::user()->gare_id)->get();
            $colisYear = $reqColisYear->where('colis.gare_id_envoi', Auth::user()->gare_id)->get();
            $colisGroupByGare = $reqColisGroupByGare->where('gare.id', Auth::user()->gare_id)->select(DB::raw('count(*) as qte_client'), DB::raw('sum(nbre_colis) as qte_colis'), 'gare.id as gare_id', DB::raw('sum(prix) as prix_gare'))->groupBy('gare_id')->get();
            $gares = $reqGares->where('gare.id', Auth::user()->gare_id)->get();
            $agents = $reqAgents->where('users.gare_id', Auth::user()->gare_id)->get();
        }
        return view('colis.vue_ensemble_colis', compact('colis', 'colisMonth', 'colisYear', 'colisGroupByGare', 'gares', 'agents'));
    }



    public function details_colis(string $gare_id, string $statut, string $date)
    {
        if (Auth::user()->usertype == "admin") {
            $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();
            $agents = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();
        } else {
            $gares = DB::table('gare')->where('gare.id', Auth::user()->gare_id)->where('compagnie_id', Auth::user()->compagnie_id)->get();
            $agents = DB::table('users')->where('users.gare_id', Auth::user()->gare_id)->where('compagnie_id', Auth::user()->compagnie_id)->get();
        }
       

        $dates = explode("|", $date);

        if (count($dates) < 2) {
            $dates[1] = $dates[0];
        }

        $reqcolis = DB::table('colis')
        ->where('colis.compagnie_id', Auth::user()->compagnie_id);

        $reqcolis->whereDate('colis.created_at', '>=', $dates[0]);
        $reqcolis->whereDate('colis.created_at', '<=', $dates[1]);

        if (Auth::user()->usertype == "admin") {
            
            if ($gare_id != '*') {
                
                if ($gares->where('id', $gare_id)->first() !=null) {
                    $reqcolis->where('colis.gare_id_envoi', $gare_id);
                }
                else { //EVITER QUE LA COMPAGNIE ESSAIE DE VOIR LES AUTRES COLIS d'une autre compagnie
                    return abort(404, "Vous n'êtes pas autorisé!");
                }
            }
        }
        else
        {
            $reqcolis->where('colis.gare_id_envoi', Auth::user()->gare_id);
        }


        if ($statut != "all" && $statut != "*" && $statut != "All") {
            $reqcolis->where('colis.statut', $statut);
        }
        

        // switch ($statut) {
        //     case 'Waiting':
        //         $reqcolis->where('colis.statut', $statut);
        //         break;
        
        //     case 'Received':
        //         $reqcolis->where('colis.statut', $statut);
        //         break;
            
        //     case 'Delivered':
        //         $reqcolis->where('colis.statut', $statut);
        //         break;
                        
        //     default:
        //         // nothing
        //         break;
        // }

        
        
        $colis = $reqcolis->orderBy('id', 'DESC')->get();

        if (Auth::user()->usertype == "admin") {
            $colisMonth = DB::table('colis')
            ->where('colis.compagnie_id', Auth::user()->compagnie_id)
            ->whereMonth('colis.created_at', date('m'))->get();
    
            $colisYear = DB::table('colis')
            ->where('colis.compagnie_id', Auth::user()->compagnie_id)
            ->whereYear('colis.created_at', date('Y'))->get();
        } else {
            $colisMonth = DB::table('colis')
            ->where('colis.compagnie_id', Auth::user()->compagnie_id)
            ->where('colis.gare_id_envoi', Auth::user()->gare_id)
            ->whereMonth('colis.created_at', date('m'))->get();
    
            $colisYear = DB::table('colis')
            ->where('colis.compagnie_id', Auth::user()->compagnie_id)
            ->where('colis.gare_id_envoi', Auth::user()->gare_id)
            ->whereYear('colis.created_at', date('Y'))->get();
        }
        

        return view('colis.colis_activites', compact('gares', 'agents', 'colis', 'colisMonth', 'colisYear', 'dates'));
    }








    public function search(REQUEST $request)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required|string|max:255',
            'end' =>  'sometimes' /*'required|string|max:255', */,
            'gare_id' =>  'sometimes' /*'required|string|max:255', */,
            'users_id' =>  'sometimes' /*'required|string|max:255', */,
            'statut' =>  'sometimes' /*'required|string|max:255', */,
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Retrieve the validated input...
        $validated = $validator->validated();

        $validated['date'] = $validated['start'] == $validated['end'] ? $validated['end'] : $validated['start']."|". $validated['end'];
        
        // dd($validated);
        // return back()
        // ->withStart($validated['start'])
        // ->withEnd($validated['end'])
        // ->withGare_id($validated['gare_id'])
        // ->withUsers_id($validated['users_id'])
        // ->withStatut($validated['statut']);

        
        return redirect()->route('activites-colis', [
            'gare_id' => $validated['gare_id'],
            'statut' => $validated['statut'],
            'date' => $validated['date']
        ]);
    }


    
    public function commission_index()
    {
        return view('rapport-commission-colis', []);
    }

    public function colis_egare(){
        $colis_egare= DB::table('colis_egares')->where('compagnie_id',Auth::user()->compagnie_id)
        
       // ->orWhere(['gare_id_recu'=>Auth::user()->gare_id,'gare_id_envoi'=>Auth::user()->gare_id,'gare_id_qui_devait_recevoir'=>Auth::user()->gare_id])
        ->get();

        return view('chefdegare.colis-egare',compact('colis_egare')); 
    }
}
