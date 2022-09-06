<?php

namespace App\Tests\Service;

use App\Entity\Category;
use App\Model\CategoryListItem;
use App\Model\CategoryListResponse;
use App\Repository\CategoryRepository;
use App\Service\CategoryService;
use Doctrine\Common\Collections\Criteria;
use PHPUnit\Framework\TestCase;

class CategoryServiceTest extends TestCase
{

    public function testGetCategories()
    {
        $repository = $this->createMock(CategoryRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->with([], ['title' => Criteria::ASC])
            ->willReturn([(new Category())->setId(8)->setTitle('Test')->setSlug('test')->setMain(true)]);

        $service = new CategoryService($repository);
        $expected = new CategoryListResponse([new CategoryListItem(8, 'Test', 'test', true)]);

        $this->assertEquals($expected, $service->getCategories());
    }
}
