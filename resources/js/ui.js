document.addEventListener("DOMContentLoaded", function () {
    const $ = document.querySelector.bind(document);

    const $sidebar = $("#sidebar");
    const $sidebarToggle = $("#sidebar-toggle");

    $sidebarToggle?.addEventListener("click", function () {
        const isSidebarOpen = $sidebar.hasAttribute("data-open");

        if (isSidebarOpen) {
            localStorage.setItem("sidebar", "closed");
            $sidebar.removeAttribute("data-open");
        } else {
            localStorage.setItem("sidebar", "open");
            $sidebar.setAttribute("data-open", "");
        }
    });

    const sidebar = localStorage.getItem("sidebar");

    if (sidebar === "closed") {
        $sidebar.removeAttribute("data-open");
    } else {
        $sidebar.setAttribute("data-open", "");
    }
});
