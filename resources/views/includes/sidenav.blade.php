<div id="side-nav">
    <div class="menu-section my-1">
        <div id="nav-menu-data" class="nav-menu">
            <div class="menu-header px-3 py-1 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center"><i class="fas fa-file-alt"></i>
                    <p class="ms-3">Data</p>
                </div>
                <i class="fas fa-angle-down"></i>
            </div>
            <div class="nav-items">
                @if(in_array("Membuka Menu Kategori", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-data-kategori">
                    <a href="/data/kategori" class="menu-item menu-data pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fas fa-boxes"></i>
                        <p class="ms-3">Kategori</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Jenis Item", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-data-jenis-item">
                    <a href="/data/jenis-item" class="menu-item menu-data pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fas fa-box"></i>
                        <p class="ms-3">Item</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Parfum", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-data-parfum">
                    <a href="/data/parfum" class="menu-item menu-data pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <div class="position-relative d-flex justify-content-center align-items-center" style="width: 16px; height: 16px;">
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet" style="left: -2px; top: -2px;">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                                    <path d="M2152 4787 c-46 -14 -121 -84 -143 -132 -15 -33 -19 -66 -19 -197 l0 -158 570 0 570 0 0 158 c0 179 -9 210 -76 274 -70 66 -82 68 -498 67 -229 -1 -384 -5 -404 -12z"/>
                                    <path d="M1927 4126 c-150 -54 -223 -214 -169 -370 l17 -50 -85 -86 c-141 -142 -252 -323 -315 -514 -67 -206 -66 -181 -63 -1386 l3 -1085 32 -68 c20 -42 53 -88 87 -123 35 -34 81 -67 123 -87 l68 -32 935 0 935 0 68 32 c89 42 168 121 210 210 l32 68 0 1125 0 1125 -29 110 c-67 258 -177 455 -352 633 l-82 83 17 32 c25 49 21 169 -7 232 -28 62 -84 121 -137 146 -38 17 -76 19 -645 18 -482 0 -613 -3 -643 -13z m1294 -1019 c67 -32 151 -117 182 -184 22 -47 22 -55 22 -528 l0 -480 -33 -67 c-37 -77 -90 -128 -172 -167 -48 -23 -68 -26 -155 -26 -87 0 -107 3 -157 27 -109 51 -180 147 -199 271 -6 39 -9 231 -7 478 3 358 6 421 21 466 37 111 119 194 226 228 74 24 203 15 272 -18z"/>
                                </g>
                            </svg>
                        </div>
                        <p class="ms-3">Parfum</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Pelanggan", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-data-pelanggan">
                    <a href="/data/pelanggan" class="menu-item menu-data pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fas fa-users"></i>
                        <p class="ms-3">Pelanggan</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Inventory", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-data-inventory">
                    <a href="/data/inventory" class="menu-item menu-data pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fa-solid fa-boxes-stacked"></i>
                        <p class="ms-3">Inventory</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Pengeluaran", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-data-pengeluaran">
                    <a href="/data/pengeluaran" class="menu-item menu-data pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fas fa-dollar-sign"></i>
                        <p class="ms-3">Pengeluaran</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Rewash", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-data-rewash">
                    <a href="/data/rewash" class="menu-item menu-data pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fas fa-water"></i>
                        <p class="ms-3">Rewash</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Diskon", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-data-diskon">
                    <a href="/data/diskon" class="menu-item menu-data pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fa-solid fa-tags"></i>
                        <p class="ms-3">Diskon</p>
                    </a>
                </div>
                @endif
            </div>
        </div>
        <div id="nav-menu-transaksi" class="nav-menu">
            <div class="menu-header px-3 py-1 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center"><i class="fas fa-file-invoice-dollar"></i>
                    <p class="ms-3">Transaksi</p>
                </div>
                <i class="fas fa-angle-down"></i>
            </div>
            <div class="nav-items">
                @if(in_array("Membuka Menu Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-transaksi-bucket">
                    <a href="/transaksi/bucket" class="menu-item menu-transaksi pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <div class="position-relative d-flex justify-content-center align-items-center" style="width: 16px; height: 16px;">
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                                <path d="M1999 5106 c-65 -23 -112 -70 -143 -141 -11 -25 -29 -36 -107 -68 -525 -213 -956 -731 -1069 -1289 -46 -224 -59 -118 210 -1733 268 -1612 245 -1502 344 -1592 27 -24 95 -67 150 -93 233 -113 579 -174 1056 -187 666 -17 1224 91 1433 278 104 92 79 -23 347 1594 132 796 240 1471 240 1499 0 144 -54 373 -129 550 -183 433 -569 818 -978 977 -78 31 -87 37 -104 75 -23 48 -70 98 -113 122 -28 15 -87 17 -566 19 -423 2 -543 0 -571 -11z m34 -456 c36 -8 207 -10 557 -8 471 3 507 4 540 22 19 10 42 24 50 32 13 11 29 7 100 -25 186 -82 346 -193 495 -345 125 -127 210 -246 289 -406 61 -125 124 -295 113 -306 -3 -3 -41 6 -84 20 -256 84 -641 140 -1153 166 -697 35 -1507 -33 -1908 -162 -52 -16 -96 -27 -99 -24 -11 11 50 175 112 301 80 164 163 282 290 411 149 151 309 263 494 345 l83 37 35 -23 c18 -13 57 -29 86 -35z m1213 -1104 c490 -51 915 -142 937 -200 28 -73 -381 -169 -943 -223 -235 -22 -1081 -26 -1310 -5 -509 46 -912 126 -992 199 -48 43 31 79 295 133 267 54 471 83 743 105 236 19 1059 13 1270 -9z"/>
                                </g>
                            </svg>
                        </div>
                        <p class="ms-3">Bucket</p>
                    </a>
                </div>
                <div id="nav-transaksi-premium">
                    <a href="/transaksi/premium" class="menu-item menu-transaksi pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <div class="position-relative d-flex justify-content-center align-items-center" style="width: 16px; height: 16px;">
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                                    <path d="M1237 4266 c37 -62 570 -795 577 -792 5 1 131 171 279 377 148 206 278 386 288 402 l20 27 -586 0 c-490 0 -585 -2 -578 -14z"/>
                                    <path d="M2749 4238 c17 -24 147 -205 289 -402 142 -198 263 -361 268 -363 7 -2 540 731 577 793 7 12 -88 14 -578 14 l-586 0 30 -42z"/>
                                    <path d="M776 3820 c-157 -221 -286 -405 -286 -410 0 -6 219 -10 581 -10 444 0 580 3 577 12 -6 18 -572 807 -579 807 -4 1 -136 -179 -293 -399z"/>
                                    <path d="M2270 3824 c-157 -219 -286 -403 -288 -411 -3 -11 95 -13 577 -13 376 0 581 3 581 10 0 11 -567 804 -578 808 -4 1 -136 -176 -292 -394z"/>
                                    <path d="M3761 3821 c-157 -218 -287 -403 -289 -409 -3 -9 133 -12 577 -12 362 0 581 4 581 10 0 12 -570 810 -579 809 -3 0 -134 -179 -290 -398z"/>
                                    <path d="M507 3215 c62 -84 1868 -2331 1870 -2326 1 3 -138 533 -310 1176 l-312 1170 -634 3 -633 2 19 -25z"/>
                                    <path d="M1922 3228 c2 -7 146 -545 319 -1195 173 -651 316 -1183 319 -1183 3 0 146 532 319 1183 173 650 317 1188 319 1195 3 9 -129 12 -638 12 -509 0 -641 -3 -638 -12z"/>
                                    <path d="M3367 3233 c-7 -12 -628 -2345 -625 -2348 3 -2 1824 2266 1871 2330 l19 25 -631 0 c-346 0 -632 -3 -634 -7z"/>
                                </g>
                            </svg>
                        </div>
                        <p class="ms-3">Premium</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Pickup Delivery", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-transaksi-pickup-delivery">
                    <a href="/transaksi/pickup-delivery" class="menu-item menu-transaksi pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fas fa-motorcycle"></i>
                        <p class="ms-3">Pickup & Delivery</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Saldo", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-transaksi-saldo">
                    <a href="/transaksi/saldo" class="menu-item menu-transaksi pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fa-solid fa-scale-balanced"></i>
                        <p class="ms-3">Saldo</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Pembayaran", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-transaksi-pembayaran">
                    <a href="/transaksi/pembayaran" class="menu-item menu-transaksi pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fa-solid fa-money-bills"></i>
                        <p class="ms-3">Pembayaran</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Canceled", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-transaksi-cancelled">
                    <a href="/transaksi/cancelled" class="menu-item menu-transaksi pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fa-solid fa-ban"></i>
                        <p class="ms-3">Cancelled</p>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div id="nav-menu-proses" class="nav-menu">
            <div class="menu-header px-3 py-1 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-arrows-spin"></i>
                    <p class="ms-3">Proses</p>
                </div>
                <i class="fas fa-angle-down"></i>
            </div>
            <div class="nav-items">
                @if(in_array("Membuka Menu Hub Cuci", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-proses-cuci">
                    <a href="/proses/cuci" class="menu-item menu-proses pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <div class="position-relative d-flex justify-content-center align-items-center" style="width: 16px; height: 16px;">
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet" style="left: -2px; top: -2px;">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                                <path d="M921 5104 c-169 -45 -301 -180 -346 -351 -22 -86 -22 -555 1 -577 14 -14 208 -16 1984 -16 1776 0 1970 2 1984 16 23 22 23 491 1 577 -45 173 -178 307 -350 352 -87 22 -3190 22 -3274 -1z m2365 -330 c53 -39 69 -71 69 -134 0 -63 -16 -95 -69 -134 -33 -25 -158 -35 -216 -17 -103 31 -143 169 -73 252 41 48 76 60 175 57 69 -2 92 -7 114 -24z m640 0 c53 -39 69 -71 69 -134 0 -63 -16 -95 -69 -134 -33 -25 -158 -35 -216 -17 -103 31 -143 169 -73 252 41 48 76 60 175 57 69 -2 92 -7 114 -24z"/>
                                <path d="M576 3824 c-15 -14 -16 -191 -14 -1869 l3 -1854 21 -27 c11 -15 33 -37 48 -48 l27 -21 1899 0 1899 0 27 21 c15 11 37 33 48 48 l21 27 3 1854 c2 1678 1 1855 -14 1869 -14 14 -204 16 -1984 16 -1780 0 -1970 -2 -1984 -16z m2254 -493 c251 -57 446 -165 631 -350 234 -233 358 -509 375 -837 15 -279 -58 -544 -216 -780 -110 -164 -313 -340 -498 -433 -341 -171 -783 -171 -1127 1 -242 121 -461 340 -583 583 -90 179 -126 343 -126 565 0 226 36 386 132 575 76 153 224 332 356 435 173 132 403 230 619 260 97 14 339 3 437 -19z"/>
                                <path d="M2410 3029 c-321 -54 -606 -275 -731 -570 -28 -66 -29 -72 -14 -95 18 -28 18 -28 118 -9 117 22 261 29 362 16 157 -19 237 -44 544 -170 214 -89 353 -113 521 -91 118 15 259 55 284 80 19 19 19 22 4 94 -39 178 -122 328 -258 467 -149 151 -314 239 -517 274 -93 16 -227 18 -313 4z"/>
                                <path d="M1875 2046 c-111 -18 -231 -55 -251 -78 -16 -17 -16 -23 -1 -92 38 -179 122 -330 257 -466 137 -139 280 -220 466 -267 109 -27 334 -24 444 5 289 78 507 258 636 525 45 93 46 97 30 122 -19 29 -28 30 -121 10 -173 -36 -383 -28 -554 21 -47 14 -171 61 -276 104 -104 43 -228 88 -274 100 -105 27 -252 33 -356 16z"/>
                                </g>
                            </svg>
                        </div>
                        <p class="ms-3">Cuci</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Hub Setrika", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-proses-setrika">
                    <a href="/proses/setrika" class="menu-item menu-proses pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <div class="position-relative d-flex justify-content-center align-items-center" style="width: 16px; height: 16px;">
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet" style="left: -2px; top: -2px;">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                                <path d="M4660 4582 c-73 -48 -193 -147 -240 -198 -123 -135 -244 -351 -294 -526 -27 -93 -56 -269 -56 -337 l0 -41 80 0 80 0 0 38 c0 77 31 237 65 340 77 231 212 416 403 555 109 79 123 107 81 161 -24 31 -79 35 -119 8z"/>
                                <path d="M2468 3299 c-251 -38 -456 -102 -693 -219 -639 -313 -1100 -911 -1245 -1613 -10 -53 -22 -125 -26 -160 l-6 -64 1533 -6 c844 -3 1740 -3 1992 0 l458 6 37 30 c51 41 107 64 172 72 62 8 96 25 105 54 10 32 -104 1579 -120 1638 -21 71 -90 169 -148 209 -26 18 -72 42 -102 53 -55 21 -69 21 -943 20 -821 -1 -896 -2 -1014 -20z m1697 -564 l25 -24 0 -341 c0 -348 -2 -369 -39 -397 -12 -10 -245 -12 -1014 -13 l-998 0 -24 25 c-48 48 -27 99 109 257 220 256 570 449 911 502 66 10 211 14 548 15 l458 1 24 -25z m-1547 -1231 c12 -14 22 -36 22 -50 0 -35 -42 -74 -80 -74 -37 0 -80 39 -80 72 0 30 26 67 54 78 29 12 57 3 84 -26z m480 0 c12 -14 22 -36 22 -50 0 -35 -42 -74 -80 -74 -37 0 -80 39 -80 72 0 30 26 67 54 78 29 12 57 3 84 -26z m480 0 c12 -14 22 -36 22 -50 0 -35 -42 -74 -80 -74 -37 0 -80 39 -80 72 0 30 26 67 54 78 29 12 57 3 84 -26z"/>
                                <path d="M2564 2221 c-35 -21 -74 -67 -74 -87 0 -12 67 -14 390 -14 429 0 416 -2 364 60 -50 59 -56 60 -366 60 -260 0 -286 -2 -314 -19z"/>
                                <path d="M349 1051 l-29 -29 0 -225 c0 -212 1 -226 21 -251 l20 -26 1919 0 1919 0 20 26 c20 25 21 39 21 251 l0 225 -29 29 -29 29 -1902 0 -1902 0 -29 -29z"/>
                                </g>
                            </svg>
                        </div>
                        <p class="ms-3">Setrika</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Proses Rewash", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-proses-rewash">
                    <a href="/proses/rewash" class="menu-item menu-proses pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fas fa-water"></i>
                        <p class="ms-3">Rewash</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Packing", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-proses-packing">
                    <a href="/proses/packing" class="menu-item menu-proses pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fa-solid fa-boxes-packing"></i>
                        <p class="ms-3">Packing</p>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div id="nav-menu-laporan" class="nav-menu">
            <div class="menu-header px-3 py-1 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-file-lines"></i>
                    <p class="ms-3">Laporan</p>
                </div>
                <i class="fas fa-angle-down"></i>
            </div>
            <div class="nav-items">
                @if(in_array("Melihat Laporan Mutasi Deposit", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-laporan-deposit">
                    <a href="/laporan/deposit" class="menu-item menu-laporan pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fa-solid fa-sack-dollar"></i>
                        <p class="ms-3">Mutasi Deposit</p>
                    </a>
                </div>
                @endif
                @if(in_array("Melihat Laporan Piutang", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-laporan-piutang">
                    <a href="/laporan/piutang" class="menu-item menu-laporan pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fa-solid fa-credit-card"></i>
                        <p class="ms-3">Piutang</p>
                    </a>
                </div>
                @endif
                @if(in_array("Melihat Laporan Omset", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-laporan-omset">
                    <a href="/laporan/omset" class="menu-item menu-laporan pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                        <p class="ms-3">Omset</p>
                    </a>
                </div>
                @endif
                @if(in_array("Melihat Laporan Customer", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-laporan-customer">
                    <a href="/laporan/customer" class="menu-item menu-laporan pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fa-solid fa-address-card"></i>
                        <p class="ms-3">Keseluruhan</p>
                    </a>
                </div>
                @endif
                @if(in_array("Melihat Laporan Kas Masuk", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-laporan-kas">
                    <a href="/laporan/kas" class="menu-item menu-laporan pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fa-solid fa-piggy-bank"></i>
                        <p class="ms-3">Kas Masuk</p>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div id="nav-menu-setting" class="nav-menu">
            <div class="menu-header px-3 py-1 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center"><i class="fas fa-cog"></i>
                    <p class="ms-3">Setting</p>
                </div>
                <i class="fas fa-angle-down"></i>
            </div>
            <div class="nav-items">
                @if(in_array("Membuka Menu Outlet", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-setting-outlet">
                    <a href="/setting/outlet" class="menu-item menu-setting pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fas fa-building"></i>
                        <p class="ms-3">Outlet</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Karyawan", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-setting-karyawan">
                    <a href="/setting/karyawan" class="menu-item menu-setting pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fas fa-user-friends"></i>
                        <p class="ms-3">Karyawan</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Paket Cuci", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-setting-paket-cuci">
                    <a href="/setting/paket-cuci" class="menu-item menu-setting pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fa-solid fa-shirt"></i>
                        <p class="ms-3">Paket Cuci</p>
                    </a>
                </div>
                @endif
                @if(in_array("Membuka Menu Paket Deposit", Session::get('permissions')) || Session::get('role') == 'administrator')
                <div id="nav-setting-paket-deposit">
                    <a href="/setting/paket-deposit" class="menu-item menu-setting pe-3 py-1 d-flex align-items-center" style="padding-left: 2rem;">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                        <p class="ms-3">Paket Deposit</p>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
