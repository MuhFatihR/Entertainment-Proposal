<?php
include "../../config.php";
include "../../init_email.php";

$id_inputter = $_REQUEST['default_user_id'];
$id_pengusul = $_REQUEST['nama_pelapor'];
$tanggal_pelaporan = $_REQUEST['tanggal_palaporan'];
$no_revisi = $_REQUEST['no_revisi'];
$jabatan_pelapor = $_REQUEST['jabatan_pelapor'];
$direktorat_pelapor = $_REQUEST['direktorat_pelapor'];
$id_currency = $_REQUEST['currencyAdd'];
$jenisPemberian = $_REQUEST['jenisPemberian'] ?? [];
$giftText = $_REQUEST['giftText'] ?? [];
$entertainmentText = $_REQUEST['entertainmentText'] ?? [];
$otherText = $_REQUEST['otherText'] ?? [];
$persetujuan_decision = $_REQUEST['persetujuan_decision'] ?? [];
$file = $_REQUEST['file'] ?? [];
$alasan = $_REQUEST['alasan'] ?? [];
$penerima_decision = $_REQUEST['penerima_decision'];
$nama_penerima = $_REQUEST['nama_penerima'] ?? [];
$perusahaan_penerima = $_REQUEST['perusahaan_penerima'] ?? [];
$tanggal_decision = $_REQUEST['tanggal_decision'];
$tanggal_diberikan = $_REQUEST['tanggal_diberikan'] ?? [];
$tempat_decision = $_REQUEST['tempat_decision'];
$tempat_diberikan = $_REQUEST['tempat_diberikan'] ?? [];
$tujuan_decision = $_REQUEST['tujuan_decision'];
$tujuan_diberikan = $_REQUEST['tujuan_diberikan'] ?? [];
$estimasi_decision = $_REQUEST['estimasi_decision'];
$estimasi_biaya = $_REQUEST['estimasi_biaya'] ?? [];
$peserta_decision = $_REQUEST['peserta_decision'];
$peserta_perusahaan = $_REQUEST['peserta_perusahaan'] ?? [];
$nama_peserta = $_REQUEST['nama_peserta_detail2'] ?? [];
$direktorat_peserta = $_REQUEST['direktorat_peserta_detail2'] ?? [];

$getNamaPengusul = "SELECT id, full_name, manager_id, email
                        FROM employee
                        WHERE id = '" . $id_pengusul . "'";
$queNamaPengusul = $db->query($getNamaPengusul);
$result = $queNamaPengusul->fetch_assoc();

$nama_pengusul = $result['full_name'];
$manager_id = $result['manager_id'];
$email_pengusul = $result['email'];
// $employee_email = $result['email'];

// var_dump('wlee');

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

$queryGetDataFormA = "SELECT * 
                        FROM pengajuan_form_a 
                        WHERE id = '" . $no_revisi . "' AND used = '0'";
$queGetDataFormA = $dbeta->query($queryGetDataFormA);
$resultDataFormA = $queGetDataFormA->fetch_assoc();

if($resultDataFormA['id_lampiran']){
    $id_lampiran_insert = $resultDataFormA['id_lampiran'];
    $nomor_pengajuan = $resultDataFormA['nomor_pengajuan'];
}else{
    $id_lampiran_insert = 0;
    $nomor_pengajuan = 0;
}

$id_lampiran = '-';

// $list_beda_peserta = '';

if ($persetujuan_decision == 'ada') {
    $target_dir = "../../fileGift/";
    $file = basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $file;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $insertLampiran = "INSERT INTO form_b_lampiran (file_name, path)
                                 VALUES ('" . $file . "', '" . $target_file . "')";
        $queLampiran = $dbeta->query($insertLampiran);
        $id_lampiran = $dbeta->insert_id;
    } else {
        echo 'SALAH UPLOAD!';
    }

    $alasan_tanpa_dokumen = '-';
} else if ($persetujuan_decision == 'tidak') {
    $alasan_tanpa_dokumen = $alasan;
}

if ($penerima_decision == 'sama') {
    $nama_penerima_insert = $resultDataFormA['nama_penerima'];
    $perusahaan_penerima_insert = $resultDataFormA['perusahaan_penerima'];
} else if ($penerima_decision == 'tidak') {
    $nama_penerima_insert = $nama_penerima;
    $perusahaan_penerima_insert = $perusahaan_penerima;
}

