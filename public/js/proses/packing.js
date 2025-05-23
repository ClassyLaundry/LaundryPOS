$(document).ready(function() {
    var btnIndex = -1, btnId = 0, tipeTrans = '', kodeTrans = '';
    $('#container-list-trans').on('click', '.btn-show-action', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
        tipeTrans = $(this).closest('tr').children().eq(1).text().toLowerCase();
        kodeTrans = $(this).closest('tr').children().eq(0).text();
    });

    $('#action-detail').on('click', function() {
        $('#container-bucket').empty();
        $('#container-premium').empty();
        if (tipeTrans == 'bucket') {
            $('#container-bucket').load(window.location.origin + '/component/shortTrans/' + btnId, function() {
                $('#text-catatan-transaksi').text($('#container-bucket #catatan-transaksi').val());
                $('#text-catatan-pelanggan').text($('#container-bucket #catatan-pelanggan').val());
                $('#modal-detail').modal('show');
            });
        } else {
            $('#container-premium').load(window.location.origin + '/component/shortTrans/' + btnId, function() {
                $('#text-catatan-transaksi').text($('#container-premium #catatan-transaksi').val());
                $('#text-catatan-pelanggan').text($('#container-premium #catatan-pelanggan').val());
                $('#modal-detail').modal('show');
            });
        }
    });

    var flag = false;
    var btnItemTransId = 0, btnItemTransName = '';
    $('#container-bucket, #container-premium').on('click', '.btn-show-action-2', function() {
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
        btnItemTransName = $(this).closest('tr').children(0).html();
        btnItemTransId = $(this).attr('id').substring(4);
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

    $('#action-rewash').on('click', function() {
        window.location = window.location.origin + '/proses/rewash' + '?trans_kode=' + kodeTrans + '&trans_item=' + btnItemTransId;
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
            let imageContainer = $('#container-image-item').find('.carousel-item').eq(0).detach();
            if (!imageContainer.hasClass('active')) imageContainer.addClass('active');
            $('#container-image-item .carousel-inner').empty();
            $('#container-image-item .carousel-inner').append(imageContainer);
            let images = transNote.image_path.split(';');
            for (let index = 0; index < images.length; index++) {
                if (index == 0) {
                    $('#container-image-item').find('.carousel-item').eq(index).find('img').attr('src', images[index]);
                } else {
                    $('#container-image-item').find('.carousel-item').eq(index - 1).clone().appendTo("#container-image-item .carousel-inner");
                    $('#container-image-item').find('.carousel-item').eq(index).removeClass('active').find('img').attr('src', images[index]);
                }
            }

            transNote.front_top_left == 1 ? $('#td-kiri-atas').addClass('selected') : $('#td-kiri-atas').removeClass('selected');
            transNote.front_top_right == 1 ? $('#td-kanan-atas').addClass('selected') : $('#td-kanan-atas').removeClass('selected');
            transNote.front_bottom_left == 1 ? $('#td-kiri-bawah').addClass('selected') : $('#td-kiri-bawah').removeClass('selected');
            transNote.front_bottom_right == 1 ? $('#td-kanan-bawah').addClass('selected') : $('#td-kanan-bawah').removeClass('selected');
            transNote.back_top_left == 1 ? $('#tb-kiri-atas').addClass('selected') : $('#tb-kiri-atas').removeClass('selected');
            transNote.back_top_right == 1 ? $('#tb-kanan-atas').addClass('selected') : $('#tb-kanan-atas').removeClass('selected');
            transNote.back_bottom_left == 1 ? $('#tb-kiri-bawah').addClass('selected') : $('#tb-kiri-bawah').removeClass('selected');
            transNote.back_bottom_right == 1 ? $('#tb-kanan-bawah').addClass('selected') : $('#tb-kanan-bawah').removeClass('selected');

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
            for (let index = 0; index < $('#input-foto-item').prop('files').length; index++) {
                const element = $('#input-foto-item').prop('files')[index];
                formData.append('image[]', element);
            }

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

    $('#action-kemas').on('click', function() {
        $('#table-container').load(window.location.origin + '/component/packing/' + btnId, function() {
            $('#modal-packing').modal('show');
        });
    });

    $('#table-container').on('click', '#btn-clone', function() {
        $('#table-packing tbody tr').last().clone().appendTo('#table-packing tbody');
    });

    $('#container-list-trans').load(window.location.origin + '/component/packing', function() {
        $("#table-list-trans").dataTable({
            columnDefs : [{
                targets: [3, 4],
                render: function (data, type, row) {
                    if ((type === 'display' || type === 'filter') && data != '') {
                        return new Date(data).toLocaleDateString('en-GB');
                    }
                    return data;
                }
            }],
            order: [[3, 'desc']],
            columns: [
                null,
                null,
                null,
                null,
                null,
                { orderable: false }
            ]
        });
    });

    $('#form-packing').on('submit', function(e) {
        e.preventDefault();

        let inventories = [];
        for (let i = 0; i < $('.input-inventory').length; i++) {
            inventories.push({
                inventory_id: $('.input-inventory').eq(i).val(),
                qty: $('.input-qty').eq(i).val(),
            });
        }

        let formData = new FormData();
        formData.append('transaksi_id', btnId);
        formData.append('inventories', JSON.stringify(inventories));

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "/proses/packing",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).done(function() {
            alert('Data packing berhasil disimpan');
            window.location = window.location.origin + window.location.pathname;
        }).fail(function(message) {
            alert('error');
            console.log(message);
        });
    });
});
