@props(['teacherList', 'numberOfPages', 'pageNumber', 'me'])

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span>{{ $teacherList['title'] }}</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="row">
            <div class="col">
                <h5 class="card-header">Table</h5>
            </div>
            <div class="col">
            </div>
            <div class="col gy-3 gx-4">
                <x-search-component />
            </div>
            <div class="col">
            </div>
            <div class="col">
            </div>
            <div class="col gy-3 gx-4">
                @if ($me['role'] == 'ADMIN')
                    <a href="/web/dashboard/{{ $teacherList['name'] }}/create">
                        <button type="button" class="btn btn-primary">Create</button>
                    </a>
                @endif
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    @foreach ($teacherList['columns'] as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                    @if ($me['role'] == 'ADMIN')
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($teacherList['contents'] as $content)
                    <td>
                        {{ $loop->iteration }}.
                    </td>
                    <td>
                        <a href="/web/dashboard/teacher/{{ $content['id'] }}">
                            {{ $content['id'] }}
                        </a>
                    </td>
                    <td>
                        {{ $content['name'] }}
                    </td>
                    <td>
                        {{ $content['address'] }}
                    </td>

                    @if ($me['role'] == 'ADMIN')
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item" href="/web/dashboard/teacher/{{ $content['id'] }}/edit"><i
                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <form action="{{ route('apiDeleteTeacher', $content['id']) }}" method="POST"
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
