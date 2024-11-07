<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="col-6">Nama Item</th>
                <th class="col-3">Note</th>
                <th class="col-2">Tipe Kemas</th>
                <th class="col-1">Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->item_transaksi as $item)
                @if ($item->jenis_item->unit != "MTR")
                    @for($i = 0; $i < $item->qty; $i++)
                    <tr>
                        <td class="text-start">{{ $item->nama }}</td>
                        @if (isset($item->item_notes[$i]) && $item->item_notes[$i]->catatan)
                            <td class="text-start">{{ $item->item_notes[$i]->catatan }}</td>
                        @else
                            <td class="text-center">-</td>
                        @endif
                        <td class="py-1">
                            <select class="form-select form-select-sm input-inventory">
                                <option hidden value="">-</option>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}">{{ $inventory->nama }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="py-1">
                            <input type="number" class="input-qty form-control form-select-sm pe-1 ps-3 text-center" min="1" step="1" value="1">
                        </td>
                    </tr>
                    @endfor
                @else
                <tr>
                    <td class="text-start">{{ $item->nama }}</td>
                    @if (isset($item->item_notes) && $item->item_notes[0]->catatan)
                        <td class="text-start">{{ $item->item_notes[0]->catatan }}</td>
                    @else
                        <td class="text-center">-</td>
                    @endif
                    <td class="py-1">
                        <select class="form-select form-select-sm input-inventory">
                            <option hidden value="">-</option>
                            @foreach ($inventories as $inventory)
                                <option value="{{ $inventory->id }}">{{ $inventory->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="py-1">
                        <input type="number" class="input-qty form-control form-select-sm pe-1 ps-3 text-center" min="1" step="1" value="1">
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
