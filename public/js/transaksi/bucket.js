$(document).ready(function() {
    $('#modal-opsi-trans, #modal-new-trans, #modal-kode-promo').modal({
        backdrop: 'static',
        keyboard: false
    });

    $('#modal-opsi-trans').modal('show');

    $('#show-option').on('click', function() {
        $('#modal-opsi-trans').modal('show');
    });

    var transId = 0;
    $('#container-list-trans').on('click', '#table-list-trans tbody tr', function() {
        let parent = $(this).parent();
        parent.addClass('disabled');
        let id = $(this).attr('id');
        transId = id;

        $.ajax({
            url: "/transaksi/detail/" + id,
        }).done(function(data) {
            let trans = data;
            $('#id-trans').text(trans.id);
            $('#kode-trans').text(trans.kode);

            $('#input-parfum').val(trans.parfum_id);
            $('#formCheck-express').prop('checked', trans.express);
            if (trans.express) {
                $('#formCheck-express').val(1);
            }
            $('#formCheck-setrika').prop('checked', trans.setrika_only);
            if (trans.setrika_only) {
                $('#formCheck-setrika').val(1);
            }
            $('#input-catatan-trans').val(trans.catatan);
            $('#tanggal-selesai-proses').val(trans.done_date);

            let pelanggan = trans.pelanggan;
            $('#input-nama').val(pelanggan.nama);
            $('#input-telepon').val(pelanggan.telephone);
            $('#input-alamat').val(pelanggan.alamat);
            if (pelanggan.member) {
                $('#input-member').val('Member');
            } else {
                $('#input-member').val('Bukan member');
            }
            $('#input-saldo').val(pelanggan.saldo_akhir.toLocaleString(['ban', 'id']));

            if (pelanggan.catatan_pelanggan != null) {
                $('#input-catatan-pelanggan').val(pelanggan.catatan_pelanggan.catatan_khusus);
            }

            $('#search-pelanggan').hide();
            $('#data-pelanggan').show();

            $('#select-outlet').val(trans.outlet_id);

            let pickup = trans.pickup_delivery[0];
            let delivery = trans.pickup_delivery[1];
            let penerima = trans.penerima;

            if (typeof pickup !== "undefined") {
                $('#formCheck-pickup').parent().next().show();
                $('#formCheck-pickup').prop('checked', true);
                $('#input-kode-pickup').val(pickup.kode);
                $('#input-driver-pickup').val(pickup.nama_driver);
                $('#container-pickup').addClass('disabled');
            } else {
                $('#formCheck-pickup').parent().next().hide();
                $('#formCheck-pickup').prop('checked', false);
                $('#select-kode-pickup').val('');
            }

            if (typeof delivery !== "undefined") {
                $('#formCheck-delivery').parent().next().show();
                $('#formCheck-delivery').prop('checked', true);
                $('#select-kode-delivery').val(delivery.id);
                $('#check-delivery').addClass('disabled');
                $('#container-delivery').addClass('disabled');
                $('#container-delivery').removeClass('d-none');
            }else {
                $('#formCheck-delivery').parent().next().hide();
                $('#formCheck-delivery').prop('checked', false);
                $('#select-kode-delivery').val('');
            }

            if (trans.need_delivery) {
                $('#formCheck-delivery').prop('checked', true);
            } else {
                $('#formCheck-delivery').prop('checked', false);
            }

            if (penerima) {
                $('#select-outlet-ambil').parent().addClass('disabled');
                $('#select-outlet-ambil').val(penerima.outlet_id);
                $('#input-nama-penerima').val(penerima.penerima);
                $('#input-foto-penerima').hide().prev().hide();
                $('#btn-show-foto_penerima').show();
                $('#btn-show-foto_penerima').show();
                $('#btn-show-foto_penerima').data('url', penerima.foto_penerima);

                $('#simpan-info-penerimaan').hide();
            } else {
                $('#select-outlet-ambil').parent().removeClass('disabled');
                $('#select-outlet-ambil').val('');
                $('#input-nama-penerima').val('');
                $('#input-foto-penerima').show().prev().show();
                $('#btn-show-foto_penerima').hide();
                $('#btn-show-foto_penerima').data('url', '');

                $('#simpan-info-penerimaan').show();
            }

            if (!$('#show-data-pelanggan').hasClass('show')) {
                $('#show-data-pelanggan').trigger('click');
            }
            if (!$('#show-data-pickup-delivery').hasClass('show')) {
                $('#show-data-pickup-delivery').trigger('click');
            }
            if (!$('#show-data-outlet').hasClass('show')) {
                $('#show-data-outlet').trigger('click');
            }
            if (!$('#show-data-penerimaan').hasClass('show')) {
                $('#show-data-penerimaan').trigger('click');
            }

            $('#table-container').load(window.location.origin + '/component/transBucket/' + id, function() {
                setThousandSeparator();
            });

            if (trans.lunas) {
                $('#cancel-trans').hide();
            } else {
                $('#cancel-trans').show();
            }

            $('#form-transaksi').data('action', '/transaksi/update/' + trans.id);

            parent.removeClass('disabled');
            $('#modal-opsi-trans').modal('hide');
        });
    });

    var searchTrans, key = '', page = 1;
    $('#input-key-trans').on('input', function() {
        page = 1;
        clearTimeout(searchTrans);
        searchTrans = setTimeout(searchListTrans, 2000);
    });

    searchListTrans();

    function searchListTrans() {
        key = $('#input-key-trans').val();
        $('#container-list-trans').load(window.location.origin + '/transaksi/search?tipe=bucket&key=' + encodeURIComponent(key) + '&page=' + page, function() {
            setThousandSeparator();
        });
    }

    $('#container-list-trans').on('click', '.page-link', function(e) {
        e.preventDefault();
        page = $(this).attr('href').split('page=')[1];
        searchListTrans();
    });

    $('#add-new-trans').on('click', function() {
        $('#modal-opsi-trans').modal('hide');
        $('#modal-new-trans').modal('show');
    });

    $('#new-trans-back').on('click', function() {
        $('#modal-opsi-trans').modal('show');
    });

    $('#search-pelanggan-2').on('click', function() {
        $(this).next().toggle();
    });

    $('#table-list-pelanggan-2').load(window.location.origin + '/component/pelanggan2?paginate=5', function() {
        $('#table-list-pelanggan-2 th:last').hide();
        $('#table-list-pelanggan-2 .cell-action').hide();
    });
    $('#table-list-pelanggan-2').on('click', '.page-link', function(e) {
        e.preventDefault();
        $('#table-list-pelanggan-2').load($(this).attr('href'));
    });

    var searchPelanggan;
    $('#input-nama-pelanggan-2').on('input', function() {
        clearTimeout(searchPelanggan);
        searchPelanggan = setTimeout(searchListPelanggan, 1000);
    });

    function searchListPelanggan() {
        $('#table-list-pelanggan-2').load(window.location.origin + '/component/pelanggan2?key=' + encodeURIComponent($('#input-nama-pelanggan-2').val()) + '&filter=nama&paginate=5', function() {
            $('#table-list-pelanggan-2 th:last').hide();
            $('#table-list-pelanggan-2 .cell-action').hide();
        });
    }

    $('#table-list-pelanggan-2').on('click', 'tbody tr', function() {
        let parent = $(this).parent();
        parent.addClass('disabled');
        let id = $(this).attr('id').substr(10);

        $.ajax({
            url: "/data/pelanggan/" + id,
        }).done(function(data) {
            let pelanggan = data[0];

            $('#input-id-2').val(pelanggan.id);
            $('#input-nama-2').val(pelanggan.nama);
            $('#input-telepon-2').val(pelanggan.telephone);
            $('#input-alamat-2').val(pelanggan.alamat);
            $('#input-email-2').val(pelanggan.email);
            $('#input-tanggal-lahir-2').val(pelanggan.tanggal_lahir);
        });

        $('#search-pelanggan-2').text('Ganti pelanggan');
        $(this).closest('.card').hide();
        parent.removeClass('disabled');
    });

    $('#create-trans').on('click', function() {
        let pelanggan_id = $('#input-id-2').val();
        $.ajax({
            url: "/transaksi/create?pelanggan_id=" + pelanggan_id + '&tipe_transaksi=bucket',
        }).done(function(data) {
            window.location = window.location;
        });
    });

    function setThousandSeparator() {
        let length = $('.thousand-separator').length;
        if (length != 0) {
            $('.thousand-separator').each(function(index, element) {
                let val = $(element).text();
                if (val != '') {
                    while(val.indexOf('.') != -1) {
                        val = val.replace('.', '');
                    }
                    let number = parseInt(val);
                    $(element).text(number.toLocaleString(['ban', 'id']));
                }
            });
        }
    };

    $('#formCheck-pickup').on('change', function() {
        if ($(this).is(':checked')) {
            $(this).parent().next().show();
        } else {
            $(this).parent().next().hide();
        }
    });

    $('#form-penerimaan').on('submit', function(e) {
        e.preventDefault();
        $(this).addClass('disabled');
        let id_trans = $('#id-trans').text();
        let id_outlet = $('#select-outlet-ambil').val();
        let ambil_di_outlet = 0;
        if (id_outlet) {
            ambil_di_outlet = 1;
        }

        let formData = new FormData();
        formData.append('transaksi_id', id_trans);
        formData.append('ambil_di_outlet', ambil_di_outlet);
        formData.append('outlet_id', id_outlet);
        formData.append('penerima', $('#input-nama-penerima').val());
        formData.append('image', $('#input-foto-penerima').prop("files")[0]);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "/transaksi/penerima",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).done(function() {
            $('#simpan-info-penerimaan').removeClass('disabled');
            $('#simpan-info-penerimaan').hide();
        }).fail(function(message) {
            alert('error');
            console.log(message);
        });
    });

    $('#btn-show-foto_penerima').on('click', function() {
        window.open($(this).data('url'), '_blank');
    });

    $('.show-data').on('click', function() {
        let dataType = $(this).attr('id').substring($(this).attr('id').indexOf('data-') + 5);
        if (!$(this).hasClass('show')) {
            $(this).addClass('show');
            $(this).children().addClass('fa-rotate-180');
            $(this).closest('.card').addClass('h-100');

            $('#info-' + dataType).show();
        } else {
            $(this).removeClass('show');
            $(this).children().removeClass('fa-rotate-180');
            $(this).closest('.card').removeClass('h-100');

            $('#info-' + dataType).hide();
        }
    });

    $('#search-pelanggan').on('click', function() {
        $('#modal-list-pelanggan').modal('show');
    });

    $('#table-list-pelanggan tbody tr').on('click', function() {
        let id = $(this).attr('id').substring($(this).attr('id').indexOf('row-') + 4);

        $.ajax({
            url: "/data/pelanggan/" + id,
        }).done(function(data) {
            let pelanggan = data[0];

            $('#input-nama').val(pelanggan.nama);
            $('#input-telepon').val(pelanggan.telephone);
            $('#input-alamat').val(pelanggan.alamat);
            $('#input-email').val(pelanggan.email);
            $('#input-tanggal-lahir').val(pelanggan.tanggal_lahir);
        });

        $('#search-pelanggan').text('Ganti pelanggan');
        $('#data-pelanggan').show();
        $('#modal-list-pelanggan').modal('hide');
    });

    $('#to-pickup-delivery').on('click', function() {
        window.location = "/transaksi/pickup-delivery/";
    });

    $('#table-container').on('click', '#add-item', function() {
        searchListItem();
        $('#modal-add-item').modal('show');
    });

    var searchItem;
    $('#input-nama-item').on('input', function() {
        clearTimeout(searchItem);
        searchItem = setTimeout(searchListItem, 2000);
    });

    function searchListItem() {
        $('#container-search-item').load(window.location.origin + '/component/searchItemTrans?tipe=bucket&key=' + encodeURIComponent($('#input-nama-item').val()));
    }

    $('#container-search-item').on('click', '#table-items tbody tr', function() {
        let parent = $(this).parent();
        parent.addClass('disabled');
        let id = $(this).attr('id');
        id = id.substr(5);

        $.ajax({
            url: "/data/jenis-item/" + id,
        }).done(function(data) {
            let item = data[0];

            $.ajax({
                url: "/transaksi/addItem?jenis_item_id=" + item.id + "&transaksi_id=" + $('#id-trans').text() + "&tipe=bucket",
            }).done(function(data) {
                $('#table-container').load(window.location.origin + '/component/transBucket/' + transId, function() {
                    setThousandSeparator();
                    parent.removeClass('disabled');
                    $('#modal-add-item').modal('hide');
                });
            });
        });
    });

    $('#table-container').on('dblclick', '.col-qty', function() {
        let div = $(this).find('div').detach();
        $(this).append('<input class="form-control text-center" type="number" step=0.1 min=1 name="qty" value=' + div.text() + '>');
        $(this).find('input').focus();
    });

    $('#table-container').on('blur', '.col-qty', function() {
        let input = $(this).find('input').detach();
        $(this).append("<div class='d-flex align-items-center justify-content-center' style='height: 39.5px;'>" + input.val() + "</div>");

        let id = $(this).closest('tr').attr('id');
        let formData = new FormData();
        formData.append('qty', input.val());

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "/transaksi/item-transaksi/" + id + "/qty",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).done(function(data) {
            $('#table-container').load(window.location.origin + '/component/transBucket/' + transId, function() {
                setThousandSeparator();
            });
        }).fail(function(message) {
            alert('error');
            console.log(message);
        });
    });

    $('#show-catatan-trans').on('click', function() {
        let containerCatatan = $(this).next();
        containerCatatan.css('top', 'calc(-' + containerCatatan.css('height') + ' - .75rem');
        containerCatatan.toggle();
    });

    $('#save-catatan-trans').on('click', function() {
        $(this).closest('div').hide();
    });

    var btnIndex = -1, currentlySelectedItemTransactionID = 0, currentlySelectedItemName = '', btnId = '';
    $('#table-container').on('click', '.btn-show-action', function() {
        btnId = $(this).attr('id');
        btnIndex = $(this).index('#table-container .btn-show-action') + 1;
        currentlySelectedItemTransactionID = $('#table-container tbody tr:nth-child(' + btnIndex + ')').attr('id');
        currentlySelectedItemName = $('#table-container tbody tr:nth-child(' + btnIndex + ')').children().eq(0).html();
    });

    $('#action-change-qty').on('click', function() {
        let currentField = $('#' + btnId).parent().siblings('.col-qty');
        let div = $(currentField).find('div').detach();
        $(currentField).append('<input class="form-control text-center" type="number" step=0.1 min=1 name="qty" value=' + div.text() + '>');
        $(currentField).find('input').focus();
    });

    $('#action-notes').on('click', function() {
        $('#table-catatan-item').load(window.location.origin + '/component/note/' + currentlySelectedItemTransactionID, function() {
            $('#modal-list-catatan-item').modal('show');
        });
    });

    $('#action-delete').on('click', function() {
        if (confirm('Yakin menghapus data  ?')) {
            $.ajax({
                url: "/transaksi/item-transaksi/delete/" + currentlySelectedItemTransactionID,
            }).done(function(data) {
                let trans = data[0];
                $('#sub-total').html(trans.subtotal);
                $('#diskon').html(trans.diskon);
                $('#diskon-member').html(trans.diskon_member);
                $('#diskon-member').html(trans.diskon_member);
                $('#diskon-pelanggan_spesial').html(trans.diskon_pelanggan_spesial);
                $('#grand-total').html(trans.grand_total);

                currentlySelectedItemTransactionID = 0;
                currentlySelectedItemName = '';
                $('#table-container').load(window.location.origin + '/component/transBucket/' + transId, function() {
                    setThousandSeparator();
                });

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }
    });

    $('.stain-selection').on('click', function() {
        $(this).toggleClass('selected');
    });

    $('#formCheck-express, #formCheck-setrika').on('change', function() {
        if($(this).is(':checked')) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }
    });

    $('#form-transaksi').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        formData.append('need_delivery', $('#formCheck-delivery').is(':checked') ? 1 : 0);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: $('#form-transaksi').data('action'),
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).done(function(response) {
            alert(response.message);
            window.location = window.location.origin + window.location.pathname;
        }).fail(function(message) {
            alert('error');
            console.log(message);
        });
    });

    // Catatan
    var imgWidth = 0, imgHeight = 0;
    $('#input-foto-item').on('change', function() {
        imgWidth = $('#container-image-item').clientWidth;
        imgHeight = $('#container-image-item').clientHeight;
        // console.log("width : " + imgWidth + "\nheight : " + imgHeight);
    });

    $('#container-image-item').on('hover', function() {

    });

    var flag = false;
    var btnItemNoteId = 0;
    $('#table-catatan-item').on('click', '.btn-show-action-2', function() {
        let lebarList = 150;
        let lebarBtn = $(this).css('width');
        let lebarTambahan = 2;
        lebarBtn = parseInt(lebarBtn.substr(0, lebarBtn.indexOf('px')));
        $('#list-action-2').css('left', $(this).offset().left - $('#modal-list-catatan-item .modal-body').offset().left - lebarList + lebarBtn + lebarTambahan);
        let tinggiBtn = $(this).css('height');
        let tinggiHeader = 0;
        tinggiBtn = parseInt(tinggiBtn.substr(0, tinggiBtn.indexOf('px')));
        $('#list-action-2').css('top', $(this).offset().top - $('#modal-list-catatan-item .modal-body').offset().top + tinggiBtn + tinggiHeader);
        $('#list-action-2').show();
        btnItemNoteId = $(this).closest('tr').attr('id');
        flag = true;
    });

    $(document).on('click', function() {
        setTimeout(function (){
            if (flag) {
                flag = !flag;
            } else {
                if ($('#list-action-2').css('display') == 'block') {
                    $('#list-action-2').hide();
                }
            }
        }, 10);
    });

    $('#action-detail').on('click', function() {
        $('#catatan-item-name').text(currentlySelectedItemName);
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

    $('#table-catatan-item').on('click', '#add-catatan-item',function() {
        $('#catatan-item-name').text(currentlySelectedItemName);

        $('#penulis-catatan-item').parent().hide();
        $('#penulis-catatan-item').removeClass('disabled');
        $('#catatan-item').removeClass('disabled');
        $('#input-foto-item').show();
        $('#tab-noda').removeClass('disabled');

        $('#penulis-catatan-item').val('');
        $('#catatan-item').val('');
        let temp = $('#container-image-item').find('.carousel-item').eq(0).detach();
        $('#container-image-item').find('.carousel-inner').empty();
        if (!temp.hasClass('active')) {
            temp.addClass('active');
        }
        temp.find('img').removeAttr("src");
        temp.appendTo('#container-image-item .carousel-inner');
        $('#input-foto-item').val('');

        $('#modal-catatan-item .modal-footer').show();
        $('#modal-catatan-item').modal('show');
    });

    $('#input-foto-item').on('change', function() {
        for (let index = 0; index < this.files.length; index++) {
            if (index == 0) {
                $('#container-image-item').find('.carousel-item').eq(index).find('img').attr('src', window.URL.createObjectURL(this.files[index]));
            } else {
                $('#container-image-item').find('.carousel-item').eq(index - 1).clone().appendTo("#container-image-item .carousel-inner");
                $('#container-image-item').find('.carousel-item').eq(index).removeClass('active').find('img').attr('src', window.URL.createObjectURL(this.files[index]));
            }
        }
    });

    $('#simpan-catatan-item').on('click', function() {
        if ($('#form-catatan')[0].checkValidity()) {
            $(this).addClass('disabled');

            let formData = new FormData();
            formData.append('item_transaksi_id', currentlySelectedItemTransactionID);
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
            $('#form-catatan')[0].reportValidity()
        }
    });

    $('#action-delete-note').on('click', function() {
        if (confirm('Hapus catatan item ?')) {
            $.ajax({
                url: "/transaksi/item/note/" + btnItemNoteId + "/delete",
            }).done(function(response) {
                if (response.status == '200') {
                    $('#table-catatan-item').load(window.location.origin + '/component/note/' + currentlySelectedItemTransactionID);
                }
            });
        }
    });

    $('#formCheck-express').on('change', function() {
        let formData = new FormData();
        formData.append('express', $(this).val());

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "/transaksi/express/" + transId,
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).done(function() {
            $('#table-container').load(window.location.origin + '/component/transBucket/' + transId, function() {
                setThousandSeparator();
            });
        }).fail(function(message) {
            console.log(message);
        });
    });

    $('#formCheck-setrika').on('change', function() {
        let formData = new FormData();
        formData.append('setrika_only', $(this).val());

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "/transaksi/setrika_only/" + transId,
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).done(function() {
            $('#table-container').load(window.location.origin + '/component/transBucket/' + transId, function() {
                setThousandSeparator();
            });
        }).fail(function(message) {
            console.log(message);
        });
    });

    $('#cancel-trans').on('click', function() {
        if (confirm('Yakin membatalkan transaksi ?')) {
            $.ajax({
                url: "/transaksi/" + transId + "/cancel",
            }).done(function() {
                window.location = window.location.origin + window.location.pathname;
            });
        }
    });

    $('#print-tanda-terima').on('click', function() {
        window.location = window.location.origin + '/printTandaTerima/' + $('#id-trans').text();
    });

    function getActivePromo(showModal) {
        $.ajax({
            url: "/diskon-transaksi/" + transId,
        }).done(function(response) {
            if (response.data.length != 0) {
                $('#diskon-1 .kode-diskon').data('id', response.data[0].id);
                $('#diskon-1 .kode-diskon').text(response.data[0].diskon.code);
                if (response.data[0].diskon.jenis_diskon == "exact") {
                    $('#diskon-1 .info-diskon').text("Rp " + response.data[0].diskon.nominal.toLocaleString(['ban', 'id']));
                } else if (response.data[0].diskon.jenis_diskon == "percentage") {
                    if (response.data[0].diskon.maximal_diskon != 0) {
                        $('#diskon-1 .info-diskon').text(response.data[0].diskon.nominal + " % - Max Rp " + response.data[0].diskon.maximal_diskon.toLocaleString(['ban', 'id']));
                    } else {
                        $('#diskon-1 .info-diskon').text(response.data[0].diskon.nominal + " %");
                    }
                } else {
                    console.log('tipe diskon : ' + response.data[0].diskon.jenis_diskon)
                }
                $('#diskon-2').hide();
                if (response.data.length == 2) {
                    $('#diskon-2 .kode-diskon').data('id', response.data[1].id);
                    $('#diskon-2 .kode-diskon').text(response.data[1].diskon.code);
                    if (response.data[1].diskon.jenis_diskon == "exact") {
                        $('#diskon-2 .info-diskon').text("Rp " + response.data[1].diskon.nominal.toLocaleString(['ban', 'id']));
                    } else if (response.data[1].diskon.jenis_diskon == "percentage") {
                        if (response.data[1].diskon.maximal_diskon != 0) {
                            $('#diskon-2 .info-diskon').text(response.data[1].diskon.nominal + " % - Max Rp " + response.data[1].diskon.maximal_diskon.toLocaleString(['ban', 'id']));
                        } else {
                            $('#diskon-2 .info-diskon').text(response.data[1].diskon.nominal + " %");
                        }
                    } else {
                        console.log('tipe diskon : ' + response.data[1].diskon.jenis_diskon);
                    }
                    $('#diskon-2').show();
                }
                $('#active-promo').show();
            } else {
                $('#active-promo').hide();
            }
            if (showModal) {
                $('#modal-kode-promo').modal('show');
            }
        });
    }

    $('#kode-promo').on('click', function() {
        getActivePromo(true);
    });

    $('#btn-apply-promo-basic').on('click', function() {
        let formData = new FormData();
        formData.append('transaksi_id', transId);
        formData.append('code', $('#input-kode-diskon').val());

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "/diskon-transaksi",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).done(function(response) {
            if (response.status == '200') {
                getActivePromo(false);
                $('#table-container').load(window.location.origin + '/component/transBucket/' + transId, function() {
                    setThousandSeparator();
                });
                alert('Diskon berhasil ditambahkan');
            } else {
                alert(response.message);
            }
        }).fail(function(message) {
            alert('error');
            console.log(message);
        });
    });

    $('.cancel-diskon').on('click', function() {
        $.ajax({
            url: "/diskon-transaksi/" + $(this).prev().find('.kode-diskon').data('id') + "/delete",
        }).done(function(response) {
            getActivePromo(false);
            $('#input-kode-diskon').val("");
            $('#table-container').load(window.location.origin + '/component/transBucket/' + transId, function() {
                setThousandSeparator();
            });
        }).fail(function(response) {
            console.log(response);
        });
    });
    //     if (parseInt($(this).val()) > parseInt($(this).attr('max'))) {
    //         $(this).val($(this).attr('max'));
    //     }
    // });

    // $('#btn-authenticate-login').on('click', function() {
    //     let formData = new FormData();
    //     formData.append('username', $('#input-username-auth').val());
    //     formData.append('password', $('#input-password-auth').val());

    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //         },
    //         url: "/transaksi/diskon/autentikasi",
    //         method: "POST",
    //         contentType: false,
    //         processData: false,
    //         data: formData,
    //     }).done(function(data) {
    //         $('#div-promo-spesial').prev().addClass('d-none').removeClass('d-flex');
    //         $('#div-promo-spesial').removeClass('d-none').addClass('d-flex');

    //     }).fail(function(message) {
    //         alert('error');
    //         console.log(message);
    //     });
    // });

    // $('#btn-apply-promo-spesial').on('click', function() {
    //     $('#input-nominal-promo').val(removeDot($('#input-nominal-promo').val()));
    //     $.ajax({
    //         url: "/transaksi/diskon/special/transaksi/" + transId + "/nominal/" + $('#input-nominal-promo').val(),
    //     }).done(function() {
    //         window.location = window.location.origin + window.location.pathname;
    //     }).fail(function(message) {
    //         alert('error');
    //         console.log(message);
    //     });
    // });

    // Pembayaran

    $('#nav-pembayaran').on('click', function() {
        $.ajax({
            url: "/transaksi/detail/" + transId,
        }).done(function(data) {
            let trans = data;
            $('.kode-trans').text(trans.kode);
            $('#pembayaran-subtotal').html(trans.subtotal);
            $('#pembayaran-diskon').html(trans.total_diskon_promo + trans.diskon_jenis_item + trans.diskon_member);
            $('#pembayaran-grand-total').html(trans.grand_total);

            $('#table-pembayaran tbody').empty();
            let items = trans.item_transaksi;
            items.forEach(item => {
                let temp = "<td colspan='2' class='text-center'>" + parseFloat(item.bobot_bucket) + "</td>";
                $('#table-pembayaran tbody').append(
                    "<tr id='item-" + item.jenis_item_id + "'>" +
                        "<td>" + item.nama + "</td>" +
                        "<td class='text-center'>" + item.nama_kategori + "</td>" +
                        temp +
                    "</tr>"
                );
            });

            if (trans.diskon + trans.diskon_member == 0) {
                $('#pembayaran-diskon').parent().hide();
            } else {
                $('#pembayaran-diskon').parent().show();
            }
            setThousandSeparator();

            if (trans.lunas) {
                $('#btn-bayar').hide();
            } else {
                $('#btn-bayar').show();
            }

            $('#modal-detail-trans').modal('show');

            $('#input-trans-id').val(trans.id);
            $('#input-total').val((trans.grand_total - trans.total_terbayar).toLocaleString(['ban', 'id']));
            $('#input-terbayar').val(trans.total_terbayar.toLocaleString(['ban', 'id']));
            $('#input-kembalian').val('0');
        });
    });

    $('#btn-bayar').on('click', function() {
        setThousandSeparator();
        $('#modal-pembayaran').modal('show');
    });

    $('#btn-print').on('click', function() {
        if (transId == 0) {
            alert("Belum memilih transaksi, tidak bisa menampilkan nota");
        } else {
            window.location = window.location.origin + "/printNota/" + transId;
        }
    });

    var calculateNow;
    $('#input-nominal').on('input', function() {
        clearTimeout(calculateNow);
        if (!$('#btn-save').hasClass('disabled')) {
            $('#btn-save').addClass('disabled');
        }
        calculateNow = setTimeout(calculate, 1000);
    });

    function calculate() {
        let total = removeDot($('#input-total').val());

        let nominal = $('#input-nominal').val() === '' ? 0 : removeDot($('#input-nominal').val());
        let terbayar = removeDot($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(8)').find('.thousand-separator').text());
        if (total > terbayar + nominal) {
            $('#input-kembalian').val('0');
        } else {
            $('#input-kembalian').val((nominal - total).toLocaleString(['ban', 'id']));
        }
        $('#btn-save').removeClass('disabled');
    }

    function removeDot(val) {
        if (val != '') {
            while(val.indexOf('.') != -1) {
                val = val.replace('.', '');
            }
            let number = parseInt(val);
            return number;
        }
    }

    $('#form-pembayaran').on('submit', function(e) {
        e.preventDefault();

        $(this).find('button[type="submit"]').addClass('disabled');

        let formData = new FormData();
        formData.append('transaksi_id', $('#input-trans-id').val());
        formData.append('metode_pembayaran', $('#input-metode-pembayaran').val());
        formData.append('nominal', removeDot($('#input-nominal').val()) - removeDot($('#input-kembalian').val()));

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "/transaksi/pembayaran",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).done(function(response) {
            alert("Pembayaran berhasil");
            window.location = window.location;
        }).fail(function(message) {
            console.log(message);
        });
    });

    $('#nav-log').on('click', function() {
        $.ajax({
            url: "/transaksi/" + transId + "/log",
        }).done(function(response) {
            console.log(response);
            $('#table-log tbody').empty();
            response.logs.forEach(function(log, index) {
                console.log(log);
                $('#table-log tbody').append("<tr><td class='text-center'>" + log.created_at.replace('T',' ').substring(0, log.created_at.indexOf('.')) + "</td><td class='text-center'>" + log.penanggung_jawab + "</td><td>" + log.process + "</td></tr>");
            });
        });
    });
});
