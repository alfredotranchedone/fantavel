@extends('layouts.app')



@section('title','Calendario')



@section('page-header')
<h1>
    Calendario
</h1>
<ol class="breadcrumb">
    <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
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
                @forelse($all as $match)
                     <?php
                        if( $match['giornata'] > (count($all) / 2) ) {
                            $rit = '(Rit.)';
                        }
                     ?>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                     <table class="table table-bordered table-striped">
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
                            <td><a href="#">dettagli</a></td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="4">
                                <b>Data Inizio Giornata: </b>
                                @if($match['dataGiornata'])
                                    {{ $match['dataGiornata'] }}
                                @else
                                    <a href="#"><i class="fa fa-angle-right"></i> Inserisci Data e Ora</a>
                                @endif
                                <hr style="margin-top: 10px; margin-bottom: 7px;"/>
                                <b>Data Limite Consegna Formazione: </b>
                                @if($match['dataConsegna'])
                                    {{ $match['dataConsegna'] }}
                                @else
                                    <a href="#"><i class="fa fa-angle-right"></i> Inserisci Data e Ora</a>
                                @endif
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
