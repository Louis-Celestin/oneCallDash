@extends('layouts.master')


@section('content')


<div class="container-fluid">
  {{--<div class="d-flex justify-content-between px-2">
    <h3>Rapport d'activités</h3>
    <div class="d-flex justify-content-end">
        <a class="btn btn-warning" data-toggle="modal" data-target="#rapportAgentModal"> Par Agent</a>
        <a class="btn btn-success mx-2" data-toggle="modal" data-target="#rapportGareModal"> Par gare</a>
    </div>
  </div> --}}
  
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
                                    <select name="gare_id" id="" class="form-control"
                                    onchange="getRequest('{{ url('/') }}/statistique/get_user_by_gare?parent_id='+this.value,'sub-category-select','select')">
                                        @if (Auth::user()->usertype == "admin" || Auth::user()->usertype == "comptable")
                                          <option value="">Toutes les gares</option>
                                        @endif
                                     
          
                                        @foreach ($gares as $c)
                                       
                                        <option value="{{ $c->id }}"
                                            {{ old('name') == $c->id ? 'selected' : '' }}>
                                            {{ $c->nom_gare }}
                                        </option>
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
                                    @if (Auth::user()->usertype == "admin")
                                    <select name="users_id" id="sub-category-select" class="form-control">
                                        <option value="*">Tous les agents</option>
                
                                        </select>
                                        @else
                                        <select name="users_id" id="" class="form-control">
                                            <option value="*">Tous les agents</option>
                                            @foreach ($agents->where('id_module',2) as $item)
                                                <option value="{{$item->id}}" {{session()->get('users_id') == $item->id ? "selected" : ''}} data-id="{{$item->gare_id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                   

                                    
                                </div>
                            </div>
                        </div>
                      
                        <div class="mx-2">
                            <div class="form-group">
                                <label for="users" class="text-muted">Statut</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                    </div>
                                    <select name="statut" id="" class="form-control">
                                       
                                        @if($status=="ENREGISTRÉ"){
                                            <option value="Waiting">Colis expédié</option>
                                            <option value="Waiting">Colis en attente</option>
                                            <option value="Received">Colis receptionné</option>
                                            <option value="Delivered">Colis livré</option>
                                        }
                                        @elseif ($status=="LIVRÉ")
                                        <option value="Delivered">Colis livré</option>
                                        <option value="Waiting">Colis expédié</option>
                                        <option value="Waiting">Colis en attente</option>
                                            <option value="Received">Colis receptionné</option>
                                        @elseif ($status=="RECEPTIONNÉ")
                                        <option value="Received">Colis receptionné</option>
                                        <option value="Delivered">Colis livré</option>
                                        <option value="Waiting">Colis expédié</option>
                                        <option value="Waiting">Colis en attente</option>
                                        @elseif ($status=="EN ATTENTE")
                                        <option value="Waiting">Colis en attente</option>
                                        <option value="Received">Colis receptionné</option>
                                        <option value="Delivered">Colis livré</option>
                                        <option value="Waiting">Colis expédié</option>
                                        @endif
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
@if($status=='ENREGISTRÉ')
    <div class="row"> 
        
        <div class="col-sm-4 px-2">
            <a href="{{route('activites-colis', ['gare_id' => Auth::user()->usertype == "admin" ? '*' : Auth::user()->gare_id, 'statut' => "all",'users_id'=>'*', 'date' => date('Y-m-d')])}}" class="card-zo-link">  
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
                        <h6 style="font-weight: bold">{{$dates[0] == $dates[1] ? (($dates[0] == date('Y-m-d') ? "AUJOURD'HUI" : "Le " .date("d/m/Y", strtotime($dates[1])))): date("d/m/Y", strtotime($dates[0]))." au ". date("d/m/Y", strtotime($dates[1]))}} (FCFA)</h6>
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
            <a href="{{route('activites-colis', ['gare_id' => Auth::user()->usertype == "admin" ? '*' : Auth::user()->gare_id, 'statut' => "all",'users_id'=>'*', 'date' => date('Y-m-d')])}}" class="card-zo-link">  
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
                            <h6 style="font-weight: bold">MOIS ACTUEL ({{date('M')}}) (FCFA)</h6>
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
            <a href="{{route('activites-colis', ['gare_id' => Auth::user()->usertype == "admin" ? '*' : Auth::user()->gare_id, 'statut' => "all",'users_id'=>'*', 'date' => date('Y-m-d')])}}" class="card-zo-link">  
                <div class="card card-zo">
                <br>
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <div class="icon-circle-70 bg-success">
                        <i class="fa fa-calendar" style="color: white;font-size: 30px"></i>
                        </div>
                    </div>
                   
                    <div class="col-md-8">
                        <h6 style="font-weight: bold">ANNEE EN COURS ({{date('Y')}}) (FCFA)</h6>
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
@else
<div class="row"> 
        
    <div class="col-sm-6 px-2 offset-3" >
        <a href="{{route('activites-colis', ['gare_id' => Auth::user()->usertype == "admin" ? '*' : Auth::user()->gare_id, 'statut' => "all",'users_id'=>'*', 'date' => date('Y-m-d')])}}" class="card-zo-link">  
            <div class="card card-zo">
            <br>
            <div class="card-body">
                <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                    <div class="icon-circle-70 bg-primary">
                    <i class="fa fa-calendar-day" style="color: white;font-size: 30px"></i>
                    </div>
                </div>
               
                <div class="col-md-8">
                    <h6 style="font-weight: bold">{{$dates[0] == $dates[1] ? (($dates[0] == date('Y-m-d') ? "AUJOURD'HUI" : "Le " .date("d/m/Y", strtotime($dates[1])))): date("d/m/Y", strtotime($dates[0]))." au ". date("d/m/Y", strtotime($dates[1]))}} (FCFA)</h6>
                    <h2>{{$colis->count(). " enregistrement(s)"}}</h2> 
                    
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
   
