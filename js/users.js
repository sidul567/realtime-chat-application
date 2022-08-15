let searchField = document.querySelector('.search input');
let searchBtn = document.querySelector('.search button');
let usersList = document.querySelector('.users .users-list');
let update = document.querySelector('.update');

let isClickSearchBtn = false;

searchBtn.addEventListener('click',()=>{
    if(!isClickSearchBtn){
        searchField.classList.add('active');
        searchBtn.classList.add('active');
        searchField.focus();
        isClickSearchBtn = true;
    }else{
        searchField.classList.remove('active');
        searchBtn.classList.remove('active');
        searchField.value = "";
        searchField.blur();
        isClickSearchBtn = false;
    }
})

searchField.addEventListener('keyup',(e)=>{
    let searchValue = e.target.value;
    let xhr = new XMLHttpRequest();

    if(searchValue != ''){
        searchField.classList.add('active');
    }else{
        searchField.classList.remove('active');
    }

    xhr.open('POST','php/search.php',true);

    xhr.onload = ()=>{
        if(xhr.readyState == XMLHttpRequest.DONE){
            if(xhr.status == 200){
                let data = xhr.response;
                usersList.innerHTML = data;
            }
        }
    }

    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    xhr.send("searchValue="+searchValue);
})

// Fetch users List

setInterval(()=>{
    let xhr = new XMLHttpRequest();

    xhr.open('GET','php/users.php',true);

    xhr.onload = ()=>{
        if(xhr.readyState == XMLHttpRequest.DONE){
            if(xhr.status == 200){
                let data = xhr.response;
                if(!searchField.classList.contains('active')){
                    usersList.innerHTML = data;
                }
            }
        }
    }

    xhr.send();
},500)

// Notification Permission
if(Notification.permission == "default") {
    Notification.requestPermission();
}

// Get Nofication
let msgId = -1;
setInterval(() => {
    let xhr = new XMLHttpRequest();

    xhr.open('GET', 'php/getUserNotification.php', true);

    xhr.onload = () => {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = xhr.response;
                if (data) {
                    data = JSON.parse(data);
                    if (data[0] != msgId) {
                        getNotification(data);
                        console.log(data);
                        msgId = data[0];
                    }
                }
            }
        }
    }
    xhr.send();
}, 500)

// Show Notification
function showNotification(data) {
    data[1] = String(data[1]).length > 25 ? String(data[1]).substring(0,25)+"...":data[1];
    let msg = data[1];
    if(data[4] == "img"){
        msg = "Sent an Image";
    }
    else if(data[4] == "voice"){
        msg = "Sent a voice";
    }
    const notification = new Notification(data[2], {
        body: msg,
        icon: "php/images/"+data[3],
    })
}

// Get Notification
function getNotification(data) {
    if (Notification.permission == "granted") {
        showNotification(data);
    } else if (Notification.permission == "default") {
        Notification.requestPermission().then(permission => {
            if (permission == "granted") {
                showNotification(data);
            }
        })
    }
}

// Update Active Status
document.addEventListener('visibilitychange',()=>{
    if(document.visibilityState == 'visible'){
        update.value = 'Active Now';
    }else{
        update.value = new Date().toLocaleString();
    }
    let formData = new FormData();
    formData.append('update',update.value);
    let xhr = new XMLHttpRequest();
    xhr.open('POST','php/updateActiveStatus.php',true);
    xhr.onload = ()=>{
        if(xhr.readyState = XMLHttpRequest.DONE){
            if(xhr.status == 200){
                let data = xhr.response;
            }
        }
    }
    xhr.send(formData);
})