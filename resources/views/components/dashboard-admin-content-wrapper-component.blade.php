@props([
    "contentWrapper"
    ])
<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Hai {{$contentWrapper["userName"]}} 🎉</h5>
                            <p class="mb-4">
                                Semoga harimu menyenangkan.
                            </p>

                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                            </div>

                        </div>
                        <span class="fw-semibold d-block mb-1">Total User</span>
                        <h3 class="card-title mb-2">{{$contentWrapper["countUser"]}}</h3>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/wallet-info.png" alt="Credit Card" class="rounded" />
                            </div>

                        </div>
                        <span>Total Admin</span>
                        <h3 class="card-title text-nowrap mb-1">{{$contentWrapper["countAdmin"]}}</h3>
                    </div>
                </div>
            </div> --}}
            <!-- <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2"> -->
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
                            </div>
                            \
                        </div>
                        <span class="d-block mb-1">Total Guru</span>
                        <h3 class="card-title text-nowrap mb-2">{{$contentWrapper["countTeacher"]}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Murid</span>
                        <h3 class="card-title mb-2">{{$contentWrapper["countStudent"]}}</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>