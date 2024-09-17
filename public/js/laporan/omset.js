$(document).ready(function() {
    $('#btn-apply-filter').on('click', function() {
        window.location = window.location.origin + '/laporan/omset?start=' + $('#input-tanggal-awal').val() + '&end=' + $('#input-tanggal-akhir').val();
    });
});
