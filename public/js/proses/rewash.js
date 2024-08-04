$(document).ready(function() {
    var btnIndex = -1, btnId = 0;
    $('.btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    let params = (new URL(document.location)).searchParams;
    let trans_id = params.get("trans_id");
    let trans_item = params.get("trans_item");
    if (trans_id !== null && trans_item !== null) {
        $('#kode-trans').val(trans_id);
        $.ajax({
            url: "/transaksi/detail/" + $('#kode-trans').val(),
        }).done(function(data) {
            let item_transaksis = data.item_transaksi;
            $('#item-trans').empty();
            item_transaksis.forEach(item_transaksi => {
                $('#item-trans').append("<option value='" + item_transaksi.id + "'>" + item_transaksi.nama + "</option>");
            });
            $('#item-trans').val(trans_item);
        });
        $('#modal-create-rewash').modal('show');
    }

    if($('#list-action').children().length == 0) {
        $('.cell-action').each(function() {
            $(this).empty();
        });
    }

    $('.btn-tambah').on('click', function() {
        $('#modal-create-rewash').modal('show');
    });

    $('#kode-trans').on('change', function() {
        $.ajax({
            url: "/transaksi/detail/" + $('#kode-trans').val(),
        }).done(function(data) {
            let item_transaksis = data.item_transaksi;
            $('#item-trans').empty();
            item_transaksis.forEach(item_transaksi => {
                $('#item-trans').append("<option value='" + item_transaksi.id + "'>" + item_transaksi.nama +"</option>");
            });
        });
    });

    $('#action-finish').on('click', function() {
        if (confirm('Nyatakan rewash selesai ?')) {
            window.location = "/proses/rewash/update-status/" + btnId;
        }
    });

    $('#action-receipt').on('click', function() {
        window.location = "/printTandaTerimaRewash/" + btnId;
    });
});
