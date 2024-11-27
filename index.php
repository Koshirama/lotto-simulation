<!DOCTYPE html>
<html>
<head>
    <title>Symulator Lotto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

        <form id="lottoForm" action="process.php" method="post">

            <h1><label>Wybierz 6 liczb (1-49)</label></h1><br/>

            <?php for ($i = 1; $i <= 6; $i++): ?>
                <input type="number" name="userNumbers[]" min="1" max="49" id="input" required>
            <?php endfor; ?>

            <input type="submit" value="Zagraj">
            <div id="loader" style="display:none;">Ładowanie...</div>
            <div id="latestResults">
            </div>
            <p><a href="results.php">Zobacz historię gier</a></p>
        </form>




    <script src="script.js"></script>
</body>
</html>
