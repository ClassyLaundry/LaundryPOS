<h5>Outlet</h5>
<select class="form-select" required>
    <option value="" hidden>-</option>
    @foreach ($outlets as $outlet)
        @if (Auth::user()->outlet && Auth::user()->outlet->id == $outlet->id)
            <option value={{ $outlet->id }} selected>{{ $outlet->nama }}</option>
        @else
            <option value={{ $outlet->id }}>{{ $outlet->nama }}</option>
        @endif
    @endforeach
</select>
