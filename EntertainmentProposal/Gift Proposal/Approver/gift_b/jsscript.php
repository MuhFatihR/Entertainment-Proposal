<script type="text/javascript">
    var save_method;
    var table;

    $(document).ready(function() {
        App.dataTables();
        document.title = "Approval Gift B | Portal Engineering | PT Nusantara Compnet Integrator";

        // FILTER
        $("#filter").submit(function(e) {
            e.preventDefault();
            generateTable();
        });

        // FILTER CLEAR
        $("#clear").click(function(e) {
            e.preventDefault();

            $("#no_pengajuan_filter").val('');
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
                "url": "module/gift_b/getdata.php",
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
            buttons: [{
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

        // $(document).on('click', '.uploadFileButton', function() {
        //     // Trigger the corresponding file input click
        //     // $(this).siblings('.fileInputDetail').click();
        //     let id_print_a = parseInt($('#id_item_a').val());
        //     // alert(id_print);
        //     // window.open('module/gift_b/printA.php?id=' + id_print_a, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes')
        //     window.location.href = 'module/gift_b/printA.php?id=' + id_print_a + '&download=true';

        // });

        $(document).on('click', '.uploadFileButton', function() {
            // Trigger the corresponding file input click
            // $(this).siblings('.fileInputDetail').click();
            let id_print_a = parseInt($('#id_item_a').val());
                    // alert(id_print);
            // window.open('module/gift_b/printA.php?id=' + id_print_a, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes')
            // window.location.href = 'module/gift_b/printA.php?id=' + id_print_a + '&download=true';
            window.open('module/gift_b/printA.php?id=' + id_print_a, '_blank', 'location=yes,scrollbars=yes,status=yes')

        });

        table.buttons().container().appendTo(
            $('.col-sm-6:eq(1)', table.table().container())
        );
        table.rows({
            page: 'all'
        }).data();
        $('.col-sm-6:eq(0)').addClass('xs-mb-20 sm-mb-0 md-mb-0 lg-mb-0');
        $('.col-sm-6:eq(1)').addClass('text-right');

        $('#approveNotesModal').on('hidden.bs.modal', function() {
            $('#modalDetail').css('overflow-y', 'auto');
        });
        $('#rejectNotesModal').on('hidden.bs.modal', function() {
            $('#modalDetail').css('overflow-y', 'auto');
        });
    });

    function modalShow(obj) {
        let id = parseInt(obj.attributes.id.value);
        $('#id_item').val(obj.attributes.id.value);
        $('#id_item_a').val(obj.attributes.id_a.value);
        $('#approver_id').val(obj.attributes.data_appid.value);

        // var app_id = parseInt($('#approver_id').val());
        // console.log('approver_id:', app_id);

        console.log(id);

        getModal(id);
    }

    function getModal(id) {
        $.ajax({
            type: "GET",
            url: "module/gift_b/getdetail.php?id=" + id,
            dataType: "JSON",
            searching: false,
            lengthMenu: [
                [-1],
                ['All']
            ],
            success: function(data) {

                // console.log(data.data.tanggal_pelaporan);
                $('#tanggal_palaporan_detail').val(data.data.tanggal_pelaporan);
                $('#nama_pelapor_detail').val(data.data.id_pelapor).trigger('change');
                $('#no_revisi_detail').val(data.data.id_pengajuan_a).trigger('change');
                $('#jabatan_pelapor_detail').val(data.data.jabatan_pelapor);
                $('#direktorat_pelapor_detail').val(data.data.direktorat_pelapor);

                $('#giftTextDetail').val(data.data.detail_pemberian_gift_b);
                $('#entertainmentTextDetail').val(data.data.detail_pemberian_entertainment_b);
                $('#otherTextDetail').val(data.data.detail_pemberian_other_b);

                // Validasi Untuk Jenis Pemberian Detail
                if (data.data.jenis_pemberian_b) {
                    var pemberianList = data.data.jenis_pemberian_b.split(',').map(item => item.trim());

                    $('#giftDetail, #entertainmentDetail, #otherDetail').prop('checked', false);
                    if (pemberianList.includes('Gift')) {
                        $('#giftDetail').prop('checked', true);
                    }
                    if (pemberianList.includes('Entertainment')) {
                        $('#entertainmentDetail').prop('checked', true);
                    }
                    if (pemberianList.includes('Other')) {
                        $('#otherDetail').prop('checked', true);
                    }
                    toggleFieldsDetail();
                }

                $('#nama_penerima_detail').val(data.data.nama_penerima_b);
                $('#perusahaan_penerima_detail').val(data.data.perusahaan_penerima_b);
                $('#tanggal_diberikan_detail').val(data.data.tanggal_diberikan_b);

                $('#tempat_diberikan_detail').val(data.data.tempat_diberikan_b);
                $('#tujuan_diberikan_detail').val(data.data.tujuan_diberikan_b);
                $('#estimasi_biaya_detail').val(data.data.estimasi_biaya_b);

                $('#alasan_detail').val(data.data.alasan_tidak_ada_dokumen_persetujuan);
                $('#currency_detail').val(data.data.id_currency).trigger('change');

                $('#btnApprove').on('click', function() {
                    $('#approveNotesModal').modal('show');
                });

                $('#btnReject').on('click', function() {
                    $('#rejectNotesModal').modal('show');
                });

                <?php
                // Generate the base URL dynamically in PHP
                $baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];  // Base URL
                ?>

                // Pass the generated PHP URL into JavaScript
                let baseUrl = "<?php echo $baseUrl; ?>"; // The base URL from PHP

                // Destroy DataTable if it exists
                if ($.fn.DataTable.isDataTable('#fileTableDokumen')) {
                    $('#fileTableDokumen').DataTable().destroy();
                }

                let listFile = $('#listFileDokumen');
                let rowTable = '';

                // Clear the table body before appending new rows
                listFile.empty();

                // Debugging: Log data to check if it exists
                console.log('Received data:', data.dataLampiran);

                try {
                    // Check if data and dataLampiran exist and file_name is not empty
                    // if (data.dataLampiran && data.dataLampiran.file_name !== null) {
                        // console.log('File found:', data.dataLampiran.file_name);

                        rowTable += '<tr>' +
                            '<td class="fileNameCell" style="width: 99.5%;">File Print A ' + data.dataForm.nomor_pengajuan + '</td>' +
                            '<td>' +
                            '<div style="display: flex; gap: 5%;">' +
                            // Tombol View
                            // '<a href="' + baseUrl + '/engineering/uploads/' + data.dataLampiran.file_name + '" ' +
                            // 'target="_blank" class="btn btn-info">' + '<i class="fas fa-eye"></i> View </a>' +

                            '<button type="button" class="btn btn-info uploadFileButton"> <i class="fas fa-eye"></i> View </button>' +

                            // Tombol Update
                            // '<button type="button" class="btn btn-success uploadFileButton"> <i class="fas fa-upload"></i> Update Current File </button>' +
                            // '<input type="file" class="fileInputDetail" name="fileInputDetail" style="display: none;">' +
                            '</div>' +
                            '</td>' +
                            '</tr>';
                    // } else if (data.dataLampiran && data.dataLampiran.file_name == null) {
                        // Debugging: Log if no file data is found
                        // console.warn('No file data available.');
                    //     rowTable = '<tr><td style="text-align: center" colspan="2">No Data</td></tr>';
                    // }

                    // // Check if data and dataLampiran exist and file_name is not empty
                    // if (data.dataLampiran && data.dataLampiran.file_name !== 'NULL') {
                    //     console.log('File found:', data.dataLampiran.file_name);

                    //     rowTable += '<tr>' +
                    //         '<td class="fileNameCell">' + data.dataLampiran.file_name + '</td>' +
                    //         '<td>' +
                    //         '<div style="display: flex; gap: 5%;">' +
                    //         // Tombol View
                    //         '<a href="' + baseUrl + '/engineering/uploads/' + data.dataLampiran.file_name + '" ' +
                    //         'target="_blank" class="btn btn-info">' + '<i class="fas fa-eye"></i> View </a>' +

                    //         // Tombol Update
                    //         '<button type="button" class="btn btn-success uploadFileButton"> <i class="fas fa-upload"></i> Update Current File </button>' +
                    //         '<input type="file" class="fileInputDetail" name="fileInputDetail" style="display: none;">' +
                    //         '</div>' +
                    //         '</td>' +
                    //         '</tr>';
                    // } else if {
                    //     // Debugging: Log if no file data is found
                    //     // console.warn('No file data available.');
                    //     rowTable = '<tr><td style="text-align: center" colspan="2">No Data</td></tr>';
                    // }

                    // Append rows to the table
                    listFile.append(rowTable);

                    // Reinitialize DataTable
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
                                return "<div class='text-wrap' style='width: 200px;'>" + data + "</div>";
                            }
                        }, {
                            targets: 1,
                            className: 'text-end',
                            render: function(data, type, row) {
                                return "<div class='text-wrap' style='width: 50px;'>" + data + "</div>";
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

                var id_approver = parseInt($('#approver_id').val());
                $('#approverTable').DataTable().destroy();

                let listApprover = $('#listApprover');
                let rowTable3 = '';

                // Clear the table body before appending new rows
                listApprover.empty();

                if (data.dataApprover != null && data.dataApprover.length > 0) {

                    let selectedApprover = data.dataApprover.find(e => e.id == id_approver);
                    let selectedApproverLevel = selectedApprover?.approver_level_b;

                    let hasLowerLevelWaiting = data.dataApprover.some(e =>
                        e.approver_level_b < selectedApproverLevel && (e.approval_status_b === 'Waiting Approval' || e
                            .approval_status_b === 'Rejected')
                    );

                    console.log("Data Approver:", data.dataApprover);
                    console.log("ID Approver:", id_approver);
                    console.log("Selected Approver:", selectedApprover);
                    console.log("Selected Approver Level:", selectedApproverLevel);
                    console.log("Has Lower Level Waiting:", hasLowerLevelWaiting);

                    if (hasLowerLevelWaiting) {
                        // Disable tombol jika ada approver dengan level lebih kecil dan status 'Waiting'
                        $('#btnReject').prop('disabled', true).removeClass('btn-danger').addClass('btn-disabled');
                        $('#btnApprove').prop('disabled', true).removeClass('btn-success').addClass('btn-disabled');
                    }

                    data.dataApprover.forEach(e => {
                        rowTable3 += '<tr>' +
                            '<td>' + (e.approver_name_b ?? '-') + '</td>' +
                            '<td>' + (e.approval_status_b ?? '-') + '</td>' +
                            '<td>' + (e.tanggal_approval_b == '0000-00-00' ? '-' : e.tanggal_approval_b) + '</td>' +
                            '<td>' + (e.approver_level_b ?? '-') + '</td>' +
                            '<td>' + (e.notes_b ?? '-') + '</td>' +
                            '</tr>';
                    });

                    // Setelah membangun tabel, atur tombol berdasarkan status approver yang dipilih
                    if (selectedApprover) {
                        if (selectedApprover.approval_status_b != 'Waiting Approval') {
                            $('#btnReject').prop('disabled', true).removeClass('btn-danger').addClass('btn-disabled');
                            $('#btnApprove').prop('disabled', true).removeClass('btn-success').addClass('btn-disabled');
                        } else if (selectedApprover.approval_status_b == 'Waiting Approval') {
                            // Hanya enable tombol jika tidak ada lower level waiting
                            if (!hasLowerLevelWaiting) {
                                $('#btnReject').prop('disabled', false).removeClass('btn-disabled').addClass('btn-danger');
                                $('#btnApprove').prop('disabled', false).removeClass('btn-disabled').addClass('btn-success');
                            }
                        }
                    }
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

                $("#modalDetail").modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var myText = errorThrown;
                ShowErrorMessage('Error!', myText);
            }
        });
    }

    $('#btnApproveFinal').on('click', function() {

        $(this).prop('disabled', true).text('Please wait...');

        var form = $('#reportApproveNotes')[0];
        var formData = new FormData(form);
        var id = parseInt($('#approver_id').val());
        console.log('approver_id:', id);
        let url = "module/gift_b/approvesubmission.php?id=" + id;

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(data) {
                if (data.status) {
                    ShowSuccessMessage('Success!', 'Data Berhasil Diperbarui!');
                    $('#approveNotesModal').modal('hide');
                    $('#modalDetail').modal('hide');
                } else {
                    ShowErrorMessage('Error!', data.message);
                    // swal.fire('Error: ' + data.message);
                }
                clearform();
                // $("#reportAdd").parsley().reset();

                ReloadTable();
                $('#btnApproveFinal').prop('disabled', false).text('Approve Document');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var myText = errorThrown;
                ShowErrorMessage('Error!', myText);
                $('#btnSave').text('Submit');
                $('#btnSave').prop('disabled', false);
            }
        });
    });

    $('#btnRejectFinal').on('click', function() {

        $(this).prop('disabled', true).text('Please wait...');

        var form = $('#reportRejectNotes')[0];
        var formData = new FormData(form);
        var id = parseInt($('#approver_id').val());
        console.log('approver_id:', id);
        let url = "module/gift_b/rejectsubmission.php?id=" + id;

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(data) {
                if (data.status) {
                    ShowSuccessMessage('Success!', 'Data Berhasil Diperbarui!');
                    $('#rejectNotesModal').modal('hide');
                    $('#modalDetail').modal('hide');
                } else {
                    ShowErrorMessage('Error!', data.message);
                    // swal.fire('Error: ' + data.message);
                }
                clearform();
                // $("#reportAdd").parsley().reset();

                ReloadTable();
                $('#btnRejectFinal').prop('disabled', false).text('Reject Document');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var myText = errorThrown;
                ShowErrorMessage('Error!', myText);
                $('#btnSave').text('Submit');
                $('#btnSave').prop('disabled', false);
            }
        });
    });

    function toggleFieldsDetail() {
        if ($('#giftDetail').is(':checked')) {
            $('#giftTextDetailContainer').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        } else {
            $('#giftTextDetailContainer').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
        }

        // Periksa status #entertainment
        if ($('#entertainmentDetail').is(':checked')) {
            $('#entertainmentTextDetailContainer').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        } else {
            $('#entertainmentTextDetailContainer').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
        }

        // Periksa status #other
        if ($('#otherDetail').is(':checked')) {
            $('#otherTextDetailContainer').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        } else {
            $('#otherTextDetailContainer').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
        }

    }

    function clearform() {
        $("#approveNotes").val('');
        $("#rejectNotes").val('');
    }

    function ReloadTable() {
        table.ajax.reload(null, false);
    }

    function generateTable() {
        table.ajax.reload();
    }

</script>