<div class="row">
    <div class="col-md-12">

        <?php
            $user_level = Auth::user()->levels_level;
            if($user_level == 0){
                $base_url = 'admin';
            } else {
                $base_url = 'user';
            }
        ?>
        <a href="{{ url($base_url) }}" class="btn btn-default btn-md"><i class="fa fa-home fa-fw"></i> Home</a>
        &nbsp;
        <a href="{{ url($base_url.'/calendario') }}" class="btn btn-default btn-md"><i class="fa fa-calendar fa-fw"></i> Calendario</a>



        <div class="box marginTop">
            <div class="box-header with-border">
                @if($team_1_result AND $team_2_result)
                    <i class="fa fa-flag-checkered fa-fw"></i>
                @else
                    <i class="fa fa-flag-o fa-fw"></i>
                @endif
                <h3 class="box-title">Giornata {{ $match->giornata }}  </h3>
                <div class="box-tools pull-right">
                    <!-- Buttons, labels, and many other things can be placed here! -->
                    <!-- Here is a label for example -->
                    <i class="fa fa-calendar fa-fw"></i> {{ $match->dataGiornata }}
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <div class="row">
                  <div class="col-md-6">
                      <table class="table table-bordered">
                          <tr class="bg-green-gradient lead">
                              <th width="20"><i class="fa fa-users fa-fw"></i> </th>
                              <th colspan="2">{{ $match->team_1_nome }}</th>
                          </tr>
                          <tr>
                              <td><i class="fa fa-futbol-o fa-fw"></i></td>
                              <th width="40%">Gol</th>
                              <td class="lead">{{ $team_1_result->goal or '-' }}</td>
                          </tr>
                          <tr>
                              <td><i class="fa fa-diamond fa-fw"></i></td>
                              <th>Punteggio</th>
                              <td class="lead">
                                {{ $team_1_result->result or '-' }}

                                @if($team_1_result)
                                    @if($team_1_result->result)
                                        @if($team_1_result->created_at != $team_1_result->updated_at)
                                              <a href="#alertResultContainer"
                                                 class="text-red"
                                                 data-toggle="tooltip"
                                                 data-original-title="Il Punteggio Totale è stato modificato dall'Amministratore!">
                                                  <i class="fa fa-warning fa-fw"></i>
                                              </a>

                                        @endif
                                    @endif
                                @endif
                              </td>
                          </tr>
                          <tr>
                              <td><i class="fa fa-cubes fa-fw"></i></td>
                              <th>Modulo Iniziale</th>
                              <td class="lead">{{ $team_1_result->name or '-' }} ({{ $team_1_result->modificatore or '-'}})</td>
                          </tr>
                          <tr>
                              <td><i class="fa fa-home fa-fw"></i></td>
                              <th>Fattore Campo</th>
                              <td>
                                  @if($match->fattore_campo == 1)
                                      <i class="fa fa-check-square-o fa-fw"></i> (+2)
                                  @else
                                      <i class="fa fa-square-o fa-fw"></i> (0)
                                  @endif
                              </td>
                          </tr>
                      </table>



                      <table class="table table-bordered table-striped table-hover">

                          <tr>
                              <th style="width:30px;">#</th>
                              <th>R.</th>
                              <th>Giocatore</th>
                              <th>TOT</th>
                              <th>Voto</th>
                              <th nowrap>Gol (n)</th>
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
                                  <td>{{ $p->magic_punti or '-'}}</td>
                                  <td>{{ $p->voto  or '-' }}</td>
                                  <td nowrap class="@if($p->gol > 0) text-green @elseif($p->gol<0) text-red @endif">
                                      @if( $p->gol AND ($p->gol % 3) == 0)
                                          {{ ($p->gol) }}
                                          @if($p->gol <> 0)
                                              (<b>{{ $p->gol/3 }}</b>)
                                          @endif
                                      @else
                                          -
                                      @endif
                                  </td>
                                  <td class="@if($p->ammonizione != 0) text-orange @endif">
                                      {{ $p->ammonizione or '-' }}
                                  </td>
                                  <td class="@if($p->espulsione != 0) text-red @endif">
                                      {{ $p->espulsione or '-' }}</td>
                                  <td nowrap class="@if($p->rigori > 0) text-green @elseif($p->rigori<0) text-red @endif">
                                      {{ $p->rigori or '-' }}
                                  </td>
                                  <td nowrap class="@if($p->autogol > 0) text-green @elseif($p->autogol<0) text-red @endif">
                                      {{ $p->autogol or '-' }}
                                  </td>
                                  <td class="@if($p->assist != 0) text-green @endif">
                                      {{ $p->assist or '-' }}
                                  </td>
                              </tr>

                              <?php $i++; ?>
                              @if($i==12)
                                  <tr>
                                      <th colspan="11" class="bg-teal">Riserve</th>
                                  </tr>
                              @endif
                          @empty
                              <tr>
                                  <td class="text-center" colspan="11" style="background: white;">
                                      <p class="lead text-red">
                                          La formazione per questa giornata non è stata ancora inserita.</p>

                                      @if(Auth::user()->levels_level != 0)
                                          @if(Auth::user()->id == $match->team_1_user_id)
                                              <a href="{{ url($base_url.'/rose/formazione/'.$match->team_1_id) }}" class="btn btn-success btn-md">
                                                  <i class="fa fa-plus fa-fw"></i> Aggiungi Formazione
                                              </a>
                                          @endif
                                      @else
                                          <a href="{{ url($base_url.'/rose/formazione/'.$match->team_1_id) }}" class="btn btn-success btn-md">
                                              <i class="fa fa-plus fa-fw"></i> Aggiungi Formazione
                                          </a>
                                      @endif

                                  </td>
                              </tr>
                          @endforelse

                      </table>

                      <a id="alertResultContainer"></a>

                      @if($team_1_result)
                          @if($team_1_result->created_at != $team_1_result->updated_at)
                              <p class="text-red">
                                  <small><i class="fa fa-asterisk fa-fw"></i></small>
                                  <i>Questo punteggio è stato modificato dall'Admin in data {{ $team_1_result->updated_at->tz('Europe/Rome')->format('d/m/Y H:i:s') }}</i>
                              </p>
                          @endif
                      @endif

                      @if( ($user_level == 0) AND ($team_1_result AND $team_2_result))

                          <button type="button" class="btn btn-link"  onclick="jQuery('#modResultContainer').slideToggle();"><i class="fa fa-angle-right fa-fw"></i>Modifica Punteggio</button>

                          <div id="modResultContainer" class="well well-sm" style="display:none;">
                              @include('pages.admin.parts.confirm_generic',[
                              'prepend' => '
                                <input type="hidden" name="giornata" class="form-control" value="'.$match->giornata.'" />
                                <input type="hidden" name="team_id" class="form-control" value="'.$match->team_1_id.'" />
                                <input type="hidden" name="match" class="form-control" value="'.$match->id.'" />
                                <label>Inserisci Nuovo Risultato</label>
                                <input type="text" name="new_result" class="form-control" autocomplete="off" placeholder="Inserisci il Risultato" value="'.$team_1_result->result.'"/>
                                <hr>
                              ',
                              'form_action' => 'admin/calendario/save-new-result',
                              'buttonText' => 'Salva Modifica Punteggio'
                              ])
                          </div>

                      @endif



                  </div>

                  <div class="col-md-6">


                      <table class="table table-bordered">
                          <tr class="bg-green-gradient lead">
                              <th width="20"><i class="fa fa-users fa-fw"></i> </th>
                              <th colspan="2">{{ $match->team_2_nome }}</th>
                          </tr>
                          <tr>
                              <td><i class="fa fa-futbol-o fa-fw"></i></td>
                              <th width="40%">Gol</th>
                              <td class="lead">{{ $team_2_result->goal or '-' }}</td>
                          </tr>
                          <tr>
                              <td><i class="fa fa-diamond fa-fw"></i></td>
                              <th>Punteggio</th>
                              <td class="lead">
                                  {{ $team_2_result->result or '-' }}
                                  @if($team_2_result)
                                      @if($team_2_result->result)
                                          @if($team_2_result->created_at != $team_2_result->updated_at)
                                              <a href="#alertResultContainer"
                                                 class="text-red"
                                                 data-toggle="tooltip"
                                                 data-original-title="Il Punteggio Totale è stato modificato dall'Amministratore!">
                                                  <i class="fa fa-warning fa-fw"></i>
                                              </a>

                                          @endif
                                      @endif
                                  @endif
                              </td>
                          </tr>
                          <tr>
                              <td><i class="fa fa-cubes fa-fw"></i></td>
                              <th>Modulo Iniziale</th>
                              <td class="lead">{{ $team_2_result->name or '-' }} ({{ $team_2_result->modificatore or '-'}})</td>
                          </tr>
                          <tr>
                              <td><i class="fa fa-home fa-fw"></i></td>
                              <th>Fattore Campo</th>
                              <td><i class="fa fa-square-o fa-fw"></i> (0)</td>
                          </tr>
                      </table>



                      <table class="table table-bordered table-striped table-hover">

                          <tr>
                              <th style="width:30px;">#</th>
                              <th>R.</th>
                              <th>Giocatore</th>
                              <th>TOT</th>
                              <th>Voto</th>
                              <th nowrap>Gol (n)</th>
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
                                  <td nowrap class="@if($p->gol > 0) text-green @elseif($p->gol<0) text-red @endif">
                                      @if( $p->gol AND ($p->gol % 3) == 0)
                                          {{ ($p->gol) }}
                                          @if($p->gol <> 0)
                                              (<b>{{ $p->gol/3 }}</b>)
                                          @endif
                                      @else
                                          -
                                      @endif
                                  </td>
                                  <td class="@if($p->ammonizione != 0) text-orange @endif">
                                      {{ $p->ammonizione or '-' }}
                                  </td>
                                  <td class="@if($p->espulsione != 0) text-red @endif">
                                      {{ $p->espulsione or '-' }}</td>
                                  <td nowrap class="@if($p->rigori > 0) text-green @elseif($p->rigori<0) text-red @endif">
                                      {{ $p->rigori or '-' }}
                                  </td>
                                  <td nowrap class="@if($p->autogol > 0) text-green @elseif($p->autogol<0) text-red @endif">
                                      {{ $p->autogol or '-' }}
                                  </td>
                                  <td class="@if($p->assist != 0) text-green @endif">
                                      {{ $p->assist or '-' }}
                                  </td>
                              </tr>

                              <?php $i++; ?>

                              @if($i==12)
                                  <tr>
                                      <th colspan="11" class="bg-teal">Riserve</th>
                                  </tr>
                              @endif

                          @empty
                              <tr>
                                  <td class="text-center" colspan="11" style="background: white;">
                                      <p class="lead text-red">
                                          La formazione per questa giornata non è stata ancora inserita.</p>

                                      @if(Auth::user()->levels_level != 0)
                                          @if(Auth::user()->id == $match->team_2_user_id)
                                              <a href="{{ url($base_url.'/rose/formazione/'.$match->team_2_id) }}" class="btn btn-success btn-md">
                                                  <i class="fa fa-plus fa-fw"></i> Aggiungi Formazione
                                              </a>
                                          @endif
                                      @else
                                          <a href="{{ url($base_url.'/rose/formazione/'.$match->team_2_id) }}" class="btn btn-success btn-md">
                                              <i class="fa fa-plus fa-fw"></i> Aggiungi Formazione
                                          </a>
                                      @endif

                                  </td>
                              </tr>
                          @endforelse

                      </table>

                      <a id="alertResultContainer2"></a>
                      @if($team_2_result)
                          @if($team_2_result->created_at != $team_2_result->updated_at)
                              <p class="text-red">
                                  <small><i class="fa fa-asterisk fa-fw"></i></small>
                                  <i>Questo punteggio è stato modificato dall'Admin in data {{ $team_2_result->updated_at->tz('Europe/Rome')->format('d/m/Y H:i:s')}}</i>
                              </p>
                          @endif
                      @endif

                      @if( ($user_level == 0) AND ($team_1_result AND $team_2_result))

                          <button type="button" class="btn btn-link"  onclick="jQuery('#modResultContainer2').slideToggle();"><i class="fa fa-angle-right fa-fw"></i>Modifica Punteggio</button>

                          <div id="modResultContainer2" class="well well-sm" style="display:none;">
                              @include('pages.admin.parts.confirm_generic',[
                              'prepend' => '
                                <input type="hidden" name="giornata" class="form-control" value="'.$match->giornata.'" />
                                <input type="hidden" name="team_id" class="form-control" value="'.$match->team_2_id.'" />
                                <input type="hidden" name="match" class="form-control" value="'.$match->id.'" />
                                <label>Inserisci Nuovo Risultato</label>
                                <input type="text" name="new_result" class="form-control" autocomplete="off" placeholder="Inserisci il Risultato" value="'.$team_2_result->result.'"/>
                                <hr>
                              ',
                              'form_action' => 'admin/calendario/save-new-result',
                              'buttonText' => 'Salva Modifica Punteggio'
                              ])
                          </div>

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