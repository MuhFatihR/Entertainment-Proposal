<?php
include "../../config.php";

$id = $_REQUEST['id']; // ID PENGAJUAN

// $nama_pengusul = $_REQUEST['nama_pengusul_detail'];
// $jabatan_pengusul = $_REQUEST['jabatan_pengusul_detail'];
// $direktorat_pengusul = $_REQUEST['direktorat_pengusul_detail'];
// $tanggal_pengajuan = $_REQUEST['tanggal_pengajuan_detail'];

$jenisPemberian = $_REQUEST['jenisPemberian'] ?? [];
$giftText = $_REQUEST['giftText_detail'];
$entertainmentText = $_REQUEST['entertainmentText_detail'];
$otherText = $_REQUEST['otherText_detail'];

$nama_penerima = $_REQUEST['nama_penerima_detail'];
$perusahaan_penerima = $_REQUEST['perusahaan_penerima_detail'];
$tanggal_diberikan = $_REQUEST['tanggal_diberikan_detail'];
$tempat_diberikan = $_REQUEST['tempat_diberikan_detail'];
$tujuan_pemberian = $_REQUEST['tujuan_pemberian_detail'];

$currency = $_REQUEST['currency_detail'];
$estimasi_biaya = $_REQUEST['estimasi_biaya_detail'];
$tujuan_pemberian = $_REQUEST['tujuan_pemberian_detail'];

$target_dir = "../../fileGift/";


// GET Status Pengajuan
$getStatusAwal = "SELECT 
                        status_pengajuan  
                        FROM pengajuan_form_a WHERE id = '" . $id . "'";
$queStatusAwal = $dbeta->query($getStatusAwal);
$result = $queStatusAwal->fetch_assoc();
$statusPengajuan = $result['status_pengajuan'];

// Validasi untuk set jenis pemberian = '-', jika ga checked
$giftText = in_array('gift_detail', $jenisPemberian) ? $giftText : '-';
$entertainmentText = in_array('entertainment_detail', $jenisPemberian) ? $entertainmentText : '-';
$otherText = in_array('other_detail', $jenisPemberian) ? $otherText : '-';

// // GET Nama Pengusul
// $getNamaPengusul = "SELECT 
//                                 id, full_name, manager_id
//                             FROM employee
//                             WHERE id = '" . $nama_pengusul . "'";
// $queNamaPengusul = $db->query($getNamaPengusul);
// $result = $queNamaPengusul->fetch_assoc();
// $full_name = $result['full_name'];

// Validasi untuk field "JenisPemberianAll"
$textPemberian = [];
foreach ($jenisPemberian as $jenis) {
    if ($jenis == 'gift_detail') {
        $textPemberian[] = 'Gift';
    } elseif ($jenis == 'entertainment_detail') {
        $textPemberian[] = 'Entertainment';
    } elseif ($jenis == 'other_detail') {
        $textPemberian[] = 'Other';
    }
}
$jenisPemberianAll = implode(', ', $textPemberian);

$tahun = date('y'); // 'y' untuk 2 digit terakhir tahun
$bulan = date('m');

// if ($nama_pengusul) {
//     $set[] = "id_nama_pengusul = '" . $nama_pengusul . "'";
// }
// if ($full_name) {
//     $set[] = "nama_pengusul = '" . $full_name . "'";
// }
// if ($jabatan_pengusul) {
//     $set[] = "jabatan_pengusul = '" . $jabatan_pengusul . "'";
// }
// if ($direktorat_pengusul) {
//     $set[] = "direktorat_pengusul = '" . $direktorat_pengusul . "'";
// }
// if ($tanggal_pengajuan) {
//     $set[] = "tanggal_pengajuan = '" . $tanggal_pengajuan . "'";
// }

if ($jenisPemberianAll) {
    $set[] = "jenis_pemberian = '" . $jenisPemberianAll . "'";
}
if ($giftText) {
    $set[] = "jenis_pemberian_gift = '" . $giftText . "'";
}
if ($entertainmentText) {
    $set[] = "jenis_pemberian_entertainment = '" . $entertainmentText . "'";
}
if ($otherText) {
    $set[] = "jenis_pemberian_other = '" . $otherText . "'";
}
if ($nama_penerima) {
    $set[] = "nama_penerima = '" . $nama_penerima . "'";
}
if ($perusahaan_penerima) {
    $set[] = "perusahaan_penerima = '" . $perusahaan_penerima . "'";
}
if ($tanggal_diberikan) {
    $set[] = "tanggal_diberikan = '" . $tanggal_diberikan . "'";
}
if ($tempat_diberikan) {
    $set[] = "tempat_diberikan = '" . $tempat_diberikan . "'";
}
if ($tujuan_pemberian) {
    $set[] = "tujuan_pemberian = '" . $tujuan_pemberian . "'";
}
if ($currency) {
    $set[] = "id_currency = '" . $currency . "'";
}
if ($estimasi_biaya) {
    $set[] = "estimasi_biaya = '" . $estimasi_biaya . "'";
}
if ($tujuan_pemberian) {
    $set[] = "tujuan_pemberian = '" . $tujuan_pemberian . "'";
}

// only jika ada status_pengajuan "Rejected"
if ($statusPengajuan == 'Rejected') {
    $set[] = "status_pengajuan = 'Waiting Approval'";
}
$set = "SET " . implode(', ', $set);


// UPDATE PENGAJUAN
$updateDataPengajuanA = "UPDATE pengajuan_form_a " . $set . " 
                                WHERE id = '" . $id . "'";
$quePengajuanFormA = $dbeta->query($updateDataPengajuanA);

if (basename($_FILES["fileInputDetail"]["name"])) {
    // var_dump($files);
    $file = basename($_FILES["fileInputDetail"]["name"]);
    $target_file = $target_dir . $file;
    $set2[] = "file_name = '" . $file . "'";

    if ($target_file) {
        $set2[] = "path = '" . $target_file . "'";
    }
    $set2 = "SET " . implode(', ', $set2);

    if (move_uploaded_file($_FILES["fileInputDetail"]["tmp_name"], $target_file)) {
        $queryGetIdLampiran = "SELECT * FROM pengajuan_form_a WHERE id = '" . $id . "'";
        $queGetIdLampiran = $dbeta->query($queryGetIdLampiran);
        $resultGetIdLampiran = $queGetIdLampiran->fetch_assoc();

        $id_lampiran = $resultGetIdLampiran['id_lampiran'];

        $updateDataLampiran = "UPDATE form_a_lampiran " . $set2 . " 
                            WHERE id = '" . $id_lampiran . "'";
        // echo $updateDataLampiran;
        $queDataLampiran = $dbeta->query($updateDataLampiran);
    } else {
        echo 'SALAH UPLOAD!';
    }
}

// UPDATE STATUS APPROVER YANG REJECT
$updateStatus = "UPDATE approval_a
                        SET approval_status = 'Waiting Approval'
                        WHERE id_pengajuan_a = '" . $id . "' AND approval_status = 'Rejected'";
$queUpdateStatus = $dbeta->query($updateStatus);


$output = array();

echo json_encode($output);
