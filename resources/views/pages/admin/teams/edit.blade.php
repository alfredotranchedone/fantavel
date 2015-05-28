@extends('layouts.app')



@section('title','Team')



@section('page-header')
<h1>
    Teams
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li><a href="{{ url('admin/team') }}"> Teams</a></li>
    <li class="active">Edit Team</li>
</ol>
@endsection



@section('page-content')


    <div class="row">
      <div class="col-md-12">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Modifica Team</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                @endforeach

                <div class="row">
                  <div class="col-md-6 col-sm-12 col-xs-12">

                      <form action="{{ url('admin/team/'.$team->id) }}" method="POST" class="margin">

                          <input type="hidden"  name="_method" value="PUT">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">

                          <div class="form-group">
                              <label for="nomeTeam">Nome Squadra</label>
                              <input value="{{ $team->name }}" type="text" class="form-control" id="nomeTeam" name="nomeTeam" placeholder="nome squadra">
                              <span class="help-block">Inserisci il nome della squadra.</span>
                          </div>

                          <hr/>

                          <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Salva Modifiche</button>

                          <a class="btn btn-default pull-right" href="{{ \URL::previous() }}"><b>Annulla</b></a>

                      </form>

                      <hr/>

                      @include('pages.admin.parts.confirm_delete', ['form_action' => 'admin/team/'.$team->id])

                  </div>
                </div>
                <!-- /.row -->



            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- box-footer -->
        </div>

      </div>



    </div>

@endsection
