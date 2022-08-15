let loginForm = document.querySelector('.signup form');
let submitBtn = document.querySelector('.submit input');
let errorText = document.querySelector('.form .error-text');

loginForm.addEventListener('submit',(e)=>{
    e.preventDefault();
})

submitBtn.addEventListener('click',()=>{
    let xhr = new XMLHttpRequest();

    xhr.open('POST','php/login.php',true);

    xhr.onload = ()=>{
        if(xhr.readyState == XMLHttpRequest.DONE){
            if(xhr.status == 200){
                let data = xhr.response;
                if(data=="success"){
                    location.href = 'users.php'
                }else{
                    errorText.innerHTML = data;
                    errorText.style.display = 'block';
                }
            }
        }
    }

    let formData = new FormData(loginForm);

    xhr.send(formData);
})