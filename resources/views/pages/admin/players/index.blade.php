@extends('layouts.app')



@section('title','Calciatori')



@section('page-header')
<h1>
    Calciatori
</h1>
<ol class="breadcrumb">
    <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Calciatori</li>
</ol>
@endsection



@section('page-content')

    <div class="actionBar">
        <a href="{{ url('admin/import') }}" class="btn btn-app">
            <i class="fa fa-plus-circle"></i>
            Aggiungi</a>
    </div>

    <div class="row">
      <div class="col-md-12">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Gestisci Calciatori</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

              <p>Sono presenti <b>{{ $players->count() }}</b> calciatori. </p>

                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <label>Filtra per Ruolo:</label>
                            <select class="form-control" id="filterDataTableRuolo">
                                <option value="">Mostra Tutto</option>
                                <option value="P">Portiere</option>
                                <option value="D">Difensore</option>
                                <option value="C">Centrocampista</option>
                                <option value="T">Trequartista</option>
                                <option value="A">Attaccante</option>
                            </select>
                        </div>
                        <hr/>
                    </div>
                </div>

                <table id="playersDataTable" class="table table-bordered table-striped">

                    <thead>
                    <tr>
                        <th>Codice</th>
                        <th>Nome</th>
                        <th>Ruolo</th>
                        <th>Squadra</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($players as $player)
                        <tr
                                data-player-codice="{{ $player->codice }}"
                                data-player-nominativo="{{ $player->nominativo }}"
                                data-player-ruolo="{{ $player->ruolo }}"
                                data-player-id="{{ $player->id }}"
                                >
                            <td>{{ $player->codice }}</td>
                            <td>{{ $player->nominativo }}</td>
                            <td>{{ $player->ruolo }}</td>
                            <td>
                                <?php
                                if(isset($player->teams->name)):
                                    echo $player->teams->name;
                                else: ?>
                                <span class="text-green">disponibile</span>
                                <?
                                endif;
                                ?>
                            </td>
                            <td data-search="false" data-order="false">
                                <a href="{{ route('admin.players.edit',[$player->codice]) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit fa-fw"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div><!-- /.box-body -->

        </div>

      </div>


    </div>

@endsection
