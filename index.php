<?php
session_start();

// Liste des questions
$questions = [
    [
        "question" => "Quelle est la capitale de la France ?",
        "options" => ["Lyon", "Marseille", "Paris", "Nice"],
        "answer" => 2 // index de la bonne réponse
    ],
    [
        "question" => "Combien y a-t-il de continents ?",
        "options" => ["5", "6", "7", "8"],
        "answer" => 2
    ],
    [
        "question" => "Quel est l’élément chimique avec le symbole 'O' ?",
        "options" => ["Or", "Oxygène", "Osmium", "Ozone"],
        "answer" => 1
    ]
];

// Initialisation de l'étape du quiz
if (!isset($_SESSION['current'])) {
    $_SESSION['current'] = 0;
    $_SESSION['score'] = 0;
}

// Traitement de la réponse
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reponse = intval($_POST['reponse']);
    $bonneReponse = $questions[$_SESSION['current']]['answer'];

    if ($reponse === $bonneReponse) {
        $_SESSION['score']++;
    }

    $_SESSION['current']++;
}

// Affichage du quiz ou du score final
if ($_SESSION['current'] < count($questions)) {
    $index = $_SESSION['current'];
    $q = $questions[$index];
    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Quiz Études</title>
    </head>
    <body>
        <h2>Question <?php echo $index + 1; ?> / <?php echo count($questions); ?></h2>
        <form method="post" action="">
            <p><?php echo $q['question']; ?></p>
            <?php foreach ($q['options'] as $i => $option) : ?>
                <label>
                    <input type="radio" name="reponse" value="<?php echo $i; ?>" required>
                    <?php echo $option; ?>
                </label><br>
            <?php endforeach; ?>
            <br>
            <input type="submit" value="Suivant">
        </form>
    </body>
    </html>

    <?php
} else {
    $score = $_SESSION['score'];
    $total = count($questions);

    // Réinitialiser la session
    session_destroy();
    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Résultat du Quiz</title>
    </head>
    <body>
        <h1>Quiz terminé !</h1>
        <p>Votre score est : <strong><?php echo $score; ?> / <?php echo $total; ?></strong></p>
        <a href="index.php">Recommencer</a>
    </body>
    </html>

    <?php
}
?>
