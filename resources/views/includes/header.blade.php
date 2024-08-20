<header id="header" class="bg-main d-flex align-items-center justify-content-between px-2">
    <button class="btn" type="button">
        <i id="side-icon" class="fas fa-bars"></i>
    </button>
    <div class="d-flex align-items-center">
        <div class="me-4 text-white">
            Selamat datang, {{ Auth::user()->name }}! - {{ Auth::user()->outlet->nama }}
        </div>
        <div class="position-relative me-3">
            <button class="btn btn-sm d-flex" type="button">
                <i class="fa-solid fa-bell" style="font-size: 1rem"></i>
            </button>
            {{-- <div class="triangle-up position-absolute" style="width: 0; height: 0; border-left: 12px solid transparent; border-right: 12px solid transparent; border-bottom: 12px solid #dee2e6; z-index: 2;"></div>
            <div class="border border-2 rounded position-absolute" style="height: 500px; width: 300px; background-color: white; z-index: 1; top: 43px; right: -101px;">
            </div> --}}
        </div>
        <div class="dropdown">
            <button class="btn dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button">
                <i class="fas fa-user-circle"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
            @if (Session::get('role') == 'administrator')
                <a class="dropdown-item" id="menu-outlet" data-outlet="@if (Auth::user()->outlet){{ Auth::user()->outlet->id }}@endif">Outlet</a>
            @endif
                <a class="dropdown-item" href="/logout">Log Out</a>
            </div>
        </div>
    </div>
</header>
<div class="modal fade" id="modal-pengaturan-outlet" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Sesi Outlet</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <form id="form-pengaturan-outlet">
                <div class="modal-body" id="container-select-outlet">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn-ganti-outlet">Ganti</button>
                </div>
            </form>
        </div>
    </div>
</div>
