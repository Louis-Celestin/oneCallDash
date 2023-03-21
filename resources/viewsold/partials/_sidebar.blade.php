<!-------------------------------------Start Y2R------------------------->

<style>
  .nav-link{color: #ffffff !important; }
  .nav-item a p {color:#fff
  ; }

  .nav-link.active p
  {
    color: black!important;
  }

  .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    background-color: #0b60b2;
    color: black!important;
  }
</style>

<aside class="main-sidebar elevation-1" style="background:  rgb(6 6 8);">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link m-0 p-0">
      <img src="{{asset('dist/img/logo_avs.jpg')}}" alt="OCL Logo" class="brand-image" style="max-height: 61px; width: 225px; object-fit: cover;">
      {{-- <span class="brand-text font-weight-light">AVS TRANSPORT</span> --}}
    </a>
<!-------------------------------------End Y2R------------------------->

{{-- <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
      <img src="{{asset('dist/img/logo.png')}}" alt="OCL Logo" class="brand-image" >
      <span class="brand-text font-weight-light">TRANSPORS TAVS</span>
    </a> --}}

    <!-- Sidebar -->
    <div class="sidebar mt-5">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-5 pb-3 mb-3 d-flex justify-content-center">
        <div class="info">
          <a href="#" class="d-block text-center">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link {{Route::current()->uri == "/" ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Tableau de bord
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('report')}}" class="nav-link {{Route::current()->uri == "activités" || substr(Route::current()->uri, 0, strlen("rapports-detaillé-par-gare")) == "rapports-detaillé-par-gare" ? 'active' : ''}}">
              <i class="nav-icon fas fa-eye"></i>
              <p>
                Rapport d'activités
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('informations-bagage-payes')}}" class="nav-link {{Route::current()->uri == "informations-bagage-payes" ? 'active' : ''}}">
              <i class="nav-icon fas fa-route"></i>
              <p>
                Gestions des tickets
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link {{ (Route::current()->uri == "rapport-colis" || Route::current()->uri == "vue-ensemble-colis" || substr(Route::current()->uri, 0, strlen("activites-colis")) == "activites-colis" || Route::current()->uri == "apport-colis") ? "active" : ""}}">
              <i class="nav-icon fa fa-layer-group"></i>
              <p>
                Gestion des Colis
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('vue-ensemble-colis')}}" class="nav-link {{Route::current()->uri == "vue-ensemble-colis" ? 'active' : ''}}">
                  &nbsp; &nbsp; &nbsp; <i class="fa fa-chart-pie nav-icon"></i>
                  <p>Vue d'ensemle</p>
                </a>
              </li>
              <li class="nav-item">
                {{-- <a href="{{route('rapport-colis')}}" class="nav-link {{Route::current()->uri == "rapport-colis" ? 'active' : ''}}"> --}}
                  <a href="{{route('activites-colis', ['gare_id' => '*', 'statut' => 'All', "date" => date('Y-m-d')])}}" class="nav-link {{Route::current()->uri == "rapport-colis" || substr(Route::current()->uri, 0, strlen("activites-colis")) == "activites-colis" ? 'active' : ''}}">
                  &nbsp; &nbsp; &nbsp; <i class="fa fa-user-tie nav-icon"></i>
                  <p>Rapports d'activités</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('tickets-impayes')}}" class="nav-link {{Route::current()->uri == "tickets-impayes" || substr(Route::current()->uri, 0, strlen("rapport-filtre-solded")) == "rapport-filtre-solded"  ? 'active' : ''}}">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                Rapport Impayés
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('demandes-de-remises')}}" class="nav-link {{ Route::current()->uri == "gestion-de-remise" ? "active" : ""}}">
              <i class="nav-icon fa fa-percent"></i>
              <p>
                Gestion des rémises 
              </p>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a href="{{route('ocl-soldes')}}" class="nav-link {{ Route::current()->uri == "nos-factures" || Route::current()->uri == "ocl-soldes" ? "active" : ""}}">
              <i class="nav-icon fa fa-receipt"></i>
              <p>
                Soldes & Factures 
              </p>
            </a>
          </li> --}}

          <li class="nav-item">
            <a href="#" class="nav-link {{ (Route::current()->uri == "ocl-soldes" || Route::current()->uri == "nos-factures") ? "active" : ""}}">
              <i class="nav-icon fa fa-coins"></i>
              <p>
                Soldes & Factures
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('ocl-soldes')}}" class="nav-link {{Route::current()->uri == "ocl-soldes" ? 'active' : ''}}">
                  &nbsp; &nbsp; &nbsp; <i class="fa fa-user-tie nav-icon"></i>
                  <p>Soldes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('nos-factures')}}" class="nav-link {{Route::current()->uri == "nos-factures" ? 'active' : ''}}">
                  &nbsp; &nbsp; &nbsp; <i class="fa fa-boxes nav-icon"></i>
                  <p>Factures</p>
                </a>
              </li>
            </ul>
          </li>

          

          {{-- <li class="nav-item">
            <a href="#" class="">
              <i class="nav-icon fas fa-receipt"></i>
              <p>
                Comptabilité
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">3</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('ocl-soldes')}}" class="nav-link {{ Route::current()->uri == "ocl-soldes" ? "active" : ""}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('nos-factures')}}" class="nav-link {{ Route::current()->uri == "nos-factures" ? "active" : ""}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Factures</p>
                </a>
              </li>
            </ul>
          </li> --}}
          @if (Auth::user()->usertype == "admin")
            <li class="nav-item">
              <a href="#" class="nav-link {{ Route::current()->uri == "nos-vehicules" || Route::current()->uri == "nos-conducteurs" || Route::current()->uri == "nos-departs" ? "active" : ""}}">
                <i class="nav-icon fa fa-tools"></i>
                <p>
                  Configuration
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('user-lists')}}" class="nav-link {{Route::current()->uri == "user-lists" ? 'active' : ''}}">
                    &nbsp; &nbsp; &nbsp; <i class="fa fa-user-tie nav-icon"></i>
                    <p>Utilisateurs</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('gares-lists')}}" class="nav-link {{Route::current()->uri == "gares-lists" ? 'active' : ''}}">
                    &nbsp; &nbsp; &nbsp; <i class="fa fa-boxes nav-icon"></i>
                    <p>Gares</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('tarif-bagages-lists')}}" class="nav-link {{ Route::current()->uri == "tarification-bagages" ? "active" : ""}}">
                    &nbsp; &nbsp; &nbsp; <i class="nav-icon fa fa-dollar-sign"></i>
                    <p>
                      Tarification
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('nos-vehicules')}}" class="nav-link {{ Route::current()->uri == "nos-vehicules" ? "active" : ""}}">
                    &nbsp; &nbsp; &nbsp; <i class="fa fa-bus nav-icon"></i>
                    <p>Nos Véhicules</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('nos-conducteurs')}}" class="nav-link {{ Route::current()->uri == "nos-conducteurs" ? "active" : ""}}">
                    &nbsp; &nbsp; &nbsp; <i class="fa fa-user-tie nav-icon"></i>
                    <p>Nos Chauffeurs</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('ours-departs')}}" class="nav-link {{ Route::current()->uri == "nos-departs" ? "active" : ""}}">
                    &nbsp; &nbsp; &nbsp; <i class="fa fa-road nav-icon"></i>
                    <p>Départs</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('souscribers')}}" class="nav-link {{ Route::current()->uri == "souscrire" ? "active" : ""}}">
                    &nbsp; &nbsp; &nbsp; <i class="fa fa-star nav-icon"></i>
                    <p>Souscription</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          <li class="nav-item">
            <a href="{{route('logout')}}" class="nav-link">
              <i class="nav-icon fa fa-door-open"></i>
              <p>
                Déconnexion
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>