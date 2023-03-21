 <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\GareController;
    use App\Http\Controllers\BagageController;
    use App\Http\Controllers\LoginController;


    /*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::get('/login', function () {
        return view('login');
    })->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('check-login');
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('login');
    })->name('logout');



    Route::middleware([auth::class])->group(function () {

        Route::get('/', [Controllers\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/activités', [Controllers\RapportController::class, 'index'])->name('report');
        Route::post('/activités', [Controllers\RapportController::class, 'filtre'])->name('filtre');

        // User Routes
        Route::get('/user-lists', [UserController::class, 'getUsers'])->name('user-lists');
        Route::post('/user-lists', [UserController::class, 'store'])->name('add-user');
        Route::put('/user-lists', [UserController::class, 'update'])->name('update-user');
        Route::delete('/user-lists/{id}', [UserController::class, 'delete'])->name('destroy-user');


        // Gare routes
        Route::get('/gares-lists', [gareController::class, 'getGares'])->name('gares-lists');
        Route::get('/edit-gare/{id}', [gareController::class, 'show'])->name('edit-gare');
        Route::put('/update-gare', [gareController::class, 'update'])->name('update-gare');
        Route::get('/rapports-detaillé-par-gare/{id}/{user_id}/{debut}/{fin}', [gareController::class, 'showReports'])->name('gare-reports');
        Route::post('/add-gare', [gareController::class, 'storeGare'])->name('storeGare');

        // Tarification Routes
        Route::get('/tarification-bagages', [Controllers\BagageTarifController::class, 'index'])->name('tarif-bagages-lists');
        Route::post('/tarification-bagages', [Controllers\BagageTarifController::class, 'store'])->name('add-tarif-bagages');
        Route::put('/tarification-bagages', [Controllers\BagageTarifController::class, 'update'])->name('update-tarif-bagages');
        Route::delete('/tarification-bagages/{id}', [Controllers\BagageTarifController::class, 'destroy'])->name('delete-tarif-bagages');

        // Gestion de rémises
        Route::get('/gestion-de-remise', [Controllers\RemiseController::class, 'index'])->name('demandes-de-remises');
        Route::post('/gestion-de-remise', [Controllers\RemiseController::class, 'filtre'])->name('filtre-remises');
        Route::post('/remises-lists/{id}', [Controllers\RemiseController::class, 'acceptRemise'])->name('accepter-remises');
        Route::put('/remises-lists/{id}', [Controllers\RemiseController::class, 'modifierRemise'])->name('modifier-remises');

        // Factures Routes
        Route::get('/nos-factures', [Controllers\InvoiceController::class, 'index'])->name('nos-factures');

        // Comptabilité
        Route::get('/account-lists', [UserController::class, 'getUsers'])->name('d');

        // Solde Facturation
        Route::get('/invoice-solde-lists', [UserController::class, 'getUsers'])->name('d');

        // Comptablité
        Route::get('/ocl-soldes', [Controllers\InvoiceController::class, 'index'])->name('ocl-soldes');

        Route::get('/tickets-impayes', [Controllers\TicketImpayeController::class, 'index'])->name('tickets-impayes');
        Route::get('/rapport-filtre-solded/{is_solded}/{is_fret}', [Controllers\TicketImpayeController::class, 'rapportFiltreSoldedIndex'])->name('rapport-tickets-impayes');
        Route::post('/rapport-filtre-solded', [Controllers\TicketImpayeController::class, 'filtreImpayepart'])->name('filtreImpayepart');

        // Ticket impayées et Payées
        Route::get('/Tableau-de-bord-gare', [Controllers\chefdegare\DashboardController::class, 'index'])->name('dashboard-chefdegare')->middleware('chefdegareetcaissiere');
        Route::get('/listes-des-tickets-bagages-et-frets', [Controllers\TicketBagageController::class, 'index'])->name('lists-tickets')->middleware('chefdegareetcaissiere');
        Route::put('/update-ticket-bagage/{id}', [Controllers\TicketBagageController::class, 'UpdateTicketBagage'])->name('update-ticket-bagage')->middleware('chefdegareetcaissiere');
        Route::get('/informations-bagage-payes', [Controllers\TicketBagageController::class, 'InfoBagage'])->name('informations-bagage-payes')->middleware('chefdegareetcaissiere');
        Route::get('/informations-bagage/{statut}', [Controllers\TicketBagageController::class, 'BagageImpayes'])->name('informations-bagage-impayes')->middleware('chefdegareetcaissiere');
        Route::post('/informations-bagage/{statut}', [Controllers\TicketBagageController::class, 'BagageImpayes'])->name('informations-bagage-impayes-post')->middleware('chefdegareetcaissiere');
        Route::post('/search-bagage', [Controllers\TicketBagageController::class, 'SearchBagage'])->name('search-ticket-bagage')->middleware('chefdegareetcaissiere');
        Route::get('vue-ensemble-bagage', [Controllers\chefdegare\RapportController::class, 'apercu'])->name('vue-ensemble-bagage');

        // Frais de route
        Route::get('/frais-de-route', [Controllers\FraisDeRouteController::class, 'index'])->name('frais-de-route');
        Route::post('/frais-de-route', [Controllers\FraisDeRouteController::class, 'search'])->name('search-frais-de-route');


        // Fiche Suiveuse
        Route::get('/rapport-journalier-caissiere', [Controllers\chefdegare\RapportController::class, 'index'])->name('rapport-journalier-caissiere')->middleware('chefdegareetcaissiere');
        Route::post('/rapport-journalier-caissiere', [Controllers\chefdegare\RapportController::class, 'search'])->name('search-rapport-caissiere')->middleware('chefdegareetcaissiere');



        // Rapport Colis
        Route::get('/rapport-colis', [Controllers\RapportColisController::class, 'index'])->name('rapport-colis');
        Route::get('/vue-ensemble-colis', [Controllers\RapportColisController::class, 'apercu'])->name('vue-ensemble-colis');
        Route::get('/activites-colis/{gare_id}/{statut}/{users_id}/{date}', [Controllers\RapportColisController::class, 'details_colis'])->name('activites-colis');
        //Route::get('/activites-colis/{date}', [Controllers\RapportColisNewController::class, 'details_colis'])->name('activites-colis');
        Route::get('/activites-colis-gare/{gare_id}/{statut}/{users_id}/{date}', [Controllers\RapportColisController::class, 'details_colis_gare'])->name('activites-colis-gare');

        Route::post('/rapport-colis', [Controllers\RapportColisController::class, 'search'])->name('rapport-colis-search');
        Route::post('/rapport-colis-gare', [Controllers\RapportColisController::class, 'search_gare'])->name('rapport-colis-search-gare');

        Route::get('/rapport-commission-colis', [Controllers\RapportColisController::class, 'commission_index'])->name('rapport-commission-colis');

        Route::get('/colis-egare/{type}', [Controllers\RapportColisController::class, 'colis_egare'])->name('colis-egare');

        // Rapport Journalier Caissière ou chef de gare
        Route::get('/fiche-suiveuse', [Controllers\chefdegare\FicheSuiveuseController::class, 'index'])->name('fiche-suiveuse-index')->middleware('chefdegareetcaissiere');
        Route::post('/fiche-suiveuse', [Controllers\chefdegare\FicheSuiveuseController::class, 'search'])->name('fiche-suiveuse-search')->middleware('chefdegareetcaissiere');



        // Nos Departs
        Route::get('/nos-departs', [Controllers\DepartController::class, 'index'])->name('ours-departs');
        Route::post('/nos-departs', [Controllers\DepartController::class, 'store'])->name('save-departs');

        // Gérer les véhicules
        Route::get('/nos-vehicules', [Controllers\VehiculeController::class, 'index'])->name('nos-vehicules');
        Route::post('/nos-vehicules', [Controllers\VehiculeController::class, 'store'])->name('add-vehicules');
        Route::put('/nos-vehicules', [Controllers\VehiculeController::class, 'update'])->name('update-vehicules');
        Route::delete('/nos-vehicules/{id}', [Controllers\VehiculeController::class, 'destroy'])->name('delete-vehicules');

        // Gérer les conducteurs
        Route::get('/nos-conducteurs', [Controllers\ConducteurController::class, 'index'])->name('nos-conducteurs');
        Route::post('/nos-conducteurs', [Controllers\ConducteurController::class, 'store'])->name('add-conducteurs');
        Route::put('/nos-conducteurs', [Controllers\ConducteurController::class, 'update'])->name('update-conducteurs');
        Route::delete('/nos-conducteurs/{id}', [Controllers\ConducteurController::class, 'destroy'])->name('delete-conducteurs');


        // Souscription
        Route::get('/souscrire', [Controllers\EnrollementController::class, 'index'])->name('souscribers');
        Route::post('/souscrire', [Controllers\EnrollementController::class, 'store'])->name('souscribe');


        /*******************Module Ticket************************* */

        Route::get('vue-ensemble-ticket', [Controllers\Ticket\RapportTicketController::class, 'apercu'])->name('vue-ensemble-ticket');
        Route::get('/activités-ticket', [Controllers\Ticket\RapportTicketController::class, 'rapport_ticket'])->name('report-ticket');
        Route::post('/activités-ticket', [Controllers\Ticket\RapportTicketController::class, 'filtre'])->name('filtre-ticket');

        Route::get('/activité-ticket-mensuel', [Controllers\Ticket\RapportTicketController::class, 'rapport_ticket_mensuel'])->name('report-ticket-mensuel');
        Route::post('/activité-ticket-mensuel', [Controllers\Ticket\RapportTicketController::class, 'filtre'])->name('filtre-ticket-mensuel');
        /*******************Module Ticket************************* */


        /*************************Statistique************** */

        Route::prefix('statistique')->name('stat.')->group(function () {

            Route::get('/general', [Controllers\statistique\generalController::class, 'Stat_general'])->name('general');
            Route::get('/Impression/ticket/bagage', [Controllers\statistique\PdfController::class, 'ImpressionTicket'])->name('Info_bagage_payes');

            Route::get('/get_user_by_gare', [Controllers\statistique\generalController::class, 'agent'])->name('get_user_by_gare');
            Route::get('/get_vehicule_by_bagage', [Controllers\statistique\generalController::class, 'vehicule'])->name('get_vehicule_by_bagage');
            Route::post('/post_general', [Controllers\statistique\generalController::class, 'Stat_general'])->name('post_general');
            Route::get('/globale', [Controllers\statistique\generalController::class, 'Globale'])->name('globale');
            Route::post('/globale', [Controllers\statistique\generalController::class, 'Globale'])->name('post_globale');
            Route::get('/journalier', [Controllers\statistique\generalController::class, 'journalier'])->name('get_journalier');
            Route::post('/post_journalier', [Controllers\statistique\generalController::class, 'journalier'])->name('post_journalier');
            Route::get('recap/gare', [Controllers\statistique\RecapController::class, 'recap_gare'])->name('recap_gare');
            Route::get('recap/vehicule', [Controllers\statistique\RecapController::class, 'recap_vehicule'])->name('recap_vehicule');
            Route::post('recap/vehicule', [Controllers\statistique\RecapController::class, 'recap_vehicule'])->name('post_recap_vehicule');
            Route::post('recap/gare', [Controllers\statistique\RecapController::class, 'recap_gare'])->name('post_recap_gare');
            Route::get('recap/agent', [Controllers\statistique\RecapController::class, 'recap_agent'])->name('recap_agent');
            Route::post('recap/agent', [Controllers\statistique\RecapController::class, 'recap_agent'])->name('post_recap_agent');
            Route::get('pdf/recap/agent', [Controllers\statistique\PdfController::class, 'pdf_recap_by_agent'])->name('pdf_recap_by_agent');
            Route::get('pdf/recap/gare', [Controllers\statistique\PdfController::class, 'pdf_recap_by_gare'])->name('pdf_recap_by_gare');
            Route::get('pdf/recap/journalier', [Controllers\statistique\PdfController::class, 'pdf_recap_by_journalier'])->name('pdf_recap_journalier');
            Route::get('pdf/recap/general', [Controllers\statistique\PdfController::class, 'pdf_recap_by_general'])->name('pdf_recap_by_general');

            Route::get('/statistique/client', [Controllers\statistique\statclientController::class, 'get_stat_client'])->name('get_stat_client');
            Route::post('/statistique/client', [Controllers\statistique\statclientController::class, 'get_stat_client'])->name('post_stat_client');
            Route::get('pdf/recap/client', [Controllers\statistique\PdfController::class, 'pdf_stat_client'])->name('pdf_stat_client');
            Route::get('pdf/recap/vehicule', [Controllers\statistique\PdfController::class, 'pdf_stat_vehicule'])->name('pdf_stat_vehicule');
            Route::get('pdf/ticket', [Controllers\statistique\PdfController::class, 'pdf_ticket'])->name('pdf_ticket');


            // Routes de colis pour les statistiques
            // General Colis

            Route::get('/colis/general', [Controllers\statistique\generalController::class, 'Stat_colis_general'])->name('colis_general');
            Route::post('/colis/post/general', [Controllers\statistique\generalController::class, 'Stat_colis_general'])->name('colis_post_general');
            Route::get('/colis/pdf/general', [Controllers\statistique\PdfController::class, 'pdf_recap_colis_by_general'])->name('pdf_recap_colis_post_general');
            // Globale colis

            Route::get('/colis/globale', [Controllers\statistique\generalController::class, 'Stat_colis_globale'])->name('colis_globale');
            Route::post('/colis/post/globale', [Controllers\statistique\generalController::class, 'Stat_colis_globale'])->name('colis_post_globale');

            // Journalier Colis
            Route::get('/colis/journalier', [Controllers\statistique\generalController::class, 'Stat_colis_journalier'])->name('colis_journalier');
            Route::post('/colis/post/journalier', [Controllers\statistique\generalController::class, 'Stat_colis_journalier'])->name('colis_post_journlier');

            Route::get('/colis/recap/gare', [Controllers\statistique\RecapController::class, 'Colis_recap_gare'])->name('colis_recap_gare');
            Route::post('/colis/post/recap/gare', [Controllers\statistique\RecapController::class, 'Colis_recap_gare'])->name('post_colis_recap_gare');

            Route::get('/colis/recap/agent', [Controllers\statistique\RecapController::class, 'Colis_recap_agent'])->name('colis_recap-agent');
            Route::post('/colis/post/recap/agent', [Controllers\statistique\RecapController::class, 'Colis_recap_agent'])->name('post_colis_recap_agent');


            // Route de tickets pour les statistiques

            // General tickets
            Route::get('/ticket/general', [Controllers\statistique\generalController::class, 'Stat_tickets_general'])->name('ticket_general');
            Route::post('/ticket/post/general', [Controllers\statistique\generalController::class, 'Stat_tickets_general'])->name('tickets_post_general');
            // Globale tickets

            Route::post('/ticket/post/globale', [Controllers\statistique\generalController::class, 'Stat_tickets_globale'])->name('tickets_post_globale');
            Route::get('/ticket/globale', [Controllers\statistique\generalController::class, 'Stat_tickets_globale'])->name('ticket_globale');

            // Recap par gare tickets
            Route::get('/tickets/recap/gare', [Controllers\statistique\RecapController::class, 'Tickets_recap_gare'])->name('tickets_recap-gare');
            Route::post('/tickets/post/recap/gare', [Controllers\statistique\RecapController::class, 'Tickets_recap_gare'])->name('post_tickets_recap_gare');

            // Journalier tickets
            Route::get('/tickets/journalier', [Controllers\statistique\generalController::class, 'Stat_tickets_journalier'])->name('tickets_journalier');
            Route::post('/tickets/post/journalier', [Controllers\statistique\generalController::class, 'Stat_tickets_journalier'])->name('tickets_post_journlier');

            // Recap agent tickets
            Route::get('/tickets/recap/agent', [Controllers\statistique\RecapController::class, 'Tickets_recap_agent'])->name('tickets_recap-agent');
            Route::post('/tickets/post/recap/agent', [Controllers\statistique\RecapController::class, 'Tickets_recap_agent'])->name('post_tickets_recap_agent');
        });
        /********************************************************* */


        Route::get('/reinitialiser-tout', function () {
            $html = "";
            dd("Bloqué");

            // dd(DB::table('remises')->where('compagnie_id', 21));
            // ÉFFACER TOUTES LES REMISES DE AVS
            if (DB::table('remises')->where('compagnie_id', 21)->delete()) {

                $html .= " <br/>";
                $html .= "Les rémises ont été éffacé !";
                $html .= " <br/>";
            } else {
                $html .= " <br/>";
                $html .= "Il y a plus rien dans les remises de avs.";
                $html .= " <br/>";
            }

            // ÉFFACER TOUTES BAGAGES DE AVS
            if (DB::table('bagage')->where('compagnie_id', 21)->delete()) {
                $html .= " <br/>";
                $html .= "Tous les bagages de AVS ont été éffacé !";
                $html .= " <br/>";
            } else {
                $html .= " <br/>";
                $html .= "Il y a plus rien dans les bagages Avs.";
                $html .= " <br/>";
            }

            // ÉFFACER TOUS LES SOLDES COMMISION DE AVS
            if (DB::table('soldes')->where('compagnie_id', 21)->delete()) {
                $html .= " <br/>";
                $html .= "Les soldes de avs ont été éffacé !";
                $html .= " <br/>";
            } else {
                $html .= " <br/>";
                $html .= "Il y a plus rien dans les soldes de avs (ont été éffacé !)";
                $html .= " <br/>";
            }

            // ÉFFACER TOUS LES factures de AVS
            if (DB::table('invoices')->where('compagnie', 21)->delete()) {
                $html .= " <br/>";
                $html .= "Toutes les factures ont été éffacé !";
                $html .= " <br/>";
            } else {
                $html .= " <br/>";
                $html .= "Il y a plus rien dans les factures de avs (ont été éffacé !).";
                $html .= " <br/>";
            }


            $html .= "<br/><br/><a href='https://avs.ocl.ci' style='text-align: center; margin: 30px; padding: 10px; background-color: #c34384; color: #FFF; border-radius:10px;'>Revenir au tableau de bord</a>";
            return $html;
        });


        Route::get('admin/profile', function () {
            //
        })->withoutMiddleware([CheckAge::class]);
    });




