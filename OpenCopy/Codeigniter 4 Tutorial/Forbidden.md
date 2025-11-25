```html

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f7fa;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: #ffffff;
            width: 400px;
            padding: 40px 30px;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .box h1 {
            font-size: 60px;
            margin: 0;
            color: #ff4d4f;
            font-weight: bold;
        }

        .box h2 {
            margin-top: 10px;
            font-size: 26px;
            color: #333;
        }

        .box p {
            margin-top: 8px;
            font-size: 15px;
            color: #666;
        }

        .btn {
            margin-top: 25px;
            display: inline-block;
            padding: 12px 20px;
            font-size: 15px;
            background: #4a89dc;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #357bd8;
        }

        .icon-lock {
            font-size: 65px;
            color: #ff4d4f;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="icon-lock">🔒</div>

        <h2>Akses Ditolak</h2>
        <p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>

        <a href="<?= base_url() ?>" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>

```