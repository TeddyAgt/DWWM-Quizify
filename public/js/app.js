// Éléments du DOM ******************************
const mobileNavigationToggler = document.querySelector(
  ".mobile-navigation__toggler"
);
const navigationMenu = document.querySelector(".main-navigation");

let isMenuVisible = false;

mobileNavigationToggler.addEventListener("click", () => {
  isMenuVisible = !isMenuVisible;
  toggleNavigationMenu();
});

/**
 * Permet d'afficher ou de masque le menu de navigation en mode responsive
 *
 */
function toggleNavigationMenu() {
  if (isMenuVisible) {
    navigationMenu.classList.add("main-navigation--active");
    mobileNavigationToggler.children[0].src = "./public/icons/close.png";
    mobileNavigationToggler.ariaLabel = "Fermer le menu de navigation";
    mobileNavigationToggler.ariaExpanded = "true";
  } else {
    navigationMenu.classList.remove("main-navigation--active");
    mobileNavigationToggler.children[0].src = "./public/icons/burger-menu.png";
    mobileNavigationToggler.ariaLabel = "Ouvrir le menu de navigation";
    mobileNavigationToggler.ariaExpanded = "false";
  }
}
