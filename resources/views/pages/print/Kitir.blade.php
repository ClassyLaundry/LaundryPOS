<!DOCTYPE html>
<html>

<head>
    <title>Delivery Note</title>
    <style>
        body {
            width: 100%;
            height: auto;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }
        p {
            height: auto;
        }
    </style>
</head>
<body>
    @if ($cetak == 1)
        <p style="position: absolute; left: -15px; top: {{ -50 }}px; width: 150%; font-size: 1.5rem; font-weight: bold;">{{substr($data->kitir_code, 0, 8) . " " . substr($data->kitir_code, -4)}}</p>
    @else
        @for($i = 0; $i < $cetak; $i++)
            <p style="position: absolute; left: -15px; top: {{ $i * 80 - 50 }}px; width: 150%; font-size: 1.5rem; font-weight: bold;">{{substr($data->kitir_code, 0, 8) . " " . substr($data->kitir_code, -4)}}</p>
        @endfor
    @endif
</body>

</html>
