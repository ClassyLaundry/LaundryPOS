$(document).ready(function() {
    $('.nav-items').each(function() {
        if ($(this).children().length == 0) {
            $(this).parent().detach();
        }
    });

    $('form').on('click', '.fas.fa-eye-slash', function() {
        if ($(this).siblings().is('input')) {
            $(this).siblings().attr('type', 'text');
        } else {
            $(this).parent().siblings().attr('type', 'text');
        }
        $(this).attr('class', 'fas fa-eye');
    });

    $('form').on('click', '.fas.fa-eye', function() {
        if ($(this).siblings().is('input')) {
            $(this).siblings().attr('type', 'password');
        } else {
            $(this).parent().siblings().attr('type', 'password');
        }
        $(this).attr('class', 'fas fa-eye-slash');
    });

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    if (getCookie('submenu-Data') == '') {
        $('#nav-menu-data .nav-items').hide();
    }
    if (getCookie('submenu-Transaksi') == '') {
        $('#nav-menu-transaksi .nav-items').hide();
    }
    if (getCookie('submenu-Proses') == '') {
        $('#nav-menu-proses .nav-items').hide();
    }
    if (getCookie('submenu-Laporan') == '') {
        $('#nav-menu-laporan .nav-items').hide();
    }
    if (getCookie('submenu-Setting') == '') {
        $('#nav-menu-setting .nav-items').hide();
    }

    $('#side-nav .menu-header').on('click', function() {
        let submenu = $(this).find('p').text();
        let state = '';
        $(this).find('.fa-angle-down').removeClass('fa-rotate-180');
        if ($(this).next().css('display') == 'none') {
            state = 'open';
            $(this).find('.fa-angle-down').addClass('fa-rotate-180');
        }
        $(this).next().toggle('fast', null);
        setCookie('submenu-' + submenu, state, 1);
    });

    // $('#side-nav a').on('click', function(e) {
    //     e.preventDefault();
    //     $('#content').load($(this).attr('href'));
    // });

    if (getCookie('current-menu') != '') {
        let menu = getCookie('current-menu').split('/');
        menu.shift();

        $('#nav-menu-' + menu[0] + ' #nav-' + menu[0] + '-' + menu[1] + ' .menu-item').addClass('active color-sub');
    }

    $('#side-nav .nav-items div').on('click', function() {
        setCookie('current-menu', $(this).children().attr('href'), 1);
    });

    var flag = false;
    var btnIndex = -1;
    $('.btn-show-action').on('click', function() {
        let lebarList = 150;
        let lebarBtn = $(this).css('width');
        let lebarTambahan = 2;
        lebarBtn = parseInt(lebarBtn.substr(0, lebarBtn.indexOf('px')));

        let outermostCard = $(this).closest('.card');
        while (outermostCard.parent().closest('.card').length > 0) {
            outermostCard = outermostCard.parent().closest('.card');
        }
        $('#list-action').css('left', $(this).offset().left - outermostCard.offset().left - lebarList + lebarBtn + lebarTambahan);

        $('#list-action').css('left', $(this).offset().left - $(this).closest('.card').offset().left - lebarList + lebarBtn + lebarTambahan);

        let tinggiBtn = $(this).css('height');
        let tinggiHeader = 0;
        tinggiBtn = parseInt(tinggiBtn.substr(0, tinggiBtn.indexOf('px')));
        $('#list-action').css('top', $(this).offset().top - $(this).closest('.card').offset().top + tinggiBtn + tinggiHeader);

        $('#list-action').show();
        btnIndex = $(this).index('.btn-show-action') + 1;
        flag = true;
    });

    $('#data-pelanggan #table-pelanggan, #data-item #table-item, .section-detail-transaksi #table-trans-item tbody, #table-container, #list-karyawan, #container-list-trans, #table-pickup, #table-delivery, .list-container').on('click', '.btn-show-action', function(event) {

        if (event.type === 'touchstart') {
            console.log('Triggered by touch event');
            alert('Triggered by touch event');
        } else if (event.type === 'click') {
            console.log('Triggered by click event');
        } else {
            alert(event.type);
        }
        let closestCardHeight = $(this).closest('.card').offset().top;
        let lebarList = 150;
        let lebarBtn = $(this).css('width');
        let lebarTambahan = 2;
        lebarBtn = parseInt(lebarBtn.substr(0, lebarBtn.indexOf('px')));
        if($(this).closest('.list-container').length == 1) {
            lebarTambahan += 16;
        }
        $('#list-action').css('left', $(this).offset().left - $(this).closest('.card').offset().left - lebarList + lebarBtn + lebarTambahan);

        let tinggiBtn = $(this).css('height');
        let tinggiHeader = 0;
        let tinggiTambahan = 0;
        tinggiBtn = parseInt(tinggiBtn.substr(0, tinggiBtn.indexOf('px')));
        if($(this).closest('.list-container').length == 1) {
            closestCardHeight = $(this).closest('.beacon').offset().top;
        }
        $('#list-action').css('top', $(this).offset().top - closestCardHeight + tinggiBtn + tinggiHeader + tinggiTambahan);
        console.log("TOP: " + $(this).offset().top);
        console.log("CARD TOP: " + closestCardHeight);

        $('#list-action').show();
        btnIndex = $(this).index('.btn-show-action') + 1;
        flag = true;
    });

    $('.section-detail-transaksi #table-trans-item tbody').on('scroll', function() {
        setTimeout(function (){
            if (flag) {
                flag = !flag;
            } else {
                if ($('#list-action').css('display') == 'block') {
                    $('#list-action').hide();
                }
            }
        }, 10);
    });

    $(document).on('click', function() {
        setTimeout(function (){
            if (flag) {
                flag = !flag;
            } else {
                if ($('#list-action').css('display') == 'block') {
                    $('#list-action').hide();
                }
            }
        }, 10);
    });

    var sideNav_opened = true;
    if (getCookie("nav_open") == "false") {
        sideNav_opened = false;
        stateNav(false, false);
    }

    function stateNav(bool, animate) {
        if (bool) {
            if (animate) {
                $('#side-nav').animate({width: '205px'});
                $('#content').animate({width: $(window).width() - 205 + 'px'});
            } else {
                $('#side-nav').css('width', '205px');
                $('#content').css('width', 'calc(100vw - 205px)');
            }
            setCookie("nav_open", true, 1);
        } else {
            if (animate) {
                $('#side-nav').animate({width: '0px'});
                $('#content').animate({width: $(window).width() + 'px'});
            } else {
                $('#side-nav').css('width', '0px');
                $('#content').css('width', '100vw');
            }
            setCookie("nav_open", false, 1);
        }
    }

    $('#side-icon').on('click', function(){
        sideNav_opened = !sideNav_opened;
        // console.log(sideNav_opened);
        if (sideNav_opened) {
            stateNav(true, true);
        } else {
            stateNav(false, true);
        }
    });

    if ($(this).width() < 576) {
        $('.full-when-small').addClass('active-fill');
    } else {
        $('.full-when-small').removeClass('active-fill');
    }

    $(window).on('resize', function() {
        if ($(this).width() <= 900) {
            sideNav_opened = false;
        }
        if ($(this).width() < 576) {
            $('.full-when-small').addClass('active-fill');
        } else {
            $('.full-when-small').removeClass('active-fill');
        }
        stateNav(sideNav_opened, false);
    })

    var separatorInterval = setTimeout(setThousandSeparator, 10);

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

    $('.input-thousand-separator').focus(function() {
        let val = $(this).val();
        $(this).attr('type', 'number');
        if (val != '') {
            while(val.indexOf('.') != -1) {
                val = val.replace('.', '');
            }
            let number = parseInt(val);
            $(this).val(number);
        }
    });

    $('.input-thousand-separator').blur(function() {
        let val = $(this).val();
        $(this).attr('type', 'text');
        if (val != '') {
            while(val.indexOf('.') != -1) {
                val = val.replace('.', '');
            }
            let number = parseInt(val);
            $(this).val(number.toLocaleString(['ban', 'id']));
        }
    });

    $('#modal-form').on('submit', function(e) {
        e.preventDefault();
        $('.input-thousand-separator').each(function() {
            let val = $(this).val();
            $(this).attr('type', 'number');
            if (val != '') {
                while(val.indexOf('.') != -1) {
                    val = val.replace('.', '');
                }
                let number = parseInt(val);
                $(this).val(number);
            }
        });

        if ($(this).closest('#data-pengeluaran').length != 1) {
            if ($(this)[0].checkValidity()) {
                this.submit();
            } else {
                $(this)[0].reportValidity();
            }
        }
    });

    if($('#menu-outlet').data('outlet') == "") {
        $('#container-select-outlet').load(window.location.origin + '/component/outlet', function() {
            $('#modal-pengaturan-outlet').modal('show');
        });
    }

    $('#menu-outlet').on('click', function() {
        $('#container-select-outlet').load(window.location.origin + '/component/outlet', function() {
            $('#modal-pengaturan-outlet').modal('show');
        });
    });

    $('#form-pengaturan-outlet').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData();
        formData.append('outlet_id', $('#container-select-outlet option:selected').val());

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "/setting/karyawan/outlet",
            method: "POST",
            contentType: false,
            processData: false,
            data: formData,
        }).done(function() {
            window.location = window.location.origin + window.location.pathname;
        }).fail(function(message) {
            alert('error');
            console.log(message);
        });
    });
});
