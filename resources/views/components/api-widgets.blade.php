<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="api-widgets-container mt-4">
    <div class="card-header">
        <h4>Travel Information API Modules</h4>
    </div>
    <div class="card-body">
        <div class="row">

            <!-- 模块 1：天气 API -->
            <div class="col-md-4" id="weather-widget">
                <h5>🌤️ Weather in {{ $idea->destination }}</h5>
                <div id="weather-data" class="border p-2 rounded">
                    Loading...
                </div>
            </div>

            <!-- 模块 2：当地美食 -->
            <div class="col-md-4" id="food-widget">
                <h5>🍜 Popular Picks in {{ $idea->destination }}</h5>
                <div id="food-data" class="border p-2 rounded">
                    Loading...
                </div>
            </div>

            <!-- 模块 3：城市简介（editorialSummary） -->
            <div class="col-md-4" id="summary-widget">
                <h5>🏙️ About {{ $idea->destination }}</h5>
                <div id="summary-data" class="border p-2 rounded">
                    Loading...
                </div>
            </div>

            <!-- 模块 4：地图 -->
            <div class="col-md-4" id="map-widget">
                <h5>🗺️ Map of {{ $idea->destination }}</h5>
                <div id="travel-map" class="border p-2 rounded" style="height: 240px;"></div>
            </div>

        </div>
    </div>
</div>

<script>
    const destination = "{{ $idea->destination }}";
    const encodedDest = encodeURIComponent(destination);

    // ==============================
    // API 1: 天气
    // ==============================
    fetch(`https://wttr.in/${encodedDest}?format=j1`)
        .then(res => res.json())
        .then(data => {
            let w = data.current_condition[0];
            document.getElementById('weather-data').innerHTML = `
                ${w.weatherDesc[0].value}<br>
                🌡️ ${w.temp_C}°C<br>
                💨 Wind: ${w.winddir16Point} ${w.windspeedKmph} km/h
            `;
        })
        .catch(err => {
            document.getElementById('weather-data').innerHTML = "Weather unavailable";
        });

    // ==============================
    // API 2 + 3: 城市信息（美食 + 简介）
    // 调用：https://tabiji.ai/api/v1/destinations/城市名.json
    
                // ==============================
    // Popular Picks 
    // ==============================
    fetch(`https://tabiji.ai/api/v1/destinations/${encodedDest}.json`)
        .then(res => {
            if (!res.ok) throw new Error('API request failed');
            return res.json();
        })
        .then(data => {
            // 取出前 3 个 Popular Picks
            const picks = (data.relatedPicks || []).slice(0, 3);

            let html = '';
            if (picks.length === 0) {
                html = "No picks available";
            } else {
                picks.forEach(p => {
                    // 用 id 做文字，url 做链接
                    html += `🌟 <a href="${p.url}" target="_blank">${p.slug}</a><br>`;
                });
            }
            document.getElementById('food-data').innerHTML = html;


            // --------------------
            // 3. 城市简介 editorialSummary
            // --------------------
            const summary = data.editorialSummary || "No introduction available";
            document.getElementById('summary-data').innerHTML = summary;
        })
        .catch(err => {
            document.getElementById('food-data').innerHTML = "Picks unavailable";
            document.getElementById('summary-data').innerHTML = "Summary unavailable";
        });

    // ==============================
    // API 4: 地图（不动）
    // ==============================
    const mapDestination = "{{ $idea->destination }}";
    let map;
    function initTravelMap() {
        if (map) map.remove();
        map = L.map('travel-map').setView([22.2855, 114.1577], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
    }

    initTravelMap();
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(mapDestination)}&limit=1`)
        .then(res => res.json())
        .then(data => {
            if (data && data.length > 0) {
                const lat = data[0].lat;
                const lon = data[0].lon;
                map.setView([lat, lon], 13);
                L.marker([lat, lon]).addTo(map).bindPopup(mapDestination).openPopup();
            } else {
                document.getElementById('travel-map').innerHTML = "⚠️ Map not available";
            }
        })
        .catch(err => {
            document.getElementById('travel-map').innerHTML = "⚠️ Failed to load map";
        });
</script>