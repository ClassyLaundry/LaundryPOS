$(document).ready(function() {
    var btnIndex = -1, btnId = 0, tipeTrans = '';
    $('.btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    $('#action-detail').on('click', function() {
        $('#container-bucket').empty();
        $('#container-premium').empty();
        if ($('tr:nth-child(' + btnIndex + ') td:nth-child(1)').html().includes('BU-')) {
            $('#container-bucket').load(window.location.origin + '/component/shortTrans/' + btnId, function() {
                tipeTrans = 'bucket';
                $('#modal-detail').modal('show');
            });
        } else {
            $('#container-premium').load(window.location.origin + '/component/shortTrans/' + btnId, function() {
                tipeTrans = 'premium';
                $('#modal-detail').modal('show');
            });
        }
    });

    $('#action-kemas').on('click', function() {
        $('#table-container').load(window.location.origin + '/component/packing/' + btnId, function() {
            $('#modal-packing').modal('show');
        });
    });

    $('#form-packing').on('submit', function(e) {
        e.preventDefault();

        let inventories = [], newData;
        for (let i = 0; i < $('.input-inventory').length; i++) {
            let currentInventory = $('.input-inventory').eq(i);
            let tempData = {
                inventory_id: currentInventory.val(),
                qty: 1,
            };
            newData = true;

            for (let j = 0; j < inventories.length; j++) {
                if (inventories[j].inventory_id == tempData.inventory_id) {
                    inventories[j].qty++;
                    newData = false;
                    break;
                }
            };

            if (newData) {
                inventories.push(tempData);
            }
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
            alert('success');
            window.location = window.location.origin + window.location.pathname;
        }).fail(function(message) {
            alert('error');
            console.log(message);
        });
    });
});
