$(document).ready(function() {
    var btnIndex = -1, btnId = 0;
    $('#container-list-trans').on('click', '.btn-show-action', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
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

    $('#action-restore').on('click', function() {
        if (confirm('Yakin memulihkan transaksi ?')) {
            $.ajax({
                url: "/transaksi/" + btnId + "/restore",
            }).done(function() {
                window.location = window.location.origin + window.location.pathname;
            });
        }
    });

    searchListTrans();
    var searchTrans;
    $('#input-nama-pelanggan').on('input', function() {
        clearTimeout(searchTrans);
        searchTrans = setTimeout(searchListTrans, 2000);
    });

    function searchListTrans() {
        $('#container-list-trans').load(window.location.origin + '/component/cancelled?key=' + encodeURIComponent($('#input-nama-pelanggan').val()), function() {
            setThousandSeparator();
        });
    }
});
