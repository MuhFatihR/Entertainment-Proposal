<?php
include "../../config.php";
include "../../init_email.php";

$approveNotes = $_REQUEST['approveNotes'] ?? "-"; // Pastikan sudah divalidasi
$id_approver = (int) $_REQUEST['id_approver']; // Pastikan ID adalah integer
$date = date('Y-m-d H:i:s');

// Update Status Approval (Approved)
$updateApproval = "UPDATE approval_a
                    SET approval_status = 'Approved', 
                        tanggal_approval = '" . $date . "', 
                        notes = '" . $approveNotes . "'
                    WHERE id = '" . $id_approver . "'";

if ($dbeta->query($updateApproval) === TRUE) {
    $output = ['status' => 'success', 'message' => 'Approval berhasil diperbarui.'];
} else {
    $output = ['status' => 'error', 'message' => 'Gagal memperbarui approval.', 'error' => $dbeta->error];
}

$queryGetApproverLevel = "SELECT * FROM approval_a WHERE id = " . $id_approver;
$queDataLevel = $dbeta->query($queryGetApproverLevel);
$dataLevel = $queDataLevel->fetch_assoc();

if($dataLevel){
    $approverLevel = $dataLevel['approver_level'];
    $nomorPengajuan = $dataLevel['id_pengajuan_a'];
    $approverLevelInt = intval($approverLevel);
    $nextApproverLevel = $approverLevelInt + 1;
}else{
    echo "Data approver dengan ID $id_approver tidak ditemukan.";
}

$queryGetNextApprover = "SELECT * FROM approval_a WHERE id_pengajuan_a = " . $nomorPengajuan . " AND approver_level = '" . $nextApproverLevel . "'";
$queDataNextLevel = $dbeta->query($queryGetNextApprover);
$dataNextLevel = $queDataNextLevel->fetch_assoc();

// $id_pengajuan_a = $dataNextLevel['id_pengajuan_a'];

$queryGetNomorPengajuan = "SELECT * FROM pengajuan_form_a WHERE id = " . $nomorPengajuan;
$queGetNomorPengajuan = $dbeta->query($queryGetNomorPengajuan);
$dataNomorPengajuan = $queGetNomorPengajuan->fetch_assoc();

if($dataNomorPengajuan){
    $id_assigner = $dataNomorPengajuan['id_nama_pengusul'];
    $name_assigner = $dataNomorPengajuan['nama_pengusul'];
    $id_inputter = $dataNomorPengajuan['id_nama_inputter'];
}

$queryEmailAssigner = "SELECT email FROM employee WHERE id = " . $id_assigner;
$queGetEmailAssigner = $db->query($queryEmailAssigner);
$dataEmailAssigner = $queGetEmailAssigner->fetch_assoc();

// var_dump($id_inputter);

$queryEmailInputter = "SELECT full_name, email FROM employee WHERE id = " . $id_inputter;
$queGetEmailInputter = $db->query($queryEmailInputter);
$dataEmailInputter = $queGetEmailInputter->fetch_assoc();

