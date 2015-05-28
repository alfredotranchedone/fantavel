@extends('layouts.app')



@section('title','Calendario')



@section('page-header')
<h1>
    Calendario
</h1>
<ol class="breadcrumb">
    <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Calendario</li>
</ol>
@endsection



@section('page-content')

    <div class="row">
      <div class="col-md-6">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Genera Calendario</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <form action="{{ url('admin/calendario/genera') }}" method="POST">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <p>Il numero delle squadre è calcolato automaticamente</p>
                        <label for="squadre">Squadre Presenti:</label>
                        <p class="form-control-static lead"><i class="fa fa-group fa-fw"></i> {{ $totaleTeam }}</p>
                    </div>


                    <div class="input-group">
                        <label for="gironi">Numero di Gironi</label>
                        <select class="form-control" name="gironi" id="gironi">
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>


                    <hr/>

                    <button type="submit" class="btn btn-primary btn-md">
                        <i class="fa fa-eye fa-fw"></i> Genera Anteprima
                    </button>

                </form>

            </div><!-- /.box-body -->
            <div class="box-footer">
            </div><!-- box-footer -->
        </div>

      </div>



      <div class="col-md-6">



      </div>

    </div>

@endsection
