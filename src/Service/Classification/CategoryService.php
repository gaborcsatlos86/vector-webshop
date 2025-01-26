<?php

declare(strict_types=1);

namespace App\Service\Classification;

use App\Entity\Classification\Category;
use App\Repository\Classification\CategoryRepositoryInterface;

class CategoryService implements CategoryServiceInterface
{
    private array $tree = [];
    
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {}
        
    public function getTree(): array
    {
        if (empty($this->tree)) {
            $this->initTree();
        }
        return $this->tree;
    }
    
    private function initTree(): void
    {
        $categories = $this->categoryRepository->findBy(['enabled' => true]);
        $this->tree = $this->buildTree($categories);
    }
    
    private function buildTree(array $categories, ?int $parentId = null): array
    {
        $tree = [];
        foreach ($categories as $category) {
            /** @var Category $category */
            if ( ($parentId == null && $category->getParent() == null) || ($category->getParent() instanceof Category && $category->getParent()->getId() == $parentId)) {
                $tree[] = [
                    'item' => $category,
                    'children' => $this->buildTree($categories, $category->getId())
                ];
            }
        }
        return $tree;
    }
}