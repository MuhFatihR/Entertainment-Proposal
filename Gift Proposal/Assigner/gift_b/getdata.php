<?php
include "../../config.php";

$start = $_POST['start'] ?? "0";
$length = $_POST['length'] ?? "10";

$no_pengajuan = $_REQUEST['no_pengajuan_filter'] ?? "";
$nama_pelapor = $_REQUEST['nama_filter'] ?? "";
$direktorat_pelapor = $_REQUEST['direktorat_filter'] ?? "";
$nama_penerima = $_REQUEST['nama_penerima_filter'] ?? "";
$perusahaan_penerima = $_REQUEST['perusahaan_penerima_filter'] ?? "";
$jenis_pemberian = $_REQUEST['jenis_pemberian_filter'] ?? "";
$tanggal_palaporan = $_REQUEST['tanggal_pengajuan_filter'] ?? "";
$tanggal_diberikan = $_REQUEST['tanggal_diberikan_filter'] ?? "";
$status_approval = $_REQUEST['status_approval_filter'] ?? "";

$where = [];
if($no_pengajuan) {
    $where[] = "pengajuan_form_b.nomor_pengajuan_b LIKE '%" . $no_pengajuan . "%'";
}
if($nama_pelapor) {
    $where[] = "pengajuan_form_b.nama_pelapor LIKE '%" . $nama_pelapor . "%'";
}
if($direktorat_pelapor) {
    $where[] = "pengajuan_form_b.direktorat_pelapor LIKE '%" . $direktorat_pelapor . "%'";
}
if($nama_penerima){
    $where[] = "pengajuan_form_b.nama_penerima_b LIKE '%" . $nama_penerima . "%'";
}
if($perusahaan_penerima){
    $where[] = "pengajuan_form_b.perusahaan_penerima_b LIKE '%" . $perusahaan_penerima . "%'";
}
if($jenis_pemberian){
    $where[] = "pengajuan_form_b.jenis_pemberian_b LIKE '%" . $jenis_pemberian . "%'";
}
if($tanggal_palaporan){
    $where[] = "pengajuan_form_b.tanggal_pelaporan LIKE '%" . $tanggal_palaporan . "%'";
}
if($tanggal_diberikan){
    $where[] = "pengajuan_form_b.tanggal_diberikan_b LIKE '%" . $tanggal_diberikan . "%'";
}
if($status_approval){
    $where[] = "pengajuan_form_b.status_approval_b LIKE '%" . $status_approval . "%'";
}
$where_clause = $where ? ' WHERE ' . implode(' AND ', $where) : '';

$getData = "SELECT * FROM pengajuan_form_b" . $where_clause;
$queData = $dbeta->query($getData);
$count = $queData->num_rows;

if ($length != -1) {
    $limit = "LIMIT " . $start . "," . $length;
} else {
    $limit = "";
}

$getShowData = $getData . " ORDER BY id DESC " . $limit;
$queShowData = $dbeta->query($getShowData);
$list = $queShowData->fetch_all(MYSQLI_ASSOC);

$data = array();
$no = $start + 1;

foreach ($list as $dataForm) {
    $row = array();
    $row[] = $no++;
    $row[] = $dataForm['nomor_pengajuan_b'];
    $row[] = $dataForm['nama_pelapor'];
    $row[] = $dataForm['direktorat_pelapor'];
    $row[] = $dataForm['nama_penerima_b'];
    $row[] = $dataForm['perusahaan_penerima_b'];
    $row[] = $dataForm['jenis_pemberian_b'];
    $row[] = $dataForm['tanggal_pelaporan'];
    $row[] = $dataForm['tanggal_diberikan_b'];
    $row[] = $dataForm['status_approval_b'];
    $row[] = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDetail" id="' . $dataForm['id'] . '" id_a="' . $dataForm['id_pengajuan_a'] . '" onclick="modalShow(this)">Detail</button>'; // Value ini akan dikirim ke AJAX (js) 

    $data[] = $row;
}

$output = array(
    "draw" => $_POST['draw'],
    "recordsTotal" => $count,
    "recordsFiltered" => $count,
    "data" => $data,
);
echo json_encode($output);