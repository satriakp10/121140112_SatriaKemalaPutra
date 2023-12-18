<?php 

session_start();

session_unset();
session_destroy();


?>

<script> alert("Berhasil menghapus session!")

   window.location.href = 'index.php';
</script>


