<?php
include "../../config.php";
include "../../init_email.php";

$nama_pengirim = $_REQUEST['nama_pengirim'];
$perusahaan_pengirim = $_REQUEST['perusahaan_pengirim'];
$nama_penerima = $_REQUEST['nama_penerima'] ?? "0";
$department_penerima = $_REQUEST['department_penerima'] ?? "0";
$pt_penerima = $_REQUEST['pt_penerima'] ?? "0";
$banyak_parcel = $_REQUEST['banyak_parcel'];
$currency = $_REQUEST['currency'];
$estimasi_nominal = $_REQUEST['estimasi_nominal'];
$source_info_nominal = $_REQUEST['source_info_nominal'];

$target_dir = "../../fileParcel/";
$file = basename($_FILES["file"]["name"]);
$target_file = $target_dir . basename($file);


$tahun = date('y');
$bulan = date('m');

// GET Nomor Parcel
$sqlNomor = "SELECT no_parcel FROM parcel ORDER BY id DESC LIMIT 1";
$resultNomor = $dbeta->query($sqlNomor);
$count = $resultNomor->num_rows;

if ($count > 0) { //PCL24010001
    $row = $resultNomor->fetch_assoc();
    $lastNomor = $row['no_parcel'];

    $lastTahun = substr($lastNomor, 3, 2); // Extract year (characters 4-5)
    $lastNomorUrut = intval(substr($lastNomor, -4)); // Extract sequence number (last 4 characters)

    if ($lastTahun === $tahun) { // Increment the sequence if the year is the same
        $nomorUrut = $lastNomorUrut + 1;
        $nomorUrut = str_pad($nomorUrut, 4, '0', STR_PAD_LEFT); // Ensure it's 4 digits

    } else { // Reset sequence number if the year has changed
        $nomorUrut = '0001';
    }
} else {
    $nomorUrut = '0001';
}
$nomorParcel = 'PCL' . $tahun . $bulan . $nomorUrut;

$full_name = '-';
$nameDepart = '-';
$namePT = '-';

if ($nama_penerima) {
    // Get Data Employee (full_name)
    $getNamaPenerima = "SELECT 
                                id, full_name 
                            FROM employee
                            WHERE id = '" . $nama_penerima . "'";
    $queNamaPenerima = $db->query($getNamaPenerima);
    $result1 = $queNamaPenerima->fetch_assoc();
    $full_name = $result1['full_name'];
} else if(!$nama_penerima) {
    $nama_penerima = 0;
    $full_name = '-';
}

if ($department_penerima) {
    // Get Data Employee (departmentName)
    $getDepartmentPenerima = "SELECT 
                                        id, name 
                                    FROM department
                                    WHERE id = '" . $department_penerima . "'";
    $queDepartmentPenerima = $db->query($getDepartmentPenerima);
    $result2 = $queDepartmentPenerima->fetch_assoc();
    $nameDepart = $result2['name'];
} else if(!$department_penerima){
    $department_penerima = 0;
    $nameDepart = '-';
}

if ($pt_penerima) {
    // Get Data Employee (companyName)
    $getNamaCompany = "SELECT 
                                id, name 
                            FROM company
                            WHERE id = '" . $pt_penerima . "'";
    $queNamaCompany = $db->query($getNamaCompany);
    $result3 = $queNamaCompany->fetch_assoc();
    $namePT = $result3['name'];
}else if(!$pt_penerima){
    $pt_penerima = 0;
    $namePT = '-';
}


// Get CurrencyName
$getNamaCurrency = "SELECT 
                            id, nama_currency 
                        FROM currency
                        WHERE id = '" . $currency . "'";
$queNamaCurrency = $dbeta->query($getNamaCurrency);
$result4 = $queNamaCurrency->fetch_assoc();
$namaCurrency = $result4['nama_currency'];


