import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('ratingTrendChart');

    if (!canvas) {
        return;
    }

    const labels = JSON.parse(
        canvas.dataset.labels
    );

    const ratings = JSON.parse(
        canvas.dataset.ratings
    );

    new Chart(canvas, {
        type: 'line',

        data: {
            labels: labels,

            datasets: [
                {
                    label: 'Average Rating',

                    data: ratings,

                    borderColor: '#2563eb',

                    backgroundColor: 'rgba(37, 99, 235, 0.10)',

                    borderWidth: 3,

                    tension: 0.35,

                    fill: true,

                    spanGaps: true,

                    pointRadius: 4,

                    pointHoverRadius: 6,
                }
            ]
        },

        options: {
            responsive: true,

            maintainAspectRatio: false,

            scales: {
                y: {
                    min: 0,
                    max: 10,

                    ticks: {
                        stepSize: 1
                    }
                }
            },

            plugins: {
                legend: {
                    display: false
                },

                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Rating: ${context.raw ?? 'No reviews'}`;
                        }
                    }
                }
            }
        }
    });
});


const sentimentCanvas = document.getElementById('sentimentTrendChart');

if (sentimentCanvas) {
    const labels = JSON.parse(
        sentimentCanvas.dataset.labels
    );

    const positive = JSON.parse(
        sentimentCanvas.dataset.positive
    );

    const negative = JSON.parse(
        sentimentCanvas.dataset.negative
    );

    new Chart(sentimentCanvas, {
        type: 'line',

        data: {
            labels: labels,

            datasets: [
                {
                    label: 'Positive',

                    data: positive,

                    borderColor: '#16a34a',

                    backgroundColor: 'rgba(22, 163, 74, 0.08)',

                    borderWidth: 3,

                    tension: 0.35,

                    fill: true,

                    spanGaps: true,

                    pointRadius: 4,
                },

                {
                    label: 'Negative',

                    data: negative,

                    borderColor: '#dc2626',

                    backgroundColor: 'rgba(220, 38, 38, 0.08)',

                    borderWidth: 3,

                    tension: 0.35,

                    fill: true,

                    spanGaps: true,

                    pointRadius: 4,
                }
            ]
        },

        options: {
            responsive: true,

            maintainAspectRatio: false,

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    }
                }
            },

            plugins: {
                legend: {
                    display: true,

                    position: 'top'
                }
            }
        }
    });
}
