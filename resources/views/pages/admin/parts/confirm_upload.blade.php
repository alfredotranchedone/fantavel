

<form action="{{ url($form_action) }}" class="{{ $class or '' }}" method="post" enctype="multipart/form-data">

    {{ $prepend or '' }}

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <p><input type="file" name="xls" class="form-control"></p>

    <button type="button" class="btn btn-primary btn-md" onclick="jQuery('#confirmContainer').slideToggle();">
        <i class="fa fa-upload fa-fw"></i> Carica File
    </button>

    <div id="confirmContainer"  style="display: none; margin-top: 15px">
        <p>Per proseguire con il caricamento, scrivi "UPLOAD" nel campo sottostante.</p>
        <div class="input-group">
            <input type="text" name="confirmText" class="form-control" autocomplete="off" />
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default btn-md">Prosegui <i class="fa fa-chevron-right fa-fw"></i></button>
            </span>
        </div>
    </div>

</form>