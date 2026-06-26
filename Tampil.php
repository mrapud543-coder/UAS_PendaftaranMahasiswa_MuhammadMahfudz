<?php
// ===============================
// AMBIL DATA DARI FORM
// ===============================
$nim         = $_POST['nim'] ?? '';
$nama        = $_POST['nama'] ?? '';
$email       = $_POST['email'] ?? '';
$hp          = $_POST['hp'] ?? '';
$jk          = $_POST['jk'] ?? '';
$prodi       = $_POST['prodi'] ?? '';
$konsentrasi = $_POST['konsentrasi'] ?? '';
$alamat      = $_POST['alamat'] ?? '';

// ===============================
// PROSES UPLOAD FOTO
// ===============================
$folder = "upload/";

// Membuat folder upload jika belum ada
if(!is_dir($folder)){
    mkdir($folder,0777,true);
}

$foto = "";

// Memeriksa apakah file berhasil diupload
if(isset($_FILES['foto']) && $_FILES['foto']['error']==0){

    $namaFoto = $_FILES['foto']['name'];
    $tmpFoto  = $_FILES['foto']['tmp_name'];

    // Membuat nama file unik
    $fotoBaru = time()."_".$namaFoto;

    $foto = $folder.$fotoBaru;

    // Memindahkan file ke folder upload
    move_uploaded_file($tmpFoto,$foto);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>

    <!-- Pengaturan karakter dan responsif -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Judul halaman -->
    <title>Bukti Pendaftaran Mahasiswa</title>

    <!-- Library SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Library download PNG & PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<style>

/* Reset */
*{
    box-sizing:border-box;
    font-family:Poppins,Arial,sans-serif;
}

/* Background */
body{
    margin:0;
    padding:40px;
    background:linear-gradient(
        135deg,
        #111827,
        #312e81,
        #4f46e5
    );
}

/* Container */
.container{
    max-width:900px;
    margin:auto;
}

/* Card utama */
#buktiPendaftaran{
    background:#fff;
    border-radius:20px;
    padding:35px;
    box-shadow:0 15px 40px rgba(0,0,0,.25);
}

/* Header */
.header{
    text-align:center;
    padding-bottom:20px;
    border-bottom:3px solid #2563eb;
}

.header h1{
    margin:0;
    color:#2563eb;
    font-size:28px;
    font-weight:bold;
}

.header p{
    margin-top:8px;
    color:#666;
}

/* Profil */
.profile{
    display:flex;
    align-items:center;
    gap:25px;
    margin-top:25px;
}

/* Foto */
.profile img{
    width:110px;
    height:150px;
    object-fit:cover;
    border-radius:10px;
    border:2px solid #2563eb;
    padding:2px;
}

/* Nama */
.nama{
    font-size:18px;
    font-weight:bold;
    color:#222;
    margin-bottom:15px;
}

.profile p{
    margin:8px 0;
    color:#333;
}

/* Data */
.data{
    margin-top:25px;
}

/* Baris data */
.row{
    display:flex;
    padding:12px 10px;
    border-bottom:1px solid #ddd;
}

/* Label */
.label{
    width:150px;
    font-weight:bold;
    color:#222;
}

/* Isi */
.row div:last-child{
    flex:1;
    color:#333;
}

/* Footer */
.footer{
    text-align:center;
    margin-top:25px;
    color:#777;
}

/* Tombol */
.button-area{
    text-align:center;
    margin-top:25px;
}

button{
    padding:12px 22px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    color:#fff;
    font-weight:bold;
    margin:5px;
}

.png{
    background:#16a34a;
}

.pdf{
    background:#dc2626;
}

.back{
    background:#2563eb;
}

button:hover{
    opacity:.9;
}

</style>
</head>
<body>

    <!-- Container utama -->
    <div class="container">

        <!-- Area yang akan dicetak/download -->
        <div id="buktiPendaftaran">

            <!-- Header -->
            <div class="header">
                <h1>BUKTI PENDAFTARAN MAHASISWA</h1>
                <p>POLITEKNIK LP3I CIREBON</p>
            </div>

            <!-- Profil mahasiswa -->
            <div class="profile">

                <!-- Foto mahasiswa -->
                <img src="<?php echo $foto; ?>" alt="Foto Mahasiswa">

                <!-- Identitas utama -->
                <div>

                    <div class="nama">
                        <?php echo htmlspecialchars($nama); ?>
                    </div>

                    <p>
                        NIM :
                        <?php echo htmlspecialchars($nim); ?>
                    </p>

                    <p>
                        Program Studi :
                        <?php echo htmlspecialchars($prodi); ?>
                    </p>

                </div>

            </div>

            <!-- Data detail mahasiswa -->
            <div class="data">

                <!-- Email -->
                <div class="row">
                    <div class="label">Email</div>
                    <div><?php echo htmlspecialchars($email); ?></div>
                </div>

                <!-- Nomor HP -->
                <div class="row">
                    <div class="label">Nomor HP</div>
                    <div><?php echo htmlspecialchars($hp); ?></div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="row">
                    <div class="label">Jenis Kelamin</div>
                    <div><?php echo htmlspecialchars($jk); ?></div>
                </div>

                <!-- Konsentrasi -->
                <div class="row">
                    <div class="label">Konsentrasi</div>
                    <div><?php echo htmlspecialchars($konsentrasi); ?></div>
                </div>

                <!-- Alamat -->
                <div class="row">
                    <div class="label">Alamat</div>
                    <div style="word-break:break-word;">
    <?php echo htmlspecialchars($alamat); ?>
