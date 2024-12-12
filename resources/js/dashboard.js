import ApexCharts from "apexcharts";
import axios from "axios";
document.addEventListener("DOMContentLoaded", async function () {
    const $ = document.querySelector.bind(document);

    // history dates
    if ($("#history-dates")) {
        const res = await axios("/histories/dates-grouped");

        const dates = res.data;

        const optionsLineMax = {
            series: [
                {
                    name: "Descuentos aplicados",
                    data: dates,
                },
            ],
            chart: {
                type: "area",
                stacked: false,
                height: 300,
                zoom: {
                    type: "x",
                    enabled: true,
                    autoScaleYaxis: true,
                },
                toolbar: {
                    autoSelected: "zoom",
                },
            },
            dataLabels: {
                enabled: false,
            },
            markers: {
                size: 0,
            },
            title: {
                text: "Registros totales.",
                align: "left",
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.5,
                    opacityTo: 0,
                    stops: [0, 90, 100],
                },
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        val;
                    },
                },
                title: {
                    text: "Cantidad",
                },
            },
            xaxis: {
                type: "datetime",
            },
            tooltip: {
                shared: false,
                y: {
                    formatter: function (val) {
                        return val;
                    },
                },
            },
        };

        const chartLineMax = new ApexCharts(
            document.querySelector("#history-dates"),
            optionsLineMax
        );
        chartLineMax.render();
    }

    if ($("#per-business-data")) {
        const res = await axios("/histories/per-business-data");

        const labels = res.data.map((item) => item.businessName);
        const series = res.data.map((item) => item.count);

        const options = {
            series,
            chart: {
                width: "100%",
                height: 300,
                type: "pie",
            },
            title: {
                text: "Registros por empresa.",
                align: "left",
            },
            labels: labels,
            responsive: [
                {
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200,
                        },
                        legend: {
                            position: "bottom",
                        },
                    },
                },
            ],
        };

        const chart = new ApexCharts(
            document.querySelector("#per-business-data"),
            options
        );
        chart.render();
    }

    if ($("#per-business-timeseries")) {
        const res = await axios("/histories/per-business-time-series");

        const seriesData = [];
        const categories = [];

        const groupedData = {};

        res.data.forEach((item) => {
            const businessName = item.businessName;
            const date = item.date;

            // Asegurarnos de que las fechas sean únicas en categories
            if (!categories.includes(date)) {
                categories.push(date);
            }

            // Inicializamos la estructura de datos por negocio si no existe
            if (!groupedData[businessName]) {
                groupedData[businessName] = Array(categories.length).fill(0);
            }

            // Obtiene el índice de la fecha
            const index = categories.indexOf(date);

            // Asegurarse de que el índice sea válido antes de incrementar
            if (index !== -1) {
                groupedData[businessName][index] += item.count;
            }
        });

        // Creamos el array de series de datos
        Object.entries(groupedData).forEach(([businessName, data]) => {
            seriesData.push({
                name: businessName,
                data: data,
            });
        });

        console.log(seriesData, categories);

        var options = {
            series: seriesData,
            chart: {
                height: "100%",
                type: "area",
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
            },
            xaxis: {
                type: "datetime",
                categories,
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy",
                },
            },
        };

        var chart = new ApexCharts(
            document.querySelector("#per-business-timeseries"),
            options
        );
        chart.render();
    }
});
