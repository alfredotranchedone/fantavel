@extends('layouts.app')



@section('title','Utenti')



@section('page-header')
<h1>
    Utenti
</h1>
<ol class="breadcrumb">
    <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Users</li>
</ol>
@endsection



@section('page-content')

    <div class="row">
      <div class="col-md-6">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Lista Utenti</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body no-padding">

              <!-- control btn -->
              <div class="margin">
                <a class="btn btn-app" href="{{ url('admin/user/create') }}"><i class="fa fa-plus-square"></i> Add User</a>
              </div>

              <div class="table-responsive ">
                <table class="table table-striped no-margin">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Utente</th>
                        <th>Team</th>
                    </tr>

                    @foreach($users as $user)
                        <tr>
                            <td></td>
                            <td>
                                <a href="{{ url('admin/user/'.$user->id) }}">{{ ucfirst($user->name) }}</a>
                            </td>
                            <td>
                                <?php if(!isset($user->teams->name)): ?>
                                    <span class="label label-warning">no team</span>

                                    <?php
                                    // salva in sessione temporanea l'id dell'utente a cui associare il team
                                    Session::flash('uid', $user->id);
                                    ?>
                                    &nbsp;
                                    <a href="{{ url('admin/team/create') }}">
                                        <small>+ Crea Squadra</small>
                                    </a>

                                <?php else: ?>

                                    {{ $user->teams->name }}

                                <?php endif; ?>

                            </td>
                        </tr>
                    @endforeach

                </table>
              </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
              Utenti totali: <b>{{ $users->count() }}</b>

            </div><!-- box-footer -->
        </div>

      </div>


      <div class="col-md-6">
      </div>
    </div>

@endsection
