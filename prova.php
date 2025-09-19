<?php
require('credentials.php');
require('Connection.php');
$con = new Connection($host, $dbName, $dbUser, $dbPassword);
$con->connect();
$search = 'via fossatello';

$stmt = $con->getConn()->query("SELECT nomeTer, infoAgg FROM stato");
$risultati = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $indirizzi = explode(',', $row['infoAgg']); // Divide la stringa in singoli indirizzi

    foreach ($indirizzi as $indirizzo) {
        // Calcola la distanza di Levenshtein
        $distanza = levenshtein(strtolower(trim($indirizzo)), strtolower($search));

        // Considera solo le parole con distanza massima di 3
        if ($distanza <= 10) {
            $risultati[] = [
                'nomeTer' => $row['nomeTer'],
                'indirizzo' => $indirizzo,
                'distanza' => $distanza
            ];
        }
    }
}

// Ordina i risultati per distanza
usort($risultati, fn($a, $b) => $a['distanza'] <=> $b['distanza']);

foreach ($risultati as $ris) {
    echo "nomeTer: {$ris['nomeTer']} - Indirizzo: {$ris['indirizzo']} - Distanza: {$ris['distanza']}<br>";
}
