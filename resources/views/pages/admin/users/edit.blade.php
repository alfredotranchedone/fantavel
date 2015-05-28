@extends('layouts.app')



@section('title','Utenti')



@section('page-header')
<h1>
    Utenti
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li><a href="{{ url('admin/user') }}"> Users</a></li>
    <li class="active">Edit User</li>
</ol>
@endsection



@section('page-content')


    <div class="row">
      <div class="col-md-12">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Modifica Utente</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                @endforeach

                <div class="row">
                  <div class="col-md-6 col-sm-12 col-xs-12">

                      <form action="{{ url('admin/user/'.$user->id) }}" method="POST" class="margin">

                          <input type="hidden"  name="_method" value="PUT">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">

                          <fieldset>
                              <legend>Dati</legend>

                              <div class="form-group">
                                  <label for="nome">Nominativo</label>
                                  <input value="{{ $user->name }}" type="text" class="form-control" id="nome" name="nome" placeholder="nominativo">
                                  <span class="help-block">Inserisci il nome dell'utente.</span>
                              </div>

                              <div class="form-group">
                                  <label for="email">Email</label>
                                  <input value="{{ $user->email }}" type="email" class="form-control" id="email" name="email" placeholder="nome@email.it">
                                  <span class="help-block">Inserisci un indirizzo email valido.</span>
                              </div>

                              <div class="form-group">
                                  <label for="password">Password</label>
                                  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                              </div>

                              <div class="form-group">
                                  <label for="password_confirmation">Conferma Password</label>
                                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Conferma Password">
                              </div>

                              <div class="form-group">
                                  <label>Attiva Utente</label>
                                  <select name="attivo" class="form-control">
                                      <option value="1" {{ $user->attivo?:'selected' }} >Attivo</option>
                                      <option value="0" {{ $user->attivo?:'selected' }}>Non Attivo</option>
                                  </select>
                              </div>
                          </fieldset>

                          <hr/>

                          <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Salva Modifiche</button>

                          <a class="btn btn-default pull-right" href="{{ url('admin/user/'.$user->id) }}"><b>Annulla</b></a>

                          <hr/>

                          <form action="{{ url('admin/user/'.$user->id) }}" method="POST">

                              <input type="hidden" name="_method" value="DELETE">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">

                              <button type="button" class="btn btn-danger btn-md" onclick="jQuery('#confirmContainer').slideToggle();">
                                  <i class="fa fa-trash fa-fw"></i> Elimina Utente
                              </button>

                              <div id="confirmContainer"  style="display: none; margin-top: 15px">
                                  <p>Per proseguire con l'eliminazione, scrivi "DELETE" nel campo sottostante.</p>
                                  <div class="input-group">
                                    <input type="text" name="confirmDelete" class="form-control" autocomplete="off" />
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default btn-md">Prosegui <i class="fa fa-chevron-right fa-fw"></i></button>
                                    </span>
                                  </div>
                              </div>

                          </form>


                      </form>

                  </div>
                </div>
                <!-- /.row -->



            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- box-footer -->
        </div>

      </div>



    </div>

@endsection
