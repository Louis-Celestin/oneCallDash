<?php

namespace App\Http\Controllers\statistique;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\statistique\PdfController;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class RecapController extends Controller
{
    public function recap_gare(Request $request)
    {
        $req = DB::table('bagage')
            ->join('gare', 'bagage.gare_id', 'gare.id')
            ->leftJoin('remises', 'bagage.id', 'remises.bagage_id')
            //  ->where('bagage.gare_id', Auth::user()->gare_id)
            ->where('gare.compagnie_id', Auth::user()->compagnie_id);

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
        if (!empty($request->bagage_id)) {
            $req->where('is_fret', $request->bagage_id);
            if ($request->bagage_id == 0)
                session(['type_bagage' => 'BAGAGE']);
            else
                session(['type_bagage' => 'FRET']);
        }
        if (empty($request->bagage_id)) {
            $req->whereDate('is_fret', 0);
            session(['type_bagage' => 'BAGAGE']);
        }

        $rapportGares = $req->where('bagage.is_solded', 1)->select('gare.nom_gare', DB::raw('count(bagage.id) as qte_impression'), DB::raw('sum(bagage.nbr_de_bagage) as qte_bagage'), DB::raw('sum(bagage.prix) as prix'), DB::raw('sum(remises.montant) as montant_remises'))->groupBy('nom_gare')->get();

        $data = [
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
            'rapportGare' => $rapportGares,
        ];
        session(['rapportGares' => $rapportGares]);
        return view('statistique.recap-gare', $data);
    }


    public function recap_agent(Request $request)
    {
        $req = DB::table('bagage')
            ->join('gare', 'bagage.gare_id', 'gare.id')
            ->join('users', 'bagage.users_id', 'users.id')
            ->leftJoin('remises', 'bagage.id', 'remises.bagage_id')
            //  ->where('bagage.gare_id', Auth::user()->gare_id)
            ->where('gare.compagnie_id', Auth::user()->compagnie_id);

        //dd($req->get());
        if (!empty($request->gare_id)) {
            // dd( $request->gare_id);
            $req->where('bagage.gare_id', $request->gare_id);
            $nomgare  = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', $request->gare_id)->get('nom_gare');

            session(['nomgare' => $nomgare[0]->nom_gare]);
        }
        if (empty($request->gare_id)) {
            session(['nomgare' => 'Toutes les gares']);
        }
        if (empty($request->start) && empty($request->end)) {
            $req->whereDate('bagage.created_at', '>=', date('Y-m-d'));
            session(['start' => date('Y-m-d')]);
            session(['end' => date('Y-m-d')]);
        }
        if (!empty($request->start)) {
            $req->where('bagage.created_at', '>=', $request->start);
            session(['start' => $request->start]);
        }
        if (!empty($request->end)) {
            $req->where('bagage.created_at', '<=', $request->end);
            session(['end' => $request->end]);
        }
        $rapportGares = $req->where('bagage.is_solded', 1)->select('users.name', DB::raw('count(bagage.id) as qte_impression'), DB::raw('sum(bagage.nbr_de_bagage) as qte_bagage'), DB::raw('sum(bagage.prix) as prix'), DB::raw('sum(remises.montant) as montant_remises'))->groupBy('users.name')->get();

        $data = [
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
            'rapportGare' => $rapportGares,
        ];
        //  dd($rapportGares);
        session(['rapportGares' => $rapportGares]);

        // PdfController::index($data);
        return view('statistique.recap-agent', $data);
    }


    public function recap_vehicule(Request $request)
    {

        //dd($request->all());
        $req  = DB::table('bagage')
            ->join('vehicule', 'bagage.immatriculationCar', 'vehicule.numero_vehicule')
            ->where('bagage.compagnie_id', Auth::user()->compagnie_id);




        if (empty($request->start) && empty($request->end)) {
            $req->whereDate('bagage.created_at', '>=', date('Y-m-d'));
            //   dd($req->get());
            session(['start' => date('Y-m-d')]);
            session(['end' => date('Y-m-d')]);
        }



        if (!empty($request->start)) {

            $req->where('bagage.created_at', '>=', $request->start);
            session(['start' => $request->start]);
        }
        if (!empty($request->end)) {

            $req->where('bagage.created_at', '<=', $request->end);
            session(['end' => $request->end]);
        }

        // dd(($request->bagage_id));

        if (!empty($request->bagage_id)) {
            // dd('hj');
            if ($request->bagage_id == "Fret") {
                $req->where('bagage.is_fret', 1);

                session(['bagage_fret' => 'Fret']);
            } else {

                $req->where('bagage.is_fret', 0);
                session(['bagage_fret' => 'Bagage']);
            }
        }


        if (empty($request->bagage_id)) {


            $req->where('bagage.is_fret', 1);

            session(['bagage_fret' => 'Fret']);
        }
        if (!empty($request->vehicule_id)) {

            $req->where('vehicule.id', $request->vehicule_id);
        }
        //      dd($req);

        $rapportGares =   $req->where('bagage.is_solded', 1)->select('vehicule.nom_vehicule as NOM_DU_VEHICULE',  DB::raw('vehicule.numero_vehicule'), DB::raw('sum(bagage.prix) as PRIX_TOTAL_BAGAGE'), DB::raw('sum(nbr_de_bagage) as NOMBRE_TOTAL_BAGAGE'))->groupBy('vehicule.nom_vehicule', 'vehicule.numero_vehicule')->get();

        $data = [
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
            'rapportGare' => $rapportGares,


        ];
        session(['rapportGares' => $rapportGares]);
        return view('statistique.recap_bagage_fret_by_vehicule', $data);
    }

