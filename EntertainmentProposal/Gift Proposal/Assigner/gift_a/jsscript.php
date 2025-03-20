<script type="text/javascript">
    var save_method;
    var table;
    var originalApproverOptions = $('.approverSelect').first().html();
    var originalApproverOptionsDetail = null;

    $(document).ready(function() {
        App.dataTables();
        document.title = "Gift | Portal Engineering | PT Nusantara Compnet Integrator";

        originalApproverOptionsDetail = $('#approverContainerDetail .approverSelectDetail').html();

        // Select2 Untuk Add Gift
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

        // Select2 Untuk Detail Gift
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

        $(document).on('click', '.uploadFileButton', function() {
            // Trigger the corresponding file input click
            $(this).siblings('.fileInputDetail').click();

        });

        $(document).on('change', '.fileInputDetail', function() {
            var file = $(this).prop('files')[0];
            if (file) { // Ensure a file was selected
                var newFileName = file.name; // Get the name of the selected file
                // Update the file name in the same row
                $(this).closest('tr').find('.fileNameCell').text(newFileName);
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

            $("#nomor_pengajuan_filter").val('');
            $("#nama_filter").val('');
            $("#direktorat_filter").val('');
            $("#nama_penerima_filter").val('');
            $("#perusahaan_penerima_filter").val('');
            $("#jenis_pemberian_filter").val('');
            $("#tanggal_pengajuan_filter").val('');
            $("#tanggal_diberikan_filter").val('');
            $("#status_approval_filter").val('');

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
            var nama_pengusul = $('select[name="nama_pengusul"]').val();
            if (!nama_pengusul) {
                ShowErrorMessage('Error!', 'Nama Pengusul Harus Dipilih!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            // ROW 2 
            // var jabatan_pengusul = $('#jabatan_pengusul').val();
            // if (!jabatan_pengusul) {
            //     ShowErrorMessage('Error!', 'Jabatan Pengusul Harus Diisi!');
            //     $('#btnSave').text('Save');
            //     $('#btnSave').prop('disabled', false);
            //     return false;
            // }
            // var direktorat_pengusul = $('#direktorat_pengusul').val();
            // if (!direktorat_pengusul) {
            //     ShowErrorMessage('Error!', 'Direktorat Pengusul Harus Diisi!');
            //     $('#btnSave').text('Save');
            //     $('#btnSave').prop('disabled', false);
            //     return false;
            // }


            // ROW 3
            var jenisPemberian = $('input[name="jenisPemberian[]"]');
            if (jenisPemberian.filter(':checked').length == 0) {
                ShowErrorMessage('Error!', 'Jenis Pemberian Minimal Dipilih Satu!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            var gift = $('#gift');
            var giftText = $('#giftText');
            if (gift.is(':checked') && giftText.val().trim() === '') {
                ShowErrorMessage('Error!', 'Jenis Pemberian Gift Wajib Diisi Jika DiPilih!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }
            var entertainment = $('#entertainment');
            var entertainmentText = $('#entertainmentText');
            if (entertainment.is(':checked') && entertainmentText.val().trim() === '') {
                ShowErrorMessage('Error!', 'Jenis Pemberian Entertainment Wajib Diisi Jika DiPilih!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }
            var other = $('#other');
            var otherText = $('#otherText');
            if (other.is(':checked') && otherText.val().trim() === '') {
                ShowErrorMessage('Error!', 'Jenis Pemberian Other Wajib Diisi Jika DiPilih!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }


            // ROW 4
            var nama_penerima = $('#nama_penerima').val();
            if (!nama_penerima) {
                ShowErrorMessage('Error!', 'Nama Penerima Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }
            var perusahaan_penerima = $('#perusahaan_penerima').val();
            if (!perusahaan_penerima) {
                ShowErrorMessage('Error!', 'Perusahaan Penerima Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }


            // ROW 5
            var tanggal_diberikan = $('#tanggal_diberikan').val();
            if (!tanggal_diberikan) {
                ShowErrorMessage('Error!', 'Tanggal Diberikan Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }
            var tempat_diberikan = $('#tempat_diberikan').val();
            if (!tempat_diberikan) {
                ShowErrorMessage('Error!', 'Tempat Diberikan Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }


            // ROW 6
            var tujuan_pemberian = $('#tujuan_pemberian').val();
            if (!tujuan_pemberian) {
                ShowErrorMessage('Error!', 'Tujuan Diberikan Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }
            var currency = $('select[name="currency"]').val();
            if (!currency) {
                ShowErrorMessage('Error!', 'Currency Harus Dipilih!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }
            var estimasi_biaya = $('#estimasi_biaya').val();
            if (!estimasi_biaya) {
                ShowErrorMessage('Error!', 'Estimasi Biaya Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            } else if (isNaN(estimasi_biaya)) {
                ShowErrorMessage('Error!', 'Estimasi Biaya harus diisi dengan angka!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            // ROW 7
            $('input[name="file"]').on('change', function() {
                var inputFile = $('input[name="file"]')[0]; // Ambil elemen DOM dari input file
                // if (!inputFile.files || inputFile.files.length === 0) {
                //     ShowErrorMessage('Error!', 'File Harus Diisi!');
                //     $('#btnSave').text('Save');
                //     $('#btnSave').prop('disabled', false);
                //     return false;
                // }

                // Validasi ukuran file (maksimal 15MB)
                var fileSize = inputFile.files[0].size; // ukuran file dalam byte
                if (fileSize > 15 * 1024 * 1024) { // 15MB dalam byte
                    ShowErrorMessage('Warning!', 'File size max 15MB!');
                    $('#btnSave').text('Save');
                    $('#btnSave').prop('disabled', false);
                    return false;
                }
            });

            // Peserta
            var nama_peserta = $('select[name="nama_peserta[]"]').val();
            if (nama_peserta == null || nama_peserta == "") {
                ShowErrorMessage('Error!', 'Peserta Harus diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            var selectedApprovers = [];
            $('select[name="nama_peserta[]"]').each(function() {
                var selectedValue = $(this).val();
                if (selectedValue) {
                    var selectedOption = $(this).find('option:selected');

                    if (selectedApprovers.includes(selectedValue)) {
                        ShowErrorMessage('Error!', 'Sudah diPilih, Pilih Yang Lain!');
                        $(this).val('');
                        $('#btnSave').text('Save');
                        $('#btnSave').prop('disabled', false);
                    } else {
                        selectedApprovers.push(selectedValue);
                    }
                }
            });

            default_user_id = $('#default_user_id').val();
            formData.append('default_user_id', default_user_id);

            $.ajax({
                url: "module/gift_a/adddata.php",
                type: "POST",
                data: formData,
                dataType: "json", // Ensure the server returns valid JSON
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                success: function(data) {
                    if (data) {
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

        // Datatable (getdata.php)
        table = $('#GiftTable').DataTable({
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
                "url": "module/gift_a/getdata.php",
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
                    }
                },
                {
                    extend: 'csvHtml5',
                    filename: function() {
                        var d = new Date();
                        var n = d.getTime();
                        return "Audit Log Report-" + n;
                    },
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: function() {
                        var d = new Date();
                        var n = d.getTime();
                        return "Audit Log Report-" + n;
                    },
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    filename: function() {
                        var d = new Date();
                        var n = d.getTime();
                        return "Audit Log Report-" + n;
                    },
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'print',
                    filename: function() {
                        var d = new Date();
                        var n = d.getTime();
                        return "Audit Log Report-" + n;
                    },
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        }
                    }
                }
            ]
        });

        // Nampilin Data pada Detail (getdetail.php) - Version [0] (FetchAll)
        $('#GiftTable').on('click', '.showDetail', function() {
            var id = $(this).data('id');

            $('#modalDetail').modal('show');

            $.ajax({
                url: "module/gift_a/getdetail.php?id=" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id"]').val(data.data[0].idPengajuan);
                    $('[name="id_peserta"]').val(data.data[0].idPeserta);
                    $('[name="id_pengajuan"]').val(data.data[0].idPengajuan);

                    document.getElementById("nomor_pengajuan_detail").textContent = data.data[0].nomor_pengajuan;

                    let status = '';

                    if (data.data[0].status_pengajuan == 'Waiting Approval') {
                        status = '<span style="font-size: 15px;" class="badge badge-info">Waiting Approval</span>'
                    } else if (data.data[0].status_pengajuan == 'Rejected') {
                        status = '<span style="font-size: 15px;" class="badge badge-danger">Rejected</span>'
                    } else {
                        status = '<span style="font-size: 15px;" class="badge badge-success">Approved</span>'
                    }
                    $('#statusApp').html(status);

                    $('[name="nama_pengusul_detail"]').val(data.data[0].id_nama_pengusul).trigger("change");
                    $('[name="tanggal_pengajuan_detail"]').val(data.data[0].tanggal_pengajuan);
                    $('[name="jabatan_pengusul_detail"]').val(data.data[0].jabatan_pengusul);
                    $('[name="direktorat_pengusul_detail"]').val(data.data[0].direktorat_pengusul);

                    $('[name="giftText_detail"]').val(data.data[0].jenis_pemberian_gift);
                    $('[name="entertainmentText_detail"]').val(data.data[0].jenis_pemberian_entertainment);
                    $('[name="otherText_detail"]').val(data.data[0].jenis_pemberian_other);

                    $('[name="nama_penerima_detail"]').val(data.data[0].nama_penerima);
                    $('[name="perusahaan_penerima_detail"]').val(data.data[0].perusahaan_penerima);
                    $('[name="tanggal_diberikan_detail"]').val(data.data[0].tanggal_diberikan);
                    $('[name="tempat_diberikan_detail"]').val(data.data[0].tempat_diberikan);

                    $('[name="tujuan_pemberian_detail"]').val(data.data[0].tujuan_pemberian);
                    $('[name="currency_detail"]').val(data.data[0].id_currency).trigger("change");
                    $('[name="estimasi_biaya_detail"]').val(data.data[0].estimasi_biaya);


                    if (data.data[0].jenis_pemberian) {
                        var pemberianList = data.data[0].jenis_pemberian.split(',').map(item => item.trim());

                        $('#gift_detail, #entertainment_detail, #other_detail').prop('checked', false);
                        if (pemberianList.includes('Gift')) {
                            $('#gift_detail').prop('checked', true);
                        }
                        if (pemberianList.includes('Entertainment')) {
                            $('#entertainment_detail').prop('checked', true);
                        }
                        if (pemberianList.includes('Other')) {
                            $('#other_detail').prop('checked', true);
                        }
                        toggleFieldsDetail();
                    }

                    $('#gift_detail').on('change', function() {
                        if (!$(this).is(':checked')) {
                            $("#giftText_detail").val('');
                        }
                    });
                    $('#entertainment_detail').on('change', function() {
                        if (!$(this).is(':checked')) {
                            $("#entertainmentText_detail").val('');
                        }
                    });
                    $('#other_detail').on('change', function() {
                        if (!$(this).is(':checked')) {
                            $("#otherText_detail").val('');
                        }
                    });
                    $('#editPesertaButton').on('click', function() {
                        $('#modalPeserta').modal('show');
                    });
                    $('#btnPrint').on('click', function() {
                        window.open('module/gift_a/print.php?id=' + id, '_blank', 'location=yes,scrollbars=yes,status=yes')
                    });


                    $('[name="nama_peserta_detail[]"]').val(data.data[0].id_employee).trigger("change");
                    $('[name="direktorat_peserta_detail[]"]').val(data.data[0].direktorat_peserta_perusahaan).trigger("change");


                    // FILE
                    <?php
                        $baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];  // Base URL
                    ?>

                    let baseUrl = "<?php echo $baseUrl; ?>"; // Pass the generated PHP URL into JavaScript

                    if ($.fn.DataTable.isDataTable('#fileTableDokumen')) { // Destroy DataTable if it exists
                        $('#fileTableDokumen').DataTable().destroy();
                    }

                    let listFile = $('#listFileDokumen');
                    let rowTable = '';
                    listFile.empty(); // Clear the table body before appending new rows

                    console.log('Received data:', data.dataLampiran); // Debugging: Log data to check if it exists

                    try {
                        // Check if data and dataLampiran exist and file_name is not empty
                        if (data.dataLampiran && data.dataLampiran.file_name !== null) {
                            // console.log('File found:', data.dataLampiran.file_name);

                            rowTable += '<tr>' +
                                            '<td class="fileNameCell">' + data.dataLampiran.file_name + '</td>' +
                                                '<td style="width: 10%">' +
                                                    '<div style="display: flex; gap: 30%;">' +
                                                        // Tombol View
                                                        '<a href="' + baseUrl + '/portalform/fileGift/' + data.dataLampiran.file_name + '" ' +
                                                        'target="_blank" class="btn btn-info">' + '<i class="fas fa-eye"></i> View </a>' +

                                                        // Tombol Update
                                                        '<button type="button" class="btn btn-success uploadFileButton" id="uploadFileButton"> <i class="fas fa-upload"></i> Update Current File </button>' +
                                                        '<input type="file" class="fileInputDetail" name="fileInputDetail" style="display: none;">' +
                                                    '</div>' +
                                                '</td>' +
                                        '</tr>';
                        } else if (data.dataLampiran && data.dataLampiran.file_name == null) {
                            rowTable = '<tr><td style="text-align: center" colspan="2">No Data</td></tr>';
                        }

                        // Append rows to the table
                        listFile.append(rowTable);
                        $('#fileTableDokumen').DataTable({
                            responsive: true,
                            processing: true,
                            paging: false,
                            searching: false,
                            info: false,
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

                        // Debugging: Modal state
                        console.log('Opening modal...');
                        $("#modalDetail").modal('show');

                    } catch (error) {
                        // Log any errors that occur
                        console.error('An error occurred while processing the table:', error);
                        ShowErrorMessage('Error!', error.message);
                    }

                    // MODAL PESERTA
                    $('#approverContainerDetail').empty();
                    $('#jenisapproverdivDetail').empty();

                    let idPeserta = data.data[0].id_employee;
                    let jumlahPeserta = data.data;

                    if (idPeserta && jumlahPeserta.length > 0) {
                        for (let index = 0; index < jumlahPeserta.length; index++) {
                            let approver = jumlahPeserta[index];
                            console.log('approver', jumlahPeserta[index]);

                            if (approver.id_employee) {
                                let approverDiv = `<div class="jenisapproverdivDetail" id="jenisapproverdivDetail">
                                                    <div class="col-md-6">
                                                        <label class="approver-label">Nama Peserta ${index + 1}</label>
                                                        <div class="d-flex align-items-center">
                                                            <div class="">
                                                                <select name="nama_peserta_detail[]" id="nama_peserta_detail" class="form-control select2 approverSelectDetail" style="position: relative; z-index: 1050;">
                                                                    <option value="" disabled ${approver.id_employee ? '' : 'selected'}>Choose Your Approver</option>
                                                                        ${data.listemployee.map(employee => ` <option value="${employee.id}" data_email="${employee.email}" data_title="${employee.directorate}" data_fullName="${employee.full_name}" ${employee.id == approver.id_employee ? 'selected' : ''}>  ${employee.full_name}  </option>`).join('')}                                                                   
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" style="pointer-events: none; opacity: 0.5;">
                                                        <label class="direktorat-label" for="direktorat_peserta_detail">Direktorat Peserta ${index + 1}</label>
                                                        <input type="text" name="direktorat_peserta_detail[]" id="direktorat_peserta_detail" class="form-control input-sm" value="${approver.direktorat_peserta_perusahaan || ''}"  placeholder="Direktorat Tidak Tersedia" disabled>
                                                    </div>

                                                    <div class="col-md-2" style="margin-top: 3.3%;">
                                                        <button type="button" class="btn btn-success btnAddDetail me-1">+</button>
                                                        <button type="button" class="btn btn-danger btnRemoveDetail">-</button>
                                                    </div>
                                                </div>`;

                                if (index === 0) {
                                    $('#approverContainerDetail').append(approverDiv);
                                } else {
                                    $('#jenisapproverdivDetail').append(approverDiv);
                                }

                            } else {
                                console.error('Approver id_employee is missing for index: ' + index);
                            }
                        }

                    } else {
                        console.error('No valid data available for approvers.');
                    }
                    attachApproverDetailEventHandlers();


                    $('#approverContainerDetail').on('change', '.approverSelectDetail', function() {
                        let direktoratePeserta = $(this).find('option:selected').attr('data_title');
                        $(this).closest('.jenisapproverdivDetail').find('[name="direktorat_peserta_detail[]"]').val(direktoratePeserta).trigger('change');
                    });

                    currentListEmployee = data.listemployee;
                    originalApproverOptionsDetail = generateApproverOptions(currentListEmployee);


                    // Informasi Peserta
                    $('#pesertaTable').DataTable().destroy();
                    let listPeserta = $('#listPeserta');
                    let rowTable2 = '';

                    // Clear the table body before appending new rows
                    listPeserta.empty();

                    if (jumlahPeserta != null && jumlahPeserta.length > 0) {
                        jumlahPeserta.forEach(e => {
                            rowTable2 += '<tr>' +
                                '<td>' + (e.nama_peserta_perusahaan ?? '-') + '</td>' +
                                '<td>' + (e.direktorat_peserta_perusahaan ?? '-') + '</td>' +
                                '</tr>';
                        });
                    } else {
                        rowTable2 = '<tr><td style="text-align: center" colspan="5">No Data</td></tr>';
                    }
                    listPeserta.append(rowTable2);
                    tablePeserta = $('#pesertaTable').DataTable({
                        responsive: true,
                        processing: true,
                        paging: false,
                        searching: false,
                        lengthMenu: [
                            [-1],
                            ['All']
                        ],

                        drawCallback: function() {
                            $('#modalDetail .be-datatable-header').remove();
                        }
                    });


                    // Informasi Approval
                    $('#approverTable').DataTable().destroy();
                    let listApprover = $('#listApprover');
                    let rowTable3 = '';
                    listApprover.empty(); // Clear the table body before appending new rows

                    if (data.dataApprover != null && data.dataApprover.length > 0) {
                        data.dataApprover.forEach(e => {
                            rowTable3 += '<tr>' +
                                '<td>' + (e.approver_name ?? '-') + '</td>' +
                                '<td>' + (e.approval_status ?? '-') + '</td>' +
                                '<td>' + (e.tanggal_approval == '0000-00-00' ? '-' : e.tanggal_approval) + '</td>' +
                                '<td>' + (e.approver_level ?? '-') + '</td>' +
                                '<td>' + (e.notes ?? '-') + '</td>' +
                                '</tr>';
                        });
                    } else {
                        rowTable3 = '<tr><td style="text-align: center" colspan="5">No Data</td></tr>';
                    }
                    listApprover.append(rowTable3);
                    tableApprover = $('#approverTable').DataTable({
                        responsive: true,
                        processing: true,
                        paging: false,
                        searching: false,
                        lengthMenu: [
                            [-1],
                            ['All']
                        ],
                        order: [
                            [3, 'asc']
                        ],

                        drawCallback: function() {
                            $('#modalDetail .be-datatable-header').remove();
                        }
                    });

                    // Collect all approval status
                    var statuses = data.dataApprover.map(function(approver) {
                        return approver.approval_status;
                    });

                    if (statuses.every(function(status) {
                            return status === 'Waiting Approval';
                        })) { // Jika semua status adalah "Waiting Approval"
                        enableAllElements();
                        console.log('Statuses1:', statuses);

                        if (data.data[0].jenis_pemberian) {
                            var pemberianList = data.data[0].jenis_pemberian.split(',').map(item => item.trim());

                            $('#giftText_detail').prop('disabled', false).css({
                                'pointer-events': 'auto',
                                'opacity': '1'
                            });

                            $('#entertainmentText_detail').prop('disabled', false).css({
                                'pointer-events': 'auto',
                                'opacity': '1'
                            });

                            $('#otherText_detail').prop('disabled', false).css({
                                'pointer-events': 'auto',
                                'opacity': '1'
                            });

                            $('#gift_detail, #entertainment_detail, #other_detail').prop('checked', false);
                            if (pemberianList.includes('Gift')) {
                                $('#gift_detail').prop('checked', true);
                                $('#gift_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                                $('#giftText_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });
                            }
                            if (pemberianList.includes('Entertainment')) {
                                $('#entertainment_detail').prop('checked', true);
                                $('#entertainment_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                                $('#entertainmentText_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                            }
                            if (pemberianList.includes('Other')) {
                                $('#other_detail').prop('checked', true);
                                $('#other_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                                $('#otherText_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                            }
                            toggleFieldsDetail();
                        }

                    } else if (statuses.includes('Approved')) { // Jika ada status "Approved"
                        disableAllElements();
                        console.log('Statuses2:', statuses);

                        if (data.data[0].jenis_pemberian) {
                            var pemberianList = data.data[0].jenis_pemberian.split(',').map(item => item.trim());

                            $('#btnPrint').prop('disabled', true).css({
                                'opacity': '0.5'
                            });
                            $('#uploadFileButton').prop('disabled', true).css({
                                'pointer-events': 'none',
                                'opacity': '0.5'
                            });

                            $('#gift_detail, #entertainment_detail, #other_detail').prop('checked', false);
                            if (pemberianList.includes('Gift')) {
                                $('#gift_detail').prop('checked', true);
                                $('#gift_detail').prop('disabled', true).css({
                                    'pointer-events': 'none',
                                    'opacity': '0.5'
                                });
                                $('#giftText_detail').prop('disabled', true).css({
                                    'pointer-events': 'none',
                                    'opacity': '0.5'
                                });
                            }
                            if (pemberianList.includes('Entertainment')) {
                                $('#entertainment_detail').prop('checked', true);
                                $('#entertainment_detail').prop('disabled', true).css({
                                    'pointer-events': 'none',
                                    'opacity': '0.5'
                                });
                                $('#entertainmentText_detail').prop('disabled', true).css({
                                    'pointer-events': 'none',
                                    'opacity': '0.5'
                                });

                            }
                            if (pemberianList.includes('Other')) {
                                $('#other_detail').prop('checked', true);
                                $('#other_detail').prop('disabled', true).css({
                                    'pointer-events': 'none',
                                    'opacity': '0.5'
                                });

                                $('#otherText_detail').prop('disabled', true).css({
                                    'pointer-events': 'none',
                                    'opacity': '0.5'
                                });

                            }
                            toggleFieldsDetail();
                        }

                        if (statuses.includes('Rejected')) { // Jika ada juga status "Rejected"
                            enableAllElements();
                            console.log('Statuses3:', statuses);

                            if (data.data[0].jenis_pemberian) {
                                var pemberianList = data.data[0].jenis_pemberian.split(',').map(item => item.trim());

                                $('#giftText_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                                $('#entertainmentText_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                                $('#otherText_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                                $('#gift_detail, #entertainment_detail, #other_detail').prop('checked', false);
                                if (pemberianList.includes('Gift')) {
                                    $('#gift_detail').prop('checked', true);
                                    $('#gift_detail').prop('disabled', false).css({
                                        'pointer-events': 'auto',
                                        'opacity': '1'
                                    });

                                    $('#giftText_detail').prop('disabled', false).css({
                                        'pointer-events': 'auto',
                                        'opacity': '1'
                                    });
                                }
                                if (pemberianList.includes('Entertainment')) {
                                    $('#entertainment_detail').prop('checked', true);
                                    $('#entertainment_detail').prop('disabled', false).css({
                                        'pointer-events': 'auto',
                                        'opacity': '1'
                                    });

                                    $('#entertainmentText_detail').prop('disabled', false).css({
                                        'pointer-events': 'auto',
                                        'opacity': '1'
                                    });

                                }
                                if (pemberianList.includes('Other')) {
                                    $('#other_detail').prop('checked', true);
                                    $('#other_detail').prop('disabled', false).css({
                                        'pointer-events': 'auto',
                                        'opacity': '1'
                                    });

                                    $('#otherText_detail').prop('disabled', false).css({
                                        'pointer-events': 'auto',
                                        'opacity': '1'
                                    });

                                }
                                toggleFieldsDetail();
                            }
                        }

                    } else if (statuses.includes('Rejected')) {
                        enableAllElements(); // Jika ada status "Rejected"
                        console.log('Statuses4:', statuses);

                        if (data.data[0].jenis_pemberian) {
                            var pemberianList = data.data[0].jenis_pemberian.split(',').map(item => item.trim());

                            $('#giftText_detail').prop('disabled', false).css({
                                'pointer-events': 'auto',
                                'opacity': '1'
                            });

                            $('#entertainmentText_detail').prop('disabled', false).css({
                                'pointer-events': 'auto',
                                'opacity': '1'
                            });

                            $('#otherText_detail').prop('disabled', false).css({
                                'pointer-events': 'auto',
                                'opacity': '1'
                            });

                            $('#gift_detail, #entertainment_detail, #other_detail').prop('checked', false);
                            if (pemberianList.includes('Gift')) {
                                $('#gift_detail').prop('checked', true);
                                $('#gift_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                                $('#giftText_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });
                            }
                            if (pemberianList.includes('Entertainment')) {
                                $('#entertainment_detail').prop('checked', true);
                                $('#entertainment_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                                $('#entertainmentText_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                            }
                            if (pemberianList.includes('Other')) {
                                $('#other_detail').prop('checked', true);
                                $('#other_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                                $('#otherText_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                            }
                            toggleFieldsDetail();
                        }

                    } else {
                        enableAllElements(); // Default: jika tidak ada kondisi di atas
                        console.log('Statuses5:', statuses);

                        if (data.data[0].jenis_pemberian) {
                            var pemberianList = data.data[0].jenis_pemberian.split(',').map(item => item.trim());

                            $('#giftText_detail').prop('disabled', false).css({
                                'pointer-events': 'auto',
                                'opacity': '1'
                            });

                            $('#entertainmentText_detail').prop('disabled', false).css({
                                'pointer-events': 'auto',
                                'opacity': '1'
                            });

                            $('#otherText_detail').prop('disabled', false).css({
                                'pointer-events': 'auto',
                                'opacity': '1'
                            });

                            $('#gift_detail, #entertainment_detail, #other_detail').prop('checked', false);
                            if (pemberianList.includes('Gift')) {
                                $('#gift_detail').prop('checked', true);
                                $('#gift_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                                $('#giftText_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });
                            }
                            if (pemberianList.includes('Entertainment')) {
                                $('#entertainment_detail').prop('checked', true);
                                $('#entertainment_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                                $('#entertainmentText_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                            }
                            if (pemberianList.includes('Other')) {
                                $('#other_detail').prop('checked', true);
                                $('#other_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                                $('#otherText_detail').prop('disabled', false).css({
                                    'pointer-events': 'auto',
                                    'opacity': '1'
                                });

                            }
                            toggleFieldsDetail();
                        }

                    }

                    if (statuses.every(function(status) {
                            return status === 'Approved';
                        })) { // Jika semua status Approved
                        $('#btnPrint').prop('disabled', false).css({
                            'opacity': '1'
                        });
                        $('#btnSaveEdit').prop('disabled', true).css({
                            'pointer-events': 'none',
                            'opacity': '0.5'
                        });
                        $('#currenyDetail').prop('disabled', true).css({
                            'pointer-events': 'none',
                            'opacity': '0.5'
                        });
                        $('#uploadFileButton').prop('disabled', true).css({
                            'pointer-events': 'none',
                            'opacity': '0.5'
                        });
                    }

                    $("#modalDetail").modal('show');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var myText = errorThrown;
                    ShowErrorMessage('Error!', myText);
                }
            });
        });


        
        // Menyimpan Data (editdatapeserta.php)
        $('#btnSavePeserta').click(function(e) {
            e.preventDefault();
            var formData = new FormData($('#reportEditPeserta')[0]);

            var id_peserta = parseInt($('#id_peserta').val());
            console.log('id_peserta:', id_peserta);

            $(this).prop('disabled', true);
            $(this).text('Saving...');

            // var selectedOption = $('select[name="nama_penerima"] option:selected');
            // var dataType = selectedOption.data('type');


            // Peserta
            var nama_peserta = $('select[name="nama_peserta_detail[]"]').val();
            if (nama_peserta == null || nama_peserta == "") {
                ShowErrorMessage('Error!', 'Peserta Harus diisi!');
                $('#btnSavePeserta').text('Save');
                $('#btnSavePeserta').prop('disabled', false);
                return false;
            }

            var selectedApprovers = [];
            $('select[name="nama_peserta_detail[]"]').each(function() {
                var selectedValue = $(this).val();
                if (selectedValue) {
                    var selectedOption = $(this).find('option:selected');

                    if (selectedApprovers.includes(selectedValue)) {
                        ShowErrorMessage('Error!', 'Sudah diPilih, Pilih Yang Lain!');
                        $(this).val('');
                        $('#btnSavePeserta').text('Save');
                        $('#btnSavePeserta').prop('disabled', false);
                    } else {
                        selectedApprovers.push(selectedValue);
                    }
                }
            });

            var selectedDirectorateDetails = $('input[name="direktorat_peserta_detail[]"]').map(function() {
                return $(this).val(); // Ambil nilai setiap input
            }).get(); // Konversi hasil menjadi array

            console.log('selectedDirectorateDetails:', selectedDirectorateDetails);

            selectedDirectorateDetails.forEach(function(value) {
                formData.append('direktorat_peserta_detail[]', value);
            });

            $.ajax({
                url: "module/gift_a/editdatapeserta.php",
                type: "POST",
                data: formData,
                dataType: "json", // Ensure the server returns valid JSON
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                success: function(data) {
                    if (data) {
                        ShowSuccessMessage('Success!', 'Data Berhasil DiUpdate!');
                        $('#modalPeserta').modal('hide');
                        $('#modalDetail').css('overflow-y', 'auto');
                    } else {
                        var myText = data.msg;
                        ShowWarningMessage('Warning!', myText);
                    }
                    ReloadTablePeserta();
                    ReloadTable();
                    $('#btnSavePeserta').text('Save');
                    $('#btnSavePeserta').prop('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var myText = errorThrown;
                    ShowErrorMessage('Error!', myText);
                    $('#btnSavePeserta').text('Save');
                    $('#btnSavePeserta').prop('disabled', false);
                }
            });
            
        });

        // Menyimpan Data (editdata.php)
        $('#btnSaveEdit').click(function(e) {
            e.preventDefault();
            var formData = new FormData($('#reportDetail')[0]);

            $(this).prop('disabled', true);
            $(this).text('Saving...');

            var selectedOption = $('select[name="nama_penerima"] option:selected');
            var dataType = selectedOption.data('type');

            // ROW 1
            var nama_pengusul_detail = $('select[name="nama_pengusul_detail"]').val();
            if (!nama_pengusul_detail) {
                ShowErrorMessage('Error!', 'Nama Pengusul Harus Dipilih!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }

            // ROW 2 
            // var jabatan_pengusul_detail = $('#jabatan_pengusul_detail').val();
            // if (!jabatan_pengusul_detail) {
            //     ShowErrorMessage('Error!', 'Jabatan Pengusul Harus Diisi!');
            //     $('#btnSaveEdit').text('Save');
            //     $('#btnSaveEdit').prop('disabled', false);
            //     return false;
            // }
            // var direktorat_pengusul_detail = $('#direktorat_pengusul_detail').val();
            // if (!direktorat_pengusul_detail) {
            //     ShowErrorMessage('Error!', 'Direktorat Pengusul Harus Diisi!');
            //     $('#btnSaveEdit').text('Save');
            //     $('#btnSaveEdit').prop('disabled', false);
            //     return false;
            // }


            // ROW 3
            var jenisPemberian = $('input[name="jenisPemberian[]"]');
            if (jenisPemberian.filter(':checked').length == 0) {
                ShowErrorMessage('Error!', 'Jenis Pemberian Minimal Dipilih Satu!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }

            var gift_detail = $('#gift_detail');
            var giftText_detail = $('#giftText_detail');
            if (gift_detail.is(':checked') && giftText_detail.val().trim() === '') {
                ShowErrorMessage('Error!', 'Jenis Pemberian Gift Wajib Diisi Jika DiPilih!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }
            var entertainment_detail = $('#entertainment_detail');
            var entertainmentText_detail = $('#entertainmentText_detail');
            if (entertainment_detail.is(':checked') && entertainmentText_detail.val().trim() === '') {
                ShowErrorMessage('Error!', 'Jenis Pemberian Entertainment Wajib Diisi Jika DiPilih!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }
            var other_detail = $('#other_detail');
            var otherText_detail = $('#otherText_detail');
            if (other_detail.is(':checked') && otherText_detail.val().trim() === '') {
                ShowErrorMessage('Error!', 'Jenis Pemberian Other Wajib Diisi Jika DiPilih!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }


            // ROW 4
            var nama_penerima_detail = $('#nama_penerima_detail').val();
            if (!nama_penerima_detail) {
                ShowErrorMessage('Error!', 'Nama Penerima Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }
            var perusahaan_penerima_detail = $('#perusahaan_penerima_detail').val();
            if (!perusahaan_penerima_detail) {
                ShowErrorMessage('Error!', 'Perusahaan Penerima Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }


            // ROW 5
            var tanggal_diberikan_detail = $('#tanggal_diberikan_detail').val();
            if (!tanggal_diberikan_detail) {
                ShowErrorMessage('Error!', 'Tanggal Diberikan Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }
            var tempat_diberikan_detail = $('#tempat_diberikan_detail').val();
            if (!tempat_diberikan_detail) {
                ShowErrorMessage('Error!', 'Tempat Diberikan Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }


            // ROW 6
            var tujuan_pemberian_detail = $('#tujuan_pemberian_detail').val();
            if (!tujuan_pemberian_detail) {
                ShowErrorMessage('Error!', 'Tujuan Diberikan Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }
            var currency_detail = $('select[name="currency_detail"]').val();
            if (!currency_detail) {
                ShowErrorMessage('Error!', 'Currency Harus Dipilih!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }
            var estimasi_biaya_detail = $('#estimasi_biaya_detail').val();
            if (!estimasi_biaya_detail) {
                ShowErrorMessage('Error!', 'Estimasi Biaya Harus Diisi!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            } else if (isNaN(estimasi_biaya_detail)) {
                ShowErrorMessage('Error!', 'Estimasi Biaya harus diisi dengan angka!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }

            var selectedApprovers = [];
            $('select[name="jenisapproverDetail[]"]').each(function() {
                var selectedValue = $(this).val();
                if (selectedValue) {
                    var selectedOption = $(this).find('option:selected');
                    var selectedEmail = selectedOption.attr('data_email');
                    var selectedName = selectedOption.attr('data_fullName');

                    if (selectedApprovers.includes(selectedValue)) {
                        swal.fire(
                            'This approver has already been selected. Please choose another.'
                        );
                        $(this).val('');
                        $('#saveApproverChanges').prop('disabled', false).text('Save Changes');
                    } else {
                        selectedApprovers.push(selectedValue);
                        formData.append('jenisapproveremailDetail[]', selectedEmail);
                        formData.append('jenisapprovernameDetail[]', selectedName);
                    }
                }
            });

            $.ajax({
                url: "module/gift_a/editdata.php",
                type: "POST",
                data: formData,
                dataType: "json", // Ensure the server returns valid JSON
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                success: function(data) {
                    if (data) {
                        $('#modalDetail').modal('hide');
                        ShowSuccessMessage('Success!', 'Data Berhasil DiUpdate!');
                        ReloadTable();
                    } else {
                        var myText = data.msg;
                        ShowWarningMessage('Warning!', myText);
                    }
                    // clearform();
                    $('#btnSaveEdit').text('Save');
                    $('#btnSaveEdit').prop('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var myText = errorThrown;
                    ShowErrorMessage('Error!', myText);
                    $('#btnSaveEdit').text('Save');
                    $('#btnSaveEdit').prop('disabled', false);
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



        // MODAL ADD - PESERTA
        initializeSelect2($('.approverSelect'));
        // Event handler untuk tombol Add
        $('#approverContainer').on('click', '.btnAdd', function() {
            var lastApproverDiv = $('.jenisapproverdiv').last();

            // Hancurkan instance Select2 sebelum cloning
            lastApproverDiv.find('.approverSelect').select2('destroy');

            // Clone elemen
            var newField = lastApproverDiv.clone();

            // Inisialisasi ulang Select2 pada elemen asli
            initializeSelect2(lastApproverDiv.find('.approverSelect'));

            // Reset nilai select pada elemen baru
            newField.find('select').val('');

            newField.find('input').val('');

            // Hapus atribut ID untuk menghindari duplikasi
            newField.find('[id]').each(function() {
                $(this).removeAttr('id');
            });

            // Update label
            var approverCount = $('.jenisapproverdiv').length + 1;
            newField.find('.approver-label').text('Peserta ' + approverCount);

            // Sisipkan field baru setelah field terakhir
            newField.insertAfter(lastApproverDiv);

            // Inisialisasi Select2 pada elemen baru
            initializeSelect2(newField.find('.approverSelect'));

            $('#approverContainer').on('change', '.approverSelect', function() {
                let direktoratePeserta = $(this).find('option:selected').attr('data-title');
                $(this).closest('.jenisapproverdiv').find('[name="direktorat_peserta[]"]').val(direktoratePeserta).trigger('change');
            });


            // Mengatur ulang opsi approver
            filterApproverOptions();
            updateApproverLabels();
        });

        // Event handler untuk tombol Remove
        $('#approverContainer').on('click', '.btnRemove', function() {
            var approvers = $('.jenisapproverdiv');
            if (approvers.length > 1) {
                // Hancurkan instance Select2 sebelum menghapus elemen
                $(this).closest('.jenisapproverdiv').find('.approverSelect').select2('destroy');
                $(this).closest('.jenisapproverdiv').remove();
                filterApproverOptions();
                updateApproverLabels();
            } else {
                ShowErrorMessage('Error!', 'Minimal satu peserta harus ada!');
            }
        });



        // MODAL DETAIL - PESERTA
        $(document).on('click', '.btnAddDetail', function() {
            var approverCount = $('.jenisapproverdivDetail').length;
            var newApproverField = createApproverField(approverCount, null);
            $('#approverContainerDetail').append(newApproverField); // Tambahkan ke container

            // Initialize Select2 and event handlers for the new field
            initializeSelect2Detail($('.approverSelectDetail').last());
            updateApproverLabelsDetail();
            filterApproverOptionsDetail();
        });

        $(document).on('click', '.btnRemoveDetail', function() {
            if ($('.jenisapproverdivDetail').length > 1) { // Jangan hapus jika hanya ada satu baris
                $(this).closest('.jenisapproverdivDetail').remove();

                updateApproverLabelsDetail();
                filterApproverOptionsDetail();
            } else {
                ShowErrorMessage('Error!', 'Minimal satu peserta harus ada!');
            }
        });


        // Autofill Nama Pengusul & Tanggal Pengajuan
        $('#modalAdd').on('shown.bs.modal', function() {
            const defaultUserId = $('#default_user_id').val();
            if (defaultUserId) {
                $('#nama_pengusul').val(defaultUserId).trigger('change'); // Trigger change for select2 UI
            }

            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0]; // Format ke yyyy-mm-dd

            $('#tanggal_pengajuan').val(formattedDate);
        });


        // Trigger Validasi JenisPemberian (Modal Add)
        $('input[name="jenisPemberian[]"]').change(function() {
            toggleFields();
        });

        // Trigger Validasi JenisPemberian (Modal Detail)
        $('input[name="jenisPemberian[]"]').change(function() {
            toggleFieldsDetail();
        });

        // Autofill Jabatan (Modal Add)
        $('#nama_pengusul').on('change', function() {
            let titlePengusul = $('#nama_pengusul option:selected').attr('data-title');
            $('#jabatan_pengusul').val(titlePengusul).trigger('change');

            let departmentPengusul = $('#nama_pengusul option:selected').attr('data-directorate');
            $('#direktorat_pengusul').val(departmentPengusul).trigger('change');
        });

        // Autofill Peserta (Modal Add)
        $('#nama_peserta').on('change', function() {
            let direktoratePeserta = $('#nama_peserta option:selected').attr('data-title');
            $('#direktorat_peserta').val(direktoratePeserta).trigger('change');
        });

        // Autofill Jabatan (Modal Detail)
        $('#nama_pengusul_detail').on('change', function() {
            let titlePengusulDetail = $('#nama_pengusul_detail option:selected').attr('data-title');
            $('#jabatan_pengusul_detail').val(titlePengusulDetail).trigger('change');

            let departmentPengusulDetail = $('#nama_pengusul_detail option:selected').attr('data-directorate');
            $('#direktorat_pengusul_detail').val(departmentPengusulDetail).trigger('change');
        });

        // Autofill Peserta (Modal Detail)
        $('#nama_peserta_detail').on('change', function() {
            let direktoratePesertaDetail = $('#nama_peserta_detail option:selected').attr('data-title');
            $('#direktorat_peserta_detail').val(direktoratePesertaDetail).trigger('change');
        });



        // Clear data form ModalAdd when hidden
        $('#modalAdd').on('hidden.bs.modal', function() {
            $("#nama_pengusul").val('').trigger("change");
            $("#tanggal_pengajuan").val('');
            $("#jabatan_pengusul").val('');
            $("#direktorat_pengusul").val('');

            $("input[name='jenisPemberian[]']").prop('checked', false).trigger('change');
            $("#giftText").val('');
            $("#entertainmentText").val('');
            $("#otherText").val('');

            $("#nama_penerima").val('');
            $("#perusahaan_penerima").val('');
            $("#tanggal_diberikan").val('');
            $("#tempat_diberikan").val('');

            $("#tujuan_pemberian").val('');
            $("#currency").val('').trigger("change");
            $("#estimasi_biaya").val('');
            $("#file").val('');

            $('.jenisapproverdiv').not(':first').remove();
            $('#approverContainer .jenisapproverdiv:first select[name="nama_peserta[]"]').val('').trigger('change');

            $("#btnSave").prop("disabled", false);
        });

    });

    // Validasi Untuk Jenis Pemberian
    function toggleFields() {
        if ($('#gift').is(':checked')) {
            $('#giftTextContainer').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        } else {
            $('#giftTextContainer').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
            $('#giftText').val('');

        }

        // Periksa status #entertainment
        if ($('#entertainment').is(':checked')) {
            $('#entertainmentTextContainer').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        } else {
            $('#entertainmentTextContainer').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
            $('#entertainmentText').val('');

        }

        // Periksa status #other
        if ($('#other').is(':checked')) {
            $('#otherTextContainer').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        } else {
            $('#otherTextContainer').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
            $('#otherText').val('');

        }

    }

    // Validasi Untuk Jenis Pemberian Detail
    function toggleFieldsDetail() {
        if ($('#gift_detail').is(':checked')) {
            $('#giftTextContainer_detail').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        } else {
            $('#giftTextContainer_detail').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
        }

        // Periksa status #entertainment
        if ($('#entertainment_detail').is(':checked')) {
            $('#entertainmentTextContainer_detail').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        } else {
            $('#entertainmentTextContainer_detail').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
        }

        // Periksa status #other
        if ($('#other_detail').is(':checked')) {
            $('#otherTextContainer_detail').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        } else {
            $('#otherTextContainer_detail').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
        }

    }



    // MODAL ADD
    function initializeSelect2(element) {
        element.select2({
            placeholder: "Choose Your Approver",
            allowClear: true,
            width: '100%',
            dropdownParent: element.parent(), // Agar dropdown muncul dengan benar
        });
    }

    function filterApproverOptions() {
        var selectedValues = [];
        $('.approverSelect').each(function() {
            if ($(this).val() !== "") {
                selectedValues.push($(this).val());
            }
        });

        $('.approverSelect').each(function() {
            var $dropdown = $(this);
            var currentValue = $dropdown.val();

            // Kembalikan opsi ke kondisi awal
            $dropdown.html(originalApproverOptions);

            // Hapus opsi yang sudah dipilih di select lain
            $dropdown.find('option').each(function() {
                if (selectedValues.indexOf($(this).val()) !== -1 && $(this).val() !== currentValue) {
                    $(this).remove();
                }
            });

            // Set nilai saat ini
            $dropdown.val(currentValue);

            // Refresh Select2
            $dropdown.trigger('change.select2');
        });
    }

    // Fungsi untuk memperbarui label approver
    function updateApproverLabels() {
        $('.approver-label').each(function(index) {
            $(this).text('Peserta ' + (index + 1));
        });
    }



    // MODAL DETAIL
    // Function to generate the options HTML
    function generateApproverOptions(employeeList) {
        return employeeList.map(employee => `
            <option value="${employee.id}" data_email="${employee.email}" data_title="${employee.directorate}" data_fullName="${employee.full_name}">
                ${employee.full_name}
            </option>
        `).join('');
    }

    // EventHandlers
    function attachApproverDetailEventHandlers() {
        initializeSelect2Detail($('.approverSelectDetail'));

        updateApproverLabelsDetail();
        filterApproverOptionsDetail();
    }

    // Fungsi untuk menginisialisasi Select2 pada elemen approver di modal edit
    function initializeSelect2Detail(element) {
        element.select2({
            placeholder: "Choose Your Approver",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#modalPeserta'),
        });
    }

    // Urutan Approver Detail
    function updateApproverLabelsDetail() {
        $('.jenisapproverdivDetail').each(function(index) {
            $(this).find('.approver-label').text('Peserta ' + (index + 1));
        });

        $('.jenisapproverdivDetail').each(function(index) {
            $(this).find('.direktorat-label').text('Direktorat Peserta ' + (index + 1));
        });
    }

    // Cek Duplikasi Approver Detail
    function filterApproverOptionsDetail() {
        var selectedValues = [];
        $('.approverSelectDetail').each(function() {
            var value = $(this).val();
            if (value !== "") {
                selectedValues.push(value);
            }
        });

        $('.approverSelectDetail').each(function() {
            var $dropdown = $(this);
            var currentValue = $dropdown.val();

            // Reset options to the original unfiltered options
            $dropdown.html('<option value="" disabled>Choose Your Approver</option>' +
                originalApproverOptionsDetail);

            // Remove options that have been selected in other selects
            $dropdown.find('option').each(function() {
                var optionValue = $(this).val();
                if (selectedValues.indexOf(optionValue) !== -1 && optionValue !== currentValue) {
                    $(this).remove();
                }
            });

            // Set the current value
            $dropdown.val(currentValue);

            // Refresh Select2
            $dropdown.trigger('change.select2');
        });
    }

    function createApproverField(index, selectedValue) {
        return `<div class="jenisapproverdivDetail" id="jenisapproverdivDetail">
                    <div class="col-md-6">
                        <label class="approver-label">Nama Peserta ${index + 1}</label>
                        <div class="d-flex align-items-center">
                            <div class="">
                                <select name="nama_peserta_detail[]" id="nama_peserta_detail" class="form-control select2 approverSelectDetail" style="position: relative; z-index: 1050;">
                                    <option value="" disabled ${selectedValue ? '' : 'selected'}>Choose Your Approver</option>
                                        ${originalApproverOptionsDetail}
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4" style="pointer-events: none; opacity: 0.5;">
                        <label class="direktorat-label" for="direktorat_peserta_detail">Direktorat Peserta ${index + 1}</label>
                        <input type="text" name="direktorat_peserta_detail[]" id="direktorat_peserta_detail" class="form-control input-sm" value=""  disabled>
                    </div>

                    <div class="col-md-2" style="margin-top: 3.3%;">
                        <button type="button" class="btn btn-success btnAddDetail me-1">+</button>
                        <button type="button" class="btn btn-danger btnRemoveDetail">-</button>
                    </div>
                </div>`;

    }



    // Nampilin Modal Add, Jika Ditekan Button Add Data
    function ShowModalAdd() {
        $("#modalAdd").modal('show');
    }

    function enableAllElements() {
        // ROW 1
        $('#nama_pengusul_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#tanggal_pengajuan_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });

        // ROW 2
        $('#jabatan_pengusul_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#direktorat_pengusul_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });


        // ROW 3
        $('#gift_detail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
        $('#giftTextContainer_detail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });

        $('#entertainment_detail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
        $('#entertainmentTextContainer_detail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });

        $('#other_detail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
        $('#otherTextContainer_detail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'

        });

        // ROW 4
        $('#nama_penerima_detail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
        $('#perusahaan_penerima_detail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });

        // ROW 5
        $('#tanggal_diberikan_detail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
        $('#tempat_diberikan_detail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });

        // ROW 6
        $('#tujuan_pemberian_detail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
        $('#currency_detail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
        $('#estimasi_biaya_detail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
        $('#currenyDetail').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });

        // INFORMASI PESERTA & APPROVAL
        $('#uploadFileButton').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
        $('#editPesertaButton').prop('disabled', false).css({
            'opacity': '1'
        });
        $('#btnPrint').prop('disabled', true).css({
            'opacity': '0.5'
        });
        $('#btnSaveEdit').prop('disabled', false).css({
            'pointer-events': 'auto',
            'opacity': '1'
        });
    }

    function disableAllElements() {
        // ROW 1
        $('#nama_pengusul_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#tanggal_pengajuan_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });

        // ROW 2
        $('#jabatan_pengusul_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#direktorat_pengusul_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });

        // ROW 3
        $('#gift_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#giftTextContainer_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });

        $('#entertainment_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#entertainmentTextContainer_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });

        $('#other_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#otherTextContainer_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'

        });

        // ROW 4
        $('#nama_penerima_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#perusahaan_penerima_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });

        // ROW 5
        $('#tanggal_diberikan_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#tempat_diberikan_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });

        // ROW 6
        $('#tujuan_pemberian_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#currency_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#estimasi_biaya_detail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#currenyDetail').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });


        // INFORMASI PESERTA & APPROVAL
        $('#uploadFileButton').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });
        $('#editPesertaButton').prop('disabled', true).css({
            'opacity': '0.5'
        });
        $('#btnPrint').prop('disabled', false).css({
            'opacity': '1'
        });
        $('#btnSaveEdit').prop('disabled', true).css({
            'pointer-events': 'none',
            'opacity': '0.5'
        });

    }



    function ReloadTablePeserta() {
        let id = parseInt($('#id').val());

        $.ajax({
            type: "GET",
            url: "module/gift_a/getdetail.php?id=" + id,
            dataType: "JSON",
            success: function(data) {
                // Informasi Peserta
                $('#pesertaTable').DataTable().destroy();
                let listPeserta = $('#listPeserta');
                let rowTable2 = '';

                // Clear the table body before appending new rows
                listPeserta.empty();

                if (data.dataPeserta != null && data.dataPeserta.length > 0) {
                    data.dataPeserta.forEach(e => {
                        rowTable2 += '<tr>' +
                            '<td>' + (e.nama_peserta_perusahaan ?? '-') + '</td>' +
                            '<td>' + (e.direktorat_peserta_perusahaan ?? '-') + '</td>' +
                            '</tr>';
                    });
                } else {
                    rowTable2 = '<tr><td style="text-align: center" colspan="5">No Data</td></tr>';
                }
                listPeserta.append(rowTable2);
                tablePeserta = $('#pesertaTable').DataTable({
                    responsive: true,
                    processing: true,
                    paging: false,
                    searching: false,
                    lengthMenu: [
                        [-1],
                        ['All']
                    ],

                    drawCallback: function() {
                        $('#modalDetail .be-datatable-header').remove();
                    }
                });
            },
            error: function() {
                ShowErrorMessage("Error fetching approver data.");
            }
        });

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

        $("#nama_pengusul").val('').trigger("change");
        $("#tanggal_pengajuan").val('');
        $("#jabatan_pengusul").val('');
        $("#direktorat_pengusul").val('');

        $("input[name='jenisPemberian[]']").prop('checked', false).trigger('change');
        $("#giftText").val('');
        $("#entertainmentText").val('');
        $("#otherText").val('');

        $("#nama_penerima").val('');
        $("#perusahaan_penerima").val('');
        $("#tanggal_diberikan").val('');
        $("#tempat_diberikan").val('');

        $("#tujuan_pemberian").val('');
        $("#currency").val('').trigger("change");
        $("#estimasi_biaya").val('');
        $("#fileUpload").val('');

        $('.jenisapproverdiv').not(':first').remove();
        $('#approverContainer .jenisapproverdiv:first select[name="nama_peserta[]"]').val('').trigger('change');
    }
</script>