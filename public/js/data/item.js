$(document).ready(function() {
    if ($('#table-item tbody').children().length == 0) {
        $('#table-item tbody').append('<tr><td colspan=16 class="text-center">Data masih kosong</td></tr>');
    }

    if($('#list-action').children().length == 0) {
        $('#list-action').detach();
    }
    var btnIndex = -1, btnId = 0;
    $('#data-item').on('click',  '.btn-show-action', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    $('#table-item').load(window.location.origin + '/component/jenis-item?key=' + $('#input-search').val() +'&paginate=5', function() {
        setThousandSeparator();
    });
    $('#data-item').on('click', '.page-link', function(e) {
        e.preventDefault();
        $('#table-item').load($(this).attr('href'));
    });
    var searchData, paginateCount = 5;
    $('#input-search').on('input', function() {
        clearTimeout(searchData);
        searchData = setTimeout(search, 2000);
    });

    function search() {
        $('#table-item').load(window.location.origin + '/component/jenis-item?key=' + encodeURIComponent($('#input-search').val()) +'&paginate=' + paginateCount, function() {
            setThousandSeparator();
        });
    }

    $("#dropdown-filter .dropdown-item").on('click', function() {
        paginateCount = parseInt($(this).data('paginate'));
        $("#dropdown-filter .dropdown-item").each(function(index, element) {
            $(element).removeClass('active');
        });
        $(this).addClass('active');
        search();
    });

    // untuk mereset tampilan modal & menampilkan modal
    $('#data-item .btn-tambah').on('click', function() {
        btnIndex = -1;
        $('#modal-form').attr('action', "/data/jenis-item");
        $('.modal-title').text('Tambah jenis item');

        $('#input-kategori').val('');
        $('#input-nama-item').val('');
        $('#input-unit').val('pcs');
        $('#input-bobot-bucket').val(0);
        $('#input-harga-kilo').val(0);
        $('#input-harga-bucket').val(0);
        $('#input-harga-premium').val(0);
        $('#input-beban-produksi').val(0);
        $('#input-diskon-item').val(0);
        $('#formCheck-kilo-aktif').attr('checked', true);
        $('#formCheck-kilo-tidakAktif').attr('checked', false);
        $('#formCheck-bucket-aktif').attr('checked', true);
        $('#formCheck-bucket-tidakAktif').attr('checked', false);
        $('#formCheck-premium-aktif').attr('checked', true);
        $('#formCheck-premium-tidakAktif').attr('checked', false);
        $('#formCheck-item-aktif').attr('checked', true);
        $('#formCheck-item-tidakAktif').attr('checked', false);
        $('#modal-form .modal-body .row .col-12:nth-child(13)').hide();

        $('#modal-update').modal('show');
    });

    $('#data-item #action-update').on('click', function() {
        $('#modal-form').attr('action', "/data/jenis-item/" + btnId);
        $('.modal-title').text('Rubah jenis item');

        $('#input-kategori').val($('#input-kategori option:contains(' + $('tbody tr:nth-child(' + btnIndex + ') td:nth-child(1)').html() + ')').val());
        $('#input-nama-item').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(2)').html());
        $('#input-unit').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(3)').html());
        $('#input-bobot-bucket').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(4)').html());
        $('#input-harga-kilo').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(7)').html());
        $('#input-harga-bucket').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(9)').html());
        $('#input-harga-premium').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(11)').html());
        $('#input-beban-produksi').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(12)').html());
        $('#input-diskon-item').val($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(14)').html());

        if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(15)').html() == "Aktif") {
            $('#formCheck-kilo-aktif').attr('checked', true);
        } else if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(15)').html() == "Tidak aktif") {
            $('#formCheck-kilo-tidakAktif').attr('checked', true);
        }
        if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(16)').html() == "Aktif") {
            $('#formCheck-bucket-aktif').attr('checked', true);
        } else if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(16)').html() == "Tidak aktif") {
            $('#formCheck-bucket-tidakAktif').attr('checked', true);
        }
        if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(17)').html() == "Aktif") {
            $('#formCheck-premium-aktif').attr('checked', true);
        } else if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(17)').html() == "Tidak aktif") {
            $('#formCheck-premium-tidakAktif').attr('checked', true);
        }
        if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(18)').html() == "Aktif") {
            $('#formCheck-item-aktif').attr('checked', true);
        } else if ($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(18)').html() == "Tidak aktif") {
            $('#formCheck-item-tidakAktif').attr('checked', true);
        }
        $('#modal-form .modal-body .row .col-12:nth-child(13)').show();

        $('#modal-update').modal('show');
    });

    // untuk menghapus data item
    $('#action-delete').on('click', function() {
        if (confirm('Yakin menghapus data ?')) {
            $.ajax({
                url: "/data/jenis-item/delete/" + btnId,
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

    function setThousandSeparator () {
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

});
