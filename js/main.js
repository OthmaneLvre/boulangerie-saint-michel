// ===============================
// Contact form AJAX
// ===============================
const form = document.querySelector(".contact-form");
const feedback = document.getElementById("form-feedback");

if (form) {
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        feedback.textContent = "Envoi en cours...";
        feedback.className = "";

        try {
            const response = await fetch("php/contact.php", {
                method: "POST",
                body: formData,
            });

            const result = await response.text();

            if (response.ok) {
                feedback.textContent = result;
                feedback.classList.add("success");
                form.reset();
            } else {
                feedback.textContent = result;
                feedback.classList.add("error");
            }
        
        } catch (error) {
            feedback.textContent = "Erreur réseau. Veuillez réessayer.";
            feedback.classList.add("error");
        }
    });
}