@extends('layouts.app')



@section('title','Squadre')



@section('page-header')
<h1>
    Calendario
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('user') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ url('user/calendario') }}"><i class="fa fa-calendar"></i> Calendario</a></li>
    <li class="active">Dettaglio Incontro</li>
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


    @include('commons.tabellino')

@endsection
