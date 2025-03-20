<?php
include "../../config.php";

$rejectNotes = $_REQUEST['rejectNotes']; // Pastikan sudah divalidasi
$approver_id = (int) $_REQUEST['id']; // Pastikan ID adalah integer
$date = date('Y-m-d H:i:s');

// // Get id_pengajuan_a
// $getDataApproval = "SELECT * 
//                     FROM approval_b
//                     WHERE id = '" . $approver_id . "'";
// $queDataApproval = $dbeta->query($getDataApproval);
// $dataApproval = $queDataApproval->fetch_assoc();

// $idPengajuan = $dataApproval['id_pengajuan_b'];

// Pastikan nilai string dikelilingi tanda kutip tunggal
$queryApprove = "UPDATE approval_b 
                SET approval_status_b = 'Rejected', 
                    tanggal_approval_b = '" . $date . "', 
                    notes_b = '". $rejectNotes. "'
                WHERE id = '" . $approver_id . "'";

// Eksekusi query
if ($dbeta->query($queryApprove) === TRUE) {
    $output = ['status' => 'success', 'message' => 'Approval berhasil diperbarui.'];
} else {
    $output = ['status' => 'error', 'message' => 'Gagal memperbarui approval.', 'error' => $dbeta->error];
}


// Get id_pengajuan_a
$getDataApproval = "SELECT * 
                    FROM approval_b
                    WHERE id = '" . $approver_id . "'";
$queDataApproval = $dbeta->query($getDataApproval);
$dataApproval = $queDataApproval->fetch_assoc();

$idPengajuanB = $dataApproval['id_pengajuan_b'];


// Get data approval_A (untuk pengecekan keselurah status)
$getDataStatus = "SELECT * 
                    FROM approval_b
                    WHERE id_pengajuan_b = " . $idPengajuanB;
$queDataStatus = $dbeta->query($getDataStatus);

$gotRejected = false;
foreach ($queDataStatus as $datastatus) {
    if ($datastatus['approval_status_b'] == 'Rejected') {
        $gotRejected = true;
        break;
    }
}

if ($gotRejected == true) {
    $updateStatus = "UPDATE pengajuan_form_b
                            SET status_approval_b = 'Rejected'
                            WHERE id = '" . $idPengajuanB . "'";
    $queUpdateStatus = $dbeta->query($updateStatus);
}
// Kirim respons JSON
echo json_encode($output);