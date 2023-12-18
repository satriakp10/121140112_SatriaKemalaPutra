<?php 

class CONNECT {
   private $host = "localhost";
   private $username = "root";
   private $password = "";
   private $database = "users";
   public $conn;

   //fungsi untuk deklarasi koneksi database dengan mysqli
   public function __construct() {
       $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

       if ($this->conn->connect_error) {
           die("conn failed: " . $this->conn->connect_error);
       }
   }



   public function masukData($nama, $noRekamMedik, $ruang, $email, $jenis_kelamin, $masukRs, $konsultasi, $browser, $ip) {
      
      $sudahAda = $this->conn->query("SELECT * FROM pengguna WHERE email = '$email';");

      if ($sudahAda->num_rows < 1) {

          $query = "INSERT INTO pengguna (nama, no_rekam_medik, ruang, email, jenis_kelamin, masuk_rs, konsultasi, jenis_browser, ip_pengguna) 
                     VALUES ('$nama', '$noRekamMedik', '$ruang', '$email', '$jenis_kelamin','$masukRs','$konsultasi','$browser','$ip')";
          
         $hasil =  $this->conn->query($query);

            // Periksa hasil eksekusi kueri
            if (!$hasil) {
               die("Kueri gagal: " . $this->conn->error);
            }


            session_start();

            $_SESSION['masuk'] = $nama;

          echo "<script> alert('Berhasil menambahkan data!'); </script>";
      }
      else{
         echo "<script> alert('Gagal menambahkan data!'); </script>";
      }
   }


   public function ambilData(){

      $hasil = $this->conn->query("SELECT * FROM pengguna");

         // Periksa hasil eksekusi kueri
         if (!$hasil) {
            die("Kueri gagal: " . $this->conn->error);
         }

      $data = array();
      while ($row = $hasil->fetch_assoc()) {
         $data[] = $row;
      }


      return $data;

   }

}

?>