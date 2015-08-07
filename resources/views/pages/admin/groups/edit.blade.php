@extends('layouts.app')



@section('title','Impostazioni \ Gruppi')



@section('page-header')
    <h1>
        Gruppi (Minicampionati)
    </h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Impostazioni</li>
        <li class="active">Gruppi</li>
    </ol>
@endsection



@section('page-content')




    <div class="row">

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

                    <form action="{{ url('admin/config/groups/update') }}" method="POST">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ $gruppo->id }}">

                        <div class="form-group">
                            <label for="nomeTeam">Nome Gruppo</label>
                            <input value="{{ old('name',$gruppo->name) }}" type="text" class="form-control" id="name" name="name" placeholder="Nome del gruppo">
                            <span class="help-block">Inserisci il nome del gruppo.</span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-md">Salva Modifiche</button>

                    </form>

                    <hr/>

                    @include('pages.admin.parts.confirm_delete',[
                           'form_action' => 'admin/config/groups/destroy/'.$gruppo->id
                       ])

                </div><!-- /.box-body -->
                <div class="box-footer">

                </div><!-- box-footer -->
            </div>

        </div>



    </div>

@endsection
