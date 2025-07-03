<div class="table-responsive">
    <table class="table table-striped" class="table-item_transaksi">
        <thead>
            <tr>
                <th class="col-9">Nama Item</th>
                {{-- <th class="col-4">Note</th> --}}
                <th class="col-3">Qty Item</th>
                {{-- <th class="col-2">Tipe Kemas</th>
                <th class="col-1">Qty</th> --}}
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($transaksi->item_transaksi as $item)
                @if ($item->jenis_item->unit != "MTR")
                    <!-- diisikan per item, bukan per jenis item -->
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
                        @if (isset($item->item_notes) && count($item->item_notes) > 0)
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
            @endforeach --}}
            @foreach ($transaksi->item_transaksi as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td class="text-center">{{ $item->qty }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<hr>
<div class="table-responsive">
    <table class="table table-striped" id="table-packing">
        <thead>
            <tr>
                <th class="col-9">Item Packing</th>
                <th class="col-3">Qty</th>
            </tr>
        </thead>
        <tbody>
            <tr>
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
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-center">
                    <button type="button" class="btn btn-sm btn-primary" id="btn-clone">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
