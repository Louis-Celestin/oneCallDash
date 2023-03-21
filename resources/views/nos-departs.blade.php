@extends('layouts.master')

@section('content')
<div class="row my-5">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">DEPARTS </h3>
          <a class="btn btn-primary" data-toggle="modal" data-target="#addDepart">Ajouter</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>Gare</th>
                <th>Départ</th>
                <th>Heure</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($departs as $item)
              <tr>
                  <td>
                    @if ($gares->where('id', $item->ville_depart)->first() != null)
                      {{$gares->where('id', $item->ville_depart)->first()->nom_gare}}
                    @endif
                  </td>
                  <td>{{$item->nom_depart}}</td>
                  <td>{{$item->heure_depart}}</td>
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
<div class="modal fade" id="addDepart">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('save-departs')}}" method="post">
        @csrf 
        <div class="modal-header">
          <h4 class="modal-title text-center">ENRÉGISTRER UN DÉPART</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="depart">Départ : </label>
                <select name="nom_depart" id="depart" class="form-control">
                  @for ($i = 1; $i <= 200; $i++)
                    <option value="Départ {{$i}}">Départ {{$i}}</option>
                  @endfor
                </select>
              </div>
            </div>
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="departype">Type de départ : </label>
                <select name="is_depart_fret" id="departype" class="form-control">
                  <option value="0">BAGAGE</option>
                  <option value="1">FRET</option>
                </select>
              </div>
            </div>
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="heure_depart">Heure de départ : </label>
                <input type="time" name="heure_depart" id="heure_depart" class="form-control">
              </div>
            </div>

            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="depart">Ville de départ : </label>
                <select name="ville_depart" id="depart" class="form-control">
                  <option value="">--</option>
                  @foreach ($gares as $item)
                      <option value="{{$item->id}}">{{$item->nom_gare}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="arrive">Destination : </label>
                <select name="ville_destination" id="arrive" class="form-control">
                  <option value="">--</option>
                  @foreach ($gares as $item)
                      <option value="{{$item->id}}">{{$item->nom_gare}}</option>
                  @endforeach
                </select>
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

{{-- @foreach ($tarifs as $item)
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
                        <label for="name_bagage">Nom : </label>
                        <input type="text" class="form-control" name="name_bagage" value="{{$item->name_bagage}}">
                    </div>
                    </div>

                    <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name_bagage">Taille : </label>
                        <input list="listofsize" class="form-control" name="taille" value="{{$item->taille}}">
                        <datalist id="listofsize">
                        <option value="Pétite">Pétite</option>
                        <option value="Moyen">Moyen</option>
                        <option value="Grande">Grande</option>
                        <option value="Très Grande">Très Grande</option>
                        </datalist>
                    </div>
                    </div>
                    
                    <div class="col-sm-12">
                    <div class="form-group">
                        <label for="montant_bagage">Montant : </label>
                        <input type="number" min="0" class="form-control" name="montant_bagage" value="{{$item->montant_bagage}}">
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
@endforeach --}}
@endsection