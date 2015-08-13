<div class="table-responsive">
    <table class="table table-striped table-bordered no-margin">
        <tr>
            <th style="width: 10px">#</th>
            <th>Team</th>
            <th><span data-toggle="tooltip" data-original-title="FantaPunti">Fp</span></th>
        </tr>
        <?php $i=1; ?>
        @forelse($groups as $c)
            <tr>
                <td>{{ $i }}.</td>
                <td>{{ $c->name or ' - '}}</td>
                <td>{{ $c->fp or '-' }}</td>
            </tr>
            <?php $i++; ?>
        @empty
            <tr>
                <td colspan="10">Classifica non presente.</td>
            </tr>
        @endforelse
    </table>
</div>