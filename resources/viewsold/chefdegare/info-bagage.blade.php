@extends('layouts.master')

{{-- @section('title')
    Impression ticket |
@endsection --}}

@section('content')
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Informations Bagages</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Bagage</a></li>
                <li class="breadcrumb-item active">Recherche</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->   

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row">
                    <h5 class="col-sm-3">Recherche</h5>
                    <div class="col-sm-9 d-flex justify-content-end">
                        <form action="{{route('search-ticket-bagage')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <input type="text" name="ref" id="ref" placeholder="Code du bagage" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <button class="btn btn-success"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if ($bagage != null)
                <div class="card-body">
                    <table id="{{$bagage->is_solded == 1 ? 'example9': ''}}" class="table table-bordered">
                        
                        <thead>
                            <tr>
                                <th>LIBELLE</th>
                                <th>VALEUR</th>
                            </tr>
                        </thead>
                        <tbody style="color: black !important;">
                            <tr>
                                <td><strong style="font-size: 27px;">CODE</strong></td>
                                <td><strong style="font-size: 27px;">{{$bagage->ref}}</strong></td>
                            </tr>
                            <tr>
                                <td><strong style="font-size: 27px;">NOM CLIENT</strong></td>
                                <td><strong style="font-size: 27px;">{{ucfirst($bagage->name_passager)}}</strong></td>
                            </tr>
                            <tr>
                                <td><strong style="font-size: 27px;">TYPE BAGAGE</strong></td>
                                <td><strong style="font-size: 27px;">{{$bagage->type_bagage}}</strong></td>
                            </tr>
                            <tr>
                                <td><strong style="font-size: 27px;">DESTINATION</strong></td>
                                <td><strong style="font-size: 27px;">{{$bagage->trajet_ville}}</strong></td>
                            </tr>
                            <tr>
                                <td><strong style="font-size: 27px;">MONTANT</strong></td>
                                <td><strong style="font-size: 27px;">{{number_format($bagage->prix, 0, '', ' ')}}</strong></td>
                            </tr>
                            <tr>
                                <td><strong style="font-size: 27px;">STATUS</strong></td>
                                <td>
                                    <strong style="font-size: 27px;">
                                        @if ($bagage->is_solded == 1)
                                            Payé
                                        @else
                                            <a class="btn btn-danger">Impayées</a>
                                            <a class="btn bg-gradient-success" data-target="#confirmPaiement{{$bagage->id}}" data-toggle="modal"><i class="fa fa-print"></i>Confirmer le paiement</a>
                                        @endif
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('modal')
@if ($bagage != null)
    <div class="modal fade" id="confirmPaiement{{$bagage->id}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{$bagage->type_bagage}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{route('update-ticket-bagage', ['id'=> $bagage->id])}}" method="post">
                    @csrf
                    @method("PUT")
                    <div class="modal-body">
                        <p><h4 class="text-center">Vous confirmez le paiement <br>{{$bagage->nbr_de_bagage > 1 ? "des bagages" : "du bagage"}}  de <i>{{$bagage->name_passager}}</i>  pour un <br>montant de <i>{{number_format($bagage->prix, 0, '', ' '). " FCFA"}}</i> ?  </h4></p>
                        <ul>
                            <li><strong>Code :</strong> {{$bagage->ref}}</li>
                            <li><strong>Client :</strong> {{$bagage->name_passager}}</li>
                            <li><strong>Téléphone :</strong> {{$bagage->phone_passager}}</li>
                            <li><strong>Destination :</strong> {{$bagage->trajet_ville}}</li>
                            <li><strong>Type de bagage :</strong> {{$bagage->type_bagage}}</li>
                            <li><strong>Montant à payer :</strong> {{number_format($bagage->prix, 0, '', ' '). " FCFA"}}</li>
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
@endif
@endsection