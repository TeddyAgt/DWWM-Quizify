<section class="admin-section white-card">
    <h2 class="main-title">Consulter les résultats</h2>

    <ul class="quiz-results__quiz-list">
        <?php foreach ($quizList as $quiz) : ?>
            <li class="quiz-results__quiz-item">
                <button
                    class="quiz-results-item__title"
                    aria-controls="result-list-1"
                    aria-expanded="false"
                    title="Voir les résultats de <?= $quiz->title; ?>">
                    <span>👉</span><?= $quiz->title; ?>
                </button>
                <ul class="quiz-results-list" id="result-list-1" aria-hidden="true">
                    <?php foreach ($quiz->results as $result) : ?>
                        <li
                            class="quiz-results-item">
                            <?= $result->date; ?> - <?= $result->player["username"]; ?> - <?= $result->score; ?>%
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
</section>