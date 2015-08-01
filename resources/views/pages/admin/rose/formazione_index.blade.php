@extends('layouts.app')



@section('title','Squadre')



@section('page-header')
<h1>
    Squadre
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li><a href="{{ url('admin/rose') }}">Squadre</a></li>
    <li class="active">Formazione</li>
</ol>
@endsection



@section('page-content')

    <div class="row">

        <div class="col-md-12">

            <div class="box">
                <div class="box-header with-border">
                  <i class="fa fa-th-large"></i>
                  <h3 class="box-title">Gestisci Formazione</h3>
                  <div class="box-tools pull-right">
                    <!-- Buttons, labels, and many other things can be placed here! -->
                    <!-- Here is a label for example -->
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">

                    <div class="row">
                      <div class="col-md-6">
                          <div class="pull-right">
                              <a href="{{ url('admin/rose') }}" class="btn btn-default btn-sm"><i class="fa fa-chevron-left fa-fw"></i> Torna a Squadre</a>
                          </div>

                          <h4><i class="fa fa-group fa-fw"></i> {{ $team->name }}</h4>

                          <hr/>

                          <form id="frmModulo" action="{{ url('admin/rose/save-modulo/'.$teamId) }}" method="post">
                              <input type="hidden" value="{{ $teamId }}" name="team_id" />
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">

                              <label for="modulo">Modulo (Mod. Punteggio)</label>
                              <div class="row">
                                  <div class="col-md-8">
                                      <div class="input-group">
                                          <select class="form-control" name="modulo" id="modulo">
                                              @forelse($moduli as $m)

                                                  <option {{  (isset($team->modulo->name) AND ($team->modulo->name == $m->name))?'selected':'' }} value="{{ $m->id }}">
                                                      {{ $m->name }} &nbsp; ( {{ $m->modificatore }} )
                                                  </option>
                                              @empty
                                                  <option value="0">Nessun Modulo</option>
                                              @endforelse
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <button type="submit" class="btn btn-primary pull-right">
                                          <i class="fa fa-save fa-fw"></i> Salva Modulo
                                      </button>
                                  </div>
                              </div>
                              <!-- /.row -->

                          </form>
                      </div>

                    </div><!-- /.row -->



                    <hr/>

                    <?php
                    if(isset($team->modulo->name)):
                    ?>

                    <form action="{{ url('admin/rose/formazione/'.$teamId) }}" method="post">

                        <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Salva Formazione</button>

                        <hr/>

                        <div class="row">
                            <div class="col-md-6">

                                <input type="hidden" value="{{ $teamId }}" name="team_id" />
                                <input type="hidden" value="{{ $prossima_giornata }}" name="prossima_giornata" />
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <table class="table table-striped formazione">

                                  <tr>
                                      <th class="autowidth">Maglia </th>
                                      <th class="autowidth">Ruolo</th>
                                      <th>Calciatore</th>
                                      <th style="width: 10px"></th>
                                  </tr>

                                  <?php
                                  $arrayModulo = explode('-',$team->modulo->name);

                                  $c_arrayModulo = count($arrayModulo);

                                  //controlla se il modulo prevede il trequartista
                                  if($c_arrayModulo == 4){

                                      $difesa = $arrayModulo[0];
                                      $centrocampo = $arrayModulo[1];
                                      $trequarti = $arrayModulo[2];
                                      $attacco = $arrayModulo[3];

                                  } elseif($c_arrayModulo == 3){

                                      $difesa = $arrayModulo[0];
                                      $centrocampo = $arrayModulo[1];
                                      $attacco = $arrayModulo[2];

                                  }


                                  for($i=1;$i<12;$i++):



                                     if($c_arrayModulo == 4){

                                        switch (true){
                                          case ($i == 1):
                                              $position = 'P';
                                              break;
                                          case ($i > 1 AND $i <= $difesa+1):
                                              $position = 'D';
                                              break;
                                          case ($i > $difesa+1 AND $i <= $centrocampo+$difesa+1):
                                              $position = 'C';
                                              break;
                                          case ($i > $centrocampo AND $i <= $centrocampo+$difesa+$trequarti+1):
                                              $position = 'T';
                                              break;
                                          case ($i > $trequarti AND $i <= $centrocampo+$difesa+$trequarti+$attacco+1):
                                              $position = 'A';
                                              break;
                                          default:
                                              $position = '';
                                        }



                                     } elseif($c_arrayModulo == 3) {

                                         switch (true){
                                             case ($i == 1):
                                                 $position = 'P';
                                                 break;
                                             case ($i > 1 AND $i <= $difesa+1):
                                                 $position = 'D';
                                                 break;
                                             case ($i > $difesa+1 AND $i <= $centrocampo+$difesa+1):
                                                 $position = 'C';
                                                 break;
                                             case ($i > $centrocampo AND $i <= $centrocampo+$difesa+$attacco+1):
                                                 $position = 'A';
                                                 break;
                                             default:
                                                 $position = '';
                                         }

                                     }

                                  ?>

                                  <tr>
                                      <td>
                                          <div class="tshirtContainer">
                                              <?php $tshirt = ($i==1)?'/img/t-shirt-P.png':'/img/t-shirt.png'; ?>
                                              <img src="{{ asset($tshirt) }}" alt=""/>
                                              <div class="textShadow">{{ $i }}</div>
                                          </div>
                                      </td>
                                      <td class="{{ $position }} text-center">{{ $position }}</td>
                                      <td>
                                          <input type="hidden" name="numero_maglia[{{ $i }}]" value="{{ $p->formazione->numero_maglia or 0 }}" />
                                          <select data-position="{{ $position }}" name="sel_numero_maglia[{{ $i }}]" class="form-control">
                                              <option value="0">Seleziona...</option>
                                              @foreach($players as $p)
                                                  <?php
                                                  if(isset($p->formazione->numero_maglia) AND $p->formazione->numero_maglia == $i):
                                                      $sel = 'selected="selected"';
                                                  else:
                                                      $sel = '';
                                                  endif;
                                                  ?>

                                                  @if( strtoupper($p->ruolo) == $position )
                                                      <option {{ $sel }} value="{{ $p->codice }}">{{ $p->nominativo }}</option>
                                                  @endif
                                              @endforeach
                                          </select>
                                      </td>
                                      <td>
                                          <button
                                                  data-toggle="tooltip"
                                                  data-original-title="Rimuovi Calciatore"
                                                  data-id="btnPosRemove{{ $i }}"
                                                  data-maglia="{{ $i }}"
                                                  value=""
                                                  type="button"
                                                  class="btn btn-link btn-xs pull-right">
                                              <i class="fa fa-ban fa-fw"></i>
                                          </button>
                                      </td>
                                  </tr>

                                  <?php endfor; ?>

                                </table>

                            </div><!-- /.col -->



                            <div class="col-md-6">

                                <table class="table table-striped formazione">

                                    <tr>
                                        <th class="autowidth">Maglia </th>
                                        <th class="autowidth">Ruolo</th>
                                        <th>Calciatore</th>
                                        <th style="width: 10px"></th>
                                    </tr>

                                    <?php

                                    for($i=12;$i<=23;$i++):

                                        if ($i == 12):
                                            $position = 'P';
                                        else:
                                            $position = 'R';
                                        endif;

                                    ?>

                                    <tr>
                                        <td>
                                            <div class="tshirtContainer">
                                                <?php $tshirt = ($i==12)?'/img/t-shirt-P.png':'/img/t-shirt.png'; ?>
                                                <img src="{{ asset($tshirt) }}" alt="" />
                                                <div class="textShadow">{{ $i }}</div>
                                            </div>
                                        </td>
                                        <td class="{{ $position }} {{ $i==12 ? 'P':'' }} text-center">{{ $position }}</td>
                                        <td>
                                            <input type="hidden" name="numero_maglia[{{ $i }}]" value="{{ $p->formazione->numero_maglia or 0 }}" />
                                            <select data-position="{{ $position }}" name="sel_numero_maglia[{{ $i }}]" class="form-control">
                                                <option value="0">Seleziona...</option>
                                                @foreach($players as $p)
                                                    <?php
                                                    if(isset($p->formazione->numero_maglia) AND $p->formazione->numero_maglia == $i):
                                                        $sel = 'selected="selected"';
                                                    else:
                                                        $sel = '';
                                                    endif;
                                                    ?>

                                                    @if( strtoupper($p->ruolo) == $position )
                                                        <option {{ $sel }} value="{{ $p->codice }}">{{ $p->nominativo }}</option>
                                                    @endif

                                                    @if( $position == 'R' AND strtoupper($p->ruolo) != 'P')
                                                        <option {{ $sel }} value="{{ $p->codice }}">{{ $p->nominativo }}</option>
                                                    @endif

                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <button
                                                    data-toggle="tooltip"
                                                    data-original-title="Rimuovi Calciatore"
                                                    data-id="btnPosRemove{{ $i }}"
                                                    data-maglia="{{ $i }}"
                                                    value=""
                                                    type="button"
                                                    class="btn btn-link btn-xs pull-right">
                                                <i class="fa fa-ban fa-fw"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <?php endfor; ?>

                                </table>

                            </div><!-- /.col -->



                        </div><!-- /.row -->

                    </form>

                <?php else: ?>

                    <div class="row">
                      <div class="col-md-12">
                          <p class="lead">Seleziona un modulo.</p>
                      </div>
                    </div>
                    <!-- /.row -->

                <?php endif; ?>




                </div><!-- /.box-body -->
                <div class="box-footer">

                </div><!-- box-footer -->
            </div>

        </div>

    </div>

@endsection
