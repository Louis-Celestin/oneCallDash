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
       // ->where('compagnie_id', Auth::user()->compagnie_id)->whereDate('created_at', date('Y-m-d'));
        ->where('compagnie_id', Auth::user()->compagnie_id);

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
          //  $colis = $reqColis->where('colis.gare_id_envoi', Auth::user()->gare_id)->get();
            $colis = $reqColis->get();
            $colisMonth = $reqColisMonth->where('colis.gare_id_envoi', Auth::user()->gare_id)->get();
            $colisYear = $reqColisYear->where('colis.gare_id_envoi', Auth::user()->gare_id)->get();
            $colisGroupByGare = $reqColisGroupByGare->where('gare.id', Auth::user()->gare_id)->select(DB::raw('count(*) as qte_client'), DB::raw('sum(nbre_colis) as qte_colis'), 'gare.id as gare_id', DB::raw('sum(prix) as prix_gare'))->groupBy('gare_id')->get();
            $gares = $reqGares->where('gare.id', Auth::user()->gare_id)->get();
            $agents = $reqAgents->where('users.gare_id', Auth::user()->gare_id)->get();
        }

       // dd($colis);
        return view('colis.vue_ensemble_colis', compact('colis', 'colisMonth', 'colisYear', 'colisGroupByGare', 'gares', 'agents'));
    }




    public function details_colis(string $gare_id, string $statut, string $users_id, string $date,Request $request)
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
       // ->join('gare','colis.gare_id_envoi','gare.id')
        ->where('colis.compagnie_id', Auth::user()->compagnie_id);
       // dd($reqcolis->get()[0]);
        $reqcolisListe = DB::table('colis')
        ->join('gare','colis.gare_id_envoi','gare.id')
        ->where('colis.compagnie_id', Auth::user()->compagnie_id);
       
        if(  $statut== "all" or $statut == "*" or $statut == "All"){
           
            $reqcolis->whereDate('colis.created_at', '>=', $dates[0]);
            $reqcolis->whereDate('colis.created_at', '<=', $dates[1]);
            $reqcolisListe->whereDate('colis.created_at', '>=', $dates[0]);
            $reqcolisListe->whereDate('colis.created_at', '<=', $dates[1]);
            
        }
        if($statut=='Delivered' or $statut== "all" || $statut=='Waiting'|| $statut=='Received'){
            $reqcolis->whereDate('colis.updated_at', '>=', $dates[0]);
            $reqcolis->whereDate('colis.updated_at', '<=', $dates[1]);
            $reqcolisListe->whereDate('colis.updated_at', '>=', $dates[0]);
            $reqcolisListe->whereDate('colis.updated_at', '<=', $dates[1]);

        }
       
        if($users_id!='*'){
            $reqcolis->where('colis.users_id',$users_id);
            $reqcolisListe->where('colis.users_id',$users_id);
        }
        
        if (Auth::user()->usertype == "admin") {
            
            if ($gare_id != '*') {
                
                if ($gares->where('id', $gare_id)->first() !=null) {
                    $reqcolis->where('colis.gare_id_envoi', $gare_id);
                    $reqcolisListe->where('colis.gare_id_envoi', $gare_id);
                }
                else { //EVITER QUE LA COMPAGNIE ESSAIE DE VOIR LES AUTRES COLIS d'une autre compagnie
                    return abort(404, "Vous n'êtes pas autorisé!");
                }
            }
        }
        else
        {
            
            if($statut== "all" or $statut == "*" or $statut == "All")
            {$reqcolis->where('colis.gare_id_envoi', Auth::user()->gare_id);
                $reqcolisListe->where('colis.gare_id_envoi', Auth::user()->gare_id);
            }
           else
         {  
           
            $reqcolis->where('colis.gare_id_recu', Auth::user()->gare_id);
            $reqcolisListe->where('colis.gare_id_recu', Auth::user()->gare_id);}

          // dd($reqcolis);
        }

       
        if ($statut != "all" && $statut != "*" && $statut != "All") {
            
           
            $reqcolis->where('colis.statut', $statut);
            $reqcolisListe->where('colis.statut', $statut);
        }
        


        
        
       // $colis = $reqcolis->orderBy('id', 'DESC')->get();
       $colis = $reqcolis->get();

       $colisListe = $reqcolisListe
       ->select('gare.nom_gare as nom_gare' ,'gare.id as id_gare' ,DB::raw('DATE(colis.created_at) as date'), DB::raw('count(colis.id) as nbr_colis'), DB::raw('sum(prix) as prix'))->groupBy('date','nom_gare','id_gare')
       ->get();

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
        //dd($statut);
         switch ($statut) {
             case 'Waiting':
                $status='EN ATTENTE';
                 break;
        
             case 'Received':
                $status='RECEPTIONNÉ';
                 break;
            
             case 'Delivered':
                 $status='LIVRÉ';
                break;
                        
            default:
            $status='ENREGISTRÉ';
                 break;
         }
         
         
        return view('colis.colis_activites', compact('colisListe','gares', 'agents', 'colis', 'colisMonth', 'colisYear', 'dates','status','statut'));
    }

/*************************************** */

