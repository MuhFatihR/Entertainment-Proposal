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
                    <div class="py-2 d-flex justify-content-between"></div>
                    <form action="" method="" id="reportDetail">
                        <input type="hidden" id="id_item" name="id_item" value="">
                        <input type="hidden" id="id_item_a" name="id_item" value="">
                        <!-- Nama & Tanggal Pengajuan -->
                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-4 col-xs-12" id="">
                                <label for="nama_pelapor_detail" class="form-label">Nama</label>
                                <select name="nama_pelapor_detail" id="nama_pelapor_detail" class="select2">
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
                                <!-- <input type="date" name="tanggal_palaporan" id="tanggal_palaporan"
                                    class="form-control form-control-sm datetimepicker"> -->
                                <input type="date" name="tanggal_palaporan_detail" id="tanggal_palaporan_detail"
                                    class="form-control input-sm">
                            </div>

                            <div class="col-md-4 col-xs-12" id="" style="pointer-events: none; opacity: 0.5;">
                                <label for="no_revisi_detail" class="form-label">Nomor Form A</label>
                                <select name="no_revisi_detail" id="no_revisi_detail" class="select2">
                                    <option value=""></option>
                                    <?php
                                    $getPengajuanA = $dbeta->query("SELECT id, nomor_pengajuan
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
                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="jabatan_pelapor_detail" class="form-label">Jabatan</label>
                                <input type="text" name="jabatan_pelapor_detail" id="jabatan_pelapor_detail"
                                    class="form-control input-sm">
                            </div>
                            <div class="col-md-6 col-xs-12" id="" style="pointer-events: none; opacity: 0.5;">
                                <label for="direktorat_pelapor_detail" class="form-label">Direktorat</label>
                                <input type="text" name="direktorat_pelapor_detail" id="direktorat_pelapor_detail"
                                    class="form-control input-sm">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4 col-xs-12" id="">
                                <label for="jenis_pemberian_detail">Jenis Penemberian</Title></label>
                            </div>
                        </div>

                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-2 col-xs-12">
                                <label for="gift" class="form-check-label mb-0">Gift</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberianDetail[]" id="giftDetail"
                                    value="gift" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="giftTextDetailContainer" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="giftTextDetail"
                                    name="giftTextDetail" class="form-control input-sm">
                            </div>
                        </div>

                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-2 col-xs-12">
                                <label for="entertainment" class="form-check-label mb-0">Entertainment</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberianDetail[]" id="entertainmentDetail"
                                    value="entertainment" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="entertainmentTextDetailContainer" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="entertainmentTextDetail"
                                    name="entertainmentTextDetail" class="form-control input-sm">
                            </div>
                        </div>

                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-2 col-xs-12">
                                <label for="other" class="form-check-label mb-0">Other</label>
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <input type="checkbox" name="jenisPemberianDetail[]" id="otherDetail"
                                    value="other" class="form-check-input">
                            </div>
                            <div class="col-md-9 col-xs-12" id="otherTextDetailContainer" style="pointer-events: none; opacity: 0;">
                                <input type="text" id="otherTextDetail"
                                    name="otherTextDetail" class="form-control input-sm">
                            </div>
                        </div>
                        <!-- 
                        <div class="row form-group"> -->
                        <!-- <div class="col-md-3 col-xs-12" id="">
                                <label for="persetujuan_sebelumnya" class="form-label">Persetujuan Sebelumnya: </label>
                                <div>
                                    <div>
                                        <div class="d-flex align-items-center toggle-radio" data-style="square">
                                            <input type="radio" name="persetujuan_decision_detail" id="ada1_detail" value="ada" checked>
                                            <label for="ada1_detail" class="form-check-label px-4">Ada </label>

                                            <input type="radio" name="persetujuan_decision_detail" id="tidak1_detail" value="tidak">
                                            <label for="tidak1_detail" class="form-check-label px-4">Tidak </label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        <!-- <div class="col-md-9 col-xs-12" id="insertFile_detail" style="display: block;">
                                <label for="file" class="form-label">Insert File</label>
                                <input type="file" name="file_detail" id="file_detail" class="form-control input-sm">
                            </div>

                            <div class="col-md-9 col-xs-12" id="alasan_detail" style="display: none;">
                                <label for="" class="control-label">Alasan </label>
                                <input type="text" name="alasan_detail" id="alasan_detail" class="form-control input-sm">
                            </div>

                        </div> -->

                        <div class="row form-group">
                            <!-- <div class="col-md-3 col-xs-12" id="">
                                <label for="detail_penerima_detail" class="form-label">Detail Penerima: </label>
                                <div>
                                    <div>
                                        <div class="d-flex align-items-center toggle-radio" data-style="square">
                                            <input type="radio" name="penerima_decision_detail" id="sama2_detail" value="sama" checked>
                                            <label for="sama2_detail" class="form-check-label px-4">Sama </label>

                                            <input type="radio" name="penerima_decision_detail" id="tidak2_detail" value="tidak">
                                            <label for="tidak2_detail" class="form-check-label px-4">Tidak </label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- Nama Penerima -->
                            <div class="col-md-4 col-xs-12" style="pointer-events: none; opacity: 0.5;" id="namaPenerima_detail">
                                <label for="" class="control-label">Nama Penerima </label>
                                <input type="text" name="nama_penerima_detail" id="nama_penerima_detail" class="form-control input-sm">
                            </div>

                            <!-- Perusahaan Penerima -->
                            <div class="col-md-4 col-xs-12" style="pointer-events: none; opacity: 0.5;" id="perusahaanPenerima_detail">
                                <label for="" class="control-label">Perusahaan Penerima </label>
                                <input type="text" name="perusahaan_penerima_detail" id="perusahaan_penerima_detail" class="form-control input-sm">
                            </div>

                            <!-- Tanggal Diberikan -->
                            <div class="col-md-4 col-xs-12" style="pointer-events: none; opacity: 0.5;" id="tanggalPenerima_detail">
                                <label for="" class="control-label">Tanggal Diberikan </label>
                                <input type="date" name="tanggal_diberikan_detail" id="tanggal_diberikan_detail" class="form-control input-sm">
                            </div>

                        </div>

                        <div class="row form-group">
                            <!-- <div class="col-md-3 col-xs-12" id="">
                                <label for="tanggal_diberikan" class="form-label">Tanggal Diberikan: </label>
                                <div>
                                    <div>
                                        <div class="d-flex align-items-center toggle-radio" data-style="square">
                                            <input type="radio" name="tanggal_decision_detail" id="sama3_detail" value="sama" checked>
                                            <label for="sama3_detail" class="form-check-label px-4">Sama </label>

                                            <input type="radio" name="tanggal_decision_detail" id="tidak3_detail" value="tidak" 3>
                                            <label for="tidak3_detail" class="form-check-label px-4">Tidak </label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-md-6 col-xs-12" style="pointer-events: none; opacity: 0.5;" id="tempatPenerima_detail">
                                <label for="" class="control-label">Tempat Diberikan</label>
                                <input type="text" name="tempat_diberikan_detail" id="tempat_diberikan_detail" class="form-control input-sm">
                            </div>

                            <div class="col-md-6 col-xs-12" style="pointer-events: none; opacity: 0.5;" id="tujuanPenerima_detail">
                                <label for="" class="control-label">Tujuan Diberikan</label>
                                <input type="text" name="tujuan_diberikan_detail" id="tujuan_diberikan_detail" class="form-control input-sm">
                            </div>

                        </div>

                        <div class="row form-group">
                            <!-- <div class="col-md-3 col-xs-12" id="">
                                <label for="tempat_diberikan" class="form-label">Tempat Diberikan: </label>
                                <div>
                                    <div>
                                        <div class="d-flex align-items-center toggle-radio" data-style="square">
                                            <input type="radio" name="tempat_decision_detail" id="sama4_detail" value="sama" checked>
                                            <label for="sama4_detail" class="form-check-label px-4">Sama </label>

                                            <input type="radio" name="tempat_decision_detail" id="tidak4_detail" value="tidak">
                                            <label for="tidak4_detail" class="form-check-label px-4">Tidak </label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-md-6 col-xs-12" style="pointer-events: none; opacity: 0.5;" id="estimasiBiaya_detail">
                                <label for="" class="control-label">Currency</label>
                                <select name="currency_detail" id="currency_detail" class="select2">
                                    <option value="">Currency</option>
                                    <?php
                                    $getCurrency = $dbeta->query("SELECT * FROM currency");
                                    while ($currencyOption = $getCurrency->fetch_assoc()) {
                                        echo '<option value="' . $currencyOption['id'] . '"> ' . $currencyOption['nama_currency'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-xs-12" style="pointer-events: none; opacity: 0.5;" id="estimasiBiaya_detail">
                                <label for="" class="control-label">Estimasi Biaya</label>
                                <input type="text" name="estimasi_biaya_detail" id="estimasi_biaya_detail" class="form-control input-sm">
                            </div>

                        </div>

                        <!-- <hr style="border-top: 1px solid rgb(89, 87, 87);"> -->

                        <div class="row form-group" style="width: 103.5%;">
                            <div class="col-md-12 pt-3" style="margin-bottom: 1%; margin-top: 2%;">
                                <label for="softcopy" class="control-label fw-bolder mb-2" style="font-size: 20px;">
                                    <strong> Softcopy Dokumen Persetujuan Sebelumnya </strong>
                                </label>
                                <div id="table_invoices">
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
                        </div>

                        <!-- <hr style="border-top: 1px solid rgb(89, 87, 87);"> -->

                        <!-- <div class="row form-group">
                            <div class="col-md-3 col-xs-12" id="">
                                <label for="peserta_perusahaan" class="form-label">Peserta Perusahaan: </label>
                                <div>
                                    <div>
                                        <div class="d-flex align-items-center toggle-radio" data-style="square">
                                            <input type="radio" name="peserta_decision_detail" id="sama_detail" value="sama" checked>
                                            <label for="sama_detail" class="form-check-label px-4">Sama </label>

                                            <input type="radio" name="peserta_decision_detail" id="tidak_detail" value="tidak">
                                            <label for="tidak_detail" class="form-check-label px-4">Tidak </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-xs-12" id="alasanDetail" style="pointer-events: none; opacity: 0.5;">
                                <label for="" class="control-label">Alasan Tanpa File</label>
                                <input type="text" name="alasan_detail" id="alasan_detail" class="form-control input-sm">
                            </div>

                        </div> -->

                        <!-- <hr style="border-top: 1px solid rgb(89, 87, 87);"> -->

                        <div class="row form-group" style="width: 103.5%;">
                            <div class="col-md-12 pt-3" style="margin-bottom: 1%; margin-top: 2%;">
                                <div class="pesertaHeader" style="display: flex; justify-content:space-between;">
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

                        <!-- <hr style="border-top: 1px solid rgb(89, 87, 87);"> -->

                        <div class="row form-group" style="width: 103.5%;">
                            <div class="col-md-12 pt-3" style="margin-bottom: 1%; margin-top: 2%;">
                                <div class="approverHeader" style="display: flex; justify-content:space-between;">
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

    <!-- {{-- Modal Approve Notes --}} -->
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
                        <input type="hidden" id="approver_id" value="">

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

    <!-- {{-- Modal Reject Notes --}} -->
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
                        <input type="hidden" id="approver_id" value="">

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