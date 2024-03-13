@props(['periodList', 'numberOfPages', 'pageNumber'])

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span>{{ $periodList['title'] }}</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="row">
            <div class="col">
                <h5 class="card-header">Table</h5>
            </div>
            <div class="col">
            </div>
            <div class="col">
            </div>
            <div class="col">
            </div>
            @if ($periodList['name'] == 'classroom')
                <div class="col gy-3 gx-4">
                    <a href="/web/dashboard/{{ $periodList['name'] }}/{{ $periodList['classId'] }}/schedule">
                        <button type="button" class="btn btn-primary">Schedule</button>
                    </a>
                </div>
            @else
                <div class="col">
                </div>
            @endif
            <div class="col gy-3 gx-4">
                <a href="/web/dashboard/{{ $periodList['name'] }}/create">
                    <button type="button" class="btn btn-primary">Create</button>
                </a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    @foreach ($periodList['columns'] as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($periodList['contents'] as $content)
                    <td>
                        {{ $content['id'] }}
                    </td>

                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu" style="">
                                <form action="{{ route('apiDeletePeriod') }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $content['id'] }}">

                                    <button type="submit" class="dropdown-item"
                                        onclick="return confirm('Are you sure you want to delete this item?');">
                                        <i class="bx bx-trash me-1"></i> Delete
                                    </button>
                                </form>
                                <!-- <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a> -->
                            </div>
                        </div>
                    </td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <!--/ Basic Bootstrap Table -->

    <x-pagination-component :numberOfPages="$numberOfPages" :pageNumber="$pageNumber" />


</div>
