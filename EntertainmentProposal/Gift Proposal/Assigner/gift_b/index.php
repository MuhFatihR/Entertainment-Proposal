<div class="main-content container-fluid">

    <!-- Filter -->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">
                    <div class="col-md-8 col-sm-9 col-xs-12">
                        <b>Filter</b>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">
                    <form id="filter" action="" method="post">
                        <!-- ROW 1 -->
                        <div class="form-group row">
                            <div class="col-sm-3 xs-mb-5">
                                <label for="no_pengajuan_filter">Nomor Pengajuan</Title></label>
                                <input type="text" id="no_pengajuan_filter"
                                    name="no_pengajuan_filter" class="form-control input-sm"
                                    placeholder="Search Nomor Pengajuan" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs-mb-5">
                                <label for="nama_filter">Nama</Title></label>
                                <input type="text" id="nama_filter"
                                    name="nama_filter" class="form-control input-sm"
                                    placeholder="Search Nama" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs-mb-5">
                                <label for="direktorat_filter">Direktorat</Title></label>
                                <input type="text" id="direktorat_filter"
                                    name="direktorat_filter" class="form-control input-sm"
                                    placeholder="Search Perusahaan Pengirim" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs-mb-5">
                                <label for="nama_penerima_filter">Nama Penerima</Title></label>
                                <input type="text" id="nama_penerima_filter"
                                    name="nama_penerima_filter" class="form-control input-sm"
                                    placeholder="Search Nama Penerima" autocomplete="off">
                            </div>
                        </div>

                        <!-- ROW 2 -->
                        <div class="form-group row">
                            <div class="col-sm-3 xs-mb-5">
                                <label for="perusahaan_penerima_filter">Perusahaan Penerima</Title></label>
                                <input type="text" id="perusahaan_penerima_filter"
                                    name="perusahaan_penerima_filter" class="form-control input-sm"
                                    placeholder="Search Perusahaan Penerima" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs">
                                <label for="jenis_pemberian_filter">Jenis Pemberian</Title></label>
                                <input type="text" id="jenis_pemberian_filter"
                                    name="jenis_pemberian_filter" class="form-control input-sm"
                                    placeholder="Search Jenis Pemberian" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs">
                                <label for="tanggal_pengajuan_filter">Tanggal Pelaporan</Title></label>
                                <input type="date" id="tanggal_pengajuan_filter"
                                    name="tanggal_pengajuan_filter" class="form-control input-sm"
                                    placeholder="Search Tanggal Pengajuan" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs">
                                <label for="tanggal_diberikan_filter">Tanggal Diberikan</Title></label>
                                <input type="date" id="tanggal_diberikan_filter"
                                    name="tanggal_diberikan_filter" class="form-control input-sm"
                                    placeholder="Search Tanggal Diberikan" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3 xs">
                                <label for="status_approval_filter">Status Approval</Title></label>
                                <input type="text" id="status_approval_filter"
                                    name="status_approval_filter" class="form-control input-sm"
                                    placeholder="Search Status Approval" autocomplete="off">
                            </div>
                            <div class="col-sm-1 xs">
                                <label for="clear">&nbsp;</label>
                                <button id="clear" name="clear" class="btn btn-space btn-default form-control input-sm" style="background-color: #6c757d; color: white;" type="clear">Clear</button>
                            </div>
                            <div class="col-sm-2 xs">
                                <label for="submit">&nbsp;</label>
                                <button id="submitSearch" name="hasilkan" class="btn btn-space btn-primary form-control input-sm" type="submit">Generate</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAdd" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-lg" id="modalAddSize">
            <div class="modal-content d-flex">
                <div class="modal-header" style="display: flex">
                    <h4 class="modal-title">Add New Gift</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close" style="margin-left: 84.5%;"><span class="mdi mdi-close"></span></button>
                </div>

                <div class="modal-body">
                    <div class="py-2 d-flex justify-content-between"></div>
                    <form action="" method="" id="reportAdd" autocomplete="off">
                        <!-- Nama, Tanggal Pelaporan & Nomor Form A -->
                        <div class="row form-group">
                            <div class="col-md-4 col-xs-12" id="">
                                <?php // GET email by COOKIE
                                $userEmail = $mydata['email'];
                                $defaultUserQuery = $db->query("SELECT id, full_name FROM employee WHERE email = '$userEmail' AND active = '1'");
                                $defaultUser = $defaultUserQuery->fetch_assoc();
                                ?>
                                <input type="hidden" id="default_user_id" value="<?php echo $defaultUser['id']; ?>">
                                <input type="hidden" id="default_user_name" value="<?php echo $defaultUser['full_name']; ?>">

                                <label for="nama_pelapor" class="form-label">Nama</label>
                                <select name="nama_pelapor" id="nama_pelapor" class="form-control input-sm select2">
                                    <option value=""></option>
                                    <?php
                                    $getPelapor = $db->query("SELECT id, full_name, title, directorate
                                                                FROM employee 
                                                                WHERE active = '1'
                                                                ORDER BY full_name");
                                    while ($pelapor = $getPelapor->fetch_assoc()) {
                                        echo '<option value="' . $pelapor['id'] . '"  data-title="' . $pelapor['title'] . '" data-directorate="' . $pelapor['directorate'] . '">  ' . $pelapor['full_name'] . ' </option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4 col-xs-12" style="pointer-events: none; opacity: 0.5;">
                                <label for="" class="form-label">Tanggal Pelaporan</label>
                                <input type="date" name="tanggal_palaporan" id="tanggal_palaporan"
                                    class="form-control input-sm">
                            </div>

                            <div class="col-md-4 col-xs-12" id="">
                                <label for="no_revisi" class="form-label">Nomor Form A</label>
                                <select name="no_revisi" id="no_revisi" class="form-control input-sm select2" data-placeholder="Select Nomor Form A">
                                    <option value="" disabled selected></option>
                                    <?php
                                    $getPengajuanA = $dbeta->query("SELECT id, nomor_pengajuan
                                                                    FROM pengajuan_form_a 
                                                                    WHERE used = '0'
                                                                    and status_pengajuan = 'Approved'
                                                                    ORDER BY nomor_pengajuan ASC");
                                    while ($pengajuanA = $getPengajuanA->fetch_assoc()) {
                                        echo '<option value="' . $pengajuanA['id'] . '">  ' . $pengajuanA['nomor_pengajuan'] . ' </option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Jabatan & Direktorat -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="jabatan_pelapor" class="form-label">Jabatan</label>
                                <input type="text" name="jabatan_pelapor" id="jabatan_pelapor"
                                    class="form-control input-sm">
                            </div>
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="direktorat_pelapor" class="form-label">Direktorat</label>
                                <input type="text" name="direktorat_pelapor" id="direktorat_pelapor"
                                    class="form-control input-sm">
                            </div>
                        </div>

                        <!-- Jenis Pemberian -->
                        <div class="row form-group">
                            <div class="col-md-4 col-xs-12" id="">
                                <label for="jenis_pemberian">Jenis Pemberian</Title></label>
                            </div>
                        </div>

                        <!-- Gift -->
                        <div class="row form-group">
                            <div class="col-md-2 col-xs-12">
                                <label for="gift" class="form-check-label mb-0">Gift</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberian[]" id="gift"
                                    value="gift" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="giftTextdiv" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="giftText"
                                    name="giftText" class="form-control input-sm" placeholder="Input Gift">
                            </div>
                        </div>

                        <!-- Entertainment -->
                        <div class="row form-group">
                            <div class="col-md-2 col-xs-12">
                                <label for="entertainment" class="form-check-label mb-0">Entertainment</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberian[]" id="entertainment"
                                    value="entertainment" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="entertainmentTextdiv" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="entertainmentText"
                                    name="entertainmentText" class="form-control input-sm" placeholder="Input Entertainment">
                            </div>
                        </div>

                        <!-- Other -->
                        <div class="row form-group">
                            <div class="col-md-2 col-xs-12">
                                <label for="other" class="form-check-label mb-0">Other</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberian[]" id="other"
                                    value="other" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="otherTextdiv" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="otherText"
                                    name="otherText" class="form-control input-sm" placeholder="Input Other">
                            </div>
                        </div>

                        <!-- Persetujuan Sebelumnya -->
                        <!-- <div class="row form-group">
                            <div class="col-md-3 col-xs-12" id="">
                                <label for="persetujuan_sebelumnya" class="form-label">Persetujuan Sebelumnya: </label>
                                <div>
                                    <div>
                                        <div class="d-flex align-items-center toggle-radio" data-style="square">
                                            <input type="radio" name="persetujuan_decision" id="ada1" value="ada" checked>
                                            <label for="ada1" class="form-check-label px-4">Ada </label>

                                            <input type="radio" name="persetujuan_decision" id="tidak1" value="tidak">
                                            <label for="tidak1" class="form-check-label px-4">Tidak </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 col-xs-12" id="insertFile" style="display: block;">
                                <label for="file" class="form-label">Insert File</label>
                                <input type="file" name="file" id="file" class="form-control input-sm">
                            </div>

                            <div class="col-md-9 col-xs-12" id="alasandiv" style="display: none;">
                                <label for="" class="control-label">Alasan </label>
                                <input type="text" name="alasan" id="alasan" class="form-control input-sm">
                            </div>

                        </div> -->

                        <!-- Detail Penerima -->
                        <div class="row form-group">
                            <div class="col-md-3 col-xs-12" id="">
                                <label for="detail_penerima" class="form-label">Detail Penerima: </label>
                                <div>
                                    <div>
                                        <div class="d-flex align-items-center toggle-radio" data-style="square">
                                            <input type="radio" name="penerima_decision" id="sama2" value="sama" checked>
                                            <label for="sama2" class="form-check-label px-4">Sama </label>

                                            <input type="radio" name="penerima_decision" id="tidak2" value="tidak">
                                            <label for="tidak2" class="form-check-label px-4">Tidak </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xs-12" style="pointer-events: none; opacity: 0.5;" id="namaPenerima">
                                <label for="" class="control-label">Nama Penerima </label>
                                <input type="text" name="nama_penerima" id="nama_penerima" class="form-control input-sm" placeholder="Input Nama Penerima">
                            </div>

                            <div class="col-md-5 col-xs-12" style="pointer-events: none; opacity: 0.5;" id="perusahaanPenerima">
                                <label for="" class="control-label">Perusahaan Penerima </label>
                                <input type="text" name="perusahaan_penerima" id="perusahaan_penerima" class="form-control input-sm" placeholder="Input Perusahaan Penerima">
                            </div>
                        </div>

                        <!-- Currency & Estimasi Biaya-->
                        <div class="row form-group">
                            <div class="col-md-3 col-xs-12" id="">
                                <label for="estimasi_biaya" class="form-label">Estimasi Biaya: </label>
                                <div>
                                    <div>
                                        <div class="d-flex align-items-center toggle-radio" data-style="square">
                                            <input type="radio" name="estimasi_decision" id="sama6" value="sama" checked>
                                            <label for="sama6" class="form-check-label px-4">Sama </label>

                                            <input type="radio" name="estimasi_decision" id="tidak6" value="tidak">
                                            <label for="tidak6" class="form-check-label px-4">Tidak </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xs-12" style="pointer-events: none; opacity: 0.5;" id="estimasiBiayaCurrency">
                                <label for="currencyAdd" class="control-label">Currency</label>
                                <select name="currencyAdd" id="currencyAdd" class="form-control input-sm select2" data-placeholder="Select Currency">
                                    <option value="">Select Currency</option>
                                    <?php
                                    $getCurrency = $dbeta->query("SELECT * FROM currency");
                                    while ($currencyOption = $getCurrency->fetch_assoc()) {
                                        echo '<option value="' . $currencyOption['id'] . '"> ' . $currencyOption['nama_currency'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-5 col-xs-12" style="pointer-events: none; opacity: 0.5;" id="estimasiBiaya">
                                <label for="" class="control-label">Estimasi Biaya</label>
                                <input type="text" name="estimasi_biaya" id="estimasi_biaya" class="form-control input-sm" placeholder="Input Estimasi Biaya">
                            </div>

                        </div>

                        <!-- Tanggal Diberikan -->
                        <div class="row form-group">
                            <div class="col-md-3 col-xs-12" id="">
                                <label for="tanggal_diberikan" class="form-label">Tanggal Diberikan: </label>
                                <div>
                                    <div>
                                        <div class="d-flex align-items-center toggle-radio" data-style="square">
                                            <input type="radio" name="tanggal_decision" id="sama3" value="sama" checked>
                                            <label for="sama3" class="form-check-label px-4">Sama </label>

                                            <input type="radio" name="tanggal_decision" id="tidak3" value="tidak" 3>
                                            <label for="tidak3" class="form-check-label px-4">Tidak </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9 col-xs-12" style="pointer-events: none; opacity: 0.5; padding-top:2.7%;" id="tanggalPenerima">
                                <input type="date" name="tanggal_diberikan" id="tanggal_diberikan" class="form-control input-sm" placeholder="Select Tanggal Diberikan">
                            </div>

                        </div>

                        <!-- Tempat Diberikan -->
                        <div class="row form-group">
                            <div class="col-md-3 col-xs-12" id="">
                                <label for="tempat_diberikan" class="form-label">Tempat Diberikan: </label>
                                <div>
                                    <div>
                                        <div class="d-flex align-items-center toggle-radio" data-style="square">
                                            <input type="radio" name="tempat_decision" id="sama4" value="sama" checked>
                                            <label for="sama4" class="form-check-label px-4">Sama </label>

                                            <input type="radio" name="tempat_decision" id="tidak4" value="tidak">
                                            <label for="tidak4" class="form-check-label px-4">Tidak </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9 col-xs-12" style="pointer-events: none; opacity: 0.5; padding-top:2.7%;" id="tempatPenerima">
                                <input type="text" name="tempat_diberikan" id="tempat_diberikan" class="form-control input-sm" placeholder="Input Tempat Diberikan">
                            </div>

                        </div>

                        <!-- Tujuan Diberikan -->
                        <div class="row form-group">
                            <div class="col-md-3 col-xs-12" id="">
                                <label for="tujuan_diberikan" class="form-label">Tujuan Diberikan: </label>
                                <div>
                                    <div>
                                        <div class="d-flex align-items-center toggle-radio" data-style="square">
                                            <input type="radio" name="tujuan_decision" id="sama5" value="sama" checked>
                                            <label for="sama5" class="form-check-label px-4">Sama </label>

                                            <input type="radio" name="tujuan_decision" id="tidak5" value="tidak">
                                            <label for="tidak5" class="form-check-label px-4">Tidak </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9 col-xs-12" style="pointer-events: none; opacity: 0.5; padding-top:2.7%;" id="tujuanPenerima">
                                <input type="text" name="tujuan_diberikan" id="tujuan_diberikan" class="form-control input-sm" placeholder="Input Tujuan Diberikan">
                            </div>

                        </div>

                        <!-- Peserta Perusahaan -->
                        <div class="row form-group">
                            <div class="col-md-3 col-xs-12" id="">
                                <label for="peserta_perusahaan" class="form-label">Peserta Perusahaan: </label>
                                <div>
                                    <div>
                                        <div class="d-flex align-items-center toggle-radio" data-style="square">
                                            <input type="radio" name="peserta_decision" id="sama" value="sama" checked>
                                            <label for="sama" class="form-check-label px-4">Sama </label>

                                            <input type="radio" name="peserta_decision" id="tidak" value="tidak">
                                            <label for="tidak" class="form-check-label px-4">Tidak </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-md-9 col-xs-12" style="pointer-events: none; opacity: 0.5; padding-top:2.7%;" id="pesertaPerusahaan">
                                <input type="text" name="peserta_perusahaan" id="peserta_perusahaan" class="form-control input-sm">
                            </div> -->

                        </div>

                        <div class="row form-group">
                            <div id="approverContainerDetail2">
                                <div class="jenisapproverdivDetail2" id="jenisapproverdivDetail2" style="pointer-events: none; opacity: 0.5;">
                                    <div class="col-md-6" id="pesertaHidden">
                                        <label class="approver-label2">Nama Peserta 1</label>
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                                <select name="nama_peserta_detail2[]" id="nama_peserta_detail2" class="form-control select2 approverSelectDetail2" style="position: relative; z-index: 1050;" data-placeholder="Input Nama Peserta">
                                                    <option value=""></option>
                                                    <?php
                                                    $getPeserta = $db->query("SELECT 
                                                                                    id, full_name, directorate, email
                                                                                FROM employee 
                                                                                WHERE active = '1'
                                                                                ORDER BY full_name");
                                                    while ($peserta = $getPeserta->fetch_assoc()) {
                                                        echo '<option value="' . $peserta['id'] . '"  data-title="' . $peserta['directorate'] . '" data-email="' . $peserta['email'] . '">' . $peserta['full_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4" id="direktoratHidden2" style="pointer-events: none; opacity: 0.5;">
                                        <label class="direktorat-label2" for="direktorat_peserta_detail2">Direktorat Peserta 1</Title></label>
                                        <input type="text" name="direktorat_peserta_detail2[]" id="direktorat_peserta_detail2" class="form-control input-sm" placeholder="Input Direktorat Peserta">
                                    </div>

                                    <div class="col-md-2" style="margin-top: 3.3%;">
                                        <button type="button" class="btn btn-success btnAddDetail2 me-1">+</button>
                                        <button type="button" class="btn btn-danger btnRemoveDetail2">-</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- <div class="row form-group">
                            <div id="approverContainer1" style="opacity: 0.5;">
                                <div class="jenisapproverdiv">
                                    <div class="col-md-6 pt-2">
                                        <label class="approver-label pt-2">Nama Peserta 1</label>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 me-2">
                                                <select name="nama_peserta[]" id="nama_peserta" class="form-control select2 approverSelect" style="position: relative; z-index: 1050;">
                                                    <option value=""></option>
                                                    <?php
                                                    $getPeserta = $db->query("SELECT id, full_name, directorate
                                                    FROM employee 
                                                    WHERE active = '1'
                                                    ORDER BY full_name");
                                                    while ($peserta = $getPeserta->fetch_assoc()) {
                                                        echo '<option value="' . $peserta['id'] . '"  data-title="' . $peserta['directorate'] . '">' . $peserta['full_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-2" style="pointer-events: none; opacity: 0.5;">
                                        <label for="direktorat_peserta">Direktorat Peserta</Title></label>
                                        <input type="text" id="direktorat_peserta"
                                            name="direktorat_peserta[]" class="form-control input-sm">
                                    </div>

                                    <div class="col-md-2 mt-2" style="margin-top: 3.3%;">
                                        <button type="button" class="btn btn-success btnAdd me-1">+</button>
                                        <button type="button" class="btn btn-danger btnRemove">-</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Tidak Sama -->
                        <!-- <div class="row form-group">
                            <div id="approverContainer" style="display: none;">
                                <div class="jenisapproverdiv">
                                    <div class="col-md-6 pt-2">
                                        <label class="approver-label pt-2">Nama Peserta 1</label>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 me-2">
                                                <select name="nama_peserta[]" id="nama_peserta" class="form-control select2 approverSelect" style="position: relative; z-index: 1050;">
                                                    <option value=""></option>
                                                    <?php
                                                    $getPeserta = $db->query("SELECT id, full_name, directorate
                                                                                FROM employee 
                                                                                WHERE active = '1'
                                                                                ORDER BY full_name");
                                                    while ($peserta = $getPeserta->fetch_assoc()) {
                                                        echo '<option value="' . $peserta['id'] . '"  data-title="' . $peserta['directorate'] . '">' . $peserta['full_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-2" style="pointer-events: none; opacity: 0.5;">
                                        <label for="direktorat_peserta">Direktorat Peserta</Title></label>
                                        <input type="text" id="direktorat_peserta"
                                            name="direktorat_peserta[]" class="form-control input-sm">
                                    </div>

                                    <div class="col-md-2 mt-2" style="margin-top: 3.3%;">
                                        <button type="button" class="btn btn-success btnAdd me-1">+</button>
                                        <button type="button" class="btn btn-danger btnRemove">-</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </form>
                </div>

                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="btnSave">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Datatable -->
    <div class="row reportpanel">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default panel-table">
                <div class="panel-body">
                    <table id="ParcelTable" width="100%" class="table table-hover table-fw-widget">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Pengajuan</th>
                                <th>Nama</th>
                                <th>Direktorat</th>
                                <th>Nama Penerima</th>
                                <th>Perusahaan Penerima</th>
                                <th>Jenis Pemberian</th>
                                <th>Tanggal Pelaporan</th>
                                <th>Tanggal Diberikan</th>
                                <th>Status Approval</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nomor Pengajuan</th>
                                <th>Nama</th>
                                <th>Direktorat</th>
                                <th>Nama Penerima</th>
                                <th>Perusahaan Penerima</th>
                                <th>Jenis Pemberian</th>
                                <th>Tanggal Pelaporan</th>
                                <th>Tanggal Diberikan</th>
                                <th>Status Approval</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetail" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-lg" id="modalDetailSize">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Gift B
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </h4>
                </div>

                <div class="modal-body">
                    <!-- <div class="py-2 d-flex justify-content-between"></div> -->
                    <div class="" style="text-align: right;">
                        <h4 id="statusApp" name="statusApp" style="margin-top: 0;"> </h4>
                    </div>
                    <form action="" method="" id="reportDetail" autocomplete="off">
                        <input type="hidden" id="id_item" name="id_item" value="">
                        <input type="hidden" id="id_item_a" name="id_item_a" value="">
                        <!-- Nama & Tanggal Pengajuan -->
                        <div class="row form-group">
                            <div class="col-md-4 col-xs-12" style="pointer-events: none; opacity: 0.5;">
                                <label for="nama_pelapor_detail" class="form-label">Nama</label>
                                <select name="nama_pelapor_detail" id="nama_pelapor_detail" class="form-control input-sm select2">
                                    <option value=""></option>
                                    <?php
                                    $getPelapor = $db->query("SELECT id, full_name, title, directorate
                                                                FROM employee 
                                                                WHERE active = '1'
                                                                ORDER BY full_name");
                                    while ($pelapor = $getPelapor->fetch_assoc()) {
                                        echo '<option value="' . $pelapor['id'] . '"  data-title="' . $pelapor['title'] . '" data-directorate="' . $pelapor['directorate'] . '">  ' . $pelapor['full_name'] . ' </option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4 col-xs-12">
                                <label for="" class="form-label">Tanggal Pelaporan</label>
                                <input type="date" name="tanggal_palaporan_detail" id="tanggal_palaporan_detail"
                                    class="form-control input-sm">
                            </div>

                            <div class="col-md-4 col-xs-12" style="pointer-events: none; opacity: 0.5;">
                                <label for="no_revisi_detail" class="form-label">Nomor Form A</label>
                                <select name="no_revisi_detail" id="no_revisi_detail" class="form-control input-sm select2">
                                    <option value="" disabled selected></option>
                                    <?php
                                    $getPengajuanA = $dbeta->query("SELECT DISTINCT
                                                                        id, nomor_pengajuan, used
                                                                    FROM pengajuan_form_a
                                                                    ORDER BY nomor_pengajuan ASC");
                                    while ($pengajuanA = $getPengajuanA->fetch_assoc()) {
                                        echo '<option value="' . $pengajuanA['id'] . '">  ' . $pengajuanA['nomor_pengajuan'] . ' </option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Jabatan & Direktorat -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="jabatan_pelapor_detail" class="form-label">Jabatan</label>
                                <input type="text" name="jabatan_pelapor_detail" id="jabatan_pelapor_detail"
                                    class="form-control input-sm">
                            </div>
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="direktorat_pelapor_detail" class="form-label">Direktorat</label>
                                <input type="text" name="direktorat_pelapor_detail" id="direktorat_pelapor_detail"
                                    class="form-control input-sm">
                            </div>
                        </div>

                        <!-- Jenis Pemberian -->
                        <div class="row form-group">
                            <div class="col-md-4 col-xs-12" id="">
                                <label for="jenis_pemberian_detail">Jenis Penemberian</Title></label>
                            </div>
                        </div>

                        <!-- Gift -->
                        <div class="row form-group">
                            <div class="col-md-2 col-xs-12">
                                <label for="gift" class="form-check-label mb-0">Gift</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberianDetail[]" id="giftDetail"
                                    value="gift" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="giftTextDetailContainer" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="giftTextDetail"
                                    name="giftTextDetail" class="form-control input-sm" placeholder="Input Gift">
                            </div>
                        </div>

                        <!-- Entertainment -->
                        <div class="row form-group">
                            <div class="col-md-2 col-xs-12">
                                <label for="entertainment" class="form-check-label mb-0">Entertainment</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberianDetail[]" id="entertainmentDetail"
                                    value="entertainment" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="entertainmentTextDetailContainer" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="entertainmentTextDetail"
                                    name="entertainmentTextDetail" class="form-control input-sm" placeholder="Input Entertainment">
                            </div>
                        </div>

                        <!-- Other -->
                        <div class="row form-group">
                            <div class="col-md-2 col-xs-12">
                                <label for="other" class="form-check-label mb-0">Other</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberianDetail[]" id="otherDetail"
                                    value="other" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="otherTextDetailContainer" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="otherTextDetail"
                                    name="otherTextDetail" class="form-control input-sm" style="pointer-events: none;" placeholder="Input Other">
                            </div>
                        </div>

                        <!-- Nama & Perusahaan Penerima -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="namaPenerima_detail">
                                <label for="" class="control-label">Nama Penerima </label>
                                <input type="text" name="nama_penerima_detail" id="nama_penerima_detail" class="form-control input-sm" placeholder="Input Nama Penerima">
                            </div>
                            <div class="col-md-6 col-xs-12" id="perusahaanPenerima_detail">
                                <label for="" class="control-label">Perusahaan Penerima </label>
                                <input type="text" name="perusahaan_penerima_detail" id="perusahaan_penerima_detail" class="form-control input-sm" placeholder="Input Perusahaan Penerima">
                            </div>
                        </div>

                        <!-- Tanggal & Tempat Diberikan -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="tanggalPenerima_detail">
                                <label for="" class="control-label">Tanggal Diberikan </label>
                                <input type="date" name="tanggal_diberikan_detail" id="tanggal_diberikan_detail" class="form-control input-sm" placeholder="Input Tanggal Diberikan">
                            </div>
                            <div class="col-md-6 col-xs-12" id="tempatPenerima_detail">
                                <label for="" class="control-label">Tempat Diberikan</label>
                                <input type="text" name="tempat_diberikan_detail" id="tempat_diberikan_detail" class="form-control input-sm" placeholder="Input Tempat Diberikan">
                            </div>
                        </div>

                        <!-- Tujuan Diberikan, Currency & Estimasi Biaya -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="tujuanPenerima_detail">
                                <label for="" class="control-label">Tujuan Diberikan</label>
                                <input type="text" name="tujuan_diberikan_detail" id="tujuan_diberikan_detail" class="form-control input-sm" placeholder="Input Tujuan Diberikan">
                            </div>
                            <div class="col-md-2 col-xs-12" id="estimasiBiaya_detail">
                                <label for="currency_detail" class="control-label">Currency</label>
                                <select name="currency_detail" id="currency_detail" class="form-control input-sm select2">
                                    <option value="">Currency</option>
                                    <?php
                                    $getCurrency = $dbeta->query("SELECT * FROM currency");
                                    while ($currencyOption = $getCurrency->fetch_assoc()) {
                                        echo '<option value="' . $currencyOption['id'] . '"> ' . $currencyOption['nama_currency'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4 col-xs-12" id="estimasiBiaya_detail">
                                <label for="" class="control-label">Estimasi Biaya</label>
                                <input type="text" name="estimasi_biaya_detail" id="estimasi_biaya_detail" class="form-control input-sm" placeholder="Input Estimasi Biaya">
                            </div>

                        </div>

                        <!-- <hr style="border-top: 1px solid rgb(89, 87, 87);"> -->

                        <!-- Softcopy Dokumen B -->
                        <div class="row form-group" style="width: 103.5%;">
                            <div class="col-md-12 pt-3" style="margin-bottom: 1%; margin-top: 2%;">
                                <label for="softcopy" class="control-label fw-bolder mb-2" style="font-size: 20px;">
                                    <strong> Softcopy Dokumen Persetujuan Sebelumnya </strong>
                                </label>
                                <table id="fileTableDokumen" class="table table-sm table-bordered table-hover" style="width: 100%; border: 1px solid #dee2e6;">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">Filename</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listFileDokumen"></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- <hr style="border-top: 1px solid rgb(89, 87, 87);"> -->

                        <!-- Alasan Tanpa File -->
                        <!-- <div class="row form-group">
                            <div class="col-md-12 col-xs-12" id="alasanDetail">
                                <label for="" class="control-label">Alasan Tanpa File</label>
                                <input type="text" name="alasan_detail" id="alasan_detail" class="form-control input-sm">
                            </div>
                        </div> -->

                        <!-- Informasi Peserta -->
                        <div class="row form-group" style="width: 103.5%;">
                            <div class="col-md-12 pt-3" style="margin-bottom: 1%; margin-top: 2%;">
                                <div class="pesertaHeader mb-2" style="display: flex; justify-content:space-between;">
                                    <label for="softcopy" class="control-label fw-bolder mb-2" style="font-size: 20px;">
                                        <strong> Informasi Peserta </strong>
                                    </label>
                                    <div class="detailButton">
                                        <button type="button" id="editPesertaButton" class="btn btn-sm btn-success">
                                            <i class="feather icon-edit"></i> Add / Edit Peserta
                                        </button>
                                    </div>
                                </div>
                                <div id="table_peserta">
                                    <table id="pesertaTable" class="table table-sm table-bordered table-hover"
                                        style="width: 100%; border: 1px solid #dee2e6">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Direktorat</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listPeserta"></tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <!-- <hr style="border-top: 1px solid rgb(89, 87, 87);"> -->

                        <!-- Informasi Approval -->
                        <div class="row form-group" style="width: 103.5%;">
                            <div class="col-md-12 pt-3" style="margin-bottom: 1%; margin-top: 2%;">
                                <div class="approverHeader mb-2" style="display: flex; justify-content:space-between;">
                                    <label for="softcopy" class="control-label fw-bolder mb-2" style="font-size: 20px;">
                                        <strong> Informasi Approval </strong>
                                    </label>
                                    <div class="detailButton">
                                        <!-- <button type="button" id="uploadFileButton" class="btn btn-sm btn-primary"><i
                                                class="feather icon-printer"></i>View Data Form A</button> -->
                                        <button type="button" id="btn-print" class="btn btn-sm btn-primary"><i
                                                class="feather icon-printer"></i>Print Summary</button>
                                    </div>
                                </div>
                                <div id="table_approver">
                                    <table id="approverTable" class="table table-sm table-bordered table-hover"
                                        style="width: 100%; border: 1px solid #dee2e6">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Tanggal Approval</th>
                                                <th class="text-center">Jenjang Approval</th>
                                                <th class="text-center">Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listApprover"></tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="btnSaveEdit">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pesera -->
    <div class="modal fade" id="modalPeserta" tabindex="-1" role="dialog" aria-labelledby="modalPeserta"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.5);">
                <div class="modal-header d-flex">
                    <h5 class="modal-title" id="">Add or Edit Peserta</h5>
                </div>
                <div class="modal-body">
                    <form action="" method="" id="reportEditPeserta">
                        <input type="hidden" id="id_pengajuan" name="id_pengajuan" value="">
                        <input type="hidden" id="id_peserta" name="id_peserta" value="">

                        <!-- Peserta -->
                        <div class="row form-group">
                            <div id="approverContainerDetail">

                                <div class="jenisapproverdivDetail" id="jenisapproverdivDetail">
                                    <div class="col-md-6">
                                        <label class="approver-label">Nama Peserta 1</label>
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                                <select name="nama_peserta_detail[]" id="nama_peserta_detail" class="form-control select2 approverSelectDetail" style="position: relative; z-index: 1050;">
                                                    <option value=""></option>
                                                    <?php
                                                    $getPeserta = $db->query("SELECT 
                                                                                    id, full_name, directorate, email
                                                                                FROM employee 
                                                                                WHERE active = '1'
                                                                                ORDER BY full_name");
                                                    while ($peserta = $getPeserta->fetch_assoc()) {
                                                        echo '<option value="' . $peserta['id'] . '"  data-title="' . $peserta['directorate'] . '" data-email="' . $peserta['email'] . '">' . $peserta['full_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4" style="pointer-events: none; opacity: 0.5;">
                                        <label class="direktorat-label" for="direktorat_peserta_detail_1">Direktorat Peserta 1</Title></label>
                                        <input type="text" name="direktorat_peserta_detail[]" id="direktorat_peserta_detail" class="form-control input-sm">
                                    </div>

                                    <div class="col-md-2" style="margin-top: 3.3%;">
                                        <button type="button" class="btn btn-success btnAddDetail me-1">+</button>
                                        <button type="button" class="btn btn-danger btnRemoveDetail">-</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSavePeserta" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

</div>