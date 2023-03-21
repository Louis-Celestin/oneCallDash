@extends('layouts.master')


@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between px-2">
    <h3>Gestion des colis\Rapport d'activités</h3>
    <div class="d-flex justify-content-end">
        <a class="btn btn-warning" data-toggle="modal" data-target="#rapportAgentModal"> Par Agent</a>
        <a class="btn btn-success mx-2" data-toggle="modal" data-target="#rapportGareModal"> Par gare</a>
    </div>
  </div>
  
  <div class="row">
    {{-- <div class="col-sm-3">
        <div class="card my-2">
            <div class="card-body">
                <h5>Montant</h5>
                <h1>{{number_format($colis->sum('prix'), 0, '', ' ')}}</h1>
            </div>
        </div>
    </div> --}}
    <div class="col-sm-12">

        <div class="card my-2">
            <div class="card-body mx-auto">
                <form action="{{route('rapport-colis-search')}}" method="post">
                    @csrf
                    <div class="row d-flex justify-content-center">
                        <div class="mx-2">
                            <div class="form-group">
                                <label for="datestart" class="text-muted">Début </label>
                
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" id="datestart" class="form-control" name="start" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" value="{{$dates[0]}}">
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
                                    <input type="date" id="dateend" class="form-control" name="end" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" value="{{$dates[1]}}">
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
                                        <option value="*">Toutes les gares</option>
                                        @foreach ($gares as $gare)
                                        <option value="{{$gare->id}}">{{$gare->nom_gare}}</option>
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
                                        @foreach ($agents->where('usertype', 'agent') as $agent)
                                        <option value="212" data-id="60">{{$agent->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mx-2">
                            <div class="form-group">
                                <label for="users" class="text-muted">Satut</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                    </div>
                                    <select name="statut" id="" class="form-control">
                                        <option value="*">Tous</option>
                                        <option value="Waiting">Colis expédié</option>
                                        <option value="Received">Colis receptionné</option>
                                        <option value="Delivered">Colis rétiré</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mx-2">
                            <div class="form-group">
                                <label for="">&nbsp;</label>
                                <input type="submit" value="Chercher" class="form-control btn btn-success">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>

    <br>

    <div class="row"> 
        
        <div class="col-sm-4 px-2">
            <a href="{{route('activites-colis', ['gare_id' => Auth::user()->usertype == "admin" ? '*' : Auth::user()->gare_id, 'statut' => "all", 'date' => date('Y-m-d')])}}" class="card-zo-link">  
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
                        <h6>{{$dates[0] == $dates[1] ? (($dates[0] == date('Y-m-d') ? "Aujourd'hui" : "Le " .date("d/m/Y", strtotime($dates[1])))): date("d/m/Y", strtotime($dates[0]))." au ". date("d/m/Y", strtotime($dates[1]))}} (FCFA)</h6>
                        <h2>{{number_format($colis->sum('prix'), 0, '', '.') . ""}}</h2> 
                        <p>{{$colis->count(). " enregistrement(s)"}}</p>
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
            <a href="{{route('activites-colis', ['gare_id' => Auth::user()->usertype == "admin" ? '*' : Auth::user()->gare_id, 'statut' => "all", 'date' => date('Y-m-d')])}}" class="card-zo-link">  
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
                            <h6>Mois actuel ({{date('M')}}) (FCFA)</h6>
                            <h2>{{number_format($colisMonth->sum('prix'), 0, '', '.') . " "}}</h2>
                            <p>{{$colisMonth->count(). " enregistrement(s)"}}</p>
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
            <a href="{{route('activites-colis', ['gare_id' => Auth::user()->usertype == "admin" ? '*' : Auth::user()->gare_id, 'statut' => "all", 'date' => date('Y-m-d')])}}" class="card-zo-link">  
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
                        <h6>Année en cours ({{date('Y')}}) (FCFA)</h6>
                        <h2>{{number_format($colisYear->sum('prix'), 0, '', '.') . ""}}</h2>
                        <p>{{$colisYear->count(). " enregistrement(s)"}}</p>
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

    <br>
  {{--   {{ dd($colis->groupBy('gare_id_envoi')) }} 
    <div class="card">
        <div class="card-header">
            <strong>LISTE DES COLIS</strong>
        </div>
        <div class="card-body">
            <table class="table" id="example1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>CODE</th>
                        <th>GARE</th>
                        <th>COLIS</th>
                        <th>MONTANT</th>
                        <th>CLIENT</th>
                        <th>STATUT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colis as $item)
                    <tr>
                        <td>{{$loop->index +1}}</td>
                        <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                        <td>{{$item->code}}</td>
                        <td>
                            @if ($gares->where('id', $item->gare_id_envoi)->first() != null)
                                {{$gares->where('id', $item->gare_id_envoi)->first()->nom_gare}}
                            @endif
                        </td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->prix}}</td>
                        <td>{{$item->nom_expediteur}}</td>
                        <td>
                            @if ($item->statut == "Waiting")
                                {{"En attente"}}
                            @else
                            {{$item->statut}}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>  --}}

    <div class="card">
        <div class="card-header">
            <strong>LISTE DES COLIS</strong>
        </div>
        <div class="card-body">
            <table class="table" id="example1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                       
                        <th>GARE</th>
                        <th>NOMBRE</th>
                        <th>MONTANT</th>
                        <th>DETAILS</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colis->groupBy('gare_id_envoi') as $item)

                  
                    <tr>
                       
                        <td>{{$loop->index +1}}</td>
                        <td>{{date('d/m/Y', strtotime($item[0]->created_at))}}</td>
                       
                        <td>
                            @if ($gares->where('id', $item[0]->gare_id_envoi)->first() != null)
                                {{$gares->where('id', $item[0]->gare_id_envoi)->first()->nom_gare}}
                            @endif
                        </td>
                        <td>{{$item->count()}}</td>
                        <td>{{number_format($item->sum('prix'), 0, '', '.') . ""}}</td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-warning" data-toggle="modal" data-target="#exampleModal{{ $item[0]->gare_id_envoi }}"><i class="fa fa-eye"></i> Détail</a>
                                
                            </div>
                        </td>
                            
                           

                    </tr>

                    
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> 



