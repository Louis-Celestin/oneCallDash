@extends('layouts.master')


@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Accueil</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">

      <div class="col-sm-4 px-2">
          <a href="#{{route('activites-colis', ['gare_id' => '*', 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">
              <div class="card card-zo">
                  <br>
                  <div class="card-body">
                      <div class="row">
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <div class="icon-circle-70 bg-primary">
                            <i class="fa fa-truck" style="color: white;font-size: 30px"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6  style="font-weight: bold;">FRET </h6>
                            <h5>{{number_format($todayBagage->where('is_fret', 1)->sum('prix'), 0, '', ' ')}}</h5>
                            <p>{{$todayBagage->where('is_fret', 1)->count(). " enregistrement(s)"}}</p>
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <i class="fa fa-chevron-right"></i>
                        </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>

      <div class="col-sm-4 px-2">
          <a href="#{{route('activites-colis', ['gare_id' => '*', 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">
              <div class="card card-zo">
                  <br>
                  <div class="card-body">
                      <div class="row">
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <div class="icon-circle-70 bg-warning">
                            <i class="fa fa-suitcase-rolling" style="color: white;font-size: 30px"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 style="font-weight: bold;">BAGAGES </h6>
                            <h5>{{number_format($todayBagage->where('is_fret', 0)->sum('prix'), 0, '', ' ') . " FCFA"}}</h5>
                            <p>{{$todayBagage->where('is_fret', 0)->count(). " enregistrement(s)"}}</p>
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <i class="fa fa-chevron-right"></i>
                        </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>

      <div class="col-sm-4 px-2">
          <a href="{{route('frais-de-route')}}" class="card-zo-link">
              <div class="card card-zo">
                  <br>
                  <div class="card-body">
                      <div class="row">
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <div class="icon-circle-70 bg-danger">
                            <i class="fa fa-road" style="color: white;font-size: 30px"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 style="font-weight: bold;">FRAIS DE ROUTE </h6>
                            <h5>{{number_format($todayBagage->sum('frais_de_route'), 0, '', '.') . " FCFA"}}</h5>
                            {{-- <h5>{{$todayBagage->where('is_fret', 1)->count(). " enregistrement(s)"}}</h5> --}}
                            <p> &nbsp;</p>
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <i class="fa fa-chevron-right"></i>
                        </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>


      <div class="col-sm-4 px-2">
          <a href="{{route('activites-colis', ['gare_id' => '*', 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">
              <div class="card card-zo">
              <br>
              <div class="card-body">
                  <div class="row">
                  <div class="col-md-5 d-flex align-items-center justify-content-center">
                      <div class="icon-circle-70 bg-info">
                      <i class="fa fa-suitcase" style="color: white;font-size: 30px"></i>
                      </div>
                  </div>
                  <div class="col-md-5">
                      <h6 style="font-weight: bold;">COLIS EMIS</h6>
                      <h2>{{number_format($colis->count(), 0, '', '.')}}</h2>
                  </div>
                  <div class="col-md-2 d-flex align-items-center">
                      <i class="fa fa-chevron-right"></i>
                  </div>
                  </div>
              </div>
              <br>
              </div>
          </a>
      </div>
      <div class="col-sm-4 px-2">
          <a href="{{route('activites-colis', ['gare_id' => '*', 'statut' => "Delivered", 'date' => date("Y-m-d")])}}" class="card-zo-link">
              <div class="card card-zo">
              <br>
              <div class="card-body">
                  <div class="row">
                  <div class="col-md-5 d-flex align-items-center justify-content-center">
                      <div class="icon-circle-70 bg-success">
                      <i class="fa fa-paper-plane" style="color: white;font-size: 30px"></i>
                      </div>
                  </div>
                  <div class="col-md-5">
                      <h6 style="font-weight: bold;">COLIS LIVRE</h6>
                      <h2>{{number_format($colis->where('statut', 'Delivered')->count(), 0, '', '.')}}</h2>
                  </div>
                  <div class="col-md-2 d-flex align-items-center">
                      <i class="fa fa-chevron-right"></i>
                  </div>
                  </div>
              </div>
              <br>
              </div>
          </a>
      </div>
      <div class="col-sm-4 px-2">
          <a href="{{route('vue-ensemble-colis')}}" class="card-zo-link">
              <div class="card card-zo">
              <br>
              <div class="card-body">
                  <div class="row">
                  <div class="col-md-3 d-flex align-items-center justify-content-center">
                      <div class="icon-circle-70 bg-dark">
                      <i class="fa fa-wallet" style="color: white;font-size: 30px"></i>
                      </div>
                  </div>
                  <div class="col-md-8">
                      <h6 style="font-weight: bold;">MONTANT COLIS</h6>
                      <h2>{{number_format($colis->sum('prix'), 0, '', '.')}}</h2>
                  </div>
                  <div class="col-md-1 d-flex align-items-center">
                      <i class="fa fa-chevron-right"></i>
                  </div>
                  </div>
              </div>
              <br>
              </div>
          </a>
      </div>



      {{-- <div class="col-lg-2 col-4">
        <div class="small-box bg-info" style="color: black !important;">
          <div class="inner">
            <p>Qte FRET</p>
            <h3>{{$todayBagage->where('is_fret', 1)->count()}}</h3>

          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-4">
        <div class="small-box bg-success" style="color: black !important;">
          <div class="inner">
            <p>Montant Fret (FCFA)</p>
            <h3>{{number_format($todayBagage->where('is_fret', 1)->sum('prix'), 0, '', ' ')}}</h3>

          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-4">
        <div class="small-box bg-warning" style="color: black !important;">
          <div class="inner">
            <p>Qte bagage</p>
            <h3>{{$todayBagage->where('is_fret', 0)->count()}}</h3>

          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-4">
        <div class="small-box bg-danger" style="color: black !important;">
          <div class="inner">
            <p>Montant Bagage (FCFA)</p>
            <h3>{{number_format($todayBagage->where('is_fret', 0)->sum('prix'), 0, '', ' ')}}</h3>

          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-8">
        <div class="small-box bg-info" style="color: black !important;">
          <div class="inner">
            <p>Frais de route</p>
            <h3>{{$todayBagage->sum('frais_de_route')}}</h3>

          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
        </div>
      </div> --}}


    </div>
    <div class="row">

      @if ($remises->count() > 0)
      <section class="col-lg-12  connectedSortable">
        <div class="card direct-chat direct-chat-primary ">
          <div class="card-header">
            <h3 class="card-title"><strong>REMISES DU JOUR</strong></h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <table id="" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>GARE</th>
                  <th>BAGAGE</th>
                  <th>AGENT</th>
                  <th>MONTANT GLOBAL (FCFA)</th>
                  <th>REMISE (FCFA)</th>
                  <th>PAYÉ (FCFA)</th>
                  <th>TYPE</th>
                  <th>ACTIONS</th>
                </tr>
              </thead>
              <tbody>
                {{-- {{dd($todayBagage->groupBy('gare_id')['42'])}} --}}
                @foreach ($remises as $item)
                  <tr>
                    <td>{{$item->nom_gare}}</td>
                    <td>{{$item->type_bagage}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{number_format($item->montant + $item->prix, 0, '', ' ')}}</td>
                    <td>{{number_format($item->montant, 0, '', ' ')}}</td>
                    <td>{{number_format($item->prix, 0, '', ' ')}}</td>
                    <td>{{$item->is_fret  ? "FRET" : "BUS"}}</td>
                    <td>
                      <a class="btn bg-gradient-success" data-target="#detailBagage{{$item->bagage_id}}" data-toggle="modal"><i class="fa fa-eye"> Details</i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="mt-2">
              {{$remises->links()}}
            </div>
          </div>
        </div>
        <!--/.Mes remises -->
      </section>
      @endif



      <section class="col-lg-12  connectedSortable">

        <!-- Mes gares -->
        <div class="card direct-chat direct-chat-primary ">
          <div class="card-header">
            <h3 class="card-title"><strong>BAGAGE DU JOUR</strong></h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-c ard-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>GARE</th>
                  <th>CLIENT</th>
                  <th>NUMERO</th>
                  <th>BAGAGE</th>
                  <th>QTE BAGAGE</th>
                  <th>MONTANT</th>
                  <th>PHOTO</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($todayBagage->where('is_fret', 0) as $item)
                  <tr>
                    {{-- <td>#{{$loop->index + 1}}</td> --}}
                    <td>#{{$item->id}}</td>
                    <td>
                      @if ($gares->where('id', $item->gare_id)->first() != null)
                          {{$gares->where('id', $item->gare_id)->first()->nom_gare}}
                      @endif
                    </td>
                    <td>{{$item->name_passager}}</td>
                    <td>{{$item->phone_passager}}</td>
                    <td>{{$item->type_bagage}}</td>
                    <td>{{$item->nbr_de_bagage}}</td>
                    <td>{{number_format($item->prix, 0, '', ' ')." FCFA"}}</td>
                    <td>
                      @if ($item->image != null)
                      <a class="btn bg-gradient-success" data-target="#detailBagage{{$item->id}}" data-toggle="modal"><i class="fa fa-eye"> Voir</i></a>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">

          </div>
          <!-- /.card-footer-->
        </div>
        <!--/.Mes gares -->
      </section>


      @if ($todayBagage->where('is_fret', 1)->count() >= 0)

      <section class="col-lg-12  connectedSortable">

        <!-- Mes gares -->
        <div class="card direct-chat direct-chat-primary ">
          <div class="card-header">
            <h3 class="card-title"><strong>FRET DU JOUR</strong></h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-c ard-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example3" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>GARE</th>
                  <th>CLIENT</th>
                  <th>NUMERO</th>
                  <th>BAGAGE</th>
                  <th>QTE BAGAGE</th>
                  <th>MONTANT</th>
                  <th>PHOTO</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($todayBagage->where('is_fret', 1) as $item)
                  <tr>
                    {{-- <td>#{{$loop->index + 1}}</td> --}}
                    <td>#{{$item->id}}</td>

                    <td>
                      @if ($gares->where('id', $item->gare_id)->first() != null)
                          {{$gares->where('id', $item->gare_id)->first()->nom_gare}}
                      @endif
                    </td>
                    <td>{{$item->name_passager}}</td>
                    <td>{{$item->phone_passager}}</td>
                    <td>{{$item->type_bagage}}</td>
                    <td>{{$item->nbr_de_bagage}}</td>
                    <td>{{number_format($item->prix, 0, '', ' ')." FCFA"}}</td>
                    <td>
                      @if ($item->image != null)
                      <a class="btn bg-gradient-success" data-target="#detailBagage{{$item->id}}" data-toggle="modal"><i class="fa fa-eye"> Voir</i></a>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <!--/.Mes gares -->
      </section>
      @endif



      <!-- Left col -->
      <section class=" {{$remises->count() > 0 ? 'col-lg-12' : 'col-lg-12'}}  connectedSortable">

        <!-- Mes gares -->
        <div class="card direct-chat direct-chat-primary ">
          <div class="card-header">
            <h3 class="card-title"><strong>GARES</strong></h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-c ard-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>GARE</th>
                  <th>NOMBRE DE BAGAGE</th>
                  <th>MONTANT</th>
                  <th>ACTION</th>
                </tr>
              </thead>
              <tbody>
                {{-- {{dd($todayBagage->groupBy('gare_id')['42'])}} --}}
                @foreach ($todayBagage->groupBy('gare_id') as $item)

                  <tr>
                    <td>
                      @if ($item[0]->gare_id != null)
                          {{$gares->where('id', $item[0]->gare_id)->first()->nom_gare}}
                      @endif
                    </td>
                    <td>{{$item->count()}}</td>
                    <td>{{number_format($item->SUM('prix'), 0, '', ' ')}}</td>
                    <td>
                      <a href="{{route('gare-reports', ['id'=>$gares->where('id', $item[0]->gare_id)->first()->id, 'user_id' => session()->has('users_id') ? session()->get('users_id') : '*', 'debut' => session()->has('start') ? session()->get('start') : date('Y-m-d'), 'fin' => session()->has('end') ? session()->get('end') : date('Y-m-d')])}}" class="btn btn-success">
                        <i class="fa fa-chart-pie"></i>
                        Rapport détaillé
                    </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              @if ($todayBagage->groupBy('gare_id')->count() > 10)
                <tfoot>
                  <tr>
                    <tr>
                      <th>GARE</th>
                      <th>NOMBRE DE BAGAGE</th>
                      <th>MONTANT (FCFA)</th>
                      <th>ACTION</th>
                    </tr>
                  </tr>
                </tfoot>
              @endif
            </table>
          </div>
        </div>
        <!--/.Mes gares -->
      </section>
      <!-- /.Left col -->



    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>
@endsection



@section('modal')

  @foreach ($todayBagage->where('image', '!=', null) as $item)
    <div class="modal fade" id="detailBagage{{$item->id}}">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{$item->nbr_de_bagage}} Bagages pour {{$item->name_passager}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <img src="https://ocl.ci/storage/bagages/{{$item->image}}" alt="les bagages de {{$item->name_passager}}" height="auto" width="100%">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>DESCRIPTION</th>
                    <th>VALEUR EN PERTE</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($detailBagage->where('bagage_id',$item->id) as $item)
                    <tr>
                      <td>#{{$item->id}}</td>
                      <td>{{$item->description}}</td>
                      <td>{{number_format($item->valperte_detail, 0, '', ' '). " FCFA"}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>
  @endforeach

@endsection
