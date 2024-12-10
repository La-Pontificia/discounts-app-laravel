document.addEventListener("DOMContentLoaded", function () {
    const $ = document.querySelector.bind(document);

    $("#query-document")?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const form = new FormData(e.target);
        window.disabledFormChildren($("#query-document"));
        try {
            const res = await fetch(`/clients/one?slug=${form.get("slug")}`);
            const data = await res.json();
            $("#form-result")?.setAttribute("data-ready", "");
            $("#documentId").value = data.documentId;
            $("#firstNames").value = data.firstNames;
            $("#lastNames").value = data.lastNames;
            $("#businessUnit").value = data.businessUnit;
        } catch (error) {
            alert("No se encontró el cliente");
        } finally {
            window.enabledFormChildren($("#query-document"));
        }
    });
});
