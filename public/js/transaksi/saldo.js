$(document).ready(function() {
    var selectedPaketId = 0;
    $('#paket-container .card').on('click', function() {
        $('#paket-container .card').removeClass('selected');

        selectedPaketId = $(this).attr('id');
        $(this).addClass('selected');
        if ($('#submit-saldo').prop('disabled')) {
            $('#submit-saldo').prop('disabled', false);
        }

        if (selectedPaketId != 1) {
            $('#input-dibayarkan').val(removeDot($('#paket-container .card.selected .harga-paket .thousand-separator').text()).toLocaleString(['ban', 'id']));
        } else {
            $('#input-dibayarkan').val(parseInt($('#paket-container .card.selected #input-manual').val()).toLocaleString(['ban', 'id']));
        }
    });

    $('#input-manual').on('input', function() {
        if ($(this).val() != "") {
            $('#input-dibayarkan').val(parseInt($(this).val()).toLocaleString(['ban', 'id']));
        }
    });

    $('#pilih-pelanggan').on('click', function() {
        $('#modal-data-pelanggan').modal('show');
    });

    var pelangganId = 0;
    $('#table-pelanggan').load(window.location.origin + '/component/pelanggan?paginate=5', function() {
        $('#table-pelanggan th:last').hide();
        $('#table-pelanggan .cell-action').hide();
    });
    $('#table-pelanggan').on('click', '.page-link', function(e) {
        e.preventDefault();
        $('#table-pelanggan').load($(this).attr('href'));
    });

    function search() {
        $('#table-pelanggan').load(window.location.origin + '/component/pelanggan?key=' + encodeURIComponent($('#input-nama-pelanggan').val()) + '&filter=nama&paginate=5', function() {
            $('#table-pelanggan th:last').hide();
            $('#table-pelanggan .cell-action').hide();
        });
    }

    var searchPelanggan;
    $('#input-nama-pelanggan').on('input', function() {
        clearTimeout(searchPelanggan);
        searchPelanggan = setTimeout(searchListPelanggan, 2000);
    });

    function searchListPelanggan() {
        search();
    }

    $('#table-pelanggan').on('click', 'tr', function() {
        pelangganId = $(this).attr('id').substr(10);

        let tempNama = $(this).find('td').eq(1).html();
        $.ajax({
            url: "/pelanggan/" + pelangganId + "/check-saldo",
        }).done(function(data) {
            $('#data-nama-pelanggan').val(tempNama);
            $('#data-saldo-akhir').val(parseInt(data.saldo).toLocaleString(['ban', 'id']));

            if ($('#submit-saldo').css('display') == 'none') {
                $('#submit-saldo').show();
            }
            $('#modal-data-pelanggan').modal('hide');

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        });
    });

    $('#form-saldo').on('submit', function(e) {
        e.preventDefault();

        if (selectedPaketId != 0) {
            $.ajax({
                url: "/data/pelanggan/" + pelangganId + "/detail",
            }).done(function(data) {
                let member = data.member;

                $.ajax({
                    url: "/pelanggan/" + pelangganId + "/check-saldo",
                }).done(function(data) {
                    let saldo = data.saldo;

                    if (saldo >= 100000) {
                        $('#alert-saldo').addClass('d-none');
                    } else {
                        $('#alert-saldo').removeClass('d-none');
                    }

                    if (member) {
                        $('#alert-member').addClass('d-none');
                    } else {
                        $('#alert-member').removeClass('d-none');
                    }

                    $('#input-total').val($('#input-dibayarkan').val());

                    setThousandSeparator();
                    $('#modal-pembayaran').modal('show');
                });
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }
    });

    $('#btn-save').on('click', function(e) {
        e.preventDefault();
        $('#btn-save').addClass('disabled');

        let nominal;
        if (selectedPaketId == 1) {
            nominal = $('#input-manual').val();
        } else {
            nominal = removeDot($('#paket-container .card.selected .nominal-paket .thousand-separator').text());
        }
        let metode_pembayaran = $('#input-metode_pembayaran').val();
        let saldoAkhir = nominal + removeDot($('#data-saldo-akhir').val());

        if (nominal == 0) {
            alert('nominal yang di isikan tidak boleh 0');
        } else {
            let formData = new FormData();
            formData.append('pelanggan_id', pelangganId);
            formData.append('paket_deposit_id', selectedPaketId);
            formData.append('nominal', nominal);
            formData.append('jenis_input', 'deposit');
            formData.append('via', metode_pembayaran);
            formData.append('saldo_akhir', saldoAkhir);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "/pelanggan/" + pelangganId + "/add-saldo",
                method: "POST",
                contentType: false,
                processData: false,
                data: formData,
            }).done(function() {
                alert('Pengisian saldo berhasil');
                location.reload();

            }).fail(function(message) {
                alert('error');
                console.log(message.responseJSON.message);
            });
        }
    });

    function removeDot(val) {
        if (val != '') {
            while(val.indexOf('.') != -1) {
                val = val.replace('.', '');
            }
            let number = parseInt(val);
            return number;
        }
    }

    function adjustWindow() {
        if ($(window).width() < 992) {
            $('#info-pelanggan').removeClass('border-start');
        } else {
            $('#info-pelanggan').addClass('border-start');
        }
    }

    $(window).on('resize', function() {
        adjustWindow();
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
        if (total > nominal) {
            $('#input-kembalian').val(0);
        } else {
            $('#input-kembalian').val((nominal - total).toLocaleString(['ban', 'id']));
        }
        $('#btn-save').removeClass('disabled');
    }
});
