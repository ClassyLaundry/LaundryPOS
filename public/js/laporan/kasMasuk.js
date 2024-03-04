$(document).ready(function() {
    $('#btn-apply-filter').on('click', function() {
        let jenis = '';
        if ($('#btn-cash').is(':checked')) {
            jenis = jenis + 'tunai;';
        }
        if ($('#btn-qris').is(':checked')) {
            jenis = jenis + 'qris;';
        }
        if ($('#btn-debit').is(':checked')) {
            jenis = jenis + 'debit;';
        }
        if ($('#btn-transfer').is(':checked')) {
            jenis = jenis + 'transfer;';
        }
        if (jenis == '') {
            alert('Pilih tipe bayar');
        } else {
            $('#table-container').load(window.location.origin + '/component/kasMasuk?start=' + $('#input-tanggal-awal').val() + '&end=' + $('#input-tanggal-akhir').val() + '&jenis=' + jenis, function() {
                $('#total-kas_masuk').text('Rp ' + $('#table-container #table-laporan').data('total'));
            });
        }
    });
});
