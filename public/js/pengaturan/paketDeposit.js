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
        $('#form-paket-deposit').attr('action', "/setting/paket-deposit/" + btnId);
        $('.modal-title').text('Rubah paket');

        $('#input-nama-paket').val($('#table-paket-deposit tbody tr:nth-child(' + btnIndex + ') td:nth-child(1)').html());
        $('#input-deskripsi').val($('#table-paket-deposit tbody tr:nth-child(' + btnIndex + ') td:nth-child(2)').html());
        $('#input-nominal').val($('#table-paket-deposit tbody tr:nth-child(' + btnIndex + ') td:nth-child(4)').html());
        $('#input-harga-paket').val($('#table-paket-deposit tbody tr:nth-child(' + btnIndex + ') td:nth-child(6)').html());
        if ($('#table-paket-deposit tbody tr:nth-child(' + btnIndex + ') td:nth-child(7)').html() == 'Aktif') {
            $('#radio-status-tidakAktif').attr('checked', false);
            $('#radio-status-aktif').attr('checked', true);
        } else if ($('#table-paket-deposit tbody tr:nth-child(' + btnIndex + ') td:nth-child(7)').html() == 'Tidak aktif') {
            $('#radio-status-aktif').attr('checked', false);
            $('#radio-status-tidakAktif').attr('checked', true);
        }
        $('#col-status').show();

        $('#modal-paket-deposit').modal('show');
    });

    // untuk menambah data paket
    $('.btn-add').on('click', function() {
        $('#form-paket-deposit').attr('action', "/setting/paket-deposit");
        $('.modal-title').text('Rubah paket');

        $('#input-nama-paket').val('');
        $('#input-deskripsi').val('');
        $('#input-harga-paket').val('');
        $('#input-nominal').val('');
        $('#col-status').hide();
        $('#radio-status-aktif').attr('checked', false);
        $('#radio-status-tidakAktif').attr('checked', false);

        $('#modal-paket-deposit').modal('show');
    });

    // untuk delete data paket
    $('#action-delete').on('click', function() {
        if (confirm('Yakin menghapus paket ?')) {
            $.ajax({
                url: "/setting/paket-deposit/delete/" + btnId,
            }).done(function() {
                window.location = window.location.origin + window.location.pathname;
            });
        }
    });

    // untuk menghilangkan thousand separator dari input
    $('#form-paket-deposit').on('submit', function(e) {
        e.preventDefault();

        $('#input-nominal').val(removeDot($('#input-nominal').val()));
        $('#input-harga-paket').val(removeDot($('#input-harga-paket').val()));

        $(this).submit();
    });

    function removeDot(val) {
        if (val != '') {
            while(val.indexOf('.') != -1) {
                val = val.replace('.', '');
            }
            let number = parseInt(val);
            return number;
        }
    }
});
