<?php
require_once "../bootstrap.php";

$repository = $entityManager->getRepository(\App\Entity\Menu::class);
$exportService = new \App\Service\MenuExport($repository);

try {
    $menuStringList = $exportService->generateData(0, 'a');
} catch (\Throwable $t) {
    echo($t->getMessage());
}


$loader = new Twig_Loader_Filesystem(dirname(__DIR__).'/src/view');
$twig = new Twig_Environment($loader, array(
    'cache' => dirname(__DIR__).'/var/twig',
));

$menuStringList = array_map(function ($string) {
    return htmlentities($string);
}, $menuStringList);

$data = implode('<br>', $menuStringList);
$data =  str_replace(' ', '&nbsp;', $data);
echo $twig->render('list_menu.html', array('menuStringList' => $data));

