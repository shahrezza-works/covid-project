<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/images/location.png" sizes="32x32">
    <link rel="icon" href="/assets/images/location.png" sizes="192x192">
    <link rel="apple-touch-icon-precomposed" href="/assets/images/location.png">
    <title>Registration Form</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="/assets-admin/css/bootstrap.min.css" rel="stylesheet" />
    <style>
      html, body {
      min-height: 100%;
      }
      body, div, form, input, p { 
      padding: 0;
      margin: 0;
      outline: none;
      font-family: Roboto, Arial, sans-serif;
      font-size: 14px;
      color: #666;
      line-height: 22px;
      }
      h1 {
      font-weight: 400;
      }
      h4 {
      margin: 15px 0 4px;
      }
      .testbox {
      display: flex;
      justify-content: center;
      align-items: center;
      height: inherit;
      padding: 3px;
      }
      form {
      width: 100%;
      padding: 20px;
      background: #fff;
      box-shadow: 0 2px 5px #ccc; 
      }
      input {
      width: calc(100% - 10px);
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 3px;
      vertical-align: middle;
      }
      .email {
      display: block;
      width: 45%;
      }
      input:hover, textarea:hover {
      outline: none;
      border: 1px solid #095484;
      }
      th, td {
      width: 15%;
      padding: 15px 0;
      /* border-bottom: 1px solid #ccc; */
      text-align: center;
      vertical-align: unset;
      line-height: 18px;
      font-weight: 400;
      word-break: break-all;
      }
      .first-col {
      width: 16%;
      text-align: left;
      }
      table {
      width: 100%;
      }
      textarea {
      width: calc(100% - 6px);
      }
      .btn-block {
      margin-top: 20px;
      text-align: center;
      }
      button {
      width: 150px;
      padding: 10px;
      border: none;
      -webkit-border-radius: 5px; 
      -moz-border-radius: 5px; 
      border-radius: 5px; 
      background-color: #095484;
      font-size: 16px;
      color: #fff;
      cursor: pointer;
      }
      button:hover {
      background-color: #0666a3;
      }
      @media (min-width: 568px) {
      th, td {
      word-break: keep-all;
      }
      }

      h6 {
          margin-top: 0.75rem;
      }

      .radio-setting {
          width: 10%;
      }
    </style>
  </head>
  <body>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                <div class="alert alert-success notification" role="alert">
                    {{ session('status') }}
                </div>
                @endif
        
                @if (session('status_error'))
                <div class="alert alert-danger notification" role="alert">
                    {{ session('status_error') }}
                </div>
                @endif
            </div>
        </div>
    </div>
    

    <div class="testbox">
        <form action="/form/kontraktor/submit/{{ md5($location_id) }}" method="POST">
        @csrf
        <input type="hidden" name="lid" value="{{ md5($location_id) }}">
        <h2>Borang Pengisytiharan Kesihatan Harian (COVID-19) untuk Kontraktor</h2>
        <hr />

        <p class="pb-2" style="color: rgb(255, 11, 52);"><i>***Sila baca semua maklumat tertera</i></p>
        <br>


        <h3>Lokasi Pendaftaran / Registration Location:</h3>

        <h5>Nama Premis / Premise Name :</h5>
        <h2>{{ $nama_premis }}</h2>
        @if (!empty($nama_bangunan))
            <h5>Nama Bangunan / Building Name :</h5>
            <h2>{{ $nama_bangunan }}</h2>
        @endif
        <h5>Kawasan / Area :</h5>
        <h2>{{ $kawasan }}</h2>
        <br>

        <div class="container-fluid">
            <p>Sila masukkan butiran berikut:</p>
            <p><i>Please fill in the following details:</i></p>
            <br>

            <h4 class="mb-4">Maklumat Diri / Personal Information</h4>

            <h6>Nama / Name <span style="color: red;">*</span></h6>
            <input class="form-control" type="text" name="nama" maxlength="200" required>
            
            <h6>Nombor Telefon / Phone Number  <span style="color: red;">*</span></h6>
            <input class="form-control" type="text" name="no_tel" minlength="10" maxlength="20" required>

            @if ($type == 1)
            <h6 class="mt-2">Suhu / Temperature <span style="color: red;">*</span></h6>
            <input type="number" name="suhu" step="0.01" max="50" class="col-md-2" required> 
            <br>
            <br>
            @endif
            
            <br>
        </div>

        <br>

        <h5>Dalam 14 hari yang lalu, adakah anda:<span style="color: red;">*</span>
        <br><i>In the last 14 days, have you:</i></h5>

        <ul>
            <li>Mengalami sebarang simptom COVID-19 (demam, batuk, sesak nafas, sakit tekak)?
                <br><i>Been exhibiting any COVID-19 symptoms (fever, cought, shortness of breath, sore throat)?</i>
            </li>
            <li>Berhubung rapat dengan pesakit positif COVID-19?
                <br><i>Had close contact with COVID-19 positive patient?</i>
            </li>
        </ul>
        
        <table style="width: 0;">
            <tr>
                <td><input type="radio" name="verify" value="0" style="width: 5%;" required>Tidak / No</td>
            </tr>
            <tr>
                <td><input type="radio" name="verify" value="1" style="width: 5%;" required>Ya / Yes</td>
            </tr>
        </table>

        <p class="mt-2">Dengan ini, saya mengakui bahawa butiran yang diisi adalah betul dan tepat. <span style="color: red;">*</span></p>
        <p class="mt-2">I hereby acknowledge that the information given in this form is correct and accurate.</p>
        <div class="mt-4">
            <input type="checkbox" name="agree" value="1" style="width: 15%;" required>Setuju / Agree
        </div>
        

        <div class="mt-4 btn-block">
          <button type="submit" href="/">Hantar / Submit</button>
        </div>

      </form>

    </div>
    <script src="/assets-admin/js/core/jquery.min.js"></script>
    <script src="/assets-admin/js/core/bootstrap.min.js"></script>
  </body>
</html>