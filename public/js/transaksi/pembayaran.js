$(document).ready(function() {
    // btnIndex untuk menyimpan currently selected row
    // btnId untuk menyimpan item id dari selected row
    var btnIndex = -1, btnId = 0;
    $('.btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
    });

    // untuk menampilkan nota
    $('#action-detail').on('click', function() {
        $('#diskon').parent().show();
        $.ajax({
            url: "/transaksi/detail/" + btnId,
        }).done(function(data) {
            let trans = data;
            $('.kode-trans').text(trans.kode);
            $('#subtotal').html(trans.subtotal);
            $('#diskon').html(trans.diskon + trans.diskon_member);
            $('#grand-total').html(trans.grand_total);

            let items = trans.item_transaksi;
            items.forEach(item => {
                let temp = "<td>Rp</td><td class='text-end'>" + item.harga_premium + "</td>";
                if (item.harga_premium == 0) {
                    temp = "<td colspan='2' class='text-center'>" + parseFloat(item.bobot_bucket) + "</td>";
                }
                $('#table-item-transaksi tbody').append(
                    "<tr id='item-" + item.jenis_item_id + "'>" +
                        "<td>" + item.nama + "</td>" +
                        "<td class='text-center'>" + item.nama_kategori + "</td>" +
                        temp +
                    "</tr>"
                );
            });

            if (trans.diskon + trans.diskon_member == 0) {
                $('#diskon').parent().hide();
            }
            setThousandSeparator();

            if (trans.lunas) {
                $('#btn-bayar').hide();
            } else {
                $('#btn-bayar').show();
            }

            $('#modal-detail-trans').modal('show');

            $('#input-trans-id').val(trans.id);
            $('#input-total').val(trans.grand_total);
            $('#input-terbayar').val(trans.total_terbayar);
            $('#input-kembalian').val('0');
        });
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

    $('#btn-bayar').on('click', function() {
        setThousandSeparator();
        $('#modal-pembayaran').modal('show');
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

        let nominal = removeDot($('#input-nominal').val());
        let terbayar = removeDot($('tbody tr:nth-child(' + btnIndex + ') td:nth-child(7)').html());
        if (total > terbayar + nominal) {
            $('#input-terbayar').val((terbayar + nominal).toLocaleString(['ban', 'id']));
            $('#input-kembalian').val(0);
        } else {
            $('#input-terbayar').val((total).toLocaleString(['ban', 'id']));
            $('#input-kembalian').val((terbayar + nominal - total).toLocaleString(['ban', 'id']));
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
        e.preventDefault;
        $('#input-nominal').val(removeDot($('#input-nominal').val()));
        $(this).submit();
    });
});