public function details_colis_gare(string $gare_id, string $statut,string $users_id, string $date)
    {
        $gare_id=$gare_id;
   //    dd($users_id);
        if (Auth::user()->usertype == "admin") {
            $gares = DB::table('gare')->where('gare.id', $gare_id)->where('compagnie_id', Auth::user()->compagnie_id)->get();
            $agents = DB::table('users')->where('users.gare_id', $gare_id)->where('compagnie_id', Auth::user()->compagnie_id)->get();
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
        if($statut=='Waiting'){
            $reqcolis->whereDate('colis.created_at', '>=', $dates[0]);
            $reqcolis->whereDate('colis.created_at', '<=', $dates[1]);
        }
        else{
            $reqcolis->whereDate('colis.updated_at', '>=', $dates[0]);
        $reqcolis->whereDate('colis.updated_at', '<=', $dates[1]);
        }

        if (Auth::user()->usertype == "admin") {
            
            if ($gare_id != '*') {
               
                if ($gares->where('id', $gare_id)->first() !=null) {
                    
                    if($statut=='Delivered')
                    $reqcolis->where('colis.gare_id_recu', $gare_id);
                    else
                    $reqcolis->where('colis.gare_id_envoi', $gare_id);
                }
                else { //EVITER QUE LA COMPAGNIE ESSAIE DE VOIR LES AUTRES COLIS d'une autre compagnie
                    return abort(404, "Vous n'êtes pas autorisé!");
                }
               
            }
        }
        else
        {
              
            if($statut== "all" or $statut == "*" or $statut == "All")
            {$reqcolis->where('colis.gare_id_envoi', Auth::user()->gare_id);
              
            }
           else
         {  
           
            $reqcolis->where('colis.gare_id_recu', Auth::user()->gare_id);
         }
        }
       

        if ($statut != "all" && $statut != "*" && $statut != "All") {
           // dd($reqcolis->get());
            $reqcolis->where('colis.statut', $statut);
           
        }

        
        if($users_id!='*'){
            $reqcolis->where('colis.users_id',$users_id);
           // $reqcolisListe->where('colis.users_id',$users_id);
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
            ->where('colis.gare_id_envoi', $gare_id)
            ->whereMonth('colis.created_at', date('m'))->get();
    
            $colisYear = DB::table('colis')
            ->where('colis.compagnie_id', Auth::user()->compagnie_id)
            ->where('colis.gare_id_envoi', $gare_id)
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
        switch ($statut) {
            case 'Waiting':
               $status='EN ATTENTE';
                break;
       
            case 'Received':
               $status='RECEPTIONNÉ';
                break;
           
            case 'Delivered':
                $status='LIVRÉ';
               break;
                       
           default:
           $status='ENREGISTRÉ';
                break;
        }

        return view('colis.detail_colis', compact('status','gares', 'agents', 'colis', 'colisMonth', 'colisYear', 'dates','gare_id'));
    }






/******************************************************************* */








    public function search(REQUEST $request)
    {
       // dd($request->all());
        $validator = Validator::make($request->all(), [
            'start' => 'required|string|max:255',
            'end' => 'sometimes' /*'required|string|max:255', */,
            'gare_id' => 'sometimes' /*'required|string|max:255', */,
            'users_id' => 'sometimes', /*'required|string|max:255', */
            'statut' => 'sometimes' /*'required|string|max:255', */
        ]);
       
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
       
        // Retrieve the validated input...
        $validated = $validator->validated();

        $validated['date'] = $validated['start'] == $validated['end'] ? $validated['end'] : $validated['start']."|". $validated['end'];
        
       
        if($validated['gare_id']==null)
        $validated['gare_id']='*';

       // dd($validated['date']);
        
        return redirect()->route('activites-colis', [
            'gare_id' => $validated['gare_id'],
            'statut' => $validated['statut'],
            'users_id' => $validated['users_id'],//new
            'date' => $validated['date']
        ]);
    }

    public function search_gare(REQUEST $request)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required|string|max:255',
            'end' => 'sometimes' /*'required|string|max:255', */,
            'gare_id' => 'sometimes' /*'required|string|max:255', */,
            'users_id' => 'sometimes' /*'required|string|max:255', */,
            'statut' => 'sometimes' /*'required|string|max:255', */,
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Retrieve the validated input...
        $validated = $validator->validated();

        $validated['date'] = $validated['start'] == $validated['end'] ? $validated['end'] : $validated['start']."|". $validated['end'];
        
       
//dd($validated['users_id']);
        
        return redirect()->route('activites-colis-gare', [
            'gare_id' => $validated['gare_id'],
            'statut' => $validated['statut'],
            'date' => $validated['date'],
            'users_id' =>  $validated['users_id']
        ]);
    }

    
    public function commission_index()
    {
        return view('rapport-commission-colis', []);
    }

    public function colis_egare($type=null){
       // dd($type);
        $req= DB::table('colis_egares')->where('compagnie_id',Auth::user()->compagnie_id);
        
        if($type=='Attente'){
            $req->Where(['gare_id_qui_devait_recevoir'=>Auth::user()->gare_id]);
            $titre='Liste des colis égaré en attente';
            $hiddenA='hidden';
            $hiddenE='';
            $hiddenR='';
        }
           
        if($type=='Emission'){
            $req->Where(['gare_id_envoi'=>Auth::user()->gare_id]);
            $titre='Liste des colis émis égaré ';
            $hiddenA='';
            $hiddenE='hidden';
            $hiddenR='';
        }
           
        if($type=='Receive')
        {
            $req->Where(['gare_id_recu'=>Auth::user()->gare_id]);
            $titre='Liste des colis recus égaré ';
            $hiddenA='';
            $hiddenE='';
            $hiddenR='hidden';
           
        }
           

        $colis_egare=$req->get();

        $data=['colis_egare'=>$colis_egare,
                'titre'=>$titre,
                'hiddenA'=>$hiddenA,
                'hiddenE'=>$hiddenE,
                'hiddenR'=>$hiddenR,
                'user'=>DB::table('users')->where('compagnie_id',Auth::user()->compagnie_id)->get(),
            ];

        return view('chefdegare.colis-egare', $data); 
    }
}
