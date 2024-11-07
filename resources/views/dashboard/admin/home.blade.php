@extends('dashboard.master')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
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
    <div class="col-xl-3 col-md-6 mb-4">
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
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow-sm h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pending Assessement</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$assessment_pending}}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-times fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Annual) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
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
                <h4>Sistem Pendukung Keputusan Pemilihan Fitter Terbaik</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <p class="card-text">
                        Metode Simple Additive Weighting (SAW) sering juga dikenal istilah metode
                        penjumlahan terbobot. Konsep dasar metode SAW adalah mencari penjumlahan
                        terbobot dari rating kinerja pada setiap alternatif pada semua atribut
                        (Fishburn 1967). SAW dapat dianggap sebagai cara yang paling mudah dan
                        intuitif untuk menangani masalah Multiple Criteria Decision-Making MCDM,
                        karena fungsi linear additive dapat mewakili preferensi pembuat keputusan
                        (Decision-Making, DM). Hal tersebut dapat dibenarkan, namun, hanya ketika
                        asumsi preference independence (Keeney & Raiffa 1976) atau preference
                        separability (Gorman 1968) terpenuhi.
                    </p>
                    <hr>
                    <p class="card-text">
                        Langkah Penyelesaian Simple Additive Weighting (SAW) adalah sebagai berikut
                        :
                    </p>
                    <ol type="1">
                        <li>Menentukan kriteria-kriteria yang akan dijadikan acuan dalam pengambilan
                            keputusan, yaitu Ci</i>
                        <li>Menentukan rating kecocokan setiap alternatif pada setiap kriteria (X).
                        </li>
                        <li>Membuat matriks keputusan berdasarkan kriteria(Ci), kemudian melakukan
                            normalisasi matriks berdasarkan persamaan yang disesuaikan dengan jenis
                            atribut (atribut keuntungan ataupun atribut biaya) sehingga diperoleh
                            matriks ternormalisasi R.</li>
                        <li>Hasil akhir diperoleh dari proses perankingan yaitu penjumlahan dari
                            perkalian matriks ternormalisasi R dengan vektor bobot sehingga
                            diperoleh nilai terbesar yang dipilih sebagai alternatif terbaik
                            (Ai)sebagai solusi</li>
                    </ol>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
