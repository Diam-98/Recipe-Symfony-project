<?php

namespace App\Controller;

use App\Entity\Ingrediant;
use App\Form\IngrediantType;
use App\Repository\IngrediantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngrediantController extends AbstractController
{
    #[Route('/ingrediant', name: 'ingrediant')]
    public function index(IngrediantRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $repository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('pages/ingrediant/index.html.twig', [
            'ingrediants'=>$pagination
        ]);
    }

    #[Route('/ingrediant/nouveau', 'ingrediant.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager):Response{

        $ingrediant = new Ingrediant();

        $form = $this->createForm(IngrediantType::class, $ingrediant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $ingrediant = $form->getData();

            $manager->persist($ingrediant);
            
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre ingrediant a ete enregistre avec success !'
            );

            return $this->redirectToRoute("ingrediant");
        }

        return $this->render('pages/ingrediant/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('ingrediant/edition/{id}', 'ingrediant.edit', methods: ['GET', 'POST'])]
//    public function edit(IngrediantRepository $ingrediantRepository, int $id):Response{
    public function edit(Ingrediant $ingrediant, Request $request, EntityManagerInterface $manager):Response{

        $form = $this->createForm(IngrediantType::class, $ingrediant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $ingrediant = $form->getData();

            $manager->persist($ingrediant);

            $manager->flush();

            $this->addFlash(
                'success',
                'Votre ingrediant a ete enregistre avec success !'
            );

            return $this->redirectToRoute("ingrediant");
        }

        return $this->render('pages/ingrediant/edit.html.twig',[
            'form' => $form->createView()
            ]);
    }

    #[Route('ingrediant/delete/{id}', 'ingrediant.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Ingrediant $ingrediant):Response{
        if (!$ingrediant){
            $this->addFlash(
                'success',
                'Ingrediant inexistante !'
            );

            return $this->redirectToRoute('ingrediant');
        }

        $manager->remove($ingrediant);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre ingrediant a ete supprime avec success !'
        );

        return $this->redirectToRoute('ingrediant');
    }
}
