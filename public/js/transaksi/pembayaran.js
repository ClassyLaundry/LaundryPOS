$(document).ready(function() {
    if($('#list-action').children().length == 0) {
        $('#list-action').detach();
    }
    var btnIndex = -1, btnId = 0;
    $('.btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).attr('id').substring(4);
        $('#form-cetak-kitir').attr('action', '/printKitir/' + btnId);
        $('#kode-trans-kitir').text($(this).closest('tr').children().eq(0).text());
    });

    $('#action-detail').on('click', function() {
        $('#diskon').parent().show();
        $.ajax({
            url: "/transaksi/detail/" + btnId,
        }).done(function(data) {
            let trans = data;
            $('.kode-trans').text(trans.kode);
            $('#subtotal').html(trans.subtotal);
            $('#diskon').html(trans.subtotal - trans.grand_total);
            $('#grand-total').html(trans.grand_total);
            $('#table-item-transaksi tbody').empty();

            let items = trans.item_transaksi;
            if (trans.tipe_transaksi == "bucket") {
                items.forEach(item => {
                    $('#table-item-transaksi tbody').append(
                        "<tr id='item-" + item.jenis_item_id + "'>" +
                            "<td>" + item.nama + "</td>" +
                            "<td class='text-center'>" + item.nama_kategori + "</td>" +
                            "<td colspan='2' class='text-center'>" + parseFloat(item.bobot_bucket) + "</td>" +
                        "</tr>"
                    );
                });
            } else if (trans.tipe_transaksi == "premium") {
                items.forEach(item => {
                    $('#table-item-transaksi tbody').append(
                        "<tr id='item-" + item.jenis_item_id + "'>" +
                            "<td>" + item.nama + "</td>" +
                            "<td class='text-center'>" + item.nama_kategori + "</td>" +
                            "<td>Rp</td><td class='text-end'>" + item.harga_premium.toLocaleString(['ban', 'id']) + "</td>" +
                        "</tr>"
                    );
                });
            }

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
            $('#input-total').val(trans.grand_total.toLocaleString(['ban', 'id']));
            $('#input-terbayar').val(trans.total_terbayar.toLocaleString(['ban', 'id']));
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

    var pelangganSaldo = 0;
    $('#btn-bayar').on('click', function() {
        pelangganSaldo = 0;
        $.ajax({
            url: "/transaksi/detail/" + btnId,
        }).done(function(data) {
            let pelanggan = data.pelanggan;
            $.ajax({
                url: "/pelanggan/" + pelanggan.id + "/check-saldo",
            }).done(function(data) {
                let saldo = data.saldo;
                pelangganSaldo = saldo;
                let total = removeDot($('#input-total').val());

                $('#input-saldo-pelanggan').val(saldo);

                if (saldo != 0) {
                    $('#input-metode-pembayaran option[value=deposit]').removeAttr('disabled');
                    $('#input-metode-pembayaran').val('deposit');
                    $('#input-metode-pembayaran').trigger('change');
                    if (saldo >= total) {
                        $('#input-nominal').val(total.toLocaleString(['ban', 'id']));
                    } else {
                        $('#input-nominal').val(saldo.toLocaleString(['ban', 'id']));
                    }
                } else {
                    $('#input-metode-pembayaran option[value=deposit]').attr('disabled','disabled');
                }

                if (saldo >= 100000) {
                    $('#alert-saldo').alert('close');
                }
                if (pelanggan.member) {
                    $('#alert-member').alert('close');
                }

                setThousandSeparator();
                $('#modal-pembayaran').modal('show');
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        });
    });

    $('#input-metode-pembayaran').on('change', function() {

        if ($(this).val() == "deposit") {
            $('#input-nominal').attr('disabled','disabled');

            let total = removeDot($('#input-total').val());
            if (pelangganSaldo >= total) {
                $('#input-nominal').val(total.toLocaleString(['ban', 'id']));
            } else {
                $('#input-nominal').val(pelangganSaldo.toLocaleString(['ban', 'id']));
            }
        } else {
            $('#input-nominal').removeAttr('disabled');
            $('#input-nominal').val(0);
        }
    });

    $('#action-print-nota').on('click', function() {
        window.location = window.location.origin + "/printNota/" + btnId;
    });

    $('#action-print-memo').on('click', function() {
        window.location = window.location.origin + "/printMemoProduksi/" + btnId;
    });

    $('#action-print-kitir').on('click', function() {
        $.ajax({
            url: "/transaksi/detail/" + btnId,
        }).done(function(data) {
            let trans = data;
            let total_qty = 0;
            trans['item_transaksi'].forEach(function(item) {
                total_qty += item['qty'];
            });
            $('#input-cetak').val(total_qty);
            $('#modal-cetak-kitir').modal('show');
        });
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
        e.preventDefault();

        let formData = new FormData();
        formData.append('transaksi_id', $('#input-trans-id').val());
        formData.append('metode_pembayaran', $('#input-metode-pembayaran').val());
        formData.append('nominal', removeDot($('#input-nominal').val()));

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
});
