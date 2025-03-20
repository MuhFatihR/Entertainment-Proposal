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

// Eksekusi query
if ($dbeta->query($updateApproval) === TRUE) {
    $output = ['status' => 'success', 'message' => 'Approval berhasil diperbarui.'];
} else {
    $output = ['status' => 'error', 'message' => 'Gagal memperbarui approval.', 'error' => $dbeta->error];
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


    // Kirim Email
    // GET id_nama_inputter
    $getIDUserInputter = "SELECT 
                            id_nama_inputter
                        FROM pengajuan_form_a
                        WHERE id = '" . $idPengajuan . "'";
    $queIDUserInputter = $dbeta->query($getIDUserInputter);
    $resultIDUserInputter = $queIDUserInputter->fetch_assoc();

    // Get name inputter
    $getUserInputter = "SELECT 
                            full_name,
                            email
                        FROM employee
                        WHERE id = '" . $resultIDUserInputter['id_nama_inputter'] . "'";
    $queUserInputter = $db->query($getUserInputter);
    $resultUserInputter = $queUserInputter->fetch_assoc();
    $emailInpputer = $resultUserInputter['email'];


    // Get id inputted
    $getIDUserinputted = "SELECT
                            nomor_pengajuan,
                            id_nama_pengusul
                        FROM pengajuan_form_a 
                        WHERE id = '" . $idPengajuan . "'";
    $queIDUserInpputed = $dbeta->query($getIDUserinputted);
    $resultIDUserInputted = $queIDUserInpputed->fetch_assoc();

    // Get name inputted
    $getUserInputted = "SELECT 
                        full_name,
                        email
                    FROM employee
                    WHERE id = '" . $resultIDUserInputted['id_nama_pengusul'] . "'";
    $queUserInputted = $db->query($getUserInputted);
    $resultUserInputted = $queUserInputted->fetch_assoc();
    $emailInpputed = $resultUserInputted['email'];


    // EMAIL
    if($emailInpputer == $emailInpputed){
        $to = $emailInpputer;
        // $to = 'ricky.krisdianto@compnet.co.id';
        $cc = '';
        $bcc= '';
    
        $subject = 'Informasi Approval Pengajuan Gift A';
    
        $message = 'Dear Mr/Ms ' . $resultUserInputter['full_name'] . ', <br><br>
                            We are pleased to inform you that all approvers have approved the Gift A request with the following details. ' . '<br><br>' .
                                '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                        <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                    </tr>
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;">' . $resultIDUserInputted['nomor_pengajuan'] . '</td>
                                        <td style="border: 1px solid #000;">' . $resultUserInputted['full_name'] . '</td>
                                    </tr>
                                </table>' . '<br><br>' .
                            'Please note that the summary file is now available and ready for printing' . '<br><br><br>' .
                            'Thank you.';
            
        $attachment = [];
        kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);
    } else {
        $to = $emailInpputer;
        // $to = 'ricky.krisdianto@compnet.co.id';
        $cc = '';
        $bcc= '';
    
        $subject = 'Informasi Approval Pengajuan Gift A';
    
        $message = 'Dear Mr/Ms ' . $resultUserInputter['full_name'] . ', <br><br>
                            We are pleased to inform you that all approvers have approved the Gift A request with the following details. ' . '<br><br>' .
                                '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                        <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                    </tr>
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;">' . $resultIDUserInputted['nomor_pengajuan'] . '</td>
                                        <td style="border: 1px solid #000;">' . $resultUserInputted['full_name'] . '</td>
                                    </tr>
                                </table>' . '<br><br>' .
                            'Please note that the summary file is now available and ready for printing.' . '<br><br><br>' .
                            'Thank you.';
            
        $attachment = [];
        kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);

        // Inputted 
        $to = $emailInpputed;
        // $to = 'ricky.krisdianto@compnet.co.id';
        $cc = '';
        $bcc= '';
    
        $subject = 'Informasi Approval Pengajuan Gift A';
    
        $message = 'Dear Mr/Ms ' . $resultUserInputted['full_name'] . ', <br><br>
                            We are pleased to inform you that all approvers have approved the Gift A request with the following details. ' . '<br><br>' .
                                '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                        <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                    </tr>
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;">' . $resultIDUserInputted['nomor_pengajuan'] . '</td>
                                        <td style="border: 1px solid #000;">' . $resultUserInputted['full_name'] . '</td>
                                    </tr>
                                </table>' . '<br><br>' .
                                'Please note that the summary file is now available and ready for printing.' . '<br><br><br>' .
                            'Thank you.';
            
        $attachment = [];
        kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);
    }
    
}

echo json_encode($output);