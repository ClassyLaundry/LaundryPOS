<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>
    @include('includes.header')
    <div class="d-flex">
        @include('includes.sidenav')
        <div id="content" class="position-relative pb-5" style="max-height: calc(100vh - 60px); width: calc(100vw - 205px); overflow-y: auto;">
            @yield('content')
        </div>
    </div>
</body>
</html>
