@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Gares AVS Transports</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Éditer une gare</li>
            </ol>
          </div><!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <form action="{{route('update-gare')}}" method="POST">
              @csrf
              @method("PUT")
              <input type="hidden" name="id" value="{{$gare->id}}">
              <div class="card-header">
                <h3 class="card-title">Édition de gare</h3>
    
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nom : </label>
                      <input type="text" class="form-control" name="nom_gare" value="{{$gare->nom_gare}}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Ville : </label>
                      <input type="text" class="form-control" name="ville_gare" value="{{$gare->ville_gare}}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Adresse : </label>
                      <input type="text" class="form-control" name="adresse" value="{{$gare->adresse}}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Chef de gare : </label>
                      <select name="users_id" id="" class="form-control">
                        <option value=""></option>
                        @foreach ($users as $user)
                          <option value="{{$user->id}}" {{$user->id == $gare->users_id ? 'selected' : ''}}>{{$user->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Appliquer</button>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                Ne pas toucher la sélection de chef de gare si vous ne voulez pas mofier
              </div>
            </form>
          </div>
          <!-- /.card -->
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection