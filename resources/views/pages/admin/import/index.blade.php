@extends('layouts.app')



@section('title','Utility')



@section('page-header')
<h1>
    Utility
</h1>
<ol class="breadcrumb">
    <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Import</li>
</ol>
@endsection



@section('page-content')

    <div class="row">
      <div class="col-md-6">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-upload fa-fw"></i> Importa Calciatori</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

              <p>Sono presenti <b>{{ $player_count }}</b> calciatori. </p>
              <p class="text-red">Importando un nuovo file cancellerai i dati esistenti.</p>

              @include('pages.admin.parts.confirm_upload', ['form_action' => 'admin/import/upload'])


            </div><!-- /.box-body -->

        </div>

      </div>


      <div class="col-md-6">

          <div class="box">
              <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-plus-circle fa-fw"></i> Aggiungi Calciatore</h3>
                  <div class="box-tools pull-right">
                      <!-- Buttons, labels, and many other things can be placed here! -->
                      <!-- Here is a label for example -->

                  </div><!-- /.box-tools -->
              </div><!-- /.box-header -->
              <div class="box-body">

                  <p>Aggiungi manualmente un calciatore.</p>

                  <form action="{{ url('admin/import/player') }}" method="post">

                      @foreach ($errors->all() as $error)
                          <p class="text-danger"># {{ $error }}</p>
                      @endforeach

                      <input type="hidden" name="_token" value="{{ csrf_token() }}">

                      <div class="form-group">
                        <label for="nominativo">Nominativo</label>
                        <input type="text"
                              class="form-control"
                              name="nominativo"
                              id="nominativo"
                              value="{{ old('nominativo') }}"
                              placeholder="Formato: COGNOME Nome">
                      </div>

                      <div class="form-group">
                        <label for="ruolo">Ruolo</label>
                        <select
                              class="form-control"
                              name="ruolo"
                              id="ruolo">
                            <option {{ (old('ruolo') == 'P') ? 'selected':'' }} value="P">Portiere (P)</option>
                            <option {{ (old('ruolo') == 'D') ? 'selected':'' }} value="D">Difensore (D)</option>
                            <option {{ (old('ruolo') == 'C') ? 'selected':'' }} value="C">Centrocampista (C)</option>
                            <option {{ (old('ruolo') == 'T') ? 'selected':'' }} value="T">Trequartista (T)</option>
                            <option {{ (old('ruolo') == 'A') ? 'selected':'' }} value="A">Attaccante (A)</option>
                            </select>
                      </div>

                      <div class="form-group">
                        <label for="codice">Codice</label>
                        <input type="text"
                              class="form-control"
                              name="codice"
                              id="codice"
                              value="{{ old('codice') }}"
                              placeholder="Codice">
                      </div>


                      <div class="form-group">
                          <label for="teams_id">Associa a Squadra</label>
                          @if($teams)
                          <select
                                  class="form-control"
                                  name="teams_id"
                                  id="teams_id">
                              <option value="0">Non Associare</option>
                              <optgroup label="Teams">
                             @foreach($teams as $t)
                                  <option
                                          {{ (old('teams_id') == $t->id) ? 'selected':'' }}
                                          value="{{ $t->id }}">{{ $t->name }}</option>
                             @endforeach
                              </optgroup>
                          </select>
                          @else
                            Non ci sono squadre
                          @endif
                          <span class="help-block">Se vuoi inserire il Calciatore in una Rosa, scegli il Team.</span>
                      </div>

                      <hr/>

                      <button type="submit" class="btn btn-success btn-md">
                          <i class="fa fa-plus-circle fa-fw"></i>
                          Salva Calciatore</button>
                  </form>

              </div><!-- /.box-body -->

          </div>

      </div>

    </div>

@endsection
