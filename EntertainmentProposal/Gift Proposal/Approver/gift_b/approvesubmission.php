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

$queryGetpjid = "SELECT * FROM approval_b a WHERE a.id = '" . $approver_id . "'";
$queGetpjid = $dbeta->query($queryGetpjid);
$dataGetpjid = $queGetpjid->fetch_assoc();

$pj_id = $dataGetpjid['id_pengajuan_b'];

$queryGetStatus = "SELECT * FROM approval_b a WHERE a.id_pengajuan_b = " . $pj_id;
$queGetStatus = $dbeta->query($queryGetStatus);

$allApproved = true;
foreach ($queGetStatus as $datastatus) {
    if ($datastatus['approval_status_b'] == 'Rejected' || $datastatus['approval_status_b'] == 'Waiting') {
        $allApproved = false;
        break;
    }
}

if ($allApproved) {
    $queryUpdateStatus = "UPDATE pengajuan_form_b 
                            SET status_approval_b = 'Approved'
                            WHERE id = '" . $pj_id . "'";
    $queUpdateStatus = $dbeta->query($queryUpdateStatus);


    // Kirim Email
    // GET id_inputter
    $getIDUserInputter = "SELECT 
                            id_inputter
                        FROM pengajuan_form_b
                        WHERE id = '" . $pj_id . "'";
    $queIDUserInputter = $dbeta->query($getIDUserInputter);
    $resultIDUserInputter = $queIDUserInputter->fetch_assoc();

    // Get name inputter
    $getUserInputter = "SELECT 
                            full_name,
                            email
                        FROM employee
                        WHERE id = '" . $resultIDUserInputter['id_inputter'] . "'";
    $queUserInputter = $db->query($getUserInputter);
    $resultUserInputter = $queUserInputter->fetch_assoc();
    $emailInpputer = $resultUserInputter['email'];


    // Get id inputted
    $getIDUserinputted = "SELECT
                            nomor_pengajuan_b,
                            id_pelapor
                        FROM pengajuan_form_b 
                        WHERE id = '" . $pj_id . "'";
    $queIDUserInpputed = $dbeta->query($getIDUserinputted);
    $resultIDUserInputted = $queIDUserInpputed->fetch_assoc();

    // Get name inputted
    $getUserInputted = "SELECT 
                        full_name,
                        email
                    FROM employee
                    WHERE id = '" . $resultIDUserInputted['id_pelapor'] . "'";
    $queUserInputted = $db->query($getUserInputted);
    $resultUserInputted = $queUserInputted->fetch_assoc();
    $emailInpputed = $resultUserInputted['email'];


    // EMAIL
    if($emailInpputer == $emailInpputed){
        $to = $emailInpputer;
        // $to = 'ricky.krisdianto@compnet.co.id';
        $cc = '';
        $bcc= '';

        $subject = 'Informasi Approval Pengajuan Gift B';

        $message = 'Dear Mr/Ms ' . $resultUserInputter['full_name'] . ', <br><br>
                            We are pleased to inform you that all approvers have approved the Gift B request with the following details: ' . '<br><br>' .
                                '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                        <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                    </tr>
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;">' . $resultIDUserInputted['nomor_pengajuan_b'] . '</td>
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
    
        $subject = 'Informasi Approval Pengajuan Gift B';
    
        $message = 'Dear Mr/Ms ' . $resultUserInputter['full_name'] . ', <br><br>
                            We are pleased to inform you that all approvers have approved the Gift B request with the following details. ' . '<br><br>' .
                                '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                        <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                    </tr>
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;">' . $resultIDUserInputted['nomor_pengajuan_b'] . '</td>
                                        <td style="border: 1px solid #000;">' . $resultUserInputted['full_name'] . '</td>
                                    </tr>
                                </table>' . '<br><br>' .
                            'Please note that the summary file is now available and ready for printing.' . '<br><br><br>' .
                            'Thank you.';

        $attachment = [];
        kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);


        $to = $emailInpputed;
        // $to = 'ricky.krisdianto@compnet.co.id';
        $cc = '';
        $bcc= '';
    
        $subject = 'Informasi Approval Pengajuan Gift B';
    
        $message = 'Dear Mr/Ms ' . $resultUserInputted['full_name'] . ', <br><br>
                            You have been assigned as a requestor by ' . $resultUserInputter['full_name'] . ' on Gift B with the following details: ' . '<br><br>' .
                                '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 60%;">
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;"><b>Nomor Pengajuan</b></td>
                                        <td style="border: 1px solid #000;"><b>Nama Pengusul</b></td>
                                    </tr>
                                    <tr style="width: 50%;">
                                        <td style="border: 1px solid #000;">' . $resultIDUserInputted['nomor_pengajuan_b'] . '</td>
                                        <td style="border: 1px solid #000;">' . $resultUserInputted['full_name'] . '</td>
                                    </tr>
                                </table>' . '<br><br>' .
                            'Thank you.';

        $attachment = [];
        kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);
    }
}

echo json_encode($output);