<?php
include "../../config.php";
include "../../init_email.php";

$id_inputter = $_REQUEST['default_user_id'];
$nama_pengusul = $_REQUEST['nama_pengusul'];
$jabatan_pengusul = $_REQUEST['jabatan_pengusul'];
$direktorat_pengusul = $_REQUEST['direktorat_pengusul'];
$tanggal_pengajuan = $_REQUEST['tanggal_pengajuan'];

$jenisPemberian = $_REQUEST['jenisPemberian'] ?? [];
$giftText = $_REQUEST['giftText'];
$entertainmentText = $_REQUEST['entertainmentText'];
$otherText = $_REQUEST['otherText'];

$nama_penerima = $_REQUEST['nama_penerima'];
$perusahaan_penerima = $_REQUEST['perusahaan_penerima'];
$tanggal_diberikan = $_REQUEST['tanggal_diberikan'];
$tempat_diberikan = $_REQUEST['tempat_diberikan'];
$tujuan_pemberian = $_REQUEST['tujuan_pemberian'];

$currency = $_REQUEST['currency'];
$estimasi_biaya = $_REQUEST['estimasi_biaya'];
$tujuan_pemberian = $_REQUEST['tujuan_pemberian'];

$nama_peserta = $_REQUEST['nama_peserta'] ?? [];
$direktorat_peserta = $_REQUEST['direktorat_peserta'] ?? [];
$jenisapprovername = $_REQUEST['jenisapprovername'] ?? [];
$jenisapproveremail = $_REQUEST['jenisapproveremail'] ?? [];

$file = basename($_FILES["file"]["name"]) ?? [];
// var_dump($file);


if ($file) {    
    $target_dir = "../../fileGift/";
    $target_file = $target_dir . basename($file);

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0644);
    }
    $uploaded = move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

    if ($uploaded) {
        $insertLampiran = "INSERT INTO form_a_lampiran (file_name, path)
                                 VALUES ('" . $file . "', '" . $target_file . "')";
        $queLampiran = $dbeta->query($insertLampiran);
        $id_lampiran = $dbeta->insert_id;
    } else {
        echo 'SALAH UPLOAD!';
    }
} else if (!$file) {
    $id_lampiran = 0;
    // var_dump('tes');
}


// Validasi agar default value null == '-'
if ($giftText == '') {
    $giftText = '-';
}
if ($entertainmentText == '') {
    $entertainmentText = '-';
}
if ($otherText == '') {
    $otherText = '-';
}

// GET Nama Pengusul & Manager ID-nya
$getNamaPengusul = "SELECT id, full_name, manager_id, email
                            FROM employee
                            WHERE id = '" . $nama_pengusul . "'";
$queNamaPengusul = $db->query($getNamaPengusul);
$result = $queNamaPengusul->fetch_assoc();

$full_name = $result['full_name'];
$manager_id = $result['manager_id'];

// Validasi untuk field "JenisPemberianAll"
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

// GET Nomor Pengajuan (untuk pembuatan field "nomorPengajuan")
$sqlNomor = "SELECT nomor_pengajuan FROM pengajuan_form_a ORDER BY id DESC LIMIT 1";
$resultNomor = $dbeta->query($sqlNomor);

if ($resultNomor->num_rows > 0) {
    $row =  $resultNomor->fetch_assoc();
    $lastNomor = $row['nomor_pengajuan'];

    preg_match('/GA(\d{2})\d{2}(\d+)/', $lastNomor, $matches);
    $lastTahun = $matches[1];

    if ($lastTahun == $tahun) {
        $nomorUrut = (int)$matches[2] + 1; // Tambah 1 jika tahun sama
    } else {
        $nomorUrut = 1; // Reset ke 1 jika tahun berbeda
    }
} else {
    $nomorUrut = 1;
}
$nomorPengajuan = sprintf("GA%s%s%03d", $tahun, $bulan, $nomorUrut);


