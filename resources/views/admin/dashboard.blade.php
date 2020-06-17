
@extends('layouts.master')

@section('title')
    Dashboard | COVID-19 - Check In
@endsection

@section('top_title')
    Dashboard
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
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="w-100">
                    <h6>Jumlah Daftar Masuk</h6>
                </div>
                <div class="w-50 text-left">
                    <i class="fas fa-map-marked fa-3x" style="color: salmon"></i>
                </div>
                <div class="w-100 text-right">
                    <h2 style="margin-bottom:5px;">{{$total_respon}}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="w-100">
                    <h6>Jumlah Daftar Masuk Unik</h6>
                </div>
                <div class="w-50 text-left">
                    <i class="fas fa-phone fa-3x" style="color: salmon"></i>
                </div>
                <div class="w-100 text-right">
                    <h2 style="margin-bottom:5px;">{{$total_unique_respon}}</h2>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div id="container-chart">

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="https://code.highcharts.com/highcharts.src.js"></script>

    <script>
        Highcharts.chart('container-chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Jumlah Keseluruhan Daftar Masuk Berdasarkan Suhu Badan (Normal vs Tidak Normal)'
            },
            // subtitle: {
            //     text: 'Source: WorldClimate.com'
            // },
            xAxis: {
                labels: {
                    enabled: false
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Keseluruhan Daftar Masuk'
                }
            },
            tooltip: {
                headerFormat: '',
            //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            //         '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            //     footerFormat: '</table>',
            //     shared: true,
            //     useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Kurang 37.5 C',
                data: [{{ $suhu_normal }}]

            }, {
                name: 'Lebih 37.5 C',
                data: [{{ $suhu_xnormal }}]

            }, {
                name: 'Tidak Dinyatakan',
                data: [{{ $suhu_null }}]

            }]
        });
    </script>
@endsection