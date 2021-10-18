// GESTION DE LA CARTE

if(typeof raisonSociale != "undefined") {
    let raisonSociale = document.querySelector('#raisonSociale').innerText
    let adresse = document.querySelector('#adresse').innerText
    console.log(adresse)

    let long = "48.5576075" 
    let lat = "7.7477045"

    var mymap = L.map('mapid').setView([long, lat], 13);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYXV0YXJjaCIsImEiOiJja3V1MGJtNnAwcGpjMm9sdG9jeW85eTY1In0.XX8PNa67LxDUWlD6arC4Vw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        minZoom: 0,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'your.mapbox.access.token'
    }).addTo(mymap);

    var marker = L.marker([long, lat]).addTo(mymap);
    var circle = L.circle([long, lat], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.3,
        radius: 100
    }).addTo(mymap);

    marker.bindPopup("<b>"+raisonSociale+"</b><br>"+adresse+"").openPopup();
}
// CONDITIONS GENERALES

let open = document.querySelector("#openConditions")

let win

open.addEventListener('click', () => {
    win = window.open("/conditions", "_blank")
})


