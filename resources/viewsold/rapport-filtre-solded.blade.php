@extends('layouts.master')


@section('content')
<div class="container">

  <div class="card my-2" style="background-color: #ffef38;">
    <div class="card-body mx-auto">
        <form action="{{route('filtreImpayepart')}}" method="post">
            @csrf
            <div class="row d-flex justify-content-center">
                <div class="mx-2">
                    <div class="form-group">
                        <label for="datestart" class="text-mutded">Début </label>
        
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" id="datestart" class="form-control" name="start" placeholder="ds"  data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" value="{{session()->has('start') ? session()->get('start') : date('Y-01-01')}}">
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
                <div class="mx-2">
                    <div class="form-group">
                        <label for="dateend" class="text-mutded">Fin </label>
        
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
                        <label for="gares" class="text-mutded">Gare(s) </label>
        
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-bus"></i></span>
                            </div>
                            <select name="gare_id" id="" class="form-control">
                                <option value="*">Toutes les gares</option>
                                @foreach ($gares as $item)
                                    <option value="{{$item->id}}" {{session()->get('gare_id') == $item->id ? "selected" : ''}}>{{$item->nom_gare}}</option>
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
</div>
<div class="row">

  
    {{-- <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info" style="color: black !important;">
        <div class="inner">
          <p>FRET IMPAYÉS</p>
          <h5>QTE : {{$impayes->where('is_fret', 1)->where('is_solded', 0)->count()}}</h5>
          <h5>MONTANT : {{number_format($impayes->where('is_fret', 1)->where('is_solded', 0)->sum('prix'), 0, '', ' ')}}</h5>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="#" class="small-box-footer">Détails <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success" style="color: black !important;">
        <div class="inner">
          <p>FRET PAYÉS</p>
          <h5>QTE : {{$impayes->where('is_fret', 1)->where('is_solded', 1)->count()}}</h5>
          <h5>MONTANT : {{number_format($impayes->where('is_fret', 1)->where('is_solded', 1)->sum('prix'), 0, '', ' ')}}</h5>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer">Détails <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger" style="color: black !important;">
        <div class="inner">
          <p>BAGAGES IMPAYÉS</p>
          <h5>QTE : {{$impayes->where('is_fret', 0)->where('is_solded', 0)->count()}}</h5>
          <h5>MONTANT : {{number_format($impayes->where('is_fret', 0)->where('is_solded', 0)->sum('prix'), 0, '', ' ')}}</h5>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">Détails <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning" style="color: black !important;">
        <div class="inner">
          <p>BAGAGES PAYÉS</p>
          <h5>QTE : {{$impayes->where('is_fret', 0)->where('is_solded', 1)->count()}}</h5>
          <h5>MONTANT : {{number_format($impayes->where('is_fret', 0)->where('is_solded', 1)->sum('prix'), 0, '', ' ')}}</h5>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer text-white" style="color: white !important;">Détails <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col --> --}}
  </div>


<div class="row my-5">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">{{$is_fret == 1 ? "FRET" : "BAGAGES"}} {{$is_solded == 1 ? "PAYÉS" : "IMPAYÉS"}} </h3>
          {{-- <a data-target="#addUser" data-toggle="modal" class="btn btn-primary">Ajouter</a> --}}
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>#</th>
                <th>DATE</th>
                <th>HEURE</th>
                <th>CODE</th>
                <th>GARE</th>
                <th>CLIENT</th>
                <th>BAGAGE</th>
                <th>QUANTITE</th>
                <th>PRIX</th>
                <th>PHOTO</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
              <tr>
                  <td>{{$loop->index + 1}}</td>
                  <td>
                    {{date('d-m-Y', strtotime($item->created_at))}}
                  </td>
                  <td>
                    {{date('H:i', strtotime($item->created_at))}}
                  </td>
                  <td>{{$item->ref}}</td>
                  <td>{{$item->nom_gare}}</td>
                  <td>{{$item->name_passager}}</td>
                  <td>{{$item->type_bagage}}</td>
                  <td>{{$item->nbr_de_bagage}}</td>
                  <td>{{number_format($item->prix, 0, '', ' ')}}</td>
                  <td>
                      <a href="https://ocl.ci/storage/bagages/{{$item->image}}" target="_blank" class="btn btn-secondary"> Voir l'image</a>
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
<div class="row my-5">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">{{$is_solded == 1 ? "PAYÉS" : "IMPAYÉS"}} PAR GARE</h3>
          {{-- <a data-target="#addUser" data-toggle="modal" class="btn btn-primary">Ajouter</a> --}}
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example3" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>#</th>
                <th>GARE</th>
                <th>QTE CLIENT</th>
                <th>QTE BAGAGE</th>
                <th>MONTANT ( FCFA )</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($impayesGroupByGare as $item)
              <tr>
                  <td>{{$loop->index + 1}}</td>
                  <td>{{$item->nom_gare}}</td>
                  <td>{{number_format($item->qte_client, 0, '', ' ')}}</td>
                  <td>{{number_format($item->qte_bagage, 0, '', ' ')}}</td>
                  <td>{{number_format($item->prix_gare, 0, '', ' ')}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div>
@endsection