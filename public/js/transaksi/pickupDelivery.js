$(document).ready(function() {
    // untuk menampilkan modal pickup
    $('#create-pickup').on('click', function() {
        $('#modal-create-pickup').modal('show');
    });

    $('#input-pickup-pelanggan').on('click', function() {
        $('#modal-data-pelanggan').modal('show');
    });

    var pelangganId = 0;
    $('#table-pelanggan').load(window.location.origin + '/component/pelanggan?paginate=5', function() {
        $('#table-pelanggan th:last').hide();
        $('#table-pelanggan .cell-action').hide();
    });
    $('#table-pelanggan').on('click', '.page-link', function(e) {
        e.preventDefault();
        $('#table-pelanggan').load($(this).attr('href'));
    });

    function search() {
        $('#table-pelanggan').load(window.location.origin + '/component/pelanggan?key=' + encodeURIComponent($('#input-nama-pelanggan').val()) + '&filter=nama&paginate=5', function() {
            $('#table-pelanggan th:last').hide();
            $('#table-pelanggan .cell-action').hide();
        });
    }

    $('#search-pelanggan').on('click', function() {
        search();
    });

    $('#table-pelanggan').on('click', 'tr', function() {
        pelangganId = $(this).attr('id').substr(10);

        $.ajax({
            url: "/data/pelanggan/" + pelangganId,
        }).done(function(data) {
            $('#input-pickup-pelanggan').val(data[0].nama);
            $('#input-pickup-pelanggan-id').val(pelangganId);
            $('#input-pickup-alamat').val(data[0].alamat);

            $('#modal-data-pelanggan').modal('hide');

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
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

    var btnIndex = -1, btnId = 0, currentlySelectedType = '', pelangganId = 0, orderId = 0;;
    $('.btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).closest('.border.rounded').data('transaksi');
        pelangganId = $(this).closest('.border.rounded').find('.pelanggan-id').val();
        if ($(this).closest('.card-pickup').length == 1) {
            currentlySelectedType = "pickup";
            orderId = $(this).closest('.border.rounded').attr('id').substr(7);
            $('#action-detail').hide();
            $('#action-print-memo').hide();
        } else if ($(this).closest('.card-delivery').length == 1) {
            currentlySelectedType = "delivery";
            orderId = $(this).closest('.border.rounded').attr('id').substr(9);
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
                url: "/transaksi/pickup-delivery/" + orderId + "/is-done",
            }).done(function(data) {
                window.location = window.location.origin + window.location.pathname;
            });
        }
    });

    $(".hub-karyawan").sortable();

    $('#action-detail').on('click', function() {
        $('#kode-transaksi').text($('h6').eq(btnIndex).text());

        $('#table-short-trans').load(window.location.origin + '/component/shortTrans/' + btnId + '/delivery', function() {
            $('#table-short-trans').find('.cell-action').detach();
            $.ajax({
                url: "/transaksi/detail/" + btnId,
            }).done(function(data) {
                if (data.lunas) {
                    $('#status-transaksi').text('Lunas');
                } else {
                    $('#status-transaksi').text('Belum lunas');
                }
                // console.log(data);
            });
        });

        $('#kode-trans').text($('.btn-show-action').eq(btnIndex - 1).prev().find('h4').text());
        $('#modal-transaksi').modal('show');
    });
});
