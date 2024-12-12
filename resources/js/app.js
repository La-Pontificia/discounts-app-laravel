// import './bootstrap';

import Swal from "sweetalert2";
import "./utils";
import "./discount";
import "./reports";
import "./dashboard";
import "./ui";

window.alert = (title = "Confirmar", text = "Confirmar", icon = "warning") =>
    Swal.fire({
        icon,
        title,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        text,
    });

window.disabledFormChildren = (form) => {
    const id = form.id;
    const button = document.querySelector(`button[form="${id}"]`);
    if (button) {
        button.disabled = true;
    }
    const elements = form.querySelectorAll("input, select, textarea, button");
    elements.forEach((c) => {
        if (c) {
            c.disabled = true;
            c.classList.add("cursor-not-allowed");
            c.classList.add("animate-pulse");
        }
    });
};

window.enabledFormChildren = (form) => {
    const id = form.id;
    const button = document.querySelector(`button[form="${id}"]`);
    if (button) button.disabled = false;

    const elements = form.querySelectorAll("input, select, textarea, button");
    elements.forEach((c) => {
        if (c) {
            c.disabled = false;
            c.classList.remove("cursor-not-allowed");
            c.classList.remove("animate-pulse");
        }
    });
};
