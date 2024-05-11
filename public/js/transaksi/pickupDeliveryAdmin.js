$(document).ready(function() {
    $('#input-week').change(function() {
        $(this).hide();
        let selectedWeek = $(this).val();
        let year = selectedWeek.substring(0, 4);
        let weekNumber = selectedWeek.substring(6);

        let startDate = new Date(year, 0, 1 + (weekNumber - 1) * 7 + 1);
        let endDate = new Date(year, 0, 1 + (weekNumber - 1) * 7 + 6 + 1);

        let startDateString = formatDate(startDate);
        let endDateString = formatDate(endDate);

        $('#selected-date-range').text(startDateString + ' - ' + endDateString);
        $('#selected-date-range').show();
        $('#btn-reset').show();
    });

    $('#btn-reset').on('click', function(e) {
        $(this).hide();
        $('#selected-date-range').hide();
        $('#input-week').show();
    });

    function formatDate(date) {
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        return (day < 10 ? '0' + day : day) + '/' + (month < 10 ? '0' + month : month) + '/' + year;
    }

    var btnIndex = -1, btnId = 0, selectedTable = "";
    $('#table-pickup, #table-delivery').on('click', '.btn-show-action', function(e) {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
        selectedTable = $(this).closest('.table-container').data('table');
        if (selectedTable == 'pickup') {
            $('#action-update').hide();
        } else {
            $('#action-update').show();
        }
    });

    $('#action-update').on('click', function() {
        // $ajax disini
        $('#modal-create-delivery').modal('show');
    });

    $('#action-delete').on('click', function() {
        if (confirm('Cancel pickup delivery ?')) {
            $.ajax({
                url: "/transaksi/pickup-delivery/delete/" + btnId,
            }).done(function(data) {
                window.location.reload();

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }
    });

    // Pick Up
    $('#create-pickup').on('click', function() {
        $('#modal-create-pickup').modal('show');
    });

    $('#input-pickup-pelanggan').on('click', function() {
        $('#modal-data-pelanggan').modal('show');
    });

    $('#table-pickup').on('click', 'page-link', function(e) {
        e.preventDefault();
        $('#table-pickup').load($(this).attr('href'));
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

    var searchPelanggan;
    $('#input-nama-pelanggan').on('input', function() {
        clearTimeout(searchPelanggan);
        searchPelanggan = setTimeout(searchListPelanggan, 2000);
    });

    function searchListPelanggan() {
        search();
    }

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

    // Delivery
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

    $('#input-delivery-kode').on('click', function() {
        searchListTrans();
        $('#modal-opsi-trans').modal('show');
    });

    var searchTrans, key = '';
    $('#input-key-trans').on('input', function() {
        clearTimeout(searchTrans);
        searchTrans = setTimeout(searchListTrans, 2000);
    });

    function searchListTrans() {
        key = $('#input-key-trans').val();
        $('#container-list-trans').load(window.location.origin + '/component/transDelivery?key=' + encodeURIComponent(key), function() {
            setThousandSeparator();
        });
    }

    $('#container-list-trans').on('click', '#table-list-trans tbody tr', function() {
        let transId = $(this).attr('id');

        $.ajax({
            url: "/transaksi/detail/" + transId,
        }).done(function(response) {
            $('#input-delivery-kode').val(response.kode);
            $('#input-delivery-transaksi-id').val(response.id);
            $('#input-delivery-nama').val(response.pelanggan.nama);
            $('#input-delivery-alamat').val(response.pelanggan.alamat);

            $('#modal-opsi-trans').modal('hide');
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        });
    });

    // Ambil di outlet
    $('#table-di-outlet').load(window.location.origin + '/component/ambil_di_outlet');
    $('#section-ambil-outlet').on('click', '.page-link', function(e) {
        e.preventDefault();
        $('#table-di-outlet').load($(this).attr('href'));
    });

    // Task hub
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
});
