$(document).ready(function() {
    if($('#list-action').children().length == 0) {
        $('#list-action').detach();
    }
    var btnIndex = -1, btnId = 0;
    $('.btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    // untuk update data paket
    $('#action-update').on('click', function() {
        $('#form-paket-cuci').attr('action', "/setting/paket-cuci/" + btnId);
        $('.modal-title').text('Rubah paket');

        $('#input-nama-paket').val($('#table-paket-cuci tbody tr:nth-child(' + btnIndex + ') td:nth-child(1)').html());
        $('#input-deskripsi').val($('#table-paket-cuci tbody tr:nth-child(' + btnIndex + ') td:nth-child(2)').html());
        $('#input-bobot-paket').val($('#table-paket-cuci tbody tr:nth-child(' + btnIndex + ') td:nth-child(3)').html());
        $('#input-harga_per_bobot').val($('#table-paket-cuci tbody tr:nth-child(' + btnIndex + ') td:nth-child(5)').html());
        $('#input-harga-paket').val($('#table-paket-cuci tbody tr:nth-child(' + btnIndex + ') td:nth-child(7)').html());
        if ($('#table-paket-cuci tbody tr:nth-child(' + btnIndex + ') td:nth-child(8)').html() == 'Aktif') {
            $('#radio-status-tidakAktif').attr('checked', false);
            $('#radio-status-aktif').attr('checked', true);
        } else if ($('#table-paket-cuci tbody tr:nth-child(' + btnIndex + ') td:nth-child(8)').html() == 'Tidak aktif') {
            $('#radio-status-aktif').attr('checked', false);
            $('#radio-status-tidakAktif').attr('checked', true);
        }
        $('#col-status').show();

        $('#modal-paket-cuci').modal('show');
    });

    // untuk menambah data paket
    $('.btn-add').on('click', function() {
        $('#form-paket-cuci').attr('action', "/setting/paket-cuci");
        $('.modal-title').text('Tambah paket');

        $('#input-nama-paket').val('');
        $('#input-deskripsi').val('');
        $('#input-bobot-paket').val('');
        $('#input-harga_per_bobot').val('');
        $('#input-harga-paket').val('');
        $('#col-status').hide();
        $('#radio-status-aktif').attr('checked', false);
        $('#radio-status-tidakAktif').attr('checked', false);

        $('#modal-paket-cuci').modal('show');
    });

    // untuk delete data paket
    $('#action-delete').on('click', function() {
        if (confirm('Yakin menghapus paket ?')) {
            $.ajax({
                url: "/setting/paket-cuci/delete/" + btnId,
            }).done(function() {
                window.location = window.location.origin + window.location.pathname;
            });
        }
    });

    // untuk menghilangkan thousand separator dari input
    $('#form-paket-cuci').on('submit', function(e) {
        e.preventDefault();
        $('#input-harga_per_bobot').val($('#input-harga_per_bobot').val().replace('.', ''));
        $('#input-harga-paket').val($('#input-harga-paket').val().replace('.', ''));
        this.submit();
    });
});



