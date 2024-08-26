$(document).ready(function() {
    $('#btn-apply-filter').on('click', function() {
        window.location = window.location.origin + '/laporan/omset?date=' + $('#input-tanggal').val();
    });
});
