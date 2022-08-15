let form = document.querySelector('.typing-area');
let message = document.querySelector('.message');
let sendBtn = document.querySelector('.typing-area .send');
let chatBox = document.querySelector('.chat-box');
let dropdownIcon = document.querySelector('.dropdown i');
let dropdownList = document.querySelector('.dropdown-list');
let chooseImage = document.querySelector('.dropdown-list .image');
let chooseFile = document.querySelector('.dropdown-list .file');
let chooseImageInput = document.querySelector('.dropdown-list .image input');
let chooseFileInput = document.querySelector('.dropdown-list .file input');
let incoming_id = document.querySelector('.incoming_id');
let outgoing_id = document.querySelector('.outgoing_id');
let fid = document.querySelector('.fid');
let activeStatus = document.querySelector('.chat-area header .details p')
let update = document.querySelector('.update');
let voice = document.querySelector('.typing-area .voice');
let voiceIcon = document.querySelector('.typing-area .voice i');
let typingBox = document.querySelector('.typing-box');
let isMouseDown = false;

form.addEventListener('submit', (e) => {
    e.preventDefault();
})

chatBox.addEventListener('mouseenter', () => {
    chatBox.classList.add('active');
})
chatBox.addEventListener('mouseover', () => {
    chatBox.classList.add('active');
})
chatBox.addEventListener('mouseleave', () => {
    chatBox.classList.remove('active');
})

// Dropdown list
dropdownIcon.addEventListener('click', () => {
    dropdownList.classList.toggle('show');
    document.addEventListener('click', (e) => {
        if (e.target != dropdownIcon) {
            dropdownList.classList.remove('show');
        }
    })
})

// Send Image
chooseImage.addEventListener('click', () => {
    chooseImageInput.click();
})

chooseImageInput.addEventListener('change', (e) => {
    let formData = new FormData();
    formData.append(chooseImageInput.name, e.target.files[0]);
    formData.append('incoming_id', incoming_id.value);
    formData.append('outgoing_id', outgoing_id.value);
    formData.append('message', "");
    sendMessage(formData);
    console.log(e.target.files[0]);
})

// Send File
chooseFile.addEventListener('click', () => {
    chooseFileInput.click();
})

chooseFileInput.addEventListener('change', (e) => {
    let formData = new FormData();
    formData.append(chooseFileInput.name, e.target.files[0]);
    formData.append('incoming_id', incoming_id.value);
    formData.append('outgoing_id', outgoing_id.value);
    formData.append('message', "");
    sendMessage(formData);
    console.log(e.target.files[0]);
})

sendBtn.addEventListener('click', () => {
    let formData = new FormData(form);
    sendMessage(formData);
})
sendBtn.addEventListener('mousedown', () => {
    setTimeout(() => {
        console.log("clicked")
        if(isMouseDown){
            isMouseDown = false;
            let formData = new FormData(form);
            sendMessage(formData);
        }
    }, 50);
})

function sendMessage(formData) {
    let xhr = new XMLHttpRequest();

    xhr.open('POST', 'php/chat.php', true);

    xhr.onload = () => {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                message.value = "";
                chatBox.scrollTop = chatBox.scrollHeight;
                console.log(xhr.response);
            }
        }
    }
    xhr.send(formData);
}

// Message Typing
message.addEventListener('input',handleKeyPress);
message.addEventListener('keyup',handleKeyDown);
let keyUpTimeOut;

function handleKeyPress(){
    clearTimeout(keyUpTimeOut);
    let xhr = new XMLHttpRequest();

    xhr.open('POST', 'php/typing.php', true);

    xhr.onload = () => {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = xhr.response;
                typingBox.classList.add('active');
            }
        }
    }

    let formData = new FormData(form);
    formData.append("type","true");
    xhr.send(formData);
}

function handleKeyDown(){
    keyUpTimeOut = setTimeout(()=>{
        let xhr = new XMLHttpRequest();

        xhr.open('POST', 'php/typing.php', true);

        xhr.onload = () => {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    let data = xhr.response;
                }
            }
        }

        let formData = new FormData(form);
        formData.append("type","false");
        xhr.send(formData);
    },1000)
}

