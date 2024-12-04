@extends('dashboard.master')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-primary shadow-sm h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Fitter</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$employe}}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tasks Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-info shadow-sm h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Criteria</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$criteria}}</div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Annual) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-success shadow-sm h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Assessement</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$assessment_success}}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-check fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center text-dark">
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4>Grafik Pemilihan Fitter Terbaik</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                  @if($decision_id)
                    <form action="{{ route('home') }}" method="get">
                        <div class="mb-3">
                            <label for="decisionSelector" class="form-label">Pilih Decision:</label>
                            <select id="decisionSelector" name="decision_id" class="form-select" onchange="this.form.submit()">
                                @foreach($decisions as $decision)
                                    <option value="{{ $decision->id }}" {{ $decision->id == $decision_id ? 'selected' : '' }}>
                                        {{ $decision->decision_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <!-- Area grafik -->
                    <div class="chart-container">
                        <canvas id="rankingChart"></canvas>
                    </div>
                    @else
                        <p class="text-center">Data belum tersedia. Tambahkan keputusan terlebih dahulu.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const rankings = @json($rankings);

        const labels = rankings.map(item => item.full_name);
        const scores = rankings.map(item => item.score);

        const ctx = document.getElementById('rankingChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Score',
                    data: scores,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `Score: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        title: {
                            display: true,
                            text: 'Score',
                            font: {
                                size: 14
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fitters',
                            font: {
                                size: 14
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
