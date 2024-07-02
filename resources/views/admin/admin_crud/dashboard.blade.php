@extends('admin.layout.master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Kriteria</span>
                            <span class="info-box-number">
                                {{ \App\Models\Kriteria::count() }}
                                <small>Kriteria</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-map"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Kelurahan</span>
                            <span class="info-box-number">
                                {{ \App\Models\Kelurahan::count() }}
                                <small>Kelurahan</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>             
            </div>
            <!-- solid sales graph -->
            <div class="card bg-gradient-info">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="fas fa-th mr-1"></i>
                            Grafik Jumlah Data UMKM Pertahun
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas class="chart" id="line-chart" style="min-height: 450px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card -->
        </div>
    </section>
</div>

<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('line-chart').getContext('2d');
    
    // Ambil data dari tabel data, kelurahan, dan tahun
    var dataItems = @json(\DB::table('data')
        ->select(\DB::raw('kelurahan_id, COUNT(*) as jumlah'))
        ->groupBy('kelurahan_id')
        ->get());
    
    var kelurahanItems = @json(\App\Models\Kelurahan::all());
    var tahunItems = @json(\App\Models\Tahun::all());
    
    // Olah data untuk chart
    var kelurahanData = dataItems.map(function(item) {
        var kelurahan = kelurahanItems.find(kelurahan => kelurahan.id === item.kelurahan_id);
        var tahun = tahunItems.find(tahun => kelurahan && kelurahan.tahun_id === tahun.id);
        return {
            year: tahun ? tahun.year : 'Unknown',
            jumlah: item.jumlah
        };
    });

    // Mengelompokkan data berdasarkan tahun dan menjumlahkan
    var chartData = kelurahanData.reduce(function(acc, item) {
        var found = acc.find(data => data.year === item.year);
        if (found) {
            found.jumlah += item.jumlah;
        } else {
            acc.push({ year: item.year, jumlah: item.jumlah });
        }
        return acc;
    }, []);

    // Mengurutkan data berdasarkan tahun
    chartData.sort((a, b) => (a.year > b.year) ? 1 : ((b.year > a.year) ? -1 : 0));
    
    var labels = chartData.map(function(item) {
        return item.year;
    });
    
    var data = chartData.map(function(item) {
        return item.jumlah;
    });

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Data UMKM',
                data: data,
                backgroundColor: 'rgba(255, 255, 255, 0)',
                borderColor: 'rgba(255, 255, 255, 1)',
                borderWidth: 3, // Menjadikan garis lebih tebal
                fill: false,
                pointBackgroundColor: 'rgba(255, 255, 255, 1)',
                pointBorderColor: 'rgba(255, 255, 255, 1)',
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHitRadius: 10,
                pointBorderWidth: 2,
                pointStyle: 'circle'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'rgba(255, 255, 255, 1)' // Warna angka label sumbu y
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.2)' // Warna grid sumbu y
                    }
                },
                x: {
                    ticks: {
                        color: 'rgba(255, 255, 255, 1)' // Warna angka label sumbu x
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.2)' // Warna grid sumbu x
                    }
                }
            },
            elements: {
                line: {
                    tension: 0.4 // Membuat garis lurus (tanpa kurva)
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'rgba(255, 255, 255, 1)' // Warna label legend
                    }
                }
            }
        }
    });
});
</script>
@endsection
