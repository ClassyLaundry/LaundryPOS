
@if ($trans->tipe_transaksi == 'bucket')
<div class="table-responsive my-2 tbody-wrap">
    <table class="table table-striped mb-0" id="table-trans-item">
        <thead>
            <tr>
                <th style="width: 62.5%;">Nama Item</th>
                <th style="width: 20%;">Kategori</th>
                <th style="width: 7.5%;">Qty</th>
                @if(Session::get('role') != 'delivery')
                <th class="column-action"></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($trans->item_transaksi as $item_transaksi)
            <tr id="trans-{{ $trans->id }}">
                <td style="width: 62.5%;">{{ $item_transaksi->nama }}</td>
                <td style="width: 20%;" class="text-center">{{ $item_transaksi->nama_kategori }}</td>
                <td style="width: 7.5%;" class="text-center">{{ $item_transaksi->qty }}</td>
                <td class="cell-action">
                    <div class="d-flex h-100 align-items-center justify-content-end">
                        @if(isset($rewashes))
                            @foreach ($rewashes as $rewash)
                                @if($rewash->item_transaksi_id == $item_transaksi->id)
                                    <i class="me-3 text-danger fa-solid fa-circle-exclamation"></i>
                                @break
                                @endif
                            @endforeach
                        @endif
                        @if(Session::get('role') != 'delivery')
                        <button id="btn-{{ $item_transaksi->id }}" class="btn btn-primary btn-sm btn-show-action-2" type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
            @if (isset($inventories))
                @foreach ($inventories as $inventory)
                <tr>
                    <td style="width: 62.5%;">{{ $inventory['name'] }}</td>
                    <td style="width: 20%;" class="text-center">Packing</td>
                    <td style="width: 7.5%;" class="text-center">{{ $inventory['qty'] }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@elseif ($trans->tipe_transaksi == 'premium')
<div class="table-responsive my-2 tbody-wrap">
    <table class="table table-striped mb-0" id="table-trans-item">
        <thead>
            <tr>
                <th style="width: 62.5%;">Nama Item</th>
                <th style="width: 20%;">Kategori</th>
                <th style="width: 7.5%;">Qty</th>
                @if(Session::get('role') != 'delivery')
                <th class="column-action"></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < count($trans->item_transaksi); $i++)
                <tr id="trans-{{ $trans->id }}">
                    <td style="width: 62.5%;">{{ $trans->item_transaksi[$i]->nama }}</td>
                    <td style="width: 20%;" class="text-center">{{ $trans->item_transaksi[$i]->nama_kategori }}</td>
                    <td style="width: 7.5%;" class="text-center">{{ $trans->item_transaksi[$i]->qty }}</td>
                    <td class="cell-action">
                        <div class="d-flex h-100 align-items-center justify-content-end">
                            @if(isset($rewashes))
                                @foreach ($rewashes as $rewash)
                                    @if($rewash->item_transaksi_id == $trans->item_transaksi[$i]->id)
                                        <i class="me-3 text-danger fa-solid fa-circle-exclamation"></i>
                                    @break
                                    @endif
                                @endforeach
                            @endif
                            @if(Session::get('role') != 'delivery')
                            <button id="btn-{{ $trans->item_transaksi[$i]->id }}" class="btn btn-primary btn-sm btn-show-action-2" type="button">
                                <i class="fas fa-bars"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @for($j = 0; $j < $trans->item_transaksi[$i]->qty; $j++)
                @if (isset($inventories))
                    <tr>
                        <td class="py-1" style="width: 62.5%;">{{ $inventories[$i * count($trans->item_transaksi) + $j]['name'] }}</td>
                        <td class="py-1 text-center" style="width: 20%;">Packing</td>
                    </tr>
                @endif
                @endfor
            @endfor

            {{-- @foreach ($trans->item_transaksi as $item_transaksi)
            <tr id="trans-{{ $trans->id }}">
                <td style="width: 62.5%;">{{ $item_transaksi->nama }}</td>
                <td style="width: 20%;" class="text-center">{{ $item_transaksi->nama_kategori }}</td>
                <td style="width: 7.5%;" class="text-center">{{ $item_transaksi->qty }}</td>
                <td class="cell-action">
                    <div class="d-flex h-100 align-items-center justify-content-end">
                        @if(isset($rewashes))
                            @foreach ($rewashes as $rewash)
                                @if($rewash->item_transaksi_id == $item_transaksi->id)
                                    <i class="me-3 text-danger fa-solid fa-circle-exclamation"></i>
                                @break
                                @endif
                            @endforeach
                        @endif
                        @if(Session::get('role') != 'delivery')
                        <button id="btn-{{ $item_transaksi->id }}" class="btn btn-primary btn-sm btn-show-action-2" type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
            @if (isset($inventories))
                @foreach ($inventories as $inventory)
                <tr>
                    <td style="width: 62.5%;">{{ $inventory['name'] }}</td>
                    <td style="width: 20%;" class="text-center">Packing</td>
                    <td style="width: 7.5%;" class="text-center">{{ $inventory['qty'] }}</td>
                </tr>
                @endforeach
            @endif --}}
        </tbody>
    </table>
</div>
<input type="hidden" id="catatan-transaksi" value="{{ $trans->catatan_transaksi }}">
<input type="hidden" id="catatan-pelanggan" value="{{ $trans->pelanggan->special_note }}">
@endif
