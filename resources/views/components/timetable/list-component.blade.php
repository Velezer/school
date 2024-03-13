@props(['me', 'timetableList', 'numberOfPages', 'pageNumber', 'classrooms', 'periods', 'subjects'])

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span>{{ $timetableList['title'] }}</h4>

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
            <div class="col gy-3 gx-4">
                <x-search-component />
            </div>
            <div class="col gy-3 gx-4">
                <x-filter-button-modal-component :classrooms="$classrooms" :periods="$periods" :subjects="$subjects" />
            </div>
            <div class="col gy-3 gx-4">
                @if ($me['role'] == 'ADMIN')
                    <a href="{{ route('webTimetableCreate') }}">
                        <button type="button" class="btn btn-primary">Create</button>
                    </a>
                @endif
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    @foreach ($timetableList['columns'] as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                    @if ($me['role'] == 'ADMIN')
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($timetableList['contents'] as $content)
                    <td>
                        {{-- <a href="/web/dashboard/timetable/{{ $content['id'] }}"> --}}
                        {{ $loop->iteration }}.
                        {{-- </a> --}}
                    <td>
                        {{ $content['day'] }}
                    </td>
                    <td>
                        {{ $content['time'] }}
                    </td>
                    <td>
                        {{ $content['subject'] }}
                    </td>
                    <td>
                        {{ $content['classroom'] }}
                    </td>
                    <td>
                        {{ $content['period'] }}
                    </td>
                    <td>
                        {{ $content['semester'] }}
                    </td>

                    @if ($me['role'] == 'ADMIN')
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item"
                                        href="/web/dashboard/timetable/{{ $content['id'] }}/edit"><i
                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <form action="{{ route('apiDeleteTimetable', $content['id']) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="dropdown-item"
                                            onclick="return confirm('Are you sure you want to delete this item?');">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                    <!-- <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a> -->
                                </div>
                            </div>
                        </td>
                    @endif

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <!--/ Basic Bootstrap Table -->

    <x-pagination-component :numberOfPages="$numberOfPages" :pageNumber="$pageNumber" />



</div>
