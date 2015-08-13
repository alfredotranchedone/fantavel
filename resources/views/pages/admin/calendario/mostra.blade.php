@extends('layouts.app')



@section('title','Calendario')



@section('page-header')
<h1>
    Calendario
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Mostra Calendario</li>
</ol>
@endsection



@section('page-content')

    <div class="row">
      <div class="col-md-12">

        <div class="box">
            <div class="box-header with-border">
              <i class="fa fa-calendar fa-fw"></i>
              <h3 class="box-title">Calendario</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <div class="row">

                <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

                <?php
                    $today = Carbon\Carbon::now()->timezone('Europe/Rome');
                ?>

                @forelse($all as $match)
                     <?php
                        if( $match['giornata'] > (count($all) / 2) ) {
                            $rit = '(Rit.)';
                        }
                     ?>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                     <table class="table table-bordered table-striped" style="margin-bottom: 0">
                        <tr>
                            <th>Giornata #{{ $match['giornata'] }}  {{ $rit or '' }}</th>
                            <th>Risultato</th>
                            <th>Punteggio</th>
                            <th></th>
                        </tr>
                        @foreach($match['incontri'] as $m)
                        <tr>
                            <td>{{ $m['team1'] }} - {{ $m['team2'] }}</td>
                            <td>{{ $m['goalTeam1'] }} - {{ $m['goalTeam2'] }}</td>
                            <td>{{ $m['resultTeam1'] }} - {{ $m['resultTeam2'] }}</td>
                            <td><a href="{{ url('admin/calendario/match/'.$m['id']) }}">dettagli</a></td>
                        </tr>
                        @endforeach
                        </table>

                        <table class="table table-condensed table-bordered">

                        <tr>
                            <td>
                                @if($match['dataGiornata'])

                                    @if( $today > $match['dataGiornata'] )
                                        <span class="text-red">
                                            <i class="fa fa-warning fa-fw"></i> La giornata è trascorsa.
                                            Le modifiche non influenzeranno il risultato salvato, a meno che non venga
                                            ricaricato il file dei punteggi.
                                        </span>
                                    @else
                                        <span class="text-green">
                                            <i class="fa fa-info-circle fa-fw"></i> E' possibile modificare la data di
                                            consegna della giornata e abilitare il conteggio del fattore campo (+2 per
                                            la squadra di casa).
                                        </span>
                                    @endif

                                @else

                                    <span class="text-orange">
                                        <i class="fa fa-exclamation"></i> &nbsp;Attenzione!<br/>
                                        Non è stata ancora impostatata la data della giornata!
                                    </span>
                                @endif


                            </td>
                        </tr>

                        <tr>
                            <td>
                                <b>Data Inizio Giornata: </b>
                                @if($match['dataGiornata'])
                                    <span id="span-{{ $match['giornata'] }}">{{ date("d-m-Y H:i:s", strtotime($match['dataGiornata'])) }}</span> <small><a href="javascript:dgAddFormToggle('{{ $match['giornata'] }}');">[modifica]</a></small>
                                @else
                                    <span id="span-{{ $match['giornata'] }}"></span> <a href="javascript:dgAddFormToggle('{{ $match['giornata'] }}');"><i class="fa fa-angle-right"></i> Inserisci Data e Ora</a>
                                @endif

                                <form id="dg-add-{{ $match['giornata'] }}" onsubmit="return ajaxSubmit($(this),repopulateForm)" style="display: none">
                                    <?php
                                    $dg_d = false;
                                    $dg_t = false;
                                    if($match['dataGiornata']){
                                        $dg_all = explode(' ',$match['dataGiornata']);
                                        $dg_d = date("d-m-Y", strtotime($dg_all[0]));
                                        $dg_t = $dg_all[1];
                                    }
                                    ?>
                                    <input name="giornata" id="giornata" type="hidden" value="{{ $match['giornata'] }}">
                                    <input name="data" type="text" class="datepicker" placeholder="Inserisci data" value="{{ $dg_d or '' }}">
                                    <input name="time" type="text" class="timepicker" placeholder="Inserisci orario" value="{{ $dg_t or '' }}">
                                    <input name="action" id="action" type="hidden" value="{{ url('admin/ajax/save-data-giornata') }}">
                                    <button type="submit" class="btn btn-link">Salva</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <form id="fc-edit-{{ $match['giornata'] }}" onsubmit="return ajaxSubmit($(this))" style="padding: 0">
                                    <b>Fattore Campo: </b>

                                    &nbsp;

                                    <input type="radio"
                                           name="fattore_campo"
                                           value="1"
                                           checked
                                           {{ $match['fattore_campo'] != 0 ? 'checked':'' }}
                                            >
                                    SI

                                    &nbsp;

                                    <input type="radio"
                                           name="fattore_campo"
                                           value="0"
                                           {{ $match['fattore_campo'] == 0 ? 'checked':'' }}
                                           >
                                    NO

                                    &nbsp;

                                    <button type="submit" class="btn btn-link btn-sm">[Salva]</button>

                                    <input name="giornata" id="giornata" type="hidden" value="{{ $match['giornata'] }}">
                                    <input name="action" id="action" type="hidden" value="{{ url('admin/ajax/save-fattore-campo-giornata') }}">

                                </form>


                            </td>
                        </tr>


                    </table>
                    </div>
                @empty
                    <div class="col-md-12">
                        <p>Nessun calendario presente.</p>
                    </div>
                @endforelse
                </div>
                <!-- /.row -->


            </div><!-- /.box-body -->
            <div class="box-footer">
                <!--
                <a href="#" class="btn btn-default btn-md">
                    <i class="fa fa-print fa-fw"></i>
                    Stampa Calendario
                </a>
                -->
            </div><!-- box-footer -->
        </div>

      </div>





    </div>

@endsection
