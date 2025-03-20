<?php
include "../../config.php";

$id = $_REQUEST['id'] ?? "";

$getDataPengajuan = "SELECT
							pfA.id AS id,
							pfA.id_currency,
							pfA.tanggal_pengajuan,
							pfA.id_nama_pengusul,
							pfA.nama_pengusul,
							pfA.jabatan_pengusul,
							pfA.direktorat_pengusul,
							pfA.jenis_pemberian_gift,
							pfA.jenis_pemberian_entertainment,
							pfA.jenis_pemberian_other,
							pfA.nama_penerima,
							pfA.perusahaan_penerima,
							pfA.tanggal_diberikan,
							pfA.tempat_diberikan,
							pfA.tujuan_pemberian,
							pfA.estimasi_biaya,
							pA.id_pengajuan_a AS id_pengajuan_a,
							pA.nama_peserta_perusahaan,
							pA.direktorat_peserta_perusahaan,
							cu.id,
							cu.nama_currency
                        FROM pengajuan_form_a pfA
						JOIN peserta_a pA
						ON pfA.id = pA.id_pengajuan_a
						JOIN currency cu
						ON cu.id = pfA.id_currency
                        WHERE pfA.id = '" . $id . "'";
$queDataPengajuan = $dbeta->query($getDataPengajuan);
$list = mysqli_fetch_assoc($queDataPengajuan);
$id_nama_pengusul = $list['id_nama_pengusul'];


$getDataPeserta = "SELECT *
					FROM peserta_a
					WHERE id_pengajuan_a = '" . $id . "'";
$queDataPeserta = $dbeta->query($getDataPeserta);
$dataPeserta = $queDataPeserta->fetch_all(MYSQLI_ASSOC);

// Ekstrak nama_peserta_perusahaan & direktorat
$namePeserta = array_column($dataPeserta, 'nama_peserta_perusahaan');
$direktoratPeserta = array_column($dataPeserta, 'direktorat_peserta_perusahaan');



// Search manager_id FROM id_nama_pengusul
$getIDManager	= "SELECT 
						id, full_name, manager_id
					FROM employee
					WHERE id = '" . $id_nama_pengusul . "'";
$queIDManager = $db->query($getIDManager);
$resultIDManager = mysqli_fetch_assoc($queIDManager);
$manager_id = $resultIDManager['manager_id']; // id manager pengusul


// GET MANAGER
$getDataManager = "SELECT *
						FROM approval_a
						WHERE id_pengajuan_a = '" . $id . "'
						AND id_employee = '" . $manager_id . "'";
$queDataManager = $dbeta->query($getDataManager);
$resultManager = mysqli_fetch_assoc($queDataManager);


// GET CCO
$getDataCCO = "SELECT *
					FROM approval_a
					WHERE id_pengajuan_a = '" . $id . "'
					AND id_employee = '4'";
$queDataCCO = $dbeta->query($getDataCCO);
$resultCCO = mysqli_fetch_assoc($queDataCCO);

?>
<style>
	@page {
		size: auto;
		margin: 5mm;
	}

	body {
		margin: 0mm 5mm 5mm 5mm;
	}
</style>

