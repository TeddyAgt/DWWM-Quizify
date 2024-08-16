// Éléments du DOM **************************************************
const toggleShowPasswordBtn = document.querySelector("#show-password");
const passwordInput = document.querySelector("input[type='password']");

toggleShowPasswordBtn.addEventListener("click", togglePasswordVisibility);

/**
 * togglePasswordVisibility
 *
 * Permet d'afficher ou de masquer le mot de passe dans les formulaires de connexion ou d'ionscription.
 *
 */
function togglePasswordVisibility() {
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    toggleShowPasswordBtn.innerHTML =
      '<img src="./public/icons/hide.png" alt="" aria-hidden="true">';
    toggleShowPasswordBtn.ariaLabel = "Masquer le mot de passe";
  } else {
    passwordInput.type = "password";
    toggleShowPasswordBtn.innerHTML =
      '<img src="./public/icons/show.png" alt="" aria-hidden="true">';
    toggleShowPasswordBtn.ariaLabel = "Afficher le mot de passe";
  }
}
