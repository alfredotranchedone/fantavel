<div class="row">
    <div class="col-md-12">

        <div class="box">
            <div class="box-header with-border">
                <i class="fa fa-flag-o fa-fw"></i>
                <h3 class="box-title">Giornata {{ $match->giornata }}</h3>
                <div class="box-tools pull-right">
                    <!-- Buttons, labels, and many other things can be placed here! -->
                    <!-- Here is a label for example -->

                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <h4>Incontro del {{ $match->dataGiornata }}</h4>

                <div class="row">
                  <div class="col-md-6">

                      <h4 class="text-center">{{ $match->team_1_nome }}</h4>

                      <table class="table table-bordered table-striped">

                          <tr>
                              <th style="width:30px;">#</th>
                              <th>Ruolo</th>
                              <th>Giocatore</th>
                              <th>Totale</th>
                              <th>Voto</th>
                              <th>Gol</th>
                              <th>Amm</th>
                              <th>Esp</th>
                              <th>Rig</th>
                              <th>Auto</th>
                              <th>Ass</th>
                          </tr>

                          <?php $i = 1; ?>
                          @forelse($team_1_players as $p)
                              <tr>
                                  <td>{{ $i }}.</td>
                                  <td>{{ $p->ruolo }}</td>
                                  <td>{{ $p->nominativo }}</td>
                                  <td>{{ $p->magic_punti or '-' }}</td>
                                  <td>{{ $p->voto or '-' }}</td>
                                  <td>{{ $p->gol or '-' }}</td>
                                  <td>{{ $p->ammonizione or '-' }}</td>
                                  <td>{{ $p->espulsione or '-' }}</td>
                                  <td>{{ $p->rigori or '-' }}</td>
                                  <td>{{ $p->autogol or '-' }}</td>
                                  <td>{{ $p->assist or '-' }}</td>
                              </tr>
                              <?php $i++;
                              if($i==11)
                                  exit;
                              ?>
                          @empty
                              <tr>
                                  <td colspan="4">Nessun dettaglio.</td>
                              </tr>
                          @endforelse

                      </table>
                  </div>

                  <div class="col-md-6">

                      <h4 class="text-center">{{ $match->team_2_nome }}</h4>

                      <table class="table table-bordered table-striped">

                          <tr>
                              <th style="width:30px;">#</th>
                              <th>Ruolo</th>
                              <th>Giocatore</th>
                              <th>Totale</th>
                              <th>Voto</th>
                              <th>Gol</th>
                              <th>Amm</th>
                              <th>Esp</th>
                              <th>Rig</th>
                              <th>Auto</th>
                              <th>Ass</th>
                          </tr>

                          <?php $i = 1; ?>
                          @forelse($team_2_players as $p)
                              <tr>
                                  <td>{{ $i }}.</td>
                                  <td>{{ $p->ruolo }}</td>
                                  <td>{{ $p->nominativo }}</td>
                                  <td>{{ $p->magic_punti or '-'}}</td>
                                  <td>{{ $p->voto  or '-' }}</td>
                                  <td>{{ $p->gol or '-' }}</td>
                                  <td>{{ $p->ammonizione or '-' }}</td>
                                  <td>{{ $p->espulsione or '-' }}</td>
                                  <td>{{ $p->rigori or '-' }}</td>
                                  <td>{{ $p->autogol or '-' }}</td>
                                  <td>{{ $p->assist or '-' }}</td>
                              </tr>
                              <?php $i++;
                              if($i==12)
                                  break;
                              ?>
                          @empty
                              <tr>
                                  <td colspan="4">Nessun dettaglio.</td>
                              </tr>
                          @endforelse

                      </table>
                  </div>
                </div>
                <!-- /.row -->


            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- box-footer -->
        </div>

    </div>



    <div class="col-md-6">



    </div>

</div>