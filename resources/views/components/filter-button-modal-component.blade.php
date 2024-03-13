@props(['classrooms', 'periods', 'subjects', 'assessments'])
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
    Filter
</button>

<form id="formFilter" class="mb-3" action="{{ url()->current() }}" method="GET">
    <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (!empty($subjects))
                        <div class="row">
                            <div class="col mb-3">
                                <label for="subject" class="form-label">Mata Pelajaran</label>
                                <select id="subject" name="subject" class="form-select" aria-label="subject">
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject }}"
                                            {{ request()->input('subject') == $subject ? 'selected' : '' }}>
                                            {{ $subject }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    @if (!empty($classrooms))
                        <div class="row">
                            <div class="col mb-3">
                                <label for="classroom" class="form-label">Kelas</label>
                                <select id="classroom" name="classroom" class="form-select" aria-label="classroom">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom }}"
                                            {{ request()->input('classroom') == $classroom ? 'selected' : '' }}>
                                            {{ $classroom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    @if ($assessments ?? [])
                        <div class="row">
                            <div class="col mb-3">
                                <label for="assessmentId" class="form-label">Assessment</label>
                                <select name="assessmentId" class="form-select">
                                    <option value="">Pilih Assessment</option>
                                    @foreach ($assessments as $assessment)
                                        <option value="{{ $assessment['id'] }}"
                                            {{ request()->input('assessment') == $assessment['id'] ? 'selected' : '' }}>
                                            {{ $assessment['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    @if (!empty($periods))
                        <div class="row">
                            <div class="col mb-3">
                                <label for="period" class="form-label">Tahun Ajaran</label>
                                <select id="period" name="period" class="form-select" aria-label="period">
                                    <option value="">Pilih Tahun Ajaran</option>
                                    @foreach ($periods as $period)
                                        <option value="{{ $period }}"
                                            {{ request()->input('period') == $period ? 'selected' : '' }}>
                                            {{ $period }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