    public function Colis_recap_gare(Request $request)
    {

        if (!empty($request->start) && !empty($request->end) && !empty($request->gare_id)) {
            $req = DB::table('colis')
                ->join('gare', 'colis.gare_id_envoi', 'gare.id')
                ->join('users', 'colis.users_id', 'users.id')
                ->whereDate('colis.created_at', '>=', $request->start)
                ->whereDate('colis.created_at', '<=', $request->end)
                ->where('colis.compagnie_id', Auth::user()->compagnie_id)
                ->where('gare.id', $request->gare_id);
            $r = $req->select('colis.gare_id_envoi as id', 'gare.nom_gare', 'users.name', DB::raw('count(colis.id) as qte_impression'), DB::raw('sum(colis.nbre_colis) as qte_colis'), DB::raw('sum(colis.prix) as prix'))->groupBy('colis.gare_id_envoi', 'gare.nom_gare', 'users.name')->get();
        } else {
            $r = [];
        }
        $data = [
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
            'stat_colis' => $r
        ];

        return view('statistique.colis.recap_gare', $data);
    }

    public function Colis_recap_agent(Request $request)
    {
        if (!empty($request->start) && !empty($request->end) && !empty($request->gare_id) && !empty($request->users_id)) {
            $req = DB::table('colis')
                ->join('gare', 'colis.gare_id_envoi', 'gare.id')
                ->join('users', 'colis.users_id', 'users.id')
                ->whereDate('colis.created_at', '>=', $request->start)
                ->whereDate('colis.created_at', '<=', $request->end)
                ->where('colis.compagnie_id', Auth::user()->compagnie_id)
                ->where('gare.id', $request->gare_id)
                ->where('users.id', $request->users_id);
            $r = $req->select('colis.gare_id_envoi as id', 'gare.nom_gare', 'users.name', DB::raw('count(colis.id) as qte_impression'), DB::raw('sum(colis.nbre_colis) as qte_colis'), DB::raw('sum(colis.prix) as prix'))->groupBy('colis.gare_id_envoi', 'gare.nom_gare', 'users.name')->get();
        } else {
            $r = [];
        }

        $data = [
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
            'agents' => DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', $request->users_id)->get('name'),
            'stat_colis' => $r
        ];
        return view('statistique.colis.recap-agent', $data);
    }

    public function Tickets_recap_gare(Request $request)
    {

        if (!empty($request->start) && !empty($request->end) && !empty($request->gare_id)) {
            $req = DB::table('ticket')
                ->join('gare', 'ticket.gare_id', 'gare.id')
                ->join('users', 'ticket.users_id', 'users.id')
                ->whereDate('ticket.created_at', '>=', $request->start)
                ->whereDate('ticket.created_at', '<=', $request->end)
                ->where('ticket.compagnie_id', Auth::user()->compagnie_id)
                ->where('gare.id', $request->gare_id);
            $r = $req->select('ticket.gare_id as id', 'gare.nom_gare', 'users.name', DB::raw('count(ticket.id) as qte_impression'), DB::raw('sum(ticket.nbre_tickets) as qte_tickets'), DB::raw('sum(ticket.prix) as prix'))->groupBy('ticket.gare_id', 'gare.nom_gare', 'users.name')->get();
        } else {
            $r = [];
        }


        $data = [
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
            'stat_tickets' => $r
        ];
        return view('statistique.tickets.recap-gare', $data);
    }

    public function Tickets_recap_agent(Request $request)
    {

        if (!empty($request->start) && !empty($request->end) && !empty($request->gare_id) && !empty($request->users_id)) {
            $req = DB::table('ticket')
                ->join('gare', 'ticket.gare_id', 'gare.id')
                ->join('users', 'ticket.users_id', 'users.id')
                ->whereDate('ticket.created_at', '>=', $request->start)
                ->whereDate('ticket.created_at', '<=', $request->end)
                ->where('ticket.compagnie_id', Auth::user()->compagnie_id)
                ->where('gare.id', $request->gare_id)
                ->where('ticket.users_id', $request->users_id);
            $r = $req->select('ticket.gare_id as id', 'gare.nom_gare', 'users.name', DB::raw('count(ticket.id) as qte_impression'), DB::raw('sum(ticket.nbre_tickets ) as qte_tickets'), DB::raw('sum(ticket.prix) as prix'))->groupBy('ticket.gare_id', 'gare.nom_gare', 'users.name')->get();
        } else {
            $r = [];
        }

        $data = [
            'gares' => DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get(),
            'stat_tickets' => $r

        ];
        return view('statistique.tickets.recap-agent', $data);
    }
}