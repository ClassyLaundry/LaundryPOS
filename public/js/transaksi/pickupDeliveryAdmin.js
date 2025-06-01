$(document).ready(function() {
    $('#tab-pickup_delivery').on('click', '.nav-link', function() {
        let formData = new FormData();
        formData.append('tab', $(this).text());

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "/transaksi/pickup-delivery/changeTab",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).fail(function(message) {
            console.log(message);
        });
    });

    var btnIndex = -1, btnId = 0, selectedTable = "";
    $('#table-pickup, #table-delivery').on('click', '.btn-show-action', function(e) {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
        selectedTable = $(this).closest('.table-container').data('table');

        // Hide semua list action dulu
        $('#list-action-pickup, #list-action-delivery').hide();

        /**
         * note: kenapa action-update-* di hide?
         * karena original codenya sudah di hide
         * by: Bil Abror
         */
        if (selectedTable == 'pickup') {
            $('#action-update-pickup').hide();
            $('#list-action-pickup').show();
        } else {
            $('#action-update-delivery').hide();
            $('#list-action-delivery').show();
        }
    });

    // Hide aksi list ketika klik di luar button show action
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.btn-show-action, #list-action-pickup, #list-action-delivery').length) {
            $('#list-action-pickup, #list-action-delivery').hide();
        }
    });

    $('#action-delete-pickup, #action-delete-delivery').on('click', function() {
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


    var searchPelanggan;
    function search() {
        $('#table-pelanggan').load(window.location.origin + '/component/pelanggan?key=' + encodeURIComponent($('#input-nama-pelanggan').val()) + '&filter=nama&paginate=5', function() {
            $('#table-pelanggan th:last').hide();
            $('#table-pelanggan .cell-action').hide();
        });
    }

    search();

    $('#table-pelanggan').on('click', '.page-link', function(e) {
        e.preventDefault();
        $('#table-pelanggan').load($(this).attr('href'));
    });

    $('#input-nama-pelanggan').on('input', function() {
        clearTimeout(searchPelanggan);
        searchPelanggan = setTimeout(searchListPelanggan, 2000);
    });

    function searchListPelanggan() {
        search();
    }

    var pelangganId = 0;
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

    // Pick Up
    const currentDate = new Date();
    var year = currentDate.getFullYear();
    var month = String(currentDate.getMonth() + 1).padStart(2, '0');
    $('.input-month').val(`${year}-${month}`);

    var paginatePickUp = 5, pagePickUp = 1, keyPickUp = '', datePickUp = $('#input-pickup-month').val(), searchByPickUp = 'pelanggan', searchPickUpData;

    function searchPickUp() {
        $('#table-pickup').load(window.location.origin + '/component/pickup?search=' + searchByPickUp + '&key=' + encodeURIComponent(keyPickUp) + '&date=' + datePickUp + '&paginate=' + paginatePickUp + '&page=' + pagePickUp);
    }

    searchPickUp();

    $('#input-pickup-month').on('change', function() {
        datePickUp = $(this).val();
        searchPickUp();
    });

    $('#table-pickup').on('click', '.page-link', function(e) {
        e.preventDefault();
        pagePickUp = $(this).attr('href').split('page=')[1];
        searchPickUp();
    });

    $("#section-pickup .filter-search").on('click', function() {
        searchByPickUp = $(this).data('search');
        $("#section-pickup .filter-search").each(function(index, element) {
            $(element).removeClass('active');
        });
        $(this).addClass('active');
        searchPickUp();
    });

    $('#input-search-pickup').on('input', function() {
        keyPickUp = $(this).val();
        clearTimeout(searchPickUpData);
        searchPickUpData = setTimeout(searchPickUp, 1000);
    });

    $("#section-pickup .filter-paginate").on('click', function() {
        paginatePickUp = parseInt($(this).data('paginate'));
        $("#section-pickup .filter-paginate").each(function(index, element) {
            $(element).removeClass('active');
        });
        $(this).addClass('active');
        searchPickUp();
    });

    $('#create-pickup').on('click', function() {
        $('#modal-create-pickup').modal('show');
    });

    $('#input-pickup-pelanggan').on('click', function() {
        $('#modal-data-pelanggan').modal('show');
    });

    // Delivery
    var paginateDelivery = 5, pageDelivery = 1, keyDelivery = '', dateDelivery = $('#input-delivery-month').val(), searchByDelivery = 'pelanggan', searchDeliveryData;

    function searchDelivery() {
        $('#table-delivery').load(window.location.origin + '/component/delivery?search=' + searchByDelivery + '&key=' + encodeURIComponent(keyDelivery) + '&date=' + dateDelivery + '&paginate=' + paginateDelivery + '&page=' + pageDelivery);
    }

    searchDelivery();

    $('#input-delivery-month').on('change', function() {
        dateDelivery = $(this).val();
        searchDelivery();
    });

    $('#table-delivery').on('click', '.page-link', function(e) {
        e.preventDefault();
        pageDelivery = $(this).attr('href').split('page=')[1];
        searchDelivery();
    });

    $("#section-delivery .filter-search").on('click', function() {
        searchByDelivery = $(this).data('search');
        $("#section-delivery .filter-search").each(function(index, element) {
            $(element).removeClass('active');
        });
        $(this).addClass('active');
        searchDelivery();
    });

    $('#input-search-delivery').on('input', function() {
        keyDelivery = $(this).val();
        clearTimeout(searchDeliveryData);
        searchDeliveryData = setTimeout(searchDelivery, 1000);
    });

    $("#section-delivery .filter-paginate").on('click', function() {
        paginateDelivery = parseInt($(this).data('paginate'));
        $("#section-delivery .filter-paginate").each(function(index, element) {
            $(element).removeClass('active');
        });
        $(this).addClass('active');
        searchDelivery();
    });

    $('#create-delivery').on('click', function() {
        $('#modal-create-delivery').modal('show');
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
        $('#container-list-trans').load(window.location.origin + '/component/transDelivery?key=' + encodeURIComponent(key));
    }

    $('#container-list-trans').on('click', '#table-list-trans tbody tr', function() {
        let transId = $(this).attr('id');

        $.ajax({
            url: "/transaksi/detail/" + transId,
        }).done(function(response) {
            console.log(response);
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
    var paginateOutlet = 5, pageOutlet = 1, keyOutlet = '', dateOutlet = $('#input-outlet-month').val(), searchByOutlet = 'pelanggan', searchOutletData;

    function searchDiOutlet() {
        $('#table-outlet').load(window.location.origin + '/component/ambil_di_outlet?search=' + searchByOutlet + '&key=' + encodeURIComponent(keyOutlet) + '&date=' + dateOutlet + '&paginate=' + paginateOutlet + '&page=' + pageOutlet);
    }

    searchDiOutlet();

    $('#input-outlet-month').on('change', function() {
        dateOutlet = $(this).val();
        searchDiOutlet();
    });

    $('#table-outlet').on('click', '.page-link', function(e) {
        e.preventDefault();
        pageOutlet = $(this).attr('href').split('page=')[1];
        searchDiOutlet();
    });

    $("#section-outlet .filter-search").on('click', function() {
        searchByOutlet = $(this).data('search');
        $("#section-outlet .filter-search").each(function(index, element) {
            $(element).removeClass('active');
        });
        $(this).addClass('active');
        searchDiOutlet();
    });

    $('#input-search-outlet').on('input', function() {
        keyOutlet = $(this).val();
        clearTimeout(searchOutletData);
        searchOutletData = setTimeout(searchDiOutlet, 1000);
    });

    $("#section-outlet .filter-paginate").on('click', function() {
        paginateOutlet = parseInt($(this).data('paginate'));
        $("#section-outlet .filter-paginate").each(function(index, element) {
            $(element).removeClass('active');
        });
        $(this).addClass('active');
        searchDiOutlet();
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
