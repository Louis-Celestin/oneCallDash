@extends('layouts.master')

@section('content')
<div class="row my-5">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">Souscription</h3>
          <a data-target="#addUser" data-toggle="modal" class="btn btn-primary">Ajouter</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>Gare</th>
                <th>Module</th>
                <th>TYPE D'OFFRE</th>
                <th>STATUS</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($enrollements as $item)
              <tr>
                  <td>{{$item->nom_gare}}</td>
                  <td>
                      @switch($item->id_module)
                          @case(1)
                              {{"BAGAGES & FRETS"}}
                              @break
                          @case(2)
                              {{"COLIS"}}
                              @break
                          @default
                              {{"TICKETS"}}
                      @endswitch
                  </td>
                  <td>
                      @if ($item->type_offre == 0)
                          {{"PAR COMMISSION"}}
                      @endif
                  </td>
                  <td>
                      @if ($item->actif)

                        <a class="btn btn-success">
                            <i class="fa fa-check text-white"></i>
                        </a>

                      @else

                        <a class="btn btn-danger">
                            <i class="fa fa-times text-white"> Inactif</i> 
                        </a>

                      @endif


                  </td>
              </tr>
            @endforeach
          </tbody>
          @if ($enrollements->count() > 10) 
          <tfoot>
            <tr>
                <th>Gare</th>
                <th>Module</th>
                <th>TYPE D'OFFRE</th>
                <th>STATUS</th>
            </tr>
          </tfoot>
          @endif
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
      <form action="{{route('souscribe')}}" method="post">
        @csrf 
        <div class="modal-header">
          <h4 class="modal-title text-center">Souscrire pour une gare ? </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="gare">Choisissez la gare :</label>
                    <select name="id_gare" id="gare" class="form-control">
                        @foreach ($gares as $item)
                            <option value="{{$item->id}}">{{$item->nom_gare}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="module">Le module :</label>
                    <select name="id_module" id="module" class="form-control">
                        <option value="1">BAGAGES & FRET</option>
                        <option value="2" disabled>COLIS</option>
                        <option value="3" disabled>TICKETS</option>
                    </select>
                </div>
            </div>
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="type_offre">Offre : </label>
                <input type="text" readonly class="form-control" name="type_offre" value="Par commission">
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary">Souscrire</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
</div>

@endsection