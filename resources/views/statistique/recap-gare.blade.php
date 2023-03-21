@extends('layouts.master')
{{-- {{dd($bagages)}} --}}

@section('content')
<div class="card my-2">
    <div class="card-body mx-auto">
        <form action="{{ route('stat.post_recap_gare') }}" method="post">
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

{{--
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
                </div> --}}
                <div class="mx-2">
                    <div class="form-group">
                        <label for="users" class="text-muted">Bagage(s){{--/Fret(s) --}} </label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                            </div>
                            <select name="bagage_id" id="sub-category-select" class="form-control" >
                            <option value="0">Bagages</option>
                          {{--  <option value="1">Frets</option> --}}

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


<div class="row my-2">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">RAPPORT RECAPITULATIF PAR GARE</h3>
          <a class="btn btn-danger" target="_blank" href="{{ route('stat.pdf_recap_by_gare') }}">Impression</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example3" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>Gare </th>


                <th>Qte <sup>Bagages</sup></th>
                <th>Montant <sup>CFA</sup></th>
            </tr>
          </thead>
          <tbody>

            @foreach ($rapportGare as $data)
                <tr>
                    <td>{{ $data->nom_gare }}</td>
                    <td>{{ $data->qte_bagage }}</td>
                    <td>{{ $data->prix }}</td>
                </tr>
            @endforeach

          </tbody>

        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div>

<div class="row my-2">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between my-2">
            <h3 class="card-title">STATISTIQUE  PAR NOMBRE DE GARE | TRANSPORTS AVS</h3>
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

  <div class="row my-2">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between my-2">
            <h3 class="card-title">STATISTIQUE DE RECETTE PAR BAGAGE | TRANSPORTS AVS</h3>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
  </div>

  <?php
$data = [];
$databg = [];

for ($i=0; $i < count($rapportGare) ; $i++) {
    $data[]=  array("label"=> $rapportGare[$i]->nom_gare, "y"=> $rapportGare[$i]->prix)  ;
    $databg[]=  array("label"=> $rapportGare[$i]->nom_gare, "y"=> $rapportGare[$i]->qte_bagage)  ;
};
//dd($data);
$dataPoints1  = ($data);
$dataPoints2  = ($databg);



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
            name: "BAGAGES",
            indexLabel: "{y}",
            yValueFormatString: "",
            showInLegend: true,
            dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
        }
    ]
    });
    var chart2 = new CanvasJS.Chart("chartContainer2", {
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
            name: "BAGAGES",
            indexLabel: "{y}",
            yValueFormatString: "",
            showInLegend: true,
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        }
    ]
    });
    chart.render();
    chart2.render();

    function toggleDataSeries(e){
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        }
        else{
            e.dataSeries.visible = true;
        }
        chart.render();
        chart2.render();
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


