<div class="card border-0 mb-4 mt-2">
    <div class="card-header font-weight-bold text-light bg-primary">List Assessment</div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="data" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Fitter Name</th>
                        @foreach ($criterias as $criteria)
                            <th>{{$criteria->criteria_code}}<br>({{$criteria->name}})</th>
                        @endforeach
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employes as $index => $employe)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$employe->full_name}}</td>
                            <form action="{{route('assessment.store')}}" method="post">
                                <input type="hidden" name="employe_id" value="{{$employe->id}}">
                                @foreach ($criterias as $criteria)
                                    @csrf
                                    <td>
                                        <input type="hidden" name="decision_id" value="{{$decision_id}}">
                                        <input type="hidden" name="criteria_id[]" value="{{$criteria->id}}">
                                        <select name="weight[]" class="form-control" required>
                                            <option selected disabled>--Choose--</option>
                                            @php
                                                // Cari nilai weight yang sesuai untuk decision_id dan criteria_id
                                                $selectedWeight = $employe->assessment
                                                    ->where('decision_id', $decision_id)
                                                    ->where('criteria_id', $criteria->id)
                                                    ->first()
                                                    ->weight ?? null;
                                            @endphp
                                            @foreach ($criteria->sub_criteria as $sub_criteria)
                                                <option value="{{$sub_criteria->weight}}" 
                                                    {{ $selectedWeight == $sub_criteria->weight ? 'selected' : '' }}>
                                                    {{$sub_criteria->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endforeach
                                <td>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
