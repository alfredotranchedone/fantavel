@extends('layouts.app')



@section('title','Squadre')



@section('page-header')
<h1>
    Squadre
</h1>
<ol class="breadcrumb">
    <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Squadre</li>
</ol>
@endsection



@section('page-content')

    <div class="row">


        <div class="col-md-5">

            <div class="box">
                <div class="box-header with-border">
                    <i class="fa fa-cubes fa-fw"></i>
                  <h3 class="box-title">Gestisci Rose e Formazioni</h3>
                  <div class="box-tools pull-right">
                    <!-- Buttons, labels, and many other things can be placed here! -->
                    <!-- Here is a label for example -->
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">

                    <div class="table-responsive ">
                        <table class="table table-striped no-margin">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Team</th>
                                <th></th>
                                <th></th>
                                <th>Calciatori</th>
                            </tr>
                            <?php $i=1; ?>
                            @foreach($teams as $team)
                                <tr>
                                    <td>{{ $i }}.</td>
                                    <td><a href="{{ url('admin/rose/formazione/'.$team->id) }}">{{ $team->name }}</a></td>
                                    <td>
                                        <a
                                                href="{{ url('admin/rose/formazione/'.$team->id) }}"
                                                class="btn btn-primary btn-xs">
                                            <i class="fa fa-th-large fa-fw"></i>
                                            Formazione
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                                href="{{ url('admin/rose/assign/'.$team->id) }}"
                                                class="btn bg-purple btn-xs">
                                            <i class="fa fa-male fa-fw"></i>
                                            Rose
                                        </a>
                                    </td>
                                    <td><?php  echo (!isset( $team->players )) ? $team->players()->count() : '0'; ?></td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                       </table>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">

                </div><!-- box-footer -->
            </div>

        </div>



        <div class="col-md-7">

            <div class="box">
                <div class="box-header with-border">
                    <i class="fa fa-list fa-fw"></i>
                    <h3 class="box-title">Classifica</h3>
                    <div class="box-tools pull-right">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
                    </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">

                    @include('commons.classifica_table')

                </div><!-- /.box-body -->
                <div class="box-footer">

                </div><!-- box-footer -->
            </div>

        </div>



    </div>

@endsection
