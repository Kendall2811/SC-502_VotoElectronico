// ==============================
// LOGIN
// ==============================

const loginForm = document.getElementById('loginform');
const loginError = document.getElementById('login-error');

loginForm.addEventListener('submit', async function(e){

    e.preventDefault();

    const user = document.getElementById('user').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('api.php?controller=Usuario&action=login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ correo: user, password: password })
        });

        const data = await response.json();

        if(response.ok){
            // Guardar info de sesion básica
            sessionStorage.setItem("userId", data.id);
            sessionStorage.setItem("userName", data.nombre);
            sessionStorage.setItem("userRol", data.rol);
            window.location.href = "index.html";
        }else{
            loginError.innerText = data.message || "Credenciales inválidas";
            loginError.style.display = "block";
        }
    } catch(err) {
        console.error(err);
        loginError.innerText = "Error de conexión al servidor";
        loginError.style.display = "block";
    }
});



// ==============================
// REGISTER
// ==============================

const registerForm = document.getElementById('registerform');
const registerError = document.getElementById('register-error');
const registerSuccess = document.getElementById('register-success');

registerForm.addEventListener('submit', async function(e){

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

    try {
        const response = await fetch('api.php?controller=Usuario&action=registrar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nombre: name, correo: email, password: password })
        });

        const data = await response.json();

        if(response.ok) {
            // mostrar mensaje
            registerError.style.display = "none";
            registerSuccess.innerHTML = data.message || "Registrado con éxito";
            registerSuccess.style.display = "block";

            // cambiar a login automaticamente
            setTimeout(() => {
                const loginTab = document.querySelector('[data-bs-target="#login"]');
                loginTab.click();
            }, 1500);
        } else {
            registerError.innerHTML = data.message || "Error al registrarse";
            registerError.style.display = "block";
            registerSuccess.style.display = "none";
        }
    } catch(err) {
        console.error(err);
        registerError.innerHTML = "Error de conexión al servidor";
        registerError.style.display = "block";
    }

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