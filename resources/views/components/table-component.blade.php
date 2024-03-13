@props(['table'])

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span>{{ $table['title'] }}</h4>

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
            @if($table['name'] == 'classroom')
            <div class="col gy-3 gx-4">
                <a href="/web/dashboard/{{ $table['name'] }}/{{ $table['classId'] }}/schedule">
                    <button type="button" class="btn btn-primary">Schedule</button>
                </a>
            </div>
            @else
            <div class="col">
            </div>
            @endif
            <div class="col gy-3 gx-4">
                <a href="/web/dashboard/{{ $table['name'] }}/create">
                    <button type="button" class="btn btn-primary">Create</button>
                </a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    @foreach ($table["columns"] as $column)
                    <th>{{ $column }}</th>
                    @endforeach
                    @if(isset($table['isRemoveAction'])? $table['isRemoveAction']: false)
                    @else
                    <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($table['contents'] as $content)
                @foreach ($content as $key => $value)
                <td>
                    @if ($key == 'id')
                    <a href="/web/dashboard/{{ $table['name'] }}/{{ $value }}">
                        {{ $value }}
                    </a>
                    @else
                    {{ $value }}
                    @endif
                </td>
                @endforeach

                @if(isset($table['isRemoveAction'])? $table['isRemoveAction']: false)
                @else
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="/web/dashboard/user/{{ $content['id'] }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                            <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
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

    <div class="demo-inline-spacing card my-1 px-2 table-responsive">
        <!-- Basic Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item first">
                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-left"></i></a>
                </li>
                <li class="page-item prev">
                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevron-left"></i></a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);">2</a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="javascript:void(0);">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);">4</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);">5</a>
                </li>
                <li class="page-item next">
                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevron-right"></i></a>
                </li>
                <li class="page-item last">
                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-right"></i></a>
                </li>
            </ul>
        </nav>
        <!--/ Basic Pagination -->
    </div>


</div>