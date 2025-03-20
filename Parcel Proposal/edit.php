<?php
include "../../config.php";

$id_parcel = $_REQUEST['id'];

$nama_pengirim = $_REQUEST['nama_pengirim_detail'];
$perusahaan_pengirim = $_REQUEST['perusahaan_pengirim_detail'];

$nama_penerima = $_REQUEST['nama_penerima_detail'] ?? "0";
$department_penerima = $_REQUEST['department_penerima_detail'] ?? "0";
$pt_penerima = $_REQUEST['pt_penerima_detail'] ?? "0";

$banyak_parcel = $_REQUEST['banyak_parcel_detail'];
$currency = $_REQUEST['currency_detail'];
$estimasi_nominal = $_REQUEST['estimasi_nominal_detail'];
$source_info_nominal = $_REQUEST['source_info_nominal_detail'];

$keputusan = $_REQUEST['keputusan_detail'] ?? "TBA";

$target_dir = "../../fileParcel/";
$file = basename($_FILES["fileInputDetail"]["name"]);
$target_file = $target_dir . basename($file);


    // Get Data Employee (full_name)
    if($nama_penerima != '-'){
        $getNamaPenerima = "SELECT 
                                id, full_name 
                            FROM employee
                            WHERE id = '" . $nama_penerima . "'";
        $queNamaPenerima = $db->query($getNamaPenerima);
        $result = $queNamaPenerima->fetch_assoc();
        $full_name = $result['full_name'];
    } else {
        $nama_penerima = 0;
        $full_name = '-';
    }

    // Get Data Employee (departmentName)
    if($department_penerima != '-'){
        $getDepartmentPenerima = "SELECT 
                                        id, name 
                                    FROM department
                                    WHERE id = '" . $department_penerima . "'";
        $queDepartmentPenerima = $db->query($getDepartmentPenerima);
        $result = $queDepartmentPenerima->fetch_assoc();
        $nameDepart = $result['name'];
    } else {
        $department_penerima = 0;
        $nameDepart = '-';
    }
 
    // Get Data Employee (companyName)
    if($pt_penerima != '-'){    
        $getNamaCompany = "SELECT 
                                id, name 
                            FROM company
                            WHERE id = '" . $pt_penerima . "'";
        $queNamaCompany = $db->query($getNamaCompany);
        $result = $queNamaCompany->fetch_assoc();
        $namePT = $result['name'];
    } else {
        $pt_penerima = 0;
        $namePT = '-';
    }


    // UPDATE TABLE PARCEL PENGIRIM
    if($nama_pengirim){
        $set1[] = "nama_pengirim = '" . $nama_pengirim . "'";
    }
    if($perusahaan_pengirim){
        $set1[] = "perusahaan_pengirim = '" . $perusahaan_pengirim . "'";
    }
    if($currency){
        $set1[] = "id_currency = '" . $currency . "'";
    }
    if($source_info_nominal){
        $set1[] = "source_info_nominal = '" . $source_info_nominal . "'";
    }
    if($estimasi_nominal){
        $set1[] = "estimasi_nominal = " . $estimasi_nominal . "";
    }
    $set1 = "SET " . implode(', ', $set1);

    $updateDataPengirim = "UPDATE parcel_pengirim " . $set1 . " 
                           WHERE id = '" . $id_parcel . "'";
    $queDataPengirim = $dbeta->query($updateDataPengirim);

    // var_dump($nama_penerima);
    // var_dump($full_name);

    // UPDATE TABLE PARCEL PENERIMA
    if($nama_penerima){
        // var_dump('tes');
        $set[] = "id_nama_penerima = '" . $nama_penerima . "'";
    }
    if($nama_penerima == 0){
        // var_dump('tes');
        $set[] = "id_nama_penerima = '" . $nama_penerima . "'";
    }
    if($full_name){
        $set[] = "nama_penerima = '" . $full_name . "'";
    }

    // var_dump($department_penerima);

    if($department_penerima){
        $set[] = "id_department_penerima = '" . $department_penerima . "'";
    }
    if($department_penerima == 0){
        // var_dump('tes');
        $set[] = "id_department_penerima = '" . $department_penerima . "'";
    }
    if($nameDepart){
        $set[] = "department_penerima = '" . $nameDepart . "'";
    }

    if($pt_penerima){
        $set[] = "id_pt_penerima = '" . $pt_penerima . "'";
    }
    if($pt_penerima == 0){
        // var_dump('tes');
        $set[] = "id_pt_penerima = '" . $pt_penerima . "'";
    }
    if($namePT){
        $set[] = "pt_penerima = '" . $namePT . "'";
    }

    $set = "SET " . implode(', ', $set);

    $updateDataPenerima = "UPDATE parcel_penerima " . $set . "
                            WHERE id = '" . $id_parcel . "'";
    $queData = $dbeta->query($updateDataPenerima);



    // UPDATE INTO TABLE LAMPIRAN
    if($file){
        $set2[] = "file_name = '" . $file . "'";
    }
    if($target_file){
        $set2[] = "path = '" . $target_file . "'";
    }
    $set2 = "SET " . implode(', ', $set2);

    if (move_uploaded_file($_FILES["fileInputDetail"]["tmp_name"], $target_file)) {
        $updateDataLampiran = "UPDATE parcel_lampiran " . $set2 . " 
                            WHERE id = '" . $id_parcel . "'";
        $queDataLampiran = $dbeta->query($updateDataLampiran);
    }else{
        $updateDataLampiran = null;
    }



    // UPDATE TABLE PARCEL
    if($banyak_parcel){
        $setParcel[] = "banyak_parcel = '" . $banyak_parcel . "'";
    }
    if($keputusan){
        $setParcel[] = "keputusan = '" . $keputusan . "'";
    }
    $setParcel = "SET " . implode(', ', $setParcel);

    $updateDataParcel = "UPDATE parcel " . $setParcel . " 
                            WHERE id = '" . $id_parcel . "'";
    $queDataParcel = $dbeta->query($updateDataParcel);


    // OUTPUT
    $output = array(
        "quePengirim" => $updateDataPengirim,
        "quePenerima" => $updateDataPenerima,
        "queLampiran" => $updateDataLampiran,
    );
    
echo json_encode($output);