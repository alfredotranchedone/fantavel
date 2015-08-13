<div class="table-responsive">
    <table class="table table-striped table-bordered no-margin">
        <tr>
            <th style="width: 10px">#</th>
            <th>Team</th>
            <th><span data-toggle="tooltip" data-original-title="Punti">Pt</span></th>
            <th><span data-toggle="tooltip" data-original-title="Vinte">V</span></th>
            <th><span data-toggle="tooltip" data-original-title="Nulle">N</span></th>
            <th><span data-toggle="tooltip" data-original-title="Pareggiate">P</span></th>
            <th><span data-toggle="tooltip" data-original-title="Gol Fatti">Gf</span></th>
            <th><span data-toggle="tooltip" data-original-title="Gol Subiti">Gs</span></th>
            <th><span data-toggle="tooltip" data-original-title="Differenza Reti">Dr</span></th>
            <th><span data-toggle="tooltip" data-original-title="FantaPunti">Fp</span></th>
        </tr>
        <?php $i=1; ?>
        @forelse($classifica as $c)

            <tr class="@if($c->user_id == Auth::user()->id) bg-success @endif">
                <td>{{ $i }}.</td>
                <td>{{ $c->name or ' - '}}</td>
                <td>{{ $c->punti }}</td>
                <td>{{ $c->vinte }}</td>
                <td>{{ $c->nulle }}</td>
                <td>{{ $c->perse }}</td>
                <td>{{ $c->gf }}</td>
                <td>{{ $c->gs }}</td>
                <td>{{ $c->differenzaReti }}</td>
                <td>{{ $c->fp }}</td>
            </tr>
            <?php $i++; ?>
        @empty
            <tr>
                <td colspan="10">Classifica non presente.</td>
            </tr>
        @endforelse
    </table>
</div>