</div>
                </div>

            </div>

            <!-- Status pendaftaran -->
            <div class="footer">
                Data telah berhasil didaftarkan
            </div>

        </div>

        <!-- Tombol aksi -->
        <div class="button-area">

            <!-- Download PNG -->
            <button class="png" id="downloadPNG">
                Simpan PNG
            </button>

            <!-- Download PDF -->
            <button class="pdf" id="downloadPDF">
                Simpan PDF
            </button>

            <!-- Kembali ke form -->
            <button class="back"
            onclick="window.location.href='index.html'">
                Kembali ke Form
            </button>
        </div>
    </div>
<script>
// Menampilkan notifikasi berhasil
Swal.fire({
    icon:'success',
    title:'Berhasil Mendaftar!',
    text:'Data mahasiswa berhasil disimpan.'
});

// Saat tombol dengan id "downloadPNG" diklik
document.getElementById("downloadPNG")
.onclick=function(){

// Mengubah elemen HTML menjadi gambar (canvas)
    html2canvas(
        document.getElementById("buktiPendaftaran")
    )
    .then(canvas=>{

    // Mengonversi canvas menjadi format PNG (Base64)
        let dataURL =
        canvas.toDataURL("image/png");

        // Mengirim data gambar ke file simpan_png.php menggunakan metode POST
        fetch("simpan_png.php",{
            method:"POST",
            headers:{
                "Content-Type":
                "application/x-www-form-urlencoded"
            },
            body:
"gambar=" + encodeURIComponent(dataURL) +
"&nim=<?php echo urlencode($nim); ?>"
        })

        // Mengambil respons dari server dalam bentuk teks
        .then(res=>res.text())

        .then(response=>{

    if(response==="success"){

        Swal.fire({
            icon:'success',
            title:'Berhasil',
            text:'PNG berhasil disimpan ke folder Bukti Pendaftaran'
        });

    }

    else if(response==="exists"){

        Swal.fire({
            icon:'error',
            title:'Oops...',
            html:`
        Bukti pendaftaran sudah pernah disimpan!<br><br>
        <small>Setiap mahasiswa hanya boleh menyimpan 1 bukti PNG.</small>
    `
});
    }
});     // <-- menutup .then()

});     // <-- menutup html2canvas()

};      // <-- menutup onclick PNG


    // Mengubah bukti pendaftaran menjadi PDF
    document.getElementById("downloadPDF")
    .onclick=function(){

    // Mengubah elemen bukti pendaftaran menjadi canvas
    html2canvas(
        document.getElementById("buktiPendaftaran")
    )
    .then(canvas=>{

    // Mengonversi canvas menjadi gambar PNG (Base64)
        const imgData =
        canvas.toDataURL("image/png");

        // Mengambil objek jsPDF
        const {jsPDF} = window.jspdf;

        // Membuat dokumen PDF ukuran A4 orientasi portrait
        const pdf =
        new jsPDF(
            'portrait',
            'mm',
            'A4'
        );

        // Menentukan lebar gambar dalam PDF
        let width = 190;

        // Menghitung tinggi gambar agar proporsional
        let height =
        canvas.height *
        width /
        canvas.width;

        // Menambahkan gambar ke dalam PDF
        pdf.addImage(
            imgData,
            'PNG',
            10,
            20,
            width,
            height
        );

        // Mengubah PDF menjadi format Base64
        let pdfBase64 =
        pdf.output('datauristring');

        fetch("simpan_pdf.php",{
            method:"POST",
            headers:{
                "Content-Type":
                "application/x-www-form-urlencoded"
            },
            body:
"pdf=" + encodeURIComponent(pdfBase64) +
"&nim=<?php echo urlencode($nim); ?>"
        })

        // Mengambil respons dari server
        .then(res=>res.text())

        .then(response=>{

    if(response==="success"){
        Swal.fire({
            icon:'success',
            title:'Berhasil',
            text:'Bukti berhasil disimpan.'
        });
    }
   else if(response==="exists"){

    Swal.fire({
        icon:'error',
        title:'Oops...',
        html:`
        Bukti pendaftaran sudah pernah disimpan!<br><br>
        <small>Setiap mahasiswa hanya boleh menyimpan 1 bukti PDF.</small>
    `
});
   }
});
});
};

</script>
</body>
</html>