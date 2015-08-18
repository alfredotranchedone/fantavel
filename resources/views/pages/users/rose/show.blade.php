@extends('layouts.app')



@section('title','Squadre')



@section('page-header')
<h1>
    Squadre
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('user') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Rosa</li>
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

    <h2><i class="fa fa-group fa-fw"></i> {{ $team->name }}</h2>

    <hr style="border-color: #fff"/>



    <div class="row">

        <div class="col-md-12">

            <div class="box">
                <div class="box-header with-border">
                    <i class="fa fa-male"></i>
                    <h3 class="box-title">Rosa</h3>
                    <div class="box-tools pull-right">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
                    </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">

                    <div class="table-reponsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th width="30">#</th>
                                <th width="50">Codice</th>
                                <th width="50">Ruolo</th>
                                <th>Nominativo</th>

                            </tr>
                            <?php $i=1; ?>
                            @forelse($players as $p )
                                <tr>
                                    <td><small>{{ $i }}.</small></td>
                                    <td>{{ $p->codice }}</td>
                                    <td>{{ $p->ruolo }}</td>
                                    <td>{{ $p->nominativo }}</td>
                                </tr>
                                <?php $i++; ?>
                            @empty
                                <tr>
                                    <td colspan="4">Nessun giocatore in rosa.</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>


                </div><!-- /.box-body -->
                <div class="box-footer">

                </div><!-- box-footer -->
            </div>

        </div>

    </div>

@endsection
