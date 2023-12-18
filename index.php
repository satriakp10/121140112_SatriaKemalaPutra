<?php 


session_start();


if( isset($_SESSION['masuk']) ){

   $session = $_SESSION['masuk'];
   $masuk = true;

 }
 else{
   $masuk = false;
 }

?>


<?php 

include_once 'connect.php';

if(isset($_POST['submit'])){

   $nama = $_POST['nama'];
   $noRekamMedik = $_POST['noRekamMedik']; 
   $ruang = $_POST['ruang'];
   $email = $_POST['email'];
   $jenis_kelamin =  $_POST['jenis_kelamin'];


   $masukRs = isset($_POST['masukRs']) ? $_POST['masukRs'] : array();
      // Konversi array ke string dengan pemisah koma
   $masukRs = implode(', ', $masukRs);


   $konsultasi = isset($_POST['konsultasi']) ? $_POST['konsultasi'] : array();
   // Konversi array ke string dengan pemisah koma
   $konsultasi = implode(', ', $konsultasi);


   // Mendapatkan jenis browser
   $browser = $_SERVER['HTTP_USER_AGENT'];
   // Mendapatkan alamat IP pengguna
   $ip = $_SERVER['REMOTE_ADDR'];


   // membuat objek untuk push data ke database
   $pasien = new CONNECT();

   $pasien->masukData($nama, $noRekamMedik, $ruang, $email, $jenis_kelamin, $masukRs, $konsultasi, $browser, $ip);


   // objek untuk ambil data

   $dataPasien = $pasien->ambilData();
}


?>

<script></script>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
   <link rel="stylesheet" href="./css/style.css">
   <link rel="icon" href="./img/icon.png">
   
   <title>Medical Care</title>


</head>
<body>

   <nav>
      <div id="logo">
      <i class="fa-solid fa-suitcase-medical"></i>
      <a href="./index.php">Medical</a>
      </div>

      <div id="container-link">
         <button id="bt-kunjungan" onclick="openForm()">
            <span>Kunjungan</span> <i class="fa-solid fa-arrow-right-to-bracket"></i>
         </button>

         <?php if($masuk): ?>
         <button id="bt-user">
            <?php echo $session; ?><i class="fa-solid fa-user-large"></i>
         </button>

         <button id="bt-keluar" onclick="moveToLogout()">
            <i class="fa-solid fa-arrow-right-to-bracket"></i>
         </button>

         <?php endif; ?>

      </div>
   </nav>


   <section id="bg">
   </section>

   <section id="popupForm" class="popup">
      <div class="popup-content">
         <span class="close" onclick="openForm()">&times;</span>
         <h2>Riwayat Kunjungan</h2>

         <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">

            <div class="sub-form">
               <label for="1">Data Umum *</label>
               
               <div style="width: 100%;">
                  <input type="text" id="nama" name="nama" placeholder="Nama Pasien" required>
                  <input type="text" id="noRekamMedik" name="noRekamMedik" placeholder="Nomor Rekam Medik" required>
               </div>

            </div>

            <div class="sub-form">
               <label for="2">Ruang Perawatan *</label>
               <input type="text" id="ruang" name="ruang" placeholder="Ruang Perawatan" style="width: 100%;" required>
            </div>

            <div class="sub-form">
               <label for="3">Email *</label>
               <input type="email" id="email" name="email" placeholder="email" style="width: 100%;" required>
            </div>

            <div class="sub-form">

               <label>Jenis Kelamin *</label> 
                  <select id="jenis_kelamin" name="jenis_kelamin"  style="width: 100%;" required>
                     <option value="" selected disabled>Jenis Kelamin</option>
                     <option value="Laki-Laki">Laki-Laki</option>
                     <option value="Perempuan">Perempuan</option>
                  </select>
            </div>

            <div class="sub-form">
               <label for="4">Masuk RS *</label>
               <label style="display: block;">
                  <input type="checkbox" name="masukRs[]" value="igd" style="transform: scale(1.2);">
                     IGD
                  </label>

               <label>
                  <input type="checkbox" name="masukRs[]" value="poliklinik" style="transform: scale(1.2);" >
                     Poliklinik
               </label>
            </div>

            <div class="sub-form">
               <label for="5">Konsultasi *</label>
               <label style="display: block;"> 
                  <input type="checkbox" name="konsultasi[]" value="anastesi" style="transform: scale(1.2);">
                     anastesi
                  </label>    
  
               <label>
                  <input type="checkbox" name="konsultasi[]" value="kardionlogi" style="transform: scale(1.2);">
                     Kardionlogi
               </label>

               <label style="display:block;">
                  <input type="checkbox" name="konsultasi[]" value="pulmononlogi" style="transform: scale(1.2);">
                     Pulmononlogi
               </label>

               <label>
                  <input type="checkbox" name="konsultasi[]" value="spenyakit dalam" style="transform: scale(1.2);">
                     Penyakit Dalam
               </label>

               <label style="display:block;">
                  <input type="checkbox" name="konsultasi[]" value="lainnya" style="transform: scale(1.2);">
                     Lainnya
               </label>
            </div>

            <div class="sub-form submit" >
               <input id="submit" type="submit" name="submit" value="Simpan">
            </div>

         </form>
      </div>
   </section>



   <section>
      
      <h2>Data Kunjungan Pasien</h2>
        <table id="tabel" border="1">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No. Rekam Medik</th>
                    <th>Ruang</th>
                    <th>Email</th>
                    <th>Jenis Kelamin</th>
                    <th>Masuk RSr</th>
                    <th>Konsultasi</th>
                    <th>Browser</th>
                    <th>IP Pengguna</th>
                </tr>
            </thead>
            <tbody >
                <?php

               if(isset($dataPasien)){
                  foreach ($dataPasien as $row) {
                     echo "
                     <tr>
                         <td>{$row['nama']}</td>
                         <td>{$row['no_rekam_medik']}</td>
                         <td>{$row['ruang']}</td>
                         <td>{$row['email']}</td>
                         <td>{$row['jenis_kelamin']}</td>
                         <td>{$row['masuk_rs']}</td> 
                         <td>{$row['konsultasi']}</td>
                         <td>{$row['jenis_browser']}</td> 
                         <td>{$row['ip_pengguna']}</td>     
                     </tr>";
                 }
               }
                ?>
            </tbody>
        </table>
   </section>


   <script src="./script.js"> </script>
</body>
</html>