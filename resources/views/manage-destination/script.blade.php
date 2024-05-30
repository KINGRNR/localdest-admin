<script type="text/javascript">
    APP_URL = "{{ getenv('APP_URL') }}/";
    FILE_URL = "{{ getenv('FILE_URL') }}/";

    var formSuspend = 'formSuspend';
    $(() => {
        var start = moment().subtract(29, "days");
        var end = moment();

        function cb(start, end) {
            $("#daterangepicker_filter").html(start.format("MMMM D, YYYY") + " - " + end.format(
                "MMMM D, YYYY"));
        }

        $("#daterangepicker_filter").daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                "Today": [moment(), moment()],
                "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1,
                    "month").endOf("month")]
            }
        }, cb);

        cb(start, end);
        init()

    })
    init = async () => {
        await initializeDataTables();
        // quick.unblockPage()
    }
    $('#modal_form').on('hidden.bs.modal', function() {
        $(`input, select`).removeAttr('disabled');
    });




    function countSelectedRows() {
        const selectedRowCount = $('.row-checkbox:checked').not('#checkAll').length;
        $('#selected_total').text(selectedRowCount);
    }

    //filter
    var filterDatatable = [];
    var userTable = null;

    $('[name="daterangepicker"]').on('apply.daterangepicker', (event) => {
        var selectedValue = $(event.target).val();

        if (selectedValue !== '0') {
            filterDatatable.date = selectedValue;
        } else {
            delete filterDatatable.date;
        }
        if (userTable) {
            userTable.destroy();
        }
        $('.reset-filter').fadeIn();
        initializeDataTables(filterDatatable);
    });

    $('[name="role_filter"]').on('change', (event) => {
        var selectedValue = $(event.target).val();

        if (selectedValue !== '0') {
            filterDatatable.role = selectedValue;
        } else {
            delete filterDatatable.role;
        }
        if (userTable) {
            userTable.destroy();
        }
        $('.reset-filter').fadeIn();

        initializeDataTables(filterDatatable);
    });
    resetFilter = () => {
        if (userTable) {
            userTable.destroy();
        }
        $('[name="role_filter"]').val('');
        $('.reset-filter').fadeOut();

        initializeDataTables();
    }

    function initializeDataTables(filterDatatable) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token from meta tag

        userTable = $('#table-destination').DataTable({
            ajax: {
                url: APP_URL + 'listdest/index',
                type: "POST",
                dataType: "json",
                data: filterDatatable,
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Add CSRF token to headers
                },
            },
            processing: true,
            serverSide: true,
            clickable: true,
            searchAble: true,
            searching: true,
            destroyAble: true,
            order: [
                [2, 'asc']
            ],
            columns: [{
                    "targets": 0,
                    "orderable": false,
                    "render": function(data, type, row, meta) {
                        var id = row.id;
                        var name = row.name;
                        return '<div class="ms-6"><input class="form-check-input row-checkbox" type="checkbox" data-id="' +
                            id + '" data-name="' + name + '"></div>';
                    }
                },
                {
                    "orderable": false,
                    render: function(data, type, row, meta) {
                        return '<span class="ps-3">' + (meta.row + meta.settings._iDisplayStart + 1) +
                            '</span>';
                    }
                },
                {
                    data: 'destination_name',
                    name: 'destination_name'
                },
                {
                    data: 'destination_desc',
                    name: 'destination_desc',
                    render: function(data, type, row) {
                        if (data.length > 30) {
                            return data.substr(0, 30) + '...';
                        }
                        return data;
                    }

                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'destination_created_at',
                    name: 'destination_created_at',
                    render: function(data, type, row) {

                        var formattedDate = quick.convertDate(data);


                        return formattedDate;
                    }
                },
                {
                    render: function(data, type, row) {
                        var id = row.id; // Ambil ID dari data atau sumber lain sesuai kebutuhan
                        var btnHTML = `
                        <div class="me-0">
                     <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" type="button" 
                          id="toggleDropdownTable" onclick="toggleMenu(${id})">
                          <i class="bi bi-three-dots fs-3"></i>
                     </button>
                     </div>
                          `;
                        return btnHTML;
                    },
                },
            ],
            initComplete: function() {
                // Add a filter for the "users_role_id" column
                this.api().columns('users_role_id:name').every(function() {
                    var column = this;

                    var select = $(
                            '<select class="form-control"><option value="">Filter Role</option></select>'
                        )
                        .appendTo(
                            '#filter_role'
                        ) // Make sure you have a <div id="filter_role"></div> in your HTML
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>');
                    });
                });
            },
        });
        userTable.on('draw', function() {
            $('.row-checkbox').prop('checked', false);
            $('.deleted-selected').fadeOut(300)
            countSelectedRows();
        });
        $('#search_user').on('input', function() {
            var searchValue = $(this).val();
            userTable.search(searchValue).draw();
        });

    }
    $('#checkAll').click(function() {
        $('.row-checkbox').prop('checked', this.checked);
        handleCheckboxSelection();
        countSelectedRows();
    });

    $('#table-user tbody').on('click', '.row-checkbox', function() {
        countSelectedRows();
    });

    function handleCheckboxSelection() {
        const isChecked = $('.row-checkbox:checked').length > 0;
        const isCheckAllChecked = $('#checkAll').prop('checked');

        if (isChecked) {
            $('.deleted-selected').fadeIn(300)
        } else {
            $('.deleted-selected').fadeOut(300)
        }
    }

    handleCheckboxSelection();

    $('#table-user tbody').on('click', '.row-checkbox', function() {
        handleCheckboxSelection();
        countSelectedRows();

        if ($('.row-checkbox:checked').length === 0) {
            $('#checkAll').prop('checked', false);
        }
    });

    function deleteSelected() {
        var selectedUserNames = [];

        $(".row-checkbox:checked").each(function() {
            var name = $(this).data("name");
            if (name !== null && name !== undefined) {
                selectedUserNames.push(name);
            }
        });

        var selectedUsersList = document.getElementById("selectedUsersList");

        while (selectedUsersList.firstChild) {
            selectedUsersList.removeChild(selectedUsersList.firstChild);
        }

        for (var i = 0; i < selectedUserNames.length; i++) {
            var userName = selectedUserNames[i];
            var listItem = document.createElement("li");
            listItem.textContent = userName;
            selectedUsersList.appendChild(listItem);
        }

        $(".row-checkbox:checked").each(function() {
            var userId = $(this).data("id");
            if (userId !== null && userId !== undefined) {
                var userIdInput = document.createElement("input");
                userIdInput.type = "hidden";
                userIdInput.name = "data[" + $(this).data("id") + "]";
                userIdInput.value = userId;

                var userIdDiv = document.getElementById("userId");
                userIdDiv.appendChild(userIdInput);
            }
        });

        $('#deleteUser').modal('show');
    }


    toggleMenu = (id) => {
        Swal.fire({
            title: 'Action',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Details',
            denyButtonText: `Suspend`,
            customClass: {
                popup: 'custom-swal-popup',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                onDetail(id);
                onDetailJob(id);
            } else if (result.isDenied) {
                toggleModalBanned(id);
            }
        })
    }

    toggleDetail = () => {
        $(`[data-group="detail"]`).addClass('active');
        $(`[data-group="job"]`).removeClass('active');
        $('.table-user-ini').fadeOut();
        $('.detail').fadeIn();
    }
    toggleModalBanned = (id) => {
        $.ajax({
            url: APP_URL + 'listuser/show',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: (response) => {
                const data = response.data;
                $(`#selected_user`).val(data.users_fullname).attr('readonly', 'readonly');
                $('#suspendModal').modal('show');
                $("#kt_daterangepicker_1").daterangepicker({
                    timePicker: true,
                    startDate: moment().startOf("hour"),
                    endDate: moment().startOf("hour").add(32, "hour"),
                    locale: {
                        format: "M/DD hh:mm A"
                    }
                });
            },
            error: (xhr, status, error) => {
                let errorMessage = 'An error occurred while fetching data.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                });
            },
            complete: (response) => {
                quick.unblockPage(500);
            }
        });
    }
    toggleDetailUser = () => {
        $(`[data-group="detail"]`).addClass('active');
        $(`[data-group="job"]`).removeClass('active');
        $('#job_history').fadeOut();
        $('#kt_profile_details_view').fadeIn();
    }
    toggleJob = () => {
        $(`[data-group="detail"]`).removeClass('active');
        $(`[data-group="job"]`).addClass('active');
        $('#kt_profile_details_view').fadeOut();
        $('#job_history').fadeIn();
    }
    toggleTable = () => {
        $('.table-user-ini').fadeIn();
        $('.detail').fadeOut();
    }

    onDeleteUser = () => {
        var formDeleteUser = 'formDeleteUsers';
        var dataDeleteUser = $('[name="' + formDeleteUser + '"]')[0];
        var formData = new FormData(dataDeleteUser);
        $.ajax({
            url: APP_URL + 'listuser/deleteUser',
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: "User Telah Dinonaktifkan",
                        text: "User akan tetap tersimpan selama 30 hari sebelum dihapus secara permanen.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Oke!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        },
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred. Please try again later.",
                    showConfirmButton: true,
                }).then(() => {
                    location.reload();
                });
            }
        });
    }
    onSaveSuspend = () => {
        console.log('hai')
        var data = $('[name="' + formSuspend + '"]')[0];
        var formData = new FormData(data);
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah kamu ingin melanjutkan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: APP_URL + 'listuser/savesuspend',
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: response.title,
                                text: response.message,
                                icon: (response.success) ? 'success' : "error",
                                buttonsStyling: false,
                                confirmButtonText: "Oke!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                },
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "An error occurred. Please try again later.",
                            showConfirmButton: true,
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        });
    }
    onDetail = (id) => {
        quick.blockPage();
        $.ajax({
            url: APP_URL + 'listuser/show',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: (response) => {
                const data = response.data;
                //proses format men format data ya ges ya
                const numericId = data.id;
                const formattedId = String(numericId).padStart(4, '0');
                const gender = data.users_gender === 1 ? 'Woman' : 'Man';
                toggleDetail();

                //proses add data ini
                $(`#username`).text(data.name);
                $(`#fullname`).text(data.users_fullname);
                $(`#email`).text(data.email);
                $(`#join_date`).text(quick.convertDate(data.created_at));
                $('#id_user').text(formattedId);
                $('#gender').text(gender);
                $('#lulusan').text(data.users_lulusan);
                $('#kota').text(data.users_kota);
                $('#link_porto').text(data.users_portofolio_link);
                $('#pekerjaan_sekarang').text(data.users_posisi_kerja);
                $('#skills').text(data.users_skills);
                $('#negara').text("KAMU NANYA HAH?");
                $('#link_resume').text(data.users_resume_link);
                // const profileImageSrc = data.resume.resume_official_photo ? data.photo_profile :
                //     'assets/media/avatars/blank.png';
                $('#profile_image').attr('src', FILE_URL + 'user_photo/' + data.resume
                    .resume_official_photo);

                const completenessPercentage = calculateCompleteness(data);

                $('#completeness').text(completenessPercentage + "%");
                $('.progress-bar-completeness').attr('aria-valuenow', completenessPercentage).css(
                    'width', completenessPercentage + '%');

            },
            error: (xhr, status, error) => {
                let errorMessage = 'An error occurred while fetching data.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                });
            },
            complete: (response) => {
                quick.unblockPage(500);
            }
        });
    }

    function calculateCompleteness(data) {
        let completeness = 0;

        if (data.name) completeness += 10;
        if (data.users_fullname) completeness += 10;
        if (data.email) completeness += 10;
        if (data.created_at) completeness += 10;
        if (data.id) completeness += 10;
        if (data.users_gender !== undefined) completeness += 10;
        if (data.users_lulusan) completeness += 10;
        if (data.users_kota) completeness += 10;
        if (data.users_portofolio_link) completeness += 10;
        if (data.users_posisi_kerja) completeness += 10;
        if (data.users_skills) completeness += 10;
        if (data.users_resume_link) completeness += 10;
        if (data.photo_profile) completeness += 10;

        completeness = Math.min(completeness, 100);
        return completeness;
    }

    // onDetailJob = (id) => {
    //     blockPage();
    //     $.ajax({
    //         url: APP_URL + 'listuser/detailJob',
    //         method: 'POST',
    //         data: {
    //             _token: '{{ csrf_token() }}',
    //             id: id
    //         },
    //         success: (response) => {
    //             const data = response.data;
    //             console.log(data);
    //             // Clear existing rows in the table body

    //             $('#table-user tbody').empty();

    //             // Loop through the data and create rows
    //             for (let i = 0; i < data.length; i++) {
    //                 const item = data[i];
    //                 const newRow = $('<tr>');
    //                 newRow.append($('<td>').text(i + 1));
    //                 newRow.append($('<td>').text("km nanya?"));
    //                 newRow.append($('<td>').text(item.job_name));
    //                 newRow.append($('<td>').text(item.company_name));
    //                 let badgeText = '';
    //                 if (item.job_type === '1') {
    //                     badgeText = 'Full Time';
    //                     badgeColorClass = 'badge-success'; // Green color
    //                 } else if (item.job_type === '2') {
    //                     badgeText = 'Part Time';
    //                     badgeColorClass = 'badge-warning'; // Yellow color
    //                 } else if (item.job_type === '3') {
    //                     badgeText = 'Intern';
    //                     badgeColorClass = 'badge-info'; // Blue color
    //                 }
    //                 const badge = $('<span>').addClass('badge ' + badgeColorClass).text(badgeText);

    //                 newRow.append($('<td>').append(badge)); // Add the badge to the table cell


    //                 // ... Add other columns ...

    //                 $('#table-user tbody').append(newRow);
    //             }


    //         },
    //     });
    // }
    onDetailJob = (id) => {
        quick.blockPage();
        $.ajax({
            url: APP_URL + 'listuser/detailJob',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: (response) => {
                $("#card_table").addClass('d-none'); // Initialize DataTable
                $("#card_table").removeClass('d-none');

                let table = $('#table-user_detail').DataTable({
                    destroy: true, // Destroy existing DataTable instance
                    data: response.data,
                    columns: [{
                            data: null,
                            render: (data, type, row, meta) => meta.row + 1
                        },
                        {
                            data: null,
                            render: () =>
                                '<img src="" alt="f" width="50">'
                        },
                        {
                            data: 'job_name',
                            name: 'job_name'
                        },
                        {
                            data: 'company_name',
                            name: 'company_name'
                        },
                        {
                            data: 'job_type',
                            render: (data) => {
                                let badgeText = '';
                                let badgeColorClass = '';
                                if (data === '1') {
                                    badgeText = 'Full Time';
                                    badgeColorClass = 'badge-success';
                                } else if (data === '2') {
                                    badgeText = 'Part Time';
                                    badgeColorClass = 'badge-warning';
                                } else if (data === '3') {
                                    badgeText = 'Intern';
                                    badgeColorClass = 'badge-info';
                                }
                                return `<span class="badge ${badgeColorClass}">${badgeText}</span>`;
                            }
                        }
                    ]
                });
                // Unblock the page
                quick.unblockPage();
            }
        });
    }
</script>
