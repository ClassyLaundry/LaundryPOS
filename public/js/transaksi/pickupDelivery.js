$(document).ready(function() {
    // untuk menampilkan modal pickup
    $('#create-pickup').on('click', function() {
        $('#modal-create-pickup').modal('show');
    });

    $('#data-pelanggan').on('click', 'option', function() {
        let selectedValue = $(this).val();
        let dataListOptions = $('#data-pelanggan').find('option');

        dataListOptions.each(function() {
            if ($(this).val() === selectedValue) {
                $('#input-pickup-alamat').val($(this).data('alamat'));
                $('#input-pickup-pelanggan-id').val($(this).data('id'));
            }
        });
    });

    // untuk menampilkan modal delivery
    $('#create-delivery').on('click', function() {
        $('#modal-create-delivery').modal('show');
    });

    $('#table-pickup').load(window.location.origin + '/component/pickup');
    $('#section-pickup').on('click', '.page-link', function(e) {
        e.preventDefault();
        $('#table-pickup').load($(this).attr('href'));
    });

    $('#table-delivery').load(window.location.origin + '/component/delivery');
    $('#section-delivery').on('click', '.page-link', function(e) {
        e.preventDefault();
        $('#table-delivery').load($(this).attr('href'));
    });

    $('#table-di-outlet').load(window.location.origin + '/component/ambil_di_outlet');
    $('#section-ambil-outlet').on('click', '.page-link', function(e) {
        e.preventDefault();
        $('#table-di-outlet').load($(this).attr('href'));
    });

    $('.btn-toggle').on('click', function() {
        let icon = $(this).children();
        if (icon.hasClass('fa-down-left-and-up-right-to-center')) {
            icon.removeClass('fa-down-left-and-up-right-to-center');
            icon.addClass('fa-up-right-and-down-left-from-center');
            icon.closest('div').next().hide();
        } else {
            icon.removeClass('fa-up-right-and-down-left-from-center');
            icon.addClass('fa-down-left-and-up-right-to-center');
            icon.closest('div').next().show();
        }
    });

    var btnIndex = -1, btnId = 0, currentlySelectedType = '', transId = 0, pelangganId = 0;
    $('.btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).closest('.border.rounded').data('transaksi');
        pelangganId = $(this).closest('.border.rounded').find('.pelanggan-id').val();
        if ($(this).closest('.card-pickup').length == 1) {
            currentlySelectedType = "pickup";
            transId = 0;
            $('#action-detail').hide();
            $('#action-print-memo').hide();
        } else if ($(this).closest('.card-delivery').length == 1) {
            currentlySelectedType = "delivery";
            transId = $(this).closest('.card-delivery').data('transaksi');
            $('#action-detail').show();
            $('#action-print-memo').show();
        }
    });

    $('#action-print-memo').on('click', function() {
        window.location = window.location.origin + "/printMemoProduksi/" + btnId;
    });

    $('#action-pesan').on('click', function() {
        $('.btn-show-action').eq(btnIndex - 1).closest('.rounded').next().toggle();
    });

    $('#action-change-status').on('click', function() {
        if (confirm('Nyatakan ' + currentlySelectedType + ' selesai ?') == true) {
            $.ajax({
                url: "/transaksi/pickup-delivery/" + btnId + "/is-done",
            }).done(function(data) {
                window.location = window.location.origin + window.location.pathname;
            });
        }
    });

    $(".hub-karyawan").sortable();

    $('#action-detail').on('click', function() {
        $('#kode-transaksi').text($('h6').eq(btnIndex).text());

        // not done
        $('#table-short-trans').load(window.location.origin + '/component/shortTrans/' + btnId + '/delivery', function() {
            $.ajax({
                url: "/transaksi/detail/" + transId,
            }).done(function(data) {
                if (data.lunas) {
                    $('#status-transaksi').text('Lunas');
                } else {
                    $('#status-transaksi').text('Belum lunas');
                }
                console.log(data);
            });
        });

        $('#kode-trans').text($('.btn-show-action').eq(btnIndex - 1).prev().find('h4').text());
        $('#modal-transaksi').modal('show');
    });
});
