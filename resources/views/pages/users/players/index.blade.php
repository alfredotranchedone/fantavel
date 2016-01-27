@extends('layouts.app')



@section('title','Calciatori')



@section('page-header')
<h1>
    Calciatori
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('user') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Calciatori</li>
</ol>
@endsection



@section('page-content')

    <a href="{{ url('user') }}" class="btn btn-default btn-md">
        <i class="fa fa-angle-left fa-fw"></i> Home
    </a>
    &nbsp;
    <a href="{{ url('user/rosa') }}" class="btn btn-default btn-md">
        <i class="fa fa-male fa-fw"></i> Rosa
    </a>
    &nbsp;
    <a href="{{ url('user/calendario') }}" class="btn btn-default btn-md">
        <i class="fa fa-calendar fa-fw"></i> Calendario
    </a>

    <div class="row marginTop15">
      <div class="col-md-12">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Calciatori</h3>
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

                <table id="playersDataTable" class="table table-bordered table-striped no-highlight">

                    <thead>
                    <tr>
                        <th>Codice</th>
                        <th>Nome</th>
                        <th>Ruolo</th>
                        <th>Squadra</th>

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

                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div><!-- /.box-body -->

        </div>

      </div>


    </div>

@endsection
