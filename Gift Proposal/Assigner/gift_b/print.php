<?php
include "../../config.php";

$id = $_REQUEST['id'] ?? "";

// query untuk mengambil id pengajuan sebelumnya
$getDataPengajuan = "SELECT *
                        FROM pengajuan_form_b
                        WHERE id = '" . $id . "'";
$queDataPengajuan = $dbeta->query($getDataPengajuan);
$list = mysqli_fetch_assoc($queDataPengajuan);

$id_A = $list['id_pengajuan_a'];
// var_dump($id_A);


$getDataPengajuan_A = "SELECT *
                        FROM pengajuan_form_a
                        WHERE id = '" . $id_A . "'";
$queDataPengajuan_A = $dbeta->query($getDataPengajuan_A);
$list_A = mysqli_fetch_assoc($queDataPengajuan_A);
// var_dump($list_A);

$id_currency = $list['id_currency'];

$getDataCurrency = "SELECT *
                        FROM currency
                        WHERE id = '" . $id_currency . "'";
$queDataCurrency = $dbeta->query($getDataCurrency);
$currencyData = mysqli_fetch_assoc($queDataCurrency);

$getDataPeserta = "SELECT nama_peserta_perusahaan
                FROM peserta_b
                WHERE id_pengajuan_b = '" . $id . "'";
$queDataPeserta = $dbeta->query($getDataPeserta);
$DataPeserta = $queDataPeserta->fetch_all(MYSQLI_ASSOC);

$getDataPeserta_A = "SELECT nama_peserta_perusahaan 
                FROM peserta_a
                WHERE id_pengajuan_a = '" . $id_A . "'";
$queDataPeserta_A = $dbeta->query($getDataPeserta_A);
$DataPeserta_A = $queDataPeserta_A->fetch_all(MYSQLI_ASSOC);

// Ekstrak nama_peserta_perusahaan dari $DataPeserta
$namesPeserta = array_column($DataPeserta, 'nama_peserta_perusahaan');
// Ekstrak nama_peserta_perusahaan dari $DataPeserta_A
$namesPeserta_A = array_column($DataPeserta_A, 'nama_peserta_perusahaan');

// Urutkan kedua array untuk memastikan perbandingan yang akurat
sort($namesPeserta);
sort($namesPeserta_A);

$getDataDirektoratPeserta = "SELECT nama_peserta_perusahaan, direktorat_peserta_perusahaan 
                FROM peserta_b
                WHERE id_pengajuan_b = '" . $id . "'";
$queDataDirektoratPeserta = $dbeta->query($getDataDirektoratPeserta);
$DataDirektoratPeserta = $queDataDirektoratPeserta->fetch_all(MYSQLI_ASSOC);

// Sort data by 'nama_peserta_perusahaan' in ascending order
usort($DataDirektoratPeserta, function ($a, $b) {
    return strcmp($a['nama_peserta_perusahaan'], $b['nama_peserta_perusahaan']);
});

// Array of 'direktorat_peserta_perusahaan' after sorting
$directoratesPeserta = array_column($DataDirektoratPeserta, 'direktorat_peserta_perusahaan');

$id_pelapor = $list['id_pelapor'];

$getManager = "SELECT *
                        FROM employee
                        WHERE id = '" . $id_pelapor . "'";
$queGetManager = $db->query($getManager);
$employeeData = mysqli_fetch_assoc($queGetManager);

$id_manager = $employeeData['manager_id'];

$getManagerStatus = "SELECT *
                        FROM approval_b
                        WHERE id_pengajuan_b = '" . $id . "' AND id_employee = '" . $id_manager . "'";
$queGetManagerStatus = $dbeta->query($getManagerStatus);
$employeeDataStatus = mysqli_fetch_assoc($queGetManagerStatus);

$getCCOStatus = "SELECT *
                        FROM approval_b
                        WHERE id_pengajuan_b = '" . $id . "' AND id_employee = '4'";
$queGetCCOStatus = $dbeta->query($getCCOStatus);
$employeeDataStatusCCO = mysqli_fetch_assoc($queGetCCOStatus);

