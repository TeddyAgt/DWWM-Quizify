// Éléments du DOM **************************************************
const editTitleHeading = document.querySelector("#edit-title-heading");
const editDescriptionText = document.querySelector("#edit-description-p");
const addAnswerBtn = document.querySelector("#add-answer-btn");
const badAnswersContainer = document.querySelector("#bad-answers-container");
const addQuestionForm = document.querySelector("#add-question-form");
const deleteQuestionBtn = document.querySelector("#delete-question-btn");
const deleteQuiznBtn = document.querySelector("#delete-quiz-btn");
const overlay = document.querySelector(".overlay");
const cancelDeleteQuizBtn = document.querySelector("#cancel-delete-quiz-btn");
const cancelDeleteQuestionBtn = document.querySelector(
  "#cancel-delete-question-btn"
);
const deleteQuestionModal = document.querySelector("#delete-question-modal");
const deleteQuizModal = document.querySelector("#delete-quiz-modal");

// Constantes globales **************************************************
const queryParams = new URLSearchParams(window.location.search);
const limit = queryParams.get("edit") === "2" ? 3 : 2;

// Messages d'erreur **************************************************
const ERROR_REQUIRED = "Ce champs est obligatoire";
const ERROR_QUESTION_TEXT_TOO_SHORT =
  "La question doit faire 20 caractères minimum";

// Variables globales **************************************************
let badAnswersCount = document.querySelector(
  "#bad-answers-container"
).childElementCount;

// Events listeners **************************************************
editTitleHeading.addEventListener("dblclick", handleDbclickTitle);
editDescriptionText.addEventListener("dblclick", handleDbclickDescription);
addAnswerBtn.addEventListener("click", addAnswerInput);
addQuestionForm.addEventListener("submit", handleSubmitAddQuestionForm);
if (deleteQuestionBtn) {
  deleteQuestionBtn.addEventListener("click", showDeleteQuestionModal);
}
deleteQuiznBtn.addEventListener("click", showDeleteQuizModal);
deleteQuestionModal.addEventListener("click", (e) => e.stopPropagation());
deleteQuizModal.addEventListener("click", (e) => e.stopPropagation());

// Fonctions **************************************************
/**
 * handleDbClickTitle
 *
 * Permet de transformer l'élément h1 en input afin de pouvoir modifier le titre du quiz.
 *
 */
function handleDbclickTitle() {
  editTitleHeading.innerHTML = `
    <input type="text" name="title" value="${editTitleHeading.dataset.title}">
  `;
}

/**
 * handleDbClickDescription
 *
 * Permet de transformer l'élément p en textarea afin de pouvoir modifier la description du quiz.
 *
 */
function handleDbclickDescription() {
  editDescriptionText.innerHTML = `
    <textarea name="description">${editDescriptionText.dataset.title}</textarea>
    <button type="submit" class="btn btn--blue">Sauvegarder</button>
  `;
}

/**
 * addAnswerInput
 *
 * Permet d'ajouter un input supplémentaire afin de pouvoir entrer plus de réponses à une question.
 *
 */
function addAnswerInput() {
  badAnswersCount++;
  const inputGroup = document.createElement("div");
  inputGroup.classList.add("input-group");
  inputGroup.innerHTML = `
    <label for="bad-answer-${badAnswersCount}">Mauvaise réponse</label>
    <input type="text" id="bad-answer-${badAnswersCount}" name="bad-answer-${badAnswersCount}" class="answer-input--wrong">
    <p class="form-error"></p>
  `;
  badAnswersContainer.appendChild(inputGroup);
}

/**
 * handleSubmitAddQuestionForm
 *
 * Permet de gérer les erreurs avant la soumission finale du formulaire au back-end.
 *
 * @param {SubmitEvent} e
 */
function handleSubmitAddQuestionForm(e) {
  let isValid = true;
  const errorMessages = document.querySelectorAll(".form-error");
  console.log(errorMessages);

  errorMessages.forEach((m) => (m.textContent = ""));

  if (!e.target[0].value) {
    e.preventDefault();
    errorMessages[0].textContent = ERROR_REQUIRED;
    isValid = false;
  } else if (e.target[0].value.length < 20) {
    e.preventDefault();
    errorMessages[0].textContent = ERROR_QUESTION_TEXT_TOO_SHORT;
    isValid = false;
  }

  for (let i = 1; i < e.target.length - limit; i++) {
    if (!e.target[i].value) {
      e.preventDefault();

      errorMessages[i].textContent = ERROR_REQUIRED;
      isValid = false;
    }
  }

  if (isValid) {
    errorMessages.forEach((m) => (m.textContent = ""));
  }
}

/**
 * showDeleteQuestionModal
 *
 * Permet d'afficher la modale de confirmation de suppression d'une question.
 * Ajoute également les écouteurs d'évenements aux boutons de cette modale.
 *
 */
function showDeleteQuestionModal() {
  overlay.classList.add("active");
  deleteQuestionModal.classList.add("active");
  overlay.addEventListener("click", hideDeleteQuestionModal);
  cancelDeleteQuestionBtn.addEventListener("click", hideDeleteQuestionModal);
}

/**
 * hideDeleteQuestionModal
 *
 * Permet de masquer la modale de confirmation de suppression d'une question.
 * Annule également les écouteurs d'évenements des boutons de cette modale.
 *
 */
function hideDeleteQuestionModal() {
  overlay.removeEventListener("click", hideDeleteQuestionModal);
  cancelDeleteQuestionBtn.removeEventListener("click", hideDeleteQuestionModal);
  deleteQuestionModal.classList.remove("active");
  overlay.classList.remove("active");
}

/**
 * showDeleteQuizModal
 *
 * Permet d'afficher la modale de confirmation de suppression d'un quiz.
 * Ajoute également les écouteurs d'évenements aux boutons de cette modale.
 *
 */
function showDeleteQuizModal() {
  overlay.classList.add("active");
  deleteQuizModal.classList.add("active");
  overlay.addEventListener("click", hideDeleteQuizModal);
  cancelDeleteQuizBtn.addEventListener("click", hideDeleteQuizModal);
}

/**
 * hideDeleteQuiznModal
 *
 * Permet de masquer la modale de confirmation de suppression d'un quiz.
 * Annule également les écouteurs d'évenements des boutons de cette modale.
 *
 */
function hideDeleteQuizModal() {
  overlay.removeEventListener("click", hideDeleteQuestionModal);
  cancelDeleteQuizBtn.removeEventListener("click", hideDeleteQuizModal);
  deleteQuizModal.classList.remove("active");
  overlay.classList.remove("active");
}
