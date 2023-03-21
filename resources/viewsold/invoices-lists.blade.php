@extends('layouts.master')

@section('content')


@if (Route::current()->uri == "ocl-soldes")

<div class="card">
  <div class="card-header">
    <h3>Rapports Bagages & Frets</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-lg-4 col-4">
        <!-- small box -->
        <div class="small-box bg-danger" style="color: black !important;">
          <div class="inner">
            <h4>Bagages (FCFA)</h4>
            <h3 class="text-center">{{number_format($enregistrements->where('is_fret', 0)->where('is_solded', 1)->sum('prix'), 0, '', ' ')}}</h3>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          {{-- <a href="#" class="small-box-footer"> <i class="fas fa-money-bill"> </i> Montant total que vous devez à OCL</a> --}}
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-4">
        <!-- small box -->
        <div class="small-box bg-warning" style="color: black !important;">
          <div class="inner">
            <h4>Frets (FCFA)</h4>
            <h3 class="text-center">{{number_format($enregistrements->where('is_fret', 1)->where('is_solded', 1)->sum('prix'), 0, '', ' ')}}</h3>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          {{-- <a class="small-box-footer"><i class="fas fa-money-check"></i> Montant versé mais en attente de validation </a> --}}
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-4">
        <!-- small box -->
        <div class="small-box bg-success" style="color: black !important;">
          <div class="inner">
            <h4>Global (FCFA)</h4>
            <h3 class="text-center">{{number_format($enregistrements->where('is_solded', 1)->sum('prix'), 0, '', ' ')}}</h3>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          {{-- <a href="#" class="small-box-footer"><i class="fas fa-coins"></i> Montant réduit </a> --}}
        </div>
      </div>
      <!-- ./col -->
    </div>

  </div>
</div>
<div class="card">
  <div class="card-header">
    <h3>Commissions OCL</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-lg-6 col-12">
        <!-- small box -->
        <?php $commission_bagage_fret= (str_replace('%','', sprintf("%.0f%%", $enregistrements->where('is_solded', 1)->sum('prix') * 7/100) )); ?>
        <div class="small-box bg-danger" style="color: black !important;">
          <div class="inner">
            <h4>Impayées (FCFA)</h4>
            <h3 class="text-center">{{number_format($commission_bagage_fret  , 2, '.', ' ')}}</h3>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="#" class="small-box-footer text-muted" style="color: black !important;"> <i class="fas fa-money-bill"> </i> Montant total que vous devez à OCL</a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-6 col-12">
        <!-- small box -->
        <div class="small-box bg-warning " style="color: black !important;">
          <div class="inner">
            <h4>En attente (FCFA)</h4>
            <h3 class="text-center">{{number_format($soldes->where('statut', 'Waiting')->sum('montant'), 2, '.', ' ')}}</h3>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a class="small-box-footer text-muted" style="color: black !important;"><i class="fas fa-money-check"></i> Montant versé mais en attente de validation </a>
        </div>
      </div>
      <!-- ./col -->
      {{-- <div class="col-lg-4 col-4">
        <div class="small-box bg-success" style="color: black !important;">
          <div class="inner">
            <h4>Payées (FCFA)</h4>
            <h3 class="text-center">{{number_format($soldes->where('statut', 'Solded')->sum('montant'), 2, '.', ' ')}}</h3>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer text-muted" style="color: black !important;"><i class="fas fa-coins"></i> Montant réduit </a>
        </div>
      </div> --}}
    </div>

  </div>
</div>
@endif

@if (Route::current()->uri == "nos-factures" )
    
<div class="row my-5">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-center my-2">
          <h3 class="card-title">FACTURES OCL</h3>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>N° facture</th>
                <th>Gare</th>
                <th>Module</th>
                <th>Montant</th>
                <th>Période</th>
                <th class="text-center">Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($factures as $facture)
              <tr>
                  <td>#{{$facture->numero_facture}}</td>

                  <td>
                    @if ($gares->where('id', $facture->gare)->first() != null)
                      {{$gares->where('id', $facture->gare)->first()->nom_gare}}
                    @endif
                  </td>

                  <td>
                    @switch($facture->module)
                        @case(1)
                          {{"Bagage"}}
                          @break
                        @case(2)
                          {{"Colis"}}
                          @break
                        @case(3)
                          {{"Ticket"}}
                          @break
                        @default
                          {{"Inconnu"}}
                    @endswitch
                  </td>

                  <td>{{number_format($facture->montant, 2, '.', ' ')." FCFA"}}</td>

                  <td>
                      {{"Du ".date("d/m", strtotime($facture->debut))." au ". date("d/m/Y", strtotime($facture->fin))}}
                  </td>

                  <td>
                    @switch($facture->statut)
                        @case("Solded")
                          <div class="card btn text-success">Payées</div>
                          @break
                        @case("Unsolded")
                          <div class="card btn text-danger">
                            Impayées
                          </div>
                          @break
                        @case("Waiting")
                          <div class="d-flex justify-content-center">
                            <a class="btn btn-secondary">En attente</a>
                            <a 
                              href="{{"https://wa.me/2250767034178?text=Bonjour Onecall, je suis " .Auth::user()->name. ", et nous souhaitons procéder au paiement de la facture ".$facture->numero_facture.". Veuillez-nous contacter svp. \n Merci"}}" 
                              target="_blank" class="btn btn-success mx-2">
                              <i class="fab fa-whatsapp"> Contacter pour Payer</i>
                            </a>
                          </div>
                          @break
                        @case("Canceled")
                          <div class="card btn text-warning">
                            Annulée
                          </div>
                          @break
                        @default
                        {{$facture->statut}}
                    @endswitch
                  </td>
                  
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div>
@endif
{{-- 
<div class="row my-5">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-center my-2">
          <h3 class="card-title">Soldes par gare</h3>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>Gare</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($factures as $facture)
              <tr>

                  <td>
                    @if ($gares->where('id', $facture->gare)->first() != null)
                      {{$gares->where('id', $facture->gare)->first()->nom_gare}}
                    @endif
                  </td>

                  <td>{{number_format($facture->montant, 0, '', ' ')." FCFA"}}</td>

                  <td>
                      {{date("d/m", strtotime($facture->created_at))}}
                  </td>

                  <td>
                    @switch($facture->statut)
                        @case("Solded")
                          <div class="card btn text-success">Payées</div>
                          @break
                        @case("Unsolded")
                          <div class="card btn text-danger">
                            Impayées
                          </div>
                          @break
                        @case("Waiting")
                          <div class="card btn text-info">
                            En attente
                          </div>
                          @break
                        @case("Canceled")
                          <div class="card btn text-warning">
                            Annulée
                          </div>
                          @break
                        @default
                        {{$facture->statut}}
                    @endswitch
                  </td>
                  
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div> --}}


@endsection

@section('modal')
@endsection