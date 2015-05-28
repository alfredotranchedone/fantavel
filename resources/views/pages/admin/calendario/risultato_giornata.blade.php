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
                <h3 class="box-title">Risultato Giornata</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <h4>Giornata {{ $giornata or '-'}}</h4>

                <table class="table table-bordered table-striped">

                    <tr>
                        <th style="width:30px;">#</th>
                        <th>Incontro</th>
                        <th>Risultato</th>
                        <th>Pt.</th>
                        <th style="width: 30px"></th>
                    </tr>

                    <?php $i = 1; ?>
                    @forelse($matches as $match)
                        <tr>
                            <td>{{ $i }}.</td>
                            <td>{{ $match->team1 }} - {{ $match->team2 }}</td>
                            <td>{{ $match->goal1 }} - {{ $match->goal2 }}</td>
                            <td>{{ $match->resultTeam1 }} - {{ $match->resultTeam2 }}</td>
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

            </div><!-- box-footer -->
        </div>

      </div>



      <div class="col-md-6">



      </div>

    </div>

@endsection
