@extends('layouts.master')


@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between px-2">
    <h3>Vue d'ensemble</h3>
    <h3>Administrateur</h3>
  </div>
  
  <br>

  @if (Auth::user()->usertype == 'admin')
    <div class="row">

      <div class="col-sm-6 px-2">
        <a href="{{route('activites-colis', ['gare_id' => '*', 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">  
          <div class="card card-zo">
            <br>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                  <div class="icon-circle-70" style="background-color: rgb(224, 194, 27);">
                    <i class="fa fa-users" style="color: white;font-size: 30px"></i>
                  </div>
                </div>
                {{-- <div class="col-md-3">
                  <i class="fa fa-users" style="font-size: 70px"></i>
                </div> --}}
                <div class="col-md-8">
                  <h5>COLIS ENREGISTRÉ</h5>
                  <h2>{{number_format($colis->count('nbre_colis'), 0, '', ' ')}}</h2>
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
        <a href="{{route('activites-colis', ['gare_id' => '*', 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">  
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
                  <h5>MONTANT COLIS</h5>
                  <h2>{{number_format($colis->sum('prix'), 0, '', '.') . " FCFA"}}</h2>
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


      <div class="col-sm-4 px-2">
        <a href="{{route('activites-colis', ['gare_id' => '*', 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">  
          <div class="card card-zo">
            <br>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                  <div class="icon-circle-70 bg-danger">
                    <i class="fa fa-envelope" style="color: white;font-size: 30px"></i>
                  </div>
                </div>
                {{-- <div class="col-md-3">
                  <i class="fa fa-users" style="font-size: 70px"></i>
                </div> --}}
                <div class="col-md-8">
                  <h6>Quantité colis</h6>
                  <h2>{{$colis->where('statut', 'Waiting')->sum('nbre_colis')}}</h2>
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

      <div class="col-sm-4 px-2">
        <a href="{{route('activites-colis', ['gare_id' => '*', 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">  
          <div class="card card-zo">
            <br>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                  <div class="icon-circle-70 bg-primary">
                    <i class="fa fa-boxes" style="color: white;font-size: 30px"></i>
                  </div>
                </div>
                {{-- <div class="col-md-3">
                  <i class="fa fa-users" style="font-size: 70px"></i>
                </div> --}}
                <div class="col-md-8">
                  <h6>Colis en attente</h6>
                  <h2>{{$colis->where('statut', 'Received')->sum('nbre_colis')}}</h2>
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

      <div class="col-sm-4 px-2">
        <a href="{{route('activites-colis', ['gare_id' => '*', 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">  
          <div class="card card-zo">
            <br>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                  <div class="icon-circle-70 bg-success">
                    <i class="fa fa-paper-plane" style="color: white;font-size: 30px"></i>
                  </div>
                </div>
                {{-- <div class="col-md-3">
                  <i class="fa fa-users" style="font-size: 70px"></i>
                </div> --}}
                <div class="col-md-8">
                  <h6>Colis Livré</h6>
                  <h2>{{$colis->where('statut', 'Delivered')->sum('nbre_colis')}}</h2>
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
        <a href="{{route('activites-colis', ['gare_id' => Auth::user()->gare_id, 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">  
          <div class="card card-zo">
            <br>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                  <div class="icon-circle-70" style="background-color: rgb(224, 194, 27);">
                    <i class="fa fa-users" style="color: white;font-size: 30px"></i>
                  </div>
                </div>
                {{-- <div class="col-md-3">
                  <i class="fa fa-users" style="font-size: 70px"></i>
                </div> --}}
                <div class="col-md-8">
                  <h5>COLIS ENREGISTRÉ</h5>
                  <h2>{{number_format($colis->count('nbre_colis'), 0, '', ' ')}}</h2>
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
        <a href="{{route('activites-colis', ['gare_id' => Auth::user()->gare_id, 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">  
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
                  <h5>MONTANT COLIS</h5>
                  <h2>{{number_format($colis->sum('prix'), 0, '', '.') . " FCFA"}}</h2>
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


      <div class="col-sm-4 px-2">
        <a href="{{route('activites-colis', ['gare_id' => Auth::user()->gare_id, 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">  
          <div class="card card-zo">
            <br>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                  <div class="icon-circle-70 bg-danger">
                    <i class="fa fa-envelope" style="color: white;font-size: 30px"></i>
                  </div>
                </div>
                {{-- <div class="col-md-3">
                  <i class="fa fa-users" style="font-size: 70px"></i>
                </div> --}}
                <div class="col-md-8">
                  <h6>Quantité colis</h6>
                  <h2>{{$colis->where('statut', 'Waiting')->sum('nbre_colis')}}</h2>
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

      <div class="col-sm-4 px-2">
        <a href="{{route('activites-colis', ['gare_id' => Auth::user()->gare_id, 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">  
          <div class="card card-zo">
            <br>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                  <div class="icon-circle-70 bg-primary">
                    <i class="fa fa-boxes" style="color: white;font-size: 30px"></i>
                  </div>
                </div>
                {{-- <div class="col-md-3">
                  <i class="fa fa-users" style="font-size: 70px"></i>
                </div> --}}
                <div class="col-md-8">
                  <h6>Colis en attente</h6>
                  <h2>{{$colis->where('statut', 'Received')->sum('nbre_colis')}}</h2>
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

      <div class="col-sm-4 px-2">
        <a href="{{route('activites-colis', ['gare_id' => Auth::user()->gare_id, 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">  
          <div class="card card-zo">
            <br>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                  <div class="icon-circle-70 bg-success">
                    <i class="fa fa-paper-plane" style="color: white;font-size: 30px"></i>
                  </div>
                </div>
                {{-- <div class="col-md-3">
                  <i class="fa fa-users" style="font-size: 70px"></i>
                </div> --}}
                <div class="col-md-8">
                  <h6>Colis Livré</h6>
                  <h2>{{$colis->where('statut', 'Delivered')->sum('nbre_colis')}}</h2>
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