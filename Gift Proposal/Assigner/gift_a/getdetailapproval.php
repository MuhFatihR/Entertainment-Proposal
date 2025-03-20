<?php
include "../../config.php";

$id = $_REQUEST['id'];

// Get Data Pengajuan
$getGiftData = "SELECT *           
                    FROM pengajuan_form_a 
                    JOIN peserta_a
                    ON pengajuan_form_a.id = peserta_a.id_pengajuan_a
                    JOIN currency
                    ON pengajuan_form_a.id_currency = currency.id
                    WHERE pengajuan_form_a.id = '" . $id . "'";
$queGiftData = $dbeta->query($getGiftData);
$data = $queGiftData->fetch_all(MYSQLI_ASSOC);


// Get Data Employee
$getDataEmployee = "SELECT DISTINCT 
                        id, full_name, email 
                    FROM employee 
                    WHERE active = '1' 
                    ORDER BY full_name";
$queDataEmployee = $db->query($getDataEmployee);
$listemployee = $queDataEmployee->fetch_all(MYSQLI_ASSOC);


// Get Data Peserta Pengajuan
$getDataPeserta = "SELECT * 
                    FROM peserta_a
                    WHERE id_pengajuan_a = '" . $id . "'";
$queDataPeserta = $dbeta->query($getDataPeserta);
$dataPeserta = $queDataPeserta->fetch_all(MYSQLI_ASSOC);


// Get Data Approver Pengajuan
$getDataApprover = "SELECT * 
                    FROM approval_a
                    WHERE id_pengajuan_a = '" . $id . "'";
$queDataApprover = $dbeta->query($getDataApprover);
$dataApprover = $queDataApprover->fetch_all(MYSQLI_ASSOC);

$getGiftDataLampiran = "SELECT * 
                FROM pengajuan_form_a p
                JOIN form_a_lampiran f ON p.id_lampiran = f.id
                WHERE p.id = '" . $id . "'";
$queGiftDataLampiran = $dbeta->query($getGiftDataLampiran);
$dataLampiran = $queGiftDataLampiran->fetch_assoc();

$output = array(
    "data" => $data,
    "listemployee" => $listemployee,
    "dataPeserta" => $dataPeserta,
    "dataApprover" => $dataApprover,
    "dataLampiran" => $dataLampiran
);
echo json_encode($output);