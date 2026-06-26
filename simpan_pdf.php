<?php
// ======================================
// FOLDER PENYIMPANAN BUKTI PENDAFTARAN
// ======================================
$folder = "Bukti Pendaftaran/";

// Membuat folder jika belum ada
if(!is_dir($folder)){
    mkdir($folder,0777,true);
}

// ======================================
// MEMERIKSA DATA YANG DIKIRIM DARI Tampil.php
// ======================================
if(isset($_POST['pdf']) && isset($_POST['nim'])){

    // Mengambil data PDF (Base64)
    $pdf = $_POST['pdf'];

    // Mengambil NIM mahasiswa
    $nim = trim($_POST['nim']);

    // ======================================
    // MENGHAPUS HEADER BASE64 PDF
    // ======================================
    $pdf = str_replace(
        'data:application/pdf;base64,',
        '',
        $pdf
    );

    // Mengubah spasi menjadi tanda +
    $pdf = str_replace(
        ' ',
        '+',
        $pdf
    );

    // ======================================
    // MENGUBAH BASE64 MENJADI DATA PDF
    // ======================================
    $data = base64_decode($pdf);

    // Jika proses decode gagal
    if($data===false){
        echo "error";
        exit;
    }

    // ======================================
    // MEMBUAT NAMA FILE BERDASARKAN NIM
    // ======================================
    $namaFile = "Bukti_" . $nim . ".pdf";

    // ======================================
    // MEMERIKSA APAKAH FILE SUDAH ADA
    // ======================================
    if(file_exists($folder.$namaFile)){
        echo "exists";
        exit;
    }

    // ======================================
    // MENYIMPAN FILE PDF KE FOLDER
    // ======================================
    if(file_put_contents($folder.$namaFile,$data)){
        echo "success";
    }else{
        echo "error";
    }

}else{

    // Jika data POST tidak lengkap
    echo "error";

}
?>