$(document).ready(function() {
    if ($('#table-pelanggan tbody').children().length == 0) {
        $('#table-pelanggan tbody').append('<tr><td colspan=9 class="text-center">Data masih kosong</td></tr>');
    }

    if($('#list-action').children().length == 0) {
        $('#list-action').detach();
    }
    var btnIndex = -1, btnId = 0;
    $('#data-pelanggan').on('click', '.btn-show-action', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    $('#table-pelanggan').load(window.location.origin + '/component/pelanggan?paginate=5');
    $('#data-pelanggan').on('click', '.page-link', function(e) {
        e.preventDefault();
        $('#table-pelanggan').load($(this).attr('href'));
    });
    var searchData, searchFilter = 'nama', paginateCount = 5;
    $('#input-search').on('input', function() {
        clearTimeout(searchData);
        searchData = setTimeout(search, 2000);
    });

    function search() {
        $('#table-pelanggan').load(window.location.origin + '/component/pelanggan?key=' + encodeURIComponent($('#input-search').val()) + '&filter=' + searchFilter + '&paginate=' + paginateCount);
    }

    $("#dropdown-filter .filter-search").on('click', function() {
        searchFilter = $(this).data('search');
        $("#dropdown-filter .filter-search").each(function(index, element) {
            $(element).removeClass('active');
        });
        $(this).addClass('active');
    });

    $("#dropdown-filter .filter-paginate").on('click', function() {
        paginateCount = parseInt($(this).data('paginate'));
        $("#dropdown-filter .filter-paginate").each(function(index, element) {
            $(element).removeClass('active');
        });
        $(this).addClass('active');
        search();
    });

    // untuk mereset tampilan modal & menampilkan modal
    $('#data-pelanggan .btn-tambah').on('click', function() {
        btnIndex = -1;
        $('#modal-form').attr('action', "/data/pelanggan");
        $('.modal-title').text('Tambah pelanggan baru');

        $('#input-nama-pelanggan').val('');
        $('#input-alamat').val('');
        $('#input-tanggal-lahir').val('');
        $('#formCheck-member').attr('checked', false);
        $('#formCheck-non-member').attr('checked', true);
        $('#input-jenis-identitas').val('');
        $('#input-nomor-identitas').val('');
        $('#input-telepon').val('');
        $('#input-email').val('');
        $('#formCheck-aktif').attr('checked', true);
        $('#formCheck-tidakAktif').attr('checked', false);

        $('#modal-update').modal('show');
    });

    // untuk membuka detail pelanggan
    $('#data-pelanggan #action-detail').on('click', function() {
        window.location = window.location + '/' + btnId + '/detail';
    });

    // untuk menghapus data kategori
    $('#action-delete').on('click', function() {
        if (confirm('Yakin menghapus data ?')) {
            $.ajax({
                url: "/data/pelanggan/delete/" + btnId,
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