// Route::get('test', function () {
//     //
//     $bagages = DB::table('bagage')->where('compagnie_id', 21)
//     ->where('is_solded', 1)
//     // ->whereDate('created_at', '')
//     ->whereBetween('created_at', ['2022-11-14', '2022-12-1'])
//     ->select( DB::raw('DATE(created_at) as date'), DB::raw('sum(prix) as prix'))
//     ->groupBy('date')
//     ->get();

//     $soldes = DB::table('soldes')->where('compagnie_id', 21)
//     ->whereDate('module_id', 1)
//     ->whereBetween('created_at', ['2022-11-14', '2022-12-1'])
//     ->select( DB::raw('DATE(created_at) as date'), DB::raw('sum(montant) as montant'))
//     ->groupBy('date')
//     ->get();

//     // dd(date('Y-m-d'));
//     // dd($bagages->sum('prix') * 7 / 100);
//     // dd($bagages);
//     // dd($soldes);
//     return view('test', compact('bagages', 'soldes'));
// });

// Route::get('test2', function () {
//     //
//     $bagages = DB::table('bagage')->where('compagnie_id', 21)
//     ->where('is_solded', 1)
//     // ->whereDate('created_at', '')
//     ->whereBetween('created_at', ['2022-11-14', '2022-12-1'])
//     ->select( 'gare_id', DB::raw('sum(prix) as prix'))
//     ->groupBy('gare_id')
//     ->get();

