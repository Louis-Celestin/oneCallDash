@extends('layouts.master')

@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Colis egare</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
            <li class="breadcrumb-item active">Colis egare</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>


  <div class="row">
  
        
  <section class="col-lg-12  connectedSortable">

    <!-- Bagages Impayées du jour -->
    <div class="card direct-chat direct-chat-primary ">
      <div class="card-header">
        <h3 class="card-title"><strong>Liste de colis égarés </strong></h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-c ard-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
             
              <th>CODE COLIS</th>
              <th>GARE EMETTRICE</th>
              
              <th>GARE DESTINATRICE</th>
              <th>AGENT RECECEVEUR</th>
              <th>GARE RECEPTRICE</th>   
              <th>DATE DE RECEPTION</th>
              
              
            </tr>
          </thead>
          <tbody>
            @foreach ($colis_egare as $item)
              <tr>
                
                <td>{{$item->code_colis}}</td>
                <td>
                  {{$item->nom_gare_id_envoi}}
                </td>
                <td>{{$item->nom_gare_qui_devait_recevoir}}</td>
                <td>{{$item->nom_agent_qui_a_recu}}</td>
                <td>{{$item->nom_gare_id_recu}}</td>
               
                
                <td>{{  date("d/m/Y", strtotime($item->date_reception)) }}</td>
               
               
              
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        
      </div>
      <!-- /.card-footer-->
    </div>
    <!--/.Bagages Impayées du jour -->

    <!-- Bagages Payées du jour -->
    
    <!--/.Bagages Payées du jour -->
  </section>

</div>





@endsection