import Game from "./Game.js";

// Éléments du DOM **************************************************
const startQuizBtn = document.querySelector("#start-quiz-btn") ?? "";
const quizContainer = document.querySelector(".quiz-container");

// Constantes et variables globales **************************************************
const quizId = new URLSearchParams(window.location.search).get("id");

let timeoutId;
let intervalId;

// Event Listeners **************************************************
if (startQuizBtn) {
  startQuizBtn.addEventListener("click", startGame);
}

// Fonctions **************************************************
/**
 * Récupèrele quiz dans la base de données et parse le JSON
 *
 * @param {string} quizId
 * @return {Object}
 */
async function fetchQuiz(quizId) {
  try {
    const response = await fetch(`./get-quiz.php?id=${quizId}`);

    if (response.ok) {
      const quiz = await response.json();
      return quiz;
    }
  } catch (error) {
    console.log(error);
  }
}

/**
 * Appelle la récuupération du quiz dans le back-end et instancie un
 * objet Game
 *
 */
async function startGame() {
  const quiz = await fetchQuiz(quizId);
  const game = new Game(quiz);

  handleGame(game);
}

/**
 * Gère toute la logique du quiz
 *
 * @param {Game} game
 */
function handleGame(game) {
  quizContainer.style.backgroundImage = "none";

  if (game.isRunning()) {
    const index = game.questionCounter;
    const question = game.quiz.questions[index];

    quizContainer.innerHTML = `<h1 class="main-title"><span class="bold">${
      game.quiz.title
    }</span> - ${index + 1} / ${game.nbrOfQuestion}</h1>`;

    const questionForm = document.createElement("form");
    questionForm.classList.add("question-form");
    questionForm.innerHTML = `<h2 class="section-title">${question.text}</h2>`;
    questionForm.addEventListener("submit", (e) => handleSubmitAnswer(e, game));

    const answersList = document.createElement("ul");
    answersList.classList.add("answers-list");

    const answerElements = [];
    question.answers.forEach((answer, answerIndex) => {
      const li = document.createElement("li");
      li.innerHTML = `
        <input type="radio" name="${index}" id="${answer.id}" value="${answerIndex}">
        <label for="${answer.id}">${answer.text}</label>
      `;
      answerElements.push(li);
    });

    const timer = document.createElement("div");
    timer.classList.add("timer");
    timer.innerHTML = "<span>00</span>:<span>30</span>";

    const submitBtn = document.createElement("button");
    submitBtn.type = "submit";
    submitBtn.id = "submit-answer-btn";
    submitBtn.classList.add("btn", "btn--yellow");
    submitBtn.textContent = "Valider";

    answersList.append(...answerElements);
    questionForm.append(answersList, timer, submitBtn);
    quizContainer.appendChild(questionForm);

    game.questionCounter++;

    let i = 30;
    intervalId = setInterval(() => {
      i--;
      timer.innerHTML = `<span>00</span>:<span>${i >= 10 ? i : "0" + i}</span>`;
    }, 1000);

    // ajouter setImeout de 30 secondes
    timeoutId = setTimeout(() => {
      clearInterval(intervalId);
      timer.innerHTML = "<span>00</span>:<span>00</span>";
      handleSubmitAnswer(null, game);
    }, 30000);
  } else {
    gameOver(game);
  }
}

function handleSubmitAnswer(e = null, game) {
  if (e) {
    e.preventDefault();
  }
  clearInterval(intervalId);
  clearTimeout(timeoutId);

  const selectedAnswer = document.querySelector("input[type='radio']:checked");
  const nextQuestionBtn = document.createElement("button");
  nextQuestionBtn.type = "button";
  nextQuestionBtn.classList.add("btn", "btn--blue");
  nextQuestionBtn.textContent = "Suivant";
  nextQuestionBtn.addEventListener("click", () => handleGame(game));

  document.querySelector("#submit-answer-btn").remove();
  document.querySelector(".question-form").appendChild(nextQuestionBtn);
  document
    .querySelectorAll("input[type='radio']")
    .forEach((i) => (i.disabled = "disabled"));

  if (
    selectedAnswer &&
    game.checkAnswer(selectedAnswer.name, selectedAnswer.value)
  ) {
    quizContainer.style.backgroundImage = "var(--bg-good-answer)";
  } else {
    quizContainer.style.backgroundImage = "var(--bg-wrong-answer)";
  }
}

/**
 * Termine le jeu et envoie le résultat au back-end et les affiches sur la page.
 *
 * @param {Game} game
 */
async function gameOver(game) {
  game.endGame();

  const scorePercentages = Math.floor((game.score * 100) / game.nbrOfQuestion);

  const score = {
    quizId: game.quiz.id,
    quizAuthor: game.quiz.authorId,
    score: scorePercentages,
  };

  try {
    const response = await fetch("post-score.php", {
      method: "POST",
      headers: {
        "Content-type": "application/json",
      },
      body: JSON.stringify(score),
    });
    // Exploiter la réponse ************************************* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //
  } catch (error) {
    console.log(error);
  }

  // Afficher résultat
  quizContainer.innerHTML = `
    <h1 class="main-title"><span>${game.quiz.title}</span></h1>
    <p class="quiz-result">Score: ${scorePercentages} %</p>
    <p class="quiz-result">Bonnes réponses: ${game.score} / ${game.nbrOfQuestion}</p>
  <ul class="details-list"></ul>
    `;

  const seeDetailsBtn = document.createElement("button");
  seeDetailsBtn.classList.add("btn", "btn--yellow", "results-btn");
  seeDetailsBtn.textContent = "Voir les détails";
  seeDetailsBtn.addEventListener("click", (e) => showDetails(e, game));

  const tryAgainBtn = document.createElement("button");
  tryAgainBtn.classList.add("btn", "btn--blue", "results-btn");
  tryAgainBtn.textContent = "Réessayer";
  tryAgainBtn.addEventListener("click", startGame);

  const backHomeLink = document.createElement("a");
  backHomeLink.classList.add("btn", "btn--pink", "results-btn");
  backHomeLink.href = "./index.php";
  backHomeLink.textContent = "Retour à l'accueil";

  quizContainer.append(seeDetailsBtn, tryAgainBtn, backHomeLink);
}

/**
 * Permet d'afficher plus de détails sur les résultats du quiz
 *
 * @param {MouseEvent} e
 * @param {Game} game
 */
function showDetails(e, game) {
  e.target.remove();
  const detailsList = document.querySelector(".details-list");

  const resultElements = [];
  game.results.forEach((i) => {
    const li = document.createElement("li");
    li.classList.add("details-list__item");
    li.innerHTML = `
      <h2>${i[0]}</h2>
      <p>Bonne réponse: ${i[2]}</p>
      <p>Ta réponse: ${i[1]}</p>
    `;
    if (i[1] === i[2]) {
      li.style.backgroundImage = "var(--bg-good-answer)";
    } else {
      li.style.backgroundImage = "var(--bg-wrong-answer)";
    }
    resultElements.push(li);
  });

  detailsList.append(...resultElements);
}
