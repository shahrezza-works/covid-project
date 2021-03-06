<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/images/location.png" sizes="32x32">
    <link rel="icon" href="/assets/images/location.png" sizes="192x192">
    <link rel="apple-touch-icon-precomposed" href="/assets/images/location.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>QR Code Poster | COVID-19 - Check In</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="/assets-admin/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets-admin/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <link href="/assets-admin/demo/demo.css" rel="stylesheet" />
    <link href="/css/fontawesome/fontawesome.css" rel="stylesheet"/>
    <link href="/css/fontawesome/brands.css" rel="stylesheet"/>
    <link href="/css/fontawesome/solid.css" rel="stylesheet"/>
</head>
<body>
    <style>
        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            border-style: solid;
            border-color: black;
            border-width: thin;
        }
        page[size="A4"] {  
            width: 21cm;
            height: 29.7cm; 
        }
    </style>
    <page size="A4">
        <br>
        <center>
            {{-- <img src="https://tnbilsas.com.my/wp-content/uploads/2019/09/ilsas-logo.png" alt="Company Logo" width="300px"> --}}
            <img src="/assets-admin/img/ilsas-logo.png" alt="Company Logo" width="400px">
            <h2 style="margin-top:1.5em;font-weight:600;">SCAN WITH YOUR MOBILE PHONE<br>TO CHECK IN</h2>
            <img src="{{ $QRimage }}" alt="QR code image" style="border-style: dotted;" width="300">

            <h3 class="mt-4">
                <b>{{ $data->nama_premis }}</b>
            </h3>
            
            @if(!empty($data->nama_bangunan))
            <h4 class="mt-0">
                <b>{{ $data->nama_bangunan }}</b>
            </h4>
            @endif

            <h4 class="mt-0">
                <b>{{ $data->kawasan }}</b>
            </h4>

            <h5 class="footer">Please scan using your mobile camera<br>or QR code reader</h5>
        </center>
    </page>
    
        {{-- <div class="row"> --}}
            {{-- <div class="col-md-4">
                <a class="btn btn-primary" style="width:100%;" href="javascript:window.print()">Cetak</a>
            </div> --}}
        {{-- </div> --}}
    
    

    <!--   Core JS Files   -->
    <script src="/assets-admin/js/core/jquery.min.js"></script>
    <script src="/assets-admin/js/core/popper.min.js"></script>
    <script src="/assets-admin/js/core/bootstrap.min.js"></script>
    
</body>
</html>