if($dataNextLevel){
    $nama_nextLevel = $dataNextLevel['approver_name'];
    $email_nextLevel = $dataNextLevel['approver_email'];

    $to = $email_nextLevel;

    $cc = '';
    $bcc= '';

    $subject = 'Informasi Approval Pengajuan Gift A';

    $message = 'Dear Bapak/Ibu ' . $nama_nextLevel . ',<br><br>' .
                        'You have been registered as approver gift A with the following details.' . '<br><br>' .
                        '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                            <tr style="width: 50%;">
                                <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                            </tr>
                            <tr style="width: 50%;">
                                <td style="border: 1px solid #000;">' . $dataNomorPengajuan['nomor_pengajuan'] . '</td>
                                <td style="border: 1px solid #000;">' . $name_assigner . '</td>
                            </tr>
                        </table>' . '<br><br>' .
                        'Approval can be made through the following link:  <a href="https://apps.compnet.co.id/portalform/approval-gift-A/">Link Approval</a>.' . '<br><br><br>' .
                        'Thank you.';
    
    $attachment = [];
    // Kirim email
    kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);

    if($dataEmailAssigner && $dataEmailInputter){

        $queryApproverManager = "SELECT * FROM approval_a WHERE id_pengajuan_a = " . $nomorPengajuan . " AND approver_level = '1'";
        $queApproverManager = $dbeta->query($queryApproverManager);
        $dataApproverManager = $queApproverManager->fetch_assoc();

        $manager_name = $dataApproverManager['approver_name'];

        // $emailAssigner = $dataEmailAssigner['email'];

        $to = 'muhammad.fatih@compnet.co.id';
        // $to = $dataEmailAssigner['email'];

        $cc = '';
        $bcc= '';

        $subject = 'Informasi Approval Pengajuan Gift A';

        $message = 'Dear Bapak/Ibu ' . $name_assigner . ',
                        <br><br>' . $manager_name . ' has approved gift A request with the following details. ' . '<br><br>' .
                            '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                <tr style="width: 50%;">
                                    <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                    <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                </tr>
                                <tr style="width: 50%;">
                                    <td style="border: 1px solid #000;">' . $dataNomorPengajuan['nomor_pengajuan'] . '</td>
                                    <td style="border: 1px solid #000;">' . $name_assigner . '</td>
                                </tr>
                            </table>' . '<br><br>' .
                            'Thank you.';

        $attachment = [];
        // Kirim email
        kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);

        // ======================================================================================================================================================== \\

        if($id_assigner !== $id_inputter){
            $to = $dataEmailInputter['email'];

            $cc = '';
            $bcc= '';

            $subject = 'Informasi Approval Pengajuan Gift A';

            $message = 'Dear Bapak/Ibu ' . $dataEmailInputter['full_name'] . ',
                            <br><br>' . $manager_name . ' has approved gift A request with the following details. ' . '<br><br>' .
                                '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                        <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                    </tr>
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;">' . $dataNomorPengajuan['nomor_pengajuan'] . '</td>
                                        <td style="border: 1px solid #000;">' . $name_assigner . '</td>
                                    </tr>
                                </table>' . '<br><br>' .
                                'Thank you.';
            
            $attachment = [];
            // Kirim email
            kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);
        }

    }
}

// Get id_pengajuan_a
$getDataApproval = "SELECT * 
                    FROM approval_a
                    WHERE id = '" . $id_approver . "'";
$queDataApproval = $dbeta->query($getDataApproval);
$dataApproval = $queDataApproval->fetch_assoc();

$idPengajuan = $dataApproval['id_pengajuan_a'];

// Get data approval_A (untuk pengecekan keselurah status)
$getDataStatus = "SELECT * 
                    FROM approval_a
                    WHERE id_pengajuan_a = " . $idPengajuan;
$queDataStatus = $dbeta->query($getDataStatus);

$allApproved = true;
foreach ($queDataStatus as $datastatus) {
    if ($datastatus['approval_status'] == 'Rejected' || $datastatus['approval_status'] == 'Waiting Approval') {
        $allApproved = false;
        break;
    }
}

// Cek 1 persatu pada "APPROVAL" jika semua sudah approved maka status pada "PENGAJUAN" = Approved
if ($allApproved) {
    $updateStatus = "UPDATE pengajuan_form_a
                        SET status_pengajuan = 'Approved'
                        WHERE id = '" . $idPengajuan . "'";
    $queUpdateStatus = $dbeta->query($updateStatus);

    if($dataEmailAssigner){
        $emailAssigner = $dataEmailAssigner['email'];
        $to = 'muhammad.fatih@compnet.co.id';

        $cc = '';
        $bcc= '';

        $subject = 'Informasi Approval Pengajuan Gift A';

        $message = 'Dear Bapak/Ibu ' . $name_assigner . ',
                        <br><br>We are pleased to inform you that all approvers have approved the Gift A request with the following details. ' . '<br><br>' .
                            '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                <tr style="width: 50%;">
                                    <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                    <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                </tr>
                                <tr style="width: 50%;">
                                    <td style="border: 1px solid #000;">' . $dataNomorPengajuan['nomor_pengajuan'] . '</td>
                                    <td style="border: 1px solid #000;">' . $name_assigner . '</td>
                                </tr>
                            </table>' . '<br><br>' .
                            'Please note that the summary file is now available and ready for printing' . '<br><br><br>' .
                            'Thank you.';
            
        $attachment = [];
        // Kirim email
        kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);
    }

}


echo json_encode($output);
