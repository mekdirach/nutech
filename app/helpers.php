<?php

namespace App;

function getDummyUim($data)
{
    $username = $data['userId'];
    $H479 = [
        "nama" => "AYUNINGTYAS DWI UTAMI",
        "nip" => null,
        "userId" => "H479",
        "kodeCabang" => "0114",
        "namaCabang" => "SUKAJADI",
        "kodeInduk" => "0114",
        "namaInduk" => "SUKAJADI",
        "kodeKanwil" => "1111",
        "namaKanwil" => "KANTOR WILAYAH 1",
        "jabatan" => "Customer Service",
        "email" => "aautami@BANKBJB.CO.ID",
        "idFungsi" => "3367",
        "namaFungsi" => "CS",
        "kodePenempatan" => "0114",
        "namaPenempatan" => "SUKAJADI",
        "id" => "11290"
    ];

    $Y136 = [
        "nama" => "KETY KUSMAWATI",
        "nip" => "12.89.3537",
        "userId" => "Y136",
        "kodeCabang" => "D440",
        "namaCabang" => "DIVISI INFORMATION TECHNOLOGY",
        "kodeInduk" => "D440",
        "namaInduk" => "DIVISI INFORMATION TECHNOLOGY",
        "kodeKanwil" => "0000",
        "namaKanwil" => "Kantor Pusat",
        "jabatan" => "Staf Business Analyst Corporate Services",
        "email" => "kkusmawati@BANKBJB.CO.ID",
        "idFungsi" => "3370",
        "namaFungsi" => "Divisi IT",
        "kodePenempatan" => "D440",
        "namaPenempatan" => "DIVISI INFORMATION TECHNOLOGY",
        "id" => "16118"
    ];

    $J570 = [
        "nama" => "KIRARA RIZKIANA DENEVA",
        "nip" => "16.92.0118",
        "userId" => "J570",
        "kodeCabang" => "D156",
        "namaCabang" => "DIVISI DANA & JASA KONSUMER",
        "kodeInduk" => "D156",
        "namaInduk" => "DIVISI DANA & JASA KONSUMER",
        "kodeKanwil" => "0000",
        "namaKanwil" => "Kantor Pusat",
        "jabatan" => "Staf Business Support - Dana Jasa Konsumer",
        "email" => "kdeneva@BANKBJB.CO.ID",
        "idFungsi" => "3372",
        "namaFungsi" => "Maker DJK",
        "kodePenempatan" => "D156",
        "namaPenempatan" => "DIVISI DANA & JASA KONSUMER",
        "id" => "15113"
    ];

    $user = [
        'H479' => $H479,
        'Y136' => $Y136,
        'J570' => $J570,
    ];

    $res = [
        'statusCode' => isset($user[$username]) ? '200' : 'rc-dummy-gagal',
        'message' => isset($user[$username]) ? 'Sukses' : 'Gagal',
        'data' => isset($user[$username]) ? $user[$username] : '',
    ];
    return $res;
}
