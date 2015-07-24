@extends('layouts.app')



@section('title','Utility')



@section('page-header')
<h1>
    Backup
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li><a href="{{ url('admin/utility/backup') }}"></a></li>
    <li class="active">Ripristina Database</li>
</ol>
@endsection



@section('page-content')

    <div class="row">
      <div class="col-md-6">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-database fa-fw"></i> Ripristino del Database</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">


                <form action="{{ url('admin/utility/backup/ripristina') }}" method="POST" class="{{ $class or 'margin' }}">

                    <p>Questa operazione SOSTITUIRA' il database corrente con quello selezionato!</p>

                    <div style="padding-left: 15px">

                    <?php $i=0; ?>
                    @forelse($backupList as $f)
                        <div class="radio">
                            <label>
                                <input type="radio" name="db" id="db" value="{{ $f }}" {{ ($i>0)?:'checked'  }}>
                                {{ last(explode('/',$f)) }} <i>{{ date('d/m/Y - H:i:s',Storage::lastModified($f)) }}</i>
                            </label>
                        </div>
                        <?php $i++; ?>
                    @empty
                        <p>Nessun Database da ripristinare.</p>
                    @endforelse
                    </div>

                    <hr/>
                    <p>Per proseguire, conferma l'operazione.</p>

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



    </div>

@endsection
