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
                <i class="fa fa-flag-o fa-fw"></i>
                <h3 class="box-title">Prossima Giornata</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <h4>Giornata {{ $nextGiornata->giornata or '-'}}</h4>

                <table class="tableResult table table-bordered table-striped">

                    <tr>
                        <th style="width:30px;">#</th>
                        <th>Incontro</th>
                        <th>Risultato</th>
                        <th style="width: 30px"></th>
                    </tr>

                    <?php $i = 1; ?>
                    @forelse($nextMatches as $match)
                        <tr>
                            <td>{{ $i }}.</td>
                            <td>{{ $match->team1 }} - {{ $match->team2 }}</td>
                            <td>{{ $match->result_team_1_id }} - {{ $match->result_team_1_id }}</td>
                            <td><a href="#">dettagli</a></td>
                        </tr>
                        <?php $i++; ?>
                    @empty
                        <tr>
                            <td colspan="4">Nessun match programmato.</td>
                        </tr>
                    @endforelse

                </table>


            </div><!-- /.box-body -->
            <div class="box-footer">

                @if(isset($nextGiornata))
                    <button
                            class="btn btn-primary btn-md"
                            onclick="jQuery('#confirmContainer').slideToggle();">
                        <i class="fa fa-upload fa-fw"> </i> Carica Risultati
                    </button>

                    <div id="confirmContainer"  style="display: none; margin-top: 15px">
                        <form action="{{ url('admin/calendario/upload-risultati') }}" method="post" enctype="multipart/form-data">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="giornata" value="{{ $nextGiornata->giornata }}"/>

                            <div class="input-group">
                                <label for="">Seleziona File .xls</label>
                                <input type="file" name="xls" class="form-control">
                            </div>

                            <p style="margin-top: 15px;">Per proseguire con il caricamento, scrivi "UPLOAD" nel campo sottostante.</p>
                            <div class="input-group">
                                <input type="text" name="confirmText" class="form-control" autocomplete="off" />
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default btn-md">Prosegui <i class="fa fa-chevron-right fa-fw"></i></button>
                                </span>
                            </div>


                        </form>
                    </div>


                @else
                    <button
                        disabled
                            class="btn btn-primary btn-md">
                        <i class="fa fa-upload fa-fw"> </i> Carica Risultati
                    </button>
                @endif
            </div><!-- box-footer -->
        </div>

      </div>



      <div class="col-md-6">

          <div class="box">
              <div class="box-header with-border">
                  <i class="fa fa-flag-checkered fa-fw"></i>
                  <h3 class="box-title">Risultati Ultima Giornata</h3>
                  <div class="box-tools pull-right">
                      <!-- Buttons, labels, and many other things can be placed here! -->
                      <!-- Here is a label for example -->

                  </div><!-- /.box-tools -->
              </div><!-- /.box-header -->
              <div class="box-body">

                  <h4>Giornata {{ $lastGiornata->giornata or '-'}}</h4>

                  <table class="tableResult table table-bordered table-striped">

                      <tr>
                          <th style="width:30px;">#</th>
                          <th>Incontro</th>
                          <th>Risultato</th>
                          <th>Punteggio</th>
                          <th style="width: 30px"></th>
                      </tr>

                      <?php $i = 1; ?>
                      @forelse($lastMatches as $match)
                          <tr>
                              <td>{{ $i }}.</td>
                              <td>{{ $match->team1 }} - {{ $match->team2 }}</td>
                              <td>{{ $match->goalTeam1 }} - {{ $match->goalTeam2 }}</td>
                              <td>{{ $match->resultTeam1 }} - {{ $match->resultTeam2 }}</td>
                              <td><a href="#">dettagli</a></td>
                          </tr>
                          <?php $i++; ?>
                      @empty
                          <tr>
                              <td colspan="4">Nessun match giocato.</td>
                          </tr>
                      @endforelse

                  </table>

              </div><!-- /.box-body -->
              <div class="box-footer">
              </div><!-- box-footer -->
          </div>

      </div>

    </div>

@endsection
