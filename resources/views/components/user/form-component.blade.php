@props(['me', 'userDetail' => [], 'periods', 'classrooms', 'readonly' => true])

@php
    $method = 'POST';
    if ($userDetail['id'] ?? '') {
        $method = 'PUT';
    }

@endphp

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register Card -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="index.html" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <defs>
                                        <path
                                            d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                                            id="path-1"></path>
                                        <path
                                            d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                                            id="path-3"></path>
                                        <path
                                            d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                                            id="path-4"></path>
                                        <path
                                            d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                                            id="path-5"></path>
                                    </defs>
                                    <g id="g-app-brand" stroke="none" stroke-width="1" fill="none"
                                        fill-rule="evenodd">
                                        <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                            <g id="Icon" transform="translate(27.000000, 15.000000)">
                                                <g id="Mask" transform="translate(0.000000, 8.000000)">
                                                    <mask id="mask-2" fill="white">
                                                        <use xlink:href="#path-1"></use>
                                                    </mask>
                                                    <use fill="#696cff" xlink:href="#path-1"></use>
                                                    <g id="Path-3" mask="url(#mask-2)">
                                                        <use fill="#696cff" xlink:href="#path-3"></use>
                                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3">
                                                        </use>
                                                    </g>
                                                    <g id="Path-4" mask="url(#mask-2)">
                                                        <use fill="#696cff" xlink:href="#path-4"></use>
                                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4">
                                                        </use>
                                                    </g>
                                                </g>
                                                <g id="Triangle"
                                                    transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                                    <use fill="#696cff" xlink:href="#path-5"></use>
                                                    <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <span class="app-brand-text demo text-body fw-bolder">
                                @if ($userDetail['role'] == 'TEACHER')
                                    Guru
                                @elseif ($userDetail['role'] == 'STUDENT')
                                    Murid
                                @else
                                    Admin
                                @endif
                            </span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">
                        @if ($userDetail['role'] == 'TEACHER')
                            Guru
                        @elseif ($userDetail['role'] == 'STUDENT')
                            Murid
                        @else
                            Admin
                        @endif 🚀
                    </h4>
                    <p class="mb-4">Silakan ubah form di bawah ini</p>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const uploadInput = document.getElementById('upload');
                            const uploadedAvatar = document.getElementById('uploadedAvatar');

                            uploadInput.addEventListener('change', function(event) {
                                const file = event.target.files[0];

                                if (file) {
                                    const reader = new FileReader();

                                    reader.onload = function(e) {
                                        // Set the src attribute of the image to the Blob data
                                        uploadedAvatar.src = e.target.result;
                                    };

                                    // Read the file as a data URL
                                    reader.readAsDataURL(file);
                                }
                            });

                            // Reset button functionality
                            const resetButton = document.querySelector('.account-image-reset');
                            resetButton.addEventListener('click', function() {
                                // Reset the input field and image src
                                uploadInput.value = '';
                                uploadedAvatar.src = '/assets/img/avatars/1.png'; // Set to default image path
                            });
                        });
                    </script>

                    <form id="formAuthentication" class="mb-3"
                        action="{{ $method == 'PUT' ? route('apiUpdateUser', $userDetail['id']) : route('apiCreateUser') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($method == 'PUT')
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ $userDetail['avatar'] ?? '' ? '/storage/' . $userDetail['avatar'] : '/assets/img/avatars/1.png' }}"
                                    alt="user-avatar" class="d-block rounded" height="100" width="100"
                                    id="uploadedAvatar">
                                @unless ($readonly)
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" name="avatar" id="upload" class="account-file-input"
                                                hidden="" accept="image/png, image/jpeg">
                                        </label>
                                        <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                            <i class="bx bx-reset d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>

                                        <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                    </div>
                                @endunless
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="id" class="col-md-2 col-form-label">
                                {{ ($userDetail['role'] ?? '') == 'TEACHER' ? 'NIP' : (($userDetail['role'] ?? '') == 'STUDENT' ? 'NISN' : 'ID') }}
                            </label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="id" name="id"
                                    placeholder="Enter your NIP" autofocus @readonly($readonly || $method == 'PUT')
                                    value="{{ $userDetail['id'] ?? '' }}" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="name" class="col-md-2 col-form-label">Nama</label>
                            <div class="col-md-10">

                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Masukkan Nama" autofocus value="{{ $userDetail['name'] ?? '' }}"
                                    @readonly($readonly) />
                            </div>
                        </div>

                        @if ($method == 'PUT')
                            <div class="mb-3 row">
                                <label for="name" class="col-md-2 col-form-label">Password</label>
                                <div class="col-md-10">

                                    <input type="text" class="form-control" name="password"
                                        placeholder="Kosongkan bila tidak ingin mengganti password" autofocus
                                        value="" @readonly($readonly) />
                                </div>
                            </div>
                        @endif

                        @unless (($userDetail['role'] ?? '') == 'ADMIN')
                            <div class="mb-3 row">
                                <label for="classroom" class="col-md-2 col-form-label">Kelas</label>
                                <div class="col-md-10">

                                    <select id="classroom" name="classroom" class="form-select" aria-label="classroom"
                                        required @disabled($readonly)>
                                        <option value="">Pilih Kelas</option>
                                        @foreach ($classrooms as $classroom)
                                            <option value="{{ $classroom }}"
                                                {{ $userDetail['classroom'] ?? '' == '1' ? 'selected' : '' }}>
                                                {{ $classroom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            @if ($userDetail['role'] ?? '' == 'STUDENT')
                                <div class="mb-3 row">
                                    <label for="period" class="col-md-2 col-form-label">Tahun Ajaran</label>
                                    <div class="col-md-10">

                                        <select id="period" name="period" class="form-select" aria-label="period"
                                            required @disabled($readonly)>
                                            <option value="">Pilih Tahun Ajaran</option>
                                            @foreach ($periods as $period)
                                                <option value="{{ $period }}"
                                                    {{ $userDetail['period'] ?? '' == '1' ? 'selected' : '' }}>
                                                    {{ $period }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif


                            <div class="mb-3 row">
                                <label for="address" class="col-md-2 col-form-label">Alamat</label>
                                <div class="col-md-10">

                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Masukkan Alamat" autofocus @readonly($readonly)
                                        value="{{ $userDetail['address'] ?? '' }}" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="gender" class="col-md-2 col-form-label">Jenis Kelamin</label>
                                <div class="col-md-10">

                                    <select id="gender" name="gender" class="form-select" aria-label="gender"
                                        required @disabled($readonly)>
                                        <option>
                                            Pilih Jenis Kelamin Anda
                                        </option>
                                        <option value="MALE"
                                            {{ $userDetail['gender'] ?? '' == 'MALE' ? 'selected' : '' }}>
                                            Laki-Laki
                                        </option>
                                        <option value="FEMALE"
                                            {{ $userDetail['gender'] ?? '' == 'FEMALE' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="religion" class="col-md-2 col-form-label">Agama</label>
                                <div class="col-md-10">

                                    <input type="text" class="form-control" id="religion" name="religion"
                                        placeholder="Masukkan Agama" autofocus @readonly($readonly)
                                        value="{{ $userDetail['religion'] ?? '' }}" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="dob" class="col-md-2 col-form-label">Tanggal Lahir</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="date" id="dob" name="dob"
                                        value="{{ $userDetail['dob'] ?? '' }}" @readonly($readonly)>
                                </div>
                            </div>

                        @endunless

                        <input type="hidden" name="role" value="{{ $userDetail['role'] }}">
                        <input type="hidden" name="redirectUrl" value="{{ url()->current() }}">

                        <button class="btn btn-primary d-grid w-100">
                            @if ($readonly)
                                @if ($userDetail['role'] == 'TEACHER')
                                    <a href="{{ route('webTeacherEditView', $userDetail['id']) }}"
                                        style="color: white;">
                                    @elseif ($userDetail['role'] == 'STUDENT')
                                        <a href="{{ route('webStudentEditView', $userDetail['id']) }}"
                                            style="color: white;">
                                        @else
                                            <a href="{{ route('webUserEditView', $userDetail['id']) }}"
                                                style="color: white;">
                                @endif
                                Edit
                                </a>
                            @else
                                Submit
                            @endif
                        </button>
                    </form>
                </div>
            </div>
            <!-- Register Card -->
        </div>
    </div>
</div>
