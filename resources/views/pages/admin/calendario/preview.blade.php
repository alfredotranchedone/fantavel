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
      <div class="col-md-12">

        <div class="box">
            <div class="box-header with-border">
                <i class="fa fa-calendar"></i>
                <h3 class="box-title">Anteprima Calendario</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                {!! $matches !!}

            </div><!-- /.box-body -->
            <div class="box-footer">
                @include('pages.admin.parts.confirm_generic', [
                    'prepend' =>
                        '<input type="hidden" name="gironi" value="'. $gironi .'">',
                    'class' => 'noMargin',
                    'form_action' => 'admin/calendario/save',
                    'buttonText' => 'Genera Calendario',
                    'buttonClass' => 'success',
                ])
            </div><!-- box-footer -->
        </div>

      </div>


    </div>

@endsection