<div class="main-content container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default panel-border-color panel-border-color-primary">
				<div class="panel-heading">

					<body>

						<!-- Judul -->
						<table style="border-collapse: collapse;" width="100%">
							<tr>
								<td> <strong style="font-size: 20px;"> Formulir 1A </strong> </td>
							</tr>
							<tr>
								<td> <strong style="font-size: 20px;"> Pengajuan Pemberian Hadiah/ Hiburan - Klasifikasi B </strong> </td>
							</tr>
							<tr>
								<td> (Application Form for Gifts/ Entertainment of Classification B) </td>
							</tr>
						</table>

						<!-- Data -->
						<table style="border-collapse: collapse; margin-top: 15px;" width="100%;">
							<tr>
								<td colspan="1" style="border: 1px solid black; width: 200px; padding-left: 5px;">Tanggal Pengajuan/Date</td>
								<td colspan="2" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['tanggal_pengajuan']; ?></td>
							</tr>
							<tr>
								<td colspan="1" style="border: 1px solid black; width: 200px; padding-left: 5px;">Nama/Name</td>
								<td colspan="2" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['nama_pengusul']; ?></td>
							</tr>
							<tr>
								<td colspan="1" style="border: 1px solid black; width: 200px; padding-left: 5px;">Jabatan / Position</td>
								<td colspan="2" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['jabatan_pengusul']; ?></td>
							</tr>
							<tr>
								<td colspan="1" style="border: 1px solid black; width: 200px; padding-left: 5px;">Direktorat / Directorate</td>
								<td colspan="2" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['direktorat_pengusul']; ?></td>
							</tr>

							<!-- Jenis Pemberian Gift -->
							<tr>
								<td colspan="1" rowspan="3" style="border: 1px solid black; padding-left: 5px;">Jenis Pemberian/ Subject of Application</td>
								<?php
								if ($list['jenis_pemberian_gift'] !== '-' && trim($list['jenis_pemberian_gift']) !== '') {
									echo '<td colspan="1" style="border: 1px solid black; text-align: center">&#10003;</td>';
								} else {
									echo '<td colspan="1" style="border: 1px solid black; text-align: center"></td>';
								}
								?>

								<?php
								if (trim($list['jenis_pemberian_gift']) !== '' && trim($list['jenis_pemberian_gift'] !== '-')) {
									echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;"> Gift: ' . $list['jenis_pemberian_gift'] . '</td>';
								} else {
									echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;"> Gift: -</td>';
								}
								?>
							</tr>

							<!-- Jenis Pemberian Entertainment -->
							<tr>
								<?php
								if ($list['jenis_pemberian_entertainment'] !== '-' && trim($list['jenis_pemberian_entertainment']) !== '') {
									echo '<td colspan="1" style="border: 1px solid black; text-align: center">&#10003;</td>';
								} else {
									echo '<td colspan="1" style="border: 1px solid black; text-align: center"></td>';
								}
								?>

								<?php
								if (trim($list['jenis_pemberian_entertainment']) !== '' && trim($list['jenis_pemberian_entertainment'] !== '-')) {
									echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;"> Entertainment: ' . $list['jenis_pemberian_entertainment'] . '</td>';
								} else {
									echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;"> Entertainment: -</td>';
								}
								?>
							</tr>

							<!-- Jenis Pemberian Other -->
							<tr>
								<?php
								if ($list['jenis_pemberian_other'] !== '-' && trim($list['jenis_pemberian_other']) !== '') {
									echo '<td colspan="1" style="border: 1px solid black; text-align: center;">&#10003;</td>';
								} else {
									echo '<td colspan="1" style="border: 1px solid black; text-align: center;"></td>';
								}
								?>

								<?php
								if (trim($list['jenis_pemberian_other']) !== '' && trim($list['jenis_pemberian_other'] !== '-')) {
									echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;"> Other: ' . $list['jenis_pemberian_other'] . '</td>';
								} else {
									echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;"> Other: -</td>';
								}
								?>
							</tr>

							<!-- Detail Penerima -->
							<tr>
								<td colspan="1" rowspan="2" style="border: 1px solid black; padding-left: 5px;">Detail Penerima / Recipient Details</td>
								<td colspan="1" style="border: 1px solid black; width: 100px; padding-left: 5px;">Nama / Name</td>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['nama_penerima']; ?></td>
							</tr>
							<tr>
								<td colspan="1" style="border: 1px solid black; width: 100px; padding-left: 5px;">Perusahaan/ Instansi <br> Company/ Institution</td>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['perusahaan_penerima']; ?></td>
							</tr>


							<!-- Tanggal Diberikan -->
							<tr>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;">Tanggal Diberikan / Scheduled Date</td>
								<td colspan="2" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['tanggal_diberikan']; ?></td>
							</tr>

							<!-- Tempat Diberikan -->
							<tr>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;">Tempat Diberikan/ Scheduled Venue</td>
								<td colspan="2" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['tempat_diberikan']; ?></td>
							</tr>

							<!-- Tujuan Pemberian -->
							<tr>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;">Tujuan Pemberian/ Purpose</td>
								<td colspan="2" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['tujuan_pemberian']; ?></td>
							</tr>

							<!-- Estimasi Biaya -->
							<tr>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;">Estimasi Biaya (per orang untuk hiburan) / Cost Estimation (per person for entertainment)</td>
								<td colspan="2" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['nama_currency'] . ' ' . $list['estimasi_biaya'];; ?></td>
							</tr>


							<!-- Peserta Perusahaan -->
			
							<tr>
                                <td colspan="1" rowspan="2" style="border: 1px solid black; padding-left: 5px;">Peserta Dari Perusahaan / Participants From the Company</td>
								<td colspan="1" style="border: 1px solid black; width: 150px; padding-left: 5px;">Nama / Name</td>
									<?php
										if (!empty($namePeserta)) {
											echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;">' . implode(', ', $namePeserta) . '</td>';
										} else {
											echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;">-</td>';
										}
									?>
                            </tr>
                           
                            <tr>
								<td colspan="1" style="border: 1px solid black; width: 150px; padding-left: 5px;">Direktorat / Directorate</td>
								<?php
									if (!empty($direktoratPeserta)) {
										echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;">' . implode(', ', $direktoratPeserta) . '</td>';
									} else {
										echo '<td colspan="1" style="border: 1px solid black; padding-left: 5px;">-</td>';
									}
                                ?>
                            </tr>
						</table>

						<!-- TTD -->
						<table style="border-collapse: collapse; margin-top: 15px;" width="100%">
							<tr>
								<td colspan="2" style="border: 1px solid black; text-align: center">Diajukan oleh/ Proposed by</td>
								<td colspan="2" style="border: 1px solid black; text-align: center">Diketahui oleh/ Acknowledged by</td>
								<td colspan="2" style="border: 1px solid black; text-align: center">Disetujui oleh/ Approved by</td>
							</tr>

							<tr>
								<td colspan="2" style="border: 1px solid black; height: 100px; text-align: center"> <img src="../../assets/img/check.png" height="100%" alt="" title="" class="img-small"> </td>
								<?php
								if ($resultManager['approval_status'] == 'Approved') {
									echo '<td colspan="2" style="border: 1px solid black; height: 100px; text-align: center"> <img src="../../assets/img/check.png" height="100%" alt="" title="" class="img-small"> </td>';
								} else {
									echo '<td colspan="2" style="border: 1px solid black; height: 100px; text-align: center"></td>';
								}
								?>

								<?php
								if ($resultCCO['approval_status'] == 'Approved') {
									echo '<td colspan="2" style="border: 1px solid black; height: 100px; text-align: center"> <img src="../../assets/img/check.png" height="100%" alt="" title="" class="img-small"> </td>';
								} else {
									echo '<td colspan="2" style="border: 1px solid black; height: 100px; text-align: center"></td>';
								}
								?>
							</tr>

							<tr>
								<td colspan="1" style="border: 1px solid black; width: 50px; padding-left: 5px;"> Nama/ <br> Name</td>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['nama_pengusul']; ?></td>
								<td colspan="1" style="border: 1px solid black; width: 50px; padding-left: 5px;"> Nama/ <br> Name</td>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $resultManager['approver_name']; ?></td>
								<td colspan="1" style="border: 1px solid black; width: 50px; padding-left: 5px;"> Nama/ <br> Name</td>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $resultCCO['approver_name']; ?></td>
							</tr>

							<tr>
								<td colspan="1" style="border: 1px solid black; width: 50px; padding-left: 5px;"> Jabatan/ <br> Position</td>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['jabatan_pengusul']; ?></td>
								<td colspan="1" style="border: 1px solid black; width: 50px; padding-left: 5px;"> Jabatan/ <br> Position</td>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $resultManager['approver_jabatan']; ?></td>
								<td colspan="1" style="border: 1px solid black; width: 50px; padding-left: 5px;"> Jabatan/ <br> Position</td>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;">CCO</td>
							</tr>

							<tr>
								<td colspan="1" style="border: 1px solid black; width: 50px; padding-left: 5px;"> Tanggal/ <br> Date</td>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $list['tanggal_pengajuan']; ?></td>
								<td colspan="1" style="border: 1px solid black; width: 50px; padding-left: 5px;"> Tanggal/ <br> Date</td>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $resultManager['tanggal_approval']; ?></td>
								<td colspan="1" style="border: 1px solid black; width: 50px; padding-left: 5px;"> Tanggal/ <br> Date</td>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;"><?php echo $resultCCO['tanggal_approval']; ?></td>
							</tr>

						</table>

						<!-- Komentar CCO / CCO's comment -->
						<table style="border-collapse: collapse; margin-top: 15px;" width="100%">
							<tr>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px;">Komentar CCO / CCO's comment</td>
							</tr>

							<tr>
								<td colspan="1" style="border: 1px solid black; padding-left: 5px; height: 100px">
									<?php echo $resultCCO['notes']; ?>
								</td>
							</tr>
						</table>

					</body>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	window.print();
</script>