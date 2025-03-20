<?php
include "../../config.php";

$start = $_POST['start'] ?? "0";
$length = $_POST['length'] ?? "10";

$nomor_pengajuan = $_REQUEST['nomor_pengajuan_filter'] ?? "";
$nama = $_REQUEST['nama_filter'] ?? "";
$direktorat = $_REQUEST['direktorat_filter'] ?? "";
$nama_penerima = $_REQUEST['nama_penerima_filter'] ?? "";
$perusahaan_penerima = $_REQUEST['perusahaan_penerima_filter'] ?? "";
$jenis_pemberian = $_REQUEST['jenis_pemberian_filter'] ?? "";
$tanggal_pengajuan = $_REQUEST['tanggal_pengajuan_filter'] ?? "";
$tanggal_diberikan = $_REQUEST['tanggal_diberikan_filter'] ?? "";
$status_approval = $_REQUEST['status_approval_filter'] ?? "";

$where = [];
if($nomor_pengajuan) {
    $where[] = "pengajuan_form_a.nomor_pengajuan LIKE '%" . $nomor_pengajuan . "%'";
}
if($nama) {
    $where[] = "pengajuan_form_a.nama_pengusul LIKE '%" . $nama . "%'";
}
if($direktorat) {
    $where[] = "pengajuan_form_a.direktorat_pengusul LIKE '%" . $direktorat . "%'";
}
if($nama_penerima){
    $where[] = "pengajuan_form_a.nama_penerima LIKE '%" . $nama_penerima . "%'";
}
if($perusahaan_penerima){
    $where[] = "pengajuan_form_a.perusahaan_penerima LIKE '%" . $perusahaan_penerima . "%'";
}
if($jenis_pemberian){
    $where[] = "pengajuan_form_a.jenis_pemberian LIKE '%" . $jenis_pemberian . "%'";
}
if($tanggal_pengajuan){
    $where[] = "pengajuan_form_a.tanggal_pengajuan LIKE '%" . $tanggal_pengajuan . "%'";
}
if($tanggal_diberikan){
    $where[] = "pengajuan_form_a.tanggal_diberikan LIKE '%" . $tanggal_diberikan . "%'";
}
if($status_approval){
    $where[] = "pengajuan_form_a.status_pengajuan LIKE '%" . $status_approval . "%'";
}
$where_clause = $where ? ' WHERE ' . implode(' AND ', $where) : '';


// GET DATA
$getData = "SELECT * 
            FROM pengajuan_form_a" . $where_clause;
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
    $row[] = $dataForm['nomor_pengajuan'];
    $row[] = $dataForm['nama_pengusul'];
    $row[] = $dataForm['direktorat_pengusul'];
    $row[] = $dataForm['nama_penerima'];
    $row[] = $dataForm['perusahaan_penerima'];
    $row[] = $dataForm['jenis_pemberian'];
    $row[] = $dataForm['tanggal_pengajuan'];
    $row[] = $dataForm['tanggal_diberikan'];
    $row[] = $dataForm['status_pengajuan'];
    $row[] = '<button type="button" class="btn btn-sm btn-primary showDetail" data-id="' . $dataForm['id'] . '"> Detail </button>'; // Value ini akan dikirim ke AJAX (js) 
    $data[] = $row;
}

$output = array(
    "draw" => $_POST['draw'],
    "recordsTotal" => $count,
    "recordsFiltered" => $count,
    "data" => $data,
);
echo json_encode($output);