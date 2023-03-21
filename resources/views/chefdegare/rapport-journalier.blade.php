@extends('layouts.master')

@section('title')
    {{session()->has('date') ? date('d-m-Y', strtotime(session()->get('date'))) : date('d-m-Y') ." TOTAL : ". number_format($rapports->sum('prix_depart'), 0, '', ' '). "F |"}}
@endsection

@section('content')
<div class="content-header">

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Rapport Journalier bagage du  {{ session()->has('date') ? date('d-m-Y', strtotime(session()->get('date'))) : date('d-m-Y')}}</h1>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    <form action="{{route('search-rapport-caissiere')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <input type="date" name="date" id="date" value="{{session()->has('date') ? session()->get('date') : date('Y-m-d')}}" max="{{date('Y-m-d')}}" required placeholder="Date de recherche" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-success"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>DEPART</th>
                            <th>HEURE</th>
                            <th>QTE CLIENT</th>
                            <th>QTE BAGAGE</th>
                            <th>MONTANT (FCFA)</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($rapports as $item)
                            <tr>
                                <td>#{{$loop->index + 1}}</td>
                                <td>{{$item->nom_depart}}</td>
                                <td>
                                    {{$item->heure_depart}}
                                </td>
                                <td>{{number_format($item->qte_client, 0, '', ' ')}}</td>
                                <td>{{number_format($item->qte_bagage, 0, '', ' ')}}</td>
                                <td>{{number_format($item->prix_depart, 0, '', ' ').""}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>TOTAL</td>
                                <td>{{number_format($rapports->sum('prix_depart'), 0, '', ' ')}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-body">
                    <table id="example9" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>DATE</th>
                            <th>MONTANT (FCFA)</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{session()->has('date') ? date('d-m-Y', strtotime(session()->get('date'))) : date('d-m-Y')}}</td>
                                <td>{{number_format($rapports->sum('prix_depart'), 0, '', ' ')." "}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="content-header">

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Rapport Journalier colis du  {{ session()->has('date') ? date('d-m-Y', strtotime(session()->get('date'))) : date('d-m-Y')}}</h1>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
               
                
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>DATE</th>
                            
                            <th>NOMBRE</th>
                            <th>MONTANT (FCFA)</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{session()->has('date') ? date('d-m-Y', strtotime(session()->get('date'))) : date('d-m-Y')}}</td>
                               
                                <td>{{number_format($rapportcolis->count(), 0, '', ' ')}}</td>
                                <td>{{number_format($rapportcolis->sum('prix'), 0, '', ' ')." "}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>



@endsection