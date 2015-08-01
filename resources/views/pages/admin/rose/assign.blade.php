@extends('layouts.app')



@section('title','Rose')



@section('page-header')
<h1>
    Gestione Rose
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li><a href="{{ url('admin/rose') }}">Gestione Rose</a></li>
    <li class="active">Assegna Calciatori</li>
</ol>
@endsection



@section('page-content')

    <div class="row">
      <div class="col-md-7">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Seleziona Calciatori</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

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
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($players as $player)
                        <tr
                                class="<?php echo ($player->teams_id == $team->id) ? 'active' : '' ?>"
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
            <div class="box-footer">

            </div><!-- box-footer -->
        </div>

      </div>



      <div class="col-md-5">

          <div class="box">
              <div class="box-header with-border">
                  <h3 class="box-title">Squadra <b>{{ $team->name }}</b></h3>
                  <div class="box-tools pull-right">
                      <a href="{{ url('admin/rose/formazione/'.$team->id) }}"
                         class="btn btn-success btn-sm">
                          <i class="fa fa-angle-right"></i> Vai a Formazione</a>
                  </div><!-- /.box-tools -->
              </div><!-- /.box-header -->
              <div class="box-body">

                  <form action="{{ url('admin/rose/assign/'.$team->id) }}" id="formSaveAssigned" method="post">

                      <input type="hidden" name="_token" value="{{ csrf_token() }}">

                      <input type="hidden" name="tid" value="{{ $team->id }}">

                      <p>
                        <button
                                type="submit"
                                id="btnSaveAssigned"
                                class="btn btn-primary btn-sm">
                            Salva Selezione
                        </button>
                        <hr/>
                      </p>

                      <p class="hidden">Selezionati: <span class="badge badge-green" id="teamAssignedCount">-</span></p>

                      <ul class="list-group" id="teamAssigned">
                          @foreach($players_assigned as $pa)
                              <li
                                      class="list-group-item"
                                      data-id="{{ $pa->id }}"
                                      data-codice="{{ $pa->codice }}">
                                  {{ $pa->nominativo }} ({{ $pa->ruolo }})
                                  <input type="hidden" name="cods[]" value="{{ $pa->codice }}"/>
                                  <button
                                          data-codice="{{ $pa->codice }}"
                                          type="button"
                                          class="btn btn-default btn-xs pull-right"
                                          onclick="removePlayer(this);">
                                      <i class="fa fa-trash-o fa-fw"></i>
                                  </button>
                              </li>
                          @endforeach
                      </ul>

                  </form>

              </div><!-- /.box-body -->
              <div class="box-footer">

              </div><!-- box-footer -->
          </div>

      </div>

    </div>

@endsection
