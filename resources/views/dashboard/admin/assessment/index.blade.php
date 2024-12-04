@extends('dashboard.master')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Assessment</h1>
  </div>
    <div class="row justify-content-center">
    <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header font-weight-bold text-light bg-primary">
                    Add New Assessment
                </div>
                <div class="card-body">
                <form action="{{route('assessment.decision')}}" method="POST">
                @csrf
                    <div class="form-group">
                      <label for="decision_name">Assessment Name</label>
                      <input type="text" name="decision_name" class="form-control" id="decision_name" aria-describedby="nameHelp">
                    </div>
                    <div class="form-group">
                      <label for="decision_date">Assessment Date</label>
                      <input type="date" name="decision_date" class="form-control" id="decision_date" aria-describedby="nameHelp">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header font-weight-bold text-light bg-primary">List Assessment</div>

                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-bordered" id="data" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Assessment Name</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($decisions as $index => $decision)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $decision->decision_name }}</td>
                                    <td>{{ $decision->decision_date }}</td>
                                    <td>
                                      <a href="/dashboard/assessment/{{$decision->id}}/saw" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                      <a href="/dashboard/assessment/{{$decision->id}}/result" class="btn btn-sm btn-dark"><i class="fas fa-layer-group"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection
@push('scripts')
<script src="{{asset('sbadmin2\vendor\datatables\jquery.dataTables.js')}}"></script>
<script src="{{asset('sbadmin2\vendor\datatables\dataTables.bootstrap4.js')}}"></script>
<script>
    $(document).ready(function() {
    $('#data').DataTable();
} );
</script>
@endpush