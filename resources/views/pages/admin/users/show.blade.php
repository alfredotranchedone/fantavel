@extends('layouts.app')



@section('title','Utenti')



@section('page-header')
<h1>
    Utenti
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li><a href="{{ url('admin/user') }}"> Users</a></li>
    <li class="active">Show User</li>
</ol>
@endsection



@section('page-content')


    <div class="row">
      <div class="col-md-12">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Dettagli Utente</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <h3><i class="fa fa-user"></i> {{ ucfirst($user->name) }}</h3>

                <p><i class="fa fa-envelope-o fa-fw"></i> {{ $user->email  }}</p>

                <div class="row">
                  <div class="col-md-6 col-sm-12 col-xs-12">

                      <table class="table table-bordered table-striped">
                          <tr>
                              <th style="width:35%;">Attivo:</th>
                              <td>{!! $user->attivo ? '<span class="label label-success">SI</span>' : '<span class="label label-warning">NO</span>' !!}</td>
                          </tr>
                          <tr>
                              <th>Data Creazione:</th>
                              <td>{{ $user->created_at }}</td>
                          </tr>
                          <tr>
                              <th>Ultimo Aggiornamento:</th>
                              <td>{{ $user->updated_at }}</td>
                          </tr>
                      </table>
                      <a href="{{ url('admin/user/'.$user->id.'/edit') }}"
                         class="btn btn-warning btn-sm">
                          <i class="fa fa-pencil-square-o fa-fw"></i>
                          Modifica Utente
                      </a>
                  </div>



                  <div class="col-md-6 col-sm-12 col-xs-12">

                      <table class="table table-bordered table-striped">
                          <tr>
                              <th style="width: 25%">Squadra:</th>
                              <td>{!! $team->name or '<span class="label label-warning">no team</span>' !!}</td>
                          </tr>

                      </table>

                      @if($team)
                          <a href="{{ url('admin/team/'.$team->id.'/edit') }}"
                             class="btn btn-warning btn-sm">
                              <i class="fa fa-pencil-square-o fa-fw"></i>
                              Modifica Squadra
                          </a>
                      @else

                          <?php
                            // salva in sessione temporanea l'id dell'utente a cui associare il team
                            Session::flash('uid', $user->id);
                          ?>

                          <a href="{{ url('admin/team/create') }}"
                             class="btn btn-primary btn-sm">
                              <i class="fa fa-plus fa-fw"></i>
                              Crea Squadra
                          </a>

                      @endif

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
