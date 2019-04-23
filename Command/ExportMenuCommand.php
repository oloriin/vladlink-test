<?php
require dirname(__DIR__).'/bootstrap.php';

if ($argc == 1) {
    die('File name missing!');
}
$fileName = $argv[1];
$level = 0;
$type = 'a';

if ($argc >= 3) {
    $level = $argv[2];
}

if ($argc >= 4) {
    $type = $argv[3];
}

$varDir = dirname(__DIR__) . '/var/';
$filePath = $varDir . $fileName;

$repository = $entityManager->getRepository(\App\Entity\Menu::class);
$exportService = new \App\Service\MenuExport($repository);

try {
    $menuStringList = $exportService->generateData($level, $type);
    $dataString = implode("\n", $menuStringList);

    file_put_contents($filePath, $dataString);
    echo('Menu exported in file: ' . $filePath . "\n");
} catch (\Throwable $t) {
    echo($t->getMessage());
}
