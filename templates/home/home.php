<main>
    <section class="quiz-list-section white-card">
        <h1 class="main-title">Liste des <span>Quiz</span></h1>

        <form role="search" class="search-bar">
            <input type="search" name="search" id="search" placeholder="Rechercher...">
            <label for="search" aria-label="Rechercher">🔎</label>
        </form>

        <ul class="quiz-list">
            <?php if (count($quizList)) : ?>
                <?php foreach ($quizList as $q) : ?>
                    <li class="quiz-list__item" data-quiz-title="<?= $q->title; ?>">
                        <a href="index.php?action=quiz&id=<?= $q->id; ?>" title="Aller au quiz <?= $q->quiz_title; ?>">
                            <h2 class="quiz-item__name"><?= $q->title; ?></h2>
                            <p class="quiz-item__description">
                                <?= $q->description; ?>
                            </p>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li>Oups... On dirait qu'aucun quiz n'a été créé. Lancez-vous !</li>
            <?php endif; ?>
        </ul>

    </section>
</main>