<?php
include "../../config.php";

    $id = $_REQUEST['id'];

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
    $data = $queGiftData->fetch_all(MYSQLI_ASSOC);

    $idCurrency = $data[0]['id_currency'];


    $getDataEmployee = "SELECT DISTINCT 
                                id, full_name, email, directorate
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
                            FROM approval_a a
                            WHERE id_pengajuan_a = '" . $id . "'";
    $queDataApprover = $dbeta->query($getDataApprover);
    $dataApprover = $queDataApprover->fetch_all(MYSQLI_ASSOC);

    // Get File Lampiran
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
