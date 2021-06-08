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
        <form method="post" action="/form/staff/clockoutprocess">
            <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="clockout" value="{{ date('H:i:s') }}">
            <div class="row">
                <div class="col-12">
                <img src="/assets/images/site-logo.svg" alt="Company Logo" style="margin-bottom:10px;" width="300px">
                </div>
                @csrf
                
                <div class="col-12">
                    <h2>Rekod Clock Out untuk <br>Staff ILSAS</h2>
                </div>
                <hr />

                <div class="container-fluid" style="display: block;">
                    <p>Sila masukkan butiran berikut:</p>
                    <p><i>Please fill in the following details:</i></p>
                    <br>
                    
                </div>
                <div class="col-md-3 col-xs-12">
                    <h6>No. Pekerja / Staff No. <span style="color: red;">*</span></h6>
                    <p style="color:red;">Sila masukkan nombor pekerja tanpa ruang seperti contoh di bahawa /</p>
                    <p style="color:red;">Please enter staff number without space as below</p>
                    <p>Contoh / Example:</p>
                    <p style="color:red;">10098764</p>
                    <p style="color:red;">ILS0062</p>
                    <p style="color:red;">VPT1000</p>
                    <p style="color:red;">PB1000</p>
                    <input style="text-transform: uppercase;" id="no_pekerja" 
                        class="form-control" type="text" name="no_pekerja" maxlength="9" value="{{ Cookie::get('no_pekerja') }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-4 mt-4">
                    <button type="submit" href="/">Hantar / Submit</button>
                </div>
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