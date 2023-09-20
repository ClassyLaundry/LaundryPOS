$(document).ready(function() {
    // base
    if($('#list-action').children().length == 0) {
        $('#list-action').detach();
    }
    var btnIndex = -1, btnId = 0;
    $('#list-karyawan').on('click', '.btn-show-action', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    // data karyawan
    function reloadList() {
        let role = $('#dropdown-filter-role .dropdown-menu .dropdown-item.active').data('value');
        $('#list-karyawan').load(window.location.origin + '/component/karyawan?key=' + $('#input-search').val() + (role != '' ? '&role=' + role : ''));
    }
    reloadList();
    $('#dropdown-filter-role .dropdown-menu .dropdown-item').on('click', function() {
        $('#dropdown-filter-role .dropdown-menu .dropdown-item.active').removeClass('active');
        $(this).addClass('active');
        reloadList();
    });

    $('#list-karyawan').on('click', '.page-link', function(e) {
        e.preventDefault();
        $('#list-karyawan').load($(this).attr('href'));
    });

    // untuk update data karyawan
    $('#action-update').on('click', function() {
        $('#form-karyawan').attr('action', "/setting/karyawan/" + btnId);
        $('#modal-data-user .modal-title').text('Rubah data karyawan');

        $('#input-username').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(1)').html());
        $('#input-password').attr('required', false);
        $('#input-password').attr('name', '');
        $('#input-nama').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(2)').html());
        $('#input-telepon').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(3)').html());
        $('#input-email').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(4)').html());
        $("#input-outlet option:contains(" + $('tbody tr:nth-child(' + btnIndex + ') td:nth-child(5)').html() +")").attr("selected", true);
        $("#input-role option:contains(" + $('tbody tr:nth-child(' + btnIndex + ') td:nth-child(6)').html() +")").attr("selected", true);
        if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(7)').html() == 'Aktif') {
            $('#radio-status-aktif').attr('checked', true);
        } else if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(7)').html() == 'Tidak aktif') {
            $('#radio-status-tidakAktif').attr('checked', true);
        }

        $('#col-password').hide();
        $('#col-status').show();

        $('#col-username').removeClass('col-sm-6');
        $('#col-username').addClass('col-sm-3');
        $('#col-name').addClass('col-sm-9');

        $.ajax({
            url: "/setting/karyawan/" + btnId,
        }).done(function(data) {
            let alamat = data[0].address;
            $('#input-alamat').val(alamat);
            $('#modal-data-user').modal('show');
        });
    });

    // untuk menambah data karyawan
    $('#btn-add').on('click', function() {
        $('#form-karyawan').attr('action', "/setting/karyawan");
        $('#modal-data-user .modal-title').text('Tambah data karyawan');

        $('#input-username').val('');
        $('#input-password').val('');
        $('#input-password').attr('required', true);
        $('#input-password').attr('name', 'password');
        $('#input-nama').val('');
        $('#input-alamat').val('');
        $('#input-telepon').val('');
        $('#input-email').val('');
        $('#input-outlet').val('');
        $('#input-role').val('');
        $('#radio-status-aktif').attr('checked', false);
        $('#radio-status-tidakAktif').attr('checked', false);

        $('#col-password').show();
        $('#col-status').hide();

        $('#col-username').removeClass('col-sm-3');
        $('#col-username').addClass('col-sm-6');
        $('#col-name').removeClass('col-sm-9');

        $('#modal-data-user').modal('show');
    });

    // untuk menampilkan modal ganti password
    $('#action-change-password').on('click', function() {
        $('#modal-change-password').modal('show');
    });

    // untuk merubah password karyawan
    $('#btn-change-password').on('click', function() {
        $(this).addClass('disabled');
        $('#error-msg').parent().addClass('d-none');

        let formData = new FormData();
        formData.append('new_password', $('#input-password-baru').val());
        formData.append('new_password_confirmation', $('#input-konfirmasi').val());

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "/setting/karyawan/" + btnId + "/change-password",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).done(function(data) {
            $('#btn-change-password').removeClass('disabled');
            if (data.message == "Success") {
                $('#modal-change-password').modal('hide');
            } else {
                $('#error-msg').text(data.message);
                $('#error-msg').parent().removeClass('d-none');
            }
        }).fail(function(message) {
            alert('error');
            console.log(message);
        });
    });


    // role & permission
    $('#role-id').on('change', function() {
        $(this).addClass('disabled');
        $(".form-check-input").each(function() {
            $(this).prop("checked", false);
        })
        $.ajax({
            url: "/setting/hak-akses/role/" + $(this).val(),
        }).done(function(data) {
            data.forEach(value => {
                $("input:checkbox[value='" + value + "']").prop("checked", true);
            });
            $('#list-hak-akses').removeClass('disabled');
            $('#role-id').removeClass('disabled');
        });
    });

    $('#save-permission').on('click', function() {
        let formData = new FormData();
        $('.form-check-input:checked').each(function(index){
            formData.append('list[]', $(this).val());
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "/setting/hak-akses/role/" + $('#role-id').val() + "/sync",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).done(function(data) {
            alert('Perubahan hak akses berhasil disimpan');

        }).fail(function(message) {
            alert('error');
            console.log(message);
        });
    });
});
