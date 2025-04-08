<?php
include "../../config.php";

$start = $_POST['start'] ?? "0";
$length = $_POST['length'] ?? "10";

$no_pengajuan = $_REQUEST['no_pengajuan_filter'] ?? "";
$nama_pengusul = $_REQUEST['nama_pengusul_filter'] ?? "";
$direktorat_pengusul = $_REQUEST['direktorat_pengusul_filter'] ?? "";
$nama_penerima = $_REQUEST['nama_penerima_filter'] ?? "";
$perusahaan_penerima = $_REQUEST['perusahaan_penerima_filter'] ?? "";
$jenis_pemberian = $_REQUEST['jenis_pemberian_filter'] ?? "";
$tanggal_pengajuan = $_REQUEST['tanggal_pengajuan_filter'] ?? "";
$tanggal_diberikan = $_REQUEST['tanggal_diberikan_filter'] ?? "";
$status_pengajuan = $_REQUEST['status_pengajuan_filter'] ?? "";

$getUserEmail = isset($_POST['useremail']) ? $_POST['useremail'] : '';

$where = [];
if($no_pengajuan) {
    $where[] = "pfA.nomor_pengajuan LIKE '%" . $no_pengajuan . "%'";
}
if($nama_pengusul) {
    $where[] = "pfA.nama_pengusul LIKE '%" . $nama_pengusul . "%'";
}
if($direktorat_pengusul) {
    $where[] = "pfA.direktorat_pengusul LIKE '%" . $direktorat_pengusul . "%'";
}
if($nama_penerima){
    $where[] = "pfA.nama_penerima LIKE '%" . $nama_penerima . "%'";
}
if($perusahaan_penerima){
    $where[] = "pfA.perusahaan_penerima LIKE '%" . $perusahaan_penerima . "%'";
}
if($jenis_pemberian){
    $where[] = "pfA.jenis_pemberian LIKE '%" . $jenis_pemberian . "%'";
}
if($tanggal_pengajuan){
    $where[] = "pfA.tanggal_pengajuan LIKE '%" . $tanggal_pengajuan . "%'";
}
if($tanggal_diberikan){
    $where[] = "pfA.tanggal_diberikan LIKE '%" . $tanggal_diberikan . "%'";
}
if($status_pengajuan){
    $where[] = "appA.approval_status LIKE '%" . $status_pengajuan . "%'";
}

if (!empty($where)) {
    $where_clause = ' WHERE ' . implode(' AND ', $where) . " AND appA.approver_email = '" . $getUserEmail . "'";
} else {
    $where_clause = " WHERE appA.approver_email = '" . $getUserEmail . "'";
}

// GET DATA
$getData = "SELECT 
                pfA.id AS id,
                pfA.nomor_pengajuan AS nomor_pengajuan,
                pfA.nama_pengusul AS nama_pengusul,
                pfA.direktorat_pengusul AS direktorat_pengusul,
                pfA.nama_penerima AS nama_penerima,
                pfA.perusahaan_penerima AS perusahaan_penerima,
                pfA.jenis_pemberian AS jenis_pemberian,
                pfA.tanggal_pengajuan AS tanggal_pengajuan,
                pfA.tanggal_diberikan AS tanggal_diberikan,
                appA.approval_status AS approval_status,
                appA.id AS idApprover,
                appA.approver_email
            FROM pengajuan_form_a pfA
            JOIN approval_a appA
            ON pfA.id = appA.id_pengajuan_a" . $where_clause;
            // echo($getData);
$queData = $dbeta->query($getData);
$count = $queData->num_rows;

if ($length != -1) {
    $limit = "LIMIT " . $start . "," . $length;
} else {
    $limit = "";
}

$getShowData = $getData . " ORDER BY approval_status DESC, tanggal_pengajuan DESC " . $limit;
$queShowData = $dbeta->query($getShowData); 
$list = $queShowData->fetch_all(MYSQLI_ASSOC);

$data = array();
$no = $start + 1;;

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
    $row[] = $dataForm['approval_status'];
    $row[] = '<button type="button" class="btn btn-sm btn-primary showDetail" data-id="' . $dataForm['id'] . '" data-idapprover ="' . $dataForm['idApprover'] . '"> Detail </button>'; // Value ini akan dikirim ke AJAX (js) 
    $data[] = $row;
}

$output = array(
    "draw" => $_POST['draw'],
    "recordsTotal" => $count,
    "recordsFiltered" => $count,
    "data" => $data,
);

echo json_encode($output);
