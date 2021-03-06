/**
 * Created by alfredo on 05/05/15.
 */

$(document).ready(function() {


    if($('#playersDataTable').length > 0) {

        var options = {

            "language": {
                lengthMenu: "Mostra _MENU_ calciatori",
                search: "Ricerca Calciatore:",
                zeroRecords: "Nessun calciatore trovato.",
                info:   "Visualizzati _START_ - _END_ di _TOTAL_ calciatori",
                paginate: {
                    first:      "Prima",
                    previous:   "< Prec.",
                    next:       "Succ. >",
                    last:       "Ultima"
                },
            },

            "initComplete": function (settings) {

                console.log('DT','init complete');

                var api = this.api();

                var select = $('#filterDataTableRuolo')
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        api.column(2)
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();

                    });

                $('#teamAssignedCount').html( $('#playersDataTable tbody tr.active').length );

            }

        };


        var pdt = $('#playersDataTable').dataTable(options);



        $('#playersDataTable tbody').on( 'click', 'tr', function () {

            var _this = $(this);
            var _playerId = _this.data('playerId');
            var _playerRuolo = _this.data('playerRuolo');
            var _playerCodice = _this.data('playerCodice');
            var _playerNominativo = _this.data('playerNominativo');

            _this.toggleClass('active');

            if(_this.hasClass('active')) {
                var _html  = '<li class="list-group-item" data-codice="'+ _playerCodice +'">';
                _html += _playerNominativo
                _html += ' ('+ _playerRuolo +') ';
                _html += '<input type="hidden" name="cods[]" value="'+_playerCodice+'" />';
                _html += '<button type="button" class="btn btn-default btn-xs pull-right" data-codice="'+ _playerCodice +'" onclick="removePlayer(this);">';
                _html += '  <i class="fa fa-trash-o fa-fw"></i>';
                _html += '</button>';
                _html += '</li>';
                $('#teamAssigned').append(_html);
            } else {
                $('#teamAssigned li[data-codice='+ _playerCodice +']').remove();
            }

            $('#teamAssignedCount').html( $('#playersDataTable tbody tr.active').length );

        } );

    }



    // spegni evidenziazzione riga
    $('#playersDataTable.no-highlight tbody').off('click');


    var assigned = [];

    $('button[data-id*="btnPosRemove"]').each(function(i){
        $(this).on('click',function(){
            var _maglia = $(this).data('maglia');
            var _codice = $(this).val();
            $('select[name="sel_numero_maglia['+ _maglia +']"]').val(0);
            $('input[name="numero_maglia['+ _maglia +']"]').val(0);
            assigned[_maglia] = '0';
            $('option[value=' +  $(this).val() + ']').prop('disabled', false);
        });
    });

    $('select[name*="sel_numero_maglia"]').each(function(i){

        // init
        $('button[data-id="btnPosRemove'+ (i+1) +'"]').val( $(this).val() );
        $('input[name="numero_maglia['+ (i+1) +']"]').val( $(this).val() );
        assigned[i+1] = $(this).val();
        for(var _v in assigned) {
            if($('option[value=' + assigned[_v] + ']').val() != '0') {
                $('option[value=' + assigned[_v] + ']').prop('disabled', true);
            }
        }
        // fine init


        $(this).on('change',function(e){

            $('input[name="numero_maglia['+ (i+1) +']"]').val( $(this).val() );
            assigned[i+1] = $('input[name="numero_maglia['+ (i+1) +']"]').val();

            $('option').prop('disabled', false);
            for(var _v in assigned) {
                if($('option[value=' + assigned[_v] + ']').val() != '0') {
                    $('option[value=' + assigned[_v] + ']').prop('disabled', true);
                }
            }

        });

    });


} );


/* DATEPICKER - TIMEPICKER INIT */
    $('.datepicker').pickadate({
        format: 'dd-mm-yyyy',
        formatSubmit: 'yyyy-mm-dd',
    });

    $('.timepicker').pickatime({
        format: 'HH:i',
        formatSubmit: 'HH:i',
    });
/* --- */


$( ".ajaxForm" ).on( "submit", function( event ) {

    event.preventDefault();

    var _callback = $(this).data('callback');

    var _token = $('#_token').val();
    var _action = $('#action',this).val();
    var _formData = $( this ).serialize() + '&_token=' + _token;
    var _formId = $( this).id;
    //console.log(_formData);
    $.ajax({
        type        : 'POST',
        url         : _action,
        data        : _formData,
        dataType    : 'json',
        encode      : true
    }).done(function(response){
        console.log('RESP',response);
        console.log('DATA-ATTR-CB',_callback);
        if(_callback)
            eval(_callback);
    });

});


function ajaxSubmit(_form,_callback){

    console.log(  );

    var _token = $('#_token').val();
    var _action = $('#action',_form).val();
    var _formData = _form.serialize() + '&_token=' + _token;
    var _formId = _form.attr('id');

    // set form action
    _form.attr('action',_action);

    //console.log(_formData);

    $.ajax({
        type        : 'POST',
        url         : _action,
        data        : _formData,
        dataType    : 'json',
        encode      : true
    }).done(function(response){
        console.log('RESP',response);
        // console.log('DATA-ATTR-CB',_callback);

        $('#cb-modal-sm').modal('show');

        if(_callback)
            _callback(_formId,response);
    });

    return false;

}



function repopulateForm(elem,resp){

    var dg = resp.dataGiornata.split(' ');
    var data = dg[0];
    var ora = dg[1];

    $('#'+elem).siblings('span').html( resp.dataGiornata )

}



function removePlayer(elem){

    var _playerCodice = $(elem).data('codice');

    $('#teamAssigned li[data-codice='+ _playerCodice +']').remove();
    $('#playersDataTable tbody tr[data-player-codice='+ _playerCodice +']')
        .removeClass('active');

}



function dgAddFormToggle(n_id_form){
    $('#dg-add-'+n_id_form).toggle();
}
function dcAddFormToggle(n_id_form){
    $('#dc-add-'+n_id_form).toggle();
}