// Refresh Active Status
setInterval(() => {                        
    let xhr = new XMLHttpRequest();

    xhr.open('POST', 'php/activeStatus.php', true);

    xhr.onload = () => {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = xhr.response;
                activeStatus.innerHTML = data;
            }
        }
    }

    let formData = new FormData();
    formData.append(fid.name, fid.value);

    xhr.send(formData);
}, 500)

// Fetch messages
let mssg = setInterval(() => {
    let xhr = new XMLHttpRequest();

    xhr.open('POST', 'php/getMessage.php', true);

    xhr.onload = () => {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = xhr.response;
                if (!chatBox.classList.contains('active')) {
                    chatBox.innerHTML = data;
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            }
        }
    }

    let formData = new FormData(form);

    xhr.send(formData);
}, 500)

// Typing Status
setInterval(() => {                        
    let xhr = new XMLHttpRequest();

    xhr.open('POST', 'php/typingStatus.php', true);

    xhr.onload = () => {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = xhr.response;
                if(data == "active"){
                    if(typingBox.classList.contains("inactive")){
                        typingBox.classList.remove("inactive");
                    }
                    typingBox.classList.add("active");
                }else{
                    if(typingBox.classList.contains("active")){
                        typingBox.classList.remove("active");
                    }
                    typingBox.classList.add("inactive");
                }
            }
        }
    }

    let formData = new FormData(form);
    xhr.send(formData);
}, 100)

// Play Audio
let audio,volumeslider,seekto,ctime;
function playAudio(e){
    audio = e.parentElement.children[4];
    ctime = e.parentElement.children[1];
    volumeslider = e.parentElement.children[2];
    muteBtn = e.parentElement.children[3];
    audio.volume = volumeslider.value / 100;
    volumeslider.addEventListener('mousemove',volume);
    volumeslider.addEventListener('mousedown',volume);
    muteBtn.addEventListener('click',()=>{
        if(audio.muted){
            audio.muted = false;
            muteBtn.classList.remove("fa-volume-xmark");
            muteBtn.classList.add("fa-volume-high");
        }else{
            audio.muted = true;
            muteBtn.classList.remove("fa-volume-high");
            muteBtn.classList.add("fa-volume-xmark");
        }
    })
    audio.addEventListener('timeupdate',()=>{
        let min = Math.floor(audio.currentTime/60);
        let sec = Math.floor(audio.currentTime-min*60);
        min<10?min="0"+min:min;
        sec<10?sec="0"+sec:sec;
        ctime.innerHTML = min+":"+sec;
        if(audio.currentTime == audio.duration){
            e.classList.remove("fa-circle-pause");
            e.classList.add("fa-circle-play");
        }
    })
    if(audio.paused){
        audio.play();
        e.classList.remove("fa-circle-play");
        e.classList.add("fa-circle-pause");
    }else{
        audio.pause();
        e.classList.remove("fa-circle-pause");
        e.classList.add("fa-circle-play");
    }
}

function volume(){
    audio.volume = volumeslider.value/100;
}

// Get Nofication
let msgId = -1;
setInterval(() => {
    let xhr = new XMLHttpRequest();

    xhr.open('POST', 'php/getNotification.php', true);

    xhr.onload = () => {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = xhr.response;
                if (data) {
                    data = JSON.parse(data);
                    if (data[0] != msgId) {
                        getNotification(data);
                        console.log(String(data[1]));
                        msgId = data[0];
                    }
                }
            }
        }
    }

    let formData = new FormData(form);
    xhr.send(formData);
}, 500)

