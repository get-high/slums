<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class CategoryController extends AbstractController
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    #[Route("admin/categories", name: "admin_categories", methods: ["GET"])]
    public function index()
    {
        $categories = $this->categoryRepository->findBy([], ['order_by' => 'ASC']);

        return $this->render(
            'admin/categories/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route("admin/categories/sort", name: "admin_spot_categories_sort", methods: ["POST"])]
    public function sort(Request $request): Response
    {
        foreach ($request->get('item') as $index => $item) {
            $category = $this->categoryRepository->find($item);
            $category->setOrderBy($index);
            $this->categoryRepository->add($category, true);
        }

        return new Response();
    }

    #[Route("admin/categories/create", name: "admin_create_category", methods: ["GET", "POST"])]
    public function create(Request $request)
    {

    }

    #[Route("admin/categories/{id<\d+>}/edit", name: "admin_edit_category", methods: ["GET", "POST"])]
    public function edit(Category $category, Request $request)
    {

    }

    #[Route("admin/categories/{id<\d+>}/destroy", name: "admin_destroy_category", methods: ["GET", "DELETE"])]
    public function destroy(Category $category)
    {
        $this->categoryRepository->remove($category, true);

        $this->addFlash('message', 'Раздел успешно удален');

        return $this->redirectToRoute('admin_categories');
    }
}
