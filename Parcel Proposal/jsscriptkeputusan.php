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

            $("#currency_filter").val('').trigger("change");
            $("#estimasi_nominal_filter").val('');
            $("#source_info_nominal_filter").val('');
            $("#keputusan_filter").val('').trigger("change");

            generateTable();
        });


        // Menyimpan Perubahan (editdata.php)
        $('#btnSaveEdit').click(function(e) {
            e.preventDefault();
            var formData = new FormData($('#reportDetail')[0]);

            $(this).prop('disabled', true);
            $(this).text('Saving...');

            var keputusan_detail = $('select[name="keputusan_detail"]').val();
            if (!keputusan_detail) {
                ShowErrorMessage('Error!', 'Keputusan Tidak Boleh TBA!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }

            $.ajax({
                url: "module/parcel/editkeputusan.php",
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                success: function(data) {
                    if (data.code == 200) {
                        $('#modalDetail').modal('hide');
                        ShowSuccessMessage('Success!', 'Data Berhasil DiUpdate!');
                        ReloadTable();
                    } else {
                        var myText = data.msg;
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
                "url": "module/parcel/getdatakeputusan.php",
                "type": "POST",
                "data": function(d) {
                    form = $("#filter").serializeArray();
                    console.log(form);
                    $.each(form, function(key, val) {
                        d[val.name] = val.value;
                    });
                    d.useremail = $('[name="email"]').val();
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
            buttons: [
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


        // Nampilin Data pada Detail (getdetail.php)
        $('#ParcelTable').on('click', '.showDetail', function() {
            var id = $(this).data('id');
            console.log("ID parcel:", id);

            $('#modalDetail').modal('show');
            $.ajax({
                url: "module/parcel/getdetailkeputusan.php?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    // console.log("Data received:", data);
                    $('[name="id"]').val(data.data.id);
                    // $('[name="id_penerima"]').val(data.data.id);
                    // $('[name="id_pengirim"]').val(data.data.id_pengirim);
                    console.log(data.data);

                    document.getElementById("no_parcel_detail").textContent = data.data.no_parcel;

                    $('[name="nama_pengirim_detail"]').val(data.data.nama_pengirim);
                    $('[name="perusahaan_pengirim_detail"]').val(data.data.perusahaan_pengirim);

                    $('[name="nama_penerima_detail"]').val(data.data.id_nama_penerima);
                    $('[name="department_penerima_detail"]').val(data.data.department_penerima);
                    $('[name="pt_penerima_detail"]').val(data.data.pt_penerima);

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
                    // console.log(data.data.file_name);

                    if (data.data.file_name) {
                        rowTable += '<tr>' +
                                        '<td class="fileNameCell">' + data.data.file_name + '</td>' +
                                            '<td style="width: 10%">' +
                                                '<div style="">' +
                                                    // Tombol View
                                                    '<a href="' + baseUrl + '/engineering/fileParcel/' + data.data.file_name + '" ' +
                                                    'target="_blank" class="btn btn-info">' + '<i class="fas fa-eye"></i> View </a>' +

                                                    // Tombol Update
                                                    // '<button type="button" class="btn btn-success uploadFileButton" id="uploadFileButton"> <i class="fas fa-upload"></i> Update Current File </button>' +
                                                    // '<input type="file" class="fileInputDetail" name="fileInputDetail" style="display: none;">' +
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

                    if (data.data.keputusan == 'TBA' || data.data.keputusan == 'Hold' ) {
                        $('#keputusanCCO').css({
                            'pointer-events': 'auto',
                            'opacity': '1'
                        });
                        $('#btnSaveEdit').css({
                            'pointer-events': 'auto',
                            'opacity': '1'
                        });
                        
                    } else {
                        $('#keputusanCCO').css({
                            'pointer-events': 'none',
                            'opacity': '0.5'
                        });
                        $('#btnSaveEdit').css({
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
            let departmentPenerima = $('#nama_penerima option:selected').attr('data-title');
            $('#department_penerima').val(departmentPenerima).trigger('change');
        });

        // Autofill DepartmentName (Share) - Modal Detail
        $('#nama_penerima_detail').on('change', function() {
            let departmentPenerimaDetail = $('#nama_penerima_detail option:selected').attr('data-title');
            $('#department_penerima_detail').val(departmentPenerimaDetail).trigger('change');
        });


        // Clear data form ModalAdd when hidden
        $('#modalDetail').on('hidden.bs.modal', function() {
            // Clear the form
            $("#note_keputusan_detail").val('');

            $("#btnSaveEdit").prop("disabled", false);
        });

    });


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