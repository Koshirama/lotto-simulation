<?php
require 'db_connect.php';

$sql = "SELECT * FROM results ORDER BY date DESC";
$stmt = $pdo->query($sql);

echo "<h2>Historia Gier</h2>";
echo "<div class='table-container'>";
echo "<table>";
echo "<tr><th>Data</th><th>Twoje Liczby</th><th>Wylosowane Liczby</th><th>Trafienia</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['date'] . "</td>";
    echo "<td>" . $row['user_numbers'] . "</td>";
    echo "<td>" . $row['random_numbers'] . "</td>";
    echo "<td>" . $row['matches'] . "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";
?>


<!DOCTYPE html>
<html>
<head>
    <title>Symulator Lotto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

        <form action="results.php" method="text">
        <p><a href="index.php">Powrót</a></p>
        </form>
</body>
</html>