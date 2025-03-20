<?php
// Include database configuration
include "../../config.php";

// Fetch request parameters
$id_pengajuan = $_REQUEST['id_pengajuan'];
// $id_Peserta = $_REQUEST['id_peserta_detail'] ?? [];
$id_employee_peserta = $_REQUEST['nama_peserta_detail'] ?? [];
$direktorat_peserta = $_REQUEST['direktorat_peserta_detail'] ?? [];

$id_employee_peserta_str = implode(",", $id_employee_peserta);

$queryGet_nama_peserta = "SELECT * FROM employee WHERE id IN ($id_employee_peserta_str)";

$que_nama_peserta = $db->query($queryGet_nama_peserta);

$pesertaNames = []; // array untuk mapping ID ke full_name
while ($row = $que_nama_peserta->fetch_assoc()) {
    $pesertaNames[$row['id']] = $row['full_name'];
}

// $pesertaNames = []; // array untuk menyimpan nama peserta saja
// while ($row = $que_nama_peserta->fetch_assoc()) {
//     $pesertaNames[] = $row['full_name'];
// }

// var_dump($pesertaNames);

// Validasi data input
$totalData = (int) count($id_employee_peserta);


// Ambil data existing untuk id_pengajuan
$queryExisting = "SELECT id_employee FROM peserta_a WHERE id_pengajuan_a = '$id_pengajuan'";
$resultExisting = $dbeta->query($queryExisting);
$existingData = [];
while ($row = $resultExisting->fetch_assoc()) {
    $existingData[] = $row['id_employee'];
}

$totalExist = (int) count($existingData);
// var_dump($totalExist);
// var_dump($totalData);
// exit;
// var_dump($existingData);

// $selisih = $totalExist - $totalData;
// var_dump($selisih);



if($totalExist > $totalData){

    $selisih = $totalExist - $totalData;

    $sqlDeleteExisting = "DELETE FROM peserta_a WHERE id_pengajuan_a = '" . $id_pengajuan . "' LIMIT " . $selisih;
    // var_dump($sqlDeleteExisting);
    $dbeta->query($sqlDeleteExisting);

}else if($totalExist < $totalData){

    $selisih = $totalData - $totalExist;

    for ($i = 0; $i < $selisih; $i++) {
        $sqlinsertExisting = "INSERT INTO peserta_a (id_pengajuan_a, id_employee, nama_peserta_perusahaan, direktorat_peserta_perusahaan, has_updated) VALUES ($id_pengajuan, 0, 'temp', 'temp', '0')";
        // var_dump($sqlinsertExisting);
        $dbeta->query($sqlinsertExisting);
    }
    
}

// $dataValues = [];
// $dataValues2 = [];


for ($i = 0; $i < $totalData; $i++) {
    $idPeserta = $id_employee_peserta[$i] ?? '';
    $direktorat = $direktorat_peserta[$i] ?? '';
    $fullName = $pesertaNames[$idPeserta] ?? '';

    $queryUpdatePeserta = "UPDATE peserta_a
                            SET id_employee = '". $idPeserta ."', nama_peserta_perusahaan = '". $fullName ."', direktorat_peserta_perusahaan = '". $direktorat ."', has_updated = '1'
                            WHERE id_pengajuan_a = '". $id_pengajuan ."' AND has_updated = '0' LIMIT 1";

    // var_dump($queryUpdatePeserta);
    $dbeta->query($queryUpdatePeserta);
    
    // Menambahkan data untuk INSERT
    // $dataValues[] = "('" . $id_pengajuan . "', '" . $idPeserta . "', '" . $fullName . "', '" . $direktorat . "')";

    // // Menambahkan data untuk UPDATE (gunakan CASE terpisah untuk masing-masing kolom)
    // $dataValues2[] = "WHEN id_employee = '" . $idPeserta . "' THEN '" . $fullName . "'";
    // $dataValues3[] = "WHEN id_employee = '" . $idPeserta . "' THEN '" . $direktorat . "'";
}

$queryUpdatePesertastatus = "UPDATE peserta_a
                            SET has_updated = '0'
                            WHERE id_pengajuan_a = '". $id_pengajuan ."'";

// var_dump($queryUpdatePesertastatus);
$dbeta->query($queryUpdatePesertastatus);

// // // Gabungkan data untuk INSERT dan UPDATE
// $insertValues = implode(',', $dataValues);

// var_dump($insertValues);
// $updateValuesName = implode(' ', $dataValues2);
// $updateValuesDirectorate = implode(' ', $dataValues3);

// // Membuat query INSERT dengan ON DUPLICATE KEY UPDATE
// $insertPesertaA = "INSERT INTO peserta_a (id_pengajuan_a, id_employee, nama_peserta_perusahaan, direktorat_peserta_perusahaan)
//                 VALUES $insertValues
//                 ON DUPLICATE KEY UPDATE 
//                     nama_peserta_perusahaan = CASE $updateValuesName END,
//                     direktorat_peserta_perusahaan = CASE $updateValuesDirectorate END";

// // var_dump($insertPesertaA);

// // $queinsertPesertaA = $dbeta->query($insertPesertaA);



// if ($queinsertPesertaA) {
//     $output = ['status' => 'success', 'message' => 'Data inserted/updated successfully'];
// } else {
//     $output = ['status' => 'error', 'message' => 'Failed to insert/update data'];
// }

// echo json_encode($output);

// // var_dump($insertPesertaA);


// // var_dump($insertPesertaA);

// // $updateDataPeserta = "UPDATE pengajuan_form_a " . $set . " 
// // //                                 WHERE id = '" . $id . "'";

// // Output response
echo json_encode(['status' => 'success', 'message' => 'Data peserta berhasil diperbarui.']);
