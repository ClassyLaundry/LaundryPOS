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
<body style="width: 100%; height: 100%;">
    @for($i = 0; $i < $cetak; $i++)
        <h3 style="position: absolute; left: 0px; top: {{ $i * 70 - 30 }}px; width: 100%; font-size: 1.25rem; font-weight: bold;">{{ $data->kitir_code }}</h3>
    @endfor
</body>

</html>
