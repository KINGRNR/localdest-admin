
var quick = {
    convertDate: function (data) {
        var date = new Date(data);

        var monthNames = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        var day = date.getDate().toString().padStart(2, '0');
        var month = monthNames[date.getMonth()];
        var year = date.getFullYear();

        return day + ' ' + month + ' ' + year;
    },

    leafletMapSelector: function (id, a , b) {
        var map = L.map(id).setView([-2.5489, 118.0149], 5); 
    
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    
        var markers = [];
    
        map.on('click', function (e) {
            markers.forEach(function (marker) {
                map.removeLayer(marker);
            });
            markers = []; 
    
            var marker = L.marker(e.latlng).addTo(map); 
            marker.bindPopup('Latitude: ' + e.latlng.lat + '<br>Longitude: ' + e.latlng.lng).openPopup();
            markers.push(marker); 
            var latitude = e.latlng.lat
            var longitude = e.latlng.lng
    
            $(a).attr('value', latitude);
            $(b).attr('value', longitude);
            
        });
    },

    leafletMapShowStatic: function (id, lt, ln) {
        var map = L.map(id).setView([-2.5489, 118.0149], 2);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var markers = L.layerGroup().addTo(map);

        function addMarkerAtCoordinates(lat, lng) {
            var marker = L.marker([lat, lng]).addTo(markers);
            var coordinates = lat + ',' + lng;
            var googleMapsUrl = 'https://www.google.com/maps/search/?q=' + encodeURIComponent(coordinates);


            marker.bindPopup('<a href="' + googleMapsUrl + '" target="_blank">For Detail</a>');

            marker.addTo(map);

        }

        addMarkerAtCoordinates(lt, ln);
    },

    blockPage: function () {
        const loadingDiv = $(
            '<div class="loading loading-spinner-overlay" id="loading-spinner"><div class="loading-spinner"></div><p class="loading-text">Loading </p></div>'
        );
        loadingDiv.hide().appendTo("#pagecontainer").fadeIn();
    },

    unblockPage: function (data) {
        $("#pagecontainer").find(".loading").fadeOut();
        removeSkeleton();
    }

};


