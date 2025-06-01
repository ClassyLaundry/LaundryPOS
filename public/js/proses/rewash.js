$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();

    var btnIndex = -1, btnId = 0;
    $('.btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    let params = (new URL(document.location)).searchParams;
    let trans_kode = params.get("trans_kode");
    let trans_item = params.get("trans_item");
    if (trans_kode !== null) {

        $.ajax({
            url: "/transaksi/kode/" + trans_kode,
        }).done(function(response) {
            console.log(response);

            $('#input-rewash-kode').val(response.kode);

            $('#item-trans').empty();
            response.item_transaksi.forEach(item => {
                $('#item-trans').append("<option value='" + item.id + "' data-max='" + item.qty + "'>" + item.nama +"</option>");
            });
            if (trans_item !== null) {
                $('#item-trans').val(trans_item);
            }

            let qtyMax = $('#item-trans option:selected').data('max');
            $('#qty-rewash').attr('max', qtyMax);
            $('#qty-rewash').attr('title', "Max " + qtyMax);
            $('#qty-rewash').val(1);
            $('#modal-opsi-trans').modal('hide');

            $('#modal-create-rewash').modal('show');
        });
    }

    if($('#list-action').children().length == 0) {
        $('.cell-action').each(function() {
            $(this).empty();
        });
    }

    $('.btn-tambah').on('click', function() {
        $('#modal-create-rewash').modal('show');
    });

    $('#input-rewash-kode').on('click', function() {
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
        $('#container-list-trans').load(window.location.origin + '/component/transRewash?key=' + encodeURIComponent(key));
    }

    $('#container-list-trans').on('click', '#table-list-trans tbody tr', function() {
        let transId = $(this).attr('id');

        $.ajax({
            url: "/transaksi/detail/" + transId,
        }).done(function(response) {
            console.log(response);
            $('#input-rewash-kode').val(response.kode);

            $('#item-trans').empty();
            response.item_transaksi.forEach(item => {
                $('#item-trans').append("<option value='" + item.id + "' data-max='" + item.qty + "'>" + item.nama +"</option>");
            });

            let qtyMax = $('#item-trans option:selected').data('max');
            $('#qty-rewash').attr('max', qtyMax);
            $('#qty-rewash').attr('title', "Max " + qtyMax);
            $('#qty-rewash').val(1);
            $('#modal-opsi-trans').modal('hide');

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        });
    });

    $('#item-trans').on('change', function() {
        $('#qty-rewash').attr('max', $('#item-trans option:selected').data('max'));
        $('#qty-rewash').val(1);
    });

    // $('#kode-trans').on('change', function() {
    //     $.ajax({
    //         url: "/transaksi/detail/" + $('#kode-trans').val(),
    //     }).done(function(data) {
    //         let item_transaksis = data.item_transaksi;
    //         $('#item-trans').empty();
    //         item_transaksis.forEach(item_transaksi => {
    //             $('#item-trans').append("<option value='" + item_transaksi.id + "'>" + item_transaksi.nama +"</option>");
    //         });
    //     });
    // });

    $('#action-finish').on('click', function() {
        if (confirm('Nyatakan rewash selesai ?')) {
            window.location = "/proses/rewash/update-status/" + btnId;
        }
    });

    $('#action-receipt').on('click', function() {
        window.open("/printTandaTerimaRewash/" + btnId, '_blank');
    });

    // Add form submission handler
    $('form[action="/proses/rewash/insert"]').on('submit', function(e) {
        e.preventDefault();
        if (confirm('Dengan merewash maka transaksi akan kembali ke kondisi awal')) {
            this.submit();
        }
    });
});
