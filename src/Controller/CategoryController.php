<?php

namespace App\Controller;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Util\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

/**
 * @Route("/categories")
 */
final class CategoryController extends AbstractController
{
    private const LOG_LOCATION = 'Category';

    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/", name="categories", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()
            ->getRepository(Category::class);

        $categories = $repository->findAll();

        return $this->render('category/index.html.twig', [
            "categories" => $categories,
        ]);
    }

    /**
     * @Route("/create", name="categories_create", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($category);
                $manager->flush();

                //Redirection vers la page d'édition
                return $this->redirectToRoute('categories_update', [
                    'id' => $category->getId(),
                ]);
            } catch (\Exception $exception) {
                $this->logger->log($exception, self::LOG_LOCATION, 'create');
            }
        }

        return $this->render('category/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categories_update", methods={"GET", "POST"}, requirements={"id"="\d+"})
     * @param Category $category
     * @param Request $request
     * @return Response
     */
    public function update(Category $category, Request $request): Response
    {
        $form = $this->createForm(CategoryType::class, $category, [
            'on_update' => true,
        ]);

        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->flush();

                //Redirection vers la page d'édition
                return $this->redirectToRoute('categories_update', [
                    'id' => $category->getId(),
                ]);
            }
        } catch (\Exception $exception) {
            $this->logger->log($exception, self::LOG_LOCATION, 'create');
        }

        return  $this->render('category/create.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}", name="categories_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     * @param Category $category
     * @param Request $request
     * @return Response
     */
    public function delete(Category $category, Request $request): Response
    {

        if (!$this->isCsrfTokenValid('categories_delete', $request->request->get('_csrf_token'))) {
            throw new InvalidCsrfTokenException();
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($category);
        $manager->flush();

        return $this->redirectToRoute('categories');
    }
}