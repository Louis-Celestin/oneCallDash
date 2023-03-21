@extends('layouts.master')


@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between px-2">
    <h3>Vue d'ensemble bagage</h3>
    <h3>Administrateur</h3>
  </div>
  
  <br>

  @if (Auth::user()->usertype == 'admin')
  <div class="row">

    <div class="col-sm-6 px-2">
      <a href="{{route('informations-bagage-impayes',['statut'=>'impaye'])}}" class="card-zo-link">  
        <div class="card card-zo">
          <br>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 d-flex align-items-center justify-content-center">
                <div class="icon-circle-70" style="background-color: rgb(224, 194, 27);">
                  <i class="fa fa-boxes" style="color: white;font-size: 30px"></i>
                </div>
              </div>
              {{-- <div class="col-md-3">
                <i class="fa fa-users" style="font-size: 70px"></i>
              </div> --}}
              <div class="col-md-8">
                <h5>BAGAGE IMPAYE</h5>
                <h2>{{number_format($bagage->where('is_solded',0)->count(), 0, '', ' ')}}</h2>
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
      <a href="{{route('informations-bagage-impayes',['statut'=>'impaye'])}}" class="card-zo-link">  
        <div class="card card-zo" style="border-bottom: 5px solid rgb(73, 224, 27) !important;">
          <br>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 d-flex align-items-center justify-content-center">
                <div class="icon-circle-70" style="background-color: rgb(73, 224, 27);">
                  <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                </div>
              </div>
              {{-- <div class="col-md-3">
                <i class="fa fa-users" style="font-size: 70px"></i>
              </div> --}}
              <div class="col-md-8">
                <h5>MONTANT BAGAGE IMPAYE</h5>
                <h2>{{number_format($bagage->where('is_solded',0)->sum('prix'), 0, '', '.') . " FCFA"}}</h2>
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
      <a href="{{route('informations-bagage-impayes',['statut'=>'paye'])}}" class="card-zo-link">  
        <div class="card card-zo">
          <br>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 d-flex align-items-center justify-content-center">
                <div class="icon-circle-70 bg-danger">
                  <i class="fa fa-boxes" style="color: white;font-size: 30px"></i>
                </div>
              </div>
              {{-- <div class="col-md-3">
                <i class="fa fa-users" style="font-size: 70px"></i>
              </div> --}}
              <div class="col-md-8">
                <h5>BAGAGE PAYE</h5>
                <h2>{{number_format($bagage->where('is_solded',1)->count(), 0, '', ' ')}}</h2>
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

    <div class="col-sm-6 px-2 col-sm-offset-2 ">
      <a href="{{route('informations-bagage-impayes',['statut'=>'paye'])}}" class="card-zo-link">  
        <div class="card card-zo">
          <br>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 d-flex align-items-center justify-content-center">
                <div class="icon-circle-70 bg-primary">
                  <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                </div>
              </div>
              {{-- <div class="col-md-3">
                <i class="fa fa-users" style="font-size: 70px"></i>
              </div> --}}
              <div class="col-md-8">
                <h5>MONTANT BAGAGE PAYE</h5>
                <h2>{{number_format($bagage->where('is_solded',1)->sum('prix'), 0, '', '.') . " FCFA"}}</h2>
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
      <a href="#" class="card-zo-link">  
        <div class="card card-zo">
          <br>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 d-flex align-items-center justify-content-center">
                <div class="icon-circle-70 bg-success">
                  <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                </div>
              </div>
              {{-- <div class="col-md-3">
                <i class="fa fa-users" style="font-size: 70px"></i>
              </div> --}}
              <div class="col-md-8">
                <h6>FRAIS DE ROUTE</h6>
                <h2>{{number_format($bagage->where('is_solded',1)->sum('frais_de_route'), 0, '', '.') . " FCFA"}}</h2>
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
      
  @else
  <div class="row">

    <div class="col-sm-6 px-2">
      <a href="{{route('informations-bagage-impayes',['statut'=>'impaye'])}}" class="card-zo-link">  
        <div class="card card-zo">
          <br>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 d-flex align-items-center justify-content-center">
                <div class="icon-circle-70" style="background-color: rgb(224, 194, 27);">
                  <i class="fa fa-boxes" style="color: white;font-size: 30px"></i>
                </div>
              </div>
              {{-- <div class="col-md-3">
                <i class="fa fa-users" style="font-size: 70px"></i>
              </div> --}}
              <div class="col-md-8">
                <h5>BAGAGE IMPAYE</h5>
                <h2>{{number_format($bagage->where('is_solded',0)->count(), 0, '', ' ')}}</h2>
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
      <a href="{{route('informations-bagage-impayes',['statut'=>'impaye'])}}" class="card-zo-link">  
        <div class="card card-zo" style="border-bottom: 5px solid rgb(73, 224, 27) !important;">
          <br>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 d-flex align-items-center justify-content-center">
                <div class="icon-circle-70" style="background-color: rgb(73, 224, 27);">
                  <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                </div>
              </div>
              {{-- <div class="col-md-3">
                <i class="fa fa-users" style="font-size: 70px"></i>
              </div> --}}
              <div class="col-md-8">
                <h5>MONTANT BAGAGE IMPAYE</h5>
                <h2>{{number_format($bagage->where('is_solded',0)->sum('prix'), 0, '', '.') . " FCFA"}}</h2>
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
      <a href="{{route('informations-bagage-impayes',['statut'=>'paye'])}}" class="card-zo-link">  
        <div class="card card-zo">
          <br>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 d-flex align-items-center justify-content-center">
                <div class="icon-circle-70 bg-danger">
                  <i class="fa fa-boxes" style="color: white;font-size: 30px"></i>
                </div>
              </div>
              {{-- <div class="col-md-3">
                <i class="fa fa-users" style="font-size: 70px"></i>
              </div> --}}
              <div class="col-md-8">
                <h5>BAGAGE PAYE</h5>
                <h2>{{number_format($bagage->where('is_solded',1)->count(), 0, '', ' ')}}</h2>
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

    <div class="col-sm-6 px-2 col-sm-offset-2 ">
      <a href="{{route('informations-bagage-impayes',['statut'=>'paye'])}}" class="card-zo-link">   
        <div class="card card-zo">
          <br>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 d-flex align-items-center justify-content-center">
                <div class="icon-circle-70 bg-primary">
                  <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                </div>
              </div>
              {{-- <div class="col-md-3">
                <i class="fa fa-users" style="font-size: 70px"></i>
              </div> --}}
              <div class="col-md-8">
                <h5>MONTANT BAGAGE PAYE</h5>
                <h2>{{number_format($bagage->where('is_solded',1)->sum('prix'), 0, '', '.') . " FCFA"}}</h2>
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
      <a href="#" class="card-zo-link">  
        <div class="card card-zo">
          <br>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 d-flex align-items-center justify-content-center">
                <div class="icon-circle-70 bg-success">
                  <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                </div>
              </div>
              {{-- <div class="col-md-3">
                <i class="fa fa-users" style="font-size: 70px"></i>
              </div> --}}
              <div class="col-md-8">
                <h6>FRAIS DE ROUTE</h6>
                <h2>{{number_format($bagage->where('is_solded',1)->sum('frais_de_route'), 0, '', '.') . " FCFA"}}</h2>
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
  @endif
</div>



@endsection