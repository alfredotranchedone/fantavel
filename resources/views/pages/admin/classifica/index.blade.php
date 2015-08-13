@extends('layouts.app')



@section('title','Classifica')



@section('page-header')
<h1>
    Classifica
</h1>
<ol class="breadcrumb">
    <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Classifica</li>
</ol>
@endsection



@section('page-content')

    <div class="row">

        <div class="col-md-12">

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


    @if($groups_name)
    <div class="row">
      <div class="col-md-6">

          <h3>Mini Campionati</h3>
          <div class="box">
              <div class="box-header with-border">
                  <i class="fa fa-list fa-fw"></i>
                  <h3 class="box-title">Campionato: {{ $groups_name }}</h3>
                  <div class="box-tools pull-right">
                      <!-- Buttons, labels, and many other things can be placed here! -->
                      <!-- Here is a label for example -->
                  </div><!-- /.box-tools -->
              </div><!-- /.box-header -->
              <div class="box-body">

                  @include('commons.classifica_mini_table')

              </div><!-- /.box-body -->
              <div class="box-footer">

              </div><!-- box-footer -->
          </div>

      </div>
    </div>
    @endif

@endsection
