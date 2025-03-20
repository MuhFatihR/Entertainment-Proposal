<?php
include "../../config.php";

    $id = $_REQUEST['id'];

    $getParcelData = "SELECT 
                            A.id, A.id_penerima, A.id_pengirim, A.id_lampiran, A.banyak_parcel, A.keputusan, A.note_keputusan, A.no_parcel,
                            B.id_nama_penerima ,B.nama_penerima, B.department_penerima, B.id_department_penerima, B.pt_penerima, B.id_pt_penerima, 
                            C.nama_pengirim, C.perusahaan_pengirim , C.id_currency , C.estimasi_nominal, C.source_info_nominal,
                            D.file_name, D.path 
                        FROM parcel A
                        JOIN parcel_penerima B
                        ON A.id_penerima = B.id

                        JOIN parcel_pengirim C
                        ON A.id_pengirim = C.id

                        JOIN parcel_lampiran D
                        ON A.id_lampiran = D.id
                        WHERE A.id = '" . $id . "'";
    $queParcelData = $dbeta->query($getParcelData);
    $data = $queParcelData->fetch_assoc();
    
    $output = array(
        "data" => $data
    );

echo json_encode($output);
