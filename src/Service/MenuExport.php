<?php
namespace App\Service;

use App\Entity\Menu;
use App\Repository\MenuRepository;

class MenuExport
{
    /**
     * @var MenuRepository
     */
    private $repository;

    public function __construct(MenuRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $level
     * @param string $type
     * @return array
     * @throws \Exception
     */
    public function generateData(int $level, string $type): array
    {
        $menuList = $this->repository->findBy(['parent' => null]);
        $dataString = $this->generateDataItem($menuList, $level, $type, 0, '/');

        return $dataString;
    }

    /**
     * @param Menu[] $menuList
     * @param int $level
     * @param string $type
     * @param int $currentLevel
     * @param string $parentUrl
     * @return array
     * @throws \Exception
     */
    private function generateDataItem($menuList, int $level, string $type, int $currentLevel, string $parentUrl): array
    {
        if ($level !== 0 && $level === $currentLevel) {
            return [];
        }

        $dataList = [];
        $indent = str_repeat('    ', $currentLevel);
        foreach ($menuList as $menuItem) {
            if ($type === 'a') {
                $currentUrl = $parentUrl . $menuItem->getAlias() . '/';
                $dataList[] = $indent . $menuItem->getName() . ' ' . $currentUrl;
            } elseif ($type === 'b') {
                $dataList[] = $indent . $menuItem->getName();
                $currentUrl = $parentUrl;
            } else {
                throw new \Exception('Undefined type.');
            }

            $menuChildList = $menuItem->getChildren();
            if (count($menuChildList)) {
                $childList = $this->generateDataItem($menuChildList, $level, $type, ($currentLevel + 1), $currentUrl);
                $dataList = array_merge($dataList, $childList);
            }
        }

        return $dataList;
    }
}
