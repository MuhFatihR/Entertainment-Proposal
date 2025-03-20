<?php
include "../../config.php";

$start = $_POST['start'] ?? "0";
$length = $_POST['length'] ?? "10";

$no_parcel = $_REQUEST['no_parcel_filter'] ?? "";
$nama_pengirim = $_REQUEST['nama_pengirim_filter'] ?? "";
$perusahaan_pengirim = $_REQUEST['perusahaan_pengirim_filter'] ?? "";
$currency = $_REQUEST['currency_filter'] ?? "";
$estimasi_nominal = $_REQUEST['estimasi_nominal_filter'] ?? "";
$source_info_nominal = $_REQUEST['source_info_nominal_filter'] ?? "";
$nama_penerima = $_REQUEST['nama_penerima_filter'] ?? "";
$department_penerima = $_REQUEST['department_penerima_filter'] ?? "";
$pt_penerima = $_REQUEST['pt_penerima_filter'] ?? "";
$keputusan = $_REQUEST['keputusan_filter'] ?? "";

$getUserEmail = isset($_POST['useremail']) ? $_POST['useremail'] : '';
// $getUserEmail = 'jayadi@compnet.co.id';

    if($no_parcel) {
        $where[] = "no_parcel LIKE '%" . $no_parcel . "%'";
    }
    if($nama_pengirim) {
        $where[] = "nama_pengirim LIKE '%" . $nama_pengirim . "%'";
    }
    if($perusahaan_pengirim) {
        $where[] = "perusahaan_pengirim LIKE '%" . $perusahaan_pengirim . "%'";
    }
    if($currency){
        $where[] = "nama_currency LIKE '%" . $currency . "%'";
    }
    if($estimasi_nominal){
        $where[] = "estimasi_nominal LIKE '%" . $estimasi_nominal . "%'";
    }
    if($source_info_nominal){
        $where[] = "source_info_nominal LIKE '%" . $source_info_nominal . "%'";
    }
    if($nama_penerima){
        $where[] = "parcel_penerima.nama_penerima LIKE '%" . $nama_penerima . "%'";
    }
    if($department_penerima){
        $where[] = "parcel_penerima.department_penerima LIKE '%" . $department_penerima . "%'";
    }
    if($pt_penerima){
        $where[] = "parcel_penerima.pt_penerima LIKE '%" . $pt_penerima . "%'";
    }
    if($keputusan){
        $where[] = "parcel.keputusan LIKE '%" . $keputusan . "%'";
    }

    if (!empty($where)) {
        $where_clause = ' WHERE ' . implode(' AND ', $where) . " AND parcel.approver_email = '" . $getUserEmail . "'";
    } else {
        $where_clause = " WHERE parcel.approver_email = '" . $getUserEmail . "'";
    }
    
    // GET DATA
    $getData = "SELECT 
                    parcel.id, parcel.keputusan, parcel.approver_email, parcel.no_parcel,
                    parcel_pengirim.nama_pengirim, parcel_pengirim.perusahaan_pengirim, parcel_pengirim.estimasi_nominal, parcel_pengirim.source_info_nominal,
                    parcel_penerima.nama_penerima, parcel_penerima.department_penerima, parcel_penerima.pt_penerima,
                    currency.nama_currency
                FROM parcel
                JOIN parcel_penerima
                ON parcel.id_penerima = parcel_penerima.id
                JOIN parcel_pengirim
                ON parcel.id_pengirim = parcel_pengirim.id
                JOIN currency
                ON parcel_pengirim.id_currency = currency.id" . $where_clause;
    $queData = $dbeta->query($getData);
    $count = $queData->num_rows;


    if ($length != -1) {
        $limit = "LIMIT " . $start . "," . $length;
    } else {
        $limit = "";
    }

    $getShowData = $getData . " ORDER BY parcel.id DESC " . $limit;
    $queShowData = $dbeta->query($getShowData); 
    $list = $queShowData->fetch_all(MYSQLI_ASSOC);

    $data = array();
    $no = $start + 1;

    foreach ($list as $filter) {
        $row = array();
        $row[] = $no++;
        $row[] = $filter['no_parcel'];
        $row[] = $filter['nama_pengirim'];
        $row[] = $filter['perusahaan_pengirim'];
        $row[] = $filter['nama_penerima'];
        $row[] = $filter['department_penerima'];
        $row[] = $filter['pt_penerima'];
        $row[] = $filter['nama_currency'];
        $row[] = $filter['estimasi_nominal'];
        $row[] = $filter['source_info_nominal'];
        $row[] = $filter['keputusan'];
        $row[] = '<button type="button" class="btn btn-sm btn-primary showDetail" data-id="' . $filter['id'] . '"> Detail </button>';
        $data[] = $row;
    }

$output = array(
    "draw" => $_POST['draw'],
    "recordsTotal" => $count,
    "recordsFiltered" => $count,
    "data" => $data,
);

echo json_encode($output);