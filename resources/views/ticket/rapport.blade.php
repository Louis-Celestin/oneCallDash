@extends('layouts.master')
{{-- {{dd($bagages)}} --}}

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Rapport d'activités</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
            <li class="breadcrumb-item active">Rapport d'activités</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
<div class="card my-2">
    <div class="card-body mx-auto">
        <form action="{{route('filtre')}}" method="post">
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
                                @foreach ($users->where('id_module',3) as $item)
                                    <option value="{{$item->id}}" {{session()->get('users_id') == $item->id ? "selected" : ''}} data-id="{{$item->gare_id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        @endif
                       

                        
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

<div class="row"></div>
<br>
<div class="row">

   {{-- <div class="col-sm-4 px-2">
        <a href="#{{route('activites-colis', ['gare_id' => '*', 'statut' => "all", 'date' => date("Y-m-d")])}}" class="card-zo-link">
            <div class="card card-zo">
                <br>
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-3 d-flex align-items-center justify-content-center">
                          <div class="icon-circle-70 bg-primary">
                          <i class="fa fa-truck" style="color: white;font-size: 30px"></i>
                          </div>
                      </div>
                      <div class="col-md-8">
                          <h6  style="font-weight: bold;">MONTANT GLOBAL FRET (FCFA) </h6>
                          <h5>{{number_format($bagages->where('is_fret', 1)->sum('prix'), 0 , '', ' ')}}</h5>

                      </div>
                      <div class="col-md-1 d-flex align-items-center">
                          <i class="fa fa-chevron-right"></i>
                      </div>
                    </div>
                </div>
            </div>
        </a>
    </div>--}}

    <div class="col-sm-6 px-2">
        <a href="{{route('report-ticket')}}" class="card-zo-link">
            <div class="card card-zo">
                <br>
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-3 d-flex align-items-center justify-content-center">
                          <div class="icon-circle-70 bg-warning">
                          <i class="fa fa-suitcase-rolling" style="color: white;font-size: 30px"></i>
                          </div>
                      </div>
                      <div class="col-md-8">
                          <h6 style="font-weight: bold;">NOMBRE TICKET  </h6>
                          <h5>{{number_format($tickets->count(), 0 , '', ' ')}}</h5>

                      </div>
                      
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6  px-2">
      <a href="{{route('report-ticket')}}" class="card-zo-link">
          <div class="card card-zo">
              <br>
              <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <div class="icon-circle-70 bg-success">
                        <i class="fa fa-money-bill" style="color: white;font-size: 30px"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 style="font-weight: bold;">MONTANT TICKET (FCFA) </h6>
                        <h5>{{number_format($tickets->sum('prix'), 0 , '', ' ')}}</h5>

                    </div>
                    
                  </div>
              </div>
          </div>
      </a>
  </div>


  </div>











<div class="row my-2">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">RAPPORT GLOBAL QTE </h3>
          
          @if (Auth::user()->usertype !='admin')
          <a href="{{route('gare-reports', ['id'=>Auth::user()->gare_id, 'user_id' => session()->has('users_id') ? session()->get('users_id') : '*', 'debut' => session()->has('start') ? session()->get('start') : date('Y-m-d'), 'fin' => session()->has('end') ? session()->get('end') : date('Y-m-d')])}}" class="btn btn-success">
            <i class="fa fa-chart-pie"></i>
            Rapport détaillé
        </a>
          @endif
       
        </div>
       
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example3" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>TYPE</th>
                <th>Qte <sup>Impression</sup> </th>
                <th>Qte <sup>Ticket</sup> </th>
                <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>TICKET</td>
              <td>{{number_format($rapportType->count('prix'), 0, '', ' ')}}</td>
              <td>{{number_format($rapportType->sum('nbr_ticket'), 0, '', ' ')}}</td>
              <td>{{number_format($rapportType->sum('prix'), 0, '', ' ') . " FCFA"}}</td>
            </tr>
       
          </tbody>
          {{-- <tfoot>
            <tr>
              <th>Nom</th>
              <th>Ville</th>
              <th>Adresse</th>
              <th>Chef de Gare</th>
              <th class="text-center">Actions</th>
            </tr>
          </tfoot> --}}
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div>
{{--
<div class="row my-2">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">RAPPORT GARE | TRANSPORTS SMT</h3>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>Gare</th>
                <th>Qte <sup>Impression</sup></th>
                <th>Qte <sup>Bagages</sup></th>
                <th>Global</th>
                <th>Remise</th>
                <th>Total</th>
                <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($rapportGares as $gare)
              <tr>
                <td>{{$gare->nom_gare}}</td>
                <td>{{number_format($gare->qte_impression, 0, '', ' ')}}</td>
                <td>{{number_format($gare->qte_bagage, 0, '', ' ')}}</td>
                <td>{{number_format($gare->prix + $gare->montant_remises, 0, '', ' ')}}</td>
                <td>{{number_format($gare->montant_remises, 0, '', ' ')}}</td>
                <td>{{number_format($gare->prix, 0, '', ' ')}}</td>
                <td class="text-center">
                    <a href="{{route('gare-reports', ['id'=>$gare->id, 'user_id' => session()->has('users_id') ? session()->get('users_id') : '*', 'debut' => session()->has('start') ? session()->get('start') : date('Y-m-d'), 'fin' => session()->has('end') ? session()->get('end') : date('Y-m-d')])}}" class="btn btn-success">
                        <i class="fa fa-chart-pie"></i>
                        Rapport détaillé
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
--}}



<div class="row my-2">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">RAPPORT FILTRE JOURNALIER</h3>
          <a class="btn btn-primary" target="_blank" href="{{ route('stat.pdf_ticket') }}">Impression</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example3" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>ID</th>
                <th>JOUR</th>
                <th>QTE TICKET</th>
               
                <th>MONTANT TOTAL</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($ticketsGroupedByCreatedAt as $ticket)
              <tr>
                <td>{{$loop->index + 1}}</td>
                <td>{{date('d/m/Y', strtotime($ticket->date))}}</td>
                <td>{{number_format($ticket->nbr_tickets, 0, '', ' ')}}</td>
              
                <td>{{number_format($ticket->prix, 0, '', ' ')}}</td>
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

  <!-- Page specific script -->
  <script>


      //-------------
      //- DONUT CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
      var donutData        = {
        labels: [
            'Adjame',
            'Yamoussoukro',
            'Boundiali',
            'Bouake',
            'Korhogo',
        ],
        datasets: [
          {
            data: [700,500,400,600,300],
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
          }
        ]
      }
      var donutOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
      })

      //-------------
      //- PIE CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
      var pieData        = donutData;
      var pieOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      })

    });
  </script>

    <script>
    </script>
@endsection


