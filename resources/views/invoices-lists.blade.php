@extends('layouts.master')

@section('content')


@if (Route::current()->uri == "ocl-soldes")


<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Soldes</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
            <li class="breadcrumb-item active">Soldes</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>


<div class="card">
    <div class="card-header">
      <h3>Rapports Bagages & Frets</h3>
    </div>
    <div class="card-body">



      <div class="row">

        <div class="col-sm-4 px-2">

                <div class="card card-zo">
                <br>
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <div class="icon-circle-70 bg-primary">
                        <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <h4 class="font-weight:bold">BAGAGE (FCFA)</h4>
                        <h3 >{{number_format($enregistrements->where('is_fret', 0)->where('is_solded', 1)->where('statut_payement_ocl','!=','payes')->sum('prix'), 0, '', ' ')}}</h3>
                    </div>
                  
                    </div>
                </div>
                <br>
                </div>

        </div>

        <div class="col-sm-4 px-2">

                <div class="card card-zo">
                    <br>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <div class="icon-circle-70 bg-warning">
                            <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                            </div>
                        </div>
                       
                        <div class="col-md-8">
                            <h4 class="font-weight:bold">FRET (FCFA)</h4>
                            <h3>{{number_format($enregistrements->where('is_fret', 1)->where('is_solded', 1)->where('statut_payement_ocl','!=','payes')->sum('prix'), 0, '', ' ')}}</h3>
                        </div>
                        
                        </div>
                    </div>
                    <br>
                </div>

        </div>

        <?php $commission_bagage_fret = str_replace('%','',sprintf("%.0f%%",$enregistrements->where('is_solded', 1)->where('statut_payement_ocl','!=','payes')->sum('prix')*7/100))?>

        <div class="col-sm-4 px-2">

                <div class="card card-zo">
                <br>
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <div class="icon-circle-70 bg-success">
                        <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                        </div>
                    </div>
                   
                    <div class="col-md-8">
                        <h4 class="font-weight:bold">GLOBAL (FCFA)</h4>
                        <h3>{{number_format($enregistrements->where('is_solded', 1)->where('statut_payement_ocl','!=','payes')->sum('prix'), 0, '', ' ')}}</h3>
                    </div>
                   
                    </div>
                </div>
                <br>
                </div>

        </div>
    </div>

    </div>
  </div>


<div class="card">
    <div class="card-header">
      <h3>Commissions bagage OCL</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="offset-md-3 col-sm-6 px-2">

            <div class="card card-zo">
            <br>
            <div class="card-body">
                <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                    <div class="icon-circle-70 bg-danger">
                    <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                    </div>
                </div>

                <div class="col-md-8">
                    <h4>Impayées (FCFA)</h4>
                    <h3 >{{number_format($commission_bagage_fret, 2, '.', ' ')}}</h3>
                </div>
                
                </div>
            </div>
            <br>
            </div>

    </div>

      </div>

    </div>
  </div>



<!-------------------------------------->


<div class="card">
    <div class="card-header">
      <h3>Rapports Colis </h3>
    </div>
    <div class="card-body">



      <div class="row">

        <div class="col-sm-6 px-2">

                <div class="card card-zo">
                <br>
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <div class="icon-circle-70 bg-primary">
                        <i class="fa fa-calendar-day" style="color: white;font-size: 30px"></i>
                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <i class="fa fa-users" style="font-size: 70px"></i>
                    </div> --}}
                    <div class="col-md-8">
                        <h4 class="font-weight:bold">NOMBRE COLIS</h4>
                       {{-- <h3 >{{number_format($commissioncolis->where('module_id',2)->where('statut_paiement', 'Unsolded')->count(), 0, '', ' ')}}</h3>--}}
                        <h3 >{{number_format($commissioncolis->where('statut_payement_ocl','!=','payes')->count(), 0, '', ' ')}}</h3>
                    </div>
                    
                    </div>
                </div>
                <br>
                </div>

        </div>

        <div class="col-sm-6 px-2">

                <div class="card card-zo">
                    <br>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <div class="icon-circle-70 bg-warning">
                            <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <h4 class="font-weight:bold">MONTANT COLIS (FCFA)</h4>
                           {{-- <h3>{{number_format($commissioncolis->where('module_id',2)->where('statut_paiement', 'Unsolded')->sum('montant_bagage'), 0, '', ' ')}}</h3>--}}
                         <h3>{{number_format($commissioncolis->where('statut_payement_ocl','!=','payes')->sum('prix'), 0, '', ' ')}}</h3>
                        </div>
                      
                        </div>
                    </div>
                    <br>
                </div>

        </div>


    </div>

    </div>
  </div>

