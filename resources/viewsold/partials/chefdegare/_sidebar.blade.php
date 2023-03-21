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
    <a href="{{route('dashboard')}}" class="brand-link">
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
    <div class="sidebar">
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
            <a href="{{route('dashboard-chefdegare')}}" class="nav-link {{Route::current()->uri == "Tableau-de-bord-gare" ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Tableau de bord
              </p>
            </a>
          </li>
          @if(Auth::user()->usertype == "chefgare")
            <li class="nav-item">
              <a href="{{route('report')}}" class="nav-link {{Route::current()->uri == "activités" || substr(Route::current()->uri, 0, strlen("rapports-detaillé-par-gare")) == "rapports-detaillé-par-gare" ? 'active' : ''}}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Rapport d'activités
                </p>
              </a>
            </li>
            
          <li class="nav-item">
            <a href="#" class="nav-link {{ ( Route::current()->uri == "colis-egare" || Route::current()->uri == "rapport-colis" || Route::current()->uri == "vue-ensemble-colis" || substr(Route::current()->uri, 0, strlen("activites-colis")) == "activites-colis" || Route::current()->uri == "apport-colis") ? "active" : ""}}">
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
              <li class="nav-item">
               
                  <a href="{{route('colis-egare')}}" class="nav-link {{Route::current()->uri == "rapport-colis" || substr(Route::current()->uri, 0, strlen("colis-egare")) == "colis-egare" ? 'active' : ''}}">
                  &nbsp; &nbsp; &nbsp; <i class="fa fa-bus nav-icon"></i>
                  <p>Colis égaré</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
         {{--  <li class="nav-item">
            <a href="{{route('informations-bagage-payes')}}" class="nav-link {{Route::current()->uri == "informations-bagage-payes" ? 'active' : ''}}">
              <i class="nav-icon fas fa-eye"></i>
              <p>
                Gestions des tickets
              </p>
            </a>
          </li>--}}

          <li class="nav-item">
            <a href="#" class="nav-link {{ ( Route::current()->uri == "informations-bagage-payes" || Route::current()->uri == "rapport-colis" || Route::current()->uri == "vue-ensemble-colis" || substr(Route::current()->uri, 0, strlen("activites-colis")) == "activites-colis" || Route::current()->uri == "apport-colis") ? "active" : ""}}">
              <i class="nav-icon fas fa-eye"></i>
              <p>
                Gestions des tickets
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('informations-bagage-payes')}}" class="nav-link {{Route::current()->uri == "informations-bagage-payes" ? 'active' : ''}}">
                  &nbsp; &nbsp; &nbsp; <i class="fa fas fa-eye"></i>
                  <p> Gestions des tickets</p>
                </a>
              </li>
              <li class="nav-item">
                {{-- <a href="{{route('rapport-colis')}}" class="nav-link {{Route::current()->uri == "rapport-colis" ? 'active' : ''}}"> --}}
                  <a href="{{route('informations-bagage-impayes')}}" class="nav-link {{Route::current()->uri == "informations-bagage-impayes" ? 'active' : ''}}">
                  &nbsp; &nbsp; &nbsp; <i class="fa fa-user-tie nav-icon"></i>
                  <p>Tickets Impayés</p>
                </a>
              </li>
             
            </ul>
          </li>




























          <li class="nav-item">
            <a href="{{route('rapport-journalier-caissiere')}}" class="nav-link {{Route::current()->uri == "rapport-journalier-caissiere" ? 'active' : ''}}">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Rapport Journalier
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('fiche-suiveuse-index')}}" class="nav-link {{Route::current()->uri == "fiche-suiveuse" ? 'active' : ''}}">
              <i class="nav-icon fas fa-bus"></i>
              <p>
                Fiche suiveuse
              </p>
            </a>
          </li>
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