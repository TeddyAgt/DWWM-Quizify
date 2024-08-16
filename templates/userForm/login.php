<main>
  <section class="login-section white-card">
    <h1 class="main-title">Connexion</h1>

    <form action="index.php?action=login" method="POST">

      <div class="input-group">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" value=<?= $username ?? ""; ?>>
        <?php if ($handler->hasError("username")) : ?>
          <p class="form-error"><?= $handler->getError("username"); ?></p>
        <?php endif; ?>
      </div>


      <div class="input-group">
        <label for="password">Mot de passe</label>
        <div class="password-input-box">
          <input type="password" name="password" id="password" value=<?= $password ?? ""; ?>>
          <button type="button" id="show-password" aria-label="Afficher le mot de passe" title="Afficher le mot de passe">
            <img src="public/assets/icons/show.png" alt="" aria-hidden="true">
          </button>
          <?php if ($handler->hasError("password")) : ?>
            <p class="form-error"><?= $handler->getError("password"); ?></p>
          <?php endif; ?>
        </div>
      </div>

      <button type="submit" class="btn btn--yellow">Valider</button>

      <p class="form-redirection-text">Pas encore de comte ? <a href="./signup.php">Inscription</a>.</p>
    </form>
  </section>
</main>