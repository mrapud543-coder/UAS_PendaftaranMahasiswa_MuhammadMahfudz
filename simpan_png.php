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
if(isset($_POST['gambar']) && isset($_POST['nim'])){

    // Mengambil data gambar PNG (Base64)
    $gambar = $_POST['gambar'];

    // Mengambil NIM mahasiswa
    $nim = trim($_POST['nim']);

    // ======================================
    // MENGHAPUS HEADER BASE64
    // ======================================
    $gambar = str_replace(
        'data:image/png;base64,',
        '',
        $gambar
    );

    // Mengubah spasi menjadi tanda +
    $gambar = str_replace(
        ' ',
        '+',
        $gambar
    );

    // ======================================
    // MENGUBAH BASE64 MENJADI DATA GAMBAR
    // ======================================
    $data = base64_decode($gambar);

    // Jika proses decode gagal
    if($data===false){
        echo "error";
        exit;
    }

    // ======================================
    // MEMBUAT NAMA FILE BERDASARKAN NIM
    // ======================================
    $namaFile = "Bukti_" . $nim . ".png";

    // ======================================
    // MEMERIKSA APAKAH FILE SUDAH ADA
    // ======================================
    if(file_exists($folder.$namaFile)){
        echo "exists";
        exit;
    }

    // ======================================
    // MENYIMPAN FILE PNG KE FOLDER
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