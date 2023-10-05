<!DOCTYPE html>
<html>

<head>
    <title>Delivery Note</title>
    <style>
        /* Add any styles you want to use for the PDF here */
        body {
            font-family: sans-serif;
            font-size: 10pt
        }
    </style>
</head>
<body style="width: 100%; height: 100%;">
    @for($i = 0; $i < $cetak; $i++)
        <h2 style="position: absolute; left: 0px; top: {{ $i * 70 - 30 }}px; width: 100%;">{{ $data->kitir_code }}</h2>
    @endfor
</body>

</html>
