$(document).ready(function() {
    $('#btn-apply-filter').on('click', function() {
        // $('#table-container').load(window.location.origin + '/component/omset?start=' + $('#input-tanggal-awal').val() + '&end=' + $('#input-tanggal-akhir').val(), function() {
        //     $('#total-omset').text('Rp ' + $('#table-container #table-laporan').data('total'));
        // });
        window.location = window.location.origin + '/laporan/omset?start=' + $('#input-tanggal-awal').val() + '&end=' + $('#input-tanggal-akhir').val();
    });
});
