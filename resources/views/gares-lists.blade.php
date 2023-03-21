@extends('layouts.master')

@section('content')
{{-- <div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <p>Nombre Gares</p>
        <h3>{{$gares->count()}}</h3>

      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <p>Montant Global Bagage</p>
        <h3>{{number_format(0, 0 , '', ' ') . " FCFA"}}</h3>

      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <p>Montant Global Fret</p>
        <h3>{{number_format(0, 0 , '', ' ') . " FCFA"}}</h3>

      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <p>Montant Global Fret & Bagage</p>
        <h3>{{number_format(0, 0 , '', ' ') . " FCFA"}}</h3>

      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
    </div>
  </div>
</div> --}}
<div class="row msy-5">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">UTILISATEURS | TRANSPORTS SMT</h3>
          <a data-target="#addUser" data-toggle="modal" class="btn btn-primary">Ajouter</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>Nom</th>
                <th>Ville</th>
                <th>Adresse</th>
                <th>Chef de Gare</th>
                <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($gares as $gare)
              <tr>
                <td>{{$gare->nom_gare}}</td>
                <td>{{$gare->ville_gare}}</td>
                <td>{{$gare->adresse}}</td>
                <td>
                  @if ($gare->users_id != null)
                    {{$users->where('id', $gare->users_id)->first() != null ? $users->where('id', $gare->users_id)->first()->name  ." (". $users->where('id', $gare->users_id)->first()->phone.")" : "Aucun"}}</td>
                  @endif
                <td class="text-center">
                    <a href="{{ route('edit-gare', ['id' => $gare->id])}}" class="btn btn-warning text-white">
                        <i class="fa fa-edit"></i>
                        Modifier
                    </a>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Nom</th>
              <th>Ville</th>
              <th>Adresse</th>
              <th>Chef de Gare</th>
              <th class="text-center">Actions</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="addUser">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('storeGare')}}" method="post">
        @csrf 
        <div class="modal-header">
          <h4 class="modal-title text-center">Ajouter une gare</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nom_gare">Nom : </label>
                <input type="text" class="form-control" name="nom_gare" value="{{old('nom_gare')}}">
              </div>
            </div>
            
            <div class="col-sm-6">
              <div class="form-group">
                <label for="ville_gare">Ville : </label>
                <input type="text" class="form-control" name="ville_gare" value="{{old('ville_gare')}}">
              </div>
            </div>
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="adresse">Adresse : </label>
                <input type="text" class="form-control" name="adresse" value="{{old('adresse')}}">
              </div>
            </div>
            
            <div class="col-sm-12">
              <div class="form-group">
                <select name="users_id" id="" class="form-control">
                  <option value="">--</option>
                  @foreach ($users->where('usertype', 'chefgare') as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary">Créer</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
</div>
@endsection


@section('customScripts')
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
@endsection