// INSERT INTO Pengajuan Form A
$insertPengajuanFormA = "INSERT INTO pengajuan_form_a (id_currency, id_nama_pengusul, nama_pengusul, jabatan_pengusul, direktorat_pengusul, tanggal_pengajuan, jenis_pemberian, jenis_pemberian_gift, jenis_pemberian_entertainment, jenis_pemberian_other, nama_penerima, perusahaan_penerima, tanggal_diberikan, tempat_diberikan, tujuan_pemberian, estimasi_biaya, status_pengajuan, nomor_pengajuan, used, id_lampiran, id_nama_inputter)
                                    VALUES ('" . $currency . "', '" . $nama_pengusul . "', '" . $full_name . "', '" . $jabatan_pengusul . "', '" . $direktorat_pengusul . "', '" . $tanggal_pengajuan . "', '" . $jenisPemberianAll . "', '" . $giftText . "', '" . $entertainmentText . "', '" . $otherText . "', '" . $nama_penerima . "', '" . $perusahaan_penerima . "', '" . $tanggal_diberikan . "', '" . $tempat_diberikan . "', '" . $tujuan_pemberian . "', '" . $estimasi_biaya . "', 'Waiting Approval', '" . $nomorPengajuan . "', '0', '" . $id_lampiran . "', '" . $id_inputter . "')";
$quePengajuanFormA = $dbeta->query($insertPengajuanFormA);
$idPengajuanFormA = $dbeta->insert_id;

if($nama_pengusul !== $id_inputter){
    $getNamaInputter = "SELECT id, full_name, email
                        FROM employee
                        WHERE id = '" . $id_inputter . "'";
    $queNamaInputter = $db->query($getNamaInputter);
    $resultInputter = $queNamaInputter->fetch_assoc();

    $nama_inputter = $resultInputter['full_name'];

    $to = 'muhammad.fatih@compnet.co.id';
    // $to = $result['email'];

    $cc = '';
    $bcc= '';

    $subject = 'Informasi Approval Pengajuan Gift A';

    $message = 'Dear Bapak/Ibu ' . $full_name . ',
                        <br><br>You have been assigned as a requestor by '. $nama_inputter .' on Gift A with the following details. <br><br>' .
                            '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                <tr style="width: 50%;">
                                    <td style="border: 1px solid #000;"><b>Nomor Pengajuan A</b></td>
                                    <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                </tr>
                                <tr style="width: 50%;">
                                    <td style="border: 1px solid #000;">' . $nomorPengajuan . '</td>
                                    <td style="border: 1px solid #000;">' . $full_name . '</td>
                                </tr>
                            </table>' . '<br><br>' .
                            'Thank you.';
            
    $attachment = [];
    // Kirim email
    kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);
}

// INSERT INTO Peserta A
$totalPeserta = count($nama_peserta);
if ($totalPeserta > 0) {
    $idPesertaString = implode("','", $nama_peserta); // Buat string ID peserta untuk digunakan dalam query IN()

    // Query untuk mengambil semua full_name berdasarkan ID peserta
    $getNamaPeserta = "SELECT 
                                id, full_name
                            FROM employee
                            WHERE id IN ('$idPesertaString')";
    $queNamaPeserta = $db->query($getNamaPeserta);

    $pesertaNames = []; // array untuk mapping ID ke full_name
    while ($row = $queNamaPeserta->fetch_assoc()) {
        $pesertaNames[$row['id']] = $row['full_name'];
    }

    $dataValues = [];
    for ($i = 0; $i < $totalPeserta; $i++) {
        $idPeserta = $nama_peserta[$i] ?? null;
        $direktorat = $direktorat_peserta[$i] ?? null;

        if (empty($idPeserta) || empty($direktorat)) {
            continue;
        }

        $fullName = $pesertaNames[$idPeserta] ?? '-';

        $dataValues[] = "('" . $idPengajuanFormA . "', '" . $idPeserta . "', '" . $fullName . "', '" . $direktorat . "', '0')";
    }

    if (!empty($dataValues)) {
        $insertValues = implode(',', $dataValues);
        $insertPesertaA = "INSERT INTO peserta_a (id_pengajuan_a, id_employee, nama_peserta_perusahaan, direktorat_peserta_perusahaan, has_updated)
                                    VALUES $insertValues";
        $queInsertPesertaA = $dbeta->query($insertPesertaA);
    }
}

