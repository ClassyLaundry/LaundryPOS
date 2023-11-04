$(document).ready(function() {
    var btnIndex = -1, btnId = 0;
    $('.btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    $('.btn-tambah').on('click', function() {
        $('#modal-update').modal('show');
    });

    $('#kode-trans').on('change', function() {
        $.ajax({
            url: "/transaksi/detail/" + $('#kode-trans').val(),
        }).done(function(data) {
            let item_transaksis = data.item_transaksi;
            item_transaksis.forEach(item_transaksi => {
                $('#item-trans').append("<option value='" + item_transaksi.id + "'>" + item_transaksi.nama +"</option>");
            });
        });
    });

    $('#action-update').on('click', function() {
        // get data

        $('#modal-update').modal('show');
    });



    $('#action-finish').on('click', function() {
        if (confirm('Nyatakan rewash selesai ?')) {
            window.location = "/proses/rewash/update-status/" + btnId;
        }
    });
});
