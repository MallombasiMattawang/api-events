<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px 0;
        }

        .header img {
            width: 150px;
        }

        .content {
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            font-size: 0.9em;
            color: #6c757d;
        }

        .invoice-details {
            margin-top: 20px;
            border-top: 2px solid #e9ecef;
            padding-top: 20px;
        }

        .invoice-details p {
            margin-bottom: 10px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Invoice Pembayaran</h1>
        </div>
        <div class="content">
            <p>Halo {{ $eventMember->first_name }} {{ $eventMember->last_name }},</p>
            <p>Berikut adalah detail invoice pembayaran Event <b>{{ $eventMember->event->title }}</b> Kategori <b>{{ $eventMember->eventCategory->name }}</b> Anda:</p>
            <p>
                Silahkan transfer sebelum pukul 23:00 Wita ke: BANK BRI A.n. xxxxx No. Rekening <strong>000-000-000-000-000</strong>
                *Mohon tuliskan berita: <b>{{ $eventMember->invoice }}</b> Pada kolom berita transfer.
            </p>

            <div class="invoice-details">
                <p><strong>Nomor Invoice:</strong> {{ $eventMember->invoice }}</p>
                <p><strong>Tanggal Invoice:</strong> {{ date('d-m-Y', strtotime($eventMember->created_at)) }}</p>
                <p><strong>Total Pembayaran:</strong> Rp {{ number_format($eventMember->eventCategory->cost, 0, ',', '.') }}</p>
                <!-- Tambahkan informasi lain sesuai kebutuhan, misalnya metode pembayaran, deskripsi, dll. -->
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Otoritas Banda udara Wilayah 5 Makassar. Semua Hak Dilindungi.</p>

        </div>
    </div>
</body>
</html>
