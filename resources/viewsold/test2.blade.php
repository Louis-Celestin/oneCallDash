@extends('layouts.master')

@section('content')
<div class="row my-5">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">NOS VÉHICULES</h3>
          <a data-target="#addUser" data-toggle="modal" class="btn btn-primary">Ajouter</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>#</th>
                <th>JOUR</th>
                <th>GARE</th>
                <th>MT BAGAGE</th>
                <th>Commission nornal</th>
                <th>Com stockée</th>
                <th>ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($bagages as $item)
            <tr>
                <td>{{$loop->index + 1}}</td>
                <td>{{"JOUR"}}</td>
                <td>{{$item->gare_id}}</td>
                <td>{{$item->prix}}</td>
                <td>{{$item->prix * 7 /100}}</td>
                <td>
                    @if ($soldes->where('gare_id', $item->gare_id)->first() != null)
                        {{$soldes->where('gare_id', $item->gare_id)->first()->montant}}
                    @endif
                </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
              <tr>
                <th>NOM</th>
                <th>NUMÉRO VÉHICULE</th>
                <th>TYPE</th>
                <th>NOMBRE DE PLACE</th>
                <th>ACTIONS</th>
              </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="addUser">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('add-vehicules')}}" method="post">
        @csrf 
        <div class="modal-header">
          <h4 class="modal-title text-center">Ajouter un véhicule</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="nom_vehicule">Nom du véhicule:  <span class="text-danger"><sup>*</sup></span> </label>
                <input type="text" class="form-control" name="nom_vehicule" value="{{old('nom_vehicule')}}">
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="numero_vehicule">Numéro du véhicule:  <span class="text-danger"><sup>*</sup></span> </label>
                <input type="text" class="form-control" name="numero_vehicule" value="{{old('numero_vehicule')}}">
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="type_de_vehicule">Type de véhicule: </label>
                <input type="text" class="form-control" name="type_de_vehicule" value="{{old('type_de_vehicule')}}">
              </div>
            </div>

            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="nbre_de_place">Nombre de place:  <span class="text-danger"><sup>*</sup></span> </label>
                <input type="number" min="2" class="form-control" name="nbre_de_place" value="{{old('nbre_de_place')}}">
              </div>
            </div>


          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary">Créer</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
</div>

@foreach ([] as $item)
    
<div class="modal fade" id="updateVehicule_{{$item->id}}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('update-vehicules')}}" method="post">
        @csrf
        @method("PUT")
        <input type="hidden" name="id" value="{{$item->id}}">
        <div class="modal-header">
          <h4 class="modal-title text-center">Modifier un véhicule</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="nom_vehicule">Nom du véhicule:  <span class="text-danger"><sup>*</sup></span> </label>
                <input type="text" class="form-control" name="nom_vehicule" value="{{$item->nom_vehicule}}">
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="numero_vehicule">Numéro du véhicule:  <span class="text-danger"><sup>*</sup></span> </label>
                <input type="text" class="form-control" name="numero_vehicule" value="{{$item->numero_vehicule}}">
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="type_de_vehicule">Type de véhicule: </label>
                <input type="text" class="form-control" name="type_de_vehicule" value="{{$item->type_de_vehicule}}">
              </div>
            </div>

            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="nbre_de_place">Nombre de place:  <span class="text-danger"><sup>*</sup></span> </label>
                <input type="number" min="2" class="form-control" name="nbre_de_place" value="{{$item->nbre_de_place}}">
              </div>
            </div>


          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
<div class="modal fade" id="deleteVehicule_{{$item->id}}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('delete-vehicules', ['id'=> $item->id])}}" method="post">
        @csrf
        @method("delete")
        <div class="modal-header">
          <h4 class="modal-title text-center">Supprimer {{$item->numero_vehicule . " " .strtolower($item->nom_vehicule)}} ?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <p>Voulez-vous confirmer la suppression de ce article ?</p>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-danger">Supprimer</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
@endforeach
@endsection