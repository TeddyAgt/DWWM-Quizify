<header class="header">

  <a href="./index.php" title="Retour à l'accueil" class="header__logo">Quizify</a>

  <button class="mobile-navigation__toggler" aria-label="Ouvrir le menu de navigation" aria-controls="main-navigation" aria-expanded="false">
    <img src="public/assets/icons/burger-menu.png" alt="" class="mobile-navigation__icon" aria-hidden="true">
  </button>

  <nav class="main-navigation" id="main-navigation">

    <a href="index.php" class="navigation__link <?= $_SERVER["REQUEST_URI"] === "/" || $_SERVER["REQUEST_URI"] === "/index.php" ? "navigation__link--active" : "" ?>" title="Accueil">
      <span class="emoji-shadow" aria-hidden="true">🏠</span>
      <span class="link__text-content">Accueil</span>
    </a>

    <?php if ($user) : ?>

      <a href="index.php?action=profile" class="navigation__link <?= $_SERVER["REQUEST_URI"] === "/profile.php" ? "navigation__link--active" : "" ?>" title="Page de profil">
        <span class="emoji-shadow" aria-hidden="true">🙂</span>
        <span class="link__text-content">Profil</span>
      </a>

      <a href="index.php?action=logout" class="navigation__link" title="Déconnexion">
        <span class="emoji-shadow" aria-hidden="true">🚪</span>
        <span class="link__text-content">Déconnexion</span>
      </a>

    <?php else : ?>

      <a href="index.php?action=login" class="navigation__link <?= $_SERVER["REQUEST_URI"] === "/login.php" ? "navigation__link--active" : "" ?>" title="Connexion">
        <span class="emoji-shadow" aria-hidden="true">🔑</span>
        <span class="link__text-content">Connexion</span>
      </a>

      <a href="index.php?action=signup" class="navigation__link <?= $_SERVER["REQUEST_URI"] === "/signup.php" ? "navigation__link--active" : "" ?>" title="Inscription">
        <span class="emoji-shadow" aria-hidden="true">📝</span>
        <span class="link__text-content">Inscription</span>
      </a>

    <?php endif; ?>
  </nav>
</header>