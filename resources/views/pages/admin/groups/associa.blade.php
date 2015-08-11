@extends('layouts.app')



@section('title','Impostazioni \ Gruppi')



@section('page-header')
    <h1>
        Gruppi (Minicampionati)
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Impostazioni</li>
        <li><a href="{{ url('admin/config/groups') }}">Gruppi</a></li>
        <li class="active">Associa</li>
    </ol>
@endsection



@section('page-content')


    <div class="callout callout-info">
        <h4>Nota</h4>
        <p>Da questa pagina è possibile associare le giornate al gruppo selezionato.</p>
    </div>

    <a href="{{ url('admin/config/groups') }}" class="btn btn-default btn-md"><i class="fa fa-angle-left fa-fw"></i> Gruppi</a>

    <div class="row">
        <div class="col-md-6">

            <div class="box marginTop">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-list fa-fw"></i> Gruppo: {{ $gruppo->name }}</h3>
                    <div class="box-tools pull-right">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->

                    </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">

                    @if($errors->all())
                        <div class="alert alert-danger">
                            <p><b>Attenzione!</b></p>
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <p>Scegli le giornate da associare al gruppo <b>{{ $gruppo->name }}</b>:</p>

                    <form action="{{url('admin/config/groups/associa')}}" class="form-horizontal" method="POST">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input name="id" id="id" type="hidden" value="{{ $gruppo->id }}" >

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Gruppo</label>

                            <div class="col-sm-8">
                                <p class="form-control-static">{{ $gruppo->name }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="select_giornata_start" class="col-sm-4 control-label">Dalla Giornata:</label>

                            <div class="col-sm-8">
                                <select
                                       name="select_giornata_start"
                                       id="select_giornata_start"
                                       class="form-control">

                                    <option value="0">Nessuna giornata</option>

                                    @forelse($giornate as $g)
                                        <option value="{{ $g->giornata }}" @if($assoc_start == $g->giornata) selected @endif>
                                            {{ $g->giornata }}
                                        </option>
                                    @empty
                                        <option value="0" disabled>Nessuna giornata presente.</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="select_giornata_end" class="col-sm-4 control-label">Alla Giornata:</label>

                            <div class="col-sm-8">
                                <select
                                       name="select_giornata_end"
                                       id="select_giornata_end"
                                       class="form-control">

                                    <option value="0">Nessuna giornata</option>

                                    @forelse($giornate as $g)
                                        <option value="{{ $g->giornata }}" @if($assoc_end == $g->giornata) selected @endif>
                                            {{ $g->giornata }}
                                        </option>
                                    @empty
                                        <option value="0" disabled>Nessuna giornata presente.</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button
                                        id="btnSave"
                                        type="submit"
                                        class="btn btn-primary">
                                    Salva Associazione
                                </button>
                            </div>
                        </div>


                    </form>






                </div><!-- /.box-body -->
                <div class="box-footer">

                </div><!-- box-footer -->
            </div>

        </div>


        <div class="col-md-6">



        </div>



    </div>

@endsection
