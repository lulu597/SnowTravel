document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("form").forEach(form => {
        const inputs = form.querySelectorAll("input");

        const globalError = document.createElement("div");
        globalError.style.color = "red";
        globalError.style.marginBottom = "10px";
        form.prepend(globalError);

        inputs.forEach(input => {
            if (input.hasAttribute("maxlength")) {
                const compteur = document.createElement("span");
                compteur.style.fontSize = "12px";
                compteur.style.marginLeft = "10px";
                input.parentNode.appendChild(compteur);

                const updateCompteur = () => {
                    compteur.textContent = `${input.value.length}/${input.maxLength}`;
                };
                input.addEventListener("input", updateCompteur);
                updateCompteur();
            }

            if (input.type === "password") {
                const toggle = document.createElement("img");
                toggle.src = "assets/img/oeil.png";
                toggle.alt = "Afficher le mot de passe";
                toggle.style.cursor = "pointer";
                toggle.style.marginLeft = "10px";
                toggle.width = 20;
                toggle.height = 20;

                toggle.addEventListener("click", () => {
                    input.type = input.type === "password" ? "text" : "password";
                });

                input.parentNode.appendChild(toggle);
            }
        });


        form.addEventListener("submit", (e) => {
            let valide = true;
            globalError.textContent = "";

            inputs.forEach(input => {
                const val = input.value.trim();
                let msg = "";

                if (input.required && val === "") {
                    msg = "Ce champ est requis.";
                }

                if (input.type === "email" && val !== "" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
                    msg = "Adresse email invalide.";
                }

                if (msg) {
                    valide = false;
                    const erreurChamp = document.createElement("div");
                    erreurChamp.style.color = "red";
                    erreurChamp.style.fontSize = "12px";
                    erreurChamp.textContent = msg;
                    if (!input.nextElementSibling || input.nextElementSibling.tagName !== "DIV") {
                        input.parentNode.appendChild(erreurChamp);
                    }
                }
            });

            if (!valide) {
                e.preventDefault();
            }
        });
    });
});
