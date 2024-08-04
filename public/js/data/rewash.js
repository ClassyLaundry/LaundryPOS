$(document).ready(function() {
    if ($('#table-rewash tbody').children().length == 0) {
        $('#table-rewash tbody').append('<tr><td colspan=3 class="text-center">Data masih kosong</td></tr>');
    }

    if($('#list-action').children().length == 0) {
        $('#list-action').detach();
    }
    var btnIndex = -1, btnId = 0;
    $('#data-rewash .btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    $('#data-rewash .btn-tambah').on('click', function() {
        btnIndex = -1;
        $('#modal-form').attr('action', "/data/rewash");
        $('.modal-title').text('Tambah jenis rewash');

        $('#input-keterangan').val('');

        $('#modal-rewash').modal('show');
    });

    $('#data-rewash #action-update').on('click', function() {
        $('#modal-form').attr('action', "/data/rewash/" + btnId);
        $('.modal-title').text('Rubah jenis rewash');

        $('#input-keterangan').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(1)').html());

        $('#modal-rewash').modal('show');
    });

    $('#action-delete').on('click', function() {
        if (confirm('Yakin menghapus data ?')) {
            $.ajax({
                url: "/data/rewash/delete/" + btnId,
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
