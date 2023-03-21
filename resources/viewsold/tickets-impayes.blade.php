@extends('layouts.master')


@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Tickets Impayés</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Accueil</a></li>
          <li class="breadcrumb-item active">Tickets Impayés</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="row"> 
        
  <div class="col-sm-6 px-2">
      <a href="{{route('rapport-tickets-impayes', ['is_solded' => 0, 'is_fret' => 1])}}" class="card-zo-link">  
          <div class="card card-zo">
          <br>
          <div class="card-body">
              <div class="row">
              <div class="col-md-3 d-flex align-items-center justify-content-center">
                  <div class="icon-circle-70 bg-primary">
                  <i class="fa fa-calendar-day" style="color: white;font-size: 30px"></i>
                  </div>
              </div>
              {{-- <div class="col-md-3">
                  <i class="fa fa-users" style="font-size: 70px"></i>
              </div> --}}
              <div class="col-md-8">
                <p>FRET IMPAYÉS</p>
                <h5>QTE : {{$impayes->where('is_fret', 1)->where('is_solded', 0)->count()}}</h5>
                <h5>MONTANT : {{number_format($impayes->where('is_fret', 1)->where('is_solded', 0)->sum('prix'), 0, '', ' ')}}</h5>
              </div>
              <div class="col-md-1 d-flex align-items-center">
                  <i class="fa fa-chevron-right"></i>
              </div>
              </div>
          </div>
          <br>
          </div>
      </a>
  </div>
  
  <div class="col-sm-6 px-2">
      <a href="{{route('rapport-tickets-impayes', ['is_solded' => 1, 'is_fret' => 1])}}" class="card-zo-link">  
          <div class="card card-zo">
              <br>
              <div class="card-body">
                  <div class="row">
                  <div class="col-md-3 d-flex align-items-center justify-content-center">
                      <div class="icon-circle-70 bg-warning">
                      <i class="fa fa-calendar-plus" style="color: white;font-size: 30px"></i>
                      </div>
                  </div>
                  {{-- <div class="col-md-3">
                      <i class="fa fa-users" style="font-size: 70px"></i>
                  </div> --}}
                  <div class="col-md-8">
                    <p>FRET PAYÉS</p>
                    <h5>QTE : {{$impayes->where('is_fret', 1)->where('is_solded', 1)->count()}}</h5>
                    <h5>MONTANT : {{number_format($impayes->where('is_fret', 1)->where('is_solded', 1)->sum('prix'), 0, '', ' ')}}</h5>
                  </div>
                  <div class="col-md-1 d-flex align-items-center">
                      <i class="fa fa-chevron-right"></i>
                  </div>
                  </div>
              </div>
              <br>
          </div>
      </a>
  </div>
  
  <div class="col-sm-6 px-2">
      <a href="{{route('rapport-tickets-impayes', ['is_solded' => 0, 'is_fret' => 0])}}" class="card-zo-link">  
          <div class="card card-zo">
          <br>
          <div class="card-body">
              <div class="row">
              <div class="col-md-3 d-flex align-items-center justify-content-center">
                  <div class="icon-circle-70 bg-success">
                  <i class="fa fa-calendar" style="color: white;font-size: 30px"></i>
                  </div>
              </div>
              {{-- <div class="col-md-3">
                  <i class="fa fa-users" style="font-size: 70px"></i>
              </div> --}}
              <div class="col-md-8">
                <p>BAGAGES IMPAYÉS</p>
                <h5>QTE : {{$impayes->where('is_fret', 0)->where('is_solded', 0)->count()}}</h5>
                <h5>MONTANT : {{number_format($impayes->where('is_fret', 0)->where('is_solded', 0)->sum('prix'), 0, '', ' ')}}</h5>
              </div>
              <div class="col-md-1 d-flex align-items-center">
                  <i class="fa fa-chevron-right"></i>
              </div>
              </div>
          </div>
          <br>
          </div>
      </a>
  </div>

  <div class="col-sm-6 px-2">
    <a href="{{route('rapport-tickets-impayes', ['is_solded' => 1, 'is_fret' => 0])}}" class="card-zo-link">  
        <div class="card card-zo">
        <br>
        <div class="card-body">
            <div class="row">
            <div class="col-md-3 d-flex align-items-center justify-content-center">
                <div class="icon-circle-70 bg-success">
                <i class="fa fa-calendar" style="color: white;font-size: 30px"></i>
                </div>
            </div>
            {{-- <div class="col-md-3">
                <i class="fa fa-users" style="font-size: 70px"></i>
            </div> --}}
            <div class="col-md-8">
              <p>BAGAGES PAYÉS</p>
          <h5>QTE : {{$impayes->where('is_fret', 0)->where('is_solded', 1)->count()}}</h5>
          <h5>MONTANT : {{number_format($impayes->where('is_fret', 0)->where('is_solded', 1)->sum('prix'), 0, '', ' ')}}</h5>
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <i class="fa fa-chevron-right"></i>
            </div>
            </div>
        </div>
        <br>
        </div>
    </a>
</div>
</div>




<div class="row my-5">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title"> <strong>TICKETS IMPAYÉS </strong> </h3>
          {{-- <a data-target="#addUser" data-toggle="modal" class="btn btn-primary">Ajouter</a> --}}
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>#</th>
                <th>CODE</th>
                <th>GARE</th>
                <th>CLIENT</th>
                <th>BAGAGE</th>
                <th>TYPE</th>
                <th>QUANTITE</th>
                <th>PRIX</th>
                <th>PHOTO</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($impayes->where('is_solded', 0) as $item)
              <tr>
                  <td>{{$loop->index + 1}}</td>
                  <td>{{$item->ref}}</td>
                  <td>{{$item->nom_gare}}</td>
                  <td>{{$item->name_passager}} <br> {{$item->phone_passager}}</td>
                  <td>{{$item->type_bagage}}</td>
                  <td>{{$item->is_fret == 1 ? "FRET" : "BUS"}}</td>
                  <td>{{$item->nbr_de_bagage}}</td>
                  <td>{{number_format($item->prix, 0, '', ' ')}}</td>
                  <td>
                      <a href="https://ocl.ci/storage/bagages/{{$item->image}}" target="_blank" class="btn btn-secondary"> Voir l'image</a>
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
<div class="row my-5">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">  <strong>IMPAYÉS PAR GARE</strong> </h3>
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
                <th>QTE BAGAGE</th>
                <th>MONTANT ( FCFA )</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($impayesGroupByGare as $item)
              <tr>
                  <td>{{$loop->index + 1}}</td>
                  <td>{{$item->nom_gare}}</td>
                  <td>{{number_format($item->qte_client, 0, '', ' ')}}</td>
                  <td>{{number_format($item->qte_bagage, 0, '', ' ')}}</td>
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