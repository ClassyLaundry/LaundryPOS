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

