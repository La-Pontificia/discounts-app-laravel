import axios from "axios";
import Swal from "sweetalert2";
document.addEventListener("DOMContentLoaded", function () {
    const $$ = document.querySelectorAll.bind(document);
    const $ = document.querySelector.bind(document);

    const $dinamicForms = $$(".dinamic-form");
    const $dinamicAlerts = $$(".dinamic-alert");
    const $dinamicInputToUrl = $$(".dinamic-input-to-url");
    const $dinamicSelectToUrl = $$(".dinamic-select-to-url");

    const $refreshPage = $$(".refresh-page");
    const $rootLoader = document.getElementById("rootLoader");

    const $uploadFiles = $$(".upload-file");

    // Upload files

    $uploadFiles?.forEach(($input) => {
        $input.addEventListener("change", function () {
            const file = this.files[0];
            const dataUploadId = $input.getAttribute("data-label");
            const $labelUpload = $(`#${dataUploadId}`);

            if ($labelUpload) {
                $labelUpload.innerHTML = file.name;
            }
        });
    });

    // Refresh page
    $refreshPage?.forEach(($f) => {
        $f.onclick = () => {
            if ($rootLoader) {
                $rootLoader.setAttribute("data-open", "true");
            }
            window.location.reload();
        };
    });

    // Disable form
    $dinamicForms?.forEach(($f) => {
        $f.addEventListener("submit", async (e) => {
            e.preventDefault();
            const action = $f.getAttribute("action"); //<-- esto es el endpoint que sera de tipo string: /api/users, /api/users/{id}
            const method = $f.getAttribute("method"); // <-- esto es el metodo que sera de tipo string: POST, PUT, DELETE, GET
            const formData = new FormData($f);
            window.disabledFormChildren($f);
            try {
                const res = await axios(action, {
                    method,
                    data: formData,
                });
                alert("Ok...", res.data, "success").then(() => {
                    window.location.reload();
                });
            } catch (error) {
                console.log(error);
                const content =
                    typeof error.response.data === "object"
                        ? error.response.data.message
                        : error.response.data;
                alert(
                    "Oops...",
                    content ?? "Error al enviar el formulario",
                    "error"
                );
            } finally {
                window.enabledFormChildren($f);
            }
        });
    });

    // Dinamic alerts
    $dinamicAlerts?.forEach((f) => {
        f.onclick = async () => {
            const action = f.getAttribute("data-action");
            const method = f.getAttribute("data-method") ?? "POST";
            const title = f.getAttribute("data-title");
            const description = f.getAttribute("data-description");
            const dataAlertvariant = f.getAttribute("data-alertvariant");

            const result = await Swal.fire({
                title,
                text: description,
                icon: dataAlertvariant ?? "info",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, confirmar",
                cancelButtonText: "Cancelar",
            });

            if (!result.isConfirmed) return;

            try {
                const { data } = await axios(action, {
                    method: method,
                });
                alert("¡Hecho!", data ?? "Operación exitosa", "success").then(
                    () => {
                        window.location.reload();
                    }
                );
            } catch (error) {
                const content =
                    typeof error.response.data === "object"
                        ? error.response.data.message
                        : error.response.data;
                alert(
                    "Oops...",
                    content ?? "Error al enviar el formulario",
                    "error"
                );
            }
        };
    });

    // Dinamic input to url
    $dinamicInputToUrl?.forEach(($input) => {
        $input.addEventListener("input", function (e) {
            const value = e.target.value;
            const name = e.target.name;
            const params = new URLSearchParams(window.location.search);
            if (value !== "") params.set(name, value);
            else params.delete(name);

            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.replaceState({}, "", newUrl);
        });
    });

    // Dinamic select to url

    $dinamicSelectToUrl?.forEach(($select) => {
        $select.addEventListener("change", function (e) {
            const value = e.target.value;
            const name = e.target.name;
            const params = new URLSearchParams(window.location.search);
            if (value !== "") params.set(name, value);
            else params.delete(name);

            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.replaceState({}, "", newUrl);
        });
    });
});