<div class="card">
    <div class="card-header">
      <h3>Commissions Colis OCL</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="offset-md-3 col-sm-6 px-2">

            <div class="card card-zo">
            <br>
            <div class="card-body">
                <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                    <div class="icon-circle-70 bg-danger">
                    <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                    </div>
                </div>

                <div class="col-md-8">
                    <h4>Impayées (FCFA)</h4>
                    <h3 >{{number_format($commissioncolis->where('statut_payement_ocl','!=','payes')->count()*100, 0, '', ' ')}}</h3>
                </div>
                
                </div>
            </div>
            <br>
            </div>

    </div>

      </div>

    </div>
  </div>

  <!--------------------------------------------------------------->

  <div class="card">
    <div class="card-header">
      <h3>Rapport Ticket </h3>
    </div>
    <div class="card-body">



      <div class="row">

        <div class="col-sm-6 px-2">

                <div class="card card-zo">
                <br>
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <div class="icon-circle-70 bg-primary">
                        <i class="fa fa-calendar-day" style="color: white;font-size: 30px"></i>
                        </div>
                    </div>
                   
                    <div class="col-md-8">
                        <h4 class="font-weight:bold">NOMBRE TICKET</h4>
                       {{-- <h3 >{{number_format($commissioncolis->where('module_id',2)->where('statut_paiement', 'Unsolded')->count(), 0, '', ' ')}}</h3>--}}
                        <h3 >{{number_format($commissionticket->where('statut_payement_ocl','!=','payes')->count(), 0, '', ' ')}}</h3>
                    </div>
                   
                    </div>
                </div>
                <br>
                </div>

        </div>

        <div class="col-sm-6 px-2">

                <div class="card card-zo">
                    <br>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <div class="icon-circle-70 bg-warning">
                            <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                            </div>
                        </div>
                       
                        <div class="col-md-8">
                            <h4 class="font-weight:bold">MONTANT TICKET (FCFA)</h4>
                           {{-- <h3>{{number_format($commissioncolis->where('module_id',2)->where('statut_paiement', 'Unsolded')->sum('montant_bagage'), 0, '', ' ')}}</h3>--}}
                         <h3>{{number_format($commissionticket->where('statut_payement_ocl','!=','payes')->sum('prix'), 0, '', ' ')}}</h3>
                        </div>
                        
                        </div>
                    </div>
                    <br>
                </div>

        </div>


    </div>

    </div>
  </div>


  <div class="card">
    <div class="card-header">
      <h3>Commissions tickets OCL</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="offset-md-3 col-sm-6 px-2">

            <div class="card card-zo">
            <br>
            <div class="card-body">
                <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                    <div class="icon-circle-70 bg-danger">
                    <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                    </div>
                </div>

                <div class="col-md-8">
                    <h4>Impayées (FCFA)</h4>
                    <h3 >{{number_format($commissionticket->where('statut_payement_ocl','!=','payes')->count()*100, 0, '', ' ')}}</h3>
                </div>
                
                </div>
            </div>
            <br>
            </div>

    </div>

      </div>

    </div>
  </div>




<!------------------------------------------------------------->

@endif

@if (Route::current()->uri == "nos-factures" )


