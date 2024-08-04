$(document).ready(function() {
    if ($('#table-parfum tbody').children().length == 0) {
        $('#table-parfum tbody').append('<tr><td colspan=5 class="text-center">Data masih kosong</td></tr>');
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
    $('#data-parfum .btn-tambah').on('click', function() {
        btnIndex = -1;
        $('#modal-form').attr('action', "/data/parfum");
        $('.modal-title').text('Tambah parfum');

        $('#input-nama-parfum').val('');
        $('#input-deskripsi').val('');
        $('#input-jenis').val('');
        $('#formCheck-aktif').attr('checked', true);
        $('#formCheck-tidakAktif').attr('checked', false);
        $('#modal-form .modal-body .row .col-12:nth-child(3)').removeClass('col-sm-6');
        $('#modal-form .modal-body .row .col-12:nth-child(4)').hide();

        $('#modal-update').modal('show');
    });

    // untuk mengisi tampilan modal & menampilkan modal
    $('#data-parfum #action-update').on('click', function() {
        $('#modal-form').attr('action', "/data/parfum/" + btnId);
        $('.modal-title').text('Rubah parfum');

        $('#input-nama-parfum').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(1)').html());
        $('#input-deskripsi').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(2)').html());
        $('#input-jenis').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(3)').html());
        if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(4)').html() == "Aktif") {
            $('#formCheck-aktif').attr('checked', true);
        } else if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(4)').html() == "Tidak aktif"){
            $('#formCheck-tidakAktif').attr('checked', true);
        } else {
            console.log($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(4)').html());
        }
        $('#modal-form .modal-body .row .col-12:nth-child(3)').addClass('col-sm-6');
        $('#modal-form .modal-body .row .col-12:nth-child(4)').show();

        $('#modal-update').modal('show');
    });

    // untuk menghapus data parfum
    $('#action-delete').on('click', function() {
        if (confirm('Yakin menghapus data ?')) {
            $.ajax({
                url: "/data/parfum/delete/" + btnId,
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
