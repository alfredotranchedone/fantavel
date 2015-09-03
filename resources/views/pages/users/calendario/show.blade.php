@extends('layouts.app')



@section('title','Squadre')



@section('page-header')
<h1>
    Calendario
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('user') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Calendario</li>
</ol>
@endsection



@section('page-content')


    <a href="{{ url('user') }}" class="btn btn-default btn-md">
        <i class="fa fa-angle-left fa-fw"></i> Home
    </a>
    &nbsp;
    <a href="{{ url('user/formazione') }}" class="btn btn-default btn-md">
        <i class="fa fa-th-large fa-fw"></i> Formazione
    </a>
    &nbsp;
    <a href="{{ url('user/calendario') }}" class="btn btn-default btn-md">
        <i class="fa fa-calendar fa-fw"></i> Calendario
    </a>


    <div class="row marginTop">

        <div class="col-md-12">

            <div class="box">
                <div class="box-header with-border">
                    <i class="fa fa-male"></i>
                    <h3 class="box-title">Calendario</h3>
                    <div class="box-tools pull-right">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
                    </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">

                    <div class="row">


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
                                            <td><a href="{{ url('user/calendario/match/'.$m['id']) }}">dettagli</a></td>
                                        </tr>
                                    @endforeach
                                </table>

                                <table class="table table-condensed table-bordered">

                                    <tr>
                                        <td>
                                            @if($match['dataGiornata'])

                                                @if( $today > $match['dataGiornata'] )
                                                    <span class="text-red">
                                            <i class="fa fa-warning fa-fw"></i> Non è possibile modificare la formazione.
                                        </span>
                                                @else
                                                    <span class="text-green">
                                            <i class="fa fa-info-circle fa-fw"></i> E' possibile modificare la formazione.
                                        </span>
                                                @endif

                                            @else

                                                <span class="text-orange">
                                        <i class="fa fa-exclamation"></i>
                                        Non è stata ancora impostatata la data della giornata!
                                    </span>
                                            @endif


                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <b>Data Consegna: </b>
                                            @if($match['dataConsegna'])
                                                <span>{{ date("d-m-Y H:i:s", strtotime($match['dataConsegna'])) }}</span>
                                            @else
                                                <span><i>non inserita</i></span>
                                            @endif


                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Data Inizio Giornata: </b>
                                            @if($match['dataGiornata'])
                                                <span id="span-{{ $match['giornata'] }}">{{ date("d-m-Y H:i:s", strtotime($match['dataGiornata'])) }}</span>
                                            @else
                                                <span id="span-{{ $match['giornata'] }}"><i>non inserita</i></span>
                                            @endif


                                        </td>
                                    </tr>
                                    <tr>
                                        <td>



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


                </div>                <div class="box-footer">

                </div><!-- box-footer -->
            </div>

        </div>

    </div>

@endsection
