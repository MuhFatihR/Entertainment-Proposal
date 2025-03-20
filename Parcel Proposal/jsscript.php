<script type="text/javascript">
    var save_method;
    var table;

    $(document).ready(function() {
        App.dataTables();
        document.title = "Parcel | Portal Engineering | PT Nusantara Compnet Integrator";

        // Select2 Untuk Add Parcel
        $('#reportAdd .select2').select2({
            placeholder: $(this).data("placeholder") ?? '',
            dropdownParent: $('#reportAdd'),
            width: '100%',
            allowClear: true,

            templateResult: function(data) {
                if (data.title) {
                    return $('<div class="m-0">' +
                        '<p class="m-0" >' + data.text + '</p>' +
                        '<p class="small mb-0" >' + data.title + '</p>' +
                        '</div>');
                } else {
                    return $('<span class="mb-0">' + data.text + '</span>');
                }
            },
            matcher: function(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                if (typeof data.text === 'undefined') {
                    return null;
                }
                var search = params.term.toLowerCase();
                var text = data.text.toLowerCase();
                var title = data.title ? data.title.toLowerCase() : '';

                if (text.indexOf(search) > -1) {
                    var modifiedData = $.extend({}, data, true);
                    var reg = new RegExp(search, 'gi');
                    modifiedData.text = modifiedData.text.replace(reg, function(str) {
                        return str.bold()
                    });
                    return modifiedData;
                }

                if (title.indexOf(search) > -1) {
                    var modifiedData2 = $.extend({}, data, true);
                    var reg2 = new RegExp(search, 'gi');
                    modifiedData2.title = modifiedData2.title.replace(reg2, function(str2) {
                        return str2.bold()
                    });
                    return modifiedData2;
                }
                return null;
            }
        });

        $('#reportDetail .select2').select2({
            placeholder: $(this).data("placeholder") ?? '',
            dropdownParent: $('#reportDetail'),
            width: '100%',
            allowClear: true,

            templateResult: function(data) {
                if (data.title) {
                    return $('<div class="m-0">' +
                        '<p class="m-0" >' + data.text + '</p>' +
                        '<p class="small mb-0" >' + data.title + '</p>' +
                        '</div>');
                } else {
                    return $('<span class="mb-0">' + data.text + '</span>');
                }
            },
            matcher: function(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                if (typeof data.text === 'undefined') {
                    return null;
                }
                var search = params.term.toLowerCase();
                var text = data.text.toLowerCase();
                var title = data.title ? data.title.toLowerCase() : '';

                if (text.indexOf(search) > -1) {
                    var modifiedData = $.extend({}, data, true);
                    var reg = new RegExp(search, 'gi');
                    modifiedData.text = modifiedData.text.replace(reg, function(str) {
                        return str.bold()
                    });
                    return modifiedData;
                }

                if (title.indexOf(search) > -1) {
                    var modifiedData2 = $.extend({}, data, true);
                    var reg2 = new RegExp(search, 'gi');
                    modifiedData2.title = modifiedData2.title.replace(reg2, function(str2) {
                        return str2.bold()
                    });
                    return modifiedData2;
                }
                return null;
            }
        });


        // FILTER
        $("#filter").submit(function(e) {
            e.preventDefault();
            generateTable();
        });

        // FILTER CLEAR
        $("#clear").click(function(e) {
            e.preventDefault();

            $("#no_parcel_filter").val('');
            $("#nama_pengirim_filter").val('');
            $("#perusahaan_pengirim_filter").val('');
            $("#nama_penerima_filter").val('');
            $("#department_penerima_filter").val('');
            $("#pt_penerima_filter").val('').trigger("change");

            $("#keputusan_filter").val('').trigger("change");
            $("#currency_filter").val('').trigger("change");

            $("#estimasi_nominal_filter").val('');
            $("#source_info_nominal_filter").val('');

            generateTable();
        });


        // Menyimpan Data (adddata.php)
        $('#btnSave').click(function(e) {
            e.preventDefault();
            var formData = new FormData($('#reportAdd')[0]);

            $(this).prop('disabled', true);
            $(this).text('Saving...');

            var selectedOption = $('select[name="nama_penerima"] option:selected');
            var dataType = selectedOption.data('type');

            // ROW 1
            var nama_pengirim = $('#nama_pengirim').val();
            if (!nama_pengirim) {
                ShowErrorMessage('Error!', 'Nama Pengirim Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }
            var perusahaan_pengirim = $('#perusahaan_pengirim').val();
            if (!perusahaan_pengirim) {
                ShowErrorMessage('Error!', 'Perusahaan Pengirim Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            // ROW 2 & 3
            var nama_penerima = $('select[name="nama_penerima"]').val();
            var department_penerima = $('select[name="department_penerima"]').val();
            var pt_penerima = $('select[name="pt_penerima"]').val();
            if (!nama_penerima && !department_penerima && !pt_penerima) {
                ShowErrorMessage('Error!', 'Salah Satu Field Penerima Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            var banyak_parcel = $('#banyak_parcel').val();
            if (!banyak_parcel) {
                ShowErrorMessage('Error!', 'Banyak Parcel Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            } else if (isNaN(banyak_parcel)) {
                ShowErrorMessage('Error!', 'Banyak Parcel harus diisi dengan angka!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            // ROW 4
            var currency = $('select[name="currency"]').val();
            if (!currency) {
                ShowErrorMessage('Error!', 'Currency Harus Dipilih!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }
            var estimasi_nominal = $('#estimasi_nominal').val();
            if (!estimasi_nominal) {
                ShowErrorMessage('Error!', 'Estimasi Nominal Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            } else if (isNaN(estimasi_nominal)) {
                ShowErrorMessage('Error!', 'Estimasi Nominal harus diisi dengan angka!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }
            var source_info_nominal = $('#source_info_nominal').val();
            if (!source_info_nominal) {
                ShowErrorMessage('Error!', 'Source Info Nominal Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }


            // ROW 5
            var inputFile = $('input[name="file"]')[0]; // Ambil elemen DOM dari input file
            if (!inputFile.files || inputFile.files.length === 0) {
                ShowErrorMessage('Error!', 'File Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            // Validasi ukuran file (maksimal 15MB)
            var fileSize = inputFile.files[0].size; // ukuran file dalam byte
            if (fileSize > 15 * 1024 * 1024) { // 15MB dalam byte
                ShowErrorMessage('Warning!', 'File size max 15MB!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            $.ajax({
                url: "module/parcel/adddata.php",
                type: "POST",
                data: formData,
                dataType: "json", // Ensure the server returns valid JSON
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.code == 200) {
                        $('#modalAdd').modal('hide');
                        ShowSuccessMessage('Success!', 'Data Berhasil Ditambahkan!');
                        ReloadTable();
                    } else {
                        var myText = data.msg;
                        ShowWarningMessage('Warning!', myText);
                    }
                    clearform();
                    $('#btnSave').text('Save');
                    $('#btnSave').prop('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var myText = errorThrown;
                    ShowErrorMessage('Error!', myText);
                    $('#btnSave').text('Save');
                    $('#btnSave').prop('disabled', false);
                }
            });
        });

        // Menyimpan Perubahan (editdata.php)
        $('#btnSaveEdit').click(function(e) {
            e.preventDefault();
            var formData = new FormData($('#reportDetail')[0]);

            $(this).prop('disabled', true);
            $(this).text('Saving...');


            // ROW 1
            var nama_pengirim_detail = $('#nama_pengirim_detail').val();
            if (!nama_pengirim_detail) {
                ShowErrorMessage('Error!', 'Nama Pengirim Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }
            var perusahaan_pengirim_detail = $('#perusahaan_pengirim_detail').val();
            if (!perusahaan_pengirim_detail) {
                ShowErrorMessage('Error!', 'Perusahaan Pengirim Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }

            // ROW 2 & 3
            var nama_penerima_detail = $('select[name="nama_penerima_detail"]').val();
            var department_penerima_detil = $('select[name="department_penerima_detail"]').val();
            var pt_penerima_detil = $('select[name="pt_penerima_detail"]').val();

            if(!nama_penerima_detail){
                ShowErrorMessage('Error!', 'Nama Penerima Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }

            if(!department_penerima_detil){
                ShowErrorMessage('Error!', 'Department Penerima Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }

            if(!pt_penerima_detil){
                ShowErrorMessage('Error!', 'Perusahaan Penerima Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }

            if (
                (nama_penerima_detail === '-' || !nama_penerima_detail) &&
                (department_penerima_detil === '-' || !department_penerima_detil) &&
                (pt_penerima_detil === '-' || !pt_penerima_detil) 
            ) {
                ShowErrorMessage('Error!', 'Salah Satu Field Penerima Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }


            if (
                (nama_penerima_detail === '-' || !nama_penerima_detail) &&
                ((department_penerima_detil !== '-' && department_penerima_detil) || (pt_penerima_detil !== '-' && pt_penerima_detil))
            ) {

            } else if (
                (nama_penerima_detail !== '-' && nama_penerima_detail) ||
                (department_penerima_detil !== '-' && department_penerima_detil) ||
                (pt_penerima_detil !== '-' && pt_penerima_detil)
            ) {
                
            } else {
                ShowErrorMessage('Error!', 'Salah satu field antara Nama Penerima, Department, atau PT harus diisi.');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }


            
            var banyak_parcel_detail = $('#banyak_parcel_detail').val();
            if (!banyak_parcel_detail) {
                ShowErrorMessage('Error!', 'Banyak Parcel Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            } else if (isNaN(banyak_parcel_detail)) {
                ShowErrorMessage('Error!', 'Banyak Parcel harus diisi dengan angka!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }

            // ROW 4
            var currency_detail = $('select[name="currency_detail"]').val();
            if (!currency_detail) {
                ShowErrorMessage('Error!', 'Currency Harus Dipilih!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }
            var estimasi_nominal_detail = $('#estimasi_nominal_detail').val();
            if (!estimasi_nominal_detail) {
                ShowErrorMessage('Error!', 'Estimasi Nominal Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            } else if (isNaN(estimasi_nominal_detail)) {
                ShowErrorMessage('Error!', 'Estimasi Nominal harus diisi dengan angka!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }

            var source_info_nominal_detail = $('#source_info_nominal_detail').val();
            if (!source_info_nominal_detail) {
                ShowErrorMessage('Error!', 'Source Info Nominal Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }

            var inputFile = $('input[name="fileInputDetail"]')[0];
            if (inputFile.files && inputFile.files.length > 0) {
                var fileSize = inputFile.files[0].size;
                if (fileSize > 15 * 1024 * 1024) {
                    ShowErrorMessage('Warning!', 'Ukuran file maksimal 15MB!');
                    $('#btnSaveEdit').text('Save');
                    $('#btnSaveEdit').prop('disabled', false);
                    return false;
                }
            }

            $.ajax({
                url: "module/parcel/edit.php",
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                success: function(data) {
                    if (data) {
                        $('#modalDetail').modal('hide');
                        ShowSuccessMessage('Success!', 'Data Berhasil DiUpdate!');
                        ReloadTable();
                    } else {
                        var myText = data.message;
                        ShowWarningMessage('Warning!', myText);
                    }
                    $('#btnSaveEdit').text('Save');
                    $('#btnSaveEdit').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var myText = errorThrown;
                    ShowErrorMessage('Error!', myText);
                    $('#btnSaveEdit').text('Save');
                    $('#btnSaveEdit').attr('disabled', false);
                }
            });
        });

        // Datatable
        table = $('#ParcelTable').DataTable({
            "dom": "<'row be-datatable-header'<'col-sm-4 xs-mb-20 sm-mb-0 md-mb-0 lg-mb-0'l><'col-sm-8 space-right text-right'B>>" +
                "<'row be-datatable-body'<'col-sm-12'tr>>" +
                "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>",
            "fixedHeader": {
                header: true,
                headerOffset: $('.navbar').height()
            },
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "module/parcel/getdata.php",
                "type": "POST",
                "data": function(d) {
                    form = $("#filter").serializeArray();
                    console.log(form);
                    $.each(form, function(key, val) {
                        d[val.name] = val.value;
                    });
                }
            },
            "columnDefs": [{
                "className": "dt-center",
                "targets": "_all"
            }, ],
            lengthMenu: [
                [10, 25, 50, -1],
                ['10', '25', '50', 'All']
            ],
            buttons: [{
                    text: 'Add Data',
                    className: 'btn btn-success btn-import',
                    action: function(e, dt, node, config) {
                        ShowModalAdd();
                    }
                },
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        }
                    },
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                },
                {
                    extend: 'csvHtml5',
                    filename: function() {
                        var d = new Date();
                        var n = d.getTime();
                        return "Parcel Report-" + n;
                    },
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        },
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: function() {
                        var d = new Date();
                        var n = d.getTime();
                        return "Parcel Report-" + n;
                    },
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        },
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    filename: function() {
                        var d = new Date();
                        var n = d.getTime();
                        return "Parcel Report-" + n;
                    },
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        },
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                },
                {
                    extend: 'print',
                    filename: function() {
                        var d = new Date();
                        var n = d.getTime();
                        return "Parcel Report-" + n;
                    },
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        },
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                }
            ]
        });


        $(document).on('click', '.uploadFileButton', function() {
            // Trigger the corresponding file input click
            $(this).siblings('.fileInputDetail').click();
        });

        // Event delegation for file input changes
        $(document).on('change', '.fileInputDetail', function() {
            var file = $(this).prop('files')[0];
            if (file) { // Ensure a file was selected
                var newFileName = file.name; // Get the name of the selected file
                // Update the file name in the same row
                $(this).closest('tr').find('.fileNameCell').text(newFileName);
            }
        });

        // Nampilin Data pada Detail (getdetail.php)
        $('#ParcelTable').on('click', '.showDetail', function() {
            var id = $(this).data('id');
            console.log("ID parcel:", id);

            $('#modalDetail').modal('show');
            $.ajax({
                url: "module/parcel/getdetail.php?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    // console.log("Data received:", data);
                    $('[name="id"]').val(data.data.id);
                    console.log(data.data);
                    console.log(data.data.id_nama_penerima);
                    console.log(data.data.id_department_penerima);
                    console.log(data.data.id_pt_penerima);

                    document.getElementById("no_parcel_detail").textContent = data.data.no_parcel;

                    $('[name="nama_pengirim_detail"]').val(data.data.nama_pengirim);
                    $('[name="perusahaan_pengirim_detail"]').val(data.data.perusahaan_pengirim);

                    if (data.data.id_nama_penerima == 0) {
                        $('#nama_penerima_detail').val('-').trigger("change");
                    }else{
                        $('[name="nama_penerima_detail"]').val(data.data.id_nama_penerima).trigger("change");
                    }

                    if (data.data.id_department_penerima == 0) {
                        $('#department_penerima_detail').val('-').trigger("change");
                    }else{
                        $('[name="department_penerima_detail"]').val(data.data.id_department_penerima).trigger("change");
                    }

                    if (data.data.id_pt_penerima == 0) {
                        $('#pt_penerima_detail').val('-').trigger("change");
                    }else{
                        $('[name="pt_penerima_detail"]').val(data.data.id_pt_penerima).trigger("change");
                    }

                    $('[name="banyak_parcel_detail"]').val(data.data.banyak_parcel);
                    $('[name="currency_detail"]').val(data.data.id_currency).trigger("change");

                    $('[name="estimasi_nominal_detail"]').val(data.data.estimasi_nominal);
                    $('[name="source_info_nominal_detail"]').val(data.data.source_info_nominal);

                    $('[name="keputusan_detail"]').val(data.data.keputusan).trigger("change");
                    $('[name="note_keputusan_detail"]').val(data.data.note_keputusan);

                    // FILE
                    <?php
                    // Generate the base URL dynamically in PHP
                    $baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];  // Base URL
                    ?>

                    // Pass the generated PHP URL into JavaScript
                    let baseUrl = "<?php echo $baseUrl; ?>"; // The base URL from PHP
                    $('#fileTable').DataTable().destroy();
                    let listFile = $('#listFile');
                    let rowTable = '';
                    listFile.empty();

                    if (data.data.file_name) {
                        rowTable += '<tr>' +
                                        '<td class="fileNameCell">' + data.data.file_name + '</td>' +
                                            '<td style="width: 25%">' +
                                                '<div style="display: flex; gap: 50%;">' +
                                                    // Tombol View
                                                    '<a href="' + baseUrl + '/engineering/fileParcel/' + data.data.file_name + '" ' +
                                                    'target="_blank" class="btn btn-info">' + '<i class="fas fa-eye"></i> View </a>' +

                                                    // Tombol Update
                                                    '<button type="button" class="btn btn-success uploadFileButton" id="uploadFileButton"> <i class="fas fa-upload"></i> Update Current File </button>' +
                                                    '<input type="file" class="fileInputDetail" name="fileInputDetail" style="display: none;">' +
                                                '</div>' +
                                            '</td>' +
                                    '</tr>';
                    } else {
                        rowTable = '<tr><td style="text-align: center" colspan="2">No Data</td></tr>';
                    }
                    listFile.append(rowTable);
                    $('#fileTable').DataTable({
                        responsive: true,
                        processing: true,
                        paging: false,
                        searching: false,
                        lengthMenu: [
                            [-1],
                            ['All']
                        ],
                        columnDefs: [{
                            targets: 0,
                            render: function(data, type, row) {
                                return "<div class='text-wrap'>" + data + "</div>";
                            }
                        }, {
                            targets: 1,
                            className: 'text-end',
                            render: function(data, type, row) {
                                return "<div class='text-wrap' style='width: 5%;'>" + data + "</div>";
                            }
                        }],
                        
                        drawCallback: function() {
                            $('#modalDetail .be-datatable-header').remove();
                        }
                    });

                    console.log('keputusan: ', data.data.keputusan);
                    if (data.data.keputusan == 'TBA') {
                        enableAllElements();
                        $('#keputusanField').prop('disabled', true).css({
                            'pointer-events': 'none',
                            'opacity': '0.5'
                        });
                    } else if (data.data.keputusan == 'Hold') {
                        enableAllElements();
                        $('#keputusanField').prop('disabled', false).css({
                            'pointer-events': 'auto',
                            'opacity': '1'
                        });
                    } 
                    else {
                        disableAllElements();
                        $('#keputusanField').prop('disabled', true).css({
                            'pointer-events': 'none',
                            'opacity': '0.5'
                        });
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var myText = errorThrown;
                    ShowErrorMessage('Error!', myText);
                }
            });
        });


        table.buttons().container().appendTo(
            $('.col-sm-6:eq(1)', table.table().container())
        );
        table.rows({
            page: 'all'
        }).data();
        $('.col-sm-6:eq(0)').addClass('xs-mb-20 sm-mb-0 md-mb-0 lg-mb-0');
        $('.col-sm-6:eq(1)').addClass('text-right');


        // Autofill DepartmentName (Share)
        $('#nama_penerima').on('change', function() {

            let departmentPenerima = $('#nama_penerima option:selected').attr('data-department');
            $('#department_penerima').val(departmentPenerima).trigger('change');

            let ptPenerima = $('#nama_penerima option:selected').attr('data-pt');
            $('#pt_penerima').val(ptPenerima).trigger('change');
        });


        // Autofill DepartmentName (Share) - Modal Detail
        $('#nama_penerima_detail').on('change', function() {

            let departmentPenerimaDetail = $('#nama_penerima_detail option:selected').attr('data-department');
            $('#department_penerima_detail').val(departmentPenerimaDetail).trigger('change');

            let ptPenerimaDetail = $('#nama_penerima_detail option:selected').attr('data-pt');
            $('#pt_penerima_detail').val(ptPenerimaDetail).trigger('change');
        });

        // Clear data form ModalAdd when hidden
        $('#modalAdd').on('hidden.bs.modal', function() {
            // Clear the form
            $("#nama_pengirim").val('');
            $("#perusahaan_pengirim").val('');

            $("#nama_penerima").val('').trigger("change");
            $("#department_penerima").val('').trigger("change");
            $("#pt_penerima").val('').trigger("change");

            $("#banyak_parcel").val('');
            $("#currency").val('').trigger("change");
            $("#estimasi_nominal").val('');
            $("#source_info_nominal").val('');
            $("#file").val('');

            $("#btnSave").prop("disabled", false);
        });

    });


    function enableAllElements() {
        $('#row1').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
        $('#row2').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
        $('#row3').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
        $('#row4').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });

        $('#btnSaveEdit').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
        $('#uploadFileButton').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
    }

    function disableAllElements() {
        $('#row1').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#row2').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#row3').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#row4').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });

        $('#btnSaveEdit').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#uploadFileButton').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
    }

    // Nampilin Modal Add, Jika Ditekan Button Add Data
    function ShowModalAdd() {
        $("#modalAdd").modal('show');
    }


    function ReloadTable() {
        table.ajax.reload(null, false);
    }

    function generateTable() {
        table.ajax.reload();
    }

    function clearform() {
        $("#reportAdd")[0].reset();
        $("#reportAdd").parsley().reset();

        $("#nama_pengirim").val('').trigger("change");
        $("#perusahaan_pengirim").val('').trigger("change");

        $("input[name='decision']").prop('checked', false).first().prop('checked', true).trigger('change');
        $("#nama_penerima").val('').trigger("change");
        $("#department_penerima").val('').trigger("change");

        $("#banyak_parcel").val('');
        $("#status_parcel").val('').trigger("change");

        $("#currency").val('').trigger("change");
        $("#estimasi_nominal").val('').trigger("change");
        $("#source_info_nominal").val('').trigger("change");
        $("#fileUpload").val('');

        $("#btnSave").prop("disabled", false);
    }

</script>