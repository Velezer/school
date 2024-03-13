@props(['tableDetail'])
<div class="card mb-4">
    <h5 class="card-header">{{$tableDetail['name']}}</h5>
    <table class="table table-borderless">
        <tbody>
            @foreach ($tableDetail['data'] as $key => $value)
            <tr>
                <td class="align-middle"><small class="text-light fw-semibold">{{$key}}</small></td>
                <td class="py-3">
                    @if(is_Array($value))
                    @if($value['type'] == 'a')
                    <a href="/web/dashboard/assessment/{{$tableDetail['assessmentId']}}/classroom/{{$value['value']}}">
                        <p class="mb-0">
                            {{$value['value']}}
                        </p>
                    </a>
                    @endif
                    @else
                    <p class="mb-0">
                        {{$value}}
                    </p>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>