</div>



<!-- Modal par agent -->
<div class="modal fade" id="rapportAgentModal" tabindex="-1" role="dialog" aria-labelledby="rapportAgentModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Rapport par Agent</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
          <table class="table" id="example3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>AGENT</th>
                    <th>NOMBRE CLIENT</th>
                    <th>MONTANT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colis->groupBy('users_id') as $item)
                    @foreach ($item as $coli)
                    {{-- {{dd($coli->created_at)}} --}}
                    <tr>
                        <td>#{{$loop->index +1}}</td>
                        <td>{{date('d/m/Y', strtotime($coli->created_at))}}</td>
                        <td>
                            @if ($agents->where('id', $coli->users_id)->first() != null)
                                {{$agents->where('id', $coli->users_id)->first()->name}}
                            @endif
                        </td>
                        <td>{{$item->count('$item->nom_expediteur')}}</td>
                        <td>{{$item->sum('prix')}}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
        </div>
    </div>
</div>


<!-- Modal par gare -->
<div class="modal fade" id="rapportGareModal" tabindex="-1" role="dialog" aria-labelledby="rapportGareModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Rapport par gare</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table" id="example5">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>GARE</th>
                        <th>NOMBRE CLIENT</th>
                        <th>MONTANT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colis->groupBy( 'gare_id_envoi') as $item)
                        @foreach ($item as $coli)
                            <tr>
                                <td>#{{$loop->index +1}}</td>
                                <td>{{date('d/m/Y', strtotime($coli->created_at))}}</td>
                                <td>
                                    @if ($gares->where('id', $coli->gare_id_envoi)->first() != null)
                                        {{$gares->where('id', $coli->gare_id_envoi)->first()->nom_gare}}
                                    @endif
                                </td>
                                <td>{{$item->count('nom_expediteur')}}</td>   
                                <td>{{$item->sum('prix')}}</td>   
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
@foreach ($colis->groupBy('gare_id_envoi') as $item)
        @include('colis.detail')



@endforeach
@endsection

@section('customScripts')
<script>
    $(function () {
  
        @foreach ($colis->groupBy('gare_id_envoi') as $item)
  
        $("#example{{$item[0]->gare_id_envoi}}").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example{{$item[0]->gare_id_envoi}}_wrapper .col-md-12:eq(0)');


      @endforeach
      
    });
  </script>
@endsection