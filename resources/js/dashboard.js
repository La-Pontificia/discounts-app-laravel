import ApexCharts from "apexcharts";
import axios from "axios";
document.addEventListener("DOMContentLoaded", async function () {
    const $ = document.querySelector.bind(document);
    const params = new URLSearchParams(window.location.search);

    // history dates
    if ($("#history-dates")) {
        const res = await axios(
            "/histories/dates-grouped" + "?" + params.toString()
        );

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
        const res = await axios(
            "/histories/per-business-data" + "?" + params.toString()
        );

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
        const res = await axios(
            "/histories/per-business-time-series" + "?" + params.toString()
        );

        const seriesData = [];
        const categories = [];

        const dates = res.data.map((item) => new Date(item.date));
        const minDate = new Date(Math.min(...dates));
        const maxDate = new Date(Math.max(...dates));

        for (
            let d = new Date(minDate);
            d <= maxDate;
            d.setDate(d.getDate() + 1)
        ) {
            categories.push(d.toISOString().split("T")[0]);
        }

        const groupedData = {};
        res.data.forEach((item) => {
            const businessName = item.businessName;
            if (!groupedData[businessName]) {
                groupedData[businessName] = Array(categories.length).fill(0);
            }

            const index = categories.indexOf(item.date);
            if (index !== -1) {
                groupedData[businessName][index] += item.count;
            }
        });

        Object.entries(groupedData).forEach(([businessName, data]) => {
            seriesData.push({
                name: businessName,
                data: data,
            });
        });

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
