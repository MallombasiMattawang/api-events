<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Telah Diterima</title>
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

        .profile-card {
            display: flex;
            align-items: center;
            padding: 20px;
            background-color: #e9ecef;
            border-radius: 8px;
        }

        .profile-card .details {
            flex: 1;
        }

        .qr-code {
            margin-left: auto;
            /* Meletakkan QR Code di ujung kanan */
        }

        .qr-code img {
            width: 150px;
            /* Sesuaikan ukuran QR Code sesuai kebutuhan */
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pembayaran Telah Diterima</h1>
        </div>
        <div class="content">
            <p>Halo {{ $eventMember->first_name }} {{ $eventMember->last_name }},</p>
            <p>Kami dengan senang hati menginformasikan bahwa pembayaran Anda telah diterima.</p>
            <p>Terima kasih telah melakukan transaksi pada event kami. Berikut adalah informasi pendaftaran Anda:</p>

            <div class="profile-card">
                <div class="details">
                    <p><strong>Event:</strong> {{ $eventMember->event->title }}</p>
                    <p><strong>Kategori:</strong> {{ $eventMember->eventCategory->name }}</p>
                    <p><strong>Nomor BIB:</strong> {{ $eventMember->name_bib }}</p>
                </div>
                <div class="qr-code">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ $eventMember->name_bib }}&size=150x150" alt="QR Code">
                </div>
            </div>

            <p style="color:red">Harap membawa bukti email ini untuk pendaftaran ulang dan pengambilan Godybag. Terimakasih</p>


        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Otoritas Banda udara Wilayah 5 Makassar. Semua Hak Dilindungi.</p>
        </div>
    </div>
</body>
</html>
