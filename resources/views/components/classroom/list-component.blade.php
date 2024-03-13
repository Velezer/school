@props(['classroomList'])

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span>{{ $classroomList['title'] }}</h4>

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
            <div class="col">
            </div>
            <div class="col gy-3 gx-4">
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    @foreach ($classroomList["columns"] as $column)
                    <th>{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($classroomList['contents'] as $content)
                <tr>
                    <td>
                        {{ $content['id'] }}
                    </td>
                    <td>
                        Kelas {{ $content['id'] }}
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <!--/ Basic Bootstrap Table -->
</div>