<?php
include "../../config.php";

$id = $_REQUEST['id'];
// var_dump($id);
// exit;

$getGiftData = "SELECT * 
                FROM pengajuan_form_b p
                WHERE p.id = '" . $id . "'";
$queGiftData = $dbeta->query($getGiftData);
$data = $queGiftData->fetch_assoc();

$getGiftDataLampiran = "SELECT * 
                FROM pengajuan_form_b p
                JOIN form_a_lampiran f ON p.id_lampiran = f.id
                WHERE p.id = '" . $id . "'";
$queGiftDataLampiran = $dbeta->query($getGiftDataLampiran);
$dataLampiran = $queGiftDataLampiran->fetch_assoc();

$getAllForm = "SELECT * 
                FROM pengajuan_form_b b
                JOIN pengajuan_form_a a ON b.id_pengajuan_a = a.id
                WHERE b.id = '" . $id . "'";
$queGetAllForm = $dbeta->query($getAllForm);
$dataForm = $queGetAllForm->fetch_assoc();

// echo($data);

$getPesertaData = "SELECT * FROM peserta_b p
                    WHERE p.id_pengajuan_b = '" . $id . "'";
$quePesertaData = $dbeta->query($getPesertaData);
$dataPeserta = $quePesertaData->fetch_all(MYSQLI_ASSOC);

$getApproverData = "SELECT * FROM approval_b a
                    WHERE a.id_pengajuan_b = '" . $id . "'";
$queApproveraData = $dbeta->query($getApproverData);
$dataApprover = $queApproveraData->fetch_all(MYSQLI_ASSOC);

$output = array(
    "draw" => 1,
    // "recordsTotal" => count($data),
    // "recordsFiltered" => count($data),
    "data" => $data,
    "dataForm" => $dataForm,
    "dataLampiran" => $dataLampiran,
    "dataPeserta" => $dataPeserta,
    "dataApprover" => $dataApprover
);

echo json_encode($output);