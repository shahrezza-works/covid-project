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
        <form action="/form/staff/submit/{{ md5($location_id) }}" method="POST">
        <img src="https://tnbilsas.com.my/wp-content/uploads/2019/09/ilsas-logo.png" alt="Company Logo" style="margin-bottom:10px;" width="300px">
        @csrf
        <input type="hidden" name="clockin" value="{{ date('H:i:s') }}">
        <input type="hidden" name="lid" value="{{ md5($location_id) }}">
        <h2>Borang Pengisytiharan Kesihatan Harian (COVID-19) untuk Staff ILSAS</h2>
        <hr />

        <p class="pb-2">Rekod pemeriksaan kesihatan untuk anggota kerja dan pengisytiharan sebelum perjalanan ke pejabat.</p>
        <p class="pb-2">Sila isi pada hari yang sama ke pejabat.</p>
        <p class="pb-2">Sila hubungi HR jika ada sebarang kekeliruan atau pertanyaan.</p>
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
            <input class="form-control" type="text" name="nama" maxlength="200" value="{{ Cookie::get('nama') }}" required>
            
            <h6>No. Pekerja / Staff No. <span style="color: red;">*</span></h6>
            <p style="color:red;">Sila masukkan nombor pekerja tanpa ruang seperti contoh di bahawa /</p>
            <p style="color:red;">Please enter staff number without space as below</p>
            <p>Contoh / Example:</p>
            <p style="color:red;">10098764</p>
            <p style="color:red;">ILS0062</p>
            <p style="color:red;">VPT1000</p>
            <p style="color:red;">PB1000</p>
            <input style="text-transform: uppercase;" id="no_pekerja" class="form-control" type="text" name="no_pekerja" maxlength="9" value="{{ Cookie::get('no_pekerja') }}" required>

            <h6>Jabatan <span style="color: red;">*</span></h6>
            <select class="form-control" name="jabatan" required>
                <option value="">Pilih...</option>
                @foreach ($jabatan as $item)
                <option value="{{ $item->name }}" {{ (Cookie::get('jabatan') ==  $item->name) ? 'selected' : '' }} >{{ $item->name }}</option>
                @endforeach
                {{-- <option value="SDI">SDI</option>
                <option value="AMTEC">AMTEC</option>
                <option value="BTC">BTC</option>
                <option value="LMTC">LMTC</option>
                <option value="FINANCE">FINANCE</option>
                <option value="OS">OS</option>
                <option value="LDAC">LDAC</option>
                <option value="SMD">SMD</option>
                <option value="BDM">BDM</option>
                <option value="ICG">ICG</option>
                <option value="MALIM NAWAR">MALIM NAWAR</option>
                <option value="KULAI">KULAI</option>
                <option value="MD OFFICE">MD OFFICE</option>
                <option value="Others - TNB Staff">Others - TNB Staff</option> --}}
            </select>

            <h6>Lokasi Bekerja <span style="color: red;">*</span></h6>
            <select class="form-control" name="lokasi" required>
                <option value="">Pilih...</option>
                <option value="WFH">Work From Home</option>
                <option value="WFO">Work From Office</option>
            </select>

            <br>
            <h4>Status Kesihatan / Health Status</h4>
            <p class="col-mb-2">Tandakan "YA" atau "TIDAK" jika anda mempunyai gejala-gejala dibawah</p>
            <p class="col-mb-2">Anda akan dinilai berdasarkan maklumat dibawah</p>
            <br>

            <h6 class="mt-4">Demam / Fever ? <span style="color: red;">*</span></h6>
            <div class="mb-4">
                <input class="radio-setting" type="radio" name="demam" value="1" required> YA
            </div>
            <div>
                <input class="radio-setting" type="radio" name="demam" value="0" required> TIDAK
            </div>

            <hr>

            <h6 class="mt-4">Selsema / Flu ? <span style="color: red;">*</span></h6>
            <div class="mb-4">
                <input class="radio-setting" type="radio" name="selsema" value="1" required> YA
            </div>
            <div>
                <input class="radio-setting" type="radio" name="selsema" value="0" required> TIDAK
            </div>

            <hr>

            <h6 class="mt-4">Batuk / Cough ? <span style="color: red;">*</span></h6>
            <div class="mb-4">
                <input class="radio-setting" type="radio" name="batuk" value="1" required> YA
            </div>
            <div>
                <input class="radio-setting" type="radio" name="batuk" value="0" required> TIDAK
            </div>

            <hr>

            <h6 class="mt-4">Sesak Nafas / Breathing Difficulties ? <span style="color: red;">*</span></h6>
            <div class="mb-4">
                <input class="radio-setting" type="radio" name="sesak_nafas" value="1" required> YA
            </div>
            <div>
                <input class="radio-setting" type="radio" name="sesak_nafas" value="0" required> TIDAK
            </div>

            <hr>

            <h6 class="mt-4">Sakit-sakit Sendi / Joint Pain ? <span style="color: red;">*</span></h6>
            <div class="mb-4">
                <input class="radio-setting" type="radio" name="sakit_sendi" value="1" required> YA
            </div>
            <div>
                <input class="radio-setting" type="radio" name="sakit_sendi" value="0" required> TIDAK
            </div>

            <hr>

            <h6 class="mt-4">Hilang Deria Rasa / Loss Sense of Taste ? <span style="color: red;">*</span></h6>
            <div class="mb-4">
                <input class="radio-setting" type="radio" name="deria_rasa" value="1" required> YA
            </div>
            <div>
                <input class="radio-setting" type="radio" name="deria_rasa" value="0" required> TIDAK
            </div>

            <hr>

            <h6 class="mb-2" style="line-height: 1.8;">
            Adakah anda sedang hamil? 
            </h6>
            <div class="mb-4">
            <input class="radio-setting" type="radio" name="hamil" value="1" required> YA
            </div>      
            <div>
                <input class="radio-setting" type="radio" name="hamil" value="0" checked="checked" required > TIDAK
            </div>

            <br>
            <h4>Deklarasi / Declaration</h4>
            <p class="mb-2">Anda diminta untuk menjawab "YA" atau "TIDAK" dalam borang deklarasi di bawah</p>
            <br>

            <h6 class="mb-2" style="line-height: 1.8;">Adakah anda tinggal bersama anggota barisan hadapan kesihatan yang mengendalikan pesakit COVID-19 
                (seperti doktor, jururawat dan penolong pegawai perubatan) ATAU kakitangan penerbangan (seperti juruterbang, pramugari/pramugara)
                ATAU apa-apa pekerjaan yang meningkatkan risiko jangkitan COVID-19 yang bekerja dalam tempoh 14 hari yang lepas? <span style="color: red;">*</span>
            </h6>
            <div class="mb-4">
                <input class="radio-setting" type="radio" name="deklarasi_1" value="1" required> YA
            </div>
            <div>
                <input class="radio-setting" type="radio" name="deklarasi_1" value="0" required> TIDAK
            </div>
            
            <hr>

            <h6 class="mb-2" style="line-height: 1.8;">Adakah anda pernah menghadiri perhimpunan yang melibatkan kes yang disyaki 
                (termasuk tempat beribadat, kenduri kahwin, gym dan lain-lain)? <span style="color: red;">*</span>
            </h6>
            <div class="mb-4">
                <input class="radio-setting" type="radio" name="deklarasi_2" value="1" required> YA
            </div>
            <div>
                <input class="radio-setting" type="radio" name="deklarasi_2" value="0" required> TIDAK
            </div>

            <hr>

            <h6 class="mb-2" style="line-height: 1.8;">Adakah anda kontak rapat dengan seseorang yang positif COVID-19 dalam tempoh 14 hari yang lepas? <span style="color: red;">*</span>
            </h6>
            <div class="mb-4">
                <input class="radio-setting" type="radio" name="deklarasi_3" value="1" required> YA
            </div>
            <div>
                <input class="radio-setting" type="radio" name="deklarasi_3" value="0" required> TIDAK
            </div>

            <hr>

            <h6 class="mb-2" style="line-height: 1.8;">
            Adakah anda telah berdaftar untuk menerima vaksin COVID-19? Pendaftaran boleh dilakukan di aplikasi MySejahtera atau di <a href="https://www.vaksincovid.gov.my" target="_blank">www.vaksincovid.gov.my</a>
            </h6>
            <div class="mb-4">
                <input class="radio-setting" type="radio" name="vaksin" value="1" required> YA
            </div>
            <div>
                <input class="radio-setting" type="radio" name="vaksin" value="0" required> TIDAK
            </div>

            @if ($type == 1)
            <br>
            <h5 class="mt-4">Suhu / Temperature <span style="color: red;">*</span></h5>
            <input type="number" name="suhu" step="0.01" max="50" class="col-md-2" required> 
            <br>
            <br>
            @endif
            
            <br>
        </div>
        

        {{-- <h6>Nombor Telefon / Mobile Number  <span style="color: red;">*</span></h6>
        <input type="text" name="no_tel" minlength="10" maxlength="20" required> --}}

       
        
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
    <script>
        $("input#no_pekerja").on({
            keydown: function(e) {
                if (e.which === 32)
                return false;
            },
            change: function() {
                this.value = this.value.replace(/\s/g, "");
            }
        });
    </script>
  </body>
</html>