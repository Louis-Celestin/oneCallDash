@extends('layouts.master')

@section('title')
    Fiche suiveuse {{session()->has('num_depart') ? session()->get('num_depart') : "" . session()->has('date') ? " du " .session()->get('date') : ""}} |
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Fiche suiveuse {{session()->has('num_depart') ? session()->get('num_depart') : "" . session()->has('date') ? " du " .session()->get('date') : ""}}</h1>
            </div>
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    <form action="{{route('fiche-suiveuse-search')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select name="id" id="" class="form-control">
                                        @foreach ($departsHeureVille as $item)
                                            <option value="{{$item->id}}" {{ session()->get('id') == $item->id ? 'selected' : ''}}>{{$item->nom_depart}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="date" name="date" id="date" value="{{session()->has('date') ? session()->get('date') : ''}}" max="{{date('Y-m-d')}}" required placeholder="Date de recherche" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-success"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table id="example9" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>CODE</th>
                            <th>GARE</th>
                            <th>CLIENT</th>
                            <th>NUMERO</th>
                            <th>BAGAGE</th>
                            <th>QTE BAGAGE</th>
                            <th>MONTANT</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($liste as $item)
                            <tr>
                                <td>#{{$loop->index + 1}}</td>
                                <td>{{$item->ref}}</td>
                                <td>
                                    {{$gare->nom_gare}}
                                </td>
                                <td>{{$item->name_passager}}</td>
                                <td>{{$item->phone_passager}}</td>
                                <td>{{$item->type_bagage}}</td>
                                <td>{{$item->nbr_de_bagage}}</td>
                                <td>{{number_format($item->prix, 0, '', ' ')." FCFA"}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modal')
@endsection