@extends('layouts.app')



@section('title','Utility')



@section('page-header')
<h1>
    Backup
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li><a href="{{ url('admin/utility/backup') }}"></a></li>
    <li class="active">Database</li>
</ol>
@endsection



@section('page-content')

    <div class="row">
      <div class="col-md-6">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-database fa-fw"></i> Backup del Database</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <p>Questa operazione creerà una copia completa del database.</p>
                <p>Per favore, conferma l'operazione.</p>

                @include('pages.admin.parts.confirm_generic', [
                    'class' => 'noMargin',
                    'form_action' => 'admin/utility/backup/database'
                ])


            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- box-footer -->
        </div>

      </div>



    </div>

@endsection
