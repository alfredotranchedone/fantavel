<div class="box collapsed-box">
    <div class="box-header with-border">
        <i class="fa fa-users fa-fw"></i>
        <h3 class="box-title">Visualizza Rosa</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">

        <table class="table table-condensed table-bordered table-striped">
            <tr>
                <th width="30px">#</th>
                <th width="40px">Codice</th>
                <th width="30px">Ruolo</th>
                <th>Nome</th>
            </tr>

            <?php $ii = 1; ?>
            @forelse($players as $pl)
                <tr>
                    <td>{{ $ii }}.</td>
                    <td>{{ $pl->codice }}</td>
                    <td>{{ $pl->ruolo }}</td>
                    <td>{{ $pl->nominativo }}</td>
                </tr>
                <?php $ii++; ?>
            @empty
                <tr>
                    <td colspan="4">Nessuna rosa presente.</td>
                </tr>
            @endforelse

        </table>

    </div><!-- /.box-body -->
    <div class="box-footer">
        Totale Giocatori: {{ $ii-1 }}
    </div>
</div>