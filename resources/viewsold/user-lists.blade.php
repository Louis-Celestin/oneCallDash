@extends('layouts.master')

@section('content')

  {{-- <div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>150</h3>

          <p>New Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>53<sup style="font-size: 20px">%</sup></h3>

          <p>Bounce Rate</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>44</h3>

          <p>User Registrations</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>65</h3>

          <p>Unique Visitors</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div> --}}

  <div class="row my-5">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between my-2">
            <h3 class="card-title">UTILISATEURS TRANSPORTS AVS</h3>
            <a data-target="#addUser" data-toggle="modal" class="btn btn-primary">Ajouter</a>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Nom</th>
              <th>Téléphone</th>
              <th>Gare</th>
              <th>Role</th>
              <th>Module</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tbody>
              @foreach ($users as $item)
                <tr>
                  <td>{{ucfirst($item->name)}}</td>
                  <td>{{$item->phone}}</td>
                  <td>
                    @if ($gares->where('id', $item->gare_id)->first() != null)
                        {{$gares->where('id', $item->gare_id)->first()->nom_gare}}
                    @endif
                  </td>
                  <td>
                    @if ($item->usertype == "caissiere")
                        {{"Caissière"}}
                    @elseif($item->usertype == "chefgare")
                    {{"Chef de gare"}}
                    @else
                      {{ucfirst($item->usertype)}}
                    @endif
                  </td>
                  <td>
                    @switch($item->id_module)
                        @case(1)
                            {{"Bagage"}}
                            @break
                        @case(2)
                            {{"Colis"}}
                            @break
                        @case(3)
                            {{"Ticket"}}
                            @break
                        @default
                    @endswitch
                  </td>
                  <td>{{$item->email}}</td>
                  <td>
                    <a data-toggle="modal" data-target="#EditUser{{$item->id}}Modal" class="btn btn-warning text-white">
                      <i class="fa fa-edit"></i>
                      {{-- Modifier --}}
                  </a>
                  <a data-toggle="modal" data-target="#EraseUser{{$item->id}}Modal" class="btn btn-danger">
                      <i class="fa fa-eraser"></i>
                     {{-- Supprimer --}}
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

    {{-- ADD MODAL --}}
    <div class="modal fade" id="addUser">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form action="{{route('add-user')}}" method="post">
            @csrf
            <div class="modal-header">
              <h4 class="modal-title">Créer un Utilisateur </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="name">NOM :</label>
                    <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="phone">TÉLÉPHONE :</label>
                    <input type="tel" id="phone" class="form-control" name="phone" value="{{old('phone')}}">
                  </div>
                </div>
                
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="gare_id">Gare:</label>
                    <select name="gare_id" class="form-control">
                      <option value="">---</option>
                      @foreach ($gares as $gare)
                        <option value="{{$gare->id}}">{{$gare->nom_gare}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="id_module">Module:</label>
                    <select name="id_module" class="form-control">
                      <option value="">---</option>
                      <option value="1">Bagage & Fret</option>
                      {{-- <option value="2">Colis</option>
                      <option value="3">Ticket</option> --}}
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="usertype">Poste:</label>
                    <select name="usertype" class="form-control">
                      <option value="admin">Administrateur</option>
                      <option value="caissiere">Caissière</option>
                      <option value="chefgare">Chef de gare</option>
                      <option value="comptable">Comptable</option>
                      <option value="agent">Gestionnaire(Agent)</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="email">E-mail :</label>
                    <input type="email" id="email" class="form-control" placeholder="Seulement réquis pour les admins et chef de gare" name="email" value="{{old('email')}}">
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" class="form-control" name="password">
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
              <button type="submit" class="btn btn-warning">Ajouter</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>
    {{-- /ADD MODAL --}}

    @foreach ($users as $item)
      {{-- UPDATE MODAL --}}
      <div class="modal fade" id="EditUser{{$item->id}}Modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{route('update-user')}}" method="post">
              @csrf
              @method("PUT")
              <input type="hidden" name="id" value="{{$item->id}}">
              <div class="modal-header">
                <h4 class="modal-title">{{$item->usertype}} {{$item->name}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
    
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="name">NOM :</label>
                      <input type="text" id="name" class="form-control" name="name" value="{{$item->name}}">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="phone">TÉLÉPHONE :</label>
                      <input type="tel" id="phone" class="form-control" name="phone" value="{{$item->phone}}">
                    </div>
                  </div>
                  
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="gare_id">Gare:</label>
                      <select name="gare_id" class="form-control">
                        <option value="">---</option>
                        @foreach ($gares as $gare)
                        <option value="{{$gare->id}}" {{$item->gare_id == $gare->id ? 'selected' : ''}}>{{$gare->nom_gare}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="id_module">Module:</label>
                      <select name="id_module" class="form-control">
                        <option value="">---</option>
                        <option value="1" {{$item->id_module == '1' ? 'selected' : ''}}>Bagage & Fret</option>
                        {{-- <option value="2" {{$item->id_module == '2' ? 'selected' : ''}}>Colis</option>
                        <option value="3" {{$item->id_module == '3' ? 'selected' : ''}}>Ticket</option> --}}
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="usertype">Poste:</label>
                      <select name="usertype" class="form-control">
                        <option value="admin" {{$item->usertype == 'admin' ? 'selected' : ''}}>Administrateur</option>
                        <option value="caissiere" {{$item->usertype == 'caissiere' ? 'selected' : ''}}>Caissière</option>
                        <option value="chefgare" {{$item->usertype == 'chefgare' ? 'selected' : ''}}>Chef de gare</option>
                        <option value="comptable" {{$item->usertype == 'comptable' ? 'selected' : ''}}>Comptable</option>
                        <option value="agent" {{$item->usertype == 'agent' ? 'selected' : ''}}>Gestionnaire(Agent)</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="email">E-mail :</label>
                      <input type="email" id="email" class="form-control" placeholder="Seulement réquis pour les admins et chef de gare" name="email" value="{{$item->email}}">
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="password">Mot de passe :</label>
                      <input type="password" id="password" placeholder="Remplir seulement si vous souhaitez changer son mot de passe" class="form-control" name="password">
                    </div>
                  </div>
                </div>
              </div>
    
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-warning">Mettre à jour</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
      </div>
      {{-- /UPDATE MODAL --}}

      {{-- DELETE MODAL --}}
      <div class="modal fade" id="EraseUser{{$item->id}}Modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="{{route('destroy-user', ['id'=> $item->id])}}" method="post">
              @csrf
              @method("DELETE")
              <div class="modal-header">
                <h4 class="modal-title">Supprimer  {{$item->name}} ?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
    
              <div class="modal-body">
                <p>Voulez-vous vraiment supprimer cet Utilisateur ?</p>
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
      {{-- /DELETE MODAL --}}
    @endforeach


@endsection