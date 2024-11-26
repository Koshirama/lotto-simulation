<?php
require 'db_connect.php';
require 'Lotto.php';

// Utwórz obiekt Lotto
$lotto = new Lotto();

$userNumbers = $_POST['userNumbers']; // Tablica liczb użytkownika

// Wygeneruj losowe liczby
$randomNumbers = $lotto->generateNumbers();

// Sprawdź trafienia
$matches = $lotto->checkMatches($userNumbers, $randomNumbers);
$numberOfMatches = count($matches);

// Wyświetl wyniki
echo "Trafiłeś " . $numberOfMatches . " liczb(y): " . implode(", ", $matches) . "<br>";
echo "Twoje liczby: " . implode(", ", $userNumbers) . "<br>";
echo "Wylosowane liczby: " . implode(", ", $randomNumbers) . "<br>";

if ($numberOfMatches == 6) {
    echo "Gratulacje! Wygrałeś główną nagrodę!<br>";
} elseif ($numberOfMatches == 5) {
    echo "Wygrałeś drugą nagrodę!<br>";
} elseif ($numberOfMatches >= 3) {
    echo "Wygrałeś nagrodę pocieszenia!<br>";
} else {
    echo "Niestety, nie wygrałeś. Spróbuj ponownie.<br>";
}

// Oblicz nagrodę
$prize = $lotto->calculatePrize($numberOfMatches);
echo "Twoja wygrana: " . $prize . "<br>";

// Konwertuj tablice liczb na ciągi znaków
$userNumbersStr = implode(", ", $userNumbers);
$randomNumbersStr = implode(", ", $randomNumbers);
$matchesCount = $numberOfMatches;

// Przygotuj zapytanie SQL
$sql = "INSERT INTO results (user_numbers, random_numbers, matches) VALUES (:user_numbers, :random_numbers, :matches)";

// Przygotuj zapytanie do wykonania
$stmt = $pdo->prepare($sql);

// Powiąż parametry
$stmt->bindParam(':user_numbers', $userNumbersStr);
$stmt->bindParam(':random_numbers', $randomNumbersStr);
$stmt->bindParam(':matches', $matchesCount);

// Wykonaj zapytanie
$stmt->execute();

// Przygotuj dane do zwrócenia
$response = [
    'userNumbers' => $userNumbers,
    'randomNumbers' => $randomNumbers,
    'matches' => $matches,
    'numberOfMatches' => $numberOfMatches,
    'prize' => $prize
];
// Ustaw nagłówek odpowiedzi na JSON
header('Content-Type: application/json');
// Zwróć dane w formacie JSON
echo json_encode($response);

// Walidacja liczby liczb
if (count($userNumbers) !== 6) {
    echo json_encode(['error' => 'Musisz wybrać dokładnie 6 liczb.']);
    exit();
}
// Walidacja zakresu i unikalności liczb
$uniqueNumbers = array_unique($userNumbers);
if (count($uniqueNumbers) !== 6) {
    echo json_encode(['error' => 'Liczby muszą być unikalne.']);
    exit();
}
foreach ($userNumbers as $number) {
    if ($number < 1 || $number > 49) {
        echo json_encode(['error' => 'Liczby muszą być z zakresu od 1 do 49.']);
        exit();
    }
}

?>
