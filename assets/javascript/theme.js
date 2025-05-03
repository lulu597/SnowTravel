document.addEventListener("DOMContentLoaded", () => {
    const bouton = document.getElementById("changer-theme");
    const lienTheme = document.getElementById("lien-theme");

    const themeClair = "assets/css/style.css";
    const themeSombre = "assets/css/stylesombre.css";

    const themeSauvegarde = localStorage.getItem("theme");

    if (themeSauvegarde === "sombre") {
        lienTheme.href = themeSombre;
    } else {
        lienTheme.href = themeClair;
    }

    bouton.addEventListener("click", () => {
        if (lienTheme.href.includes("style.css")) {
            lienTheme.href = themeSombre;
            localStorage.setItem("theme", "sombre");
        } else {
            lienTheme.href = themeClair;
            localStorage.setItem("theme", "clair");
        }
    });
});
