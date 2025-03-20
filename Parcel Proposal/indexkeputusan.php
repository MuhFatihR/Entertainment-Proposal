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
                                <label for="no_parcel_filter">Nomor Parcel</Title></label>
                                <input type="text" id="no_parcel_filter"
                                    name="no_parcel_filter" class="form-control input-sm"
                                    placeholder="Search Nomor Parcel" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs-mb-5">
                                <label for="nama_pengirim_filter">Nama Pengirim</Title></label>
                                <input type="text" id="nama_pengirim_filter"
                                    name="nama_pengirim_filter" class="form-control input-sm"
                                    placeholder="Search Nama Pengirim" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs-mb-5">
                                <label for="perusahaan_pengirim_filter">Perusahaan Pengirim</Title></label>
                                <input type="text" id="perusahaan_pengirim_filter"
                                    name="perusahaan_pengirim_filter" class="form-control input-sm"
                                    placeholder="Search Perusahaan Pengirim" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs">
                                <label for="nama_penerima_filter">Nama Penerima</Title></label>
                                <input type="text" id="nama_penerima_filter"
                                    name="nama_penerima_filter" class="form-control input-sm"
                                    placeholder="Search Nama Penerima" autocomplete="off">
                            </div>
                            
                        </div>

                        <!-- ROW 2 -->
                        <div class="form-group row">
                            <div class="col-sm-3 xs">
                                <label for="department_penerima_filter">Department Penerima</Title></label>
                                <input type="text" id="department_penerima_filter"
                                    name="department_penerima_filter" class="form-control input-sm"
                                    placeholder="Search Department Penerima" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs">
                                <label for="pt_penerima_filter">PT Penerima</Title></label>
                                <select name="pt_penerima_filter" id="pt_penerima_filter" class="select2" data-placeholder="Select PT Penerima">
                                    <option value="" disabled selected> </option>
                                    <option value="PT. Nusantara Compnet Integrator"> PT. Nusantara Compnet Integrator </option>
                                    <option value="PT. Inovasi Otomasi Teknologi"> PT. Inovasi Otomasi Teknologi </option>
                                    <option value="PT. Pro Sistimatika Automasi"> PT. Pro Sistimatika Automasi </option>
                                    <option value="PT. Sugi Jaya Teknologi"> PT. Sugi Jaya Teknologi </option>
                                    <option value="PT. Compnet Integrator Services"> PT. Compnet Integrator Services </option>
                                </select>
                            </div>
                            <div class="col-sm-3 xs-mb-5">
                                <label for="currency_filter">Currency</Title></label>
                                <select name="currency_filter" id="currency_filter" class="select2" data-placeholder="Select Currency">
                                    <option value="" disabled selected> </option>
                                    <option value="IDR"> IDR </option>
                                    <option value="USD"> USD </option>
                                    <option value="JPY"> JPY </option>
                                    <option value="SGD"> SGD </option>
                                </select>
                            </div>
                            <div class="col-sm-3 xs-mb-5">
                                <label for="estimasi_nominal_filter">Estimasi Nominal</Title></label>
                                <input type="text" id="estimasi_nominal_filter"
                                    name="estimasi_nominal_filter" class="form-control input-sm"
                                    placeholder="Search Estimal Nominal" autocomplete="off">
                            </div>
                        </div>

                        <!-- ROW 3 -->
                        <div class="form-group row">
                            <div class="col-sm-3 xs">
                                <label for="source_info_nominal_filter">Source Info Nominal</Title></label>
                                <input type="text" id="source_info_nominal_filter"
                                    name="source_info_nominal_filter" class="form-control input-sm"
                                    placeholder="Search Source Info Nominal" autocomplete="off">
                            </div>
                            <div class="col-sm-3 xs">
                                <label for="keputusan_filter">Keputusan</Title></label>
                                <select name="keputusan_filter" id="keputusan_filter" class="select2" data-placeholder="Select Keputusan">
                                    <option value="" disabled selected> </option>
                                    <option value="TBA"> TBA </option>
                                    <option value="Keep">Keep</option>
                                    <option value="Share">Share</option>
                                    <option value="Hold">Hold</option>
                                </select>
                            </div>
                            <div class="col-sm-1 xs">
                                <label for="clear">&nbsp;</label>
                                <button id="clear" name="clear" class="btn btn-space btn-default form-control input-sm" style="background-color: #6c757d; color: white;" type="clear">Clear</button>
                            </div>
                            <div class="col-sm-2 xs">
                                <label for="submit">&nbsp;</label>
                                <button id="submit" name="submit" class="btn btn-space btn-primary form-control input-sm" type="submit">Generate</button>
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
                                <th>Nomor Parcel</th>
                                <th>Nama Pengirim</th>
                                <th>Perusahaan Pengirim</th>
                                <th>Nama Penerima</th>
                                <th>Department Penerima</th>
                                <th>PT Penerima</th>
                                <th>Currency</th>
                                <th>Estimasi Nominal</th>
                                <th>Source Info Nominal</th>
                                <th>Keputusan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nomor Parcel</th>
                                <th>Nama Pengirim</th>
                                <th>Perusahaan Pengirim</th>
                                <th>Nama Penerima</th>
                                <th>Department Penerima</th>
                                <th>PT Penerima</th>
                                <th>Currency</th>
                                <th>Estimasi Nominal</th>
                                <th>Source Info Nominal</th>
                                <th>Keputusan</th>
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
                    <h4 class="modal-title">Detail Parcel - <span id="no_parcel_detail"></span>
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </h4>
                </div>

                <div class="modal-body">
                    <form action="" method="" id="reportDetail">
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="email" name="email" value="<?php echo $mydata['email'];?>">

                        <!-- Nama & Perusahaan Pengirim -->
                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="" class="form-label">Nama Pengirim</label>
                                <input type="text" name="nama_pengirim_detail" id="nama_pengirim_detail"
                                    class="form-control form-control-sm">
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="" class="form-label">Perusahaan Pengirim</label>
                                <input type="text" name="perusahaan_pengirim_detail" id="perusahaan_pengirim_detail"
                                    class="form-control form-control-sm">
                            </div>
                        </div>

                        <!-- Nama & Department Penerima -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" style="pointer-events: none; opacity: 0.5;">
                                <label for="" class="control-label">Nama Penerima </label>
                                <input type="text" name="perusahaan_pengirim_detail" id="perusahaan_pengirim_detail"
                                    class="form-control form-control-sm">
                            </div>

                            <div class="col-md-6 col-xs-12" style="pointer-events: none; opacity: 0.5;">
                                <label for="" class="control-label">Department Penerima </label>
                                <input type="text" name="department_penerima_detail" id="department_penerima_detail" class="form-control form-control-sm">
                            </div>

                        </div>

                        <!-- PT Penerima & Banyak Parcel -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" style="pointer-events: none; opacity: 0.5;">
                                <label for="pt_penerima_detail" class="control-label">PT Penerima</label>
                                <input type="text" name="pt_penerima_detail" id="pt_penerima_detail"
                                class="form-control form-control-sm">
                            </div>

                            <div class="col-md-6 col-xs-12" style="pointer-events: none; opacity: 0.5;">
                                <label for="" class="form-label">Banyak Parcel</label>
                                <input type="text" name="banyak_parcel_detail" id="banyak_parcel_detail"
                                    class="form-control form-control-sm" placeholder="Input Banyak Parcel">
                            </div>
                        </div>

                        <!-- Cuurency, Estimasi Nominal & Source Info Nominal -->
                        <div class="row form-group" style="pointer-events: none; opacity: 0.5;">
                            <div class="col-md-2 col-xs-12" id="">
                                <label for="" class="control-label">Currency</label>
                                <select name="currency_detail" id="currency_detail" class="select2" data-placeholder="Select Currency">
                                    <option value=""></option>
                                    <?php
                                    $getCurrency = $dbeta->query("SELECT id, nama_currency 
                                                                FROM currency ");
                                    while ($currency = $getCurrency->fetch_assoc()) {
                                        echo '<option value="' . $currency['id'] . '">  ' . $currency['nama_currency'] . ' </option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4 col-xs-12" id="">
                                <label for="" class="control-label">Estimasi Nominal</label>
                                <input type="text" name="estimasi_nominal_detail" id="estimasi_nominal_detail"
                                    class="form-control form-control-sm">
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="" class="form-label">Source Info Nominal</label>
                                <input type="text" name="source_info_nominal_detail" id="source_info_nominal_detail"
                                    class="form-control form-control-sm">
                            </div>
                        </div>

                        <!-- Keputusan & Note Keputusan -->
                        <div class="row form-group" id="keputusanCCO">
                            <div class="col-md-6 col-xs-12">
                                <label for="keputusan_detail" class="form-label">Keputusan: </label>
                                <select name="keputusan_detail" id="keputusan_detail" class="select2" data-placeholder="Select Keputusan">
                                    <option value="TBA" selected disabled>TBA</option>
                                    <option value="Keep">Keep</option>
                                    <option value="Share">Share</option>
                                    <option value="Hold">Hold</option>
                                </select>
                            </div>

                            <div class="col-md-6 col-xs-12">
                                <label for="note_keputusan_detail" class="form-label">Note Keputusan </label>
                                <textarea name="note_keputusan_detail" id="note_keputusan_detail" class="form-control form-control-sm" rows="3"
                                    style="height: 50%;"></textarea>
                            </div>
                        </div>

                        <!-- Insert File -->
                        <div class="row form-group" style="width: 103.5%;">
                            <div class="col-md-12 pt-3" style="margin-bottom: 1%; margin-top: 2%;">
                                <label for="softcopy" class="control-label fw-bolder mb-2" style="font-size: 20px;">
                                    <strong> Softcopy Dokumen Parcel </strong>
                                </label>
                                <!-- <div id="table_invoices" style=""> -->
                                <table id="fileTable" class="table table-sm table-bordered table-hover" style="width: 100%; border: 1px solid #dee2e6;">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">Filename</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listFile"> </tbody>
                                </table>
                                <!-- </div> -->
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="btnSaveEdit" style="font-size: 1.5rem; padding: 0.25rem 1.5rem;">Save</button>
                </div>
            </div>
        </div>
    </div>

</div>