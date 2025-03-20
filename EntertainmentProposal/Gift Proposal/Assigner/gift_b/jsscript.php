<script type="text/javascript">
    var save_method;
    var table;
    var originalApproverOptions = $('.approverSelect').first().html();
    var originalApproverOptionsDetail = null;
    var originalApproverOptionsDetail2 = null;

    $(document).ready(function() {
        App.dataTables();
        document.title = "Gift B | Portal Engineering | PT Nusantara Compnet Integrator";

        originalApproverOptionsDetail = $('#approverContainerDetail .approverSelectDetail').html();
        originalApproverOptionsDetail2 = $('#approverContainerDetail2 .approverSelectDetail2').html();

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
            newField.find('.approver-label').text('Nama Peserta ' + approverCount);

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


        // Event handler untuk autofill saat memilih no_revisi (modalAdd)
        $('#no_revisi').on('change', function() {
            let selectedValue = $(this).val(); // Ambil nilai yang dipilih
            console.log('no_revisi', selectedValue);

            if (selectedValue) {
                $.ajax({
                    url: "module/gift_b/getdataformA.php", // Ganti dengan endpoint PHP Anda
                    type: 'POST',
                    data: {
                        no_revisi: selectedValue
                    },
                    dataType: "json",
                    success: function(response) {

                        $('#giftText').val(response.data.jenis_pemberian_gift);
                        $('#entertainmentText').val(response.data.jenis_pemberian_entertainment);
                        $('#otherText').val(response.data.jenis_pemberian_other);

                        $('#giftText').css({
                            'pointer-events': 'none'
                        });
                        $('#entertainmentTextDetail').css({
                            'pointer-events': 'none'
                        });
                        $('#otherTextDetail').css({
                            'pointer-events': 'none'
                        });

                        // Validasi Untuk Jenis Pemberian Detail
                        if (response.data.jenis_pemberian) {
                            var pemberianList = response.data.jenis_pemberian.split(',').map(item => item.trim());

                            $('#gift, #entertainment, #other').prop('checked', false);
                            if (pemberianList.includes('Gift')) {
                                $('#gift').prop('checked', true);
                            }
                            if (pemberianList.includes('Entertainment')) {
                                $('#entertainment').prop('checked', true);
                            }
                            if (pemberianList.includes('Other')) {
                                $('#other').prop('checked', true);
                            }
                            toggleFields();
                        }

                        $('#nama_penerima').val(response.data.nama_penerima);
                        $('#perusahaan_penerima').val(response.data.perusahaan_penerima);
                        $('#estimasi_biaya').val(response.data.estimasi_biaya);
                        $('#currencyAdd').val(response.data.idCurrency).trigger('change');

                        $('#tanggal_diberikan').val(response.data.tanggal_diberikan);
                        $('#tempat_diberikan').val(response.data.tempat_diberikan);
                        $('#tujuan_diberikan').val(response.data.tujuan_pemberian);


                        $('#approverContainerDetail2').empty();
                        $('#jenisapproverdivDetail2').empty();

                        let idPeserta = response.dataPeserta[0].id_employee;
                        let jumlahPeserta = response.dataPeserta;


                        if (idPeserta && jumlahPeserta.length > 0) {
                            for (let index = 0; index < jumlahPeserta.length; index++) {
                                let approver = jumlahPeserta[index];
                                if (approver.id_employee) {
                                    let approverDiv = `
                                                    <div class="jenisapproverdivDetail2" id="jenisapproverdivDetail2_${index}" style="pointer-events: none; opacity: 0.5;">
                                                        <div class="col-md-6">
                                                            <label class="approver-label2">Nama Peserta ${index + 1}</label>
                                                            <div class="d-flex align-items-center">
                                                                <div class="">
                                                                    <select name="nama_peserta_detail2[]" id="nama_peserta_detail2" class="form-control select2 approverSelectDetail2" style="position: relative; z-index: 1050;">
                                                                        <option value="" disabled ${approver.id_employee ? '' : 'selected'}>Choose Your Approver</option>
                                                                        ${response.listemployee.map(employee => `
                                                                            <option value="${employee.id}" data_email="${employee.email}" data_title="${employee.directorate}" data_fullName="${employee.full_name}" 
                                                                            ${employee.id == approver.id_employee ? 'selected' : ''}>
                                                                            ${employee.full_name}
                                                                            </option>
                                                                        `).join('')}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4" id="direktoratHidden2" style="pointer-events: none; opacity: 0.5;">
                                                            <label class="direktorat-label2" for="direktorat_peserta_detail2">Direktorat Peserta ${index + 1}</label>
                                                            <input type="text" name="direktorat_peserta_detail2[]" class="form-control input-sm" value="${approver.direktorat_peserta_perusahaan || ''}" placeholder="Direktorat Tidak Tersedia" disabled>
                                                        </div>

                                                        <div class="col-md-2" style="margin-top: 3.3%;">
                                                            <button type="button" class="btn btn-success btnAddDetail2 me-1">+</button>
                                                            <button type="button" class="btn btn-danger btnRemoveDetail2">-</button>
                                                        </div>
                                                    </div>`;

                                    $('#approverContainerDetail2').append(approverDiv);
                                } else {
                                    console.error('Approver id_employee is missing for index: ' + index);
                                }
                            }

                            // Inisialisasi ulang Select2
                            // $('.select2').select2();

                        } else {
                            console.error('No valid data available for approvers.');
                        }

                        // Panggil fungsi untuk menambahkan event handler
                        attachApproverDetailEventHandlers2();

                        $('#approverContainerDetail2').on('change', '.approverSelectDetail2', function() {
                            let direktoratePeserta = $(this).find('option:selected').attr('data_title');
                            console.log(direktoratePeserta);
                            $(this).closest('.jenisapproverdivDetail2').find('[name="direktorat_peserta_detail2[]"]').val(direktoratePeserta).trigger('change');
                        });

                        currentListEmployee = response.listemployee;
                        originalApproverOptionsDetail2 = generateApproverOptions2(currentListEmployee);
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan:', error);
                    }
                });
            } else {
                console.log('Tidak ada nilai yang dipilih.');
            }
        });

        // Menyimpan Data (adddata.php)
        $('#btnSave').click(function(e) {
            e.preventDefault();
            var formData = new FormData($('#reportAdd')[0]);

            $(this).prop('disabled', true);
            $(this).text('Saving...');

            var selectedDirectorateDetails = $('input[name="direktorat_peserta_detail2[]"]').map(function() {
                return $(this).val(); // Ambil nilai setiap input
            }).get(); // Konversi hasil menjadi array

            console.log('selectedDirectorateDetails:', selectedDirectorateDetails);

            selectedDirectorateDetails.forEach(function(value) {
                formData.append('direktorat_peserta_detail2[]', value);
            });


            var namaPelapor = $('#nama_pelapor').val();
            // Jika tidak ada nilai yang dipilih, tampilkan pesan error
            if (!namaPelapor) {
                ShowErrorMessage('Error!', 'Nama Pelapor Wajib Dipilih!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            var no_revisi = $('#no_revisi').val();
            // Jika tidak ada nilai yang dipilih, tampilkan pesan error
            if (!no_revisi) {
                ShowErrorMessage('Error!', 'Nomor Pengajuan Wajib Dipilih!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            var jabatan_pelapor = $('#jabatan_pelapor').val();
            // Jika tidak ada nilai yang dipilih, tampilkan pesan error
            if (!jabatan_pelapor) {
                ShowErrorMessage('Error!', 'Nomor Pengajuan Wajib Dipilih!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            var direktorat_pelapor = $('#direktorat_pelapor').val();
            // Jika tidak ada nilai yang dipilih, tampilkan pesan error
            if (!direktorat_pelapor) {
                ShowErrorMessage('Error!', 'Nomor Pengajuan Wajib Dipilih!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            var jenisPemberian = $('input[name="jenisPemberian[]"]');
            if (jenisPemberian.filter(':checked').length == 0) {
                ShowErrorMessage('Error!', 'Jenis Pemberian Minimal Dipilih Satu!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            var gift = $('#gift');
            var giftText = $('#giftText');
            if (gift.is(':checked') && giftText.val().trim() == '') {
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

            // var persetujuan_decision_ada = $('#ada1');
            // var persetujuan_decision_tidak = $('#tidak1');
            // var fileUpload = $('input[name="file"]').val();
            // var alasan = $('#alasan');
            // if (persetujuan_decision_ada.is(':checked') && !fileUpload) {
            //     ShowErrorMessage('Error!', 'File Persetujuan Sebelumnya Harus Diisi Jika Pilih Ada!');
            //     $('#btnSave').text('Save');
            //     $('#btnSave').prop('disabled', false);
            //     return false;
            // }
            // if (persetujuan_decision_tidak.is(':checked') && alasan.val().trim() === '') {
            //     ShowErrorMessage('Error!', 'Kolom Alasan Harus Diisi Jika Pilih Tidak!');
            //     $('#btnSave').text('Save');
            //     $('#btnSave').prop('disabled', false);
            //     return false;
            // }

            // var inputFile = $('input[name="file"]')[0];
            // if (inputFile.files && inputFile.files.length > 0) {
            //     var fileSize = inputFile.files[0].size;
            //     if (fileSize > 15 * 1024 * 1024) {
            //         ShowErrorMessage('Warning!', 'Ukuran file maksimal 15MB!');
            //         $('#btnSave').text('Save');
            //         $('#btnSave').prop('disabled', false);
            //         return false;
            //     }
            // }

            var penerima_decision_sama = $('#sama2');
            var penerima_decision_tidak = $('#tidak2');
            var nama_penerima = $('#nama_penerima');
            var perusahaan_penerima = $('#perusahaan_penerima');
            if (penerima_decision_tidak.is(':checked') && nama_penerima.val().trim() === '' && perusahaan_penerima.val().trim() === '') {
                ShowErrorMessage('Error!', 'Detail Penerima Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            var estimasi_decision_tidak = $('#tidak6');
            var currencyAdd = $('input[name="currencyAdd"]').val();
            var estimasi_biaya = $('#estimasi_biaya');
            if (estimasi_decision_tidak.is(':checked') && !currencyAdd && estimasi_biaya.val().trim() === '') {
                ShowErrorMessage('Error!', 'Detail Biaya Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            var tanggal_decision_tidak = $('#tidak3');
            var tanggal_diberikan = $('input[name="tanggal_diberikan"]').val();
            if (tanggal_decision_tidak.is(':checked') && !tanggal_diberikan) {
                ShowErrorMessage('Error!', 'Tanggal Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            var tempat_decision_tidak = $('#tidak4');
            var tempat_diberikan = $('#tempat_diberikan');
            // var tempat_diberikan = $('input[name="tempat_diberikan"]').val();
            if (tempat_decision_tidak.is(':checked') && tempat_diberikan.val().trim() === '') {
                ShowErrorMessage('Error!', 'Tanggal Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            var tujuan_decisionn_tidak = $('#tidak5');
            var tujuan_diberikan = $('#tujuan_diberikan');
            if (tujuan_decisionn_tidak.is(':checked') && tujuan_diberikan.val().trim() === '') {
                ShowErrorMessage('Error!', 'Tanggal Harus Diisi!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            // // Peserta
            // var peserta_decision_tidak = $('#tidak');
            // var nama_peserta = $('select[name="nama_peserta[]"]').val();
            // if (peserta_decision_tidak.is(':checked') && nama_peserta == null) {
            //     ShowErrorMessage('Error!', 'Peserta Harus Dipilih!');
            //     $('#btnSave').text('Save');
            //     $('#btnSave').prop('disabled', false);
            //     return false;
            // }

            var peserta_decision_tidak = $('#tidak'); // Checkbox for "tidak"
            var isValid = true;

            // Loop through all select elements with name="nama_peserta[]"
            $('select[name="nama_peserta_detail2[]"]').each(function() {
                if ($(this).val() == null || $(this).val().trim() === '') {
                    isValid = false;
                    return false; // Break loop if an empty value is found
                }
            });

            // Validate: If "tidak" checkbox is checked and no valid peserta is selected
            if (peserta_decision_tidak.is(':checked') && !isValid) {
                ShowErrorMessage('Error!', 'Peserta Harus Dipilih!');
                $('#btnSave').text('Save');
                $('#btnSave').prop('disabled', false);
                return false;
            }

            default_user_id = $('#default_user_id').val();
            formData.append('default_user_id', default_user_id);

            $.ajax({
                url: "module/gift_b/adddata.php",
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
                        location.reload();
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

        $('#editPesertaButton').on('click', function() {
            $('#modalPeserta').modal('show');
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


        table.buttons().container().appendTo(
            $('.col-sm-6:eq(1)', table.table().container())
        );
        table.rows({
            page: 'all'
        }).data();
        $('.col-sm-6:eq(0)').addClass('xs-mb-20 sm-mb-0 md-mb-0 lg-mb-0');
        $('.col-sm-6:eq(1)').addClass('text-right');


        // Autofill Jabatan (Modal Add)
        $('#nama_pelapor').on('change', function() {
            let titlePelapor = $('#nama_pelapor option:selected').attr('data-title');
            $('#jabatan_pelapor').val(titlePelapor).trigger('change');

            let departmentPelapor = $('#nama_pelapor option:selected').attr('data-directorate');
            $('#direktorat_pelapor').val(departmentPelapor).trigger('change');
        });

        // // Autofill Jabatan (Modal Add)
        $('#nama_peserta_detail2').on('change', function() {
            let titlePelapor = $('#nama_peserta_detail2 option:selected').attr('data-title');
            $('#direktorat_peserta_detail2').val(titlePelapor).trigger('change');
        });


        // Trigger Validasi JenisPemberian 
        $('input[name="jenisPemberian[]"]').change(function() {
            toggleFields();
        });

        // Trigger Validasi Persetujuan 
        $('input[name="persetujuan_decision"]').change(function() {
            toggleFields1();
        });

        // Trigger Validasi DetailPenerima 
        $('input[name="penerima_decision"]').change(function() {
            toggleFields2();
        });

        // Trigger Validasi TanggalDiberikan 
        $('input[name="tanggal_decision"]').change(function() {
            toggleFields3();
        });
        // Trigger Validasi TempatDiberikan 
        $('input[name="tempat_decision"]').change(function() {
            toggleFields4();
        });

        // Trigger Validasi TujuanDiberikan 
        $('input[name="tujuan_decision"]').change(function() {
            toggleFields5();
        });

        // Trigger Validasi EstimasiBiaya 
        $('input[name="estimasi_decision"]').change(function() {
            toggleFields6();
        });

        // Trigger Validasi Peserta
        $('input[name="peserta_decision"]').change(function() {
            toggleFields7();
        });


        // $(document).on('click', '#uploadFileButton', function() {
        //     // Trigger the corresponding file input click
        //     // $(this).siblings('.fileInputDetail').click();
        //     let id_print_a = parseInt($('#id_item_a').val());
        //     // alert(id_print);
        //     window.location.href = 'module/gift_b/printA.php?id=' + id_print_a + '&download=true';
        // });

        // ini buat dompdf
        // $('#uploadFileButton').on('click', function() {
        //     let id_print_a = parseInt($('#id_item_a').val());
        //     // alert(id_print);
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

        // $(document).on('change', '.fileInputDetail', function() {
        //     var file = $(this).prop('files')[0];
        //     if (file) { // Ensure a file was selected
        //         var newFileName = file.name; // Get the name of the selected file
        //         // Update the file name in the same row
        //         $(this).closest('tr').find('.fileNameCell').text(newFileName);
        //     }
        // });


        // Autofill Jabatan, Direktorat & Tanggal (Modal Add) 
        $('#modalAdd').on('shown.bs.modal', function() {
            const defaultUserId = $('#default_user_id').val();
            if (defaultUserId) {
                $('#nama_pelapor').val(defaultUserId).trigger('change'); // Trigger change for select2 UI
            }

            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0]; // Format ke yyyy-mm-dd

            $('#tanggal_palaporan').val(formattedDate);
        });


        $('#nama_peserta').on('change', function() {
            let direktoratePeserta = $('#nama_peserta option:selected').attr('data-title');
            $('#direktorat_peserta').val(direktoratePeserta).trigger('change');
        });

        $('input[name="jenisPemberianDetail[]"]').change(function() {
            toggleFieldsDetail();
        });

        $('#modalDetail').on('hidden.bs.modal', function() {
            $('#fileTableDokumen').DataTable().destroy(); // Hapus DataTable
            $('#pesertaTable').DataTable().destroy();
            $('#approverTable').DataTable().destroy();
        });

        $('#btnSaveEdit').click(function(e) {
            e.preventDefault();
            var formData = new FormData($('#reportDetail')[0]);
            var id = parseInt($('#id_item').val());

            $(this).prop('disabled', true);
            $(this).text('Saving...');

            // ROW 1
            var nama_pengusul_detail = $('select[name="nama_pelapor_detail"]').val();
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
            var jenisPemberian = $('input[name="jenisPemberianDetail[]"]');
            if (jenisPemberian.filter(':checked').length == 0) {
                ShowErrorMessage('Error!', 'Jenis Pemberian Minimal Dipilih Satu!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }

            var gift_detail = $('#giftDetail');
            var giftText_detail = $('#giftTextDetail');
            if (gift_detail.is(':checked') && giftText_detail.val().trim() === '') {
                ShowErrorMessage('Error!', 'Jenis Pemberian Gift Wajib Diisi Jika DiPilih!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }
            var entertainment_detail = $('#entertainmentDetail');
            var entertainmentText_detail = $('#entertainmentTextDetail');
            if (entertainment_detail.is(':checked') && entertainmentText_detail.val().trim() === '') {
                ShowErrorMessage('Error!', 'Jenis Pemberian Entertainment Wajib Diisi Jika DiPilih!');
                $('#btnSaveEdit').text('Save');
                $('#btnSaveEdit').prop('disabled', false);
                return false;
            }
            var other_detail = $('#otherDetail');
            var otherText_detail = $('#otherTextDetail');
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
            var tujuan_pemberian_detail = $('#tujuan_diberikan_detail').val();
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

            // ON KALO UDA BISA SISTEM FILENYA

            // var inputFile = $('input[name="fileInputDetail"]')[0];
            // if (inputFile.files && inputFile.files.length > 0) {
            //     var fileSize = inputFile.files[0].size;
            //     if (fileSize > 15 * 1024 * 1024) {
            //         ShowErrorMessage('Warning!', 'Ukuran file maksimal 15MB!');
            //         $('#btnSaveEdit').text('Save');
            //         $('#btnSaveEdit').prop('disabled', false);
            //         return false;
            //     }
            // }

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
                url: "module/gift_b/editdata.php?id=" + id,
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
                        $('#btnSaveEdit').prop('disabled', false);
                        $('#btnSaveEdit').text('Save');
                    } else {
                        var myText = data.msg;
                        ShowWarningMessage('Warning!', myText);
                        $('#btnSaveEdit').prop('disabled', false);
                        $('#btnSaveEdit').text('Save');
                    }
                    // clearform();
                    // $(this).prop('disabled', false);
                    // $(this).text('Submit');
                    // $('#btnSaveEdit').prop('disabled', false);
                    // $('#btnSaveEdit').text('Save');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var myText = errorThrown;
                    ShowErrorMessage('Error!', myText);
                    $('#btnSaveEdit').prop('disabled', false);
                    $('#btnSaveEdit').text('Save');
                }
            });
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
            } else {
                ShowErrorMessage('Error!', 'Minimal satu peserta harus ada!');
            }
        });

        // Menyimpan Data (editdatapeserta.php)
        $('#btnSavePeserta').click(function(e) {
            e.preventDefault();
            var formData = new FormData($('#reportEditPeserta')[0]);

            var id_peserta = parseInt($('#id_peserta').val());
            var id = parseInt($('#id_item').val());

            console.log('id_peserta:', id_peserta);

            $(this).prop('disabled', true);
            $(this).text('Saving...');

            var selectedOption = $('select[name="nama_penerima"] option:selected');
            var dataType = selectedOption.data('type');

            var selectedDirectorateDetails = $('input[name="direktorat_peserta_detail[]"]').map(function() {
                return $(this).val(); // Ambil nilai setiap input
            }).get(); // Konversi hasil menjadi array

            console.log('selectedDirectorateDetails:', selectedDirectorateDetails);

            selectedDirectorateDetails.forEach(function(value) {
                formData.append('direktorat_peserta_detail[]', value);
            });

            $.ajax({
                url: "module/gift_b/editdatapeserta.php?id=" + id,
                type: "POST",
                data: formData,
                dataType: "json", // Ensure the server returns valid JSON
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                success: function(data) {
                    if (data) {
                        $('#modalPeserta').modal('hide');
                        ShowSuccessMessage('Success!', 'Data Berhasil DiUpdate!');
                        // ReloadTable();
                        $('#modalDetail').css('overflow-y', 'auto');
                        $('#modalDetail').css('overflow-y', 'auto');

                    } else {
                        var myText = data.msg;
                        ShowWarningMessage('Warning!', myText);
                    }
                    $('#btnSavePeserta').text('Save Changes');
                    $('#btnSavePeserta').prop('disabled', false);
                    // clearform();
                    ReloadTablePeserta();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var myText = errorThrown;
                    ShowErrorMessage('Error!', myText);
                    $('#btnSavePeserta').text('Save Changes');
                    $('#btnSavePeserta').prop('disabled', false);
                }
            });
        });

        // Clear data form ModalAdd when hidden
        $('#modalAdd').on('hidden.bs.modal', function() {
            $("#nama_pelapor").val('').trigger("change");
            $("#tanggal_palaporan").val('');
            $("#jabatan_pelapor").val('');
            $("#direktorat_pelapor").val('');

            $("#no_revisi").val('').trigger("change");

            $("input[name='jenisPemberian[]']").prop('checked', false).trigger('change');
            $("#giftText").val('');
            $("#entertainmentText").val('');
            $("#otherText").val('');

            $("input[name='penerima_decision']").prop('checked', false).first().prop('checked', true).trigger('change');
            $("#nama_penerima").val('');
            $("#perusahaan_penerima").val('');

            $("input[name='estimasi_decision']").prop('checked', false).first().prop('checked', true).trigger('change');
            $("#currencyAdd").val('').trigger("change");
            $("#estimasi_biaya").val('');

            $("input[name='tanggal_decision']").prop('checked', false).first().prop('checked', true).trigger('change');
            $("#tanggal_diberikan").val('');

            $("input[name='tempat_decision']").prop('checked', false).first().prop('checked', true).trigger('change');
            $("#tempat_diberikan").val('');

            $("input[name='tujuan_decision']").prop('checked', false).first().prop('checked', true).trigger('change');
            $("#tujuan_diberikan").val('');

            $("input[name='peserta_decision']").prop('checked', false).first().prop('checked', true).trigger('change');
            $('.jenisapproverdivDetail2').not(':first').remove();
            $('#approverContainerDetail2 .jenisapproverdivDetail2:first select[name="nama_peserta_detail2[]"]').val('').trigger('change');
            $("#direktorat_peserta_detail2[]").val('');


            $("#btnSave").prop("disabled", false);
        });


        initializeSelect2Detail2($('.approverSelectDetail2'));

        // MODAL ADD - PESERTA
        $(document).on('click', '.btnAddDetail2', function() {
            var approverCount = $('.jenisapproverdivDetail2').length;
            var newApproverField = createApproverField2(approverCount, null);
            $('#approverContainerDetail2').append(newApproverField); // Tambahkan ke container

            // Initialize Select2 and event handlers for the new field
            initializeSelect2Detail2($('.approverSelectDetail2').last());
            updateApproverLabelsDetail2();
            filterApproverOptionsDetail2();
        });

        $(document).on('click', '.btnRemoveDetail2', function() {
            if ($('.jenisapproverdivDetail2').length > 1) { // Jangan hapus jika hanya ada satu baris
                $(this).closest('.jenisapproverdivDetail2').remove();
            } else {
                ShowErrorMessage('Error!', 'Minimal satu peserta harus ada!');
            }
        });

    });

    function attachApproverDetailEventHandlers2() {
        initializeSelect2Detail2($('.approverSelectDetail2'));

        updateApproverLabelsDetail2();
        filterApproverOptionsDetail2();
    }

    function initializeSelect2Detail2(element) {
        element.each(function () {
        if (!$(this).hasClass('select2-hidden-accessible')) {
            $(this).select2({
                placeholder: "Choose Your Approver",
                allowClear: true,
                width: '100%',
                dropdownParent: $(this).parent(),
            });
        }
    });
    }

    function updateApproverLabelsDetail2() {
        $('.jenisapproverdivDetail2').each(function(index) {
            $(this).find('.approver-label2').text('Nama Peserta ' + (index + 1));
        });
    }

    function filterApproverOptionsDetail2() {
        var selectedValues = [];
        $('.approverSelectDetail2').each(function() {
            var value = $(this).val();
            if (value !== "") {
                selectedValues.push(value);
            }
        });

        $('.approverSelectDetail2').each(function() {
            var $dropdown = $(this);
            var currentValue = $dropdown.val();

            // Reset options to the original unfiltered options
            $dropdown.html('<option value="" disabled>Choose Your Approver</option>' +
                originalApproverOptionsDetail2);

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

    function createApproverField2(index, selectedValue) {
        return `<div class="jenisapproverdivDetail2" id="jenisapproverdivDetail2">
                    <div class="col-md-6">
                        <label class="approver-label2">Nama Peserta ${index + 1}</label>
                        <div class="d-flex align-items-center">
                            <div class="">
                                <select name="nama_peserta_detail2[]" id="nama_peserta_detail2" class="form-control select2 approverSelectDetail2" style="position: relative; z-index: 1050;">
                                    <option value="" disabled ${selectedValue ? '' : 'selected'}>Choose Your Approver</option>
                                        ${originalApproverOptionsDetail2}
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4" id="direktoratHidden2" style="pointer-events: none; opacity: 0.5;">
                        <label class="direktorat-label2" for="direktorat_peserta_detail2">Direktorat Peserta ${index + 1}</label>
                        <input type="text" name="direktorat_peserta_detail2[]" id="direktorat_peserta_detail2" class="form-control input-sm" value=""  disabled>
                    </div>

                    <div class="col-md-2" style="margin-top: 3.3%;">
                        <button type="button" class="btn btn-success btnAddDetail2 me-1">+</button>
                        <button type="button" class="btn btn-danger btnRemoveDetail2">-</button>
                    </div>
                </div>`;

    }

    function generateApproverOptions2(employeeList) {
        return employeeList.map(employee => `
            <option value="${employee.id}" data_email="${employee.email}" data_title="${employee.directorate}" data_fullName="${employee.full_name}">
                ${employee.full_name}
            </option>
        `).join('');
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

    function attachApproverDetailEventHandlers() {
        initializeSelect2Detail($('.approverSelectDetail'));

        updateApproverLabelsDetail();
        filterApproverOptionsDetail();
    }

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
            $(this).find('.approver-label').text('Nama Peserta ' + (index + 1));
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

    function initializeSelect2(element) {
        element.select2({
            placeholder: "Choose Your Approver",
            allowClear: true,
            width: '100%',
            dropdownParent: element.parent(), // Agar dropdown muncul dengan benar
        });
    }

    function modalShow(obj) {
        let id = parseInt(obj.attributes.id.value);
        $('#id_item').val(obj.attributes.id.value);
        $('#id_item_a').val(obj.attributes.id_a.value);

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
                let status = '';

                if (data.data.status_approval_b == 'Waiting Approval') {
                    status = '<span style="font-size: 15px;" class="badge badge-info">Waiting Approval</span>'
                } else if (data.data.status_approval_b == 'Rejected') {
                    status = '<span style="font-size: 15px;" class="badge badge-danger">Rejected</span>'
                } else {
                    status = '<span style="font-size: 15px;" class="badge badge-success">Approved</span>'
                }
                $('#statusApp').html(status);

                // console.log(data.data.tanggal_pelaporan);
                $('#tanggal_palaporan_detail').val(data.data.tanggal_pelaporan);
                $('#nama_pelapor_detail').val(data.data.id_pelapor).trigger('change');
                $('#no_revisi_detail').val(data.data.id_pengajuan_a).trigger('change');
                $('#jabatan_pelapor_detail').val(data.data.jabatan_pelapor);
                $('#direktorat_pelapor_detail').val(data.data.direktorat_pelapor);

                $('#giftTextDetail').val(data.data.detail_pemberian_gift_b);
                $('#entertainmentTextDetail').val(data.data.detail_pemberian_entertainment_b);
                $('#otherTextDetail').val(data.data.detail_pemberian_other_b);

                $('#giftTextDetail').css({
                    'pointer-events': 'none'
                });
                $('#entertainmentTextDetail').css({
                    'pointer-events': 'none'
                });
                $('#otherTextDetail').css({
                    'pointer-events': 'none'
                });

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



                $('#btn-print').on('click', function() {
                    let id_print = parseInt($('#id_item').val());
                    // alert(id_print);
                    window.open('module/gift_b/print.php?id=' + id_print, '_blank', 'location=yes,scrollbars=yes,status=yes')

                });

                $('#btn-view').on('click', function() {
                    let id_print = parseInt($('#id_item').val());
                    // window.open('module/gift_b/printA.php?id=' + id_print)
                    window.location.href = 'module/gift_b/printA.php?id=' + id_print + '&download=true';

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
                        '<td class="fileNameCell" style="width: 99% !important;"> File Print A ' + data.dataForm.nomor_pengajuan + '</td>' +
                        '<td style="width: 1% !important;">' +
                        '<div style="display: flex;">' +
                        // Tombol View
                        // '<a href="' + baseUrl + '/engineering/uploads/' + data.dataLampiran.file_name + '" ' +
                        // 'target="_blank" class="btn btn-info">' + '<i class="fas fa-eye"></i> View </a>' +

                        // Tombol Update
                        '<button type="button" class="btn btn-info uploadFileButton"> <i class="fas fa-eye"></i> View </button>' +
                        // '<input type="file" class="fileInputDetail" name="fileInputDetail" style="display: none;">' +
                        '</div>' +
                        '</td>' +
                        '</tr>';
                    // } else if (data.dataLampiran && data.dataLampiran.file_name == null) {
                    // Debugging: Log if no file data is found
                    // console.warn('No file data available.');
                    // rowTable = '<tr><td style="text-align: center" colspan="2">No Data</td></tr>';
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


                if (data.dataLampiran) {
                    $('#alasanDetail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });
                } else {
                    $('#alasanDetail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });
                }

                // Peserta
                $('#approverContainerDetail').empty();
                $('#jenisapproverdivDetail').empty();

                let idPeserta = data.dataPeserta[0].id_employee;
                let jumlahPeserta = data.dataPeserta;

                // console.log('tes');
                console.log(idPeserta);

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

                console.log(data.listemployee);

                $('#approverContainerDetail').on('change', '.approverSelectDetail', function() {
                    let direktoratePeserta = $(this).find('option:selected').attr('data_title');
                    console.log(direktoratePeserta);
                    $(this).closest('.jenisapproverdivDetail').find('[name="direktorat_peserta_detail[]"]').val(direktoratePeserta).trigger('change');
                });

                currentListEmployee = data.listemployee;
                originalApproverOptionsDetail = generateApproverOptions(currentListEmployee);

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

                $('#approverTable').DataTable().destroy();
                let listApprover = $('#listApprover');
                let rowTable3 = '';

                // Clear the table body before appending new rows
                listApprover.empty();

                if (data.dataApprover != null && data.dataApprover.length > 0) {
                    data.dataApprover.forEach(e => {
                        rowTable3 += '<tr>' +
                            '<td>' + (e.approver_name_b ?? '-') + '</td>' +
                            '<td>' + (e.approval_status_b ?? '-') + '</td>' +
                            '<td>' + (e.tanggal_approval_b == '0000-00-00' ? '-' : e.tanggal_approval_b) + '</td>' +
                            '<td>' + (e.approver_level_b ?? '-') + '</td>' +
                            '<td>' + (e.notes_b ?? '-') + '</td>' +
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

                var statuses = data.dataApprover.map(function(approver) {
                    return approver.approval_status_b;
                });

                function disableAllElements() {
                    $('#nama_pelapor_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });
                    $('#tanggal_palaporan_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });
                    $('#no_revisi_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });
                    $('#jabatan_pelapor_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    $('#direktorat_pelapor_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });



                    $('#giftDetail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    $('#giftTextDetail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    $('#entertainmentDetail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    $('#entertainmentTextDetail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    $('#otherDetail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    $('#otherTextDetail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    $('#nama_penerima_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    $('#perusahaan_penerima_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    $('#tanggal_diberikan_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    $('#tempat_diberikan_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    $('#tujuan_diberikan_detail').prop('disabled', true).css({
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

                    $('#tujuan_diberikan_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    $('#editApproverButton').prop('disabled', true).css({
                        'opacity': '0.3'
                    });

                    $('#editPesertaButton').prop('disabled', true).css({
                        'opacity': '0.3'
                    });

                    $('#btnSaveEdit').prop('disabled', true).css({
                        'opacity': '0.3'
                    });

                    $('.uploadFileButton').prop('disabled', false).css({
                        'opacity': '1'
                    });
                    $('#btn-print').prop('disabled', false).css({
                        'opacity': '1'
                    });
                }

                // Function to enable all elements
                function enableAllElements() {
                    $('#nama_pelapor_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });
                    $('#tanggal_palaporan_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });
                    $('#no_revisi_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });
                    $('#jabatan_pelapor_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    $('#direktorat_pelapor_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });



                    $('#giftDetail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });

                    $('#giftTextDetail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });

                    $('#entertainmentDetail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });

                    $('#entertainmentTextDetail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });

                    $('#otherDetail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });

                    $('#otherTextDetail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });

                    $('#nama_penerima_detail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });

                    $('#perusahaan_penerima_detail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });

                    $('#tanggal_diberikan_detail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });

                    $('#tempat_diberikan_detail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });

                    $('#tujuan_diberikan_detail').prop('disabled', false).css({
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

                    $('#tujuan_diberikan_detail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });

                    $('#editApproverButton').prop('disabled', false).css({
                        'opacity': '1'
                    });

                    $('#editPesertaButton').prop('disabled', false).css({
                        'opacity': '1'
                    });

                    $('#btnSaveEdit').prop('disabled', false).css({
                        'opacity': '1'
                    });

                    $('.uploadFileButton').prop('disabled', false).css({
                        'opacity': '1'
                    });
                    $('#btn-print').prop('disabled', true).css({
                        'opacity': '0.5'
                    });
                }

                // Check the statuses and apply logic
                if (statuses.every(function(status) {
                        return status === 'Waiting Approval';
                    })) {
                    $('#btn-print').prop('disabled', true).css({
                        'opacity': '0.5'
                    });

                    $('#estimasiBiaya_detail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });
                    // Semua status adalah "Waiting Approval"
                    enableAllElements();
                } else if (statuses.includes('Approved')) {
                    // Jika ada status "Approved"
                    disableAllElements();
                    $('#btn-print').prop('disabled', true).css({
                        'opacity': '0.5'
                    });

                    $('#estimasiBiaya_detail').prop('disabled', true).css({
                        'pointer-events': 'none',
                        'opacity': '0.5'
                    });

                    if (statuses.includes('Rejected')) {
                        // Jika ada juga status "Rejected"
                        enableAllElements();
                        $('#btn-print').prop('disabled', true).css({
                            'opacity': '0.5'
                        });
                        $('#estimasiBiaya_detail').prop('disabled', false).css({
                            'pointer-events': 'auto',
                            'opacity': '1'
                        });
                    }
                } else if (statuses.includes('Rejected')) {
                    // Jika ada status "Rejected" tapi tidak ada "Approved"
                    enableAllElements();
                    $('#btn-print').prop('disabled', true).css({
                        'opacity': '0.5'
                    });
                    $('#estimasiBiaya_detail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });
                } else {
                    // Default: jika tidak ada kondisi di atas
                    enableAllElements();
                    $('#btn-print').prop('disabled', true).css({
                        'opacity': '0.5'
                    });
                    $('#estimasiBiaya_detail').prop('disabled', false).css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });
                }

                if (statuses.every(function(status) {
                        return status === 'Approved';
                    })) { // Jika semua status Approved
                    $('#btn-print').prop('disabled', false).css({
                        'opacity': '1'
                    });
                    $('#btnSaveEdit').prop('disabled', true).css({
                        'save': '1'
                    });
                    $('#estimasiBiaya_detail').prop('disabled', true).css({
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
    }


    function toggleFieldsDetail() {
        console.log('gift', $('#giftDetail').is(':checked'));
        console.log('entre', $('#entertainmentDetail').is(':checked'));
        console.log('other', $('#otherDetail').is(':checked'));
        if ($('#giftDetail').is(':checked') == true) {
            $('#giftTextDetailContainer').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
            $('#giftTextDetail').css({
                'pointer-events': 'auto'
            });
        } else {
            $('#giftTextDetailContainer').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
            $('#giftTextDetail').val('');
            $('#giftTextDetail').css({
                'pointer-events': 'none'
            });
        }

        // Periksa status #entertainment
        if ($('#entertainmentDetail').is(':checked')) {
            $('#entertainmentTextDetailContainer').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
            $('#entertainmentTextDetail').css({
                'pointer-events': 'auto'
            });
        } else {
            $('#entertainmentTextDetailContainer').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
            $('#entertainmentTextDetail').val('');
            $('#entertainmentTextDetail').css({
                'pointer-events': 'none'
            });
        }

        // Periksa status #other
        if ($('#otherDetail').is(':checked')) {
            $('#otherTextDetailContainer').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
            $('#otherTextDetail').css({
                'pointer-events': 'auto'
            });
        } else {
            $('#otherTextDetailContainer').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
            $('#otherTextDetail').val('');
            $('#otherTextDetail').css({
                'pointer-events': 'none'
            });
        }

    }

    // Validasi Untuk Jenis Pemberian
    function toggleFields() {
        if ($('#gift').is(':checked')) {
            $('#giftTextdiv').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
            $('#giftText').css({
                'pointer-events': 'auto'
            });
        } else {
            $('#giftText').val('');
            $('#giftTextdiv').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
            $('#giftText').css({
                'pointer-events': 'none'
            });
        }

        // Periksa status #entertainment
        if ($('#entertainment').is(':checked')) {
            $('#entertainmentTextdiv').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
            $('#entertainmentText').css({
                'pointer-events': 'auto'
            });
        } else {
            $('#entertainmentText').val('');
            $('#entertainmentTextdiv').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
            $('#entertainmentText').css({
                'pointer-events': 'none'
            });
        }

        // Periksa status #other
        if ($('#other').is(':checked')) {
            $('#otherTextdiv').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
            $('#otherText').css({
                'pointer-events': 'auto'
            });
        } else {
            $('#otherText').val('');
            $('#otherTextdiv').css({
                'pointer-events': 'none',
                'opacity': '0'
            });
            $('#otherText').css({
                'pointer-events': 'none'
            });
        }

    }

    function updateApproverLabels() {
        $('.approver-label').each(function(index) {
            $(this).text('Nama Peserta ' + (index + 1));
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


    // Validasi Untuk Detail Penerima
    function toggleFields2() {
        if ($('#sama2').is(':checked')) {
            $('#namaPenerima').css({
                'pointer-events': 'none',
                'opacity': '0.5'
            });
            $('#perusahaanPenerima').css({
                'pointer-events': 'none',
                'opacity': '0.5'
            });

        } else if ($('#tidak2').is(':checked')) {
            $('#namaPenerima').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
            $('#perusahaanPenerima').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        }
    }

    // Validasi Untuk Tanggal Diberikan
    function toggleFields3() {
        if ($('#sama3').is(':checked')) {
            $('#tanggalPenerima').css({
                'pointer-events': 'none',
                'opacity': '0.5'
            });

        } else if ($('#tidak3').is(':checked')) {
            $('#tanggalPenerima').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        }
    }

    // Validasi Untuk Tempat Diberikan
    function toggleFields4() {
        if ($('#sama4').is(':checked')) {
            $('#tempatPenerima').css({
                'pointer-events': 'none',
                'opacity': '0.5'
            });

        } else if ($('#tidak4').is(':checked')) {
            $('#tempatPenerima').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        }
    }

    // Validasi Untuk Tujuan Diberikan
    function toggleFields5() {
        if ($('#sama5').is(':checked')) {
            $('#tujuanPenerima').css({
                'pointer-events': 'none',
                'opacity': '0.5'
            });

        } else if ($('#tidak5').is(':checked')) {
            $('#tujuanPenerima').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        }
    }

    function toggleFields6() {
        if ($('#sama6').is(':checked')) {
            $('#estimasiBiaya, #estimasiBiayaCurrency').css({
                'pointer-events': 'none',
                'opacity': '0.6'
            });
            if ($('#currencyAdd').data('select2')) {
                $('#currencyAdd').val(null).trigger('change'); // Untuk Select2
            } else {
                $('#currencyAdd').val(''); // Untuk dropdown biasa
            }
        } else if ($('#tidak6').is(':checked')) {
            $('#estimasiBiaya, #estimasiBiayaCurrency').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
        }
    }

    // Validasi Peserta Perusahaan
    function toggleFields7() {
        if ($('#sama').is(':checked')) {
            $('.jenisapproverdivDetail2').css({
                'pointer-events': 'none',
                'opacity': '0.5'
            });
            $('#direktoratHidden').css({
                'pointer-events': 'none',
                'opacity': '0.5'
            });

        } else if ($('#tidak').is(':checked')) {
            $('.jenisapproverdivDetail2').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
            $('#direktoratHidden').css({
                'pointer-events': 'none',
                'opacity': '0.5'
            });
        }
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

    function ReloadTablePeserta() {
        let id = parseInt($('#id_item').val());

        // console.log('id QAa:', id);

        $.ajax({
            type: "GET",
            url: "module/gift_b/getdetail.php?id=" + id,
            dataType: "JSON",
            success: function(data) {
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
                swal.fire("Error fetching approver data.");
            }
        });
    }

    function clearform() {
        $("#reportAdd")[0].reset();
        $("#reportAdd").parsley().reset();

        $("input[name='jenisPemberian[]']").prop('checked', false).trigger('change');
        $("ada1").prop('checked', true).trigger('change');
        // $("input[name='penerima_decision']").prop('checked', false).trigger('change');
        $("#sama2").prop('checked', true).trigger('change');
        $("#sama6").prop('checked', true).trigger('change');
        $("#sama3").prop('checked', true).trigger('change');
        $("#sama4").prop('checked', true).trigger('change');
        $("#sama5").prop('checked', true).trigger('change');
        $("#sama").prop('checked', true).trigger('change');
        // $("input[name='estimasi_decision']").prop('checked', false).trigger('change');
        // $("input[name='tanggal_decision']").prop('checked', false).trigger('change');
        // $("input[name='tempat_decision']").prop('checked', false).trigger('change');
        // $("input[name='tujuan_decision']").prop('checked', false).trigger('change');
        // $("input[name='peserta_decision']").prop('checked', false).trigger('change');

        $("#nama_pelapor").val('').trigger("change");
        $("#tanggal_palaporan").val('').trigger("change");
        $("#no_revisi").val('').trigger("change");
        $("#jabatan_pelapor").val('').trigger("change");
        $("#direktorat_pelapor").val('').trigger("change");
        $("#giftText").val('').trigger("change");
        $("#entertainmentText").val('').trigger("change");
        $("#otherText").val('').trigger("change");
        $("#alasan").val('').trigger("change");
        $("#nama_penerima").val('').trigger("change");
        $("#perusahaan_penerima").val('').trigger("change");
        $("#currencyAdd").val('').trigger("change");
        $("#estimasi_biaya").val('').trigger("change");
        $("#tanggal_diberikan").val('').trigger("change");
        $("#tempat_diberikan").val('').trigger("change");
        $("#tujuan_diberikan").val('').trigger("change");
        $("#peserta_perusahaan").val('').trigger("change");
        $('#firstapprover select[name="nama_peserta[]"]').val('').trigger('change');
        $("#file").val('');
        $("#btnSave").prop("disabled", false);
        $('.jenisapproverdiv').not(':first').remove();
        $('#approverContainer .jenisapproverdiv:first select[name="nama_peserta[]"]').val('').trigger('change');

        // $("input[name='contractTemplate']").prop('checked', false).first().prop('checked', true).trigger('change');
        // $("#effectiveDate").val('').trigger("change");

        // $("input[name='project']").prop('checked', false).first().prop('checked', true).trigger('change');

        // $("#soCustomerProject").val('').trigger("change");
        // $("#poNumberProject").val('').trigger("change");
        // $("#poPrincipalProject").val('').trigger("change");

        // $("#jobPosition").val('').trigger("change");
        // $("#companyName").val('').trigger("change");

        // $("#ProjectNameText").val('');
        // $("#description").val('');

    }
</script>