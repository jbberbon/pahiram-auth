<!DOCTYPE html>
<html>

<head>
    <title>Temperature Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Current Temperature</h2>
        <h3 id="latest-temp" class="text-center">Loading...</h3>
        <p id="elapsed-time" class="text-center" style="font-size: 18px;"></p>

        <h2>History</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <!-- <th>ID</th> -->
                    <th>Celsius (°C)</th>
                    <th>Elapsed (sec)</th>
                    <th>Data Uploaded At</th>
                </tr>
            </thead>
            <tbody id="temperature-table-body">
                @foreach($temperatures as $temperature)
                    <tr>
                        <!-- <td>{{ $temperature->id }}</td> -->
                        <td>{{ $temperature->celsius }}</td>
                        <td>{{ $temperature->elapsed }}</td>
                        <td>{{ $temperature->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function formatDate(dateString) {
            const date = new Date(dateString);
            const optionsDate = { year: 'numeric', month: 'short', day: 'numeric' };
            const optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit' };

            const formattedDate = date.toLocaleDateString('en-US', optionsDate);
            const formattedTime = date.toLocaleTimeString('en-US', optionsTime);

            return `${formattedTime} on ${formattedDate}`;
        }

        function fetchLatestTemperature() {
            fetch('{{ route("api.temp.latest") }}')
                .then(response => response.json())
                .then(data => {
                    const latestTempElement = document.getElementById('latest-temp');
                    latestTempElement.innerHTML = `${data.celsius}°C`;

                    const elapsedTimeElement = document.getElementById('elapsed-time');
                    elapsedTimeElement.innerHTML = `Updated Last ${data.elapsedTime / 1000}s`
                })
                .catch(error => {
                    console.error('Error fetching latest temperature:', error);
                });
        }


        function fetchTableData() {
            fetch('{{ route("api.temp.index") }}')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('temperature-table-body');
                    tableBody.innerHTML = '';

                    data.forEach(temperature => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${temperature.celsius}</td>
                            <td>${temperature.elapsedTime / 1000}</td>
                             <td>${formatDate(temperature.created_at)}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        document.addEventListener('DOMContentLoaded', function () {
            fetchLatestTemperature();// Initial fetch
            fetchTableData(); // Initial fetch
            setInterval(fetchLatestTemperature, 5000);
            setInterval(fetchTemperatureData, 5000); // Refresh every 5 seconds
        });
    </script>
</body>

</html>