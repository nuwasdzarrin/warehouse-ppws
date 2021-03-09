$(function () {

    var lineData = {
        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli"],
        datasets: [
            {
                label: "Stok",
                backgroundColor: 'transparent',
                borderColor: "rgba(155,201,196,0.7)",
                pointBackgroundColor: "rgb(145,173,170)",
                pointBorderColor: "#fff",
                data: [65, 59, 80, 81, 56, 55, 40]
            },
            {
                label: "Trx Masuk",
                backgroundColor: 'transparent',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [28, 48, 40, 19, 86, 27, 90]
            },
            {
                label: "Trx Keluar",
                backgroundColor: 'transparent',
                borderColor: "rgb(165,54,54)",
                pointBackgroundColor: "rgb(179,26,26)",
                pointBorderColor: "#fff",
                data: [15, 20, 30, 19, 18, 20, 60]
            },
        ]
    };

    var lineOptions = {
        responsive: true
    };


    var ctx = document.getElementById("lineChart").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});
});
