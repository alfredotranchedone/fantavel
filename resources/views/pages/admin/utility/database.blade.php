@extends('layouts.app')



@section('title','Utility')



@section('page-header')
<h1>
    Database
</h1>
<ol class="breadcrumb">
    <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Database</li>
</ol>
@endsection



@section('page-content')

    <div class="row">
      <div class="col-md-6">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Resetta Tabelle</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">


                <form action="{{ url('admin/utility/database/reset') }}" method="POST" class="{{ $class or 'margin' }}">

                    <p>Questa operazione ELIMINERA' TUTTI I DATI dalle tabelle selezionate!</p>
                    <p class="text-red">E' consigliato effettuare un backup di sicurezza!</p>

                    <b>Operazione:</b>
                    <div style="padding-left: 15px">

                        <div class="radio">
                            <label>
                                <input type="radio" name="tbl" id="tbl" value="stagione" checked>
                                Resetta Tabelle (Calendario, Formazioni, Giocatori, Punteggi, Risultati, Cassifica)
                            </label>
                        </div>

                    </div>

                    <hr/>
                    <p>Per proseguire conferma l'operazione.</p>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <button type="button" class="btn btn-{{ $buttonClass or 'primary' }} btn-md" onclick="jQuery('#confirmContainer').slideToggle();">
                        <i class="fa {{ $buttonIconClass or 'fa-exclamation-circle' }} fa-fw"></i> {{ $buttonText or 'Conferma Operazione' }}
                    </button>

                    <div id="confirmContainer"  style="display: none; margin-top: 15px">
                        <p>Per proseguire con l'operazione, scrivi "CONFIRM" nel campo sottostante.</p>
                        <div class="input-group">
                            <input type="text" name="confirm" class="form-control" autocomplete="off" />
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-md">Prosegui <i class="fa fa-chevron-right fa-fw"></i></button>
                            </span>
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