// GET Data Manager
$getManager = "SELECT 
                    id, full_name, title, email
                FROM employee
                WHERE id = '" . $manager_id . "'";
$queManager = $db->query($getManager);
$resultManager = $queManager->fetch_assoc();

$managerName = $resultManager['full_name'];
$managerEmail = $resultManager['email'];
$managerTitle = $resultManager['title'];
$idManager = $resultManager['id'];

// INSERT INTO Approval A (Approver Next Level)
$insertApproverA = "INSERT INTO approval_a (id_pengajuan_a, id_employee, approver_name, approver_email, approver_level, approver_jabatan, notes, approval_status, tanggal_approval)
                                VALUES ('" . $idPengajuanFormA . "', '" . $idManager . "', '" . $managerName . "', '" . $managerEmail . "', '1', '" . $managerTitle . "', '-', 'Waiting Approval', '0000-00-00')";
$queApproverA = $dbeta->query($insertApproverA);

if($queApproverA){
    // $getEmailsQuery = "SELECT approver_email FROM approval_a WHERE id_pengajuan_a = '" . $idPengajuanFormA . "'";
    // $resultEmails = $dbeta->query($getEmailsQuery);

    // if ($resultEmails) {
    //     while ($row = $resultEmails->fetch_assoc()) {
    //         $email_approvers[] = $row['approver_email'];
    //         $name_approvers[] = $row['approver_name'];
    //     }
    // }
    
    // $to = implode(',', $email_approvers);
    // $to = "muhammad.fatih@compnet.co.id,ricky.krisdianto@compnet.co.id";
    // $email_test = [
    //     "muhammad.fatih@compnet.co.id",
    //     "ricky.krisdianto@compnet.co.id"
    // ];
    // $name_test = [
    //     "Muhammad Fatih Raharjo",
    //     "Ricky Krisdianto"
    // ];

    // $to = $managerEmail;

    $to = 'muhammad.fatih@compnet.co.id';

    $cc = '';
    $bcc= '';

    $subject = 'Informasi Approval Pengajuan Gift A';

    $message = 'Dear Bapak/Ibu ' . $managerName . ',<br><br>' .
                        'You have been registered as approver gift A with the following details.' . '<br><br>' .
                        '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                            <tr style="width: 50%;">
                                <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                            </tr>
                            <tr style="width: 50%;">
                                <td style="border: 1px solid #000;">' . $nomorPengajuan . '</td>
                                <td style="border: 1px solid #000;">' . $full_name . '</td>
                            </tr>
                        </table>' . '<br><br>' .
                        'Approval can be made through the following link:  <a href="https://apps.compnet.co.id/portalform/approval-gift-A/">Link Approval</a>.' . '<br><br><br>' .
                        'Thank you.';
    $attachment = [];
    // Kirim email
    kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);
}

// Get Data CCO
$getCCO = "SELECT 
                    id, full_name, title, email
                FROM employee
                WHERE id LIKE '4'
                AND active = '1'";
$queCCO = $db->query($getCCO);
$result = $queCCO->fetch_assoc();

// kirimemail_noreply_pcv($to, $subject, $teks_konfirmasi, $cc, $bcc);


$full_name = $result['full_name'];
$email = $result['email'];
$title = $result['title'];
$idCCO = $result['id'];

// INSERT INTO Approval A (Approver CCO)
$insertApproverA_CCO = "INSERT INTO approval_a (id_pengajuan_a, id_employee, approver_name, approver_email, approver_level, approver_jabatan, notes, approval_status, tanggal_approval)
                            VALUES ('" . $idPengajuanFormA . "', '" . $idCCO . "', '" . $full_name . "', '" . $email . "', '2', '" . $title . "', '-', 'Waiting Approval', '0000-00-00')";
$queApproverA_CCO = $dbeta->query($insertApproverA_CCO);

$output = array();

echo json_encode($output);
