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
                        <input type="hidden" id="email" name="email" value="<?php echo $mydata['email']; ?>">
                        <!-- Row 1 -->
                        <div class="form-group row">
                            <div class="col-sm-3 xs-mb-5">
                                <label for="no_pengajuan_filter">Nomor Pengajuan</Title></label>
                                <input type="text" id="no_pengajuan_filter"
                                    name="no_pengajuan_filter" class="form-control input-sm"
                                    placeholder="Search Nomor Pengajuan" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs-mb-5">
                                <label for="nama_pengusul_filter">Nama</Title></label>
                                <input type="text" id="nama_pengusul_filter"
                                    name="nama_pengusul_filter" class="form-control input-sm"
                                    placeholder="Search Nama" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs-mb-5">
                                <label for="direktorat_pengusul_filter">Direktorat</Title></label>
                                <input type="text" id="direktorat_pengusul_filter"
                                    name="direktorat_pengusul_filter" class="form-control input-sm"
                                    placeholder="Search Direktorat" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs-mb-5">
                                <label for="nama_penerima_filter">Nama Penerima</Title></label>
                                <input type="text" id="nama_penerima_filter"
                                    name="nama_penerima_filter" class="form-control input-sm"
                                    placeholder="Search Nama Penerima" autocomplete="off">
                            </div>

                        </div>

                        <!-- Row 2 -->
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
                                    autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs">
                                <label for="tanggal_diberikan_filter">Tanggal Diberikan</Title></label>
                                <input type="date" id="tanggal_diberikan_filter"
                                    name="tanggal_diberikan_filter" class="form-control input-sm"
                                    autocomplete="off">
                            </div>
                        </div>

                        <!-- Row 3 -->
                        <div class="form-group row">
                            <div class="col-sm-3 xs">
                                <label for="status_pengajuan_filter">Status Approval</Title></label>
                                <input type="text" id="status_pengajuan_filter"
                                    name="status_pengajuan_filter" class="form-control input-sm"
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
        <div class="modal-dialog modal-lg" id="modalDetailSize">
            <div class="modal-content d-flex">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Gift A - <span id="nomor_pengajuan_detail"></span>
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </h4>
                </div>

                <div class="modal-body">
                    <div class="py-2 d-flex justify-content-between"></div>
                    <form action="" method="" id="reportDetail">
                        <!-- <input type="hidden" id="idPengajuanA" name="idPengajuanA" value=""> -->
                        <!-- Nama Pengusul & Tanggal Pengajuan -->
                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-6 col-xs-12" id="">
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

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="tanggal_pengajuan_detail">Tanggal Pengajuan</Title></label>
                                <input type="date" id="tanggal_pengajuan_detail"
                                    name="tanggal_pengajuan_detail" class="form-control input-sm">
                            </div>
                        </div>

                        <!-- Jabatan & Direktorat Pengusul -->
                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="jabatan_pengusul_detail">Jabatan</Title></label>
                                <input type="text" id="jabatan_pengusul_detail"
                                    name="jabatan_pengusul_detail" class="form-control input-sm">
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="direktorat_pengusul_detail">Direktorat</Title></label>
                                <input type="text" id="direktorat_pengusul_detail"
                                    name="direktorat_pengusul_detail" class="form-control input-sm">
                            </div>
                        </div>

                        <!-- Jenis Pemberian -->
                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="jenis_pemberian">Jenis Penemberian</Title></label>
                            </div>
                        </div>
                        <!-- Gift -->
                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-2 col-xs-12">
                                <label for="gift_detail" class="form-check-label mb-0">Gift</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberian[]" id="gift_detail" value="gift_detail" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="giftTextContainer_detail" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="giftText_detail" name="giftText_detail" class="form-control input-sm">
                            </div>
                        </div>

                        <!-- Entertainment -->
                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-2 col-xs-12">
                                <label for="entertainment_detail" class="form-check-label mb-0">Entertainment</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberian[]" id="entertainment_detail" value="entertainment_detail" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="entertainmentTextContainer_detail" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="entertainmentText_detail" name="entertainmentText_detail" class="form-control input-sm">
                            </div>
                        </div>

                        <!-- Other -->
                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-2 col-xs-12">
                                <label for="other_detail" class="form-check-label mb-0">Other</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberian[]" id="other_detail" value="other_detail" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="otherTextContainer_detail" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="otherText_detail" name="otherText_detail" class="form-control input-sm">
                            </div>
                        </div>

                        <!-- Detail Penerima -->
                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="nama_penerima_detail">Nama Penerima</Title></label>
                                <input type="text" id="nama_penerima_detail"
                                    name="nama_penerima_detail" class="form-control input-sm">
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="perusahaan_penerima_detail">Perusahaan Penerima</Title></label>
                                <input type="text" id="perusahaan_penerima_detail"
                                    name="perusahaan_penerima_detail" class="form-control input-sm">
                            </div>
                        </div>

                        <!-- Tanggal & Tempat Diberikan -->
                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="tanggal_diberikan_detail">Tanggal Diberikan</Title></label>
                                <input type="date" id="tanggal_diberikan_detail"
                                    name="tanggal_diberikan_detail" class="form-control input-sm">
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="tempat_diberikan_detail">Tempat Diberikan</Title></label>
                                <input type="text" id="tempat_diberikan_detail"
                                    name="tempat_diberikan_detail" class="form-control input-sm">
                            </div>
                        </div>

                        <!-- Tujuan Diberikan, Currency & Estimasi Biaya -->
                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="tujuan_pemberian_detail">Tujuan Pemberian</Title></label>
                                <input type="text" id="tujuan_pemberian_detail"
                                    name="tujuan_pemberian_detail" class="form-control input-sm">
                            </div>

                            <div class="col-md-2 col-xs-12">
                                <label for="currency_detail">Currency</label>
                                <select name="currency_detail" id="currency_detail" class="form-control input-sm select2">
                                    <option value=""></option>
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
                                    name="estimasi_biaya_detail" class="form-control input-sm">
                            </div>
                        </div>

                        <!-- Softcopy Dokumen a -->
                        <div class="row form-group" style="width: 103.5%;">
                            <div class="col-md-12 pt-3" style="margin-bottom: 1%; margin-top: 2%;">
                                <label for="softcopy" class="control-label fw-bolder mb-2" style="font-size: 20px;">
                                    <strong> Softcopy Dokumen Form a </strong>
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
                    <button type="button" class="btn btn-danger" id="btnReject">Reject Submission</button>
                    <button type="button" class="btn btn-success" id="btnApprove">Approve Submission</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Approve Notes -->
    <div class="modal fade" id="approveNotesModal" tabindex="-1" role="dialog"
        aria-labelledby="approveNotesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.5);">
                <div class="modal-header" style="display: flex; align-items: center;">
                    <h4 class="modal-title" style="flex-grow: 1; margin: 0;">Approve Confirmation</h4>
                    <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="margin-left: auto;">
                        <span class="mdi mdi-close"></span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="" method="" id="reportApproveNotes">
                        <input type="hidden" id="id_approver" name="id_approver" value="">

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Notes:</label>
                            <textarea class="form-control" id="approveNotes" name="approveNotes"></textarea>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnApproveFinal">Approve Document</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reject Notes -->
    <div class="modal fade" id="rejectNotesModal" tabindex="-1" role="dialog" aria-labelledby="rejectNotesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.5);">
                <div class="modal-header" style="display: flex; align-items: center;">
                    <h4 class="modal-title" style="flex-grow: 1; margin: 0;">Reject Confirmation</h4>
                    <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="margin-left: auto;">
                        <span class="mdi mdi-close"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="" id="reportRejectNotes">
                        <input type="hidden" id="id_approver" name="id_approver" value="">

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Notes:</label>
                            <textarea class="form-control" id="rejectNotes" name="rejectNotes"></textarea>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnRejectFinal">Reject Document</button>
                </div>
            </div>
        </div>
    </div>

</div>