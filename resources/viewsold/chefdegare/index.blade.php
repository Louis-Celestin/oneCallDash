@extends('layouts.master')

@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger" style="color: black !important;">
            <div class="inner">
              <p>Tickets Impayées</p>
              <h3>{{$bagages->where('is_solded', 0)->count()}}</h3>
  
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">Jour</a> --}}
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info" style="color: black !important;">
            <div class="inner">
              <p>Montant Impayées (FCFA)</p>
              <h3>{{number_format($bagages->where('is_solded', 0)->sum('prix'), 0, '', ' ')}}</h3>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success" style="color: black !important;">
            <div class="inner">
              <p>Tickets Payées</p>
              <h3>{{$bagages->where('is_solded', 1)->count()}}</h3>
  
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning" style="color: black !important;">
            <div class="inner">
              <p>Montant Payés (FCFA)</p>
              <h3>{{number_format($bagages->where('is_solded', 1)->sum('prix'), 0, '', ' ')}}</h3>
  
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
  
        
        <section class="col-lg-12  connectedSortable">
  
          <!-- Bagages Impayées du jour -->
          <div class="card direct-chat direct-chat-primary ">
            <div class="card-header">
              <h3 class="card-title"><strong>BAGAGE IMPAYÉS DU JOUR </strong></h3>
  
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
                    <th>#</th>
                    <th>CODE</th>
                    <th>GARE</th>
                    <th>CLIENT</th>
                    <th>NUMERO</th>
                    <th>TYPE</th>   
                    <th>BAGAGE</th>
                    <th>QTE BAGAGE</th>
                    <th>MONTANT</th>
                    <th>PHOTO</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($bagages->where('is_solded', 0) as $item)
                    <tr>
                      <td>#{{$loop->index + 1}}</td>
                      <td>{{$item->ref}}</td>
                      <td>
                        {{$gare->nom_gare}}
                      </td>
                      <td>{{$item->name_passager}}</td>
                      <td>{{$item->phone_passager}}</td>
                      <td>
                        @if ($item->is_fret == 0)
                            {{"BAGAGE"}}
                        @else
                          {{"FRET"}}
                        @endif
                      </td>
                      <td>{{$item->type_bagage}}</td>
                      <td>{{$item->nbr_de_bagage}}</td>
                      <td>{{number_format($item->prix, 0, '', ' ')." FCFA"}}</td>
                      <td>
                        @if ($item->image != null)
                        <a class="btn bg-gradient-warning" data-target="#detailBagage{{$item->id}}" data-toggle="modal"><i class="fa fa-eye"></i></a>                         
                        <a class="btn bg-gradient-success" data-target="#confirmPaiement{{$item->id}}" data-toggle="modal"><i class="fa fa-check"></i></a>                               
                        @endif
                      </td>
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
          <div class="card direct-chat direct-chat-primary ">
            <div class="card-header">
              <h3 class="card-title"><strong>BAGAGE PAYÉS DU JOUR </strong></h3>
  
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
              <table id="example3" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>CODE</th>
                    <th>GARE</th>
                    <th>CLIENT</th>
                    <th>NUMERO</th>
                    <th>TYPE</th>
                    <th>BAGAGE</th>
                    <th>QTE BAGAGE</th>
                    <th>MONTANT</th>
                    <th>PHOTO</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($bagages->where('is_solded', 1) as $item)
                    <tr>
                      <td>#{{$loop->index + 1}}</td>
                      <td>{{$item->ref}}</td>
                      <td>
                        {{$gare->nom_gare}}
                      </td>
                      <td>{{$item->name_passager}}</td>
                      <td>{{$item->phone_passager}}</td>
                      <td>
                        @if ($item->is_fret == 0)
                            {{"BAGAGE"}}
                        @else
                          {{"FRET"}}
                        @endif
                      </td>
                      <td>{{$item->type_bagage}}</td>
                      <td>{{$item->nbr_de_bagage}}</td>
                      <td>{{number_format($item->prix, 0, '', ' ')." FCFA"}}</td>
                      <td>
                        @if ($item->image != null)
                        <a class="btn bg-gradient-warning" data-target="#detailBagage{{$item->id}}" data-toggle="modal"><i class="fa fa-eye"></i></a>                         
                        {{-- <a class="btn bg-gradient-success" data-target="#printBagage{{$item->id}}" data-toggle="modal"><i class="fa fa-print"></i></a>                          --}}
                        {{-- <a class="btn bg-gradient-success" href="informations-bagage-payes"><i class="fa fa-print"></i></a>                          --}}
                        @endif
                      </td>
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
          <!--/.Bagages Payées du jour -->
        </section>

      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
@endsection


@section('modal')
  @foreach ($bagages->where('image', '!=', null) as $item)
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
            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>

    <div class="modal fade" id="confirmPaiement{{$item->id}}">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{$item->type_bagage}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form action="{{route('update-ticket-bagage', ['id'=> $item->id])}}" method="post">
              @csrf
              @method("PUT")
              <div class="modal-body">
                <p><h4 class="text-center">Vous confirmez le paiement <br>{{$item->nbr_de_bagage > 1 ? "des bagages" : "du bagage"}}  de <i>{{$item->name_passager}}</i>  pour un <br>montant de <i>{{number_format($item->prix, 0, '', ' '). " FCFA"}}</i> ?  </h4></p>
                <ul>
                  <li><strong>Code :</strong> {{$item->ref}}</li>
                  <li><strong>Client :</strong> {{$item->name_passager}}</li>
                  <li><strong>Téléphone :</strong> {{$item->phone_passager}}</li>
                  <li><strong>Destination :</strong> {{$item->trajet_ville}}</li>
                  <li><strong>Type de bagage :</strong> {{$item->type_bagage}}</li>
                  <li><strong>Montant à payer :</strong> {{number_format($item->prix, 0, '', ' '). " FCFA"}}</li>
                </ul>
              </div>
    
              <div class="modal-footer justify-content-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                <button type="submit" class="btn btn-success">Oui</button>
              </div>
            </form>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>

    <div class="modal fade" id="printBagage{{$item->id}}">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{$item->type_bagage}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <p><h4 class="text-center">Vous confirmez le paiement <br>{{$item->nbr_de_bagage > 1 ? "des bagages" : "du bagage"}}  de <i>{{$item->name_passager}}</i>  pour un <br>montant de <i>{{number_format($item->prix, 0, '', ' '). " FCFA"}}</i> ?  </h4></p>
              <ul>
                <li><strong>Code :</strong> {{$item->ref}}</li>
                <li><strong>Client :</strong> {{$item->name_passager}}</li>
                <li><strong>Téléphone :</strong> {{$item->phone_passager}}</li>
                <li><strong>Destination :</strong> {{$item->trajet_ville}}</li>
                <li><strong>Type de bagage :</strong> {{$item->type_bagage}}</li>
                <li><strong>Montant à payer :</strong> {{number_format($item->prix, 0, '', ' '). " FCFA"}}</li>
              </ul>
            </div>
  
            <div class="modal-footer justify-content-right">
              <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
              <button type="submit" class="btn btn-success">Imprimer</button>
            </div>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>
  @endforeach
@endsection