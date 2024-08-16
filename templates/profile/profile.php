<main>
  <section class="profile-section white-card <?= $user->isAdmin ? "profile-section--admin" : "profile-section--user"; ?>">
    <h1 class="main-title">Ma page</h1>

    <!-- Info utilisateur -->
    <article class="user-data">
      <div class="user-data__header">
        <h2 class="section-title">Profil</h2>
        <button class="modify-data__button" aria-label="Modifier mes informations personnelles">
          <img class="modify-data__icon" src="./public/icons/pencil.png" alt="" aria-hidden="true">
        </button>
      </div>

      <?= "<p>" . $user->username . "</p>" ?>
      <?= "<p>" . $user->email . "</p>" ?>
    </article>


    <?php if ($user->isAdmin): ?>
      <article class="results-data">
        <h2>Résultats de mes quiz</h2>
        <ul class="participations-list">

          <?php if ($results) : ?>
            <?php foreach ($results as $result) : ?>

              <div class="user-data__header">
                <li class="participation">
                  <h3><?= $result->quiz["title"]; ?></h3>
                  <p><?= $result->player["username"]; ?></p>
                  <p><?= $result->score; ?>% - <?= $result->date; ?></p>
                </li>
              </div>

            <?php endforeach; ?>
          <?php endif; ?>

        </ul>
      </article>
    <?php else : ?>
      <!-- Participations de l'utilisateur -->
      <article class="participation-data">
        <h2 class="section-title">Mes participations</h2>

        <ul class="participations-list">

          <?php if ($participations) : ?>
            <?php foreach ($participations as $participation) : ?>

              <div class="user-data__header">
                <li class="participation">
                  <h3><?= $participation->quiz["title"]; ?></h3>
                  <p><?= $participation->score; ?>% - <?= $participation->date; ?></p>
                </li>
              </div>

            <?php endforeach; ?>
          <?php endif; ?>

        </ul>
      </article>
    <?php endif; ?>

    <!-- Quiz de l'utilisateur -->
    <?php if ($user->isAdmin) : ?>
      <article class="user-quiz-data">
        <h2 class="section-title">Mes quiz</h2>

        <ul class="quiz-list">

          <?php if ($quizList) : ?>
            <?php foreach ($quizList as $q) : ?>

              <li class="quiz-list__item" id="<?= $q->id; ?>">
                <a href="./edit-quiz.php?id=<?= $q->id; ?>" title="Éditer le quiz <?= $q->title; ?>">
                  <h3 class="quiz-item__title"><?= $q->title; ?></h3>
                </a>
              </li>

            <?php endforeach; ?>
          <?php endif; ?>

        </ul>

        <button id="create-quiz-btn" aria-label="Créer un nouveau quiz" title="Créer un nouveau quiz">
          <img src="public/assets/icons/plus.png" alt="" aria-hidden="true">
        </button>
      </article>
    <?php endif; ?>
  </section>
</main>

<div class="overlay">
  <section class="white-card" id="create-quiz-modal">

    <h2 class="main-title"><span>Créer</span> un quiz</h2>

    <form action="index.php?action=createQuiz" method="POST" id="create-quiz-form">

      <div class="input-group">
        <label for="title">Titre</label>
        <input type="text" id="title" name="title">
        <p class="form-error" id="title-error"></p>
      </div>

      <div class="input-group">
        <label for="description">Description</label>
        <textarea name="description" id="description"></textarea>
        <p class="form-error" id="description-error"></p>
      </div>

      <div class="control-group">
        <button type="submit" class="btn btn--yellow">Valider</button>
        <button type="button" class="btn btn--pink" id="close-modal">Annuler</button>
      </div>
    </form>
  </section>
</div>