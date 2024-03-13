@props(['submissionList', 'numberOfPages', 'pageNumber', 'assessments'])

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span>{{ $submissionList['title'] }}</h4>

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
                <x-filter-button-modal-component :assessments="$assessments" />
            </div>
            <div class="col gy-3 gx-4">
                {{-- <a href="{{ route('webSubmissionCreate') }}">
                    <button type="button" class="btn btn-primary">Create</button>
                </a> --}}
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    @foreach ($submissionList['columns'] as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($submissionList['contents'] as $content)
                    <td>
                        {{-- <a href="/web/dashboard/submission/{{ $content['id'] }}"> --}}
                        {{ $loop->iteration }}.
                        {{-- </a> --}}
                    <td>
                        {{ $content['userName'] }}
                    </td>
                    <td>
                        {{ $content['assessmentName'] }}
                    </td>
                    <td>
                        {{ $content['createdAt'] }}
                    </td>

                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            @php
                                $assessmentId = $content['assessmentId'];
                            @endphp
                            <div class="dropdown-menu" style="">
                                {{-- <form action="{{ route('webSubmissionCreate') }}" method="GET"
                                    style="display: inline;">
                                    <input type="hidden" name="assessmentId" value="{{ $assessmentId }}">
                                    <button type="submit" class="dropdown-item">
                                        <i class="bx bx-edit-alt me-1"></i> Submit
                                    </button>
                                </form> --}}

                                <form action="{{ route('apiDeleteSubmission', $content['id']) }}" method="POST"
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

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <!--/ Basic Bootstrap Table -->

    <x-pagination-component :numberOfPages="$numberOfPages" :pageNumber="$pageNumber" />



</div>
