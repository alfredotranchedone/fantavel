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

    <div class="row">
      <div class="col-md-12">
        @if($groups)

            @forelse($groups as $g)

                  <br/><br/>
                gruppo {{ $g->name }} <br/>

                @forelse($g->calendario as $c)
                    {{ $c->giornata }}
                @empty
                    no associazioni
                @endforelse

            @empty
                no gruppi
            @endforelse

        @endif
      </div>
    </div>

@endsection
