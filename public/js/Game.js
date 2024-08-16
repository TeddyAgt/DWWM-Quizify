/**
 * Représente une partie en cours.
 *
 * @export
 * @class Game
 */
export default class Game {
  /**
   * Crée une instance de Game.
   *
   * @param {Object} quiz
   * @memberof Game
   */
  constructor(quiz) {
    this.quiz = quiz;
    this.results = [];
    this.score = 0;
    this.questionCounter = 0;
    this.nbrOfQuestion = this.quiz.questions.length;
  }

  /**
   * Vérifie si une réponse à une question est bonne ou mauvaise.
   *
   * @param {integer} question - Index de la question
   * @param {integer} answer - Index de la réponse
   * @return {boolean}
   * @memberof Game
   */
  checkAnswer(question, answer) {
    this.updateResults(question, answer);
    if (this.quiz.questions[question].answers[answer].isTrue) {
      this.updateScore();
      return true;
    } else {
      return false;
    }
  }

  /**
   * Met à jour le score de la partie
   *
   * @param {number} [points=1] - Nombre de points à ajouter au score.
   * @memberof Game
   */
  updateScore(points = 1) {
    this.score += points;
  }

  /**
   * Met à jour le tableau de résultats du quiz avec les réponses données par le joueur
   *
   * @param {number} question - L'index de la question
   * @param {number} answer - L'index de la réponse
   * @memberof Game
   */
  updateResults(question, answer) {
    this.results.push([
      this.quiz.questions[question].text,
      this.quiz.questions[question].answers[answer].text,
      ...this.quiz.questions[question].answers
        .filter((e) => e.isTrue)
        .map((e) => e.text),
    ]);
  }

  /**
   * Renvoie le score actuel du quiz
   *
   * @return {number[]}
   * @memberof Game
   */
  getScore() {
    return [this.score, nbrOfQuestion];
  }

  /**
   * Retourne l'état du jeu (en cours ou terminé)
   *
   * @return {boolean}
   * @memberof Game
   */
  isRunning() {
    return this.questionCounter < this.nbrOfQuestion ? true : false;
  }

  /**
   * Met fin à la partie
   * Comme on peut le voir... Ca ne sert à rien.
   *
   * @memberof Game
   */
  endGame() {
    console.log("c fini");
  }
}
