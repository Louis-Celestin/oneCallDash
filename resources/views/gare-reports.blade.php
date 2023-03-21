@extends('layouts.master')

@section('content')
     <!-- Main content -->
     <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">Rapport du {{date('d-m-Y', strtotime($debut))}} {{$fin != null && $fin != $debut ? " au " . date('d-m-Y', strtotime($fin)) : "" }}</div>
          <div class="card-body">
           


{{---------------------------------------------------------------------------------}}

<div class="row">

  <div class="col-sm-3 px-2">
     
          <div class="card card-zo">
              <br>
              <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <div class="icon-circle-70 bg-primary">
                        <i class="fa fa-users" style="color: white;font-size: 30px"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                      <h4 class="text-black">Agent</h4>
                      <h3 class="text-black">{{$userReports->count()}}</h3>

                    </div>
                    
                  </div>
              </div>
          </div>
      
  </div>

  <div class="col-sm-3 px-2">
     
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
                      <h4 class="text-black">Bagage (FCFA)</h4>
                      <h3 class="text-black">{{number_format($bagages->where('is_fret', 0)->sum('prix'), 0, '', ' ')}}</h3>

                    </div>
                   
                  </div>
              </div>
          </div>
      
  </div>

  <div class="col-sm-3 px-2">
      
          <div class="card card-zo">
              <br>
              <div class="card-body">
                  <div class="row">
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <div class="icon-circle-70 bg-danger">
                        <i class="fa fa-truck" style="color: white;font-size: 30px"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                      <h4 class="text-black">Frets (FCFA)</h4>
                      <h3 class="text-black">{{number_format($bagages->where('is_fret', 1)->sum('prix'), 0, '', ' ')}}</h3>



                    </div>
                  
                  </div>
              </div>
          </div>
     
  </div>

  <div class="col-sm-3 px-2">
   
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
                    <h4 class="text-black">Global (FCFA)</h4>
                    <h3 class="text-black">{{number_format($bagages->sum('prix'), 0, '', ' ')}}</h3>

                  </div>
                 
                </div>
            </div>
        </div>
  
</div>

</div>










{{------------------------------------------------------------------------------------------------}}


          </div>
        </div>
        {{-- {{dd($userReports->pluck('userName')->toArray())}} --}}
        <div class="row">

          
        </div>



        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between my-2">
                  <h3 class="card-title"><strong>{{$gare->nom_gare}}</strong></h3>
                  <h3 class="card-title"><strong>{{"Rapport par agent"}}</strong></h3>
                </div>
              </div>
              <div class="card-body">
                <table id="aexample1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                        <th>Agent</th>
                        <th>Qte <sup>Impression</sup></th>
                        <th>Qte <sup>Bagages & Fret</sup></th>
                        <th>Montant</th>
                        <th>remises faites</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($userReports as $report)
                      <tr>
                        <td>{{$report->userName}}</td>
                        <td> {{number_format($report->qte_impression, 0, '', ' ')}}</td>
                        <td> {{number_format($report->qte_bagages, 0, '', ' ')}}</td>
                        <td>{{number_format($report->montant, 0, '', ' '). " FCFA" }}</td>
                        <td>
                          @if ($report->mt_remise == 0 )
                            {{0}}   
                          @else
                            {{number_format($report->mt_remise, 0, '', ' '). " FCFA" }}
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between my-2">
                  <h3 class="card-title"><strong>Bagage enregistré(s)</strong></h3>
                  {{-- <h3 class="card-title"><strong>{{"Rapport pa r agent"}}</strong></h3> --}}
                </div>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                        <th>CLIENT</th>
                        <th>BAGAGE</th>
                        <th>QTE</th>
                        <th>MONTANT (FCFA)</th>
                        <th>REMISE (FCFA)</th>
                        <th>PAYÉ (FCFA)</th>
                        <th>AGENT</th>
                        <th>DATE</th>
                        <th>PHOTO</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($enrollements->where('is_fret', 0) as $item)
                      <tr>
                        <td>{{$item->name_passager}}</td>
                        <td>{{$item->type_bagage}}</td>
                        <td>{{$item->nbr_de_bagage}}</td>
                        <td>{{number_format($item->prix + $item->montant, 0, '', ' ')}}</td>
                        <td>{{number_format($item->montant, 0, '', ' ')}}</td>
                        <td>{{number_format($item->prix, 0, '', ' ')}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{date('d/m/Y H:i', strtotime($item->created_at))}}</td>
                        <td>
                          <a class="btn bg-gradient-success" data-target="#detailBagage{{$item->id}}" data-toggle="modal"><i class="fa fa-eye"></i> Voir</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                  
                  {{-- <tfoot>
                    <tr>
                      <th>Agent</th>
                      <th>Qte d'impression</th>
                      <th>Montant</th>
                      <th>remises faites</th>
                    </tr>
                  </tfoot> --}}
                </table>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between my-2">
                  <h3 class="card-title"><strong>Frets enregistré(s)</strong></h3>
                  {{-- <h3 class="card-title"><strong>{{"Rapport pa r agent"}}</strong></h3> --}}
                </div>
              </div>
              <div class="card-body">
                <table id="example3" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                        <th>CLIENT</th>
                        <th>BAGAGE</th>
                        <th>QTE</th>
                        <th>MONTANT (FCFA)</th>
                        <th>REMISE (FCFA)</th>
                        <th>PAYÉ (FCFA)</th>
                        <th>AGENT</th>
                        <th>DATE</th>
                        <th>PHOTO</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($enrollements->where('is_fret', 1) as $item)
                      <tr>
                        <td>{{$item->name_passager}}</td>
                        <td>{{$item->type_bagage}}</td>
                        <td>{{$item->nbr_de_bagage}}</td>
                        <td>{{number_format($item->prix + $item->montant, 0, '', ' ')}}</td>
                        <td>{{number_format($item->montant, 0, '', ' ')}}</td>
                        <td>{{number_format($item->prix, 0, '', ' ')}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{date('d/m/Y H:i', strtotime($item->created_at))}}</td>
                        <td>
                          <a class="btn bg-gradient-success" data-target="#detailBagage{{$item->id}}" data-toggle="modal"><i class="fa fa-eye"></i> Voir</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                  
                  {{-- <tfoot>
                    <tr>
                      <th>Agent</th>
                      <th>Qte d'impression</th>
                      <th>Montant</th>
                      <th>remises faites</th>
                    </tr>
                  </tfoot> --}}
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          
          <div class="col-12">
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Charte par agent</h3>
    
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 452px;" width="904" height="500" class="chartjs-render-monitor"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('modal')
    
  @foreach ($enrollements->where('image', '!=', null) as $item)
    <div class="modal fade" id="detailBagage{{$item->id}}">
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
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>DESCRIPTION</th>
                    <th>VALEUR EN PERTE</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($detailBagage->where('bagage_id',$item->id) as $item)
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

@section('customScripts')
  <!-- Page specific script -->
  <script>
    $(function () {

      
      //-------------
      //- DONUT CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var donutChartCanvas = $('#donutChart').get(0).getContext('2d')

      var donutData        = {
        labels: {!! $userReports->pluck('userName') !!},
        datasets: [
          {
            data: {!! $userReports->pluck('montant') !!},
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
@endsection