<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Nos factures</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
            <li class="breadcrumb-item active">Nos factures</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>




  <div class="card">
    <div class="card-header">
      <h3>Montant Impayés</h3>
    </div>
    <div class="card-body">


      <div class="row">

        <div class="col-sm-4 px-2">

                <div class="card card-zo">
                <br>
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <div class="icon-circle-70 bg-primary">
                        <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                        </div>
                    </div>
                    <?php $commission_bagage_fret = str_replace('%','',sprintf("%.0f%%",$enregistrements->where('is_solded', 1)->where('statut_payement_ocl','!=','payes')->sum('prix')*7/100))?>

                    <div class="col-md-8">
                        <h4 class="font-weight:bold">BAGAGE & FRET (FCFA)</h4>
                        <h3 >{{number_format($commission_bagage_fret, 2, '.', ' ')}}</h3>
                    </div>
                   
                    </div>
                </div>
                <br>
                </div>

        </div>

        <div class="col-sm-4 px-2">

                <div class="card card-zo">
                    <br>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <div class="icon-circle-70 bg-warning">
                            <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <h4 class="font-weight:bold"> COLIS (FCFA)</h4>
                            <h3>{{number_format($commissioncolis->where('statut_payement_ocl','!=','payes')->count()*100, 0, '', ' ')}}</h3>
                        </div>
                        
                        </div>
                    </div>
                    <br>
                </div>

        </div>
        <div class="col-sm-4 px-2">

          <div class="card card-zo">
              <br>
              <div class="card-body">
                  <div class="row">
                  <div class="col-md-3 d-flex align-items-center justify-content-center">
                      <div class="icon-circle-70 bg-warning">
                      <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                      </div>
                  </div>
                  
                  <div class="col-md-8">
                      <h4 class="font-weight:bold"> TICKET (FCFA)</h4>
                      <h3>{{number_format($commissionticket->where('statut_payement_ocl','!=','payes')->count()*100, 0, '', ' ')}}</h3>
                  </div>
                 
                  </div>
              </div>
              <br>
          </div>

  </div>

    </div>

    </div>
  </div>

<div class="card">
    <div class="card-header">
      <h3>En attente de paiement</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class=" col-sm-4 px-2">

            <div class="card card-zo">
            <br>
            <div class="card-body">
                <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                    <div class="icon-circle-70 bg-danger">
                    <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                    </div>
                </div>
                <?php $commission_bagage_fret_en_attente = str_replace('%','',sprintf("%.0f%%",$enregistrements->where('is_solded', 1)->where('statut_payement_ocl','En attente')->sum('prix')*7/100))?>
                <div class="col-md-8">
                    <h4>BAGAGE & FRET (FCFA)</h4>
                  
                    <h3 >{{number_format($commission_bagage_fret_en_attente, 0, '', ' ')}}</h3>
                </div>
               
                </div>
            </div>
            <br>
            </div>

    </div>
   <div class=" col-sm-4 px-2">

        <div class="card card-zo">
        <br>
        <div class="card-body">
            <div class="row">
            <div class="col-md-3 d-flex align-items-center justify-content-center">
                <div class="icon-circle-70 bg-danger">
                <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                </div>
            </div>

            <div class="col-md-8">
                <h4>COLIS (FCFA)</h4>
                <h3 >{{number_format($commissioncolis->where('statut_payement_ocl','En attente')->count()*100, 0, '', ' ')}}</h3>
            </div>
            
            </div>
        </div>
        <br>
        </div>

</div> 
<div class=" col-sm-4 px-2">

  <div class="card card-zo">
  <br>
  <div class="card-body">
      <div class="row">
      <div class="col-md-3 d-flex align-items-center justify-content-center">
          <div class="icon-circle-70 bg-danger">
          <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
          </div>
      </div>

      <div class="col-md-8">
          <h4>TICKET (FCFA)</h4>
          <h3 >{{number_format($commissionticket->where('statut_payement_ocl','En attente')->count()*100, 0, '', ' ')}}</h3>
      </div>
     
      </div>
  </div>
  <br>
  </div>

</div> 

      </div>

    </div>
  </div>




















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
                          {{"Tous les modules"}}
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
