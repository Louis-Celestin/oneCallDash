@extends('layouts.master')


@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Frais de route</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Frais de route</li>
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

    <div class="card my-4">
        <div class="card-body mx-auto">
            <form action="{{route('search-frais-de-route')}}" method="post">
                @csrf
                <div class="row d-flex justify-content-center">
                    <div class="mx-2">
                        <div class="form-group">
                            <label for="datestart" class="text-muted">Début </label>
            
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" id="datestart" class="form-control" name="start"  data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" value="{{session()->has('start') ? session()->get('start') : date('Y-m-d')}}">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="mx-2">
                        <div class="form-group">
                            <label for="dateend" class="text-muted">Fin </label>
            
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" id="dateend" class="form-control" name="end"  data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" value="{{session()->has('end') ? session()->get('end') : date('Y-m-d')}}">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
    
                    <div class="mx-2">
                        <div class="form-group">
                            <label for="gares" class="text-muted">Gare(s) </label>
            
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-bus"></i></span>
                                </div>
                                <select name="gare_id" id="" class="form-control">
                                    @if (Auth::user()->usertype == "admin" || Auth::user()->usertype == "comptable")
                                      <option value="*">Toutes les gares</option>
                                    @endif
                                    @foreach ($gares as $item)
                                        <option value="{{$item->id}}" {{session()->get('gare_id') == $item->id ? "selected" : ''}}>{{$item->nom_gare}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mx-2">
                        <div class="form-group">
                            <label for="users" class="text-muted">Departs </label>
            
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                </div>
                                <select name="nom_depart" id="" class="form-control">
                                    <option value="*">Tous les departs</option>
                                    @foreach ($departs as $item)
                                        <option value="{{$item->nom_depart}}" {{session()->get('nom_depart') == $item->nom_depart ? "selected" : ''}} data4-id="{{$item->nom_depart}}">{{$item->nom_depart}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mx-2">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <input type="submit" value="Chercher" class="form-control btn btn-success">
                            {{-- <button class="btn btn-secondary" class="form-control"> </button> --}}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row my-2">

      <div class="col-sm-4 px-2">
          <a class="card-zo-link">  
              <div class="card card-zo">
                  <br>
                  <div class="card-body">
                      <div class="row">
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <div class="icon-circle-70 bg-success">
                            <i class="fa fa-truck" style="color: white;font-size: 30px"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6><strong>Frais de route (FRET) </strong></h6>
                            <h5>{{number_format($todayBagage->where('is_fret', 1)->sum('frais_de_route'), 0, '', ' ')." FCFA"}}</h5>
                            {{-- <p>{{$todayBagage->where('is_fret', 1)->count(). " enregistrement(s)"}}</p> --}}
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
        <a  class="card-zo-link">  
            <div class="card card-zo">
                <br>
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-3 d-flex align-items-center justify-content-center">
                          <div class="icon-circle-70 bg-success">
                          <i class="fa fa-road" style="color: white;font-size: 30px"></i>
                          </div>
                      </div>
                      <div class="col-md-8">
                        
                          <h6><strong>Frais de route (Global)</strong></h6>
                          <h5>{{number_format($todayBagage->sum('frais_de_route'), 0, '', '.') . " FCFA"}}</h5>
                          {{-- <h5>{{$todayBagage->where('is_fret', 1)->count(). " enregistrement(s)"}}</h5> --}}
                          {{-- <p> &nbsp;</p> --}}
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
          <a class="card-zo-link">  
              <div class="card card-zo">
                  <br>
                  <div class="card-body">
                      <div class="row">
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <div class="icon-circle-70 bg-success">
                            <i class="fa fa-suitcase-rolling" style="color: white;font-size: 30px"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6><strong>Frais de route (BAGAGES) </strong></h6>
                            <h5>{{number_format($todayBagage->where('is_fret', 0)->sum('frais_de_route'), 0, '', ' ') . " FCFA"}}</h5>
                            {{-- <p>{{$todayBagage->where('is_fret', 0)->where('frais_de_route', '!=', 0)->count(). " enregistrement(s)"}}</p> --}}
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <i class="fa fa-chevron-right"></i>
                        </div>
                      </div>
                  </div>
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
     
      {{-- <section class="col-lg-12  connectedSortable">

        <div class="card direct-chat direct-chat-primary ">
          <div class="card-header">
            <h3 class="card-title"><strong>PAR DEPARTS</strong></h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-c ard-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">

            { {-- { {dd($bagageDepartRaopprt)} } --} }
            { {-- { {dd($todayBagage->groupbY(DATE(DB::RAW('created_at'))))} } --} }
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>DATE</th>
                  <th>GARE</th>
                  <th>DEPART</th>
                  <th>QTE</th>
                  <th>TOTAL</th>
                  <th>FRAIS DE ROUTE</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($bagageDepartRaopprt as $date => $item)
                  <tr>
                    <td>{{$loop->index + 1}}</td>
                    <td>{{date('d-m-Y', strtotime($item->date))}}</td>
                    <td>
                      @if ($gares->where('id', $item->gare_id)->first() != null)
                          {{$gares->where('id', $item->gare_id)->first()->nom_gare}}
                      @endif
                    </td>
                    <td>
                      {{$item->num_depart}}
                    </td>
                    <td>{{number_format($item->countticket, 0, '', ' ')}}</td>
                    <td>{{number_format($item->sumticket, 0, '', ' ')." FCFA"}}</td>
                    <td>{{number_format($item->fraisroute, 0, '', ' ')." FCFA"}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            
          </div>
        </div>
      </section> --}}

    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>
@endsection



@section('modal')

@endsection