import Swal from "sweetalert2";
import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    const $ = document.querySelector.bind(document);

    const $exportButton = $("#export-button");

    $exportButton.addEventListener("click", async () => {
        Swal.fire({
            title: "¿Estás seguro de exportar los datos?",
            text: "Verifica los filtros y los rangos de fechas antes de exportar.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, exportar",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                const params = new URLSearchParams(window.location.search);

                try {
                    const { data } = await axios.get(
                        "/histories/export" + "?" + params.toString()
                    );

                    const { filename } = data;

                    const downloadUrl = `/files/reports/${filename}`;
                    window.open(downloadUrl, "_blank");
                } catch (error) {
                    Swal.showValidationMessage(
                        `Los datos no pudieron ser exportados. Inténtalo de nuevo.`
                    );
                }
            },
            allowOutsideClick: () => !Swal.isLoading(),
        });
    });
});
