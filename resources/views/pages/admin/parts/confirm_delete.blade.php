
<form action="{{ url($form_action) }}" method="POST" class="{{ $class or 'margin' }}">

    {!! $prepend or '' !!}

    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <button type="button" class="btn btn-danger btn-md" onclick="jQuery('#confirmContainer').slideToggle();">
        <i class="fa fa-trash fa-fw"></i> Elimina
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