// Show Notification
function showNotification(data) {
    data[1] = String(data[1]).length > 25 ? String(data[1]).substring(0, 25) + "..." : data[1];
    let msg = data[1];
    if (data[4] == "img") {
        msg = "Sent an Image";
    }else if(data[4] == "file"){
        msg = "Sent a file";
    }else if (data[4] == "voice") {
        msg = "Sent a voice";
    }
    const notification = new Notification(data[2], {
        body: msg,
        icon: "php/images/" + data[3],
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
document.addEventListener('visibilitychange', () => {
    if (document.visibilityState == 'visible') {
        update.value = 'Active Now';
    } else if(document.visibilityState == 'hidden') {
        update.value = new Date().toLocaleString();   
    }
    let formData = new FormData();
    formData.append('update', update.value);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/updateActiveStatus.php', true);
    xhr.onload = () => {
        if (xhr.readyState = XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = xhr.response;
            }
        }
    }
    xhr.send(formData);
})

// Focus Input Field
message.addEventListener('focus', () => {
    voice.style.display = "none";
})
message.addEventListener('focusout', () => {
    isMouseDown = true;
    voice.style.display = "block";
})
document.addEventListener('click',(e)=>{
    if(e.target != sendBtn){
        isMouseDown = false;
    }
})
// Voice Recording
navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
    const mediaRecorder = new MediaRecorder(stream);
    let audioChunks;
    voice.addEventListener('click', () => {
        if(mediaRecorder.state == "recording"){
            mediaRecorder.stop();
            voiceIcon.classList.remove("fa-stop");
            voiceIcon.classList.add("fa-microphone");
        }else if(mediaRecorder.state == "inactive"){
            mediaRecorder.start();
            voiceIcon.classList.remove("fa-microphone");
            voiceIcon.classList.add("fa-stop");
        }
        audioChunks = [];
        mediaRecorder.addEventListener("dataavailable", event => {
            audioChunks.push(event.data);
        });
    })
    mediaRecorder.addEventListener("stop", () => {
        console.log(MediaRecorder.state);
        const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/chat.php', true);
        xhr.onload = () => {
            if (xhr.readyState = XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    let data = xhr.response;
                }
            }
        }
        var reader = new FileReader();
        reader.addEventListener('load', () => {
            let formData = new FormData();
            formData.append('voice', reader.result);
            formData.append('incoming_id', incoming_id.value);
            formData.append('outgoing_id', outgoing_id.value);
            formData.append('message', "");
            xhr.send(formData);
        })
        reader.readAsDataURL(audioBlob);
    });
});

// Show each message emoji
function emojiIcon(emoji){
    let emojiLists = document.querySelectorAll('.emoji-list');
    let emojiList;
    emojiLists.forEach(emojiList2=>{
        if(emojiList2.getAttribute('data-id') == emoji.getAttribute('data-id')){
            emojiList = emojiList2;
        }
    })
    emojiList.classList.toggle('show');

    document.addEventListener('click', (e) => {
        if (e.target.getAttribute('data-id') !=  emoji.getAttribute('data-id')) {
            emojiList.classList.remove('show');
            // console.log(emoji.getAttribute('data-id'));
            // console.log("remove!");
        }
    })
}

function emojiItem(e){
    let showReacts = document.querySelectorAll('.show-react');
    showReacts.forEach(showReact=>{
        if(e.parentElement.getAttribute('data-id') == showReact.getAttribute('data-id')){
            validateEmoji(showReact.getAttribute('data-id'),e.innerHTML,showReact);
            showReact.innerHTML = e.innerHTML;
        }
    })
}

function validateEmoji(msgId,emoji,showReact){
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/getCurrentEmoji.php', true);

    xhr.onload = () => {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let currentEmojiCode = "";
                if(xhr.response){
                    currentEmojiCode = xhr.response.codePointAt(0).toString(16);
                }
                let emojiCode = emoji.codePointAt(0).toString(16);
                if(currentEmojiCode == emojiCode){
                    insertEmoji(msgId,"");
                    showReact.innerHTML = "";
                }else{
                    insertEmoji(msgId,emoji);
                }
            }
        }
    }
    let formData = new FormData();
    formData.append("msgId", msgId);
    xhr.send(formData);
}

function insertEmoji(msgId,emoji){
    // Insert emoji
    let xhr = new XMLHttpRequest();

    xhr.open('POST', 'php/emoji.php', true);

    let formData = new FormData();
    formData.append("msgId", msgId);
    formData.append("emoji", emoji);
    xhr.send(formData);
}