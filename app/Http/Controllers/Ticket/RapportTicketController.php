<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
class RapportTicketController extends Controller
{
    //
    public function index()
    {
        $req =  DB::table('bagage')->join('depart_ville_heure', 'bagage.depart_id', 'depart_ville_heure.id')
        ->where('bagage.compagnie_id', Auth::user()->compagnie_id)
        ->where('bagage.is_solded', 1)
        ->where('bagage.gare_id', Auth::user()->gare_id)
        ->select('depart_ville_heure.nom_depart', 'depart_ville_heure.heure_depart', DB::raw('count(bagage.id) as qte_client'), DB::raw('sum(nbr_de_bagage) as qte_bagage'), DB::raw('sum(prix) as prix_depart'))
        ->groupBy('depart_ville_heure.nom_depart', 'depart_ville_heure.heure_depart');
        
        $reqcolis=DB::table('colis')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', Auth::user()->gare_id);


        if (session()->has('date')) {

            $req->whereDate('bagage.created_at', '>=' , session()->get('date'));
            $req->whereDate('bagage.created_at', '<=' , session()->get('date'));

            $reqcolis->whereDate('colis.created_at', '>=' , session()->get('date'));
            $reqcolis->whereDate('colis.created_at', '<=' , session()->get('date'));
        }
        else
        {
            $req->whereDate('bagage.created_at', '>=' , date('Y-m-d'));
            $req->whereDate('bagage.created_at', '>=' , date('Y-m-d'));

            $reqcolis->whereDate('colis.created_at', '>=' , date('Y-m-d'));
            $reqcolis->whereDate('colis.created_at', '>=' , date('Y-m-d'));
        }
        $rapports = $req->get();
        $rapportcolis = $reqcolis->get();
        // dd($rapports);
        return view('chefdegare.rapport-journalier', compact('rapports','rapportcolis'));
    }

    public function search(REQUEST $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'sometimes',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();
        return back()->with('date', $validated['date']);
    }

