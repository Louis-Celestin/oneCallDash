@extends('layouts.master')


@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Gestion des remises</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Accueil</a></li>
          <li class="breadcrumb-item active">Gestion des remises</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="card my-2">
  <div class="card-body mx-auto">
      <form action="{{route('filtre-remises')}}" method="post">
          @csrf
          <div class="row d-flex justify-content-center">
              <div class="mx-2">
                  <div class="form-group">
                      <label for="datestart" class="text-muted">Début </label>
      
                      <div class="input-group">
                          <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="date" id="datestart" class="form-control" name="start"  data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" value="{{session()->has('start') ? session()->get('start') : date('Y-m-d')}}">
                      </div>
                      <!-- /.input group -->
                  </div>
              </div>
              <div class="mx-2">
                  <div class="form-group">
                      <label for="dateend" class="text-muted">Fin </label>
      
                      <div class="input-group">
                          <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="date" id="dateend" class="form-control" name="end"  data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" value="{{session()->has('end') ? session()->get('end') : date('Y-m-d')}}">
                      </div>
                      <!-- /.input group -->
                  </div>
              </div>

              <div class="mx-2">
                  <div class="form-group">
                      <label for="gares" class="text-muted">Gare(s) </label>
      
                      <div class="input-group">
                          <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-bus"></i></span>
                          </div>
                          <select name="gare_id" id="" class="form-control">
                              @if (Auth::user()->usertype == "admin" || Auth::user()->usertype == "comptable")
                                <option value="*">Toutes les gares</option>
                              @endif
                              @foreach ($gares as $item)
                                  <option value="{{$item->id}}" {{session()->get('gare_id') == $item->id ? "selected" : ''}}>{{$item->nom_gare}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
              </div>
              <div class="mx-2">
                  <div class="form-group">
                      <label for="users" class="text-muted">Agent(s) </label>
      
                      <div class="input-group">
                          <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                          </div>
                          <select name="users_id" id="" class="form-control">
                              <option value="*">Tous les agents</option>
                              @foreach ($users as $item)
                                  <option value="{{$item->id}}" {{session()->get('users_id') == $item->id ? "selected" : ''}} data-id="{{$item->gare_id}}">{{$item->name}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
              </div>
              <div class="mx-2">
                  <div class="form-group">
                      <label for="">&nbsp;</label>
                      <input type="submit" value="Chercher" class="form-control btn btn-success">
                      {{-- <button class="btn btn-secondary" class="form-control"> </button> --}}
                  </div>
              </div>
          </div>
      </form>
  </div>
</div>


<div class="row">

  <div class="col-sm-4 px-2">
      <a href="#" class="card-zo-link">
          <div class="card card-zo">
              <br>
              <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <div class="icon-circle-70 bg-primary">
                        <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                      <p><b>Remise Jour {{session()->has('start') ? "du ". date("d/m/Y", strtotime(session()->get('start'))) : ""}} {{session()->has('end') && session()->get('start') != session()->get('end')? "au ". date("d/m/Y", strtotime(session()->get('end'))) : ""}} </b></p>
                      <h3>{{number_format( session()->has('end') && session()->get('start') != session()->get('end')? $remises->sum('montant_remises') : $jour->sum('montant_remises'), 0 , '', ' ')}}</h3>
                
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <i class="fa fa-chevron-right"></i>
                    </div>
                  </div>
              </div>
          </div>
      </a>
  </div>

  <div class="col-sm-4 px-2">
      <a href="#" class="card-zo-link">
          <div class="card card-zo">
              <br>
              <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <div class="icon-circle-70 bg-warning">
                        <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                      <p><b> Remises mensuelles (FCFA)</b></p>
                      <h3>{{number_format($mois->sum('montant_remises'), 0 , '', ' ')}}</h3>
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <i class="fa fa-chevron-right"></i>
                    </div>
                  </div>
              </div>
          </div>
      </a>
  </div>

  <div class="col-sm-4 px-2">
      <a href="#" class="card-zo-link">
          <div class="card card-zo">
              <br>
              <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <div class="icon-circle-70 bg-danger">
                        <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                      <p><b> Rémise Annuelle (FCFA) </b></p>
                      <h3>{{number_format($year->sum('montant_remises'), 0 , '', ' ')}}</h3>
                
                        
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <i class="fa fa-chevron-right"></i>
                    </div>
                  </div>
              </div>
          </div>
      </a>
  </div>


  
  
  



</div>





     <!-- Mes remises -->
     <div class="card direct-chat direct-chat-primary ">
        <div class="card-header">
          <h3 class="card-title"><strong>Démandes de rémises</strong></h3>

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
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>GARE</th>
                  <th>BAGAGE</th>
                  <th>AGENT</th>
                  <th>QTE</th>
                  <th>MONTANT GLOBAL (FCFA)</th>
                  <th>REMISE (FCFA)</th>
                  <th>PAYÉ (FCFA)</th>
                  <th>TYPE</th>
                  <th>ACTIONS</th>
                </tr>
              </thead>
              <tbody>
                {{-- {{dd($remises)}} --}}
                @foreach ($remises as $item)
                  <tr>
                    <td>{{$item->nom_gare}}</td>
                    <td>{{$item->type_bagage}}</td>
                    <td>{{$item->name}} <br> {{$item->phone}}</td>
                    <td>{{$item->nbr_de_bagage}}</td>
                    <td>{{number_format($item->montant + $item->prix, 0, '', ' ')}}</td>
                    <td>{{number_format($item->montant, 0, '', ' ')}}</td>
                    <td>{{number_format($item->prix, 0, '', ' ')}}</td>
                    <td>{{$item->is_fret  ? "FRET" : "BUS"}}</td>
                    <td>
                      <a class="btn bg-gradient-success" data-target="#detailBagage{{$item->bagage_id}}" data-toggle="modal"><i class="fa fa-eye"> Details</i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td colspan="4" class="text-center">
                    <strong>TOTAL DES REMISES : {{number_format($remises->sum('montant_remises'), 0, '', ' ') . " FCFA"}}</strong>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
      </div>
      <!--/.Mes remises -->

      
     <!-- Mes remises -->
     <div class="card direct-chat direct-chat-primary ">
      <div class="card-header">
        <h3 class="card-title"><strong>Meilleur agent de remise.</strong></h3>
      </div>
      <!-- /.card-header -->
        <div class="card-body">
          <table id="example3" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>AGENT</th>
                {{-- <th>GARE</th> --}}
                <th>QTE</th>
                {{-- <th>MONTANT GLOBAL (FCFA)</th> --}}
                <th>REMISE (FCFA)</th>
                {{-- <th>PAYÉ (FCFA)</th> --}}
              </tr>
            </thead>
            <tbody>
              {{-- {{dd($todayBagage->groupBy('gare_id')['42'])}} --}}
              @foreach ($remisesParAgent as $item)
                <tr>
                  <td>{{$loop->index + 1}}</td>
                  <td>
                    @if ($users->where('id', $item->id)->first() != null)
                    {{$users->where('id', $item->id)->first()->name}}
                    @endif
                  </td>
                  {{-- <td>
                    @if ($users->where('id', $item->id)->first() != null)
                      @if ($gares->where('id', $users->where('id', $item->id)->first()->id)->first() != null)
                          {{$gares->where('id', $users->where('id', $item->id)->first()->id)->first()->nom_gare}}
                      @endif
                    @endif
                  </td> --}}
                  <td>{{$item->qte}}</td>
                  {{-- <td>{{number_format($item->montant + $item->prix, 0, '', ' ')}}</td> --}}
                  <td>{{number_format($item->montant_remises, 0, '', ' ')}}</td>
                  {{-- <td>{{number_format($item->prix, 0, '', ' ')}}</td> --}}
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td></td>
                <td></td>
                <td colspan="3">
                  <strong>TOTAL DES REMISES : {{number_format($remisesParAgent->sum('montant_remises'), 0, '', ' ') . " FCFA"}}</strong>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
    </div>
    <!--/.Mes remises -->
@endsection


@section('modal')

  @foreach ($remises as $item)
    <div class="modal fade" id="detailBagage{{$item->bagage_id}}">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{$item->nbr_de_bagage}} Bagages pour {{$item->name_passager}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <img src="https://ocl.ci/storage/bagages/{{$item->image}}" alt="les bagages de {{$item->name_passager}}" height="auto" width="100%">
              <table id="example7" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>DESCRIPTION</th>
                    <th>VALEUR EN PERTE</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($detailBagage->where('bagage_id',$item->bagage_id) as $item)
                    <tr>
                      <td>#{{$item->id}}</td>
                      <td>{{$item->description}}</td>
                      <td>{{number_format($item->valperte_detail, 0, '', ' '). " FCFA"}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>
  @endforeach

@endsection