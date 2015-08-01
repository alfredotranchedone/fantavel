@extends('layouts.app')



@section('title','Utility')



@section('page-header')
<h1>
    Utility
</h1>
<ol class="breadcrumb">
    <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Import</li>
</ol>
@endsection



@section('page-content')

    <div class="row">
      <div class="col-md-6">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Importa Calciatori</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

              <p>Sono presenti <b>{{ $player_count }}</b> calciatori. </p>
              <p class="text-red">Importando un nuovo file cancellerai i dati esistenti.</p>

              @include('pages.admin.parts.confirm_upload', ['form_action' => 'admin/import/upload'])



            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- box-footer -->
        </div>

      </div>


      <div class="col-md-6">
      </div>
    </div>

@endsection
