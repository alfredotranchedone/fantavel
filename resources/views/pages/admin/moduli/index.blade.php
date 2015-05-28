@extends('layouts.app')



@section('title','Moduli')



@section('page-header')
<h1>
    Impostazioni
</h1>
<ol class="breadcrumb">
    <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Impostazioni</li>
</ol>
@endsection



@section('page-content')

    <div class="row">
      <div class="col-md-6">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Lista Moduli</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <div class="table-responsive ">
                    <table class="table table-striped no-margin">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Modulo</th>
                            <th>Modificatore</th>
                            <th></th>
                        </tr>

                        @forelse($moduli as $m)
                            <tr>
                                <td></td>
                                <td>{{ $m->name }}</td>
                                <td><?php echo ($m->modificatore > 0) ?
                                            '+'.$m->modificatore :
                                            $m->modificatore
                                    ?>
                                </td>
                                <td><a href="{{ url('admin/moduli/'. $m->id .'/edit') }}" class="btn btn-warning btn-xs"><i class="fa fa-edit fa-fw"></i></a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Nessun modulo presente.</td>
                            </tr>
                        @endforelse
                    </table>
                </div>

            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- box-footer -->
        </div>

      </div>



      <div class="col-md-6">

          <div class="box">
              <div class="box-header with-border">
                  <h3 class="box-title"><?php echo isset($modulo) ? 'Modifica':'Crea'; ?> Modulo</h3>
                  <div class="box-tools pull-right">
                      <!-- Buttons, labels, and many other things can be placed here! -->
                      <!-- Here is a label for example -->
                  </div><!-- /.box-tools -->
              </div><!-- /.box-header -->
              <div class="box-body">

                  @foreach ($errors->all() as $error)
                      <p class="text-danger">{{ $error }}</p>
                  @endforeach

                  @if(! isset($modulo))
                      <form action="{{ url('admin/moduli') }}" method="post">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">

                          <div class="form-group">
                              <label for="modulo">Modulo</label>
                              <input value="" type="text" class="form-control" id="modulo" name="modulo" placeholder="3-4-3, 5-3-2, ecc...">
                              <span class="help-block">Inserisci il modulo.</span>
                          </div>

                          <div class="form-group">
                              <label for="modificatore">Modificatore</label>
                              <input value="" type="text" class="form-control" id="modificatore" name="modificatore" placeholder="1,0 oppure -3, ecc....">
                              <span class="help-block">Inserisci il modificatore del punteggio (1,5,-3,ecc).</span>
                          </div>

                          <button
                                  type="submit"
                                  class="btn btn-primary">
                              <i class="fa fa-plus fa-fw"></i>
                              Crea Modulo
                          </button>
                      </form>

                  @else

                      <form action="{{ url('admin/moduli/'.$modulo->id) }}" method="post">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="_method" value="PUT">

                          <div class="form-group">
                              <label for="modulo">Modulo</label>
                              <input value="{{ $modulo->name }}" type="text" class="form-control" id="modulo" name="modulo" placeholder="3-4-3, 5-3-2, ecc...">
                              <span class="help-block">Inserisci il modulo.</span>
                          </div>

                          <div class="form-group">
                              <label for="modificatore">Modificatore</label>
                              <input value="{{ $modulo->modificatore }}" type="text" class="form-control" id="modificatore" name="modificatore" placeholder="1,0 oppure -3, ecc....">
                              <span class="help-block">Inserisci il modificatore del punteggio (1,5,-3,ecc).</span>
                          </div>

                          <button
                                  type="submit"
                                  class="btn btn-primary">
                              <i class="fa fa-save fa-fw"></i>
                              Salva Modifica
                          </button>

                          <a
                                  href="{{ url('admin/moduli') }}"
                                  class="btn btn-default pull-right">
                              Annulla
                          </a>

                      </form>

                      @include('pages.admin.parts.confirm_delete', [
                        'form_action' => 'admin/moduli/'.$modulo->id,
                        'class' => '',
                        'prepend' => '<hr>'
                      ])

                  @endif

              </div><!-- /.box-body -->
              <div class="box-footer">

              </div><!-- box-footer -->
          </div>

      </div>

    </div>

@endsection
