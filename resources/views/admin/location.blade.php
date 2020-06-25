
@extends('layouts.master')

@section('title')
    Location | COVID-19 - Check In
@endsection

@section('top_title')
    Location
@endsection

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
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
<div class="row">
    <div class="col-md-12">
        <a type="button" class="btn btn-primary" href="/location/create">CREATE LOCATION</a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table id="location_table">
            <thead>
                <tr>
                    <th></th>
                    <th>Nama Premis</th>
                    <th>No. Telefon Premis</th>
                    <th>Poskod</th>
                    <th>Kawasan</th>
                    <th>Negeri</th>
                    <th>Jenis Borang</th>
                    <th>Action</th>
                    <th>QR Code</th>
                    <th>Get Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($location_list as $data)
                <tr>
                    <td></td>
                    <td>{{ $data->nama_premis }}</td>
                    <td>{{ $data->tel_premis }}</td>
                    <td>{{ $data->poskod }}</td>
                    <td>{{ $data->kawasan }}</td>
                    <td>{{ $data->negeri }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>
                        <a class="btn btn-secondary" href="/location/edit/{{ $data->id }}">EDIT</a>
                        <a class="btn btn-danger" href="javascript:;" onclick="confirmDelete({{ $data->id }})">REMOVE</a>
                    </td>
                    <td>
                        <a class="btn btn-success" target="_blank" href="/location/generate/{{ rawurlencode(openssl_encrypt($data->id.'|'.Auth::user()->id.'|'.time(), $ciphering, 
                            $encryption_key, $options, $encryption_iv)) }}">
                            <i class="fas fa-qrcode fa-2x"></i>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="/location/getdata/{{ md5($data->id) }}" target="_blank"><i class="fas fa-download"></i></a>
                    </td>
                </tr>
                @endforeach
                {{-- <tr>
                    <td></td>
                    <td>dua</td>
                    <td>dua</td>
                    <td>dua</td>
                    <td>dua</td>
                    <td><a target="_blank" href="https://google.com" class="btn btn-success">Go</a></td>
                </tr> --}}
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="comfirmationLabel">Comfirm Delete?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="location-details" class="modal-body">
            <div class="row">
                <div class="col-3">
                    <label class="font-weight-bold">Nama Premis</label>
                </div>
                <div>
                    <span id="nama_premis"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label class="font-weight-bold">No Telefon Premis</label>
                </div>
                <div>
                    <span id="tel_premis"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label class="font-weight-bold">Poskod</label>
                </div>
                <div>
                    <span id="poskod"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label class="font-weight-bold">Kawasan</label>
                </div>
                <div>
                    <span id="kawasan"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label class="font-weight-bold">Bandar</label>
                </div>
                <div>
                    <span id="bandar"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label class="font-weight-bold">Negeri</label>
                </div>
                <div>
                    <span id="negeri"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
                <a id="confirmDeleteBtn" href="javascript:;" class="btn btn-danger" >Yes</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        </div>
      </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            // $('#table_id').DataTable();
            var t = $('#location_table').DataTable( {
                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                } ],
                "order": [[ 1, 'asc' ]]
            } );
        
            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        })

        function confirmDelete(i)
        {
            $('#confirmation').modal();

            $.get('/location/single/'+i,function(res){
                var details = JSON.parse(res);
                $('#nama_premis').text(details['nama_premis']);
                $('#tel_premis').text(details['tel_premis']);
                $('#poskod').text(details['poskod']);
                $('#kawasan').text(details['kawasan']);
                $('#bandar').text(details['bandar']);
                $('#negeri').text(details['negeri']);

                $('#confirmDeleteBtn').attr('href','/location/delete/'+details['id']);
            })
        }
    </script>
@endsection