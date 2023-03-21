@extends('layouts.master')


@section('content')

<div class="container">
  <div class="row">
    <div class="card my-2">
      <div class="card-body mx-auto">
          <form action="{{route('rapport-colis-search')}}" method="post">
              <input type="hidden" name="_token" value="iJ7zivDuEZwp8qZXyYU1Sw8YXLZsJ0H7IXwxj8gF">            
              <div class="row d-flex justify-content-center">
                  <div class="mx-2">
                      <div class="form-group">
                          <label for="datestart" class="text-muted">Début </label>
          
                          <div class="input-group">
                              <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                              </div>
                              <input type="date" id="datestart" class="form-control" name="start" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" value="2023-01-23">
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
                              <input type="date" id="dateend" class="form-control" name="end" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" value="2023-01-23">
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
                                <option value="*">Toutes les gares</option>
                                @foreach ($gares as $gare)
                                  <option value="{{$gare->id}}">{{$gare->nom_gare}}</option>
                                @endforeach
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="mx-2">
                      <div class="form-group">
                          <label for="users" class="text-muted">Agent(s) </label>
          
                          <div class="input-group">
                              <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                              </div>
                              <select name="users_id" id="" class="form-control">
                                  <option value="*">Tous les agents</option>
                                  @foreach ($agents->where('usertype', 'agent') as $agent)
                                  <option value="212" data-id="60">{{$agent->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="mx-2">
                      <div class="form-group">
                          <label for="">&nbsp;</label>
                          <input type="submit" value="Chercher" class="form-control btn btn-success">
                          
                      </div>
                  </div>
              </div>
          </form>
      </div>
    </div>
  </div>
</div>
<div class="card">
    <div class="card-body bg-warning">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body bg-white">
                        <p class="card-text text-warning"><strong>Ajourd'hui</strong></p>
                        <p class="card-text"><strong>Enregistré : {{ number_format($colis->count(), 0, '', ' ') }}</strong></p>
                        <p class="card-text"><strong>Montant : {{ number_format($colis->sum('prix'), 0, '', ' ') . " FCFA" }}</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" style="border-radius: 20px;">
                <div class="card">
                    <div class="card-body bg-white">
                        <p class="card-text text-warning"><strong>Mois : {{date('M')}}</strong></p>
                        <p class="card-text"><strong>Enregistré : {{ number_format($colisMonth->count(), 0, '', ' ') }}</strong></p>
                        <p class="card-text"><strong>Montant : {{ number_format($colisMonth->sum('prix'), 0, '', ' ') . " FCFA" }}</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body bg-white">
                        <p class="card-text text-warning"><strong>Annuel : 2023</strong></p>
                        <p class="card-text"><strong>Enregistré : {{ number_format($colisYear->count(), 0, '', ' ') }}</strong></p>
                        <p class="card-text"><strong>Montant : {{ number_format($colisYear->sum('prix'), 0, '', ' ') . " FCFA" }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">

  <div class="col-sm-4">
    <a href="#" class="card card-zoom shadow-lg" style="border-radius: 10px;">
      <div class="card-body">
        {{-- <i class="fa fa-check-double">  </i> --}}
        <div class="d-flex justify-content-between">
          <h3 class="text-black">COLIS REÇU</h3>
          <h3>{{$colis->count()}}</h3>
        </div>
        <br>
        <div class="d-flex justify-content-start">
          
          <h5 class="text-success">{{number_format($colis->where('is_fret', 1)->where('is_solded', 0)->sum('prix'), 0, '', ' ')}}</h5>
        </div>
      </div>
    </a>
  </div>

  <div class="col-sm-4">
    <a href="#" class="card card-zoom shadow-lg" style="border-radius: 10px;">
      <div class="card-body">
        {{-- <i class="fa fa-check-double">  </i> --}}
        <div class="d-flex justify-content-between">
          <h3 class="text-black">COLIS EN ATTENTE</h3>
          <h3>{{$colis->where('statut', 'Waiting')->count()}}</h3>
        </div>
        <br>
        <div class="d-flex justify-content-start">
          
          <h5 class="text-success">{{number_format($colis->where('statut', 'Waiting')->sum('prix'), 0, '', ' ')}}</h5>
        </div>
      </div>
    </a>
  </div>

  <div class="col-sm-4">
    <a href="#" class="card card-zoom shadow-lg" style="border-radius: 10px;">
      <div class="card-body">
        {{-- <i class="fa fa-check-double">  </i> --}}
        <div class="d-flex justify-content-between">
          <h3 class="text-black">COLIS LIVRÉ</h3>
          <h3>{{$colis->where('statut', 'Delivered')->count()}}</h3>
        </div>
        <br>
        <div class="d-flex justify-content-start">
          
          <h5 class="text-success">{{number_format($colis->where('statut', 'Delivered')->sum('prix'), 0, '', ' ')}}</h5>
        </div>
      </div>
    </a>
  </div>
    {{-- <div class="col-lg-4 col-6">
      <div class="small-box" style="color: black !important;">
        <div class="inner">
          <p>Colis en attente</p>
          <h5>QTE : {{$colis->where('is_fret', 1)->where('is_solded', 1)->count()}}</h5>
          <h5>MONTANT : {{number_format($colis->where('is_fret', 1)->where('is_solded', 1)->sum('prix'), 0, '', ' ')}}</h5>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="{{route('rapport-colis', ['is_solded' => 1, 'is_fret' => 1])}}" class="small-box-footer">Détails <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-4 col-6">
      <div class="small-box bg-success" style="color: black !important;">
        <div class="inner">
          <p>Colis livré</p>
          <h5>QTE : {{$colis->where('is_fret', 0)->where('is_solded', 0)->count()}}</h5>
          <h5>MONTANT : {{number_format($colis->where('is_fret', 0)->where('is_solded', 0)->sum('prix'), 0, '', ' ')}}</h5>
        </div>
        <div class="icon">
          <i class="ion ion-pie-chart"></i>
        </div>
        <a href="{{route('rapport-colis', ['is_solded' => 0, 'is_fret' => 0])}}" class="small-box-footer">Détails <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div> --}}
</div>


<div class="row my-5">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title"> <strong>COLIS NON LIVRÉ </strong> </h3>
        </div>
      </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>#</th>
                <th>CODE</th>
                <th>GARE</th>
                <th>DEST</th>
                <th>COLIS</th>
                <th>PRIX</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($colis->where('is_solded', 0) as $item)
              <tr>
                  <td>{{$loop->index + 1}}</td>
                  <td>{{$item->code}}</td>
                  <td>
                      @if ($gares->where('id', $item->gare_id_recu)->first() != null)
                      {{$gares->where('id', $item->gare_id_recu)->first()->nom_gare}}
                      @else
                      {{"Non reconnu"}}
                      @endif
                  </td>
                  <td>{{$item->nom_destinataire}} <br> {{$item->num_destinataire}}</td>
                  <td>{{$item->description}}</td>
                  <td>{{number_format($item->prix, 0, '', ' ')}}</td>
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
          <h3 class="card-title">  <strong>RAPPORT DES GARES</strong> </h3>
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
                <th>QTE COLIS</th>
                <th>MONTANT ( FCFA )</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($colisGroupByGare as $item)
              <tr>
                  <td>{{$loop->index + 1}}</td>
                  <td>
                    @if ($gares->where('id', $item->gare_id)->first() != null)
                    {{$gares->where('id', $item->gare_id)->first()->nom_gare}}
                    @else
                    {{"Non reconnu"}}
                    @endif
                  </td>
                  <td>{{number_format($item->qte_client, 0, '', ' ')}}</td>
                  <td>{{number_format($item->qte_colis, 0, '', ' ')}}</td>
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