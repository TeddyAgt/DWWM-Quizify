const searchInput = document.querySelector("#search");
const listItems = document.querySelectorAll(".quiz-list__item");

searchInput.addEventListener("input", handleInputSearch);

/**
 * Permet de filtrer la liste des quiz selon le paramètre
 * de recherche de l'utilisateur.
 *
 * @param {InputEvent} e
 */
function handleInputSearch(e) {
  const searchValue = new RegExp(e.target.value, "gi");

  listItems.forEach((i) => {
    if (!searchValue.test(i.dataset.quizTitle)) {
      i.classList.add("quiz-list__item--hidden");
    } else {
      i.classList.remove("quiz-list__item--hidden");
    }
  });
}
