<!DOCTYPE html>
<html>

<head>
    <title>Delivery Note</title>
    <style>
        /* Add any styles you want to use for the PDF here */
        body {
            font-family: sans-serif;
        }
    </style>
</head>
<body>
    @if ($cetak == 1)
        <p style="position: absolute; left: -15px; top: {{ -50 }}px; width: 150%; font-size: 1.5rem; font-weight: bold;">{{substr($data->kitir_code, 0) . " " . substr($data->kitir_code,4)}}</p>
    @else
        @for($i = 0; $i < $cetak; $i++)
            <p style="position: absolute; left: -15px; top: {{ $i * 80 - 50 }}px; width: 150%; font-size: 1.5rem; font-weight: bold;">{{substr($data->kitir_code, 0) . " " . substr($data->kitir_code,-4)}}</p>
        @endfor
    @endif
</body>

</html>
