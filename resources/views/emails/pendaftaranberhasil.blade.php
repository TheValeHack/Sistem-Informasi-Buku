@php
    date_default_timezone_set('Asia/Jakarta');
    setlocale(LC_TIME, 'id_ID.UTF-8');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pendaftaran berhasil</title>
</head>
<body>
    <div style="width:100%;padding:12px;background:#dff0d8;color:#3c763d;border:1px solif #d6e9c6;">
        Anda berhasil terdaftar
    </div>
    <div>
        <h3>Sistem Informasi Buku PPW2</h3>
        Selamat <b>{{ $data['name'] }}</b>
        <br><br>
        Anda berhasil mendaftarkan akun anda ({{$data["email"]}}) pada sistem kami di jam {{date('h:i')}} pada {{strftime('%A, %d %B %Y', time()) }}
    </div>
</body>
</html>