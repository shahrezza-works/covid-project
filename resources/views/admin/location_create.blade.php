
@extends('layouts.master')

@section('title')
    Create | COVID-19 - Check In
@endsection

@section('top_title')
    Create Location
@endsection

@section('content')
<style>
    .text-red {
        color: red;
    }
</style>
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
<form method="POST" action="/location/save">
    {{ csrf_field() }}
    <div class="row mb-2">
        <div class="col-md-2">
            <label>Nama Premis <span class="text-red">*</span></label>
        </div>
        <div class="col-md-8">
            <input class="form-control" type="text" name="nama_premis" id="name_premis" placeholder="Akan dipamerkan dalam poster" maxlength="255" required>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-2">
            <label>Kategori 1 <span class="text-red">*</span></label>
        </div>
        <div class="col-md-8">
            <select class="form-control select2-js" name="kategori_1" id="kategori_1" required>
                <option value="">Pilih...</option>
                @foreach ($kategori_1 as $kategori_)
                <option value="{{ $kategori_->id }}">{{ $kategori_->description }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-2">
            <label>Kategori 2 <span class="text-red">*</span></label>
        </div>
        <div class="col-md-8">
            <select class="form-control select2-js" name="kategori_2" id="kategori_2" required>
                <option value="">Pilih...</option>
                @foreach ($kategori_2 as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->description }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-2">
            <label>No Telefon Premis <span class="text-red">*</span></label>
        </div>
        <div class="col-md-8">
            <input class="form-control" type="text" name="tel_premis" id="tel_premis" minlength="10" maxlength="20" required>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-2">
            <label>Nama Bangunan</label>
        </div>
        <div class="col-md-8">
            <input class="form-control" type="text" name="nama_bangunan" id="nama_bangunan" placeholder="Akan dipamerkan dalam poster" maxlength="255">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-2">
            <label>No. Jalan</label>
        </div>
        <div class="col-md-8">
            <input class="form-control" type="text" name="no_jalan" id="no_jalan" maxlength="100">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-2">
            <label>Nama Jalan</label>
        </div>
        <div class="col-md-8">
            <input class="form-control" type="text" name="nama_jalan" id="nama_jalan" maxlength="255">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-2">
            <label>Poskod <span class="text-red">*</span></label>
        </div>
        <div class="col-md-8">
            <input class="form-control" type="text" name="poskod" id="poskod" minlength="5" maxlength="10" required>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-2">
            <label>Seksyen / Kawasan <span class="text-red">*</span></label>
        </div>
        <div class="col-md-8">
            <input class="form-control" type="text" name="kawasan" id="kawasan" maxlength="255" placeholder="Cth: Taman Melati, Precint 12, Seksyen 12" required>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-2">
            <label>Bandar <span class="text-red">*</span></label>
        </div>
        <div class="col-md-8">
            <input class="form-control" type="text" name="bandar" id="bandar" maxlength="255" required>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-2">
            <label>Negeri <span class="text-red">*</span></label>
        </div>
        <div class="col-md-8">
            <select class="form-control" name="negeri" id="negeri" required>
                <option value="">Pilih...</option>
                @foreach ($negeri as $data)
                <option value="{{ $data->name }}">{{ $data->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            <label>Jenis Borang <span class="text-red">*</span></label>
        </div>
        <div class="col-md-3">
            <select class="form-control" name="borang" id="borang" required>
                <option value="">Pilih...</option>
                @foreach ($borang as $item)
                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-2">
            <label>Type <span class="text-red">*</span></label>
        </div>
        <div class="col-md-3">
            <select class="form-control" name="type" id="type" required>
                <option value="">Pilih...</option>
                <option value="0">On-Site Verification</option>
                <option value="1">Self Declaration</option>
            </select>
        </div>
        <div class="col-md-5">
            <ul>
                <li>On-Site Verification: Suhu akan diperiksa oleh pegawai yang bertugas dan petugas akan merekodkan suhu ke dalam sistem.</li>
                <li>Self Declaration: Suhu akan diperiksa oleh pegawai yang bertugas dan responden akan merekodkan suhu di dalam borang pendaftaran.</li>
            </ul>
        </div>
    </div>

    

    <button class="btn btn-success" type="submit">Save</button>
</form>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.select2-js').select2({width:'100%'});

            
        })

        $('#tel_premis').change(function(){
            var tel_premis = $('#tel_premis').val();
            
            if(tel_premis != ''){
                String.prototype.isNumber = function(){return /^\d+$/.test(this);}
                if(tel_premis.isNumber()){
                    if(tel_premis.length < 10){
                        $('.invalid-feedback').remove();
                        $('#tel_premis').parent().append('<span class="invalid-feedback" role="alert"><strong>This phone number to short!</strong></span>');
                        $('.invalid-feedback').show();
                        return false;
                    }else{
                        $('.invalid-feedback').remove();
                        return false;
                    }
                }else{
                    $('.invalid-feedback').remove();
                    $('#tel_premis').parent().append('<span class="invalid-feedback" role="alert"><strong>Not valid phone number!<br/>Do not put spaces, -, + and any symbols.</strong></span>');
                    $('.invalid-feedback').show();
                    return false;
                }
            }
        });

        
    </script>
@endsection