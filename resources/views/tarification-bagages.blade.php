@extends('layouts.master')

@section('content')
<div class="row my-5">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">TARIFS BAGAGES</h3>
          <a data-target="#addUser" data-toggle="modal" class="btn btn-primary">Ajouter</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>Nature bagages</th>
                <th>Gare</th>
                <th>Taille</th>
                <th>Montant</th>
                <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tarifs as $item)
              <tr>
                  <td>{{$item->name_bagage}}</td>
                  <td>
                    @if ($gares->where('id', $item->gare_id)->first() != null)
                        {{$gares->where('id', $item->gare_id)->first()->nom_gare}}
                    @endif
                  </td>
                  <td>{{$item->taille}}</td>
                  <td>{{number_format($item->montant_bagage, 0, '', ' ')}}</td>
                  <td>
                      <a data-toggle="modal" data-target="#updateTarif_{{$item->id}}" class="btn btn-warning">
                          <i class="fa fa-edit text-white"> Éditer</i>
                      </a>
                      <a data-toggle="modal" data-target="#deleteTarif_{{$item->id}}" class="btn btn-danger">
                          <i class="fa fa-trash text-white"> Supprimer</i> 
                      </a>
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
@endsection

@section('modal')
<div class="modal fade" id="addUser">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('add-tarif-bagages')}}" method="post">
        @csrf 
        <div class="modal-header">
          <h4 class="modal-title text-center">Ajouter une tarification Bagage</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="gare_id">Gare : </label>
                <select name="gare_id" id="gare_id" class="form-control">
                  @foreach ($gares as $item)
                    <option value="{{$item->id}}" {{$item->id == session()->get('gare_id') ? 'selected' : ''}}>{{$item->nom_gare}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="name_bagage">Nom : </label>
                <input type="text" class="form-control" name="name_bagage" value="{{old('name_bagage')}}" required>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="name_bagage">Taille : </label>
                <input list="listofsize" class="form-control" name="taille" value="{{old('taille')}}">
                <datalist id="listofsize">
                  <option value="Petit">Petit</option>
                  <option value="Moyen">Moyen</option>
                  <option value="Grand">Grand</option>
                  <option value="Très Grand">Très Grand</option>
                </datalist>
              </div>
            </div>
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="montant_bagage">Montant : </label>
                <input type="number" min="0" class="form-control" name="montant_bagage" value="{{old('montant_bagage')}}" required>
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

@foreach ($tarifs as $item)
    
<div class="modal fade" id="updateTarif_{{$item->id}}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('update-tarif-bagages')}}" method="post">
        @csrf
        @method("PUT")
        <input type="hidden" name="id" value="{{$item->id}}">
        <div class="modal-header">
          <h4 class="modal-title text-center">Modifier une tarification Bagage</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">

            <div class="col-sm-12">
              <div class="form-group">
                <label for="gare_id">Gare : </label>
                <select name="gare_id" id="gare_id" class="form-control">
                  @foreach ($gares as $gare)
                    <option value="{{$gare->id}}" {{$gare->id == $item->gare_id ? 'selected' : ''}}>{{$gare->nom_gare}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="name_bagage">Nom : </label>
                <input type="text" class="form-control" name="name_bagage" value="{{$item->name_bagage}}" required> 
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label for="name_bagage">Taille : </label>
                <input list="listofsize" class="form-control" name="taille" value="{{$item->taille}}" >
                <datalist id="listofsize">
                  <option value="Petit">Petit</option>
                  <option value="Moyen">Moyen</option>
                  <option value="Grand">Grand</option>
                  <option value="Très Grand">Très Grand</option>
                </datalist>
              </div>
            </div>
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="montant_bagage">Montant : </label>
                <input type="number" min="0" class="form-control" name="montant_bagage" value="{{$item->montant_bagage}}" required>
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
<div class="modal fade" id="deleteTarif_{{$item->id}}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('delete-tarif-bagages', ['id'=> $item->id])}}" method="post">
        @csrf
        @method("delete")
        <div class="modal-header">
          <h4 class="modal-title text-center">Supprimer {{$item->taille . " " .strtolower($item->name_bagage)}} ?</h4>
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