$(document).ready(function() {
    $('.btn-toggle').on('click', function() {
        let icon = $(this).children();
        if (icon.hasClass('fa-down-left-and-up-right-to-center')) {
            icon.removeClass('fa-down-left-and-up-right-to-center');
            icon.addClass('fa-up-right-and-down-left-from-center');
            icon.closest('div').next().hide();
        } else {
            icon.removeClass('fa-up-right-and-down-left-from-center');
            icon.addClass('fa-down-left-and-up-right-to-center');
            icon.closest('div').next().show();
        }
    });

    var btnIndex = -1, btnId = 0, currentlySelectedType = '', pelangganId = 0, orderId = 0;
    $('.btn-show-action').on('click', function() {
        btnIndex = $(this).index('.btn-show-action') + 1;
        btnId = $(this).closest('.border.rounded').data('transaksi');
        pelangganId = $(this).closest('.border.rounded').find('.pelanggan-id').val();
        if ($(this).closest('.card-pickup').length == 1) {
            currentlySelectedType = "pickup";
            orderId = $(this).closest('.border.rounded').attr('id').substr(7);
            $('#action-detail').hide();
            $('#action-print-memo').hide();
        } else if ($(this).closest('.card-delivery').length == 1) {
            currentlySelectedType = "delivery";
            orderId = $(this).closest('.border.rounded').attr('id').substr(9);
            $('#action-detail').show();
            $('#action-print-memo').show();
        }
    });

    $('#action-print-memo').on('click', function() {
        window.location = window.location.origin + "/printMemoProduksi/" + btnId;
    });

    $('#action-pesan').on('click', function() {
        $('.btn-show-action').eq(btnIndex - 1).closest('.rounded').siblings('.pesan-pelanggan').toggle();
    });

    $('#action-pelanggan').on('click', function() {
        window.location = window.location.origin + "/data/pelanggan/" + pelangganId + '/detail';
    });

    $('#action-change-status').on('click', function() {
        if (currentlySelectedType == "pickup") {
            if (confirm('Nyatakan ' + currentlySelectedType + ' selesai ?') == true) {
                $.ajax({
                    url: "/transaksi/pickup-delivery/" + orderId + "/is-done",
                }).done(function(data) {
                    window.location = window.location.origin + window.location.pathname;
                });
            }
        } else if(currentlySelectedType == "delivery") {
            $('.kode-transaksi').text($('h6').eq(btnIndex).text());
            $('#modal-konfirmasi-pengiriman').modal('show');
        }
    });

    $('#form-penerimaan').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData();
        formData.append('transaksi_id', btnId);
        formData.append('ambil_di_outlet', 0);
        formData.append('penerima', $('#input-nama-penerima').val());

        // Get the uploaded image file
        const imageFile = $('#input-foto-penerima').prop("files")[0];

        // Check if file needs resizing (> 2MB)
        if (imageFile && imageFile.size > 2 * 1024 * 1024) {
            alert('File harus lebih kecil dari 2MB');
            // Create canvas and context for resizing
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            // Create an image object to load the file
            const img = new Image();
            img.onload = function() {
                // Set max dimensions
                const maxWidth = 800;
                const maxHeight = 800;

                // Calculate new dimensions while maintaining aspect ratio
                let width = img.width;
                let height = img.height;
                if (width > height) {
                    if (width > maxWidth) {
                        height *= maxWidth / width;
                        width = maxWidth;
                    }
                } else {
                    if (height > maxHeight) {
                        width *= maxHeight / height;
                        height = maxHeight;
                    }
                }

                // Resize image
                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                // Convert to blob
                canvas.toBlob(function(blob) {
                    formData.append('image', blob, imageFile.name);
                    submitForm(formData);
                }, 'image/jpeg', 0.7); // Convert to JPEG with 70% quality
            };

            // Load the image file
            img.src = URL.createObjectURL(imageFile);
        } else {
            // If file is under 2MB, append original file
            formData.append('image', imageFile);
            submitForm(formData);
        }

        function submitForm(formData) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "/transaksi/penerima",
                method: "POST",
                contentType: false,
                processData: false,
                data: formData,
            }).done(function() {
                $.ajax({
                    url: "/transaksi/pickup-delivery/" + orderId + "/is-done",
                }).done(function(data) {
                    alert("data berhasil disimpan");
                    window.location = window.location.origin + window.location.pathname;
                });
            }).fail(function(message) {
                alert('error');
                // alert(JSON.stringify(message));
                console.log(message);
            });
        }
    });

    $('#action-detail').on('click', function() {
        $('.kode-transaksi').text($('h6').eq(btnIndex).text());

        $('#table-short-trans').load(window.location.origin + '/component/shortTrans/' + btnId + '/delivery', function() {
            $('#text-catatan-transaksi').text($('#table-short-trans #catatan-transaksi').val());
            $('#text-catatan-pelanggan').text($('#table-short-trans #catatan-pelanggan').val());
            $('#table-short-trans').find('.cell-action').detach();
            $.ajax({
                url: "/transaksi/detail/" + btnId,
            }).done(function(data) {
                if (data.lunas) {
                    $('#status-transaksi').text('Lunas');
                    $('#tagihan-transaksi').parent().addClass('invisible');
                } else {
                    $('#status-transaksi').text('Belum lunas');
                    $('#tagihan-transaksi').text(data.grand_total - data.total_terbayar);
                    setThousandSeparator();
                    $('#tagihan-transaksi').parent().removeClass('invisible');
                }
            });
        });

        $('#kode-trans').text($('.btn-show-action').eq(btnIndex - 1).prev().find('h4').text());
        $('#modal-transaksi').modal('show');
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
