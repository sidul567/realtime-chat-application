let passwordField = document.querySelector('.input input[type="password"]');
let eyeIcon = document.querySelector('.input .fa-eye');

eyeIcon.addEventListener('click',()=>{
    if(passwordField.type=='password'){
        passwordField.type = 'text';
        eyeIcon.classList.add('active');
    }else{
        passwordField.type = 'password';
        eyeIcon.classList.remove('active');
    }
})