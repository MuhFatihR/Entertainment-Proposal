<?php
include "../../config.php";

$id = $_REQUEST['no_revisi'];

$getGiftData = "SELECT 
                        pengajuan_form_a.id as idPengajuan,
                        pengajuan_form_a.id_currency,
                        pengajuan_form_a.nomor_pengajuan,
                        pengajuan_form_a.id_nama_pengusul,
                        pengajuan_form_a.nama_pengusul,
                        pengajuan_form_a.jabatan_pengusul,
                        pengajuan_form_a.direktorat_pengusul,
                        pengajuan_form_a.tanggal_pengajuan,
                        pengajuan_form_a.jenis_pemberian,
                        pengajuan_form_a.jenis_pemberian_gift,
                        pengajuan_form_a.jenis_pemberian_entertainment,
                        pengajuan_form_a.jenis_pemberian_other,
                        pengajuan_form_a.nama_penerima,
                        pengajuan_form_a.perusahaan_penerima,
                        pengajuan_form_a.tanggal_diberikan,
                        pengajuan_form_a.tempat_diberikan,
                        pengajuan_form_a.tujuan_pemberian,
                        pengajuan_form_a.estimasi_biaya,
                        pengajuan_form_a.status_pengajuan,
                        peserta_a.id as idPeserta,
                        peserta_a.id_pengajuan_a,
                        peserta_a.id_employee,
                        peserta_a.nama_peserta_perusahaan,
                        peserta_a.direktorat_peserta_perusahaan,
                        currency.id as idCurrency,
                        currency.nama_currency
                    FROM pengajuan_form_a   
                    JOIN peserta_a
                    ON pengajuan_form_a.id = peserta_a.id_pengajuan_a
                    JOIN currency
                    ON pengajuan_form_a.id_currency = currency.id
                    WHERE pengajuan_form_a.id = '" . $id . "'";
$queGiftData = $dbeta->query($getGiftData);
$data = $queGiftData->fetch_assoc();

$getPesertaData = "SELECT * 
                    FROM peserta_a
                    WHERE id_pengajuan_a = '" . $id . "'";
$quePesertaData = $dbeta->query($getPesertaData);
$dataPeserta = $quePesertaData->fetch_all(MYSQLI_ASSOC);

$getDataEmployee = "SELECT DISTINCT 
                    id, full_name, email, directorate
                    FROM employee 
                    WHERE active = '1' 
                    ORDER BY full_name";
$queDataEmployee = $db->query($getDataEmployee);
$listemployee = $queDataEmployee->fetch_all(MYSQLI_ASSOC);

$output = array(
    "data" => $data,
    "listemployee" => $listemployee,
    "dataPeserta" => $dataPeserta
    // "dataApprover" => $dataApprover,
    // "dataLampiran" => $dataLampiran,
    // "status" => 'success'
);

echo json_encode($output);
