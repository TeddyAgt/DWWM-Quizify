// Éléments du DOM **************************************************
const modifyDataBtn = document.querySelector("#modify-data-btn");
const overlay = document.querySelector(".overlay");
const modifyInformationsModal = document.querySelector(
    "#modify-informations-modal"
);
const closeInformationsModalBtn = document.querySelector(
    "#close-modal-informations"
);
const modifyInformationsForm = document.querySelector(
    "#modify-informations-form"
);
const usernameError = document.querySelector("#username-error");
const emailError = document.querySelector("#email-error");

// Messages d'erreur **************************************************
const ERROR_REQUIRED = "Ce champs est requis";
const ERROR_USERNAME_TOO_SHORT =
    "Le nom d'utilisateur doit faire 5 caractères minimum";
const ERROR_USERNAME_TOO_LONG =
    "Le nom d'utilisateur doit faire 32 caractères maximum";
const ERROR_USERNAME_ALREADY_EXISTS =
    "Ce nom d'utilisateur n'est pas disponnible";
const ERROR_EMAIL_INVALID = "L'adresse mail n'est pas valide";
const ERROR_EMAIL_ALREADY_EXISTS =
    "Il y a déjà un compte avec cette adresse mail";

// Events listeners **************************************************
modifyDataBtn.addEventListener("click", (e) =>
    toggleShowModifyInformationsModal(e, true)
);
modifyInformationsModal.addEventListener("click", (e) => e.stopPropagation());
closeInformationsModalBtn.addEventListener("click", (e) => {
    toggleShowModifyInformationsModal(e, false);
});
modifyInformationsForm.addEventListener("submit", handleSubmitInformationsForm);

// Fonctions **************************************************
function toggleShowModifyInformationsModal(e, show) {
    if (show) {
        overlay.classList.add("active");
        modifyInformationsModal.classList.add("active");
        overlay.addEventListener("click", (e) =>
            toggleShowModifyInformationsModal(e, false)
        );
    } else {
        overlay.removeEventListener("click", toggleShowModifyInformationsModal);
        overlay.querySelector("form").reset();
        overlay.classList.remove("active");
        modifyInformationsModal.classList.remove("active");
    }
}

async function handleSubmitInformationsForm(e) {
    const form = e.target;
    let isValid = true;

    if (!form[0].value) {
        e.preventDefault();
        usernameError.textContent = ERROR_REQUIRED;
        isValid = false;
    } else if (form[0].value.length < 5) {
        e.preventDefault();
        usernameError.textContent = ERROR_USERNAME_TOO_SHORT;
        isValid = false;
    } else if (form[0].value.length > 32) {
        e.preventDefault();
        usernameError.textContent = ERROR_USERNAME_TOO_LONG;
        isValid = false;
    } else if (
        (await checkIfAlreadyExists("username", form[0].value)) &&
        form[0].value !== form[0].dataset.control
    ) {
        e.preventDefault();
        usernameError.textContent = ERROR_USERNAME_ALREADY_EXISTS;
        isValid = false;
    }

    if (!form[1].value) {
        e.preventDefault();
        emailError = ERROR_REQUIRED;
        isValid = false;
    } else if (
        !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(form[1].value)
    ) {
        e.preventDefault();
        emailError = ERROR_EMAIL_INVALID;
        isValid = false;
    } else if (
        (await checkIfAlreadyExists("email", form[1].value)) &&
        form[1].value !== form[1].dataset.control
    ) {
        e.preventDefault();
        emailError = ERROR_EMAIL_ALREADY_EXISTS;
        isValid = false;
    }

    if (isValid) {
        usernameError.textContent = "";
        emailError.textContent = "";
        toggleShowModifyInformationsModal(null, false);
    }
}

async function checkIfAlreadyExists(field, value) {
    try {
        const response = await fetch(
            `index.php?action=checkIfAlreadyExists&field=${field}&value=${value}`
        );

        if (response.ok) {
            const responseData = await response.json();

            if (responseData.exists) {
                return true;
            }
            return false;
        }
    } catch (e) {
        console.log(e);
    }
}
