$(document).ready(function() {
    var btnIndex = -1, btnId = 0;
    $('#table-container').on('click', '.btn-show-action', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    $('#action-detail').on('click', function() {
        window.location = window.location + '/' + btnId + '/detail?start=' + $('#input-tanggal-awal').val() + '&end=' + $('#input-tanggal-akhir').val();
    });

    // $('#table-container').load(window.location.origin + '/component/piutang');

    $('#btn-apply-filter').on('click', function() {
        $('#table-container').load(window.location.origin + '/component/piutang?start=' + $('#input-tanggal-awal').val() + '&end=' + $('#input-tanggal-akhir').val(), function () {
            $('#total-piutang').text('Rp ' + $('#table-container #table-laporan').data('total'));
        });
    });
});
