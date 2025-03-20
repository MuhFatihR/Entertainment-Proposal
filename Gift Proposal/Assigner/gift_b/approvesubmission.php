<?php
include "../../config.php";
include "../../init_email.php";

$approveNotes = $_REQUEST['approveNotes']; // Pastikan sudah divalidasi
$approver_id = (int) $_REQUEST['id']; // Pastikan ID adalah integer
$date = date('Y-m-d H:i:s');

// Pastikan nilai string dikelilingi tanda kutip tunggal
$queryApprove = "UPDATE approval_b 
                SET approval_status_b = 'Approved', 
                    tanggal_approval_b = '" . $date . "', 
                    notes_b = '" . $approveNotes . "'
                WHERE id = '" . $approver_id . "'";

// Eksekusi query
if ($dbeta->query($queryApprove) === TRUE) {
    $output = ['status' => 'success', 'message' => 'Approval berhasil diperbarui.'];
} else {
    $output = ['status' => 'error', 'message' => 'Gagal memperbarui approval.', 'error' => $dbeta->error];
}

$queryGetApproverLevel = "SELECT * FROM approval_b WHERE id = " . $approver_id;
$queDataLevel = $dbeta->query($queryGetApproverLevel);
$dataLevel = $queDataLevel->fetch_assoc();

if($dataLevel){
    $approverLevel = $dataLevel['approver_level_b'];
    $nomorPengajuan = $dataLevel['id_pengajuan_b'];
    $approverLevelInt = intval($approverLevel);
    $nextApproverLevel = $approverLevelInt + 1;
}else{
    echo "Data approver dengan ID $approver_id tidak ditemukan.";
}

$queryGetNextApprover = "SELECT * FROM approval_b WHERE id_pengajuan_b = " . $nomorPengajuan . " AND approver_level_b = '" . $nextApproverLevel . "'";
$queDataNextLevel = $dbeta->query($queryGetNextApprover);
$dataNextLevel = $queDataNextLevel->fetch_assoc();

// $id_pengajuan_a = $dataNextLevel['id_pengajuan_a'];

$queryGetNomorPengajuan = "SELECT * FROM pengajuan_form_b WHERE id = " . $nomorPengajuan;
$queGetNomorPengajuan = $dbeta->query($queryGetNomorPengajuan);
$dataNomorPengajuan = $queGetNomorPengajuan->fetch_assoc();

if($dataNomorPengajuan){
    $id_assigner = $dataNomorPengajuan['id_pelapor'];
    $name_assigner = $dataNomorPengajuan['nama_pelapor'];
    $id_inputter = $dataNomorPengajuan['id_inputter'];
}

$queryEmailAssigner = "SELECT email FROM employee WHERE id = " . $id_assigner;
$queGetEmailAssigner = $db->query($queryEmailAssigner);
$dataEmailAssigner = $queGetEmailAssigner->fetch_assoc();

// var_dump($id_inputter);

$queryEmailInputter = "SELECT full_name, email FROM employee WHERE id = " . $id_inputter;
$queGetEmailInputter = $db->query($queryEmailInputter);
$dataEmailInputter = $queGetEmailInputter->fetch_assoc();

