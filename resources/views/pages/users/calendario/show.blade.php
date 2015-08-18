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




                </div><!-- /.box-body -->
                <div class="box-footer">

                </div><!-- box-footer -->
            </div>

        </div>

    </div>

@endsection
