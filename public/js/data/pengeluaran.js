$(document).ready(function() {
    if ($('#table-pengeluaran tbody').children().length == 0) {
        $('#table-pengeluaran tbody').append('<tr><td colspan=7 class="text-center">Data masih kosong</td></tr>');
    }

    if($('#list-action').children().length == 0) {
        $('#list-action').detach();
    }
    var btnIndex = -1, btnId = 0;
    $('#table-pengeluaran .btn').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    $('#btn-tambah').on('click', function() {
        btnIndex = -1;
        $('.modal-title').text('Tambah pengeluaran baru');

        $('#input-nama-pengeluaran').val('');
        $('#input-deskripsi').val('');
        $('#input-nominal').val(0);

        $('#modal-update').modal('show');
    });

    $('.btn-delete').on('click', function() {
        if (confirm('Yakin menghapus data ?')) {
            $.ajax({
                url: "/data/pengeluaran/delete/" + btnId,
            }).done(function(data) {
                if (data.status == 200) {
                    alert(data.message);
                    window.location = window.location.origin + window.location.pathname;
                } else {
                    alert(data.message);
                }
            });
        }
    });

    $('#modal-form').on('submit', function(e) {
        e.preventDefault();
        $('#btn-submit').addClass('disabled');

        let formData = new FormData();
        formData.append('nama', $('#input-nama-pengeluaran').val());
        formData.append('deskripsi', $('#input-deskripsi').val());
        formData.append('nominal', $('#input-nominal').val());

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('#modal-form').children().eq(0).val(),
            },
            url: "/data/pengeluaran",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).done(function(data) {
            if (data.status == '402') {
                alert(data.message);
                $('#modal-update').modal('hide');
                $('#btn-submit').removeClass('disabled');
            } else if (data.status == '200'){
                alert(data.message);
                window.location = window.location.origin + window.location.pathname;
            }
        });
    });
});
