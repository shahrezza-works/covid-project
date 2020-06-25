
@extends('layouts.master')

@section('title')
    Temperature | COVID-19 - Check In
@endsection

@section('top_title')
    Temperature
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
<h4 style="margin-top:0%;">Filter</h4>
<form method="GET" action="/temperature/filter">

    {{ csrf_field() }}
    <div class="row mb-2">
        <div class="col-md-12">
            <label>Location</label>
            <select name="location_select" class="form-control" required>
                <option value="">Pilih...</option>
                @foreach ($location as $item)
                <option value="{{ $item->id }}" {{ ($item->id == $location_select)?'selected':'' }}>{{ $item->nama.' - '.$item->nama_premis.(!empty($item->nama_bangunan)?' - '.$item->nama_bangunan.' - ':' - ').$item->kawasan }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-12">
            <label>Date</label>
            <input name="tarikh" type="date" value="{{ $date_select }}" class="form-control col-md-3" required>
        </div>
    </div>

    <a href="/temperature" class="btn btn-secondary">Reset</a>
    <button type="submit" class="btn btn-primary">Search</button>
</form>

<div class="row">
    <div class="col-md-12">
        <table id="_table">
            <thead>
                <tr>
                    <th></th>
                    <th>Nama</th>
                    <th> @if ($borang_type == 1)
                        No. Pekerja
                    @else
                        No. Telefon
                    @endif </th>
                    <th>Suhu (&#176;C)</th>
                    <th>Action</th>
                    {{-- 
                    <
                    <th>Poskod</>
                    <th>Kawasan</th>
                    <th>Negeri</th>
                    
                    <th>QR Code</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($table_data as $data)
                <tr>
                    <td></td>
                    <td>@if ($borang_type == 1 || $borang_type == 3)
                        {{ $data->nama }}
                    @else
                        {{ $data->name }}
                    @endif</td>
                    <td>@if ($borang_type == 1)
                        {{ $data->no_pekerja }}
                    @elseif ($borang_type == 3)
                        {{ $data->no_tel }}
                    @else
                        {{ $data->phone }}
                    @endif</td>
                    <td>{{ $data->suhu }}</td>
                    <td>
                        <button class="btn btn-secondary" onclick="updateSuhu({{ $data->id }})">update</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Label">Update</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="get" action="{{ ($borang_type == 1) ? '/temperature/update_staff' : (($borang_type == 3) ? '/temperature/update_kontraktor' : '/temperature/update') }}">
            <div id="location-details" class="modal-body">
                <input type="hidden" name="respon_id" id="respon_id">
                {{ csrf_field() }}
                <input type="hidden" name="location_select" value="{{ $location_select }}">
                <input type="hidden" name="tarikh" value="{{ $date_select }}">
                <div class="row">
                    <div class="col-3">
                        <label class="font-weight-bold">Nama</label>
                    </div>
                    <div>
                        <span id="nama_pelawat"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <label class="font-weight-bold">@if ($borang_type == 1)
                        No Pekerja
                        @else
                        No Telefon
                        @endif</label>
                    </div>
                    <div>
                        <span id="no_tel"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <label class="font-weight-bold">Suhu (&#176;C)</label>
                    </div>
                    <div>
                        <input id="suhu" class="form-control" name="suhu" type="number" step="0.01" max="50" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="update" type="submit" class="btn btn-success">Yes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
        </form>
      </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            // $('#table_id').DataTable();
            var t = $('#_table').DataTable( {
                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                } ],
                "order": [[ 1, 'asc' ]],
            } );
        
            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        })
        <?php if($borang_type == 1){ ?>
        function updateSuhu(respon)
        {//anggota kerja
            $.get('/temperature/details_staff/?rid='+respon, function(res){
                // console.log(res);
                if(res.status){
                    $('#respon_id').val(res.data[0].id);
                    $('#nama_pelawat').text(res.data[0].nama);
                    $('#no_tel').text(res.data[0].no_pekerja);
                    $('#suhu').val(res.data[0].suhu);
                    $('#updateModal').modal({backdrop: 'static', keyboard: false})
                }else{
                    alert(res.message);
                }
            })
        }
        <?php }elseif($borang_type == 3){ ?>
        function updateSuhu(respon)
        {//kontraktor
            $.get('/temperature/details_kontraktor/?rid='+respon, function(res){
                // console.log(res);
                if(res.status){
                    $('#respon_id').val(res.data[0].id);
                    $('#nama_pelawat').text(res.data[0].nama);
                    $('#no_tel').text(res.data[0].no_tel);
                    $('#suhu').val(res.data[0].suhu);
                    $('#updateModal').modal({backdrop: 'static', keyboard: false})
                }else{
                    alert(res.message);
                }
            })
        }  
        <?php }else{ ?>
        function updateSuhu(respon)
        {//pelawat
            $.get('/temperature/details?rid='+respon, function(res){
                // console.log(res);
                if(res.status){
                    $('#respon_id').val(res.data[0].id);
                    $('#nama_pelawat').text(res.data[0].name);
                    $('#no_tel').text(res.data[0].phone);
                    $('#suhu').val(res.data[0].suhu);
                    $('#updateModal').modal({backdrop: 'static', keyboard: false})
                }else{
                    alert(res.message);
                }
            })
        }
        <?php } ?>

    </script>
@endsection