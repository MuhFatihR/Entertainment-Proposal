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

    <!-- Modal Add -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAdd" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-lg" id="modalAddSize">
            <div class="modal-content d-flex">
                <div class="modal-header" style="display: flex">
                    <h4 class="modal-title"> <strong> Add New Parcel </strong> </h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close" style="margin-left: 84.5%;"><span class="mdi mdi-close"></span></button>
                </div>

                <div class="modal-body">
                    <div class="py-2 d-flex justify-content-between"></div>
                    <form action="" method="" id="reportAdd" autocomplete="off">
                        
                        <!-- Nama & Perusahaan Pengirim -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="">
                                <label for="" class="form-label">Nama Pengirim</label>
                                <input type="text" name="nama_pengirim" id="nama_pengirim"
                                    class="form-control form-control-sm" placeholder="Input Nama Pengirim">
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="" class="form-label">Perusahaan Pengirim</label>
                                <input type="text" name="perusahaan_pengirim" id="perusahaan_pengirim"
                                    class="form-control form-control-sm" placeholder="Input Perusahaan Pengirim">
                            </div>
                        </div>

                        <!-- Nama & Department Penerima -->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="shareField1">
                                <label for="" class="control-label">Nama Penerima</label>
                                <select name="nama_penerima" id="nama_penerima" class="form-control select2" data-placeholder="Select Nama Penerima">
                                    <option value=""></option>
                                    <?php
                                    $getPenerima = $db->query("SELECT id, full_name, department_id, company_id
                                                                FROM employee 
                                                                WHERE active = '1'
                                                                ORDER BY full_name ASC");
                                    while ($penerima = $getPenerima->fetch_assoc()) {
                                        echo '<option value="' . $penerima['id'] . '"  data-department="' . $penerima['department_id'] . '" data-pt="' . $penerima['company_id'] . '">' . $penerima['full_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-xs-12" id="shareField2">
                                <label for="" class="control-label">Department Penerima</label>
                                <select name="department_penerima" id="department_penerima" class="form-control select2" data-placeholder="Select Department Penerima">
                                    <option value=""></option>
                                    <?php
                                    $getDepartment = $db->query("SELECT id, name
                                                                FROM department
                                                                ORDER BY name ASC");
                                    while ($department = $getDepartment->fetch_assoc()) {
                                        echo '<option value="' . $department['id'] . '">' . $department['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- PT Penerima & Banyak Parcel-->
                        <div class="row form-group">
                            <div class="col-md-6 col-xs-12" id="shareField2">
                                <label for="pt_penerima" class="control-label">PT Penerima</label>
                                <select name="pt_penerima" id="pt_penerima" class="form-control select2" data-placeholder="Select PT Penerima">
                                    <option value=""></option>
                                    <?php
                                    $getPt = $db->query("SELECT id, name
                                                            FROM company");
                                    while ($pt = $getPt->fetch_assoc()) {
                                        echo '<option value="' . $pt['id'] . '">' . $pt['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="" class="form-label">Banyak Parcel</label>
                                <input type="text" name="banyak_parcel" id="banyak_parcel"
                                    class="form-control form-control-sm" placeholder="Input Banyak Parcel">
                            </div>
                        </div>

                        <!-- Estimasi Nominal & Source -->
                        <div class="row form-group">
                            <div class="col-md-2 col-xs-12" id="">
                                <label for="currency" class="control-label">Currency</label>
                                <select name="currency" id="currency" class="form-control select2">
                                    <option value=""></option>
                                    <?php
                                    $getCurrency = $dbeta->query("SELECT id, nama_currency 
                                                                FROM currency");
                                    while ($currency = $getCurrency->fetch_assoc()) {
                                        echo '<option value="' . $currency['id'] . '">' . $currency['nama_currency'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4 col-xs-12" id="">
                                <label for="estimasi_nominal" class="control-label">Estimasi Nominal</label>
                                <input type="text" name="estimasi_nominal" id="estimasi_nominal" class="form-control" placeholder="Input Estimasi Nominal">
                            </div>


                            <div class="col-md-6 col-xs-12" id="">
                                <label for="" class="form-label">Source Info Nominal</label>
                                <input type="text" name="source_info_nominal" id="source_info_nominal"
                                    class="form-control form-control-sm" placeholder="Input Source Info Nominal">
                            </div>
                        </div>

                        <!-- Insert File -->
                        <div class="row form-group">
                            <div class="col-md-12 col-xs-12">
                                <label for="file" class="form-label">Insert File</label>
                                <input type="file" name="file" id="file"
                                    class="form-control form-control-sm">
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
                    <h4 class="modal-title"> Detail Parcel - <span id="no_parcel_detail"></span>
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </h4>
                </div>

                <div class="modal-body">
                    <form action="" method="" id="reportDetail" autocomplete="off">
                        <input type="hidden" id="id" name="id" value="">

                        <!-- Nama & Perusahaan Pengirim -->
                        <div class="row form-group" id="row1">
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
                        <div class="row form-group" id="row2">
                            <div class="col-md-6 col-xs-12">
                                <label for="nama_penerima_detail" class="control-label">Nama Penerima</label>
                                <select name="nama_penerima_detail" id="nama_penerima_detail" class="form-control select2" data-placeholder="Select Nama Penerima">
                                    <option value="-"> Empty </option>
                                    <?php
                                    $getPenerima = $db->query("SELECT id, full_name, department_id, company_id
                                                                FROM employee 
                                                                WHERE active = '1'
                                                                ORDER BY full_name ASC");
                                    while ($penerima = $getPenerima->fetch_assoc()) {
                                        echo '<option value="' . $penerima['id'] . '"  data-department="' . $penerima['department_id'] . '" data-pt="' . $penerima['company_id'] . '">' . $penerima['full_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-xs-12">
                                <label for="department_penerima_detail" class="control-label">Department Penerima</label>
                                <select name="department_penerima_detail" id="department_penerima_detail" class="form-control select2" data-placeholder="Select Department Penerima">
                                    <option value="-"> Empty </option>
                                    <?php
                                    $getDepartment = $db->query("SELECT id, name
                                                                FROM department
                                                                ORDER BY name ASC");
                                    while ($department = $getDepartment->fetch_assoc()) {
                                        echo '<option value="' . $department['id'] . '">' . $department['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Jumlah & Status Parcel -->
                        <div class="row form-group" id="row3">
                            <div class="col-md-6 col-xs-12">
                                <label for="pt_penerima_detail" class="control-label">PT Penerima</label>
                                <select name="pt_penerima_detail" id="pt_penerima_detail" class="form-control select2" data-placeholder="Select PT Penerima">
                                    <option value="-"> Empty </option>
                                    <?php
                                    $getPt = $db->query("SELECT id, name
                                                            FROM company");
                                    while ($pt = $getPt->fetch_assoc()) {
                                        echo '<option value="' . $pt['id'] . '">' . $pt['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-xs-12" id="">
                                <label for="" class="form-label">Banyak Parcel</label>
                                <input type="text" name="banyak_parcel_detail" id="banyak_parcel_detail"
                                    class="form-control form-control-sm" placeholder="Input Banyak Parcel">
                            </div>
                        </div>


                        <!-- Currency, Estimasi Nominal & Source Info Nominal -->
                        <div class="row form-group" id="row4">
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
                        <div class="row form-group" >
                            <div class="col-md-6 col-xs-12" id="keputusanField">
                                <label for="keputusan_detail" class="form-label">Keputusan: </label>
                                <select name="keputusan_detail" id="keputusan_detail" class="select2" data-placeholder="Select Keputusan">
                                    <option value="TBA" selected disabled>TBA</option>
                                    <option value="Keep">Keep</option>
                                    <option value="Share">Share</option>
                                    <option value="Hold">Hold</option>
                                </select>
                            </div>

                            <div class="col-md-6 col-xs-12" style="pointer-events: none; opacity: 0.5;">
                                <label for="note_keputusan_detail" class="form-label">Note Keputusan </label>
                                <textarea name="note_keputusan_detail" id="note_keputusan_detail" class="form-control form-control-sm" rows="3"
                                    style="height: 50%;"></textarea>
                            </div>
                        </div>

                        <!-- Insert File -->
                        <div class="row form-group" style="width: 103.5%;">
                            <div class="col-md-12 pt-3" style="margin-bottom: 1%; margin-top: 2%;">
                                <label for="softcopy" class="control-label fw-bolder" style="font-size: 20px;">
                                    <strong> Softcopy Dokumen Parcel </strong>
                                </label>
                                <table id="fileTable" class="table table-sm table-bordered table-hover" style="width: 100%; border: 1px solid #dee2e6;">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">Filename</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listFile"> </tbody>
                                </table>
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