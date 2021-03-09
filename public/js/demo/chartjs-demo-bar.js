$(function () {
    var barData = {
        labels: ["Meja D", "Meja KT", "Papan TH", "Papan TP", "Lemari K", "Lemari A", "Kursi TPO","Kursi P","Kursi D",],
        labels_name: ["Meja Dampar", "Meja Kelas Tinggi", "Papan Tulis Hitam", "Papan Tulis Putih", "Lemari Kitab", "Lemari Al-Qur'an", "Kursi Tamu Per Orang","Kursi Panjang","Kursi Dapur",],
        datasets: [
            {
                label: "Barang",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [106, 50, 8, 7, 4, 1, 0,0,0,]
            }
        ]
    };

    var barOptions = {
        responsive: true,
        tooltips: {
            callbacks: {
                title: function (tooltipItem, data) {
                    return data.labels_name[tooltipItem[0].index];
                },
                label: function (tooltipItem, data) {
                    return 'Tersisa: '+Math.round(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
                }
            }
        }
    };

    var ctx2 = document.getElementById("barChart").getContext("2d");
    new Chart(ctx2, {type: 'horizontalBar', data: barData, options:barOptions});
});
