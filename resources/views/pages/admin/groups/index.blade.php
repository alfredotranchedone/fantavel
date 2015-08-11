@extends('layouts.app')



@section('title','Impostazioni \ Gruppi')



@section('page-header')
    <h1>
        Gruppi (Minicampionati)
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Impostazioni</li>
        <li class="active">Gruppi</li>
    </ol>
@endsection



@section('page-content')


    <div class="callout callout-info">
        <h4>Nota</h4>
        <p>
            I Gruppi possono essere usati per raggruppare le Giornate e creare, ad esempio, Mini Campionati.
        </p>
    </div>

    <div class="row">
        <div class="col-md-6">

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-list fa-fw"></i> Gruppi</h3>
                    <div class="box-tools pull-right">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->

                    </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">


                    <table class="table table-bordered table-striped">
                        <tr>
                            <th width="30px">#</th>
                            <th>Nome</th>
                            <th>Giornate</th>
                            <th width="50px"></th>
                            <th width="50px"></th>
                        </tr>
                        <?php $i=1; ?>

                        @forelse($gruppi as $g)
                            <tr>
                                <td>{{ $i }}.</td>
                                <td>{{ $g->name }}</td>
                                <td>da <b>{{ $g->calendario->first()->giornata or '-' }}</b> a <b>{{ $g->calendario->last()->giornata or '-'}}</b></td>
                                <td>
                                    <a href="{{ url('admin/config/groups/associa/'.$g->id) }}">associa</a>
                                </td>
                                <td><a class="btn btn-warning btn-xs"
                                       href="{{ url('admin/config/groups/edit/'.$g->id) }}"><i class="fa fa-edit fa-fw"></i> </a></td>
                            </tr>
                            <?php $i++; ?>
                        @empty
                            <tr>
                                <td colspan="3">Non sono presenti gruppi.</td>
                            </tr>
                        @endforelse

                    </table>

                </div><!-- /.box-body -->
                <div class="box-footer">

                </div><!-- box-footer -->
            </div>

        </div>


        <div class="col-md-6">

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-plus-square fa-fw"></i> Crea Gruppo</h3>
                    <div class="box-tools pull-right">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->

                    </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">

                    <form action="{{ url('admin/config/groups/store') }}" method="POST">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="nomeTeam">Nome Gruppo</label>
                            <input value="{{ old('name') }}" type="text" class="form-control" id="name" name="name" placeholder="Nome del gruppo">
                            <span class="help-block">Inserisci il nome del gruppo.</span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-md">Crea Gruppo</button>

                    </form>

                </div><!-- /.box-body -->
                <div class="box-footer">

                </div><!-- box-footer -->
            </div>

        </div>



    </div>

@endsection