    public function apercu()
    {

        $reqTicket = DB::table('ticket')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereDate('created_at', date('Y-m-d'));

        $reqTicketMonth = DB::table('ticket')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereMonth('created_at', date('m'));

        $reqTicketYear = DB::table('ticket')
        ->where('compagnie_id', Auth::user()->compagnie_id)->whereYear('created_at', date('Y'));


        $reqTicketGroupByGare  = DB::table('ticket')
        ->join('gare', 'ticket.gare_id', 'gare.id')
        ->where('ticket.compagnie_id', Auth::user()->compagnie_id)
        ->whereDate('ticket.created_at', date('Y-m-d'));

        // dd($colisGroupByGare);

        $reqGares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id);
        $reqAgents = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id);


        if (Auth::user()->usertype == 'admin') {
            $ticket = $reqTicket->get();
            $ticketMonth = $reqTicketMonth->get();
            $ticketYear = $reqTicketYear->get();
            $ticketGroupByGare = $reqTicketGroupByGare->select(DB::raw('count(*) as qte_client'), DB::raw('sum(ticket.nbre_tickets) as qte_ticket'), 'gare.id as gare_id', DB::raw('sum(prix) as prix_ticket'))->groupBy('gare_id')->get();
            $gares = $reqGares->get();
            $agents = $reqAgents->get();
        }
        else {
            $ticket = $reqTicket->where('ticket.gare_id', Auth::user()->gare_id)->get();
            $ticketMonth = $reqTicketMonth->where('ticket.gare_id', Auth::user()->gare_id)->get();
            $ticketYear = $reqTicketYear->where('ticket.gare_id', Auth::user()->gare_id)->get();
            $ticketGroupByGare = $reqTicketGroupByGare->where('gare.id', Auth::user()->gare_id)->select(DB::raw('count(*) as qte_client'), DB::raw('sum(ticket.nbre_tickets) as qte_ticket'), 'gare.id as gare_id', DB::raw('sum(prix) as prix_ticket'))->groupBy('gare_id')->get();
            $gares = $reqGares->where('gare.id', Auth::user()->gare_id)->get();
            $agents = $reqAgents->where('users.gare_id', Auth::user()->gare_id)->get();
        }
        return view('ticket.vue_ensemble_ticket', compact('ticket', 'ticketMonth', 'ticketYear', 'ticketGroupByGare', 'gares', 'agents'));
    }


    public function rapport_ticket()
    {
        if ((Auth::user()->usertype == "chefgare" || Auth::user()->usertype == "caissiere") && Auth::user()->gare_id != null) {
            $users = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->where('gare_id', Auth::user()->gare_id)->get();
            $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', Auth::user()->gare_id)->get();

            $req = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
           // ->leftJoin('remises', 'bagage.id', 'remises.bagage_id')
            ->where('ticket.gare_id', Auth::user()->gare_id)
            ->where('gare.compagnie_id', Auth::user()->compagnie_id);

            $req2 = DB::table('ticket')->where('ticket.gare_id', Auth::user()->gare_id);
            $req3 = DB::table('ticket')->where('ticket.gare_id', Auth::user()->gare_id);
        }
        else
        {
            $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();
            $users = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();

            $req = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
           // ->leftJoin('remises', 'bagage.id', 'remises.bagage_id')
            ->where('gare.compagnie_id', Auth::user()->compagnie_id);


            $req2 = DB::table('ticket');
            $req3 = DB::table('ticket');
        }

        // dd($rapportGares);
        

        // if session 
        
        if (session()->has('gare_id')) {

            $req->where('ticket.gare_id', session()->get('gare_id'));
            $req2->where('ticket.gare_id',session()->get('gare_id'));
            $req3->where('ticket.gare_id',session()->get('gare_id'));
            session(['gare_id' => session()->get('gare_id')]);
        }
        if (session()->has('users_id')) {
            $req->where('ticket.users_id', session()->get('users_id'));
            $req2->where('ticket.users_id',session()->get('users_id'));
            $req3->where('ticket.users_id',session()->get('users_id'));
            session(['users_id' => session()->get('users_id')]);
        }

        if (session()->has('start')) {

            $req->whereDate('ticket.created_at', '>=', session()->get('start'));
            $req2->whereDate('ticket.created_at', '>=', session()->get('start'));
            $req3->whereDate('ticket.created_at', '>=', session()->get('start'));
            session(['start' => session()->get('start')]);
        }
        else {

            $req->whereDate('ticket.created_at', '>=', date('Y-m-d'));
            $req2->whereDate('ticket.created_at', '>=', date('Y-m-d'));
            $req3->whereDate('ticket.created_at', '>=', date('Y-m-d'));
            session(['start' => date('Y-m-d')]);
            session(['end' => date('Y-m-d')]);
        }

        if (session()->has('end')) {

            $req->whereDate('ticket.created_at', '<=', session()->get('end'));
            $req2->whereDate('ticket.created_at', '<=', session()->get('end'));
            $req3->whereDate('ticket.created_at', '<=', session()->get('end'));
            session(['end' => session()->get('end')]);
        }
        

        $rapportGares = $req->select('gare.id as id', 'gare.nom_gare', DB::raw('count(ticket.id) as qte_impression'), DB::raw('sum(ticket.nbre_tickets) as qte_ticket'), DB::raw('sum(ticket.prix) as prix'))->groupBy('gare.id', 'nom_gare')->get();
        $rapportType = $req2->where('ticket.compagnie_id', Auth::user()->compagnie_id)->get();
        
        $tickets = $req3->where('ticket.compagnie_id', Auth::user()->compagnie_id)->get();

        $ticketsGroupedByCreatedAt = $req3->where('ticket.compagnie_id', Auth::user()->compagnie_id)
        ->select( DB::raw('DATE(ticket.created_at) as date'), DB::raw('sum(nbre_tickets) as nbr_ticket'), DB::raw('count(id) as nbr_tickets'), DB::raw('sum(prix) as prix'))->groupBy('date')->get();
       
        session(['ticketsGroupedByCreatedAt' => $ticketsGroupedByCreatedAt]);
        session(['tickets' => $tickets]);
        return view('ticket.rapport', compact('rapportGares', 'users', 'gares', 'rapportType', 'tickets', 'ticketsGroupedByCreatedAt'));
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

  

    public function rapport_ticket_mensuel(Request $request)
    {

        if ((Auth::user()->usertype == "chefgare" || Auth::user()->usertype == "caissiere") && Auth::user()->gare_id != null) {
            $users = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->where('gare_id', Auth::user()->gare_id)->get();
            $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', Auth::user()->gare_id)->get();

            $req = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
           // ->leftJoin('remises', 'bagage.id', 'remises.bagage_id')
            ->where('ticket.gare_id', Auth::user()->gare_id)
            ->where('gare.compagnie_id', Auth::user()->compagnie_id);

            $req2 = DB::table('ticket')->where('ticket.gare_id', Auth::user()->gare_id);
            $req3 = DB::table('ticket')->where('ticket.gare_id', Auth::user()->gare_id);
        }
        else
        {
            $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();
            $users = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();

            $req = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
           // ->leftJoin('remises', 'bagage.id', 'remises.bagage_id')
            ->where('gare.compagnie_id', Auth::user()->compagnie_id);


            $req2 = DB::table('ticket');
            $req3 = DB::table('ticket');
        }
        
       //  dd('$rapportGares');
   /*           $reqtest =   DB::table('ticket')
          //  ->select(DB::raw('YEAR(created_at) AS annee, MONTH(created_at) AS mois'),DB::raw('DATE(ticket.created_at) as date'), DB::raw('sum(nbre_tickets) as nbr_ticket'), DB::raw('count(id) as nbr_tickets'), DB::raw('sum(prix) as prix'))
          ->select(DB::raw('YEAR(created_at) AS annee,MONTH(created_at) AS mois'),DB::raw('sum(nbre_tickets) as nbr_ticket'), DB::raw('count(id) as nbr_tickets'), DB::raw('sum(prix) as prix'))->groupBy('mois','annee') 
          ->whereBetween('created_at', ['2022-01-01', '2022-12-31'])
           // ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)','date'))
            ->get();
*/
            // Récupérer le premier jour du mois courant au format 'Y-m-d'
            $firstDayOfMonth = Carbon::now()->firstOfMonth()->format('Y-m-d');

            // Récupérer le dernier jour du mois courant au format 'Y-m-d'
            $lastDayOfMonth = Carbon::now()->lastOfMonth()->format('Y-m-d');
            //dd($lastDayOfMonth);
        // if session 
      //  dd(!empty($request->gare_id));
        if (!empty($request->gare_id) /*and session()->has('gare_id')*/) {

            $req->where('ticket.gare_id', session()->get('gare_id'));
            $req2->where('ticket.gare_id',session()->get('gare_id'));
            $req3->where('ticket.gare_id',session()->get('gare_id'));
            session(['gare_id' => session()->get('gare_id')]);
        }
        if (!empty($request->users_id) /*session()->has('users_id')*/) {
            $req->where('ticket.users_id', session()->get('users_id'));
            $req2->where('ticket.users_id',session()->get('users_id'));
            
            $req3->where('ticket.users_id',session()->get('users_id'));
            session(['users_id' => session()->get('users_id')]);
        }

        if (!empty($request->start)  /*session()->has('start')*/) {

            $req->whereDate('ticket.created_at', '>=', session()->get('start'));
            $req2->whereDate('ticket.created_at', '>=', session()->get('start'));
          //  $req3->whereDate('ticket.created_at', '>=', session()->get('start'));
            session(['start' => session()->get('start')]);
        }
        else {

            $req->whereDate('ticket.created_at', '>=', date('Y-m-d'));
            $req2->whereDate('ticket.created_at', '>=', date('Y-m-d'));
            $req3->whereBetween('created_at', [$firstDayOfMonth , $lastDayOfMonth]);
           // $req3->whereDate('ticket.created_at', '>=', date('Y-m-d'));
            session(['start' => date('Y-m-d')]);
            session(['end' => date('Y-m-d')]);
        }

        if (!empty($request->end) /*session()->has('end')*/) {

            $req->whereDate('ticket.created_at', '<=', session()->get('end'));
            $req2->whereDate('ticket.created_at', '<=', session()->get('end'));
         //   $req3->whereDate('ticket.created_at', '<=', session()->get('end'));
            session(['end' => session()->get('end')]);
        }
        
        if(session()->has('end') and session()->has('start'))
        {
           // dd('sb');
            $req3->whereBetween('created_at', [session()->has('start'), session()->has('end') ]);
            session(['start' => session()->has('start')]);
            session(['end' => session()->has('end') ]);
        }

        $rapportGares = $req->select('gare.id as id', 'gare.nom_gare', DB::raw('count(ticket.id) as qte_impression'), DB::raw('sum(ticket.nbre_tickets) as qte_ticket'), DB::raw('sum(ticket.prix) as prix'))->groupBy('gare.id', 'nom_gare')->get();
        $rapportType = $req2->where('ticket.compagnie_id', Auth::user()->compagnie_id)->get();
        
        $tickets = $req3->where('ticket.compagnie_id', Auth::user()->compagnie_id)->get();

        $ticketsGroupedByCreatedAt = $req3->where('ticket.compagnie_id', Auth::user()->compagnie_id)
        ->select(DB::raw('YEAR(created_at) AS annee,MONTH(created_at) AS mois'),DB::raw('sum(nbre_tickets) as nbr_ticket'), DB::raw('count(id) as nbr_tickets'), DB::raw('sum(prix) as prix'))->groupBy('mois','annee') ->get();
    //   dd( $ticketsGroupedByCreatedAt);
   
        session(['ticketsGroupedByCreatedAt' => $ticketsGroupedByCreatedAt]);
        session(['tickets' => $tickets]);
        return view('ticket.rapport', compact('rapportGares', 'users', 'gares', 'rapportType', 'tickets', 'ticketsGroupedByCreatedAt'));
   


 
       }



}
