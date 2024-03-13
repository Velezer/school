<form id="formSearch" class="mb-3" action="{{ url()->current() }}" method="GET">

<div class="navbar-nav align-items-center">
    <div class="nav-item d-flex align-items-center">
      <i class="bx bx-search fs-4 lh-0"></i>
      <input type="text" class="form-control border-0 shadow-none" name="search" placeholder="Search..." aria-label="Search..." value="{{request()->input('search')}}">
    </div>
  </div>
</form>