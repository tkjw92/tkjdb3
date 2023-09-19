@extends('guru.layouts.main')

@section('judul')
    Index Dashboard
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Summary</h5>
        </div>

        <div class="card-body row">
            <div class="col">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $siswa }}</h3>

                        <p>Siswa</p>
                    </div>
                    <div class="icon text-white">
                        <i class="fas fa-user"></i>
                    </div>
                    <a href="/guru/data/data-siswa" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $kelas }}</h3>

                        <p>Kelas</p>
                    </div>
                    <div class="icon text-white">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="/guru/data/data-kelas" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $guru }}</h3>

                        <p>Guru</p>
                    </div>
                    <div class="icon text-white">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <a href="/guru/data/data-guru" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $dudi }}</h3>

                        <p>DuDi</p>
                    </div>
                    <div class="icon text-white">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="/guru/data/data-dudi" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>Soal Summary</h5>
        </div>
        <div class="card-body">
            <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

@section('script')
    <!-- ChartJS -->
    <script src="/AdminLTE/plugins/chart.js/Chart.min.js"></script>

    <script>
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData = {
            labels: [
                'Asesmen',
                'PTS',
                'PAS',
                'USP',
                'UKK',
            ],
            datasets: [{
                data: [{{ $asesmen }}, {{ $pts }}, {{ $pas }}, {{ $usp }}, {{ $ukk }}],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
            }]
        }
        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        })
    </script>
@endsection
