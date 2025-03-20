<?php
include "../../config.php";
include "../../init_email.php";

$id_parcel = $_REQUEST['id'];
$keputusan = $_REQUEST['keputusan_detail'];
$note = $_REQUEST['note_keputusan_detail'] ?? "";

    if($keputusan){
        $set[] = "keputusan = '" . $keputusan . "'";
    }
    if($note){
        $set[] = "note_keputusan = '" . $note . "'";
    }
    $set = "SET " . implode(', ', $set);

    $updateDataPenerima = "UPDATE parcel " . $set . "
                            WHERE id = '" . $id_parcel . "'";
    $queData = $dbeta->query($updateDataPenerima);


    $getDataParcel = "SELECT
                            parcel.id,
                            parcel.no_parcel,
                            parcel_pengirim.nama_pengirim AS nama_pengirim, 
                            parcel_pengirim.perusahaan_pengirim AS perusahaan_pengirim, 
                            parcel_pengirim.estimasi_nominal AS estimasi_nominal, 
                            parcel_penerima.nama_penerima AS nama_penerima, 
                            parcel_penerima.department_penerima AS department_penerima, 
                            parcel_penerima.pt_penerima AS pt_penerima,
                            currency.nama_currency AS nama_currency
                        FROM parcel
                        JOIN parcel_penerima
                        ON parcel.id_penerima = parcel_penerima.id
                        JOIN parcel_pengirim
                        ON parcel.id_pengirim = parcel_pengirim.id
                        JOIN currency
                        ON parcel_pengirim.id_currency = currency.id
                        WHERE parcel.id = '" . $id_parcel . "'";
    $queData = $dbeta->query($getDataParcel);
    $result = $queData->fetch_assoc();

    $no_parcel = $result['no_parcel'];
    $full_name = $result['nama_penerima'];
    $nameDepart = $result['department_penerima'];
    $namePT = $result['pt_penerima'];
    $nama_pengirim = $result['nama_pengirim'];
    $perusahaan_pengirim = $result['perusahaan_pengirim'];
    $estimasi_nominal = $result['estimasi_nominal'];
    $namaCurrency = $result['nama_currency'];

    $emailITS = "ria.romasari@compnet.co.id, heri@compnet.co.id, tito.tri@compnet.co.id, rizky.adji@compnet.co.id";

    // Email Notifikasi
    if($queData){
        // $to = "reffi@compnet.co.id";
        $to = $emailITS;
        $cc = "";                
        $bcc = "";

        $subject = "Informasi Keputusan Parcel";
        $message = 'Dear Ms Reffi Sugiarti, <br><br>' .
                    'Parcel <b>' . $no_parcel . '</b> has been given Keputusan to <b>' . $keputusan . '</b> with the following parcel details:' . '<br><br>' .
                        '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
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
                    'To see the details of the Parcel and its Keputusan, you can go through the following link: <a href="https://apps.compnet.co.id/engineering/parcel/">Link</a>' . '<br><br><br>' .
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
    //     "quePenerima" => $updateDataPenerima,
    // );
    
echo json_encode($output);