// ==============================
// LOGIN
// ==============================

const loginForm = document.getElementById('loginform');
const loginError = document.getElementById('login-error');

loginForm.addEventListener('submit', function(e){

e.preventDefault();

const user = document.getElementById('user').value;
const password = document.getElementById('password').value;

// obtener datos guardados
const savedUser = localStorage.getItem("userEmail");
const savedPass = localStorage.getItem("userPassword");

if(user === savedUser && password === savedPass){

window.location.href = "index.html";

}else{

loginError.style.display = "block";

}

});



// ==============================
// REGISTER
// ==============================

const registerForm = document.getElementById('registerform');
const registerError = document.getElementById('register-error');
const registerSuccess = document.getElementById('register-success');

registerForm.addEventListener('submit', function(e){

e.preventDefault();

const name = document.getElementById('name').value;
const email = document.getElementById('email').value;
const password = document.getElementById('register-password').value;
const confirmPassword = document.getElementById('register-password-confirm').value;


// validar contraseñas

if(password !== confirmPassword){

registerError.innerHTML = "Las contraseñas no coinciden";
registerError.style.display = "block";
registerSuccess.style.display = "none";

return;

}


// guardar usuario en LocalStorage

localStorage.setItem("userName", name);
localStorage.setItem("userEmail", email);
localStorage.setItem("userPassword", password);


// mostrar mensaje

registerError.style.display = "none";
registerSuccess.style.display = "block";


// cambiar a login automaticamente

setTimeout(() => {

const loginTab = document.querySelector('[data-bs-target="#login"]');
loginTab.click();

},1500);

});



// ==============================
// MOSTRAR / OCULTAR CONTRASEÑA
// ==============================

function togglePass(id,btn){

const input = document.getElementById(id);
const icon = btn.querySelector("i");

if(input.type === "password"){

input.type = "text";
icon.classList.replace("bi-eye","bi-eye-slash");

}else{

input.type = "password";
icon.classList.replace("bi-eye-slash","bi-eye");

}

}