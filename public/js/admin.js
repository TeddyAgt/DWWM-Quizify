const showResultsBtns = [
    ...document.querySelectorAll(".quiz-results-item__title"),
];
const resultsLists = [...document.querySelectorAll(".quiz-results-list")];

showResultsBtns.forEach((btn) =>
    btn.addEventListener("click", toggleOpenResultsList)
);

function toggleOpenResultsList(e) {
    const btn = e.target;
    const list = resultsLists[showResultsBtns.indexOf(btn)];

    btn.classList.toggle("quiz-results-item__title--active");
    btn.ariaExpanded = btn.ariaExpanded === "true" ? "false" : "true";
    list.classList.toggle("quiz-results-list--active");
    list.ariaHidden = list.ariaHidden === "true" ? "false" : "true";
}
