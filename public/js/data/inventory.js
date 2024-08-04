$(document).ready(function() {
    if ($('#table-inventory tbody').children().length == 0) {
        $('#table-inventory tbody').append('<tr><td colspan=5 class="text-center">Data masih kosong</td></tr>');
    }

    if($('#list-action').children().length == 0) {
        $('#list-action').detach();
    }
    var btnIndex = -1, btnId = 0;
    $('#data-inventory .btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    $('#data-inventory .btn-tambah').on('click', function() {
        btnIndex = -1;
        $('#modal-form').attr('action', "/data/inventory/insert");
        $('.modal-title').text('Tambah item inventory');

        $('#input-nama-inventory').val('');
        $('#input-deskripsi').val('');
        $('#input-stok').val('');

        $('#modal-inventory').modal('show');
    });

    $('#data-inventory #action-update').on('click', function() {
        $('#modal-form').attr('action', "/data/inventory/update/" + btnId);
        $('.modal-title').text('Rubah item inventory');

        $('#input-nama-inventory').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(1)').html());
        $('#input-deskripsi').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(2)').html());
        $('#input-kategori').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(3)').html());
        $('#input-stok').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(4)').html().replace('.', ''));

        $('#modal-inventory').modal('show');
    });

    $('#action-delete').on('click', function() {
        if (confirm('Yakin menghapus data ?')) {
            $.ajax({
                url: "/data/inventory/delete/" + btnId,
            }).done(function() {
                window.location = window.location.origin + window.location.pathname;
            });
        }
    });

    $('#modal-form').on('submit', function(e) {
        e.preventDefault();
        $('#btn-submit').addClass('disabled');
        e.currentTarget.submit();
    });
});
