

@if(!$lastMatches->isEmpty())
<table class="table table-condensed table-bordered table-striped">
    <tr>
        <th><i class="fa fa-home fa-fw"></i> Fattore Campo</th>
    </tr>
    <tr>
        <td>
            @if($lastMatches->first()->fattore_campo > 0)
                <i class="fa fa-check-square-o fa-fw"></i> SI
            @else
                <i class="fa fa-square-o fa-fw"></i> NO
            @endif
        </td>
    </tr>
</table>
@endif