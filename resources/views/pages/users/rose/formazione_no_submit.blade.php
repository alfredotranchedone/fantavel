@extends('layouts.app')



@section('title','Squadre')



@section('page-header')
<h1>
    Squadre
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('user') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Formazione</li>
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

    <h2><i class="fa fa-group fa-fw"></i> {{ $team->name }}</h2>

    <hr style="border-color: #fff"/>

    <div class="alert alert-danger">
        <i class="fa fa-warning fa-fw"></i> <b>Attenzione! Giornata in corso!</b><br/>
        Non è più possibile modificare la formazione! La scadenza era {{ $scadenza }} fa.
    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="box">
                <div class="box-header with-border">
                    <i class="fa fa-th-large"></i>
                    <h3 class="box-title">Gestisci Formazione ({{ $team->modulo->name or '-' }})</h3>
                    <div class="box-tools pull-right">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
                    </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">


                    <?php
                    if(isset($team->modulo->name)):
                    ?>


                        <div class="row marginTop">
                            <div class="col-md-6">

                                <input type="hidden" value="{{ $teamId }}" name="team_id" />
                                <input type="hidden" value="{{ $prossima_giornata }}" name="prossima_giornata" />
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <table class="table table-striped table-bordered table-condensed formazione">
                                    
                                    <tr>
                                        <th class="autowidth">Maglia </th>
                                        <th class="autowidth">Ruolo</th>
                                        <th>Calciatore</th>
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

                                            <select
                                                    disabled
                                                    data-position="{{ $position }}"
                                                    name="sel_numero_maglia[{{ $i }}]"
                                                    class="form-control">
                                                <option value="0">-</option>
                                                @foreach($players as $p)
                                                    <?php
                                                    if(isset($p->formazione->numero_maglia) AND $p->formazione->numero_maglia == $i):
                                                        $sel = 'selected="selected"';
                                                    else:
                                                        $sel = '';
                                                    endif;
                                                    ?>

                                                    @if( strtoupper($p->ruolo) == $position )
                                                        <option {{ $sel }} value="{{ $p->codice }}">{{ $p->nominativo }} ({{ $p->ruolo }})</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>

                                    </tr>

                                    <?php endfor; ?>

                                </table>

                            </div><!-- /.col -->



                            <div class="col-md-6">

                                <table class="table table-striped table-bordered table-condensed formazione">

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

                                            <select disabled data-position="{{ $position }}" name="sel_numero_maglia[{{ $i }}]" class="form-control">
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
                                                        <option {{ $sel }} value="{{ $p->codice }}">{{ $p->nominativo }} ({{ $p->ruolo }})</option>
                                                    @endif

                                                    @if( $position == 'R' AND strtoupper($p->ruolo) != 'P')
                                                        <option {{ $sel }} value="{{ $p->codice }}">{{ $p->nominativo }} ({{ $p->ruolo }})</option>
                                                    @endif

                                                @endforeach
                                            </select>
                                        </td>
                                        <td style="display: table-cell; vertical-align: middle">


                                        </td>
                                    </tr>

                                    <?php endfor; ?>

                                </table>


                            </div><!-- /.col -->

                        </div><!-- /.row -->


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
