<script type="text/javascript">
    var save_method;
    var table;

    $(document).ready(function() {
        App.dataTables();
        document.title = "Parcel | Portal Engineering | PT Nusantara Compnet Integrator";

        // FILTER
        $("#filter").submit(function(e) {
            e.preventDefault();
            generateTable();
        });

        // FILTER CLEAR
        $("#clear").click(function(e) {
            e.preventDefault();

            $("#no_pengajuan_filter").val('');
            $("#nama_pengusul_filter").val('');
            $("#direktorat_pengusul_filter").val('');
            $("#nama_penerima_filter").val('');
            $("#perusahaan_penerima_filter").val('');
            $("#jenis_pemberian_filter").val('')
            $("#tanggal_pengajuan_filter").val('')
            $("#tanggal_diberikan_filter").val('');
            $("#status_pengajuan_filter").val('');

            generateTable();
        });


        // Datatable (getdataapproval.php)
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
                "url": "module/gift_a/getdataapproval.php",
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
                        return "Gift-A Report-" + n;
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
                        return "Gift-A Report-" + n;
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
                        return "Gift-A Report-" + n;
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
                        return "Gift-A Report-" + n;
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


        // Nampilin Data pada Detail (getdetailapproval.php)
        $('#GiftTable').on('click', '.showDetail', function() {
            var id = $(this).data('id');
            var idApprover = $(this).data('idapprover');
            $('#modalDetail').modal('show');

            $.ajax({
                url: "module/gift_a/getdetailapproval.php?id=" + id,
                type: "GET",
                dataType: "JSON",
                data: {
                    idApprover: idApprover // Masukkan idApprover ke data
                },
                success: function(data) {
                    $('[name="id_approver"]').val(idApprover);


                    document.getElementById("nomor_pengajuan_detail").textContent = data.data[0].nomor_pengajuan;
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

                    // Validasi Checkbox Jenis Pemberian
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

                    // ModalShow
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
                        if (data.dataLampiran && data.dataLampiran.file_name !== null) {
                            // console.log('File found:', data.dataLampiran.file_name);

                            rowTable += '<tr>' +
                                            '<td class="fileNameCell">' + data.dataLampiran.file_name + '</td>' +
                                                '<td style="width: 10%">' +
                                                    '<div style="">' +
                                                        // Tombol View
                                                        '<a href="' + baseUrl + '/portalform/fileGift/' + data.dataLampiran.file_name + '" ' +
                                                        'target="_blank" class="btn btn-info">' + '<i class="fas fa-eye"></i> View </a>' +

                                                        // Tombol Update
                                                        // '<button type="button" class="btn btn-success uploadFileButton"> <i class="fas fa-upload"></i> Update Current File </button>' +
                                                        // '<input type="file" class="fileInputDetail" name="fileInputDetail" style="display: none;">' +
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

                    // Informasi Peserta
                    $('#pesertaTable').DataTable().destroy();
                    let listPeserta = $('#listPeserta');
                    let rowTable2 = '';
                    listPeserta.empty(); // Clear the table body before appending new rows
                    let jumlahPeserta = data.data;

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
                    var id_approver = $('[name="id_approver"]').val();

                    // Validasi Button Accept & Reject based on status_pengajuan user
                    if (data.dataApprover != null && data.dataApprover.length > 0) {
                        let selectedApprover = data.dataApprover.find(e => e.id === id_approver); // Cari approver yang sedang login
                        let selectedApproverLevel = selectedApprover?.approver_level;

                        // Cek apakah ada approver dengan level lebih kecil dan status 'Waiting'
                        let hasLowerLevelWaiting = data.dataApprover.some(e =>
                            e.approver_level < selectedApproverLevel && (e.approval_status === 'Waiting Approval' || e.approval_status === 'Rejected')
                        );


                        console.log("Data Approver:", data.dataApprover);
                        console.log("ID Approver:", id_approver);
                        console.log("Selected Approver:", selectedApprover);
                        console.log("Selected Approver Level:", selectedApproverLevel);
                        console.log("Has Lower Level Waiting:", hasLowerLevelWaiting);

                        if (hasLowerLevelWaiting) { // Jika ada matikan semua button approve & reject
                            $('#btnReject').prop('disabled', true).removeClass('btn-danger').addClass('btn-disabled');
                            $('#btnApprove').prop('disabled', true).removeClass('btn-success').addClass('btn-disabled');
                        }

                        data.dataApprover.forEach(e => {
                            rowTable3 += '<tr>' +
                                '<td>' + (e.approver_name ?? '-') + '</td>' +
                                '<td>' + (e.approval_status ?? '-') + '</td>' +
                                '<td>' + (e.tanggal_approval == '0000-00-00' ? '-' : e.tanggal_approval) + '</td>' +
                                '<td>' + (e.approver_level ?? '-') + '</td>' +
                                '<td>' + (e.notes ?? '-') + '</td>' +
                                '</tr>';
                        });

                        if (selectedApprover) {
                            if (selectedApprover.approval_status != 'Waiting Approval') {
                                $('#btnReject').prop('disabled', true).removeClass('btn-danger').addClass('btn-disabled');
                                $('#btnApprove').prop('disabled', true).removeClass('btn-success').addClass('btn-disabled');
                            } else if (selectedApprover.approval_status == 'Waiting Approval') {
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
        });

        // Button Approve (approvesubmisson.php)
        $('#btnApproveFinal').on('click', function() {
            $(this).prop('disabled', true).text('Please wait...');

            var formData = new FormData($('#reportApproveNotes')[0]);

            var id = parseInt($('#id_approver').val());
            console.log('id approver:', id);

            $.ajax({
                url: "module/gift_a/approvesubmission.php?id=" + id,
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
                    }
                    clearform();
                    ReloadTable();

                    $('#btnApproveFinal').prop('disabled', false).text('Approve Document');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var myText = errorThrown;
                    ShowErrorMessage('Error!', myText);
                    $('#btnSave').text('Submit').prop('disabled', false);
                }
            });
        });

        // Button Reject (rejectsubmisson.php)
        $('#btnRejectFinal').on('click', function() {
            $(this).prop('disabled', true).text('Please wait...');

            var formData = new FormData($('#reportRejectNotes')[0]);

            var id = parseInt($('#id_approver').val());
            console.log('id_approver:', id);

            $.ajax({
                url: "module/gift_a/rejectsubmission.php?id=" + id,
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
                    }
                    clearform();
                    ReloadTable();

                    $('#btnRejectFinal').prop('disabled', false).text('Reject Document');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var myText = errorThrown;
                    ShowErrorMessage('Error!', myText);
                    $('#btnSave').text('Submit').prop('disabled', false);
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

    });

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