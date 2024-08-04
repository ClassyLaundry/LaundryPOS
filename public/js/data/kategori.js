$(document).ready(function() {
    if ($('#table-kategori tbody').children().length == 0) {
        $('#table-kategori tbody').append('<tr><td colspan=4 class="text-center">Data masih kosong</td></tr>');
    }

    if($('#list-action').children().length == 0) {
        $('#list-action').detach();
    }
    var btnIndex = -1, btnId = 0;
    $('.btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    // untuk mereset tampilan modal & menampilkan modal
    $('#data-kategori .btn-tambah').on('click', function() {
        btnIndex = -1;
        $('#modal-form').attr('action', "/data/kategori");
        $('.modal-title').text('Tambah kategori');

        $('#input-nama-kategori').val('');
        $('#input-deskripsi').val('');
        $('#formCheck-aktif').attr('checked', true);
        $('#formCheck-tidakAktif').attr('checked', false);
        $('#modal-form .modal-body .row .col-12:nth-child(3)').hide();

        $('#modal-update').modal('show');
    });

    // untuk mengisi tampilan modal & menampilkan modal
    $('#data-kategori #action-update').on('click', function() {
        $('#modal-form').attr('action', "/data/kategori/" + btnId);
        $('.modal-title').text('Rubah kategori');

        $('#input-nama-kategori').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(1)').html());
        $('#input-deskripsi').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(2)').html());
        if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(3)').html() == "Aktif") {
            $('#formCheck-aktif').attr('checked', true);
        } else if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(3)').html() == "Tidak aktif"){
            $('#formCheck-tidakAktif').attr('checked', true);
        } else {
            console.log($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(3)').html());
        }
        $('#modal-form .modal-body .row .col-12:nth-child(3)').show();

        $('#modal-update').modal('show');
    });

    // untuk menghapus data kategori
    $('#action-delete').on('click', function() {
        if (confirm('Yakin menghapus data ?')) {
            $.ajax({
                url: "/data/kategori/delete/" + btnId,
            }).done(function() {
                window.location = window.location.origin + window.location.pathname + '/';
            });
        }
    });

    $('#modal-form').on('submit', function(e) {
        e.preventDefault();
        $('#btn-submit').addClass('disabled');
        e.currentTarget.submit();
    });
});
