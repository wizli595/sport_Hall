import Chart from 'chart.js/auto';

function getJsonData(element, attr) {
    const data = element.dataset[attr];
    return data ? JSON.parse(data) : [];
}

const abonnesChartEl = document.getElementById('abonnesChart');
const paiementsChartEl = document.getElementById('paiementsChart');
const creneauxChartEl = document.getElementById('creneauxChart');

if (abonnesChartEl) {
    new Chart(abonnesChartEl, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                label: 'Abonnés',
                data: abonnesChartEl.dataset.chartData.split(',').map(Number),
                backgroundColor: ['#28a745', '#dc3545'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
            },
        },
    });
}

if (paiementsChartEl) {
    new Chart(paiementsChartEl, {
        type: 'bar',
        data: {
            labels: getJsonData(paiementsChartEl, 'labels'),
            datasets: [{
                label: 'Monthly Payments (€)',
                data: getJsonData(paiementsChartEl, 'chartData'),
                backgroundColor: '#007bff',
            }],
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Months'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Payments (€)'
                    }
                },
            },
        },
    });
}

if (creneauxChartEl) {
    new Chart(creneauxChartEl, {
        type: 'bar',
        data: {
            labels: getJsonData(creneauxChartEl, 'labels'),
            datasets: [{
                    label: 'Available Slots',
                    data: getJsonData(creneauxChartEl, 'available'),
                    backgroundColor: '#28a745',
                },
                {
                    label: 'Reserved Slots',
                    data: getJsonData(creneauxChartEl, 'reserved'),
                    backgroundColor: '#dc3545',
                },
            ],
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Dates'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Number of Slots'
                    }
                },
            },
        },
    });
}