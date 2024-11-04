<!DOCTYPE html>
<html lang="id_id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Aktivasi AKun</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #3498db;
        }

        p {
            margin-bottom: 15px;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Halo!</h2>
        <p>Anda menerima email ini karena kami menerima permintaan penjualan Seafood</p>
        <p>Mohon Maaf untuk saat ini, seafood anda belum bisa kami verifikasi untuk dijual dengan beberapa alasan
            dibawah ini : </p>
        <ol>
            @php
                unset($respon['_token']);
            @endphp

            @foreach ($respon as $index => $res)
                <li>{{ $res }}</li>
            @endforeach
        </ol>
    </div>
</body>

</html>
