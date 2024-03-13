@props(['studentDetail'])
<div class="card mb-4">
<div class="card-body">
    <small class="text-light fw-semibold">Murid</small>
    <dl class="row mt-2">
        <dt class="col-sm-3">NIP</dt>
        <dd class="col-sm-9">{{ $studentDetail['data']['id'] }}</dd>

        <dt class="col-sm-3">Nama</dt>
        <dd class="col-sm-9">{{ $studentDetail['data']['name'] }}</dd>

        <dt class="col-sm-3">Kelas</dt>
        <dd class="col-sm-9">{{ $studentDetail['data']['classroom'] }}</dd>

        <dt class="col-sm-3">Alamat</dt>
        <dd class="col-sm-9">{{ $studentDetail['data']['address'] }}</dd>

        <dt class="col-sm-3">Agama</dt>
        <dd class="col-sm-9">{{ $studentDetail['data']['religion'] }}</dd>

        <dt class="col-sm-3">Gender</dt>
        <dd class="col-sm-9">{{ $studentDetail['data']['gender'] }}</dd>

        <dt class="col-sm-3">Tanggal Lahir</dt>
        <dd class="col-sm-9">{{ $studentDetail['data']['dob'] }}</dd>

    </dl>
</div>
</div>