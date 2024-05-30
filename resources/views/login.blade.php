<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>Localdest - Login</title>
    {{-- <title>Metronic - the world's #1 selling Bootstrap Admin Theme Ecosystem for HTML, Vue, React, Angular &amp; Laravel by Keenthemes</title> --}}
    <meta name="description"
        content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords"
        content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
</head>

<body id="kt_body" class="app-blank">
    <div class="d-flex flex-column flex-root" id="kt_app_root">

        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-lg-row-fluid order-d-none order-lg-1 " id="backgroundLogin"
                style="background-image: url(assets/media/localdest/.jpg); background-size: 784px 671px; background-repeat: no-repeat; background-position: right; flex-shrink: 0; background-color: white; object-fit:contain">
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 justify-content-end">
                    {{-- <img alt="" src="assets/media/jobhunt/meeting-scene.png" class="d-lg-block d-none w-100" /> --}}

                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7"></h1>
                    <div class="d-none d-lg-block text-white fs-base text-center"></div>
                </div>
            </div>

            <div class="d-flex flex-column flex-lg-row-xl w-lg-50 p-10 order-1 order-lg-2"
                style="background-color: white;">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">

                    <div class="w-lg-500px p-10">
                        <form class="form w-100 form-login" novalidate="novalidate" id="kt_sign_in_form" method="POST">
                            @csrf
                            {{-- <div class="text-center mb-10">
                                <h1 class="text-dark mb-3">Sign In</h1>
                                <div class="text-gray-400 fw-bold fs-4">New Here?
                                    <a href="{{ route('register') }}" class="link-primary fw-bolder">Create an Account</a>
                                </div>
                            </div> --}}
                            <div class="fv-row mb-10">
                                <img src="assets/media/localdest/logo_localdest-light.png" class="w-48 h-16 mr-4"
                                    alt="Logo Ipsum Logo">
                            </div>
                            <div class="fv-row mb-10">
                                <label class="form-label fs-14 fw-bolder text-dark">Email</label>
                                <input
                                    class="form-control @error('email') is-invalid @enderror form-control-lg fs-14 form-control-solid border border-gray-200 text-gray-900"
                                    id="email" type="email" name="email" value="admin@admin.com"
                                    placeholder="Enter your E-mail" required autocomplete="email" autofocus>
                                {{-- value="{{ old('email') }}" --}}
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="fv-row mb-10">
                                <div class="d-flex flex-stack mb-2">
                                    <label class="form-label fw-bolder text-dark fs-14 mb-0">Password</label>
                                </div>
                                <div class="position-relative">
                                    <input
                                        class="form-control @error('password') is-invalid @enderror form-control-lg fs-14 form-control-solid border border-gray-200 text-gray-900"
                                        id="password" type="password" name="password" value="KaliBolu"
                                        placeholder="Enter your password" required autocomplete="current-password">
                                    <button type="button" onclick="togglePassword()"
                                        class="btn-visible btn position-absolute shadow-none flex-center"
                                        style="top: 50%; right: 0; transform: translateY(-50%); color: #808080; display: flex;"
                                        fdprocessedid="mwa89f">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="fv-row mb-10">
                                <div class="d-flex flex-stack mb-2">
                                    {{-- <label class="form-label fw-bolder text-dark fs-14 mb-0">Password</label> --}}
                                    {{-- <a href="{{ route('password.request') }}" class="fs-14 fw-bolder"
                                        style="color: var(--fks-secondary, #DAA916); font-family: Poppins; font-size: 14px; font-style: normal; font-weight: 500; line-height: 140%;">Forgot
                                        Password ?</a> --}}
                                </div>
                            </div>


                            <div class="text-center">

                                <button type="submit" id="" class="btn btn-lg w-100 mb-4"
                                    style="background-color: #1B61AD">
                                    <span class="indicator-label text-white">Sign In</span>
                                    <span class="indicator-progress text-white">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                {{-- <div class="d-grid">
                                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                        <span class="indicator-label">Masuk</span>
                                        <span class="indicator-progress">Tunggu Sebentar...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div> --}}
                                {{-- <a href="{{ url('authorized/google') }}"
                                    class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                                    <img alt="Logo" src="assets/media/svg/brand-logos/google-icon.svg"
                                        class="h-20px me-3">Continue with
                                    Google</a> --}}
                        </form>

                    </div>

                </div>


            </div>

        </div>

    </div>

</body>

<!--end::Main-->
<script>
    var hostUrl = "assets/";
</script>
<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="assets/js/custom/authentication/sign-in/general.js"></script>
<!--end::Page Custom Javascript-->
<!--end::Javascript-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    togglePassword = () => {
        if ($('#password').attr('type') == 'password') {
            $('#password').attr('type', 'text')
            $('.far.fa-eye').removeClass('fa-eye').addClass('fa-eye-slash')
        } else {
            $('.far.fa-eye-slash').removeClass('fa-eye-slash').addClass('fa-eye')
            $('#password').attr('type', 'password')
        }
    }
    $('.form-login').on('submit', function submit(e) {
        e.preventDefault();

        formData = new FormData($(this)[0]);
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        axios({
                method: 'post',
                url: "{{ route('login.store') }}",
                data: formData,
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(function(response) {
                if (response.data.success) {
                    $('#submit-button').prop('disabled', true)
                        .removeClass('bg-figma-biru-primary hover:bg-blue-800')
                        .addClass('bg-gray-200')
                        .css('cursor', 'progress');
                    quick.toastNotif({
                        title: 'success',
                        icon: 'success',
                    });
                    window.location.href = response.data.redirect;
                }
            })
            .catch(function(error) {
                console.log(error);
            });

    });
</script>
</body>
<!--end::Body-->

</html>
