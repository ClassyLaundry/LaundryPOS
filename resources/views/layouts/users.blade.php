<!doctype html>
<html>

<head>
    @include('includes.head')
</head>

<body>
    <div id="loading-svg">
        <div class="progress" id="loading-rect">
            <div class="inner"></div>
        </div>
    </div>
    @include('includes.header')
    <div class="d-flex">
        @include('includes.sidenav')
        <div id="content" class="position-relative pb-5" style="max-height: calc(100vh - 60px); width: calc(100vw - 205px); overflow-y: auto;">
            @yield('content')
        </div>
    </div>
</body>
<style>
    #loading-svg {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: blurReduce 2s ease-in-out forwards;
    }

    .progress {
        background-color: #222F64;
        width: 100px;
        height: 10px;
        border-radius: 100px;
        overflow: hidden;
        backface-visibility: hidden;
    }

    .inner {
        background-image: linear-gradient(to left, #00cdac, #00c2c9, #00b4e3, #00a2f1, #008cef, #0088eb, #0085e6, #0081e2, #0090de, #009bd2, #00a3c1, #02aab0);
        height: 100%;
        transform-origin: left;
        animation: progress 2s infinite;
    }

    @keyframes progress {
        0% {
            transform: scaleX(10%) translateX(-10%);
        }

        100% {
            transform: scaleX(80%) translateX(150%);
        }
    }

    @keyframes blurReduce {
        0% {
            backdrop-filter: blur(50px);
        }

        30% {
            backdrop-filter: blur(10px);
        }

        100% {
            backdrop-filter: blur(3px);
        }
    }
</style>
<script>
    function startLoadingBar() {
        $('#loading-svg').show();
        $('#loading-rect').css('width', '0');
        $('#loading-rect').animate({ width: '50%' }, 1000);
    }

    function stopLoadingBar() {
        $('#loading-rect').animate({ width: '100%' }, 500, function() {
            $('#loading-svg').fadeOut(300);
        });
    }

    $(document).ready(function() {
        startLoadingBar();

        $(window).on('load', function() {
            stopLoadingBar();
        });

        // $(document).ajaxStart(function() {
        //     startLoadingBar();
        // }).ajaxComplete(function() {
        //     stopLoadingBar();
        // });
        stopLoadingBar();
    });
</script>

</html>
