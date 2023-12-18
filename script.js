var popupForm = document.getElementById('popupForm');
var btKunjungan = document.getElementById('bt-kunjungan');

function openForm() {
    popupForm.classList.toggle('active');
}


let btUser = document.getElementById('bt-user');
let btKeluar = document.getElementById('bt-keluar');


function showButton(){
    btUser.style.display = "flex";
    btKeluar.style.display = "flex";
}


function moveToLogout(){
    window.location.href = 'logout.php';
}
