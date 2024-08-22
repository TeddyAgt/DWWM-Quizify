// Elements du DOM **************************************************
const createQuizBtn = document.querySelector("#create-quiz-btn");
// const overlay = document.querySelector(".overlay");
const createQuizModal = document.querySelector("#create-quiz-modal") ?? "";
const closeQuizModalBtn = document.querySelector("#close-modal-quiz");
const createQuizForm = document.querySelector("#create-quiz-form");
const titleError = document.querySelector("#title-error");
const descriptionError = document.querySelector("#description-error");

// Messages d'erreur **************************************************
// const ERROR_REQUIRED = "Ce champs est obligatoire";
const ERROR_TITLE_TOO_SHORT = "Le titre doit faire 8 caractères minimum";
const ERROR_DESCRIPTION_TOO_SHORT =
    "La description doit faire 25 caractères minimum";

// Events listeners **************************************************
createQuizBtn.addEventListener("click", showCreateQuizModal);
closeQuizModalBtn.addEventListener("click", hideCreateQuizModal);
if (createQuizModal) {
    createQuizModal.addEventListener("click", (e) => e.stopPropagation());
}
createQuizForm.addEventListener("submit", handleSubmitForm);

// Fonctions **************************************************
function showCreateQuizModal() {
    overlay.classList.add("active");
    createQuizModal.classList.add("active");
    overlay.addEventListener("click", hideCreateQuizModal);
}

function hideCreateQuizModal() {
    overlay.removeEventListener("click", hideCreateQuizModal);
    overlay.querySelector("form").reset();
    overlay.classList.remove("active");
    createQuizModal.classList.remove("active");
}

function handleSubmitForm(e) {
    let isValid = true;

    if (!e.target[0].value) {
        e.preventDefault();
        titleError.textContent = ERROR_REQUIRED;
        isValid = false;
    } else if (e.target[0].value.length < 8) {
        e.preventDefault();
        titleError.textContent = ERROR_TITLE_TOO_SHORT;
        isValid = false;
    }

    if (!e.target[1].value) {
        e.preventDefault();
        descriptionError.textContent = ERROR_REQUIRED;
        isValid = false;
    } else if (e.target[1].value.length < 25) {
        e.preventDefault();
        descriptionError.textContent = ERROR_DESCRIPTION_TOO_SHORT;
        isValid = false;
    }

    if (isValid) {
        titleError.textContent = "";
        descriptionError.textContent = "";
    }
}
