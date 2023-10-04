$(document).ready(function() {
    if($('#list-action').children().length == 0) {
        $('#list-action').detach();
    }
    var btnIndex = -1, btnId = 0;
    $('.btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    // untuk update data outlet
    $('#action-update').on('click', function() {
        $('#form-outlet').attr('action', "/setting/outlet/" + btnId);
        $('#modal-outlet .modal-title').text('Rubah outlet');

        $('#input-kode').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(1)').text());
        $('#input-nama').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(2)').text());
        $('#input-alamat').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(3)').text());
        $('#input-telp1').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(4)').text());
        $('#input-telp2').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(5)').text());
        $('#input-fax').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(6)').text());
        if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(9)').text() == 'Aktif') {
            $('#radio-status-aktif').attr('checked', true);
        } else if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(9)').text() == 'Tidak aktif') {
            $('#radio-status-nonaktif').attr('checked', true);
        }

        $('#col-telp1').removeClass('col-sm-4');
        $('#col-telp2').removeClass('col-sm-4');
        $('#col-fax').removeClass('col-sm-4');
        $('#col-telp1').addClass('col-sm-6');
        $('#col-telp2').addClass('col-sm-6');
        $('#col-fax').addClass('col-sm-6');
        $('#col-status').show();

        $('#modal-outlet').modal('show');
    });

    // untuk menambah data outlet
    $('#add-outlet').on('click', function() {
        $('#form-outlet').attr('action', "/setting/outlet");
        $('#modal-outlet .modal-title').text('Tambah outlet');

        $('#input-kode').val('');
        $('#input-nama').val('');
        $('#input-alamat').val('');
        $('#input-telp1').val('');
        $('#input-telp2').val('');
        $('#input-fax').val('');

        $('#col-telp1').removeClass('col-sm-6');
        $('#col-telp2').removeClass('col-sm-6');
        $('#col-fax').removeClass('col-sm-6');
        $('#col-telp1').addClass('col-sm-4');
        $('#col-telp2').addClass('col-sm-4');
        $('#col-fax').addClass('col-sm-4');
        $('#col-status').hide();

        $('#modal-outlet').modal('show');
    });

    $('#action-add-saldo').on('click', function() {
        $('#modal-form').attr('action', "/setting/outlet/update-saldo/" + btnId);

        $('#input-saldo-kode').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(1)').html());
        $('#input-saldo-nama').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(2)').html());
        $('#input-saldo').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(8)').html());
        $('#input-nominal').val('0');

        $('#modal-add-saldo').modal('show');
    });

    $('#form-outlet').on('submit', function(e) {
        e.preventDefault();
        $('#btn-save').addClass('disabled');
        e.currentTarget.submit();
    });
});
