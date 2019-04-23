<?php
require dirname(__DIR__).'/bootstrap.php';

if ($argc == 1) {
    die('File name missing!');
}
$filePath = $argv[1];

$menuData =  file_get_contents($filePath);
$dataList = json_decode($menuData);
try {
    extractMenu($dataList, $entityManager);
    $entityManager->flush();
} catch (Throwable $t) {
    echo $t->getMessage();
}

/**
 * @param array $menuData
 * @param \App\Entity\Menu|null $parentMenu
 */
function extractMenu(array $menuData, \Doctrine\ORM\EntityManagerInterface $entityManager, ?\App\Entity\Menu $parentMenu = null)
{
    $menuList = [];
    foreach ($menuData as $menuDataItem) {
        $menu = new \App\Entity\Menu();

        $menu->setId($menuDataItem->id);
        $menu->setName(json_decode('"'.$menuDataItem->name.'"'));
        $menu->setAlias($menuDataItem->alias);
        if ($parentMenu !== null) {
            $parentMenu->addChild($menu);
        }

        if (isset($menuDataItem->childrens)) {
            extractMenu($menuDataItem->childrens, $entityManager, $menu);
        }

        $entityManager->persist($menu);

        $menuList[] = $menu;
    }

    return;
}
