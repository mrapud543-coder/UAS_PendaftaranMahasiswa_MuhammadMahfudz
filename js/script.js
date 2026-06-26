// Menjalankan script setelah halaman selesai dimuat
$(document).ready(function(){
// =====================================
// DROPDOWN PRODI & KONSENTRASI
// =====================================
// Mengubah pilihan konsentrasi sesuai prodi
$("#prodi").on("change", function(){
    // Menampilkan nilai prodi ke console
    console.log("Dropdown berubah");
    console.log($(this).val());
    let prodi = $(this).val();
    let konsentrasi = $("#konsentrasi");
    // Mengosongkan dropdown konsentrasi
    konsentrasi.empty();
    // Menambahkan pilihan default
    konsentrasi.append(
        '<option value="">-- Pilih Konsentrasi --</option>'
    );
    // Daftar konsentrasi Manajemen Informatika
    if(prodi === "Manajemen Informatika"){
        konsentrasi.append(
            '<option value="Komputer Akuntansi">Komputer Akuntansi</option>'
        );
        konsentrasi.append(
            '<option value="Informatika Komputer">Informatika Komputer</option>'
        );
        konsentrasi.append(
            '<option value="Komputer Administrasi Bisnis">Komputer Administrasi Bisnis</option>'
        );
    }
    // Daftar konsentrasi Teknik Komputer
    else if(prodi === "Teknik Komputer"){
        konsentrasi.append(
            '<option value="Komputer Cerdas">Komputer Cerdas</option>'
        );
        konsentrasi.append(
            '<option value="Komputer Jaringan">Komputer Jaringan</option>'
        );
        konsentrasi.append(
            '<option value="Multimedia Game & Mobile">Multimedia Game & Mobile</option>'
        );
    }
});
// =====================================
// PREVIEW FOTO + VALIDASI FOTO
// =====================================
// Saat pengguna memilih foto
$("#foto").change(function(){
    let file = this.files[0];
    // Jika tidak ada file dipilih
    if(!file){
        return;
    }
    // Format file yang diizinkan
    let allowedType = [
        "image/jpeg",
        "image/jpg",
        "image/png"
    ];
    // Validasi tipe file
    if(!allowedType.includes(file.type)){
        alert("Foto harus berformat JPG, JPEG, atau PNG");
        this.value="";
        $("#previewFoto")
        .attr("src","img/default-avatar.svg");
        return;
    }
    // Validasi ukuran maksimal 2MB
    if(file.size > 2097152){
        alert("Ukuran foto maksimal 2MB");
        this.value="";
        $("#previewFoto")
        .attr("src","img/default-avatar.svg");
        return;
    }
    // Membaca dimensi foto
    let img = new Image();
    img.onload=function(){
        let ratio = img.width / img.height;
        // Validasi rasio foto 3x4
        if(ratio < 0.70 || ratio > 0.80){
            alert("Gunakan foto dengan rasio 3x4");
            $("#foto").val("");
            $("#previewFoto")
            .attr("src","img/default-avatar.svg");
            return;
        }
        // Menampilkan preview foto
        let reader = new FileReader();
        reader.onload=function(e){

            $("#previewFoto")
            .attr("src",e.target.result);
        };
        reader.readAsDataURL(file);
    };
    img.src = URL.createObjectURL(file);
});
// =====================================
// VALIDASI FORM
// =====================================
// Validasi seluruh input form
$("#formPendaftaran").validate({
    // Aturan validasi
    rules:{
        nim:{
            required:true,
            digits:true,
            minlength:8
        },
        nama:{
            required:true,
            minlength:5
        },
        email:{
            required:true,
            email:true
        },
        hp:{
            required:true,
            digits:true,
            minlength:12
        },
        jk:{
            required:true
        },
        prodi:{
            required:true
        },
        konsentrasi:{
            required:true
        },
        alamat:{
            required:true,
            minlength:10
        },
        foto:{
            required:true
        }
    },
    // Pesan kesalahan
    messages:{
        nim:"NIM wajib diisi minimal 8 angka",
        nama:"Nama lengkap wajib diisi",
        email:"Email tidak valid",
        hp:"Nomor HP minimal 12 angka",
        prodi:"Silahkan pilih program studi",
        konsentrasi:"Silahkan pilih konsentrasi",
        alamat:"Alamat minimal 10 karakter",
        foto:"Silahkan upload pas foto"
    },
    // Jika valid, kirim ke Tampil.php
    submitHandler:function(form){
        form.submit();
    }
});
// =====================================
// RESET FORM
// =====================================
// Mengembalikan form ke kondisi awal
$("#resetBtn").click(function(){
    setTimeout(function(){
        // Mengembalikan preview foto default
        $("#previewFoto")
        .attr("src","img/default-avatar.svg");
        // Mengosongkan dropdown konsentrasi
        $("#konsentrasi").html(`
            <option value="">
                -- Pilih Konsentrasi --
            </option>
        `);
    },100);

});
});