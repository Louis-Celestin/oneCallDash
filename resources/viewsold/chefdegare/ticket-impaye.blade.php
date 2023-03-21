@extends('layouts.master')

@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tickets impayés</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
            <li class="breadcrumb-item active">Tickets impayés</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <div class="card my-2">
    <div class="card-body mx-auto">
        <form action="{{route('informations-bagage-impayes-post')}}" method="post">
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
                        <label for="">&nbsp;</label>
                        <input type="submit" value="Rechercher" class="form-control btn btn-success">
                        {{-- <button class="btn btn-secondary" class="form-control"> </button> --}}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row my-2">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between my-2">
            <h3 class="card-title">LISTE DES TICKETS BAGAGES IMPAYES | TRANSPORTS SMT</h3>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example3" class="table table-bordered table-striped">
            <thead>
              <tr>
                  <th>#</th>
                  <th>DATE</th>
                  <th>REFERENCE</th>
                  <th>VILLE DEPART</th>
                  <th>VILLE ARRIVEE </th>
                  <th>TYPE DE BAGAGE </th>
                   <th>MONTANT</th>
                   <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($Bagage as $item )
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{date("d/m/Y", strtotime($item->created_at))}}</td>
                    <td>{{$item->ref}}</td>
                    <td>{{$item->ville_depart}}</td>
                    <td>{{$item->ville_arrivee}}</td>
                    <td>{{$item->type_bagage}}</td>
                    <td>{{$item->prix}}</td>
                    <td> <a href="#" data-target="#confirmPaiement{{$item->id}}" data-toggle="modal"><i class="fa fas fa-eye"></i>Verifier</a> </td>
                    
                  </tr>
                @endforeach
              
             
            </tbody>
            
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
  </div>

@section('modal')

@foreach ($Bagage as $item )

<div class="modal fade" id="confirmPaiement{{$item->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{$item->type_bagage}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-body">
                <table id="{{$item->is_solded == 1 ? 'example9': ''}}" class="table table-bordered">
                    
                    <thead>
                        <tr>
                            <th>LIBELLE</th>
                            <th>VALEUR</th>
                        </tr>
                    </thead>
                    <tbody style="color: black !important;">
                        <tr>
                            <td><strong style="font-size: 27px;">CODE</strong></td>
                            <td><strong style="font-size: 27px;">{{$item->ref}}</strong></td>
                        </tr>
                        <tr>
                            <td><strong style="font-size: 27px;">NOM CLIENT</strong></td>
                            <td><strong style="font-size: 27px;">{{ucfirst($item->name_passager)}}</strong></td>
                        </tr>
                        <tr>
                            <td><strong style="font-size: 27px;">TYPE BAGAGE</strong></td>
                            <td><strong style="font-size: 27px;">{{$item->type_bagage}}</strong></td>
                        </tr>
                        <tr>
                            <td><strong style="font-size: 27px;">DESTINATION</strong></td>
                            <td><strong style="font-size: 27px;">{{$item->trajet_ville}}</strong></td>
                        </tr>
                        <tr>
                            <td><strong style="font-size: 27px;">MONTANT</strong></td>
                            <td><strong style="font-size: 27px;">{{number_format($item->prix, 0, '', ' ')}}</strong></td>
                        </tr>
                        <tr>
                            <td><strong style="font-size: 27px;">STATUS</strong></td>
                            <td>
                                <strong style="font-size: 27px;">
                                    @if ($item->is_solded == 1)
                                        Payé
                                    @else
                                        <a class="btn btn-danger">Impayées</a>
                                        <a class="btn bg-gradient-success" data-target="#confirm{{$item->id}}" data-toggle="modal"><i class="fa fa-print"></i>Confirmer le paiement</a>
                                    @endif
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="confirm{{$item->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{$item->type_bagage}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('update-ticket-bagage', ['id'=> $item->id])}}" method="post">
                @csrf
                @method("PUT")
                <div class="modal-body">
                    <p><h4 class="text-center">Vous confirmez le paiement <br>{{$item->nbr_de_bagage > 1 ? "des bagages" : "du bagage"}}  de <i>{{$item->name_passager}}</i>  pour un <br>montant de <i>{{number_format($item->prix, 0, '', ' '). " FCFA"}}</i> ?  </h4></p>
                    <ul>
                        <li><strong>Code :</strong> {{$item->ref}}</li>
                        <li><strong>Client :</strong> {{$item->name_passager}}</li>
                        <li><strong>Téléphone :</strong> {{$item->phone_passager}}</li>
                        <li><strong>Destination :</strong> {{$item->trajet_ville}}</li>
                        <li><strong>Type de bagage :</strong> {{$item->type_bagage}}</li>
                        <li><strong>Montant à payer :</strong> {{number_format($item->prix, 0, '', ' '). " FCFA"}}</li>
                    </ul>
                </div>

                <div class="modal-footer justify-content-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                    <button type="submit" class="btn btn-success">Oui</button>
                </div>
            </form>
        </div>
    </div>
</div>






@endforeach


@endsection

@endsection