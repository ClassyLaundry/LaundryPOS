$(document).ready(function() {
    const id = $('#modal-form').attr('action').split('/')[3];
    $('#table-history-transaksi').load(window.location.origin + '/pelanggan/' + id + '/history/transaksi', function() {
        setThousandSeparator();
    });
    $('#table-history-saldo').load(window.location.origin + '/pelanggan/' + id + '/history/saldo?order=desc', function() {
        setThousandSeparator();
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

    $('#btn-ubah').on('click', function() {
        $('#modal-form input:disabled, #modal-form textarea:disabled').each(function(index, element) {
            $(element).attr('disabled', false);
        });
        $('#modal-form select:disabled').attr('disabled', false);
        $(this).hide();
        $(this).next().show();
    });

    $('#btn-bayar').on('click', function() {
        let val = $('#input-total').val();
        if (val != '') {
            while(val.indexOf('.') != -1) {
                val = val.replace('.', '');
            }
            let number = parseInt(val);
            $('#input-total').val(number.toLocaleString(['ban', 'id']));
        }
        $('#modal-pembayaran').modal('show');
    });

    var calculateNow;
    $('#input-nominal').on('input', function() {
        clearTimeout(calculateNow);
        if (!$('#btn-bayar').hasClass('disabled')) {
            $('#btn-bayar').addClass('disabled');
        }
        calculateNow = setTimeout(calculate, 1000);
    });

    function calculate() {
        let total = removeDot($('#input-total').val());

        let nominal = removeDot($('#input-nominal').val());
        if (total > nominal) {
            $('#input-kembalian').val(0);
        } else {
            $('#input-kembalian').val((nominal - total).toLocaleString(['ban', 'id']));
        }
        $('#btn-bayar').removeClass('disabled');
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

    $('#modal-pembayaran').on('submit', function(e) {
        e.preventDefault;
        $('#input-nominal').val(removeDot($('#input-nominal').val()));

        let formData = new FormData();
        formData.append('nominal', $('#input-nominal').val());
        formData.append('pelanggan_id', $('#input-pelanggan').val());

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "/transaksi/pembayaran-tagihan",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).done(function(data) {
            alert('Tagihan berhasil dibayar');
            window.location = window.location.origin + window.location.pathname;
        }).fail(function(message) {
            alert('error');
            console.log(message);
        });
    });
});