if ($tanggal_decision == 'sama') {
    $tanggal_diberikan_insert = $resultDataFormA['tanggal_diberikan'];
} else if ($tanggal_decision == 'tidak') {
    $tanggal_diberikan_insert = $tanggal_diberikan;
}

if ($tempat_decision == 'sama') {
    $tempat_diberikan_insert = $resultDataFormA['tempat_diberikan'];
} else if ($tempat_decision == 'tidak') {
    $tempat_diberikan_insert = $tempat_diberikan;
}

if ($tujuan_decision == 'sama') {
    $tujuan_diberikan_insert = $resultDataFormA['tujuan_pemberian'];
} else if ($tujuan_decision == 'tidak') {
    $tujuan_diberikan_insert = $tujuan_diberikan;
}

if ($estimasi_decision == 'sama') {
    $estimasi_biaya_insert = $resultDataFormA['estimasi_biaya'];
    $currency_insert = $resultDataFormA['id_currency'];
} else if ($estimasi_decision == 'tidak') {
    $estimasi_biaya_insert = $estimasi_biaya;
    $currency_insert = $id_currency;
}

// // INSERT INTO Pengajuan Form B
// $insertPengajuanFormB = "INSERT INTO pengajuan_form_b (id_pengajuan_a, id_lampiran, nama_pelapor, jabatan_pelapor, direktorat_pelapor, tanggal_pelaporan, jenis_pemberian_b, detail_pemberian_gift_b, detail_pemberian_entertainment_b, detail_pemberian_other_b, nama_penerima_b, perusahaan_penerima_b, tanggal_diberikan_b, tempat_diberikan_b, tujuan_diberikan_b, estimasi_biaya_b, status_approval_b, alasan_tidak_ada_dokumen_persetujuan, id_pelapor, id_currency)
//                                 VALUES ('" . $no_revisi . "', '" . $id_lampiran_insert . "', '" . $nama_pengusul . "', '" . $jabatan_pelapor . "', '" . $direktorat_pelapor . "', '" . $tanggal_pelaporan . "', '" . $jenisPemberianAll . "', '" . $giftText . "', '" . $entertainmentText . "', '" . $otherText . "', '" . $nama_penerima_insert . "', '" . $perusahaan_penerima_insert . "', '" . $tanggal_diberikan_insert . "', '" . $tempat_diberikan_insert . "', '" . $tujuan_diberikan_insert . "', '" . $estimasi_biaya_insert . "', 'Waiting Approval', '" . $alasan_tanpa_dokumen . "', '" . $id_pengusul . "', '" . $currency_insert . "')";
// $quePengajuanFormB = $dbeta->query($insertPengajuanFormB);
// $idPengajuanFormB = $dbeta->insert_id;

$tahun = date('y'); // 'y' untuk 2 digit terakhir tahun
$bulan = date('m');

// GET Nomor Pengajuan (untuk pembuatan field "nomorPengajuan")
$sqlNomor = "SELECT nomor_pengajuan_b FROM pengajuan_form_b ORDER BY id DESC LIMIT 1";
$resultNomor = $dbeta->query($sqlNomor);

if ($resultNomor->num_rows > 0) {
    $row =  $resultNomor->fetch_assoc();
    $lastNomor = $row['nomor_pengajuan_b'];

    preg_match('/GB(\d{2})\d{2}(\d+)/', $lastNomor, $matches);
    $lastTahun = $matches[1];

    if ($lastTahun == $tahun) {
        $nomorUrut = (int)$matches[2] + 1; // Tambah 1 jika tahun sama
    } else {
        $nomorUrut = 1; // Reset ke 1 jika tahun berbeda
    }
} else {
    $nomorUrut = 1;
}
$nomorPengajuan = sprintf("GB%s%s%03d", $tahun, $bulan, $nomorUrut);

