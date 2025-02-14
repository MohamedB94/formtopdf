<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'entretien</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Formulaire d'entretien</h1>
    <form action="traitement.php" method="post">

        <label for="username">Prénom :</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" required><br><br>

        <label for="position">Poste :</label>
        <input type="text" name="position" id="position" required><br><br>

        <label for="experience">Experience :</label>
        <input type="textarea" name="experience" id="experience" required><br><br>

        <label for="feedback">Retour :</label>
        <input type="textarea" name="feedback" id="feedback" required><br><br>

        <label for="strenghts">Quels sont vos points forts ? </label>
        <input type="textarea" name="strenghts" id="strenghts" required><br><br>

        <label for="weaknesses">Quels sont vos points faibles ?</label>
        <input type="textarea" name="weaknesses" id="weaknesses" required><br><br>

        <label for="motivation">Qu'est-ce qui vous motive dans ce poste ?</label>
        <input type="textarea" name="motivation" id="motivation" required><br><br>

        <label for="challenges">Parlez-moi d'une situation difficile que vous avez surmontée au travail.</label>
        <input type="textarea" name="challenges" id="challenges" required><br><br>

        <label for="future">Où vous voyez-vous dans 5 ans ?</label>
        <input type="textarea" name="future" id="future" required><br><br>

        <label for="format">Choisissez le format :</label>
        <select name="action" id="format">
            <option value="pdf">PDF</option>
            <option value="csv">CSV</option>
            <option value="json">JSON</option>
        </select><br><br>

        <button type="submit">Générer</button>
    </form>
</body>
</html>