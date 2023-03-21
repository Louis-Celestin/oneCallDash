@extends('layouts.master')
{{-- {{dd($bagages)}} --}}

@section('content')
<div class="card my-2">
    <div class="card-body mx-auto">
        <form action="{{ route('stat.post_general') }}" method="post">
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
                    <div class="form-group">
                        <label for="users" class="text-muted">Type bagage </label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class=" fas fa-solid fa-briefcase"></i></span>
                            </div>
                            <select name="bagage_id" id="" class="form-control">


                                <option value="">Tous les bagages</option>
                                @foreach ($bagage as $item)
                                <option value="{{$item->name_bagage}}" data-id="{{$item->id}}">{{$item->name_bagage}} </option>

                            @endforeach

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
<div class="row">
 {{-- <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-success" style="color: black !important;">
      <div class="inner">
        <p>Montant Global Bagage (FCFA)</p>

        <h3>{{number_format($stat_bagage->where('is_fret', 0)->sum('prix'), 0 , '', ' ')}}</h3>

      </div>
      <div class="icon">
        <i class="fa fa-briefcase"></i>
      </div>

    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-warning" style="color: black !important;">
      <div class="inner">
        <p>Montant Global Fret (FCFA)</p>

        <h3>{{number_format($stat_bagage->where('is_fret', 1)->sum('prix'), 0 , '', ' ')}}</h3>

      </div>
      <div class="icon">
        <i class="fas fa-suitcase"></i>
      </div>

    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-danger" style="color: black !important;">
      <div class="inner">
        <p>Montant Global Fret & Bagage (FCFA)</p>
        <h3>{{number_format($stat_bagage->where('is_fret', 0)->sum('prix') + $stat_bagage->where('is_fret', 1)->sum('prix'), 0 , '', ' ')}}</h3>

      </div>
      <div class="icon">
        <i class="fas fa-coins"></i>
      </div>

    </div>
  </div>
--}}
  <div class="col-sm-6 px-2">

        <div class="card card-zo">
            <br>
            <div class="card-body">
                <div class="row">
                  <div class="col-md-3 d-flex align-items-center justify-content-center">
                      <div class="icon-circle-70 bg-primary">
                      <i class="fa fa-truck" style="color: white;font-size: 30px"></i>
                      </div>
                  </div>
                  <div class="col-md-8">
                      <h6  style="font-weight: bold;">NOMBRE BAGAGE </h6>
                      <h5>{{$stat_bagage->where('is_fret', 0)->count(). ""}}</h5>

                  </div>

                </div>
            </div>
        </div>

</div>

<div class="col-sm-6 px-2">

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
                    <h6  style="font-weight: bold;">MONTANT BAGAGE (FCFA) </h6>
                    <h5>{{number_format($stat_bagage->where('is_fret', 0)->sum('prix'), 0, '', ' ')}}</h5>

                </div>

              </div>
          </div>
      </div>

</div>
  <!-- ./col -->
</div>

<div class="row my-2">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between my-2">
          <h3 class="card-title">RAPPORT GENERAL DES AGENTS PAR GARE EN BAGAGE</h3>
          <a class="btn btn-danger" target="_blank" href="{{ route('stat.pdf_recap_by_general') }}">Impression</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example3" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>Gare </th>
                <th>Agent <sup>Impression</sup> </th>
                <th>Type de bagage  </th>
                <th>Qte <sup>Bagages</sup></th>
                <th>Montant <sup>CFA</sup></th>
            </tr>
          </thead>
          <tbody>
        @foreach ($stat_bagage as $data)
            <tr>
                <td>{{ $data->nom_gare }}</td>
                <td>{{ $data->name }}</td>
                <td>{{ $data->type_bagage }}</td>
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

