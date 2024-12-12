import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    const $ = document.querySelector.bind(document);

    $("#query-document")?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const form = new FormData(e.target);
        window.disabledFormChildren($("#query-document"));
        try {
            const { data } = await axios(
                `/clients/one?slug=${form.get("slug")}`
            );
            $("#form-result")?.setAttribute("data-ready", "");
            $("#documentId").innerHTML = data.documentId;
            $("#firstNames").innerHTML = data.firstNames;
            $("#lastNames").innerHTML = data.lastNames;
            $("#businessUnit").innerHTML = data.businessUnit;
            $("#clientId").value = data.id;
            $("#type").innerHTML = data.type;
        } catch (error) {
            alert(
                "Hey!",
                "No se encontró el documento ingresado o no se encuentra activo. Por favor, verifique e intente nuevamente."
            );
            const $inputSlug = $("#query-document")?.querySelector("input");
            $inputSlug.value = "";
        } finally {
            window.enabledFormChildren($("#query-document"));
        }
    });
});
