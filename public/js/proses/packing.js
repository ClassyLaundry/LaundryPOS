$(document).ready(function() {
    var btnIndex = -1, btnId = 0, tipeTrans = '';
    $('#container-list-trans').on('click', '.btn-show-action', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
        tipeTrans = $(this).closest('tr').children().eq(1).text().toLowerCase();
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

    $('#action-detail').on('click', function() {
        $('#container-bucket').empty();
        $('#container-premium').empty();
        if (tipeTrans == 'bucket') {
            $('#container-bucket').load(window.location.origin + '/component/shortTrans/' + btnId, function() {
                $('#container-bucket').find('.column-action').detach();
                $('#container-bucket').find('.cell-action').detach();
                $('#modal-detail').modal('show');
            });
        } else {
            $('#container-premium').load(window.location.origin + '/component/shortTrans/' + btnId, function() {
                $('#container-premium').find('.column-action').detach();
                $('#container-premium').find('.cell-action').detach();
                $('#modal-detail').modal('show');
            });
        }
    });

    $('#action-kemas').on('click', function() {
        $('#table-container-' + tipeTrans).load(window.location.origin + '/component/packing/' + btnId + '/' + tipeTrans, function() {
            $('#modal-packing-' + tipeTrans).modal('show');
        });
    });

    searchListTrans();
    var searchTrans;
    $('#input-nama-pelanggan').on('input', function() {
        clearTimeout(searchTrans);
        searchTrans = setTimeout(searchListTrans, 2000);
    });

    function searchListTrans() {
        $('#container-list-trans').load(window.location.origin + '/component/packing?key=' + encodeURIComponent($('#input-nama-pelanggan').val()), function() {
            setThousandSeparator();
        });
    }

    $('#form-packing-bucket').on('submit', function(e) {
        e.preventDefault();

        let inventories = [];
        inventories.push({
            inventory_id: $('#table-container-bucket #input-inventory').val(),
            qty: $('#table-container-bucket #input-inventory-qty').val(),
        });

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

    $('#form-packing-premium').on('submit', function(e) {
        e.preventDefault();

        let inventories = [];
        for (let i = 0; i < $('.input-inventory').length; i++) {
            inventories.push({
                inventory_id: $('.input-inventory').eq(i).val(),
                qty: 1,
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
