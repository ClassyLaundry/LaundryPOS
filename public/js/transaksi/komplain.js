$(document).ready(function() {

    var searchKomplain, komplainKey = '', komplainPage = 1;
    $('#input-search-komplain').on('input', function() {
        komplainPage = 1;
        clearTimeout(searchKomplain);
        searchKomplain = setTimeout(getKomplainList, 1000);
    });

    function getKomplainList() {
        komplainKey = $('#input-search-komplain').val();
        console.log(komplainKey);
        $('#container-list-komplain').load(window.location.origin + '/component/komplain?key=' + encodeURIComponent(komplainKey) + '&page=' + komplainPage);
    }

    getKomplainList();

    $('#action-resolve').on('click', function() { // masih belum dipakai
        if (confirm('Yakin menyelesaikan komplain transaksi ?')) {
            $.ajax({
                url: "/transaksi/komplain/" + btnId + "/resolve",
            }).done(function() {
                window.location = window.location.origin + window.location.pathname;
            });
        }
    });

    // List transaksi
    var searchTrans, transKey = '', transPage = 1;
    $('#input-search-trans').on('input', function() {
        transPage = 1;
        clearTimeout(searchTrans);
        searchTrans = setTimeout(searchListTrans, 1000);
    });

    function searchListTrans() {
        transKey = $('#input-search-trans').val();
        $('#container-list-trans').load(window.location.origin + '/transaksi/komplain/searchTransaksi?key=' + encodeURIComponent(transKey) + '&page=' + transPage, function() {
            $('#modal-list-transaksi').modal("show");
        }); // transaksi yang dicari harus sudah terconfirmed
    }

    $('#container-list-trans').on('click', '.page-link', function(e) {
        e.preventDefault();
        transPage = $(this).attr('href').split('page=')[1];
        searchListTrans();
    });
    // #

    $('#btn-add-komplain').on('click', function() {
        searchListTrans();
    });

    var transId = 0, transCode = '', customerName = '';
    $('#container-list-trans').on('click', 'tr', function() {
        transId = $(this).attr('id');
        transCode = $(this).children().eq(0).text();
        customerName = $(this).children().eq(3).text();

        $('#kode-transaksi').text(transCode);
        $('#input-kode').val(transCode);
        $('#input-pelanggan').val(customerName);
        $('#input-komplain').val('');
        $('#input-id_transaksi').val(transId);

        $('#modal-list-transaksi').modal("hide");
        $('#modal-add-komplain').modal("show");
    });

    $('#btn-back-komplain').on('click', function() {
        $('#modal-add-komplain').modal("hide");
        $('#modal-list-transaksi').modal("show");
    });
});