$manager_status = $employeeDataStatus['approval_status_b'];
$cco_status = $employeeDataStatusCCO['approval_status_b'];
// Bandingkan kedua array
// if ($namesPeserta === $namesPeserta_A) {
//     $result = true;
// } else {
//     $result = false;
// }
?>
<style>
    @page {
        size: auto;
        margin: 5mm;
    }

    body {
        margin: 0mm 5mm 5mm 5mm;
    }

</style>

<div class="main-content container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading">

                    <body>
                        <table style="border-collapse: collapse;" width="100%">
							<tr>
								<td> <strong style="font-size: 20px;"> Formulir 1B </strong> </td>
							</tr>
							<tr>
								<td> <strong style="font-size: 20px;"> Realisasi Pemberian Hadiah/ Hiburan - Klasifikasi B </strong> </td>
							</tr>
							<tr>
								<td> (Ex-post Facto Report on Entertainment with Public Officials) </td>
							</tr>
						</table>

                        <table style="border: 1px solid black; padding-left: 5px;border-collapse: collapse;  margin-top: 15px;" width="100%">
                            <!-- <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="8"> Formulir 1B </td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="8"> Realisasi Pemberian Hadiah/ <br> Hiburan - Klasifikasi B </td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="8"> (Ex-post Facto Report on Entertainment with Public Officials) </td>
                            </tr> -->
                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="1">Tanggal Pelaporan/ <br>Reporting Date</td>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="3"><?php echo $list['tanggal_pelaporan']; ?></td>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="1">Nama Pelapor/ Reporter</td>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="3"><?php echo $list['nama_pelapor']; ?></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="1">Jabatan/ Position</td>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="3"><?php echo $list['jabatan_pelapor']; ?></td>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="1">Direktorat/ Directorate</td>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="3"><?php echo $list['direktorat_pelapor']; ?></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="3">Jenis Pelaporan/ <br>Subject of report</td>
                                <?php
                                if ($list['detail_pemberian_gift_b'] !== '-' && trim($list['detail_pemberian_gift_b']) !== '') {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; ">&#10003;</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; "></td>';
                                }
                                ?>

                                <?php
                                if (trim($list['detail_pemberian_gift_b']) !== '' && trim($list['detail_pemberian_gift_b'] !== '-')) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6">Gift: ' . $list['detail_pemberian_gift_b'] . '</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6">Gift: -</td>';
                                }
                                ?>
                            </tr>
                            <tr>
                                <?php
                                if ($list['detail_pemberian_entertainment_b'] !== '-' && trim($list['detail_pemberian_entertainment_b']) !== '') {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; ">&#10003;</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; "></td>';
                                }
                                ?>

                                <?php
                                if (trim($list['detail_pemberian_entertainment_b']) !== '' && trim($list['detail_pemberian_entertainment_b'] !== '-')) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6">Entertainment: ' . $list['detail_pemberian_entertainment_b'] . '</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6">Entertainment: -</td>';
                                }
                                ?>
                            </tr>
                            <tr>
                                <?php
                                if ($list['detail_pemberian_other_b'] !== '-' && trim($list['detail_pemberian_other_b']) !== '') {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; ">&#10003;</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px;"></td>';
                                }
                                ?>

                                <?php
                                if (trim($list['detail_pemberian_other_b']) !== '' && trim($list['detail_pemberian_other_b'] !== '-')) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6">Other: ' . $list['detail_pemberian_other_b'] . '</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6">Other: -</td>';
                                }
                                ?>
                            </tr>

                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="3">Persetujuan sebelumnya/ <br>Prior approval</td>
                                <?php
                                if ($list['id_lampiran'] !== '0') {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; ">&#10003;</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; "></td>';
                                }
                                ?>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="6">Ada / Yes (lampirkan salinan persetujuan/ copy to be attached)</td>
                            </tr>
                            <tr>
                                <?php
                                if ($list['id_lampiran'] == '0') {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="2" class="small-td" style="width: 30px; ">&#10003;</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="2"class="small-td" style="width: 30px; "></td>';
                                }
                                ?>

                                <td style="border: 1px solid black; padding-left: 5px;" colspan="6" rowspan="2">Tidak/ No. Alasan/ reason : <?php echo $list['alasan_tidak_ada_dokumen_persetujuan']; ?></td>
                            </tr>
                            <tr></tr>

                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="4">Detail penerima / <br>Recipient details</td>
                                <?php
                                if (trim($list['nama_penerima_b']) == trim($list_A['nama_penerima']) && trim($list['perusahaan_penerima_b']) == trim($list_A['perusahaan_penerima'])) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; ">&#10003;</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px;"></td>';
                                }
                                ?>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="6">Sama dengan formulir 1A/ Same as form 1A</td>
                            </tr>
                            <tr>
                                <?php
                                // Pastikan tetap menggunakan colspan yang sesuai dengan struktur tabel.
                                if (trim($list['nama_penerima_b']) !== trim($list_A['nama_penerima']) || trim($list['perusahaan_penerima_b']) !== trim($list_A['perusahaan_penerima'])) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px; width: 30px;" rowspan="3">&#10003;</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px; width: 30px;" rowspan="3"></td>';
                                }
                                ?>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="6">Tidak sama dengan formulir 1A/ Not the same as form 1A :</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="3" style="width: 100px;">Nama/ Name</td>
                                <?php
                                if (trim($list['nama_penerima_b']) !== trim($list_A['nama_penerima']) || trim($list['perusahaan_penerima_b']) !== trim($list_A['perusahaan_penerima'])) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="3">' . $list['nama_penerima_b'] . '</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="3">-</td>';
                                }
                                ?>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="3">Instansi/ Institution</td>
                                <?php
                                if (trim($list['nama_penerima_b']) !== trim($list_A['nama_penerima']) || trim($list['perusahaan_penerima_b']) !== trim($list_A['perusahaan_penerima'])) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="3">' . $list['perusahaan_penerima_b'] . '</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="3">-</td>';
                                }
                                ?>
                            </tr>

                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="3">Tanggal diberikan / <br>scheduled date</td>
                                <?php
                                if (trim($list['tanggal_diberikan_b']) == trim($list_A['tanggal_diberikan'])) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; ">&#10003;</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; "></td>';
                                }
                                ?>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="6">Sama dengan formulir 1A/ Same as form 1A</td>
                            </tr>
                            <tr>
                                <?php
                                if (trim($list['tanggal_diberikan_b']) !== trim($list_A['tanggal_diberikan'])) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="2" class="small-td" style="width: 30px; ">&#10003;</td>';
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6" rowspan="2">Tidak ada pengajuan atau ada perubahan dari pengajuan sebelumnya/ No prior application or changed from prior application ' . $list['tanggal_diberikan_b'] . '</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; "></td>';
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6" rowspan="2">Tidak ada pengajuan atau ada perubahan dari pengajuan sebelumnya/ No prior application or changed from prior application <br> ….................................</td>';
                                }
                                ?>

                            </tr>
                            <tr></tr>

                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="3">Tempat diberikan/ <br>scheduled venue</td>
                                <?php
                                if (trim($list['tempat_diberikan_b']) == trim($list_A['tempat_diberikan'])) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; ">&#10003;</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; "></td>';
                                }
                                ?>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="6">Sama dengan formulir 1A/ Same as form 1A</td>
                            </tr>
                            <tr>
                                <?php
                                if (trim($list['tempat_diberikan_b']) !== trim($list_A['tempat_diberikan'])) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="2" class="small-td" style="width: 30px; ">&#10003;</td>';
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6" rowspan="2">Tidak ada pengajuan atau ada perubahan dari pengajuan sebelumnya/ No prior application or changed from prior application ' . $list['tempat_diberikan_b'] . '</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="2" class="small-td" style="width: 30px; "></td>';
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6" rowspan="2">Tidak ada pengajuan atau ada perubahan dari pengajuan sebelumnya/ No prior application or changed from prior application <br> ….................................</td>';
                                }
                                ?>

                            </tr>
                            <tr></tr>

                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="3">Tujuan pemberian/ <br>purpose</td>
                                <?php
                                if (trim($list['tujuan_diberikan_b']) == trim($list_A['tujuan_pemberian'])) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; ">&#10003;</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; "></td>';
                                }
                                ?>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="6">Sama dengan formulir 1A/ Same as form 1A</td>
                            </tr>
                            <tr>
                                <?php
                                if (trim($list['tujuan_diberikan_b']) !== trim($list_A['tujuan_pemberian'])) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="2" class="small-td" style="width: 30px; ">&#10003;</td>';
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6" rowspan="2">Tidak ada pengajuan atau ada perubahan dari pengajuan sebelumnya/ No prior application or changed from prior application ' . $list['tujuan_diberikan_b'] . '</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1"  rowspan="2" class="small-td" style="width: 30px; "></td>';
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6" rowspan="2">Tidak ada pengajuan atau ada perubahan dari pengajuan sebelumnya/ No prior application or changed from prior application <br> ….................................</td>';
                                }
                                ?>

                            </tr>
                            <tr></tr>

                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="4">Biaya (per orang untuk <br>hiburan) / Expense (per person for entertainment)</td>
                                <?php
                                if (trim($list['estimasi_biaya_b']) == trim($list_A['estimasi_biaya']) && trim($list['id_currency']) == trim($list_A['id_currency'])) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; ">&#10003;</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; "></td>';
                                }
                                ?>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="6">Sama dengan formulir 1A/ Same as form 1A</td>
                            </tr>
                            <tr>
                                <?php
                                if (trim($list['estimasi_biaya_b']) !== trim($list_A['estimasi_biaya']) || trim($list['id_currency']) !== trim($list_A['id_currency'])) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="3" class="small-td" style="width: 30px; ">&#10003;</td>';
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6" rowspan="3">Tidak ada pengajuan atau ada perubahan dari pengajuan sebelumnya/ No prior application or changed from prior application <br>' . $currencyData['nama_currency'] .' '. $list['estimasi_biaya_b'] . ' <br>Harap bukti-bukti dilampirkan/ evidence documents shall be attached</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="3" class="small-td" style="width: 30px; "></td>';
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="6" rowspan="3">Tidak ada pengajuan atau ada perubahan dari pengajuan sebelumnya/ No prior application or changed from prior application <br> …................................. <br>Harap bukti-bukti dilampirkan/ evidence documents shall be attached</td>';
                                }
                                ?>

                            </tr>
                            <tr></tr>
                            <tr></tr>

                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="4">Peserta dari perusahaan/ <br>participants from the<br> company </td>
                                <?php
                                if ($namesPeserta === $namesPeserta_A) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; ">&#10003;</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" class="small-td" style="width: 30px; "></td>';
                                }
                                ?>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="6">Sama dengan formulir 1A/ Same as form 1A</td>
                            </tr>
                            <tr>
                                <?php
                                if ($namesPeserta !== $namesPeserta_A) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="3" class="small-td" style="width: 30px; ">&#10003;</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="1" rowspan="3" class="small-td" style="width: 30px; "></td>';
                                }
                                ?>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="6">Tidak ada pengajuan atau ada perubahan dari pengajuan sebelumnya/ <br>No prior application or changed from prior application</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="3">Nama/ Name</td>
                                <?php
                                if ($namesPeserta !== $namesPeserta_A) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="3">' . implode(', ', $namesPeserta) . '</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="3">-</td>';
                                }
                                ?>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; padding-left: 5px;" colspan="3">Direktorat/ Directorate</td>
                                <?php
                                if ($namesPeserta !== $namesPeserta_A) {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="3">' . implode(', ', $directoratesPeserta) . '</td>';
                                } else {
                                    echo '<td style="border: 1px solid black; padding-left: 5px;" colspan="3">-</td>';
                                }
                                ?>
                            </tr>

                            <!-- TTD -->
                            <table style="border-collapse: collapse; margin-top: 15px;" width="100%">
                                <tr>
                                    <td colspan="2" style="border: 1px solid black; padding-left: 5px; text-align: center">Diajukan oleh/ Proposed by</td>
                                    <td colspan="2" style="border: 1px solid black; padding-left: 5px; text-align: center">Diketahui oleh/ Acknowledged by</td>
                                    <td colspan="2" style="border: 1px solid black; padding-left: 5px; text-align: center">Disetujui oleh/ Approved by</td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="border: 1px solid black; padding-left: 5px; height: 100px; text-align: center;"><img src="../../assets/img/check.png" height="100%" alt="" title="" class="img-small"></td>
                                    <?php
                                    if ($manager_status == 'Approved') {
                                        echo '<td colspan="2" style="border: 1px solid black; padding-left: 5px; height: 100px; text-align: center;"><img src="../../assets/img/check.png" height="100%" alt="" title="" class="img-small"></td>';
                                    } else {
                                        echo '<td colspan="2" style="border: 1px solid black; padding-left: 5px; height: 100px; text-align: center;"></td>';
                                    }
                                    ?>
                                    <?php
                                    if ($cco_status == 'Approved') {
                                        echo '<td colspan="2" style="border: 1px solid black; padding-left: 5px; height: 100px; text-align: center;"><img src="../../assets/img/check.png" height="100%" alt="" title="" class="img-small"></td>';
                                    } else {
                                        echo '<td colspan="2" style="border: 1px solid black; padding-left: 5px; height: 100px; text-align: center;"></td>';
                                    }
                                    ?>
                                </tr>

                                <tr>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px; width: 75px; text-align: center;"> Nama/ <br> Name</td>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['nama_pelapor']; ?></td>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px; width: 75px; text-align: center;"> Nama/ <br> Name</td>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $employeeDataStatus['approver_name_b']; ?></td>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px; width: 75px; text-align: center;"> Nama/ <br> Name</td>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $employeeDataStatusCCO['approver_name_b']; ?></td>
                                </tr>

                                <tr>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px; width: 75px; text-align: center;"> Jabatan/ <br> Position</td>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['jabatan_pelapor']; ?></td>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px; width: 75px; text-align: center;"> Jabatan/ <br> Position</td>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $employeeDataStatus['approver_jabatan_b']; ?></td>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px; width: 75px; text-align: center;"> Jabatan/ <br> Position</td>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $employeeDataStatusCCO['approver_jabatan_b']; ?></td>
                                </tr>

                                <tr>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px; width: 75px; text-align: center;"> Tanggal/ <br> Date</td>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['tanggal_pelaporan']; ?></td>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px; width: 75px; text-align: center;"> Tanggal/ <br> Date</td>
                                    <?php
                                    if ($employeeDataStatus['tanggal_approval_b'] == '0000-00-00') {
                                        echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;"></td>';
                                    } else if ($employeeDataStatus['tanggal_approval_b'] !== '0000-00-00') {
                                        echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;">' . $employeeDataStatus['tanggal_approval_b'] . '</td>';
                                    }
                                    ?>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px; width: 75px; text-align: center;"> Tanggal/ <br> Date</td>
                                    <?php
                                    if ($employeeDataStatus['tanggal_approval_b'] == '0000-00-00') {
                                        echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;"></td>';
                                    } else if ($employeeDataStatus['tanggal_approval_b'] !== '0000-00-00') {
                                        echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;">' . $employeeDataStatusCCO['tanggal_approval_b'] . '</td>';
                                    }
                                    ?>
                                </tr>

                            </table>
                            <!-- Komentar CCO / CCO's comment -->
                            <table style="border-collapse: collapse; margin-top: 30px;" width="100%">
                                <tr>
                                    <td colspan="1" style="border: 1px solid black; padding-left: 5px;">Komentar CCO / CCO's comment</td>
                                </tr>
                                <tr>
                                    <?php
                                    if ($employeeDataStatusCCO['notes_b'] == 'Coming Soon') {
                                        echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px; height: 100px"></td>';
                                    } else if ($employeeDataStatusCCO['notes_b'] !== 'Coming Soon') {
                                        echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px; height: 100px">' . $employeeDataStatusCCO['notes_b'] . '</td>';
                                    }
                                    ?>
                                </tr>
                            </table>
                        </table>
                    </body>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    window.print();
</script>