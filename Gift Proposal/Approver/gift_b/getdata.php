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

$email = isset($_POST['useremail']) ? $_POST['useremail'] : '';
// $email = 'jayadi@compnet.co.id';

$where = [];
if($no_pengajuan) {
    $where[] = "pf.nomor_pengajuan_b LIKE '%" . $no_pengajuan . "%'";
}
if($nama_pelapor) {
    $where[] = "pf.nama_pelapor LIKE '%" . $nama_pelapor . "%'";
}
if($direktorat_pelapor) {
    $where[] = "pf.direktorat_pelapor LIKE '%" . $direktorat_pelapor . "%'";
}
if($nama_penerima){
    $where[] = "pf.nama_penerima_b LIKE '%" . $nama_penerima . "%'";
}
if($perusahaan_penerima){
    $where[] = "pf.perusahaan_penerima_b LIKE '%" . $perusahaan_penerima . "%'";
}
if($jenis_pemberian){
    $where[] = "pf.jenis_pemberian_b LIKE '%" . $jenis_pemberian . "%'";
}
if($tanggal_palaporan){
    $where[] = "pf.tanggal_pelaporan LIKE '%" . $tanggal_palaporan . "%'";
}
if($tanggal_diberikan){
    $where[] = "pf.tanggal_diberikan_b LIKE '%" . $tanggal_diberikan . "%'";
}
if($status_approval){
    $where[] = "ab.approval_status_b LIKE '%" . $status_approval . "%'";
}

if (!empty($where)) {
    $where_clause = ' WHERE ' . implode(' AND ', $where) . " AND ab.approver_email = '" . $email . "'";
} else {
    $where_clause = " WHERE ab.approver_email = '" . $email . "'";
}

$getData = "SELECT ab.id AS id,
                    ab.approval_status_b AS approval_status_b,
                    ab.approver_email, 
                    pf.id_pengajuan_a AS id_pengajuan_a, 
                    pf.nomor_pengajuan_b AS nomor_pengajuan_b, 
                    pf.nama_pelapor AS nama_pelapor, 
                    pf.direktorat_pelapor AS direktorat_pelapor, 
                    pf.nama_penerima_b AS nama_penerima_b, 
                    pf.perusahaan_penerima_b AS perusahaan_penerima_b, 
                    pf.jenis_pemberian_b AS jenis_pemberian_b, 
                    pf.tanggal_pelaporan AS tanggal_pelaporan,
                    pf.tanggal_diberikan_b AS tanggal_diberikan_b, 
                    pf.id AS pf_id
            FROM approval_b ab 
            JOIN pengajuan_form_b pf ON ab.id_pengajuan_b = pf.id " . $where_clause;
$queData = $dbeta->query($getData);
$count = $queData->num_rows;

if ($length != -1) {
    $limit = "LIMIT " . $start . "," . $length;
} else {
    $limit = "";
}

$getShowData = $getData . " ORDER BY approval_status_b DESC, tanggal_pelaporan DESC " . $limit;
$queShowData = $dbeta->query($getShowData);
$list = $queShowData->fetch_all(MYSQLI_ASSOC);

$data = array();
$no = $start + 1;;

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
    $row[] = $dataForm['approval_status_b'];
    $row[] = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDetail" id="' . $dataForm['pf_id'] . '" data_appid="' . $dataForm['id'] . '" id_a="' . $dataForm['id_pengajuan_a'] . '" onclick="modalShow(this)">Detail</button>'; // Value ini akan dikirim ke AJAX (js) 
    // $row[] = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDetail" id="' . $filter['id_parcel'] . '" onclick="modalShow(this)">Detail</button>'; // Saat diclick akan kebentuk 

    $data[] = $row;
}

$output = array(
    "draw" => $_POST['draw'],
    "recordsTotal" => $count,
    "recordsFiltered" => $count,
    "data" => $data,
);

echo json_encode($output);