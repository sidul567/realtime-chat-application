let number = document.querySelector('.number');
let cityLocation = document.querySelector('.city');
let weatherIcon = document.querySelector('.weather-icon img');

// Get Current Location 
function currentLocation(){
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(onsuccess,onerror);
    }
}

function onsuccess(position){
    const {latitude,longitude} = position.coords;
    weather(`https://api.openweathermap.org/data/2.5/weather?lat=${latitude}&lon=${longitude}&units=metric&appid=b76da4ad7f1b8c94916a61ee79909bfe`);
}

currentLocation();

function weather(api){
    let xhr = new XMLHttpRequest();
    xhr.open('GET', api, true);

    xhr.onload = () => {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = JSON.parse(xhr.response);
                let temp = Math.round(data['main']['temp']);
                let city = data['name'].split(" ");
                let desc = data['weather'][0]['main'];
                let id = data['weather'][0]['id'];
                number.innerHTML = temp+" °C - "+desc;
                cityLocation.innerHTML = city[0];
                if(id == 800){
                    weatherIcon.src = "weather-icons/clear.svg"
                }else if(id>=200 && id<=232){
                    weatherIcon.src = "weather-icons/storm.svg"
                }else if(id>=300 && id<=531){
                    weatherIcon.src = "weather-icons/rain.svg"
                }else if(id>=600 && id<=622){
                    weatherIcon.src = "weather-icons/snow.svg"
                }else if(id>=701 && id<=781){
                    weatherIcon.src = "weather-icons/snow.svg"
                }else if(id>=801 && id<=804){
                    weatherIcon.src = "weather-icons/cloud.svg"
                }
            }
        }
    }
    xhr.send();
}