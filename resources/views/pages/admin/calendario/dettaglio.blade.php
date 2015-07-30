@extends('layouts.app')



@section('title','Calendario')



@section('page-header')
<h1>
    Calendario
</h1>
<ol class="breadcrumb">
    <li><a href="{{ 'admin' }}"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li><a href="{{ 'admin/calendario' }}">Calendario</a></li>
    <li class="active">Dettaglio Incontro</li>
</ol>
@endsection



@section('page-content')

    @include('commons.tabellino')

@endsection
