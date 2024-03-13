@props(['reportDetail'])
<div class="card mb-4">
    <div class="card">
        <div class="row card-header gx-3 gy-2">
            <div class="col">
                <h5>Nama: {{$reportDetail['name']}}</h5>
                <h5>Kelas: {{$reportDetail['classroom']}}</h5>
            </div>
            <div class="col-md-3">
                <h5>Semester: {{$reportDetail['semester']}}</h5>
                <h5>Tahun Ajaran: {{$reportDetail['period']}}</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            @foreach($reportDetail['columns'] as $c)
                            <th>{{$c}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportDetail['contents'] as $c)
                        <tr>
                            @foreach($c as $k => $v)
                            <td>
                                @if($loop->first)
                                <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$v}}</strong>
                                @else
                                {{$v}}
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>