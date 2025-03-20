<?php
include "../../config.php";

$id = $_REQUEST['id'];

// $nama_pengusul = $_REQUEST['nama_pelapor_detail'];
// $jabatan_pengusul = $_REQUEST['jabatan_pelapor_detail'];
// $direktorat_pengusul = $_REQUEST['direktorat_pelapor_detail'];
// $tanggal_pengajuan = $_REQUEST['tanggal_palaporan_detail'];
// $no_revisi_detail = $_REQUEST['no_revisi_detail'];

$jenisPemberian = $_REQUEST['jenisPemberianDetail'] ?? [];
$giftText = $_REQUEST['giftTextDetail'];
$entertainmentText = $_REQUEST['entertainmentTextDetail'];
$otherText = $_REQUEST['otherTextDetail'];

$nama_penerima = $_REQUEST['nama_penerima_detail'];
$perusahaan_penerima = $_REQUEST['perusahaan_penerima_detail'];
$tanggal_diberikan = $_REQUEST['tanggal_diberikan_detail'];
$tempat_diberikan = $_REQUEST['tempat_diberikan_detail'];
$tujuan_pemberian = $_REQUEST['tujuan_diberikan_detail'];
// $alasan_tanpa_file = $_REQUEST['alasan_detail'];

$currency = $_REQUEST['currency_detail'];
$estimasi_biaya = $_REQUEST['estimasi_biaya_detail'];

$target_dir = "../../fileGift/";
// $files = $_REQUEST['fileInputDetail'] ?? [];
// var_dump($files);

// $getNamaPengusul = "SELECT id, full_name, manager_id
//                             FROM employee
//                             WHERE id = '" . $nama_pengusul . "'";
// $queNamaPengusul = $db->query($getNamaPengusul);
// $result = $queNamaPengusul->fetch_assoc();

// $full_name = $result['full_name'];

$textPemberian = [];
foreach ($jenisPemberian as $jenis) {
    if ($jenis === 'gift') {
        $textPemberian[] = 'Gift';
    } elseif ($jenis === 'entertainment') {
        $textPemberian[] = 'Entertainment';
    } elseif ($jenis === 'other') {
        $textPemberian[] = 'Other';
    }
}
$jenisPemberianAll = implode(', ', $textPemberian);

$tahun = date('y'); // 'y' untuk 2 digit terakhir tahun
$bulan = date('m');

// if ($nama_pengusul) {
//     $set[] = "id_pelapor = '" . $nama_pengusul . "'";
// }
// if ($full_name) {
//     $set[] = "nama_pelapor = '" . $full_name . "'";
// }
// if ($jabatan_pengusul) {
//     $set[] = "jabatan_pelapor = '" . $jabatan_pengusul . "'";
// }
// if ($direktorat_pengusul) {
//     $set[] = "direktorat_pelapor = '" . $direktorat_pengusul . "'";
// }
// if ($tanggal_pengajuan) {
//     $set[] = "tanggal_pelaporan = '" . $tanggal_pengajuan . "'";
// }

if ($jenisPemberianAll) {
    $set[] = "jenis_pemberian_b = '" . $jenisPemberianAll . "'";
}
if ($giftText) {
    $set[] = "detail_pemberian_gift_b = '" . $giftText . "'";
} else {
    $set[] = "detail_pemberian_gift_b = ''";
}
if ($entertainmentText) {
    $set[] = "detail_pemberian_entertainment_b = '" . $entertainmentText . "'";
} else {
    $set[] = "detail_pemberian_entertainment_b = ''";
}
if ($otherText) {
    $set[] = "detail_pemberian_other_b = '" . $otherText . "'";
} else {
    $set[] = "detail_pemberian_other_b = ''";
}

if ($nama_penerima) {
    $set[] = "nama_penerima_b = '" . $nama_penerima . "'";
}
if ($perusahaan_penerima) {
    $set[] = "perusahaan_penerima_b = '" . $perusahaan_penerima . "'";
}
if ($tanggal_diberikan) {
    $set[] = "tanggal_diberikan_b = '" . $tanggal_diberikan . "'";
}
if ($tempat_diberikan) {
    $set[] = "tempat_diberikan_b = '" . $tempat_diberikan . "'";
}
if ($tujuan_pemberian) {
    $set[] = "tujuan_diberikan_b = '" . $tujuan_pemberian . "'";
}

if ($currency) {
    $set[] = "id_currency = '" . $currency . "'";
}
if ($estimasi_biaya) {
    $set[] = "estimasi_biaya_b = '" . $estimasi_biaya . "'";
}

// if ($alasan_tanpa_file) {
//     $set[] = "alasan_tidak_ada_dokumen_persetujuan = '" . $alasan_tanpa_file . "'";
// }

$set = "SET " . implode(', ', $set);

$updateDataPengajuanA = "UPDATE pengajuan_form_b " . $set . " 
                                WHERE id = '" . $id . "'";
$quePengajuanFormA = $dbeta->query($updateDataPengajuanA);

// if (basename($_FILES["fileInputDetail"]["name"])) {
//     // var_dump($files);
//     $file = basename($_FILES["fileInputDetail"]["name"]);
//     $target_file = $target_dir . $file;
//     $set2[] = "file_name = '" . $file . "'";

//     if ($target_file) {
//         $set2[] = "path = '" . $target_file . "'";
//     }
//     $set2 = "SET " . implode(', ', $set2);

//     if (move_uploaded_file($_FILES["fileInputDetail"]["tmp_name"], $target_file)) {
//         $queryGetIdLampiran = "SELECT * FROM pengajuan_form_b WHERE id = '" . $id . "'";
//         $queGetIdLampiran = $dbeta->query($queryGetIdLampiran);
//         $resultGetIdLampiran = $queGetIdLampiran->fetch_assoc();

//         $id_lampiran = $resultGetIdLampiran['id_lampiran'];

//         $updateDataLampiran = "UPDATE form_a_lampiran " . $set2 . " 
//                             WHERE id = '" . $id_lampiran . "'";
//         // echo $updateDataLampiran;
//         $queDataLampiran = $dbeta->query($updateDataLampiran);
//     } else {
//         echo 'SALAH UPLOAD!';
//     }
// }

$queryGetApproverStatus = "SELECT * FROM approval_b WHERE id_pengajuan_b = '" . $id . "' AND approval_status_b = 'Rejected'";
$queGetApproverStatus = $dbeta->query($queryGetApproverStatus);
$resultGetApproverStatus = $queGetApproverStatus->fetch_assoc();

if ($resultGetApproverStatus) {
    $approver_id = $resultGetApproverStatus['id'];

    $updateStatusApprovalB = "UPDATE approval_b SET approval_status_b = 'Waiting Approval'
                            WHERE id = '" . $approver_id . "'";
    $queupdateStatusApprovalB = $dbeta->query($updateStatusApprovalB);

    $updateStatusPengajuanB = "UPDATE pengajuan_form_b SET status_approval_b = 'Waiting Approval'
                            WHERE id = '" . $id . "'";
    $queupdateStatusPengajuanB = $dbeta->query($updateStatusPengajuanB);
}

$output = array();

echo json_encode($output);