$insertPengajuanFormB = "INSERT INTO pengajuan_form_b (id_pengajuan_a, id_lampiran, nama_pelapor, jabatan_pelapor, direktorat_pelapor, tanggal_pelaporan, jenis_pemberian_b, detail_pemberian_gift_b, detail_pemberian_entertainment_b, detail_pemberian_other_b, nama_penerima_b, perusahaan_penerima_b, tanggal_diberikan_b, tempat_diberikan_b, tujuan_diberikan_b, estimasi_biaya_b, status_approval_b, id_pelapor, id_currency, nomor_pengajuan_b, id_inputter)
                                VALUES ('" . $no_revisi . "', '" . $id_lampiran_insert . "', '" . $nama_pengusul . "', '" . $jabatan_pelapor . "', '" . $direktorat_pelapor . "', '" . $tanggal_pelaporan . "', '" . $jenisPemberianAll . "', '" . $giftText . "', '" . $entertainmentText . "', '" . $otherText . "', '" . $nama_penerima_insert . "', '" . $perusahaan_penerima_insert . "', '" . $tanggal_diberikan_insert . "', '" . $tempat_diberikan_insert . "', '" . $tujuan_diberikan_insert . "', '" . $estimasi_biaya_insert . "', 'Waiting Approval', '" . $id_pengusul . "', '" . $currency_insert . "', '" . $nomorPengajuan . "', '" . $id_inputter . "')";
$quePengajuanFormB = $dbeta->query($insertPengajuanFormB);
$idPengajuanFormB = $dbeta->insert_id;

if($id_pengusul !== $id_inputter){
    $getNamaInputter = "SELECT id, full_name, email
                        FROM employee
                        WHERE id = '" . $id_inputter . "'";
    $queNamaInputter = $db->query($getNamaInputter);
    $resultInputter = $queNamaInputter->fetch_assoc();

    $nama_inputter = $resultInputter['full_name'];
  
    $to = $email_pengusul;

        $cc = '';
        $bcc= '';

        $subject = 'Informasi Approval Pengajuan Gift B';

        $message = 'Dear Bapak/Ibu ' . $nama_pengusul . ',
                        <br><br>You have been assigned as a requestor by '. $nama_inputter .' on Gift B with the following details. <br><br>' .
                            '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                <tr style="width: 50%;">
                                    <td style="border: 1px solid #000;"><b>Nomor Pengajuan A</b></td>
                                    <td style="border: 1px solid #000;"><b>Nomor Pengajuan B</b></td>
                                    <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                </tr>
                                <tr style="width: 50%;">
                                    <td style="border: 1px solid #000;">' . $nomor_pengajuan . '</td>
                                    <td style="border: 1px solid #000;">' . $nomorPengajuan . '</td>
                                    <td style="border: 1px solid #000;">' . $nama_pengusul . '</td>
                                </tr>
                            </table>' . '<br><br>' .
                            'Thank you.';
    
    $attachment = [];
    // Kirim email
    kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);
}


// =========================================================================

if ($peserta_decision == 'sama') {
    $queryGetPesertaA = "SELECT * FROM peserta_a WHERE id_pengajuan_a = '" . $no_revisi . "'";
    $queGetPesertaA = $dbeta->query($queryGetPesertaA);
    $resultGetPesertaA = $queGetPesertaA->fetch_all(MYSQLI_ASSOC);

    foreach ($resultGetPesertaA as $row) {
        $id_employee = $row['id_employee'];
        $nama_peserta_perusahaan = $row['nama_peserta_perusahaan'];
        $direktorat_peserta_perusahaan = $row['direktorat_peserta_perusahaan'];

        // Query untuk memasukkan data ke peserta_b
        $queryInsertPesertaB = "INSERT INTO peserta_b (id_pengajuan_b, id_employee, nama_peserta_perusahaan, direktorat_peserta_perusahaan, has_updated) 
                                VALUES ('$idPengajuanFormB', '$id_employee', '$nama_peserta_perusahaan', '$direktorat_peserta_perusahaan', '0')";

        $quePengajuanFormB = $dbeta->query($queryInsertPesertaB);
    }
} else if ($peserta_decision == 'tidak') {

    $totalPeserta = count($nama_peserta);
    if ($totalPeserta > 0) {
        $idPesertaString = implode("','", $nama_peserta); // Buat string ID peserta untuk digunakan dalam query IN()

        // Query untuk mengambil semua full_name berdasarkan ID peserta
        $getNamaPeserta = "SELECT id, full_name
                            FROM employee
                            WHERE id IN ('$idPesertaString')";
        $queNamaPeserta = $db->query($getNamaPeserta);

        $pesertaNames = []; // array untuk mapping ID ke full_name
        while ($row = $queNamaPeserta->fetch_assoc()) {
            $pesertaNames[$row['id']] = $row['full_name'];
        }

        $dataValues = [];
        for ($i = 0; $i < $totalPeserta; $i++) {
            $idPeserta = $nama_peserta[$i] ?? '';
            $direktorat = $direktorat_peserta[$i] ?? '';
            $fullName = $pesertaNames[$idPeserta] ?? '';
            
            $dataValues[] = "('" . $idPengajuanFormB . "', '" . $idPeserta . "', '" . $fullName . "', '" . $direktorat . "', '0')";
        }

        // Gabungkan data untuk query insert
        $insertValues = implode(',', $dataValues);
        $insertPesertaA = "INSERT INTO peserta_b (id_pengajuan_b, id_employee, nama_peserta_perusahaan, direktorat_peserta_perusahaan, has_updated)
                            VALUES $insertValues";
        $queInsertPesertaA = $dbeta->query($insertPesertaA);

    }
}

