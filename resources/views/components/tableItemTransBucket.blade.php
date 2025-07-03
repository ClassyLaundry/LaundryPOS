<div class="table-responsive my-2">
    <table class="table table-striped mb-0" id="table-trans-item">
        <thead>
            <tr>
                <th style="width: 30%">Nama Item</th>
                <th class="d-none d-lg-table-cell">Kategori</th>
                <th class="d-none d-md-table-cell">Proses</th>
                <th class="d-none d-md-table-cell">Qty</th>
                <th class="d-none d-md-table-cell">Bobot</th>
                <th style="width: 135px;">Total</th>
                <th style="width: 38.25px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trans->item_transaksi as $item)
            <tr id='{{ $item->id }}'>
                <td style='white-space: nowrap;'>{{ $item->nama }}</td>
                <td class='d-none d-lg-table-cell text-center'>{{ $item->nama_kategori }}</td>
                @if ($trans->penyetrika != null)
                    <td class='d-none d-md-table-cell text-center'>Setrika</td>
                @elseif ($trans->pencuci != null)
                    <td class='d-none d-md-table-cell text-center'>Cuci</td>
                @else
                    <td class='d-none d-md-table-cell'></td>
                @endif
                @if(in_array("Mengubah Data Item Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
                <td class='d-none d-md-table-cell text-center p-0 col-qty'>
                    <div class='d-flex align-items-center justify-content-center' style='height: 39.5px;'>{{ $item->qty }}</div>
                </td>
                @else
                <td class='d-none d-md-table-cell text-center p-0 col-qty disabled'>
                    <div class='d-flex align-items-center justify-content-center' style='height: 39.5px;'>{{ $item->qty }}</div>
                </td>
                @endif
                <td class='d-none d-md-table-cell text-center'>{{ $item->bobot_bucket }}</td>
                <td class='text-center'>{{ $item->total_bobot }}</td>
                <td class='text-end p-1'>
                    <button id='btn-{{ $item->id }}' class='btn btn-primary btn-sm btn-show-action' type='button'>
                        <i class='fas fa-bars' aria-hidden='true'></i>
                    </button>
                </td>
            </tr>
            @endforeach
            @if(in_array("Menambahkan Item Ke Transaksi", Session::get('permissions')) || Session::get('role') == 'administrator')
            <tr>
                <td class="text-center" colspan="7" style="padding-top: 4px;padding-bottom: 4px;">
                    <button class="btn btn-primary btn-sm" id="add-item" type="button">
                        <i class="fas fa-plus"></i>
                    </button>
                </td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td class="text-end py-1 px-2" colspan="4">Jumlah Item</td>
                <td class="py-1 px-2" style="width: 35px"></td>
                <td class="text-end py-1 px-2">{{ $total_qty }}</td>
                <td class="p-1"></td>
            </tr>
            @if($trans->express)
            <tr>
                <td class="text-end py-1 px-2" colspan="4">Multiplier Express</td>
                <td class="p-1" style="width: 35px"></td>
                <td class="text-end py-1 px-2">{{ $multiplier_express->value }} x</td>
                <td class="p-1"></td>
            </tr>
            @endif
            @if($trans->setrika_only)
            <tr>
                <td class="text-end py-1 px-2" colspan="4">Multiplier Setrika Only</td>
                <td class="p-1" style="width: 35px"></td>
                <td class="text-end py-1 px-2">{{ $multiplier_setrika->value }} x</td>
                <td class="p-1"></td>
            </tr>
            @endif
            <tr>
                <td class="text-end py-1 px-2" colspan="4">Sub Total</td>
                <td class="p-1" style="width: 35px">Rp</td>
                <td class="text-end thousand-separator py-1 px-2" id="sub-total">{{ $trans->subtotal }}</td>
                <td class="p-1"></td>
            </tr>
            @if ($trans->total_diskon_promo != 0)
            <tr>
                <td class="text-end py-1 px-2" colspan="4">Diskon Promo</td>
                <td class="py-1 px-2" style="width: 35px">Rp</td>
                <td class="text-end thousand-separator py-1 px-2" id="diskon-promo">{{ $trans->total_diskon_promo }}</td>
                <td class="p-1"></td>
            </tr>
            @endif
            @if ($trans->diskon_member != 0)
            <tr>
                <td class="text-end py-1 px-2" colspan="4">Diskon Member</td>
                <td class="py-1 px-2" style="width: 35px">Rp</td>
                <td class="text-end thousand-separator py-1 px-2" id="diskon-member">{{ $trans->diskon_member }}</td>
                <td class="p-1"></td>
            </tr>
            @endif
            @if ($trans->diskon_pelanggan_spesial != 0)
            <tr>
                <td class="text-end py-1 px-2" colspan="4">Diskon Spesial</td>
                <td class="py-1 px-2" style="width: 35px">Rp</td>
                <td class="text-end thousand-separator py-1 px-2" id="diskon-pelanggan_spesial">{{ $trans->diskon_pelanggan_spesial }}</td>
                <td class="p-1"></td>
            </tr>
            @endif
            <tr>
                <td class="text-end py-1 px-2" colspan="4">Grand Total</td>
                <td class="p-1" style="width: 35px">Rp</td>
                <td class="text-end thousand-separator py-1 px-2" id="grand-total">{{ $trans->grand_total }}</td>
                <td class="p-1"></td>
            </tr>
        </tfoot>
    </table>
</div>
