@extends('layouts.app')



@section('title','Calciatori')



@section('page-header')
<h1>
    Calciatori
</h1>
<ol class="breadcrumb">
    <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Calciatori</li>
</ol>
@endsection



@section('page-content')

    <div class="actionBar">
        <a href="{{ route('admin.players.index') }}" class="btn btn-default">
            <i class="fa fa-angle-left"></i>
            Torna a Calciatori</a>
    </div>

    <div class="row marginTop15">
      <div class="col-md-6">

        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Modifica Calciatore</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <form action="{{ route('admin.players.update',[$player->codice]) }}" method="post">


                    @foreach ($errors->all() as $error)
                        <p class="text-danger"># {{ $error }}</p>
                    @endforeach

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">

                        <input name="id" id="id" type="hidden" value="{{ $player->id }}" >

                    <div class="form-group">
                        <label for="nominativo">Nominativo</label>
                        <input type="text"
                               class="form-control"
                               name="nominativo"
                               id="nominativo"
                               autocomplete="off"
                               value="{{ old('nominativo',$player->nominativo) }}"
                               placeholder="Formato: COGNOME Nome">
                    </div>

                    <div class="form-group">
                        <label for="ruolo">Ruolo</label>
                        <select
                                class="form-control"
                                name="ruolo"
                                id="ruolo">
                            <option {{ (old('ruolo',$player->ruolo) == 'P') ? 'selected':'' }} value="P">Portiere (P)</option>
                            <option {{ (old('ruolo',$player->ruolo) == 'D') ? 'selected':'' }} value="D">Difensore (D)</option>
                            <option {{ (old('ruolo',$player->ruolo) == 'C') ? 'selected':'' }} value="C">Centrocampista (C)</option>
                            <option {{ (old('ruolo',$player->ruolo) == 'T') ? 'selected':'' }} value="T">Trequartista (T)</option>
                            <option {{ (old('ruolo',$player->ruolo) == 'A') ? 'selected':'' }} value="A">Attaccante (A)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="codice">Codice</label>
                        <input type="text"
                               class="form-control"
                               name="codice"
                               id="codice"
                               autocomplete="off"
                               value="{{ old('codice',$player->codice) }}"
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
                                                {{ (old('teams_id',$player->teams_id) == $t->id) ? 'selected':'' }}
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

                        <button type="button" class="btn btn-success btn-md"
                                onclick="jQuery(this).next('.confirmContainer').slideToggle();">
                            <i class="fa fa-plus-circle fa-fw"></i>
                            Salva Modifica
                        </button>

                        <div class="confirmContainer" style="display: none; margin-top: 15px">
                            <p>Per proseguire con l'operazione, scrivi "CONFIRM" nel campo sottostante.</p>

                            <div class="input-group">
                                <input type="text" name="confirm" class="form-control" autocomplete="off"/>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default btn-md">Prosegui <i class="fa fa-chevron-right fa-fw"></i>
                                    </button>
                                </span>
                            </div>
                        </div>

                </form>

            </div><!-- /.box-body -->

        </div>

      </div>


    </div>



    <div class="row">
      <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Elimina Calciatore</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                @include('pages.admin.parts.confirm_delete', ['form_action' => route('admin.players.destroy',[$player->codice])])

            </div><!-- /.box-body -->

        </div>
      </div>
    </div>
    <!-- /.row -->



@endsection
