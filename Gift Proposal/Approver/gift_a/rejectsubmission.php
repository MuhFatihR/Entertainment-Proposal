<?php
include "../../config.php";

$rejectNotes = $_REQUEST['rejectNotes'];
$id_approver = (int) $_REQUEST['id_approver'];
$date = date('Y-m-d H:i:s');

$updateApprove = "UPDATE approval_a 
                    SET approval_status = 'Rejected', 
                        tanggal_approval = '" . $date . "', 
                        notes = '". $rejectNotes. "'
                    WHERE id = '" . $id_approver . "'";

if ($dbeta->query($updateApprove) === TRUE) {
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


$gotRejected = false;
foreach ($queDataStatus as $datastatus) {
    if ($datastatus['approval_status'] == 'Rejected') {
        $gotRejected = true;
        break;
    }
}

// Cek 1 persatu pada "APPROVAL" jika semua sudah approved maka status pada "PENGAJUAN" = Approved
if ($gotRejected) {
    $updateStatus = "UPDATE pengajuan_form_a
                        SET status_pengajuan = 'Rejected'
                        WHERE id = '" . $idPengajuan . "'";
    $queUpdateStatus = $dbeta->query($updateStatus);
}


echo json_encode($output);
