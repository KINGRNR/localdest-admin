@include('package.headerpack')
<!--begin::Body-->

<body id="kt_body" class="">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Aside-->
            @include('package.tampilan.aside')
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                @include('package.tampilan.header')

                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-xxl" id="kt_content_container">
                        <div class="table-user-ini">
                            {{-- <div class="row mb-5 w-75 mx-auto">
                            </div> --}}
                            <div id="filter_role"></div>

                            <div class="card">
                                <!--begin::Card header-->
                                <div class="card-header py-4">
                                    <div class="card-title">
                                        {{-- <h1
                                            style="color: var(--txt, #323232);
                                        font-size: 20px;
                                        font-style: normal;
                                        font-weight: 600;
                                        line-height: 140%; /* 28px */
                                        letter-spacing: 0.2px;">
                                            List User</h1> --}}
                                        <div class="input-group ms-2">
                                            <div class="w-100 position-relative">
                                                <span
                                                    class="svg-icon svg-icon-2 search-icon position-absolute top-50 translate-middle-y ms-4">
                                                    <i class="align-self-center fs-2 las la-search"></i>
                                                </span>
                                                <input type="search" name="search_user" id="search_user"
                                                    placeholder="Cari" class="form-control form-control-sm ps-12"
                                                    autocomplete="off"
                                                    style="display: flex;
                                                height: 48px;
                                                flex-direction: column;
                                                align-items: flex-start;
                                                gap: 8px;
                                                flex: 1 0 0;
                                                width: 241px;">
                                            </div>

                                            {{-- <span class="input-group-text" id="basic-addon1">
                                            </span> --}}
                                        </div>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="button" class="btn btn-primary me-2 reset-filter"
                                            onclick="resetFilter()" style="display: none;">Reset Filter</button>
                                        <div class="d-flex">
                                            <input class="form-control form-control-solid input-required"
                                                placeholder="Pick date rage" name="daterangepicker"
                                                id="daterangepicker_filter" fdprocessedid="dc1v83">
                                            <select name="role_filter" id="role_filter"
                                                class="form-select form-select-sm form-select-solid ms-2"
                                                style="display: flex;
                                                    width: 141px;
                                                    height: 48px;
                                                    padding: 10px 16px;
                                                    align-items: center;
                                                    gap: 16px;">
                                                
                                            </select>
                                        </div>

                                        <div class="fw-bolder me-3 ms-2 deleted-selected" style="display: none;">
                                            <span class="me-2" id="selected_total">10</span>Selected
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger deleted-selected"
                                            data-kt-customer-table-select="delete_selected" style="display: none;"
                                            onclick="deleteSelected()">Delete Selected</button>

                                    </div>
                                </div>

                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Table-->
                                    <table
                                        class="table align-middle table-hover  table-row-dashed fs-6 gy-5 text-center"
                                        id="table-user">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr
                                                class="text-start align-middle text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="ps-4" width="20">
                                                    <div class="form-check ms-2"><input
                                                            class="form-check-input row-checkbox" id="checkAll"
                                                            type="checkbox"></div>
                                                </th>
                                                <th class="ps-4" width="20">No</th>
                                                <th class="min-w-100px">Email</th>

                                                <th class="min-w-100px">Name</th>
                                                <th class="min-w-100px">Joining Date</th>
                                                {{-- <th class="min-w-100px">Full Name</th> --}}
                                                {{-- <th class="min-w-100px">Role</th> --}}
                                                <th>action</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <tbody class="fw-bold text-gray-600 text-start align-middle">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                @include('package.tampilan.footer')
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1"
                    transform="rotate(90 13 6)" fill="black" />
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="black" />
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>
    @include('package.footerpack')
    @include('manage-user.script')
