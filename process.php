<?php
require 'db_connect.php';
require 'Lotto.php';

if (!isset($_POST['userNumbers']) || count($_POST['userNumbers']) !== 6) {
    echo json_encode(['error' => 'Musisz wybrać dokładnie 6 liczb.']);
    exit();
}

$userNumbers = $_POST['userNumbers'];

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

$lotto = new Lotto();

$randomNumbers = $lotto->generateNumbers();

$matches = $lotto->checkMatches($userNumbers, $randomNumbers);
$numberOfMatches = count($matches);

$prize = $lotto->calculatePrize($numberOfMatches);

$response = [
    'userNumbers' => $userNumbers,
    'randomNumbers' => $randomNumbers,
    'matches' => (is_array($matches)) ? $matches : [], // Upewnij się, że matches to tablica
    'numberOfMatches' => $numberOfMatches,
    'prize' => $prize
];

header('Content-Type: application/json');

echo json_encode($response);

try {
    $userNumbersStr = implode(", ", $userNumbers);
    $randomNumbersStr = implode(", ", $randomNumbers);

    $sql = "INSERT INTO results (user_numbers, random_numbers, matches) VALUES (:user_numbers, :random_numbers, :matches)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_numbers', $userNumbersStr);
    $stmt->bindParam(':random_numbers', $randomNumbersStr);
    $stmt->bindParam(':matches', $numberOfMatches);
    $stmt->execute();
} catch (Exception $e) {
    echo json_encode(['error' => 'Błąd zapisu do bazy danych: ' . $e->getMessage()]);
    exit();
}

?>
