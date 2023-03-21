@extends('layouts.master')
{{-- {{dd($bagages)}} --}}

@section('content')
<div class="card my-2">
    <div class="card-body mx-auto">
        <form action="{{ route('stat.colis_post_journlier') }}" method="post">
            @csrf
            <div class="row d-flex justify-content-center">
                <div class="mx-2">
                    <div class="form-group">
                        <label for="datestart" class="text-muted">Début </label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" id="datestart" disabled class="form-control" name="start"  data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" value="{{session()->has('start') ? session()->get('start') : date('Y-m-d')}}">
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
                            <input type="date" disabled id="dateend" class="form-control" name="end"  data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" value="{{session()->has('end') ? session()->get('end') : date('Y-m-d')}}">
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
                        <label for="gares" class="text-muted">Statut de colis</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-bus"></i></span>
                            </div>
                            <select name="statut" id="" class="form-control"
                            onchange="getRequest('{{ url('/') }}/statistique/get_user_by_gare?parent_id='+this.value,'sub-category-select','select')">
                                @if (Auth::user()->usertype == "admin" || Auth::user()->usertype == "comptable")
                                  <option value="">Toutes les status</option>
                                  {{-- <option value="Sent">En provenance</option> --}}
                                @endif
                              {{--    @foreach ($gares as $item)
                                    <option value="{{$item->id}}" {{session()->get('gare_id') == $item->id ? "selected" : ''}}>{{$item->nom_gare}}</option>
                                @endforeach   --}}

                                @foreach ($statut_colis as $c)
                                <option value="{{ $c->statut }}"
                                    {{ old('statut') == $c->statut ? 'selected' : '' }}>
                                    {{ $c->statut=="Delivered" ? 'Livrés': '' }}
                                    {{ $c->statut=="Received" ? 'Reçus': '' }}
                                    {{ $c->statut=="Waiting" ? 'Expédiés': '' }}
                                </option>
                            @endforeach

                            </select>
                        </div>
                    </div>
                </div>

               {{--  <div class="mx-2">
                    <div class="form-group">
                        <label for="users" class="text-muted">Moyenne (bagages) </label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-solid fa-plus"></i></span>
                            </div>
                            <select name="min_max" id="" class="form-control">


                                <option value="">Sélectionner Min/Max</option>
                                <option value="Min">Min</option>
                                <option value="Max">Max</option>
                            </select>
                        </div>
                    </div>
                </div>  --}}
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
            <h3 class="card-title">RAPPORT GENERAL DES AGENTS PAR GARE EN COLIS</h3>
            <a class="btn btn-danger" target="_blank" href="{{ route('stat.pdf_recap_colis_post_general') }}">Impression</a>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example3" class="table table-bordered table-striped">
            <thead>
              <tr>
                  <th># </th>
                  {{-- <th>DATE</th> --}}
                  <th>GARE </th>
                  <th>AGENT </th>
                  <th>NOMBRE</th>
                  <th>MONTANT <sup>CFA</sup></th>
                  {{-- <th>DETAILS </th> --}}
              </tr>
            </thead>
            <tbody>
          @foreach ($stat_colis as $data)
              <tr>
                  <td>{{ $data->id }}</td>
                  {{-- <td>{{ $data->created_at }}</td> --}}
                  <td>{{ $data->nom_gare }}</td>
                  <td>{{ $data->name }}</td>
                  <td>{{ $data->qte_colis }}</td>
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
@endsection


