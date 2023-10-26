<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Item</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->item_transaksi as $item)
                @for($i = 0; $i < $item->qty; $i++)
                <tr>
                    <td class="text-start">{{ $item->nama }}</td>
                    @if (isset($item->item_notes[$i]) && $item->item_notes[$i]->catatan)
                        <td class="text-start">{{ $item->item_notes[$i]->catatan }}</td>
                    @else
                        <td class="text-center">-</td>
                    @endif
                </tr>
                @endfor
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center pt-4">Item Packing</th>
                <th class="text-center pt-4">Qty</th>
            </tr>
            <tr>
                <td class="">
                    <select class="form-select form-select-sm" id="input-inventory">
                        <option hidden value="">-</option>
                        @foreach ($inventories as $inventory)
                            <option value="{{ $inventory->id }}">{{ $inventory->nama }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input class="mx-auto form-control form-control-sm" step="1" style="max-width: 100px;" type="number" id="input-inventory-qty">
                </td>
            </tr>
        </tfoot>
    </table>
</div>