@if(Auth::user()->usertype == "admin")
    <div class="card">
        <div class="card-header">
            <strong>LISTE COLIS {{$status}}</strong>
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
                  
        @foreach ($colis->groupBy('ville_expediteur') as $item)

            
               @for ($i=0;$i<1;$i++)
               <tr>
                <td>{{$loop->index+1}}</td>
                <td>{{date('d/m/Y', strtotime($item[$i]->created_at))}}</td>
                <td>{{$item[$i]->ville_expediteur}}</td>
                <td>{{$item->count()}}</td>
                <td>{{number_format($item->sum('prix'), 0, '', '.') . ""}} </td>
                <td>
                    <div class="d-flex justify-content-end">
                      @if($status=='ENREGISTRÉ' || $status=='EN ATTENTE')
                        <a href="{{route('activites-colis-gare',['gare_id' => $item[$i]->gare_id_envoi, 'statut' => $statut,'users_id'=>'*', 'date' =>  date('Y-m-d', strtotime($item[$i]->created_at)) ])}}" class="btn btn-warning" ><i class="fa fa-eye"></i> Détail</a>
                       @else
                       <a href="{{route('activites-colis-gare',['gare_id' => $item[$i]->gare_id_envoi, 'statut' => $statut,'users_id'=>'*', 'date' =>  date('Y-m-d', strtotime($item[$i]->updated_at)) ])}}" class="btn btn-warning" ><i class="fa fa-eye"></i> Détail</a>
                       @endif 
                    </div>
                </td>
            </tr>
               @endfor

  @endforeach
                </tbody>
            </table>
        </div>
    </div> 

@else

<div class="card">
    <div class="card-header">
        <strong>LISTE COLIS {{$status}}</strong>
    </div>
    <div class="card-body">
        <table class="table" id="example1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>CODE</th>
                    
                    <th>COLIS</th>
                    <th>MONTANT</th>
                    <th>EXPEDITEUR</th>
                    <th>DESTINATAIRE</th>
                   
                    <th {{$status=='ENREGISTRÉ'?'hidden':''}}>VILLE D'EXPEDITION</th>
                    <th {{$status=='ENREGISTRÉ'?'':'hidden'}}>VILLE DESTINATION</th>
                    
                   
                   
                </tr>
            </thead>
            <tbody>
       
           @foreach ($colis as $item)

           
           
            <tr>
            <td>{{$loop->index+1}}</td>
            @if ($status=='ENREGISTRÉ' || $status=='EN ATTENTE')
            <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
            @else
            <td>{{date('d/m/Y', strtotime($item->updated_at))}}</td>
            @endif
            
            <td>{{$item->code}}</td>
            <td>{{$item->description}}</td>
            <td>{{number_format($item->prix, 0, '', '.') . ""}}</td>
            <td>{{$item->nom_expediteur}} <br> {{$item->num_expediteur}} </td>
            <td>{{$item->nom_destinataire}}<br> {{$item->num_destinataire}}</td>
            
            <td {{$status=='ENREGISTRÉ'?'hidden':''}}>{{ $item->ville_expediteur}}</td>
            <td {{$status=='ENREGISTRÉ'?'':'hidden'}}>{{$item->ville_destinataire}}</td>
            
            </tr>
@endforeach
            </tbody>
        </table>
    </div>
</div> 





@endif

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

    function getRequest(route, id, type) {
        $.get({
            url: route,
            dataType: 'json',
            success: function(data) {

             //   alert(data.select_tag);
                if (type == 'select') {
                    $('#' + id).empty().append(data.select_tag);
                }
            },
        });
    }

</script>
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