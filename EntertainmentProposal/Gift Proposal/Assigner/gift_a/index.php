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

                        <div class="form-group row">
                            <div class="col-sm-3 xs-mb-5">
                                <label for="nomor_pengajuan_filter">Nomor Pengajuan</Title></label>
                                <input type="text" id="nomor_pengajuan_filter"
                                    name="nomor_pengajuan_filter" class="form-control input-sm"
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
                                <label for="tanggal_pengajuan_filter">Tanggal Pengajuan</Title></label>
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
                        <!-- Nama Pengusul & Tanggal Pengajuan -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="">
                                <?php // GET email by COOKIE
                                    $userEmail = $mydata['email'];
                                    $defaultUserQuery = $db->query("SELECT id, full_name FROM employee WHERE email = '$userEmail' AND active = '1'");
                                    $defaultUser = $defaultUserQuery->fetch_assoc();
                                ?>
                                <input type="hidden" id="default_user_id" value="<?php echo $defaultUser['id']; ?>">
                                <input type="hidden" id="default_user_name" value="<?php echo $defaultUser['full_name']; ?>">

                                <label for="" class="control-label">Nama</label>
                                <select name="nama_pengusul" id="nama_pengusul" class="form-control select2" data-placeholder="Input Nama">
                                    <option value=""></option>
                                    <?php
                                    $getName = $db->query("SELECT 
                                                                id, full_name, title, directorate
                                                            FROM employee 
                                                            WHERE active = '1'
                                                            ORDER BY full_name");
                                    while ($nama = $getName->fetch_assoc()) {
                                        echo '<option value="' . $nama['id'] . '"  data-title="' . $nama['title'] . '" data-directorate="' . $nama['directorate'] . '">' . $nama['full_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="tanggal_pengajuan">Tanggal Pengajuan</Title></label>
                                <input type="date" id="tanggal_pengajuan"
                                    name="tanggal_pengajuan" class="form-control input-sm" readonly>
                            </div>
                        </div>

                        <!-- Jabatan & Direktorat Pengusul -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="jabatan_pengusul">Jabatan</Title></label>
                                <input type="text" id="jabatan_pengusul"
                                    name="jabatan_pengusul" class="form-control input-sm" placeholder="Input Jabatan">
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="direktorat_pengusul">Direktorat</Title></label>
                                <input type="text" id="direktorat_pengusul"
                                    name="direktorat_pengusul" class="form-control input-sm" placeholder="Input Direktorat">
                            </div>
                        </div>

                        <!-- Jenis Pemberian -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="jenis_pemberian">Jenis Pemberian</Title></label>
                            </div>
                        </div>

                        <!-- Gift -->
                        <div class="row form-group">
                            <div class="col-md-2 col-xs-12">
                                <label for="gift" class="form-check-label mb-0">Gift</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberian[]" id="gift" value="gift" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="giftTextContainer" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="giftText" name="giftText" class="form-control input-sm" placeholder="Input Gift">
                            </div>
                        </div>

                        <!-- Entertainment -->
                        <div class="row form-group">
                            <div class="col-md-2 col-xs-12">
                                <label for="entertainment" class="form-check-label mb-0">Entertainment</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberian[]" id="entertainment" value="entertainment" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="entertainmentTextContainer" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="entertainmentText" name="entertainmentText" class="form-control input-sm" placeholder="Input Entertainment">
                            </div>
                        </div>

                        <!-- Other -->
                        <div class="row form-group">
                            <div class="col-md-2 col-xs-12">
                                <label for="other" class="form-check-label mb-0">Other</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberian[]" id="other" value="other" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="otherTextContainer" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="otherText" name="otherText" class="form-control input-sm" placeholder="Input Other">
                            </div>
                        </div>


                        <!-- Detail Penerima -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="nama_penerima">Nama Penerima</Title></label>
                                <input type="text" id="nama_penerima"
                                    name="nama_penerima" class="form-control input-sm" placeholder="Input Nama Penerima">
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="perusahaan_penerima">Perusahaan Penerima</Title></label>
                                <input type="text" id="perusahaan_penerima"
                                    name="perusahaan_penerima" class="form-control input-sm" placeholder="Input Perusahaan Penerima">
                            </div>
                        </div>

                        <!-- Tanggal & Tempat Diberikan -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="tanggal_diberikan">Tanggal Diberikan</Title></label>
                                <input type="date" id="tanggal_diberikan"
                                    name="tanggal_diberikan" class="form-control input-sm">
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="tempat_diberikan">Tempat Diberikan</Title></label>
                                <input type="text" id="tempat_diberikan"
                                    name="tempat_diberikan" class="form-control input-sm" placeholder="Input Tempat Diberikan">
                            </div>
                        </div>

                        <!-- Tujuan Diberikan & Estimasi Biaya -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="tujuan_pemberian">Tujuan Pemberian</Title></label>
                                <input type="text" id="tujuan_pemberian"
                                    name="tujuan_pemberian" class="form-control input-sm" placeholder="Input Tujuan Pemberian">
                            </div>

                            <div class="col-md-2 col-xs-12">
                                <label for="currency">Currency</label>
                                <select name="currency" id="currency" class="form-control input-sm select2">
                                    <option value="">Currency</option>
                                    <?php
                                    $getCurrency = $dbeta->query("SELECT * 
                                                                    FROM currency");
                                    while ($currencyOption = $getCurrency->fetch_assoc()) {
                                        echo '<option value="' . $currencyOption['id'] . '"> ' . $currencyOption['nama_currency'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4 col-xs-12" id="">
                                <label for="estimasi_biaya">Estimasi Biaya</Title></label>
                                <input type="text" id="estimasi_biaya"
                                    name="estimasi_biaya" class="form-control input-sm" placeholder="Input Estimasi Biaya">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12 col-xs-12" id="insertFile" style="display: block;">
                                <label for="file" class="form-label">Insert File</label>
                                <input type="file" name="file" id="file" class="form-control input-sm">
                            </div>
                        </div>

                        <!-- Peserta -->
                        <div class="row form-group">
                            <div id="approverContainer">
                                <div class="jenisapproverdiv">
                                    <div class="col-md-6 pt-2">
                                        <label class="approver-label pt-2">Nama Peserta 1</label>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 me-2">
                                                <select name="nama_peserta[]" id="nama_peserta" class="form-control select2 approverSelect" style="position: relative; z-index: 1050;" data-placeholder="Input Nama Peserta">
                                                    <option value=""></option>
                                                    <?php
                                                    $getPeserta = $db->query("SELECT 
                                                                                    id, full_name, directorate
                                                                                FROM employee 
                                                                                WHERE active = '1'
                                                                                ORDER BY full_name");
                                                    while ($peserta = $getPeserta->fetch_assoc()) {
                                                        echo '<option value="' . $peserta['id'] . '"  data-title="' . $peserta['directorate'] . '">' . $peserta['full_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- <button type="button" class="btn btn-success btnAdd me-1">+</button>
                                            <button type="button" class="btn btn-danger btnRemove">-</button> -->
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-2" style="pointer-events: none; opacity: 0.5;">
                                        <label for="direktorat_peserta">Direktorat Peserta</Title></label>
                                        <input type="text" id="direktorat_peserta"
                                            name="direktorat_peserta[]" class="form-control input-sm" placeholder="Input Direktorat Peserta">
                                    </div>

                                    <div class="col-md-2 mt-2" style="margin-top: 3.3%;">
                                        <button type="button" class="btn btn-success btnAdd me-1">+</button>
                                        <button type="button" class="btn btn-danger btnRemove">-</button>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                    <table id="GiftTable" width="100%" class="table table-hover table-fw-widget">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Pengajuan</th>
                                <th>Nama</th>
                                <th>Direktorat</th>
                                <th>Nama Penerima</th>
                                <th>Perusahaan Penerima</th>
                                <th>Jenis Pemberian</th>
                                <th>Tanggal Pengajuan</th>
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
                                <th>Tanggal Pengajuan</th>
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
        <div class="modal-dialog modal-lg" id="modalAddSize">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Gift A - <span id="nomor_pengajuan_detail"></span>
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </h4>
                </div>

                <div class="modal-body">
                    <div class="" style="text-align: right;">
                        <h4 id="statusApp" name="statusApp" style="margin-top: 0;"> </h4>
                    </div>
                    <form action="" method="" id="reportDetail" autocomplete="off">
                        <input type="hidden" id="id" name="id" value="">
                        <!-- Nama Pengusul & Tanggal Pengajuan -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" style="pointer-events: none; opacity: 0.5;">
                                <label for="nama_pengusul_detail" class="control-label">Nama</label>
                                <select name="nama_pengusul_detail" id="nama_pengusul_detail" class="form-control input-sm select2">
                                    <option value=""></option>
                                    <?php
                                    $getName = $db->query("SELECT 
                                                                id, full_name, title, directorate
                                                            FROM employee 
                                                            WHERE active = '1'
                                                            ORDER BY full_name");
                                    while ($nama = $getName->fetch_assoc()) {
                                        echo '<option value="' . $nama['id'] . '"  data-title="' . $nama['title'] . '" data-directorate="' . $nama['directorate'] . '">' . $nama['full_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-xs-12">
                                <label for="tanggal_pengajuan_detail">Tanggal Pengajuan</Title></label>
                                <input type="date" id="tanggal_pengajuan_detail"
                                    name="tanggal_pengajuan_detail" class="form-control input-sm">
                            </div>
                        </div>

                        <!-- Jabatan & Direktorat Pengusul -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12">
                                <label for="jabatan_pengusul_detail">Jabatan</Title></label>
                                <input type="text" id="jabatan_pengusul_detail"
                                    name="jabatan_pengusul_detail" class="form-control input-sm">
                            </div>

                            <div class="col-md-6 col-xs-12">
                                <label for="direktorat_pengusul_detail">Direktorat</Title></label>
                                <input type="text" id="direktorat_pengusul_detail"
                                    name="direktorat_pengusul_detail" class="form-control input-sm">
                            </div>
                        </div>

                        <!-- Jenis Pemberian -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12">
                                <label for="jenis_pemberian">Jenis Pemberian</Title></label>
                            </div>
                        </div>

                        <!-- Gift -->
                        <div class="row form-group">
                            <div class="col-md-2 col-xs-12">
                                <label for="gift_detail" class="form-check-label mb-0">Gift</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberian[]" id="gift_detail" value="gift_detail" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="giftTextContainer_detail" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="giftText_detail" name="giftText_detail" class="form-control input-sm" placeholder="Input Gift">
                            </div>
                        </div>

                        <!-- Entertainment -->
                        <div class="row form-group">
                            <div class="col-md-2 col-xs-12">
                                <label for="entertainment_detail" class="form-check-label mb-0">Entertainment</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberian[]" id="entertainment_detail" value="entertainment_detail" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="entertainmentTextContainer_detail" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="entertainmentText_detail" name="entertainmentText_detail" class="form-control input-sm" placeholder="Input Entertainment">
                            </div>
                        </div>

                        <!-- Other -->
                        <div class="row form-group">
                            <div class="col-md-2 col-xs-12">
                                <label for="other_detail" class="form-check-label mb-0">Other</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberian[]" id="other_detail" value="other_detail" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="otherTextContainer_detail" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="otherText_detail" name="otherText_detail" class="form-control input-sm" placeholder="Input Other">
                            </div>
                        </div>

                        <!-- Detail Penerima -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="nama_penerima_detail">Nama Penerima</Title></label>
                                <input type="text" id="nama_penerima_detail"
                                    name="nama_penerima_detail" class="form-control input-sm" placeholder="Input Nama Penerima">
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="perusahaan_penerima_detail">Perusahaan Penerima</Title></label>
                                <input type="text" id="perusahaan_penerima_detail"
                                    name="perusahaan_penerima_detail" class="form-control input-sm" placeholder="Input Perusahaan Penerima">
                            </div>
                        </div>

                        <!-- Tanggal & Tempat Diberikan -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="tanggal_diberikan_detail">Tanggal Diberikan</Title></label>
                                <input type="date" id="tanggal_diberikan_detail"
                                    name="tanggal_diberikan_detail" class="form-control input-sm" placeholder="Input Tanggal Diberikan">
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="tempat_diberikan_detail">Tempat Diberikan</Title></label>
                                <input type="text" id="tempat_diberikan_detail"
                                    name="tempat_diberikan_detail" class="form-control input-sm" placeholder="Input Tempat Diberikan">
                            </div>
                        </div>

                        <!-- Tujuan Diberikan, Currency & Estimasi Biaya -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="tujuan_pemberian_detail">Tujuan Pemberian</Title></label>
                                <input type="text" id="tujuan_pemberian_detail"
                                    name="tujuan_pemberian_detail" class="form-control input-sm" placeholder="Input Tujuan Pemberian">
                            </div>

                            <div class="col-md-2 col-xs-12" id="currenyDetail">
                                <label for="currency_detail">Currency</label>
                                <select name="currency_detail" id="currency_detail" class="form-control input-sm select2">
                                    <option value="">Currency</option>
                                    <?php
                                    $getCurrency = $dbeta->query("SELECT * 
                                                                    FROM currency");
                                    while ($currencyOption = $getCurrency->fetch_assoc()) {
                                        echo '<option value="' . $currencyOption['id'] . '"> ' . $currencyOption['nama_currency'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4 col-xs-12" id="">
                                <label for="estimasi_biaya_detail">Estimasi Biaya</Title></label>
                                <input type="text" id="estimasi_biaya_detail"
                                    name="estimasi_biaya_detail" class="form-control input-sm" placeholder="Input Estimasi Biaya">
                            </div>
                        </div>

                        <!-- Softcopy Dokumen a -->
                        <div class="row form-group" style="width: 103.5%;">
                            <div class="col-md-12 pt-3" style="margin-bottom: 1%; margin-top: 2%;">
                                <label for="softcopy" class="control-label fw-bolder mb-2" style="font-size: 20px;">
                                    <strong> Softcopy Dokumen Form A </strong>
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

                        <!-- Informasi Peserta -->
                        <div class="row form-group" style="width: 103.5%;">
                            <div class="col-md-12 pt-3" style="margin-bottom: 1%; margin-top: 2%;">
                                <div class="pesertaHeader" style="display: flex; justify-content:space-between">
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

                        <!-- Informasi Approval -->
                        <div class="row form-group" style="width: 103.5%;">
                            <div class="col-md-12 pt-3" style="margin-bottom: 1%; margin-top: 2%;">
                                <div class="approverHeader" style="display: flex; justify-content:space-between">
                                    <label for="softcopy" class="control-label fw-bolder mb-2" style="font-size: 20px;">
                                        <strong> Informasi Approval </strong>
                                    </label>
                                    <div class="detailButton">
                                        <button type="button" id="btnPrint" class="btn btn-sm btn-primary"><i
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