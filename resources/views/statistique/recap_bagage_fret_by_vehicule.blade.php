@extends('layouts.master')
{{-- {{dd($bagages)}} --}}

@section('content')
<div class="card my-2">
    <div class="card-body mx-auto">
        <form action="{{ route('stat.post_recap_vehicule') }}" method="post">
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
                        <label for="users" class="text-muted">Bagage(s) {{--/Fret(s) --}} </label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                            </div>



                            <select name="bagage_id" id="" class="form-control"
                            onchange="getRequest('{{ url('/') }}/statistique/get_vehicule_by_bagage?parent_id='+this.value+'&compagnie=<?php echo Auth::user()->compagnie_id;?>','vehicule-select','select')">
                            
                            <option value="Bagage">Bagages</option>
                          {{--  <option value="Fret">Choississez Bagages/Fret</option> 
                            <option value="Fret">Frets</option>--}}
                            


                            </select>
                        </div>
                    </div>
                </div>
                <div class="mx-2">
                    <div class="form-group">
                        <label for="users" class="text-muted">Véhicule </label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                            </div>
                            <select name="vehicule_id" id="vehicule-select" class="form-control" >
                            <option value="">Selectionner un véhicule</option> </select>
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
          <h3 class="card-title">RAPPORT RECAPITULATIF PAR VEHICULE</h3>
          <a class="btn btn-danger" target="_blank" href="{{ route('stat.pdf_stat_vehicule') }}">Impression</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example3" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>Nom du véhicule </th>
                <th>Matricule du véhicule </th>

                <th>Quantité <sup>Bagages</sup></th>
                <th>Montant <sup>CFA</sup></th>
            </tr>
          </thead>
          <tbody>

            @foreach ($rapportGare as $data)
                <tr>
                    <td>{{ $data->NOM_DU_VEHICULE }}</td>
                    <td>{{ $data->numero_vehicule }}</td>

                    <td>{{ $data->NOMBRE_TOTAL_BAGAGE }}</td>
                    <td>{{ $data->PRIX_TOTAL_BAGAGE }}</td>
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

                  //  alert(data.select_tag);
                    if (type == 'select') {
                        $('#' + id).empty().append(data.select_tag);
                    }
                },
            });
        }

    </script>
@endsection