$getManager = "SELECT id, full_name, title, email
                            FROM employee
                            WHERE id = '" . $manager_id . "'";
$queManager = $db->query($getManager);
$resultManager = $queManager->fetch_assoc();

$managerName = $resultManager['full_name'];
$managerTitle = $resultManager['title'];
$managerEmail = $resultManager['email'];

// INSERT INTO Approval A (Approver Next Level)
$insertApproverB = "INSERT INTO approval_b (id_pengajuan_b, approver_name_b, approver_level_b, approver_jabatan_b, notes_b, approval_status_b, id_employee, approver_email, tanggal_approval_b)
                            VALUES ('" . $idPengajuanFormB . "', '" . $managerName . "', '1', '" . $managerTitle . "', '-', 'Waiting Approval', '" . $manager_id . "', '" . $managerEmail . "', '0000-00-00')";
$queApproverB = $dbeta->query($insertApproverB);

$to = $managerEmail;

$cc = '';
$bcc= '';

$subject = 'Informasi Approval Pengajuan Gift B';

$message = 'Dear Bapak/Ibu ' . $managerName . ',<br><br>' .
                        'You have been registered as approver gift B with the following details.' . '<br><br>' .
                        '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                            <tr style="width: 50%;">
                                <td style="border: 1px solid #000;"><b>Nomor Pengajuan A</b></td>
                                <td style="border: 1px solid #000;"><b>Nomor Pengajuan B</b></td>
                                <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                            </tr>
                            <tr style="width: 50%;">
                                <td style="border: 1px solid #000;">' . $nomor_pengajuan . '</td>
                                <td style="border: 1px solid #000;">' . $nomorPengajuan . '</td>
                                <td style="border: 1px solid #000;">' . $nama_pengusul . '</td>
                            </tr>
                        </table>' . '<br><br>' .
                        'Approval can be made through the following link:  <a href="https://apps.compnet.co.id/portalform/approval-gift-A/">Link Approval</a>.' . '<br><br><br>' .
                        'Thank you.';

$attachment = [];
// Kirim email
kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);

$queGetCCO = "SELECT id, full_name, title, email
                    FROM employee
                    WHERE id LIKE '4'
                    AND active = '1'";
$queGetCCO = $db->query($queGetCCO);
$resultCCO = $queGetCCO->fetch_assoc();

$full_name_cco = $resultCCO['full_name'];
$title_cco = $resultCCO['title'];
$id_cco = $resultCCO['id'];
$email_cco = $resultCCO['email'];

// INSERT INTO Approval A (Approver CCO)
$insertApproverB_CCO = "INSERT INTO approval_b (id_pengajuan_b, approver_name_b, approver_level_b, approver_jabatan_b, notes_b, approval_status_b, id_employee, approver_email, tanggal_approval_b)
                            VALUES ('" . $idPengajuanFormB . "', '" . $full_name_cco . "', '2', '" . $title_cco . "', '-', 'Waiting Approval', '" . $id_cco . "', '" . $email_cco . "', '0000-00-00')";
$queApproverB_CCO = $dbeta->query($insertApproverB_CCO);


// update pengajuanA yang uda diambil (use > 1)
$getUpdate = "UPDATE pengajuan_form_a 
                SET used = '1'
                WHERE id = '" . $no_revisi . "'";
$queUpdateData = $dbeta->query($getUpdate);

$output = array();

echo json_encode($output);
