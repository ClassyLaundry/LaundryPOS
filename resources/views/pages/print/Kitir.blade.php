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
    @for($i = 0; $i < $cetak; $i++)
        <p style="position: absolute; left: -15px; top: {{ $i * 80 - 50 }}px; width: 150%; font-size: 1.5rem; font-weight: bold;">{{ $data->kitir_code }}</p>
    @endfor
</body>

</html>