if($dataNextLevel){
    $nama_nextLevel = $dataNextLevel['approver_name_b'];
    // $email_nextLevel = $dataNextLevel['approver_email'];

    // $to = $dataNextLevel['approver_email'];
    $to = 'muhammad.fatih@compnet.co.id';

    $cc = '';
    $bcc= '';

    $subject = 'Informasi Approval Pengajuan Gift A';

    $message = 'Dear Bapak/Ibu ' . $nama_nextLevel . ',<br><br>' .
                        'You have been registered as approver gift B with the following details.' . '<br><br>' .
                        '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                            <tr style="width: 50%;">
                                <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                            </tr>
                            <tr style="width: 50%;">
                                <td style="border: 1px solid #000;">' . $dataNomorPengajuan['nomor_pengajuan_b'] . '</td>
                                <td style="border: 1px solid #000;">' . $name_assigner . '</td>
                            </tr>
                        </table>' . '<br><br>' .
                        'Approval can be made through the following link:  <a href="https://apps.compnet.co.id/portalform/approval-gift-A/">Link Approval</a>.' . '<br><br><br>' .
                        'Thank you.';

    $attachment = [];
    // Kirim email
    kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);

    if($dataEmailAssigner && $dataEmailInputter){

        $queryApproverManager = "SELECT * FROM approval_b WHERE id_pengajuan_b = " . $nomorPengajuan . " AND approver_level_b = '1'";
        $queApproverManager = $dbeta->query($queryApproverManager);
        $dataApproverManager = $queApproverManager->fetch_assoc();

        $manager_name = $dataApproverManager['approver_name_b'];

        // $emailAssigner = $dataEmailAssigner['email'];

        $to = 'muhammad.fatih@compnet.co.id';
        // $to = $dataEmailAssigner['email'];

        $cc = '';
        $bcc= '';

        $subject = 'Informasi Approval Pengajuan Gift A';

        $message = 'Dear Bapak/Ibu ' . $name_assigner . ',
                        <br><br>' . $manager_name . ' has approved gift B request with the following details. ' . '<br><br>' .
                            '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                <tr style="width: 50%;">
                                    <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                    <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                </tr>
                                <tr style="width: 50%;">
                                    <td style="border: 1px solid #000;">' . $dataNomorPengajuan['nomor_pengajuan_b'] . '</td>
                                    <td style="border: 1px solid #000;">' . $name_assigner . '</td>
                                </tr>
                            </table>' . '<br><br>' .
                            'Thank you.';
        
        $attachment = [];
        // Kirim email
        kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);

        // ======================================================================================================================================================== \\

        if($id_assigner !== $id_inputter){
            $to = 'muhammad.fatih@compnet.co.id';
            // $to = $dataEmailInputter['email'];

            $cc = '';
            $bcc= '';

            $subject = 'Informasi Approval Pengajuan Gift A';

            $message = 'Dear Bapak/Ibu ' . $dataEmailInputter['full_name'] . ',
                            <br><br>' . $manager_name . ' has approved gift B request with the following details. ' . '<br><br>' .
                                '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                        <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                    </tr>
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;">' . $dataNomorPengajuan['nomor_pengajuan_b'] . '</td>
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

$queryGetpjid = "SELECT * FROM approval_b a WHERE a.id = '" . $approver_id . "'";
$queGetpjid = $dbeta->query($queryGetpjid);

$dataGetpjid = $queGetpjid->fetch_assoc();
$pj_id = $dataGetpjid['id_pengajuan_b'];

$queryGetStatus = "SELECT * FROM approval_b a WHERE a.id_pengajuan_b = " . $pj_id;
$queGetStatus = $dbeta->query($queryGetStatus);

$allApproved = true;
foreach ($queGetStatus as $datastatus) {
    if ($datastatus['approval_status_b'] == 'Rejected' || $datastatus['approval_status_b'] == 'Waiting Approval') {
        $allApproved = false;
        break;
    }
}

if ($allApproved) {
    $queryUpdateStatus = "UPDATE pengajuan_form_b 
                            SET status_approval_b = 'Approved'
                            WHERE id = '" . $pj_id . "'";
    $queUpdateStatus = $dbeta->query($queryUpdateStatus);

    if($dataEmailAssigner){
        $emailAssigner = $dataEmailAssigner['email'];
        $to = 'muhammad.fatih@compnet.co.id';

        $cc = '';
        $bcc= '';

        $subject = 'Informasi Approval Pengajuan Gift A';

        $message = 'Dear Bapak/Ibu ' . $name_assigner . ',
                        <br><br>We are pleased to inform you that all approvers have approved the Gift B request with the following details. ' . '<br><br>' .
                            '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                <tr style="width: 50%;">
                                    <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                    <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                </tr>
                                <tr style="width: 50%;">
                                    <td style="border: 1px solid #000;">' . $dataNomorPengajuan['nomor_pengajuan_b'] . '</td>
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