<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/assets/images/location.png" sizes="32x32">
    <link rel="icon" href="/assets/images/location.png" sizes="192x192">
    <link rel="apple-touch-icon-precomposed" href="/assets/images/location.png">
    <title>Pendaftaran Berjaya!</title>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="/assets-admin/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <style>
        .text-grey{
            color: #444444;
        }

    </style>
    
    <div class="mt-4">
        <center>
            <h4>RESIT PENGESAHAN</h4>
        </center>
    </div>

    <div class="container-fluid mb-4">
        <center>
            <p><i>"Terima kasih kerana menyertai usaha membendung wabak COVID-19"</i></p>

            <p>Tunjukkan resit pengesahan ini kepada pekedai/pemilik premis ini untuk direkodkan <b>suhu</b>. Resit pengesahan ini digunakan untuk pengesahan visual sahaja.</p>

            <p>Kepada pekedai/pemilik premis, sila pastikan kesahihan nama premis dan tarikh resit ini.</p>

            <h4>Tarikh:</h4>
            <h3 class="text-grey">{{ $waktu_pendaftaran }}</h3>

            <h4 class="mt-4">Lokasi:</h4>
            <h3 class="text-grey">{{ $nama_premis }}</h3>
            @if (!empty($nama_bangunan))
            <h3 class="text-grey">{{ $nama_bangunan }}</h3>
            @endif
            <h3 class="text-grey">{{ $kawasan }}</h3>

            @if (!empty($no_tel))
            <h4 class="mt-4">Nombor telefon yang didaftarkan:</h4>
            <h3 class="text-grey">{{ $no_tel }}</h3>
            @endif

            @if (!empty($no_pekerja))
            <h4 class="mt-4">Nombor pekerja yang didaftarkan:</h4>
            <h3 class="text-grey">{{ $no_pekerja }}</h3>
            @endif
        </center>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <p class="mt-4 mt-4" style="text-align: center">
                    Dengan pengesahan ini, anda telah mengisytiharkan bahawa: 
    
                    <ul>
                        <li>Semua butiran yang diisi adalah tepat dan benar.</li>
                        <li>Anda tiada sebarang simptom demam atau selsema.</li>
                    </ul>

                </p>
            </div>
            <div class="col-md-4"></div>
        </div>

    </div>
    <script src="/assets-admin/js/core/jquery.min.js"></script>
    <script src="/assets-admin/js/core/bootstrap.min.js"></script>
</body>
</html>