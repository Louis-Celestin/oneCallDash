<?php

namespace App\Http\Controllers\statistique;

use App\Http\Controllers\Controller;
use App\Models\BagageTarif;
use App\Models\User;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class generalController extends Controller
{
    public function Stat_general(Request $request)
    {

        $req = DB::table('bagage')
            ->join('gare', 'bagage.gare_id', 'gare.id')
            ->join('users', 'bagage.users_id', 'users.id')
            ->leftJoin('remises', 'bagage.id', 'remises.bagage_id')
            //  ->where('bagage.gare_id', Auth::user()->gare_id)
            ->where('gare.compagnie_id', Auth::user()->compagnie_id);

        //  dd($request->gare_id == '');
        if (!empty($request->start)) {
            $req->where('bagage.created_at', '>=', $request->start);
            session(['start' => $request->start]);
        }
        if (!empty($request->end)) {
            $req->where('bagage.created_at', '<=', $request->end);
            session(['end' => $request->end]);
        }
        if (empty($request->start) && empty($request->end)) {
            $req->whereDate('bagage.created_at', '>=', date('Y-m-d'));
            session(['start' => date('Y-m-d')]);
            session(['end' => date('Y-m-d')]);
        }
        if (!empty($request->users_id)) {
            //  dd($request->users_id);
            $req->where('bagage.users_id', $request->users_id);
            $nomuser  = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', $request->users_id)->get('name');
            session(['nomuser' => $nomuser[0]->name]);
        }
        if (empty($request->users_id)) {
            //  dd($request->users_id);

            session(['nomuser' => 'Tous les agents']);
        }

        if (!empty($request->gare_id)) {
            // dd( $request->gare_id);
            $req->where('bagage.gare_id', $request->gare_id);
            $nomgare  = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', $request->gare_id)->get('nom_gare');
            session(['nomgare' => $nomgare[0]->nom_gare]);
        }
        if (empty($request->gare_id)) {
            session(['nomgare' => 'Toutes les gares']);
        }
        if (!empty($request->bagage_id)) {
            // dd($request->bagage_id);
            $req->where('bagage.type_bagage', 'like', '%' .  $request->bagage_id . '%');
            session(['type_bagage' => $request->bagage_id]);
        }
        if (empty($request->bagage_id)) {
            session(['type_bagage' => 'Tous les types de bagage']);
        }



        $rapportGares = $req->where('bagage.is_solded', 1)->select('gare.id as id', 'gare.nom_gare', 'users.name', 'bagage.type_bagage', DB::raw('count(bagage.id) as qte_impression'), DB::raw('sum(bagage.nbr_de_bagage) as qte_bagage'), DB::raw('sum(bagage.prix) as prix'), DB::raw('sum(remises.montant) as montant_remises'))->groupBy('gare.id', 'nom_gare', 'users.name', 'bagage.type_bagage')->get();
        // dd($rapportGares);
        $data = [
            'stat_bagage' => $rapportGares,
            'bagage' => BagageTarif::where('compagnie_id', Auth::user()->compagnie_id)->groupBy('name_bagage')->get('name_bagage', 'id'),
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
        ];

        session(['rapportGares' => $rapportGares]);
        return view('statistique.general', $data);
    }

    // Mes fonctions pour les colis
    public function Stat_colis_general(Request $request)
    {


        $req = DB::table('colis')
            ->join('gare', 'colis.gare_id_envoi', '=', 'gare.id')
            ->join('users', 'colis.users_id', '=', 'users.id')
            ->where('gare.compagnie_id', Auth::user()->compagnie_id);

        //  dd($request->gare_id == '');
        if (!empty($request->start)) {
            $req->where('colis.created_at', '>=', $request->start);
            session(['start' => $request->start]);
        }
        if (!empty($request->end)) {
            $req->where('colis.created_at', '<=', $request->end);
            session(['end' => $request->end]);
        }
        if (empty($request->start) && empty($request->end)) {
            $req->whereDate('colis.created_at', '>=', date('Y-m-d'));
            session(['start' => date('Y-m-d')]);
            session(['end' => date('Y-m-d')]);
        }
        if (!empty($request->users_id)) {
            //    dd($request->users_id);
            $req->where('colis.users_id', '=', $request->users_id);
            $nomuser  = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', $request->users_id)->get('name');
            session(['nomuser' => $nomuser[0]->name]);
        }
        if (empty($request->users_id)) {
            //  dd($request->users_id);

            session(['nomuser' => 'Tous les agents']);
        }

        if (!empty($request->gare_id)) {
            //    dd( $request->gare_id);
            $req->where('colis.gare_id_envoi', '=', $request->gare_id);
            $nomgare  = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', $request->gare_id)->get('nom_gare');
            session(['nomgare' => $nomgare[0]->nom_gare]);
        }
        if (empty($request->gare_id)) {
            session(['nomgare' => 'Toutes les gares']);
        }

        $rapportGaresColis = $req->where('colis.statut', '=', 'Received')->select('colis.gare_id_envoi as id', 'gare.nom_gare', 'users.name', DB::raw('count(colis.id) as qte_impression'), DB::raw('sum(colis.nbre_colis) as qte_colis'), DB::raw('sum(colis.prix) as prix'))->groupBy('colis.gare_id_envoi', 'gare.nom_gare', 'users.name')->get();

        // dd($rapportGares);
        $data = [
            'stat_colis' => $rapportGaresColis,
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
        ];
        session(['rapportColis' => $rapportGaresColis]);
        // dd($data);


        return view('statistique.colis.general', $data);
    }

    public function Stat_tickets_general(Request $request)
    {
        $date = Carbon::today()->toDateString();
        $req = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->whereDate('ticket.created_at', $date)
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);

        if (!empty($request->start)) {
            $req->whereDate('ticket.created_at', '>=', $request->start);
            session(['start' => $request->start]);
        }
        if (!empty($request->end)) {
            $req->whereDate('ticket.created_at', '<=', $request->end);
            session(['end' => $request->end]);
        }
        if (empty($request->start) && empty($request->end)) {
            $req->whereDate('ticket.created_at', '>=', date('Y-m-d'));
            session(['start' => date('Y-m-d')]);
            session(['end' => date('Y-m-d')]);
        }
        if (!empty($request->users_id)) {
            //  dd($request->users_id);
            $req->where('ticket.users_id', $request->users_id);
            $nomuser  = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', $request->users_id)->get('name');
            session(['nomuser' => $nomuser[0]->name]);
        }
        if (empty($request->users_id)) {
            //  dd($request->users_id);

            session(['nomuser' => 'Tous les agents']);
        }

        if (!empty($request->gare_id)) {
            // dd( $request->gare_id);
            $req->where('ticket.gare_id', $request->gare_id);
            $nomgare  = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', $request->gare_id)->get('nom_gare');
            session(['nomgare' => $nomgare[0]->nom_gare]);
        }
        $rapportTickets = $req->select('ticket.gare_id as id', 'gare.nom_gare', 'users.name', DB::raw('count(ticket.id) as qte_impression'), DB::raw('sum(ticket.nbre_tickets) as qte_ticket'), DB::raw('sum(ticket.prix) as prix'))->groupBy('ticket.gare_id', 'gare.nom_gare', 'users.name')->get();
        $data = [
            'gares' => DB::table('gare')->where('gare.compagnie_id', Auth::user()->compagnie_id)->get(),
            'ticket' => [],
            'stat_ticket' => $rapportTickets

        ];
        return view('statistique.tickets.general', $data);
    }
    public function Stat_tickets_globale(Request $request)
    {
        $now = now()->format("Y-m");

        $datetime0 = new \DateTime($now);
        $datetime0->modify("+0 months");
        $str_datetime0 = $datetime0->format("Y-m");
        $datetime1 = new \DateTime($now);
        $datetime1->modify("-1 months");
        $str_datetime1 = $datetime1->format("Y-m");
        $datetime2 = new \DateTime($now);
        $datetime2->modify("-2 months");
        $str_datetime2 = $datetime2->format("Y-m");
        $datetime3 = new \DateTime($now);
        $datetime3->modify("-3 months");
        $str_datetime3 = $datetime3->format("Y-m");
        $datetime4 = new \DateTime($now);
        $datetime4->modify("-4 months");
        $str_datetime4 = $datetime4->format("Y-m");
        $datetime5 = new \DateTime($now);
        $datetime5->modify("-5 months");
        $str_datetime5 = $datetime5->format("Y-m");
        $datetime6 = new \DateTime($now);
        $datetime6->modify("-6 months");
        $str_datetime6 = $datetime6->format("Y-m");
        $datetime7 = new \DateTime($now);
        $datetime7->modify("-7 months");
        $str_datetime7 = $datetime7->format("Y-m");
        $datetime8 = new \DateTime($now);
        $datetime8->modify("-8 months");
        $str_datetime8 = $datetime8->format("Y-m");
        $datetime9 = new \DateTime($now);
        $datetime9->modify("-9 months");
        $str_datetime9 = $datetime9->format("Y-m");
        $datetime10 = new \DateTime($now);
        $datetime10->modify("-10 months");
        $str_datetime10 = $datetime10->format("Y-m");
        $datetime11 = new \DateTime($now);
        $datetime11->modify("-11 months");
        $str_datetime11 = $datetime11->format("Y-m");

        // Tickets
        $reqTickets0 = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);
        $reqTickets1 = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);
        $reqTickets2 = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);
        $reqTickets3 = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);

        $reqTickets4 = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);
        $reqTickets5 = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);
        $reqTickets6 = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);
        $reqTickets7 = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);
        $reqTickets8 = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);

        $reqTickets9 = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);

        $reqTickets10 = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);

        $reqTickets11 = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);

        if (!empty($request->users_id)) {

            $reqTickets11->where('ticket.users_id', '=', $request->users_id);
        }

        if (!empty($request->users_id)) {

            $reqTickets0->where('ticket.users_id', $request->users_id);
            $reqTickets1->where('ticket.users_id', $request->users_id);
            $reqTickets2->where('ticket.users_id', $request->users_id);
            $reqTickets3->where('ticket.users_id', $request->users_id);
            $reqTickets4->where('ticket.users_id', $request->users_id);
            $reqTickets5->where('ticket.users_id', $request->users_id);
            $reqTickets6->where('ticket.users_id', $request->users_id);
            $reqTickets7->where('ticket.users_id', $request->users_id);
            $reqTickets8->where('ticket.users_id', $request->users_id);
            $reqTickets9->where('ticket.users_id', $request->users_id);
            $reqTickets10->where('ticket.users_id', $request->users_id);
            $reqTickets11->where('ticket.users_id', $request->users_id);
        }

        if (!empty($request->gare_id)) {

            $reqTickets0->where('ticket.gare_id', $request->gare_id);
            $reqTickets1->where('ticket.gare_id', $request->gare_id);
            $reqTickets2->where('ticket.gare_id', $request->gare_id);
            $reqTickets3->where('ticket.gare_id', $request->gare_id);
            $reqTickets4->where('ticket.gare_id', $request->gare_id);
            $reqTickets5->where('ticket.gare_id', $request->gare_id);
            $reqTickets6->where('ticket.gare_id', $request->gare_id);
            $reqTickets7->where('ticket.gare_id', $request->gare_id);
            $reqTickets8->where('ticket.gare_id', $request->gare_id);
            $reqTickets9->where('ticket.gare_id', $request->gare_id);
            $reqTickets10->where('ticket.gare_id', $request->gare_id);
            $reqTickets11->where('ticket.gare_id', $request->gare_id);
        }

        $ticketsVendus11 = $reqTickets11->where('ticket.created_at', 'like', '%' . $str_datetime11  . '%')->sum('prix');
        $ticketsVendus10 = $reqTickets10->where('ticket.created_at', 'like', '%' . $str_datetime10  . '%')->sum('prix');
        $ticketsVendus9 = $reqTickets9->where('ticket.created_at', 'like', '%' . $str_datetime9  . '%')->sum('prix');
        $ticketsVendus8 = $reqTickets8->where('ticket.created_at', 'like', '%' . $str_datetime8  . '%')->sum('prix');
        $ticketsVendus7 = $reqTickets7->where('ticket.created_at', 'like', '%' . $str_datetime7  . '%')->sum('prix');
        $ticketsVendus6 = $reqTickets6->where('ticket.created_at', 'like', '%' . $str_datetime6  . '%')->sum('prix');
        $ticketsVendus5 = $reqTickets5->where('ticket.created_at', 'like', '%' . $str_datetime5  . '%')->sum('prix');
        $ticketsVendus4 = $reqTickets4->where('ticket.created_at', 'like', '%' . $str_datetime4  . '%')->sum('prix');
        $ticketsVendus3 = $reqTickets3->where('ticket.created_at', 'like', '%' . $str_datetime3  . '%')->sum('prix');
        $ticketsVendus2 = $reqTickets2->where('ticket.created_at', 'like', '%' . $str_datetime2  . '%')->sum('prix');
        $ticketsVendus1 = $reqTickets1->where('ticket.created_at', 'like', '%' . $str_datetime1  . '%')->sum('prix');
        $ticketsVendus0 = $reqTickets0->where('ticket.created_at', 'like', '%' . $str_datetime0  . '%')->sum('prix');

        $data = [
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
            'stat_tickets0' => $ticketsVendus0,
            'stat_tickets1' => $ticketsVendus1,
            'stat_tickets2' => $ticketsVendus2,
            'stat_tickets3' => $ticketsVendus3,
            'stat_tickets4' => $ticketsVendus4,
            'stat_tickets5' => $ticketsVendus5,
            'stat_tickets6' => $ticketsVendus6,
            'stat_tickets7' => $ticketsVendus7,
            'stat_tickets8' => $ticketsVendus8,
            'stat_tickets9' => $ticketsVendus9,
            'stat_tickets10' => $ticketsVendus10,
            'stat_tickets11' => $ticketsVendus11,
        ];

        return view('statistique.tickets.globale', $data);
    }

    public function Stat_tickets_journalier(Request $request)
    {
        $date = Carbon::today()->toDateString();

        $req = DB::table('ticket')
            ->join('gare', 'ticket.gare_id', 'gare.id')
            ->join('users', 'ticket.users_id', 'users.id')
            ->whereDate('ticket.created_at', $date)
            ->where('ticket.compagnie_id', Auth::user()->compagnie_id);

        if (!empty($request->users_id)) {
            //    dd($request->users_id);
            $req->where('ticket.users_id', '=', $request->users_id);
            $nomuser  = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', $request->users_id)->get('name');
            session(['nomuser' => $nomuser[0]->name]);
        }
        if (empty($request->users_id)) {
            //  dd($request->users_id);

            session(['nomuser' => 'Tous les agents']);
        }

        if (!empty($request->gare_id)) {
            //    dd( $request->gare_id);
            $req->where('ticket.gare_id', '=', $request->gare_id);
            $nomgare  = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', $request->gare_id)->get('nom_gare');
            session(['nomgare' => $nomgare[0]->nom_gare]);
        }
        if (empty($request->gare_id)) {
            session(['nomgare' => 'Toutes les gares']);
        }
        $rapportTickets = $req->select('ticket.gare_id as id', 'gare.nom_gare', 'users.name', DB::raw('count(ticket.id) as qte_impression'), DB::raw('sum(ticket.nbre_tickets) as qte_ticket'), DB::raw('sum(ticket.prix) as prix'))->groupBy('ticket.gare_id', 'gare.nom_gare', 'users.name')->get();
        $data = [
            'gares' => DB::table('gare')->where('gare.compagnie_id', Auth::user()->compagnie_id)->get(),
            'stat_tickets' => $rapportTickets

        ];
        return view('statistique.tickets.journalier', $data);
    }



    public function Stat_colis_globale(Request $request)
    {

        $now = now()->format("Y-m");

        $datetime0 = new \DateTime($now);
        $datetime0->modify("+0 months");
        $str_datetime0 = $datetime0->format("Y-m");
        $datetime1 = new \DateTime($now);
        $datetime1->modify("-1 months");
        $str_datetime1 = $datetime1->format("Y-m");
        $datetime2 = new \DateTime($now);
        $datetime2->modify("-2 months");
        $str_datetime2 = $datetime2->format("Y-m");
        $datetime3 = new \DateTime($now);
        $datetime3->modify("-3 months");
        $str_datetime3 = $datetime3->format("Y-m");
        $datetime4 = new \DateTime($now);
        $datetime4->modify("-4 months");
        $str_datetime4 = $datetime4->format("Y-m");
        $datetime5 = new \DateTime($now);
        $datetime5->modify("-5 months");
        $str_datetime5 = $datetime5->format("Y-m");
        $datetime6 = new \DateTime($now);
        $datetime6->modify("-6 months");
        $str_datetime6 = $datetime6->format("Y-m");
        $datetime7 = new \DateTime($now);
        $datetime7->modify("-7 months");
        $str_datetime7 = $datetime7->format("Y-m");
        $datetime8 = new \DateTime($now);
        $datetime8->modify("-8 months");
        $str_datetime8 = $datetime8->format("Y-m");
        $datetime9 = new \DateTime($now);
        $datetime9->modify("-9 months");
        $str_datetime9 = $datetime9->format("Y-m");
        $datetime10 = new \DateTime($now);
        $datetime10->modify("-10 months");
        $str_datetime10 = $datetime10->format("Y-m");
        $datetime11 = new \DateTime($now);
        $datetime11->modify("-11 months");
        $str_datetime11 = $datetime11->format("Y-m");

        // requete pour les colis envoyés et livrés

        $reqColisEnvoye0 = DB::table('colis')->join('gare', 'colis.gare_id_envoi', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id);
        $reqColisEnvoye1 = DB::table('colis')->join('gare', 'colis.gare_id_envoi', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id);
        $reqColisEnvoye2 = DB::table('colis')->join('gare', 'colis.gare_id_envoi', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id);
        $reqColisEnvoye3 = DB::table('colis')->join('gare', 'colis.gare_id_envoi', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id);
        $reqColisEnvoye4 = DB::table('colis')->join('gare', 'colis.gare_id_envoi', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id);
        $reqColisEnvoye5 = DB::table('colis')->join('gare', 'colis.gare_id_envoi', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id);
        $reqColisEnvoye6 = DB::table('colis')->join('gare', 'colis.gare_id_envoi', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id);
        $reqColisEnvoye7 = DB::table('colis')->join('gare', 'colis.gare_id_envoi', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id);
        $reqColisEnvoye8 = DB::table('colis')->join('gare', 'colis.gare_id_envoi', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id);
        $reqColisEnvoye9 = DB::table('colis')->join('gare', 'colis.gare_id_envoi', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id);
        $reqColisEnvoye10 = DB::table('colis')->join('gare', 'colis.gare_id_envoi', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id);
        $reqColisEnvoye11 = DB::table('colis')->join('gare', 'colis.gare_id_envoi', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id);

        //requete pour les colis reçus par une autre gare que la notre

        $reqColisRecus0 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisRecus1 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisRecus2 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisRecus3 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisRecus4 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisRecus5 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisRecus6 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisRecus7 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisRecus8 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisRecus9 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisRecus10 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisRecus11 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);

        // requete pour les colis en attente mais qui sortent de notre gare

        $reqColisAttente0 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisAttente1 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisAttente2 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisAttente3 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisAttente4 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisAttente5 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisAttente6 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisAttente7 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisAttente8 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisAttente9 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisAttente10 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);
        $reqColisAttente11 = DB::table('colis')->join('gare', 'colis.gare_id_recu', 'gare.id')->join('users', 'colis.users_id', 'users.id')->where('colis.compagnie_id', Auth::user()->compagnie_id)->where('colis.gare_id_envoi', '<>', Auth::user()->gare_id);



        //  dd($req->where('bagage.created_at','like', '%'. $str_datetime10 . '%')->sum('prix'));


        //dd($request->gare_id);
        if (!empty($request->users_id)) {

            $reqColisEnvoye0->where('colis.users_id', '=', $request->users_id);
            $reqColisEnvoye1->where('colis.users_id', '=', $request->users_id);
            $reqColisEnvoye2->where('colis.users_id', '=', $request->users_id);
            $reqColisEnvoye3->where('colis.users_id', '=', $request->users_id);
            $reqColisEnvoye4->where('colis.users_id', '=', $request->users_id);
            $reqColisEnvoye5->where('colis.users_id', '=', $request->users_id);
            $reqColisEnvoye6->where('colis.users_id', '=', $request->users_id);
            $reqColisEnvoye7->where('colis.users_id', '=', $request->users_id);
            $reqColisEnvoye8->where('colis.users_id', '=', $request->users_id);
            $reqColisEnvoye9->where('colis.users_id', '=', $request->users_id);
            $reqColisEnvoye10->where('colis.users_id', '=', $request->users_id);
            $reqColisEnvoye11->where('colis.users_id', '=', $request->users_id);
        }

        if (!empty($request->gare_id)) {

            $reqColisEnvoye0->where('colis.gare_id_envoi', '=', $request->gare_id);
            $reqColisEnvoye1->where('colis.gare_id_envoi', '=', $request->gare_id);
            $reqColisEnvoye2->where('colis.gare_id_envoi', '=', $request->gare_id);
            $reqColisEnvoye3->where('colis.gare_id_envoi', '=', $request->gare_id);
            $reqColisEnvoye4->where('colis.gare_id_envoi', '=', $request->gare_id);
            $reqColisEnvoye5->where('colis.gare_id_envoi', '=', $request->gare_id);
            $reqColisEnvoye6->where('colis.gare_id_envoi', '=', $request->gare_id);
            $reqColisEnvoye7->where('colis.gare_id_envoi', '=', $request->gare_id);
            $reqColisEnvoye8->where('colis.gare_id_envoi', '=', $request->gare_id);
            $reqColisEnvoye9->where('colis.gare_id_envoi', '=', $request->gare_id);
            $reqColisEnvoye10->where('colis.gare_id_envoi', '=', $request->gare_id);
            $reqColisEnvoye11->where('colis.gare_id_envoi', '=', $request->gare_id);
        }

        /*************Stat colis livré */

        $colisLivre11 = $reqColisEnvoye11->where('colis.created_at', 'like', '%' . $str_datetime11  . '%')->where('colis.statut', '=', "Delivered")->sum('prix');
        $colisLivre10 = $reqColisEnvoye10->where('colis.created_at', 'like', '%' . $str_datetime10 . '%')->where('colis.statut', '=', "Delivered")->sum('prix');
        $colisLivre9 = $reqColisEnvoye9->where('colis.created_at', 'like', '%' . $str_datetime9  . '%')->where('colis.statut', '=', "Delivered")->sum('prix');
        $colisLivre8 =  $reqColisEnvoye8->where('colis.created_at', 'like', '%' . $str_datetime8  . '%')->where('colis.statut', '=', "Delivered")->sum('prix');
        $colisLivre7 =  $reqColisEnvoye7->where('colis.created_at', 'like', '%' . $str_datetime7  . '%')->where('colis.statut', '=', "Delivered")->sum('prix');
        $colisLivre6 =  $reqColisEnvoye6->where('colis.created_at', 'like', '%' . $str_datetime6  . '%')->where('colis.statut', '=', "Delivered")->sum('prix');
        $colisLivre5 =  $reqColisEnvoye5->where('colis.created_at', 'like', '%' . $str_datetime5  . '%')->where('colis.statut', '=', "Delivered")->sum('prix');
        $colisLivre4 =  $reqColisEnvoye4->where('colis.created_at', 'like', '%' . $str_datetime4  . '%')->where('colis.statut', '=', "Delivered")->sum('prix');
        $colisLivre3 =  $reqColisEnvoye3->where('colis.created_at', 'like', '%' . $str_datetime3  . '%')->where('colis.statut', '=', "Delivered")->sum('prix');
        $colisLivre2 =  $reqColisEnvoye2->where('colis.created_at', 'like', '%' . $str_datetime2  . '%')->where('colis.statut', '=', "Delivered")->sum('prix');
        $colisLivre1 =  $reqColisEnvoye1->where('colis.created_at', 'like', '%' . $str_datetime1  . '%')->where('colis.statut', '=', "Delivered")->sum('prix');
        $colisLivre0 = $reqColisEnvoye0->where('colis.created_at', 'like', '%' . $str_datetime0  . '%')->where('colis.statut', '=', "Delivered")->sum('prix');

        /*************stat colis reçus */

        $colisrecus11 = $reqColisRecus11->where('colis.created_at', 'like', '%' . $str_datetime11  . '%')->where('colis.statut', '=', "Received")->sum('prix');
        $colisrecus10 = $reqColisRecus10->where('colis.created_at', 'like', '%' . $str_datetime10 . '%')->where('colis.statut', '=', "Received")->sum('prix');
        $colisrecus9 = $reqColisRecus9->where('colis.created_at', 'like', '%' . $str_datetime9  . '%')->where('colis.statut', '=', "Received")->sum('prix');
        $colisrecus8 =  $reqColisRecus8->where('colis.created_at', 'like', '%' . $str_datetime8  . '%')->where('colis.statut', '=', "Received")->sum('prix');
        $colisrecus7 =  $reqColisRecus7->where('colis.created_at', 'like', '%' . $str_datetime7  . '%')->where('colis.statut', '=', "Received")->sum('prix');
        $colisrecus6 =  $reqColisRecus6->where('colis.created_at', 'like', '%' . $str_datetime5  . '%')->where('colis.statut', '=', "Received")->sum('prix');
        $colisrecus5 =  $reqColisRecus5->where('colis.created_at', 'like', '%' . $str_datetime5  . '%')->where('colis.statut', '=', "Received")->sum('prix');
        $colisrecus4 =  $reqColisRecus4->where('colis.created_at', 'like', '%' . $str_datetime4  . '%')->where('colis.statut', '=', "Received")->sum('prix');
        $colisrecus3 =  $reqColisRecus3->where('colis.created_at', 'like', '%' . $str_datetime3  . '%')->where('colis.statut', '=', "Received")->sum('prix');
        $colisrecus2 =  $reqColisRecus2->where('colis.created_at', 'like', '%' . $str_datetime2  . '%')->where('colis.statut', '=', "Received")->sum('prix');
        $colisrecus1 =  $reqColisRecus1->where('colis.created_at', 'like', '%' . $str_datetime1  . '%')->where('colis.statut', '=', "Received")->sum('prix');
        $colisrecus0 = $reqColisRecus0->where('colis.created_at', 'like', '%' . $str_datetime0  . '%')->where('colis.statut', '=', "Received")->sum('prix');

        //  Colis en attente

        //  $colisAttente11= $req11->where('colis.created_at', 'like', '%' . $str_datetime11  . '%')->where('colis.statut', "Waiting")->sum('prix');
        //  $colisAttente10= $req10->where('colis.created_at','like', '%'. $str_datetime10 . '%')->where('colis.statut', "Waiting")->sum('prix');
        //  $colisAttente9= $req9->where('colis.created_at', 'like', '%' . $str_datetime9  . '%')->where('colis.statut', "Waiting")->sum('prix');
        //  $colisAttente8=  $req8->where('colis.created_at', 'like', '%' . $str_datetime8  . '%')->where('colis.statut', "Waiting")->sum('prix');
        //  $colisAttente7=  $req7->where('colis.created_at', 'like', '%' . $str_datetime7  . '%')->where('colis.statut', "Waiting")->sum('prix');
        //  $colisAttente6=  $req6->where('colis.created_at', 'like', '%' . $str_datetime5  . '%')->where('colis.statut', "Waiting")->sum('prix');
        //  $colisAttente5=  $req5->where('colis.created_at', 'like', '%' . $str_datetime5  . '%')->where('colis.statut', "Waiting")->sum('prix');
        //  $colisAttente4=  $req4->where('colis.created_at', 'like', '%' . $str_datetime4  . '%')->where('colis.statut', "Waiting")->sum('prix');
        //  $colisAttente3=  $req3->where('colis.created_at', 'like', '%' . $str_datetime3  . '%')->where('colis.statut', "Waiting")->sum('prix');
        //  $colisAttente2=  $req2->where('colis.created_at', 'like', '%' . $str_datetime2  . '%')->where('colis.statut', "Waiting")->sum('prix');
        //  $colisAttente1=  $req1->where('colis.created_at', 'like', '%' . $str_datetime1  . '%')->where('colis.statut', "Waiting")->sum('prix');
        //  $colisAttente0= $req0->where('colis.created_at', 'like', '%' . $str_datetime0  . '%')->where('colis.statut', "Waiting")->sum('prix');
        //  dd($bagage9);

        $data = [
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
            'stat_colisLivre0' => $colisLivre0,
            'stat_colisLivre1' => $colisLivre1,
            'stat_colisLivre2' => $colisLivre2,
            'stat_colisLivre3' => $colisLivre3,
            'stat_colisLivre4' => $colisLivre4,
            'stat_colisLivre5' => $colisLivre5,
            'stat_colisLivre6' => $colisLivre6,
            'stat_colisLivre7' => $colisLivre7,
            'stat_colisLivre8' => $colisLivre8,
            'stat_colisLivre9' => $colisLivre9,
            'stat_colisLivre10' => $colisLivre10,
            'stat_colisLivre11' => $colisLivre11,

            'stat_colisrecus0' => $colisrecus0,
            'stat_colisrecus1' => $colisrecus1,
            'stat_colisrecus2' => $colisrecus2,
            'stat_colisrecus3' => $colisrecus3,
            'stat_colisrecus4' => $colisrecus4,
            'stat_colisrecus5' => $colisrecus5,
            'stat_colisrecus6' => $colisrecus6,
            'stat_colisrecus7' => $colisrecus7,
            'stat_colisrecus8' => $colisrecus8,
            'stat_colisrecus9' => $colisrecus9,
            'stat_colisrecus10' => $colisrecus10,
            'stat_colisrecus11' => $colisrecus11,


        ];
        // dd($data);
        return view('statistique.colis.globale', $data);
    }

    public function Stat_colis_journalier(Request $request)
    {
        $date = Carbon::today()->toDateString();
        $req = DB::table('colis')
            ->join('gare', 'colis.gare_id_envoi', 'gare.id')
            ->join('users', 'colis.users_id', 'users.id')
            ->whereDate('colis.created_at', $date)
            ->where('colis.compagnie_id', Auth::user()->compagnie_id);

        if (!empty($request->statut)) {

            if ($request->statut == "Received") {
                $req = DB::table('colis')
                    ->join('gare', 'colis.gare_id_recu', 'gare.id')
                    ->join('users', 'colis.update_user', 'users.id')
                    ->whereDate('colis.updated_at', $date)
                    ->where('colis.compagnie_id', Auth::user()->compagnie_id)
                    ->where('colis.statut', $request->statut);

                $r = $req->select('colis.gare_id_recu as id', 'gare.nom_gare', 'users.name', DB::raw('count(colis.id) as qte_impression'), DB::raw('sum(colis.nbre_colis) as qte_colis'), DB::raw('sum(colis.prix) as prix'))->groupBy('colis.gare_id_recu', 'gare.nom_gare', 'users.name')->get();
            } else if ($request->statut == "Delivered") {

                $req = DB::table('colis')
                    ->join('gare', 'colis.gare_id_envoi', 'gare.id')
                    ->join('users', 'colis.users_id', 'users.id')
                    ->whereDate('colis.updated_at', $date)
                    ->where('colis.compagnie_id', Auth::user()->compagnie_id)
                    ->where('colis.statut', $request->statut);

                $r = $req->select('colis.gare_id_envoi as id', 'gare.nom_gare', 'users.name', DB::raw('count(colis.id) as qte_impression'), DB::raw('sum(colis.nbre_colis) as qte_colis'), DB::raw('sum(colis.prix) as prix'))->groupBy('colis.gare_id_envoi', 'gare.nom_gare', 'users.name')->get();
            } else if ($request->statut == "Waiting") {

                $req = DB::table('colis')
                    ->join('gare', 'colis.gare_id_envoi', 'gare.id')
                    ->join('users', 'colis.users_id', 'users.id')
                    ->whereDate('colis.created_at', $date)
                    ->where('colis.compagnie_id', Auth::user()->compagnie_id)
                    ->where('colis.statut', $request->statut);

                $r = $req->select('colis.gare_id_envoi as id', 'gare.nom_gare', 'users.name', DB::raw('count(colis.id) as qte_impression'), DB::raw('sum(colis.nbre_colis) as qte_colis'), DB::raw('sum(colis.prix) as prix'))->groupBy('colis.gare_id_envoi', 'gare.nom_gare', 'users.name')->get();
            }
        }

        if (!empty($request->gare_id)) {
            $req->where('gare.id', $request->gare_id)->get();
        }

        $r = $req->select('colis.gare_id_envoi as id', 'gare.nom_gare', 'users.name', DB::raw('count(colis.id) as qte_impression'), DB::raw('sum(colis.nbre_colis) as qte_colis'), DB::raw('sum(colis.prix) as prix'))->groupBy('colis.gare_id_envoi', 'gare.nom_gare', 'users.name')->get();
        $data = [
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
            'statut_colis' => DB::table('colis')->select('colis.statut')->where('colis.gare_id_envoi', Auth::user()->gare_id)->groupBy('colis.statut')->get(),
            "stat_colis" => $r


        ];

        return view('statistique.colis.journalier', $data);
    }
    public function agent(Request $request)
    {

        if ($request->parent_id == '') {
            $users = User::where(['compagnie_id' => Auth::user()->compagnie_id])->get();
        } else {
            $users = User::where(['gare_id' => $request->parent_id])->get();
        }



        $res = '<option value="*"  selected>---Selectionner l\'agent---</option>';
        // dd($users);
        foreach ($users as $row) {
            if ($row->id == $request->sub_category) {
                $res .= '<option value="' . $row->id . '" selected >' . $row->name . '</option>';
            } else {
                $res .= '<option value="' . $row->id . '">' . $row->name . '</option>';
            }
        }
        return response()->json([
            'select_tag' => $res,
        ]);
    }
    public function statut(Request $request)
    {

        if ($request->parent_id == '') {
            $users = User::where(['compagnie_id' => Auth::user()->compagnie_id])->get();
        } else {
            $users = User::where(['gare_id' => $request->parent_id])->get();
        }



        $res = '<option value="*"  selected>---Selectionner le statut---</option>';
        // dd($users);
        foreach ($users as $row) {
            if ($row->id == $request->sub_category) {
                $res .= '<option value="' . $row->id . '" selected >' . $row->name . '</option>';
            } else {
                $res .= '<option value="' . $row->id . '">' . $row->name . '</option>';
            }
        }
        return response()->json([
            'select_tag' => $res,
        ]);
    }
    public function vehicule(Request $request)
    {

        if ($request->parent_id == 0)
            $users = Vehicule::where('nbre_de_place', '>=', 4)->where(['compagnie_id' => $request->compagnie])->get();
        else
            $users = Vehicule::where('nbre_de_place', '<=', 4)->where(['compagnie_id' => $request->compagnie])->get();


        $res = '<option value="' . 0 . '" disabled selected>---Selectionner le véhicule---</option>';
        // dd($users);
        foreach ($users as $row) {
            if ($row->id == $request->sub_category) {
                $res .= '<option value="' . $row->id . '" selected >' . $row->nom_vehicule . ' ' . $row->numero_vehicule . '</option>';
            } else {
                $res .= '<option value="' . $row->id . '">' . $row->nom_vehicule . ' ' . $row->numero_vehicule . '</option>';
            }
        }
        return response()->json([
            'select_tag' => $res,
        ]);
    }



    public function get_data(Request $request)
    {
        dd(empty($request->start));
        $req = DB::table('bagage')
            ->join('gare', 'bagage.gare_id', 'gare.id')
            ->join('users', 'bagage.users_id', 'users.id')
            ->leftJoin('remises', 'bagage.id', 'remises.bagage_id')
            //  ->where('bagage.gare_id', Auth::user()->gare_id)
            ->where('gare.compagnie_id', Auth::user()->compagnie_id);
        $req->whereDate('bagage.created_at', '>=', $request->start);
        $req->whereDate('bagage.created_at', '<=', $request->end);
        //  dd($request->gare_id == '');
        if (!empty($request->users_id)) {
            //  dd($request->users_id);
            $req->where('bagage.users_id', $request->users_id);
        }

        if (!empty($request->gare_id)) {
            // dd( $request->gare_id);
            $req->where('bagage.gare_id', $request->gare_id);
        }

        if (!empty($request->bagage_id)) {
            // dd($request->bagage_id);
            $req->where('bagage.type_bagage', 'like', '%' .  $request->bagage_id . '%');
            //session(['type_bagage' => 'BAGAGE']);
            // dd($req->get());
        }



        $rapportGares = $req->where('bagage.is_solded', 1)->select('gare.id as id', 'gare.nom_gare', 'users.name', 'bagage.type_bagage', DB::raw('count(bagage.id) as qte_impression'), DB::raw('sum(bagage.nbr_de_bagage) as qte_bagage'), DB::raw('sum(bagage.prix) as prix'), DB::raw('sum(remises.montant) as montant_remises'))->groupBy('gare.id', 'nom_gare', 'users.name', 'bagage.type_bagage')->get();
        // dd($rapportGares);
        $data = [
            'stat_bagage' => $rapportGares,
            'bagage' => BagageTarif::where('compagnie_id', Auth::user()->compagnie_id)->groupBy('name_bagage')->get('name_bagage', 'id'),
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
        ];

        session(['rapportGares' => $rapportGares]);
        return view('statistique.general', $data);
    }

    public function Globale(Request $request)

    {

        $now = now()->format("Y-m");
        $datetime0 = new \DateTime($now);
        $datetime0->modify("+0 months");
        $str_datetime0 = $datetime0->format("Y-m");
        $datetime1 = new \DateTime($now);
        $datetime1->modify("-1 months");
        $str_datetime1 = $datetime1->format("Y-m");
        $datetime2 = new \DateTime($now);
        $datetime2->modify("-2 months");
        $str_datetime2 = $datetime2->format("Y-m");
        $datetime3 = new \DateTime($now);
        $datetime3->modify("-3 months");
        $str_datetime3 = $datetime3->format("Y-m");
        $datetime4 = new \DateTime($now);
        $datetime4->modify("-4 months");
        $str_datetime4 = $datetime4->format("Y-m");
        $datetime5 = new \DateTime($now);
        $datetime5->modify("-5 months");
        $str_datetime5 = $datetime5->format("Y-m");
        $datetime6 = new \DateTime($now);
        $datetime6->modify("-6 months");
        $str_datetime6 = $datetime6->format("Y-m");
        $datetime7 = new \DateTime($now);
        $datetime7->modify("-7 months");
        $str_datetime7 = $datetime7->format("Y-m");
        $datetime8 = new \DateTime($now);
        $datetime8->modify("-8 months");
        $str_datetime8 = $datetime8->format("Y-m");
        $datetime9 = new \DateTime($now);
        $datetime9->modify("-9 months");
        $str_datetime9 = $datetime9->format("Y-m");
        $datetime10 = new \DateTime($now);
        $datetime10->modify("-10 months");
        $str_datetime10 = $datetime10->format("Y-m");
        $datetime11 = new \DateTime($now);
        $datetime11->modify("-11 months");
        $str_datetime11 = $datetime11->format("Y-m");

        //dd(Auth::user()->compagnie_id);

        $req0 = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')->join('users', 'bagage.users_id', 'users.id')->where('bagage.compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 1);
        $req1 = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')->join('users', 'bagage.users_id', 'users.id')->where('bagage.compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 1);
        $req2 = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')->join('users', 'bagage.users_id', 'users.id')->where('bagage.compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 1);
        $req3 = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')->join('users', 'bagage.users_id', 'users.id')->where('bagage.compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 1);
        $req4 = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')->join('users', 'bagage.users_id', 'users.id')->where('bagage.compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 1);
        $req5 = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')->join('users', 'bagage.users_id', 'users.id')->where('bagage.compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 1);
        $req6 = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')->join('users', 'bagage.users_id', 'users.id')->where('bagage.compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 1);
        $req7 = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')->join('users', 'bagage.users_id', 'users.id')->where('bagage.compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 1);
        $req8 = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')->join('users', 'bagage.users_id', 'users.id')->where('bagage.compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 1);
        $req9 = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')->join('users', 'bagage.users_id', 'users.id')->where('bagage.compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 1);
        $req10 = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')->join('users', 'bagage.users_id', 'users.id')->where('bagage.compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 1);
        $req11 = DB::table('bagage')->join('gare', 'bagage.gare_id', 'gare.id')->join('users', 'bagage.users_id', 'users.id')->where('bagage.compagnie_id', Auth::user()->compagnie_id)->where('bagage.is_solded', 1);
        // dd($req->where('created_at','like', '%'. $str_datetime10 . '%')->sum('prix'));
        //
        //
        // ;



        //  dd($req->where('bagage.created_at','like', '%'. $str_datetime10 . '%')->sum('prix'));


        //dd($request->gare_id);
        if (!empty($request->users_id)) {

            $req0->where('bagage.users_id', $request->users_id);
            $req1->where('bagage.users_id', $request->users_id);
            $req2->where('bagage.users_id', $request->users_id);
            $req3->where('bagage.users_id', $request->users_id);
            $req4->where('bagage.users_id', $request->users_id);
            $req5->where('bagage.users_id', $request->users_id);
            $req6->where('bagage.users_id', $request->users_id);
            $req7->where('bagage.users_id', $request->users_id);
            $req8->where('bagage.users_id', $request->users_id);
            $req9->where('bagage.users_id', $request->users_id);
            $req10->where('bagage.users_id', $request->users_id);
            $req11->where('bagage.users_id', $request->users_id);
        }

        if (!empty($request->gare_id)) {

            $req0->where('bagage.gare_id', $request->gare_id);
            $req1->where('bagage.gare_id', $request->gare_id);
            $req2->where('bagage.gare_id', $request->gare_id);
            $req3->where('bagage.gare_id', $request->gare_id);
            $req4->where('bagage.gare_id', $request->gare_id);
            $req5->where('bagage.gare_id', $request->gare_id);
            $req6->where('bagage.gare_id', $request->gare_id);
            $req7->where('bagage.gare_id', $request->gare_id);
            $req8->where('bagage.gare_id', $request->gare_id);
            $req9->where('bagage.gare_id', $request->gare_id);
            $req10->where('bagage.gare_id', $request->gare_id);
            $req11->where('bagage.gare_id', $request->gare_id);
        }

        /*************Stat bagage */
        $bagage11 = $req11->where('bagage.created_at', 'like', '%' . $str_datetime11  . '%')->where('is_fret', 0)->sum('prix');
        $bagage10 = $req10->where('bagage.created_at', 'like', '%' . $str_datetime10 . '%')->where('is_fret', 0)->sum('prix');
        $bagage9 = $req9->where('bagage.created_at', 'like', '%' . $str_datetime9  . '%')->where('is_fret', 0)->sum('prix');
        $bagage8 =  $req8->where('bagage.created_at', 'like', '%' . $str_datetime8  . '%')->where('is_fret', 0)->sum('prix');
        $bagage7 =  $req7->where('bagage.created_at', 'like', '%' . $str_datetime7  . '%')->where('is_fret', 0)->sum('prix');
        $bagage6 =  $req6->where('bagage.created_at', 'like', '%' . $str_datetime5  . '%')->where('is_fret', 0)->sum('prix');
        $bagage5 =  $req5->where('bagage.created_at', 'like', '%' . $str_datetime5  . '%')->where('is_fret', 0)->sum('prix');
        $bagage4 =  $req4->where('bagage.created_at', 'like', '%' . $str_datetime4  . '%')->where('is_fret', 0)->sum('prix');
        $bagage3 =  $req3->where('bagage.created_at', 'like', '%' . $str_datetime3  . '%')->where('is_fret', 0)->sum('prix');
        $bagage2 =  $req2->where('bagage.created_at', 'like', '%' . $str_datetime2  . '%')->where('is_fret', 0)->sum('prix');
        $bagage1 =  $req1->where('bagage.created_at', 'like', '%' . $str_datetime1  . '%')->where('is_fret', 0)->sum('prix');
        $bagage0 = $req0->where('bagage.created_at', 'like', '%' . $str_datetime0  . '%')->where('is_fret', 0)->sum('prix');

        /*************stat fret */
        $fret11 = $req11->where('bagage.created_at', 'like', '%' . $str_datetime11  . '%')->where('is_fret', 1)->sum('prix');
        $fret10 = $req10->where('bagage.created_at', 'like', '%' . $str_datetime10 . '%')->where('is_fret', 1)->sum('prix');
        $fret9 = $req9->where('bagage.created_at', 'like', '%' . $str_datetime9  . '%')->where('is_fret', 1)->sum('prix');
        $fret8 =  $req8->where('bagage.created_at', 'like', '%' . $str_datetime8  . '%')->where('is_fret', 1)->sum('prix');
        $fret7 =  $req7->where('bagage.created_at', 'like', '%' . $str_datetime7  . '%')->where('is_fret', 1)->sum('prix');
        $fret6 =  $req6->where('bagage.created_at', 'like', '%' . $str_datetime5  . '%')->where('is_fret', 1)->sum('prix');
        $fret5 =  $req5->where('bagage.created_at', 'like', '%' . $str_datetime5  . '%')->where('is_fret', 1)->sum('prix');
        $fret4 =  $req4->where('bagage.created_at', 'like', '%' . $str_datetime4  . '%')->where('is_fret', 1)->sum('prix');
        $fret3 =  $req3->where('bagage.created_at', 'like', '%' . $str_datetime3  . '%')->where('is_fret', 1)->sum('prix');
        $fret2 =  $req2->where('bagage.created_at', 'like', '%' . $str_datetime2  . '%')->where('is_fret', 1)->sum('prix');
        $fret1 =  $req1->where('bagage.created_at', 'like', '%' . $str_datetime1  . '%')->where('is_fret', 1)->sum('prix');
        $fret0 = $req0->where('bagage.created_at', 'like', '%' . $str_datetime0  . '%')->where('is_fret', 1)->sum('prix');
        //  dd($bagage9);

        $data = [
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
            'stat_bagage0' => $bagage0,
            'stat_bagage1' => $bagage1,
            'stat_bagage2' => $bagage2,
            'stat_bagage3' => $bagage3,
            'stat_bagage4' => $bagage4,
            'stat_bagage5' => $bagage5,
            'stat_bagage6' => $bagage6,
            'stat_bagage7' => $bagage7,
            'stat_bagage8' => $bagage8,
            'stat_bagage9' => $bagage9,
            'stat_bagage10' => $bagage10,
            'stat_bagage11' => $bagage11,


            'stat_fret0' => $fret0,
            'stat_fret1' => $fret1,
            'stat_fret2' => $fret2,
            'stat_fret3' => $fret3,
            'stat_fret4' => $fret4,
            'stat_fret5' => $fret5,
            'stat_fret6' => $fret6,
            'stat_fret7' => $fret7,
            'stat_fret8' => $fret8,
            'stat_fret9' => $fret9,
            'stat_fret10' => $fret10,
            'stat_fret11' => $fret11,
        ];
        return view('statistique.globale', $data);
    }

    public function journalier(Request $request)
    {

        // dd(empty($request->bagage_id));
        $req = DB::table('bagage')
            ->join('gare', 'bagage.gare_id', 'gare.id')
            ->join('users', 'bagage.users_id', 'users.id')
            ->leftJoin('remises', 'bagage.id', 'remises.bagage_id')
            //  ->where('bagage.gare_id', Auth::user()->gare_id)
            ->where('gare.compagnie_id', Auth::user()->compagnie_id);



        if (!empty($request->gare_id)) {
            // dd( $request->gare_id);
            $req->where('bagage.gare_id', $request->gare_id);
            $nomgare  = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', $request->gare_id)->get('nom_gare');

            session(['nomgare' => $nomgare[0]->nom_gare]);
        }

        if (empty($request->gare_id)) {
            session(['nomgare' => 'Toutes les gares']);
        }

        if (!empty($request->start)) {
            $req->where('bagage.created_at', '>=', $request->start);
            session(['start' => $request->start]);
        }
        if (!empty($request->end)) {
            $req->where('bagage.created_at', '<=', $request->end);
            session(['end' => $request->end]);
        }
        if (empty($request->start) && empty($request->end)) {
            $req->whereDate('bagage.created_at', '>=', date('Y-m-d'));
            session(['start' => date('Y-m-d')]);
            session(['end' => date('Y-m-d')]);
        }


        $rapportGares = $req->where('bagage.is_solded', 1)->select('gare.id as id', 'gare.nom_gare', 'bagage.type_bagage', DB::raw('count(bagage.id) as qte_impression'), DB::raw('sum(bagage.nbr_de_bagage) as qte_bagage'), DB::raw('sum(bagage.prix) as prix'), DB::raw('sum(remises.montant) as montant_remises'))->groupBy('gare.id', 'nom_gare', 'bagage.type_bagage')->get();




        $data = [
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
            'stat_bagage' => $rapportGares,
        ];
        session(['rapportGares' => $rapportGares]);
        return view('statistique.journalier', $data);
    }
}