//     $soldes = DB::table('soldes')->where('compagnie_id', 21)
//     ->whereDate('module_id', 1)
//     ->whereBetween('created_at', ['2022-11-14', '2022-12-1'])
//     ->select( 'gare_id', DB::raw('sum(montant) as montant'))
//     ->groupBy('gare_id')
//     ->get();


//     // dd(date('Y-m-d'));
//     // dd($bagages->sum('prix') * 7 / 100);
//     // dd($bagages);
//     // dd($soldes);
//     return view('test2', compact('bagages', 'soldes'));
// });

// Route::get('test3/{gare_id}', function ($gare_id) {
//     //
//     // dd($gare_id);
//     $bagages = DB::table('bagage')->where('compagnie_id', 21)
//     ->where('is_solded', 1)
//     ->where('gare_id', $gare_id)
//     // ->whereDate('created_at', '')
//     ->whereBetween('created_at', ['2022-11-14', '2022-12-1'])
//     ->select( DB::raw('DATE(created_at) as date'), DB::raw('sum(prix) as prix'))
//     ->groupBy('date')
//     ->get();

//     $soldes = DB::table('soldes')->where('compagnie_id', 21)
//     ->whereDate('module_id', 1)
//     ->where('gare_id', $gare_id)
//     ->whereBetween('created_at', ['2022-11-14', '2022-12-1'])
//     ->select(DB::raw('sum(id) as id'), DB::raw('DATE(created_at) as date'), DB::raw('sum(montant) as montant'))
//     ->groupBy('date')
//     ->get();

//     $gare = DB::table('gare')->where('id', $gare_id)->first();
//     // dd(date('Y-m-d'));
//     // dd($bagages->sum('prix') * 7 / 100);
//     // dd($bagages);
//     // dd($soldes);
//     return view('test3', compact('bagages', 'soldes', 'gare'));
// });