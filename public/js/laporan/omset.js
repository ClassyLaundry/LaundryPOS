$(document).ready(function() {
    $('#btn-show-filter').on('click', function() {
        $('#container-filter').toggle();
    });

    $('#btn-apply-filter').on('click', function() {
        window.location = window.location.origin + '/laporan/omset?start=' + $('#input-tanggal-awal').val() + '&end=' + $('#input-tanggal-akhir').val();
    });
});
