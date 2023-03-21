@extends('layouts.master')

@section('content')
<div class="row my-5">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">NOS CONDUCTEURS</h3>
          <a data-target="#addConducteurs" data-toggle="modal" class="btn btn-primary">Ajouter</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>NOM</th>
                <th>PRÉNOM</th>
                <th>NUMÉRO</th>
                <th>ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($conducteurs as $item)
              <tr>
                  <td>{{$item->nom_conducteur}}</td>
                  <td>{{$item->prenom_conducteur}}</td>
                  <td>{{$item->tel_conducteur}}</td>
                  <td>
                      <a data-toggle="modal" data-target="#updateConducteur_{{$item->id}}" class="btn btn-warning">
                          <i class="fa fa-edit text-white"> Éditer</i>
                      </a>
                      <a data-toggle="modal" data-target="#deleteConducteur_{{$item->id}}" class="btn btn-danger">
                          <i class="fa fa-trash text-white"> Supprimer</i> 
                      </a>
                  </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
              <tr>
                <th>NOM</th>
                <th>PRÉNOM</th>
                <th>NUMÉRO</th>
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
<div class="modal fade" id="addConducteurs">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('add-conducteurs')}}" method="post">
        @csrf 
        <div class="modal-header">
          <h4 class="modal-title text-center">Ajouter un conducteur</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="nom_conducteur">Nom du conducteur:  <span class="text-danger"><sup>*</sup></span> </label>
                <input type="text" class="form-control" name="nom_conducteur" value="{{old('nom_conducteur')}}">
              </div>
            </div>
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="prenom_conducteur">Prénom du conducteur:  <span class="text-danger"><sup>*</sup></span> </label>
                <input type="text" class="form-control" name="prenom_conducteur" value="{{old('prenom_conducteur')}}">
              </div>
            </div>
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="tel_conducteur">Numéro du conducteur:  </label>
                <input type="tel" class="form-control" name="tel_conducteur" value="{{old('tel_conducteur')}}">
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

@foreach ($conducteurs as $item)
    
<div class="modal fade" id="updateConducteur_{{$item->id}}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('update-conducteurs')}}" method="post">
        @csrf
        @method("PUT")
        <input type="hidden" name="id" value="{{$item->id}}">
        <div class="modal-header">
          <h4 class="modal-title text-center">Modifier un conducteur</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="nom_conducteur">Nom du conducteur:  <span class="text-danger"><sup>*</sup></span> </label>
                <input type="text" class="form-control" name="nom_conducteur" value="{{$item->nom_conducteur}}">
              </div>
            </div>
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="prenom_conducteur">Prénom du conducteur:  <span class="text-danger"><sup>*</sup></span> </label>
                <input type="text" class="form-control" name="prenom_conducteur" value="{{$item->prenom_conducteur}}">
              </div>
            </div>
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="tel_conducteur">Numéro du conducteur:  <span class="text-danger"><sup>*</sup></span> </label>
                <input type="tel" class="form-control" name="tel_conducteur" value="{{$item->tel_conducteur}}">
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
<div class="modal fade" id="deleteConducteur_{{$item->id}}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('delete-conducteurs', ['id'=> $item->id])}}" method="post">
        @csrf
        @method("delete")
        <div class="modal-header">
          <h4 class="modal-title text-center">Supprimer {{$item->nom_conducteur . " " .strtolower($item->prenom_conducteur)}} ?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <p>Voulez-vous confirmer la suppression de ce conducteur ?</p>
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