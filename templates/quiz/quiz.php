<main>

  <section class="quiz-container white-card">

    <h1 class="main-title"><span class="bold"><?= $quiz->title; ?></span></h1>
    <p><?= $quiz->description; ?></p>

    <?php if (count($quiz->questions)) : ?>

      <div class="control-group">
        <button type="button" class="btn btn--yellow" id="start-quiz-btn">Commencer</button>
        <a href="/" class="btn btn--pink">Retour</a>
      </div>

    <?php else : ?>

      <p class="my-16">L'auteur de ce quiz n'a pas encore ajouté de question. Reviens plus tard.</p>
      <a href="/" class="btn btn--pink">Retour</a>

    <?php endif; ?>

  </section>

</main>