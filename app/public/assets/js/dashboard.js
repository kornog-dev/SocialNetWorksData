window.addEventListener("DOMContentLoaded", (event) => {

    const ctx = document.getElementById('dashboard-post-data-chart').getContext('2d');
    postDataChart = null;

    fetch(datasets_url)
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            console.log(data);
            postDataChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.result.labels,
                    datasets: data.result.datasets
                },
            });
        });


    //const ctx = document.getElementById('dashboard-post-data-chart').getContext('2d');
});