<?php
$dataGiornata = $match->first()->dataGiornata;
$dataConsegna = $match->first()->dataConsegna;
?>
<table class="table table-condensed table-bordered table-striped">
    <tr>
        <th colspan="2" width="50%"><i class="fa fa-calendar-o fa-fw"></i> Data Giornata</th>
        <th colspan="2"><i class="fa fa-bell-o fa-fw"></i> Limite Consegna</th>
    </tr>
    <tr>
        <td colspan="2">
            @if($dataGiornata)
                {{ $dataGiornata }}
                {{-- <small>[<a href="{{ url('admin/calendario/mostra') }}">modifica</a></a>]</small> --}}
            @else
                {{--
                <a href="{{ url('admin/calendario/mostra') }}">
                    <i class="fa fa-angle-right"></i> Aggiungi Data</a></a>
                    --}}
            @endif
        </td>
        <td colspan="2">
            {{ $dataConsegna or 'n.d.' }}
        </td>
    </tr>
</table>

<table class="table table-condensed table-bordered table-striped">
    <tr>
        <th><i class="fa fa-home fa-fw"></i> Fattore Campo</th>
    </tr>
    <tr>
        <td>
            @if($match->first()->fattore_campo > 0)
                <i class="fa fa-check-square-o fa-fw"></i> SI
            @else
                <i class="fa fa-square-o fa-fw"></i> NO
            @endif
        </td>
    </tr>
</table>