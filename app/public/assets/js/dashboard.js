window.addEventListener("DOMContentLoaded", (event) => {

    const ctx2022 = document.getElementById('dashboard-post-data-chart-2022').getContext('2d');
    postDataChart2022 = null;

    fetch(datasets_url_2022)
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            console.log(data);
            postDataChart2022 = new Chart(ctx2022, {
                type: 'line',
                data: {
                    labels: data.result.labels,
                    datasets: data.result.datasets
                },
            });
        });





    //const ctx = document.getElementById('dashboard-post-data-chart').getContext('2d');
});