// INSERT INTO TABLE PENGIRIM
$insertPengirim = "INSERT INTO parcel_pengirim (id_currency, nama_pengirim, perusahaan_pengirim, estimasi_nominal, source_info_nominal)
                        VALUES ('" . $currency . "', '" . $nama_pengirim . "', '" . $perusahaan_pengirim . "', " . $estimasi_nominal . ", '" . $source_info_nominal . "')";
$quePengirim = $dbeta->query($insertPengirim);
$id_pengirim = $dbeta->insert_id;

// INSERT INTO TABLE PENERIMA
$insertPenerima = "INSERT INTO parcel_penerima (id_nama_penerima, nama_penerima, id_department_penerima, department_penerima, id_pt_penerima, pt_penerima)
                        VALUES ('" . $nama_penerima . "', '" . $full_name . "', '" . $department_penerima . "', '" . $nameDepart . "', '" . $pt_penerima . "', '" . $namePT . "')";
$quePenerima = $dbeta->query($insertPenerima);
$id_penerima = $dbeta->insert_id;

// INSERT INTO TABLE LAMPIRAN
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0644);
}
$uploaded = move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

if ($uploaded) {
    $insertLampiran = "INSERT INTO parcel_lampiran (file_name, path)
                             VALUES ('" . $file . "', '" . $target_file . "')";
    $queLampiran = $dbeta->query($insertLampiran);
    $id_lampiran = $dbeta->insert_id;
} else {
    echo 'SALAH UPLOAD!';
}

// INSERT INTO TABLE PARCEL
$insertParcel = "INSERT INTO parcel (id_penerima, id_pengirim, id_lampiran, no_parcel, banyak_parcel, keputusan, approver_email)
                        VALUES ('" . $id_pengirim . "', '" . $id_penerima . "', '" . $id_lampiran . "', '" . $nomorParcel . "', '" . $banyak_parcel . "', 'TBA' , 'jayadi@compnet.co.id')";
$queParcel = $dbeta->query($insertParcel);

$emailITS = "ria.romasari@compnet.co.id, heri@compnet.co.id, tito.tri@compnet.co.id, rizky.adji@compnet.co.id";

// Email Notifikasi
if ($quePengirim && $quePenerima && $queParcel) {
    $to = $emailITS;
    $cc = "";
    $bcc = "";

    $subject = "Informasi Keputusan Parcel";
    $message = 'Dear Mr Jayadi Candra,' . '<br><br>' .
        'Parcel has just been received with the following details:' . '<br><br>' .
        '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
                            <tr>
                                <td style="border: 1px solid #000;">No Parcel</td>
                                <td style="border: 1px solid #000;">' . $nomorParcel . '</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000;">Nama Pengirim</td>
                                <td style="border: 1px solid #000;">' . $nama_pengirim . '</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000;">Perusahaan Pengirim</td>
                                <td style="border: 1px solid #000;">' . $perusahaan_pengirim . '</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000;">Nama Penerima</td>
                                <td style="border: 1px solid #000;">' . $full_name . '</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000;">Department Penerima</td>
                                <td style="border: 1px solid #000;">' . $nameDepart . '</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000;">PT Penerima</td>
                                <td style="border: 1px solid #000;">' . $namePT . '</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000;">Estimasi Nominal</td>
                                <td style="border: 1px solid #000;">' . $namaCurrency . '  ' . $estimasi_nominal . '</td>
                            </tr>
                        </table>' . '<br><br>' .
        'Please input the Keputusan for Parcel at the following link: <a href="https://apps.compnet.co.id/engineering/keputusan-parcel/">Link</a>' . '<br><br><br>' .
        'Thank you.';

    $attachment = [];
    kirimemail_noreply_cl($to, $subject, $message, $cc, $bcc, $attachment);

    $output = [
        'code' => 200,
        'msg' => 'Add data is Success!'
    ];
} else {
    $output = ['msg' => 'Add data is failed!'];
}


// $output = array(
//     "quePengirim" => $insertPengirim,
//     "quePenerima" => $insertPenerima,
//     "queLampiran" => $insertLampiran,
//     "queParcel" => $insertParcel,
// );

echo json_encode($output);
