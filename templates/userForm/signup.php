<section class="signup-section white-card">
  <h1 class="main-title">Inscription</h1>

  <form action="index.php?action=signup" method="POST">

    <div class="input-group">
      <label for="username">Nom d'utilisateur</label>
      <input type="text" name="username" id="username" value=<?= $username ?? ""; ?>>
      <?php if ($handler->hasError("username")) : ?>
        <p class="form-error"><?= $handler->getError("username"); ?></p>
      <?php endif; ?>
    </div>

    <div class="input-group">
      <label for="email">Email</label>
      <input type="mail" name="email" id="email" value=<?= $email ?? ""; ?>>
      <?php if ($handler->hasError("email")) : ?>
        <p class="form-error"><?= $handler->getError("email"); ?></p>
      <?php endif; ?>
    </div>

    <div class="input-group">
      <label for="password">Mot de passe</label>
      <div class="password-input-box">
        <input type="password" name="password" id="password" value=<?= $password ?? ""; ?>>
        <button type="button" id="show-password" aria-label="Afficher le mot de passe" title="Afficher le mot de passe">
          <img src="./public/icons/show.png" alt="" aria-hidden="true">
        </button>
        <?php if ($handler->hasError("password")) : ?>
          <p class="form-error"><?= $handler->getError("password"); ?></p>
        <?php endif; ?>
      </div>
    </div>

    <div class="input-group">
      <label for="confirmation">Confirmation de mot de passe</label>
      <input type="password" name="confirmation" id="confirmation" value=<?= $confirmation ?? ""; ?>>
      <?php if ($handler->hasError("confirmation")) : ?>
        <p class="form-error"><?= $handler->getError("confirmation"); ?></p>
      <?php endif; ?>
    </div>

    <button type="submit" class="btn btn--yellow">Valider</button>

    <p class="form-redirection-text">Déjà un compte ? <a href="./login.php">Connexion</a>.</p>
  </form>
</section>