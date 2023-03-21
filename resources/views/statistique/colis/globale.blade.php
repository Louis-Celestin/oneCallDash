@extends('layouts.master')
{{-- {{dd($bagages)}} --}}

@section('content')
<div class="card my-2">
    <div class="card-body mx-auto">
        <form action="{{ route('stat.colis_post_globale') }}" method="post">
            @csrf
            <div class="row d-flex justify-content-center">
             {{--    <div class="mx-2">
                    <div class="form-group">
                        <label for="datestart" class="text-muted">Début </label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" id="datestart" class="form-control" name="start"  data-inputmask-alias="datetime" data-inputmask-inputformat="mm/yyyy" data-mask="" inputmode="numeric" value="{{session()->has('start') ? session()->get('start') : date('Y-m')}}">
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
                            <input type="date" id="dateend" class="form-control" name="end"  data-inputmask-alias="datetime" data-inputmask-inputformat="mm/yyyy" data-mask="" inputmode="numeric" value="{{session()->has('end') ? session()->get('end') : date('Y-m')}}">
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
 --}}

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
                              {{--    @foreach ($gares as $item)
                                    <option value="{{$item->id}}" {{session()->get('gare_id') == $item->id ? "selected" : ''}}>{{$item->nom_gare}}</option>
                                @endforeach   --}}

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
                            <select name="users_id" id="sub-category-select" class="form-control"

                            >
                            <option value="">Tous les agents</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="mx-2">

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


<div class="row my-2">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">STATISTIQUE ANNUEL(S) PAR GARE</h3>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div>


<?php
 $now =now()->format("Y-m");
 //dd($stat_bagage->where('created_at', 'like', '%' . $now  . '%')->sum('prix'));

         $datetime0 = new \DateTime($now);     $datetime0->modify("+0 months");  $str_datetime0 = $datetime0->format("Y-m");
         $datetime1 = new \DateTime($now);     $datetime1->modify("-1 months");  $str_datetime1 = $datetime1->format("Y-m");
         $datetime2 = new \DateTime($now);     $datetime2->modify("-2 months");  $str_datetime2 = $datetime2->format("Y-m");
         $datetime3 = new \DateTime($now);     $datetime3->modify("-3 months");  $str_datetime3 = $datetime3->format("Y-m");
         $datetime4 = new \DateTime($now);     $datetime4->modify("-4 months");  $str_datetime4 = $datetime4->format("Y-m");
         $datetime5 = new \DateTime($now);     $datetime5->modify("-5 months");  $str_datetime5 = $datetime5->format("Y-m");
         $datetime6 = new \DateTime($now);     $datetime6->modify("-6 months");  $str_datetime6 = $datetime6->format("Y-m");
         $datetime7 = new \DateTime($now);     $datetime7->modify("-7 months");  $str_datetime7 = $datetime7->format("Y-m");
         $datetime8 = new \DateTime($now);     $datetime8->modify("-8 months");  $str_datetime8 = $datetime8->format("Y-m");
         $datetime9 = new \DateTime($now);     $datetime9->modify("-9 months");  $str_datetime9 = $datetime9->format("Y-m");
         $datetime10 = new \DateTime($now);    $datetime10->modify("-10 months"); $str_datetime10 = $datetime10->format("Y-m");
         $datetime11 = new \DateTime($now);    $datetime11->modify("-11 months"); $str_datetime11 = $datetime11->format("Y-m");


       //  dd( ($stat_bagage->where('is_fret', 0)) );
//dd($stat_bagage->where('bagage.created_at', 'like', '%' . $now . '%' ));

$dataPoints1 = array(

                            array("label"=> $str_datetime11, "y"=> $stat_colisLivre11),
                            array("label"=> $str_datetime10, "y"=> $stat_colisLivre10),
                            array("label"=> $str_datetime9, "y"=> $stat_colisLivre9),
                            array("label"=> $str_datetime8, "y"=> $stat_colisLivre8),
                            array("label"=> $str_datetime7, "y"=> $stat_colisLivre7),
                            array("label"=> $str_datetime6, "y"=> $stat_colisLivre6),
                            array("label"=> $str_datetime5, "y"=> $stat_colisLivre5),
                            array("label"=> $str_datetime4, "y"=> $stat_colisLivre4),
                            array("label"=> $str_datetime3, "y"=> $stat_colisLivre3),
                            array("label"=> $str_datetime2, "y"=> $stat_colisLivre2),
                            array("label"=> $str_datetime1, "y"=> $stat_colisLivre1),
                            array("label"=> $str_datetime0, "y"=> $stat_colisLivre0)

);

$dataPoints2 = array(

                            array("label"=> $str_datetime11, "y"=> $stat_colisrecus11),
                            array("label"=> $str_datetime10, "y"=> $stat_colisrecus10),
                            array("label"=> $str_datetime9, "y"=> $stat_colisrecus9),
                            array("label"=> $str_datetime8, "y"=> $stat_colisrecus8),
                            array("label"=> $str_datetime7, "y"=> $stat_colisrecus7),
                            array("label"=> $str_datetime6, "y"=> $stat_colisrecus6),
                            array("label"=> $str_datetime5, "y"=> $stat_colisrecus5),
                            array("label"=> $str_datetime4, "y"=> $stat_colisrecus4),
                            array("label"=> $str_datetime3, "y"=> $stat_colisrecus3),
                            array("label"=> $str_datetime2, "y"=> $stat_colisrecus2),
                            array("label"=> $str_datetime1, "y"=> $stat_colisrecus1),
                            array("label"=> $str_datetime0, "y"=> $stat_colisrecus0)

);




?>





@endsection



@section('modal')

@endsection


@section('customScripts')

<script>
    window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title:{
            text: ""
        },
        axisY:{
            includeZero: true
        },
        legend:{
            cursor: "pointer",
            verticalAlign: "center",
            horizontalAlign: "right",
            itemclick: toggleDataSeries
        },
        data: [{
            type: "column",
            name: "COLIS LIVRE",
            indexLabel: "{y}",
            yValueFormatString: "",
            showInLegend: true,
            dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
        }
       , {
            type: "column",
            name: "COLIS RECUS",
            indexLabel: "{y}",
            yValueFormatString: "",
            showInLegend: true,
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        }

    ]
    });
    chart.render();

    function toggleDataSeries(e){
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        }
        else{
            e.dataSeries.visible = true;
        }
        chart.render();
    }

    }
    </script>



<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

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
@endsection


