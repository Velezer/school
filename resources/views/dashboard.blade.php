<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <x-side-bar-component :me="$me" :menuItemActive="$menuItemActive"
            :subMenuItemActive="isset($subMenuItemActive) ? $subMenuItemActive : ''"
        />
   
        
        <!-- / Menu -->
  

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
                
     
          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
      

              <ul class="navbar-nav flex-row align-items-center ms-auto">

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{$me['avatar'] ?? '' ? '/storage/' . $me['avatar'] : '/assets/img/avatars/1.png'}}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{$me['name']}}</span>
                            <small class="text-muted">{{$me['role']}}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{route('webUserDetail', $me['id'])}}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">Profil ku</span>
                      </a>
                    </li>
                    {{-- <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li> --}}
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{route('webSignOut')}}">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          @isset($timetableCreate)
    <x-timetable.form-component :periods="$periods" :classrooms="$classrooms" :subjects="$subjects"/>
@endisset
          @isset($assessmentCreate)
    <x-assessment.form-component :periods="$periods" :classrooms="$classrooms" :subjects="$subjects"/>
@endisset
          @isset($courseCreate)
    <x-course.write-component :periods="$periods" :classrooms="$classrooms" :subjects="$subjects"/>
@endisset
          @isset($submissionCreate)
    <x-submission.form-component :assessment="$assessment" :me="$me"/>
@endisset
          @isset($reportCreate)
    <x-report.form-component :students="$students" :periods="$periods" :classrooms="$classrooms" :method="'POST'"  />
@endisset
          @isset($reportUpdate)
    <x-report.form-component :reportUpdate="$reportUpdate" :subjects="$subjects" :selected="$selected" :method="'PUT'"/>
@endisset
          @isset($subjectCreate)
    <x-subject.create-component/>
@endisset
          
          @isset($periodCreate)
    <x-period.create-component/>
@endisset

        @isset($timetableUpdate)
    <x-timetable.form-component :timetableUpdate="$timetableUpdate" :periods="$periods" :classrooms="$classrooms" :subjects="$subjects"/>
@endisset
        @isset($assessmentUpdate)
    <x-assessment.form-component :assessmentUpdate="$assessmentUpdate" :periods="$periods" :classrooms="$classrooms" :subjects="$subjects"/>
@endisset
        @isset($courseUpdate)
    <x-course.write-component :courseUpdate="$courseUpdate" :periods="$periods" :classrooms="$classrooms" :subjects="$subjects"/>
@endisset
        @isset($courseDetail)
    <x-course.detail-component :courseDetail="$courseDetail" :readonly="true"/>
@endisset
          @isset($subjectUpdate)
    <x-subject.update-component :subjectUpdate="$subjectUpdate"/>
@endisset

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            @isset($reportDetail)
    <div class="container-xxl flex-grow-1 container-p-y">
                        <x-report.detail-component :reportDetail="$reportDetail" />
                      </div>
@endisset


            @isset($teacherList)
    <x-teacher.list-component :me="$me" :teacherList="$teacherList"
                      :numberOfPages="$numberOfPages"
                      :pageNumber="$pageNumber"
                      />
@endisset

            @isset($classroomList)
    <x-classroom.list-component :classroomList="$classroomList"/>
@endisset

            @isset($periodList)
    <x-period.list-component :periodList="$periodList" :numberOfPages="$numberOfPages" :pageNumber="$pageNumber"/>
@endisset
                      
            @isset($userDetail)
    <div class="container-xxl flex-grow-1 container-p-y">
                        <x-user.form-component :readonly="$readonly ?? true" :me="$me" :userDetail="$userDetail" :classrooms="$classrooms" :periods="$periods"/>
                  </div>
@endisset

            @isset($studentList)
    <x-student.list-component
                      :me="$me"
                      :studentList="$studentList"
                      :numberOfPages="$numberOfPages"
                      :pageNumber="$pageNumber"
                      :classrooms="$classrooms"
                      :periods="$periods"
                      />
@endisset

            @isset($timetableList)
    <x-timetable.list-component :me="$me"
                      :timetableList="$timetableList"
                      :numberOfPages="$numberOfPages"
                      :pageNumber="$pageNumber"
                      :classrooms="$classrooms"
                      :periods="$periods"
                      :subjects="$subjects"
                      />
@endisset
            @isset($assessmentList)
    <x-assessment.list-component
                      :assessmentList="$assessmentList"
                      :numberOfPages="$numberOfPages"
                      :pageNumber="$pageNumber"
                      :classrooms="$classrooms"
                      :periods="$periods"
                      :subjects="$subjects"
                      />
@endisset

            @isset($courseList)
    <x-course.list-component :me="$me"
                      :courseList="$courseList"
                      :numberOfPages="$numberOfPages"
                      :pageNumber="$pageNumber"
                      :classrooms="$classrooms"
                      :periods="$periods"
                      :subjects="$subjects"
                      />
@endisset
            @isset($submissionList)
    <x-submission.list-component
                      :submissionList="$submissionList"
                      :numberOfPages="$numberOfPages"
                      :pageNumber="$pageNumber"
                      :assessments="$assessments"
                      />
@endisset
            @isset($reportList)
    <x-report.list-component
                      :me="$me"
                      :reportList="$reportList"
                      :numberOfPages="$numberOfPages"
                      :pageNumber="$pageNumber"
                      />
@endisset
            @isset($subjectList)
    <x-subject.list-component
                      :subjectList="$subjectList"
                      :numberOfPages="$numberOfPages"
                      :pageNumber="$pageNumber"
                      />
@endisset

            @isset($table)
    <x-table-component :table="$table"/>
@endisset
            @if (isset($isDashboardAdmin) ? $isDashboardAdmin : false)
<x-dashboard-admin-content-wrapper-component
              :contentWrapper="$contentWrapper"
              />
@endif

            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                      document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
