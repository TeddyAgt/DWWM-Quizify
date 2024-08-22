<main>
    <section class="edit-quiz-section white-card">

        <form action="index.php?action=editQuiz&id=<?= $quizId; ?>&edit=1" method="POST" class="title-form">
            <h1
                class="main-title"
                id="edit-title-heading"
                data-title="<?= $quiz->title; ?>">Éditer <span><?= $quiz->title; ?></span></h1>
        </form>

        <button
            type="button"
            name="delete-quiz-btn"
            id="delete-quiz-btn"
            class="btn btn--pink"
            aria-label="Supprimer ce quiz">
            <img src="public/assets/icons/delete.png" aria-hidden="true" alt="">
        </button>

        <form action="index.php?action=editQuiz&id=<?= $quizId; ?>&edit=1" method="POST" class="description-form">
            <p id="edit-description-p" data-title="<?= $quiz->description; ?>"><?= $quiz->description; ?></p>
        </form>

        <article class="question-list-article">
            <h2>Questions</h2>

            <ul class="question-list">

                <?php if (count($quiz->questions)) : ?>
                    <?php foreach ($quiz->questions as $q) : ?>
                        <li class="question-list__item" data-question-id="<?= $q->id; ?>">
                            <a href="index.php?action=editQuiz&id=<?= $quizId; ?>&edit=2&question=<?= $q->id; ?>">
                                <h3 class="question-item__text"><?= $q->text; ?></h3>
                                <ul class="answers-list">

                                    <?php if (count($q->answers)) : ?>
                                        <?php foreach ($q->answers as $a) : ?>
                                            <li class="answers-list__item 
                                            <?= $a->isTrue
                                                ? "answers-list__item--true"
                                                : "answers-list__item--false"; ?>
                                            ">
                                                <?= $a->text; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </ul>
                            </a>
                        </li>

                    <?php endforeach; ?>
                <?php endif; ?>

            </ul>
        </article>

        <article class="add-question-article">

            <form
                action="index.php?action=editQuiz&id=<?= $quizId; ?>&edit=<?= $edit; ?><?= isset($questionId)
                                                                                            ? "&question=$questionId"
                                                                                            : ""; ?>"
                method="POST"
                id="add-question-form">

                <!-- Si mode édition -->
                <?php if ($edit === 2) : ?>
                    <h2>Éditer une question</h2>

                    <div class="input-group">
                        <label for="question-text">Question</label>
                        <input
                            type="text"
                            id="question-text"
                            name="question-text"
                            value="<?= $question->text; ?>">
                        <p class="form-error" id="question-text-error"></p>
                    </div>

                    <div class="input-group">
                        <label for="good-answer">Bonne réponse</label>
                        <input
                            type="text"
                            id="good-answer"
                            name="good-answer"
                            class="answer-input--good"
                            value="<?= $question->answers[0]->text; ?>">
                        <p class="form-error" id="good-answer-error"></p>
                    </div>

                    <?php for ($i = 1; $i < count($question->answers); $i++) : ?>
                        <div id="bad-answers-container">
                            <div class="input-group">
                                <label for="bad-answer-<?= $i; ?>">Mauvaise réponse</label>
                                <input
                                    type="text"
                                    id="bad-answer-<?= $i ?>"
                                    name="bad-answer-<?= $i ?>"
                                    class="answer-input--wrong"
                                    value="<?= $question->answers[$i]->text; ?>">
                                <p class="form-error bad-answer-error"></p>
                            </div>
                        </div>
                    <?php endfor; ?>

                    <div class="control-group">
                        <button
                            id="add-answer-btn"
                            type="button"
                            class="btn btn--yellow"
                            title="Ajouter une réponse supplémentaire"
                            aria-label="Ajouter une réponse supplémentaire">
                            <img src="public/assets/icons/plus.png" alt="" aria-hidden="true">
                        </button>
                        <p>Ajouter une réponse supplémentaire</p>
                    </div>

                    <div class="control-group">
                        <button
                            type="submit"
                            name="submit-btn"
                            class="btn btn--blue">Valider
                        </button>
                        <button
                            type="button"
                            name="delete-question-btn"
                            id="delete-question-btn"
                            class="btn btn--pink">Supprimer
                        </button>
                    </div>

                    <!-- Sinon, mode ajout -->
                <?php else : ?>
                    <h2>Ajouter une question</h2>

                    <div class="input-group">
                        <label for="question-text">Question</label>
                        <input
                            type="text"
                            id="question-text"
                            name="question-text">
                        <p class="form-error" id="question-text-error"></p>
                    </div>

                    <div class="input-group">
                        <label for="good-answer">Bonne réponse</label>
                        <input
                            type="text"
                            id="good-answer"
                            name="good-answer"
                            class="answer-input--good">
                        <p class="form-error" id="good-answer-error"></p>
                    </div>

                    <div id="bad-answers-container">
                        <div class="input-group">
                            <label for="bad-answer-1">Mauvaise réponse</label>
                            <input
                                type="text"
                                id="bad-answer-1"
                                name="bad-answer-1"
                                class="answer-input--wrong">
                            <p class="form-error bad-answer-error"></p>
                        </div>
                    </div>

                    <div class="control-group">
                        <button
                            id="add-answer-btn"
                            type="button"
                            class="btn btn--yellow"
                            title="Ajouter une réponse supplémentaire"
                            aria-label="Ajouter une réponse supplémentaire">
                            <img src="public/assets/icons/plus.png" alt="" aria-hidden="true">
                        </button>
                        <p>Ajouter une réponse supplémentaire</p>
                    </div>

                    <button
                        type="submit"
                        name="Valider"
                        class="btn btn--blue">Valider
                    </button>

                <?php endif; ?>

            </form>
        </article>

    </section>
</main>

<div class="overlay">

    <!-- Modale de suppression d'un quiz -->
    <section class="white-card" id="delete-quiz-modal">

        <p>Voulez vous-vraiment supprimer le quiz "
            <span class="bold"><?= isset($quiz) ? "$quiz->title" : ""; ?></span>
            " ?
        </p>

        <form action="index.php?action=editQuiz&id=<?= $quizId; ?>&edit=5" method="POST" class="control-group">
            <button
                type="submit"
                name="confirm-delete-btn"
                id="confirm-delete-quiz-btn"
                class="btn btn--pink">Supprimer
            </button>
            <button
                type="button"
                name="cancel-delete-btn"
                id="cancel-delete-quiz-btn"
                class="btn btn--yellow">Annuler
            </button>
        </form>

    </section>

    <!-- Modale de suppression d'une question -->
    <section class="white-card" id="delete-question-modal">

        <p>Voulez vous-vraiment supprimer la question "
            <span class="bold"><?= isset($question) ? "$question->text" : ""; ?></span>
            " ?
        </p>

        <form
            action="index.php?action=editQuiz&id=<?= $quizId; ?>&edit=4<?= isset($questionId)
                                                                            ? "&question=$questionId"
                                                                            : ""; ?>"
            method="POST"
            class="control-group">
            <button
                type="submit"
                name="confirm-delete-btn"
                id="confirm-delete-question-btn"
                class="btn btn--pink">Supprimer
            </button>
            <button
                type="button"
                name="cancel-delete-btn"
                id="cancel-delete-question-btn"
                class="btn btn--yellow">Annuler
            </button>
        </form>

    </section>

</div>