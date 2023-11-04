$(document).ready(function() {
    function karyawanHubCheck() {
        $('.hub-list').each(function() {
            if ($(this).children().length == 0) {
                if ($(this).hasClass('hub-cuci')) {
                    $(this).append('<div class="alert alert-success" role="alert">Tidak ada pekerjaan</div>');
                } else {
                    $(this).append('<div class="alert alert-warning" role="alert">Tidak ada pekerjaan</div>');
                }
            } else {
                $(this).find('.alert').detach();
            }
        });
    }
    karyawanHubCheck();

    var currentlySelectedItemId = 0;
    $(".hub-cuci, .hub-karyawan").sortable({
        connectWith: ".hub-list",
        placeholder: "sortable-placeholder",
        items: ".item",
        start: function( event, ui ) {
            currentlySelectedItemId = ui.item.find('.btn').attr('id').substring(6);
        },
        receive: function( event, ui ) {
            karyawanHubCheck();
            ui.item.addClass('disabled');
            if (ui.item.parent().hasClass('hub-karyawan')) {
                $.ajax({
                    url: "/transaksi/" + currentlySelectedItemId + "/pencuci",
                }).done(function() {
                    ui.item.removeClass('disabled');
                });
            } else if (ui.item.parent().hasClass('hub-cuci')) {
                $.ajax({
                    url: "/transaksi/" + currentlySelectedItemId + "/pencuci/delete",
                }).done(function() {
                    ui.item.removeClass('disabled');
                });
            }
        },
    }).disableSelection();

    var btnIndex = -1, btnId = 0;
    $('.btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(6);

        if ($(this).closest('.hub-cuci').length != 0) {
            $('#action-add').show();
            $('#action-remove').hide();
            $('#action-done').hide();
        } else if ($(this).closest('.hub-karyawan').length != 0) {
            $('#action-add').hide();
            $('#action-remove').show();
            $('#action-done').show();
        }
    });

    $('#action-detail').on('click', function() {
        $('#table-short-trans').load(window.location.origin + '/component/shortTrans/' + btnId + '/process');
        $('#modal-detail').modal('show');
    });

    $('#action-add').on('click', function() {
        $('#trans-' + btnId).addClass('disabled');
        let temp = $('#trans-' + btnId).parent().parent().parent().detach();
        $.ajax({
            url: "/transaksi/" + btnId + "/pencuci",
        }).done(function() {
            $('.hub-karyawan').append(temp);
            $('#trans-' + btnId).removeClass('disabled');
            karyawanHubCheck();
        });
    });

    $('#action-pesan').on('click', function() {
        $('.btn-show-action').eq(btnIndex - 1).closest('.rounded').next().toggle();
    });

    $('#action-remove').on('click', function() {
        $('#trans-' + btnId).addClass('disabled');
        let temp = $('#trans-' + btnId).parent().parent().detach();
        $.ajax({
            url: "/transaksi/" + btnId + "/pencuci/delete",
        }).done(function(error) {
            if (error.message) {
                alert("error");
                console.log(message);
                $('#trans-' + btnId).removeClass('disabled');
            } else {
                $('.hub-cuci').append(temp);
                $('#trans-' + btnId).removeClass('disabled');
                karyawanHubCheck();
            }
        });
    });

    $('#action-done').on('click', function() {
        if(confirm("Nyatakan cuci selesai ?")) {
            $.ajax({
                url: "/transaksi/" + btnId + "/pencuci/done",
            }).done(function() {
                location.reload();
            });
        }
    });

    var flag = false;
    var btnItemTransId = 0, btnItemTransName = '';
    $('#table-short-trans').on('click', '.btn-show-action-2', function() {
        let lebarList = 150;
        let lebarBtn = $(this).css('width');
        let lebarTambahan = 2;
        lebarBtn = parseInt(lebarBtn.substr(0, lebarBtn.indexOf('px')));
        $('#list-action-2').css('left', $(this).offset().left - $('#modal-detail .modal-body').offset().left - lebarList + lebarBtn + lebarTambahan);
        let tinggiBtn = $(this).css('height');
        let tinggiHeader = 0;
        tinggiBtn = parseInt(tinggiBtn.substr(0, tinggiBtn.indexOf('px')));
        $('#list-action-2').css('top', $(this).offset().top - $('#modal-detail .modal-body').offset().top + tinggiBtn + tinggiHeader);
        $('#list-action-2').show();
        btnItemTransId = $(this).attr('id').substr(4);
        btnItemTransName = $(this).closest('tr').children().eq(0).html();
        flag = true;
    });

    $(document).on('click', function() {
        setTimeout(function (){
            if (flag) {
                flag = !flag;
            } else {
                $('.list-action').each(function(index, element) {
                    if ($(element).css('display') == 'block') {
                        $(element).hide();
                    }
                });
            }
        }, 10);
    });

    $('#action-notes').on('click', function() {
        $('#table-catatan-item').load(window.location.origin + '/component/note/' + btnItemTransId, function() {
            $('#modal-list-catatan-item').find('.modal-title').html('Catatan item ' + btnItemTransName);
            $('#modal-list-catatan-item').modal('show');
        });
    });

    var btnItemNoteId = 0;
    $('#table-catatan-item').on('click', '.btn-show-action-2', function() {
        let lebarList = 150;
        let lebarBtn = $(this).css('width');
        let lebarTambahan = 2;
        lebarBtn = parseInt(lebarBtn.substr(0, lebarBtn.indexOf('px')));
        $('#list-action-3').css('left', $(this).offset().left - $('#modal-list-catatan-item .modal-body').offset().left - lebarList + lebarBtn + lebarTambahan);
        let tinggiBtn = $(this).css('height');
        let tinggiHeader = 0;
        tinggiBtn = parseInt(tinggiBtn.substr(0, tinggiBtn.indexOf('px')));
        $('#list-action-3').css('top', $(this).offset().top - $('#modal-list-catatan-item .modal-body').offset().top + tinggiBtn + tinggiHeader);
        $('#list-action-3').show();
        btnItemNoteId = $(this).closest('tr').attr('id');
        flag = true;
    });

    $('#table-catatan-item').on('click', '#add-catatan-item',function() {
        $('#catatan-item-name').text(btnItemTransName);

        $('#penulis-catatan-item').parent().hide();
        $('#penulis-catatan-item').removeClass('disabled');
        $('#catatan-item').removeClass('disabled');
        $('#input-foto-item').show();
        $('#tab-noda').removeClass('disabled');

        $('#penulis-catatan-item').val('');
        $('#catatan-item').val('');
        $('#container-image-item').prop('src', '');
        $('#input-foto-item').val('');

        $('#modal-catatan-item .modal-footer').show();
        $('#modal-catatan-item').modal('show');
    });

    $('#action-detail-note').on('click', function() {
        $('#catatan-item-name').text(btnItemTransName);
        $.ajax({
            url: "/transaksi/item/note/" + btnItemNoteId,
        }).done(function(data) {
            let transNote = data[0];

            $('#penulis-catatan-item').parent().show();
            $('#penulis-catatan-item').val(transNote.nama_user);
            $('#catatan-item').val(transNote.catatan);
            $('#container-image-item').attr('src', transNote.image_path);

            $('#penulis-catatan-item').addClass('disabled');
            $('#catatan-item').addClass('disabled');
            $('#input-foto-item').hide();
            $('#tab-noda').addClass('disabled');

            $('#modal-catatan-item .modal-footer').hide();
            $('#modal-catatan-item').modal('show');
        });
    });

    $('#simpan-catatan-item').on('click', function() {
        if ($('#form-catatan')[0].checkValidity()) {
            $(this).addClass('disabled');

            let formData = new FormData();
            formData.append('item_transaksi_id', btnItemTransId);
            formData.append('modified_by', $('#penulis-catatan-item').val());
            formData.append('catatan', $('#catatan-item').val());
            formData.append('image', $('#input-foto-item').prop("files")[0]);

            formData.append('front_top_left', $('#td-kiri-atas').hasClass('selected') ? 1 : 0);
            formData.append('front_top_right', $('#td-kanan-atas').hasClass('selected') ? 1 : 0);
            formData.append('front_bottom_left', $('#td-kiri-bawah').hasClass('selected') ? 1 : 0);
            formData.append('front_bottom_right', $('#td-kanan-bawah').hasClass('selected') ? 1 : 0);
            formData.append('back_top_left', $('#tb-kiri-atas').hasClass('selected') ? 1 : 0);
            formData.append('back_top_right', $('#tb-kanan-atas').hasClass('selected') ? 1 : 0);
            formData.append('back_bottom_left', $('#tb-kiri-bawah').hasClass('selected') ? 1 : 0);
            formData.append('back_bottom_right', $('#tb-kanan-bawah').hasClass('selected') ? 1 : 0);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "/transaksi/item/note/add",
                method: "POST",
                contentType: false,
                processData: false,
                data: formData,
            }).done(function() {
                $('#simpan-catatan-item').removeClass('disabled');
                $('#modal-catatan-item').modal('hide');
                $('#modal-list-catatan-item').modal('hide');
            }).fail(function(message) {
                console.log(message);
            });
        } else {
            $('#form-catatan')[0].reportValidity();
        }
    });
});
