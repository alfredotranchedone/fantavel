@extends('layouts.app')



@section('title','Utility')



@section('page-header')
<h1>
    Backup
</h1>
<ol class="breadcrumb">
    <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Backup</li>
</ol>
@endsection



@section('page-content')

    <div class="row">
      <div class="col-md-6">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Seleziona operazione</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">


                <div class="list-group">
                    <a href="{{ url('admin/utility/backup/database') }}" class="list-group-item">
                        <i class="fa fa-database fa-fw"></i>
                        Backup completo del Database
                        <i class="fa fa-angle-right fa-fw"></i>
                    </a>
                    <a href="{{ url('admin/utility/backup/ripristina') }}" class="list-group-item">
                        <i class="fa fa-cloud-upload fa-fw"></i>
                        Ripristina una versione del Database
                        <i class="fa fa-angle-right fa-fw"></i>
                    </a>
                </div>


            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- box-footer -->
        </div>

      </div>



      <div class="col-md-6">

          <div class="box">
              <div class="box-header with-border">
                  <h3 class="box-title">Files di Backup Presenti</h3>
                  <div class="box-tools pull-right">
                      <!-- Buttons, labels, and many other things can be placed here! -->
                      <!-- Here is a label for example -->
                  </div><!-- /.box-tools -->
              </div><!-- /.box-header -->
              <div class="box-body">

                  <table class="table table-bordered table-striped">
                      <tr>
                          <th>#</th>
                          <th>Nome File</th>
                          <th>Dim.</th>
                          <th>Data</th>
                      </tr>
                      <?php
                        $i=1;
                      ?>
                      @forelse($backupList as $f)
                        <tr>
                            <td>{{ $i }}.</td>
                            <td>
                                <form action="{{ url('admin/utility/backup/download') }}" method="POST">

                                    {{ last(explode('/',$f)) }}

                                    <input type="hidden" value="{{ \Crypt::encrypt($f) }}" name="file" />
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <button type="submit" class="btn btn-default btn-xs pull-right">
                                        <i class="fa fa-download fa-fw"></i>
                                    </button>

                                </form>
                            </td>
                            <td>{{ \Storage::size($f) / 1024}} kb</td>
                            <td>{{ date('d.m.Y', \Storage::lastModified($f)) }}</td>
                        </tr>
                        <?php $i++;; ?>
                      @empty
                        <tr>
                            <td>Nessun file presente</td>
                        </tr>
                      @endforelse
                  </table>

              </div><!-- /.box-body -->
              <div class="box-footer">
              </div><!-- box-footer -->
          </div>

      </div>

    </div>

@endsection
