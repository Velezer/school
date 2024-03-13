@props(['numberOfPages','pageNumber'])
<div class="demo-inline-spacing card my-1 px-2 table-responsive">
    <!-- Basic Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <!-- <li class="page-item first">
                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-left"></i></a>
                </li> -->
            <!-- <li class="page-item prev">
                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevron-left"></i></a>
                </li> -->
            @for ($i = 1; $i <= $numberOfPages; $i++) <li class="page-item {{$i == $pageNumber? 'active': ''}}">
                <!-- <a class="page-link" href="{{route('webStudentListView',['pageNumber' => $i])}}">{{$i}}</a> -->
                <a class="page-link" href="{{ url()->current() . '?' . http_build_query(
                    array_merge(request()->query(), ['pageNumber' => $i]))
                     }}">{{$i}}</a>
                </li>
                @endfor
                <!-- <li class="page-item next">
                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevron-right"></i></a>
                </li>
                <li class="page-item last">
                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-right"></i></a>
                </li> -->
        </ul>
    </nav>
    <!--/ Basic Pagination -->
</div>