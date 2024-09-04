<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LivreController extends AbstractController
{ // POUR ALLER SUR LA PAGE ACCUEIL
    #[Route('/accueil', name: 'accueil')]
    public function accueil()
    {
        return $this->render('accueil.html.twig');
    }
    #[Route('/Livres', name: 'Livre_index', methods: ['GET'])]
    
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $search = $request->query->get('search');
        $Livres = [];

        // Préparer la requête de base pour trier par titre en premier lieu
        $queryBuilder = $em->getRepository(Livre::class)->createQueryBuilder('l')
            ->orderBy('l.titre', 'ASC')
            ->addOrderBy('l.tome', 'ASC');  // Trier par tome après le titre

        // Appliquer le filtre si une recherche est effectuée
        if ($search) {
            $queryBuilder->where('LOWER(l.categorie) LIKE :search OR LOWER(l.titre) LIKE :search')
                ->setParameter('search', '%' . strtolower($search) . '%');
        }

        $Livres = $queryBuilder->getQuery()->getResult();

        // Organisation des livres par titre et catégorie
        $categories = [];
        $categoryTotals = [];
        foreach ($Livres as $livre) {
            // Normaliser les titres pour s'assurer qu'ils sont regroupés correctement
            $normalizedCategory = strtolower($livre->getCategorie());
            $normalizedTitle = strtolower($livre->getTitre());

            $categories[$normalizedTitle][$normalizedCategory][] = $livre;
        }

        // Calcul du total du prix pour chaque groupe de titres
        foreach ($categories as $titre => $categoriesGroup) {
            foreach ($categoriesGroup as $categorie => $livres) {
                $total = array_sum(array_map(fn($livre) => $livre->getPrix(), $livres));
                $categoryTotals[$titre][$categorie] = $total;
            }
        }

        return $this->render('Livre/index.html.twig', [
            'Livres' => $Livres,
            'categories' => $categories,
            'categoryTotals' => $categoryTotals,
            'search' => $search,
        ]);
    }
    #[Route('/Livre/new', name: 'Livre_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $Livre = new Livre();
        $form = $this->createForm(LivreType::class, $Livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->persist($Livre);
            $entityManager->flush();

            return $this->redirectToRoute('Livre_index');
        }

        return $this->render('Livre/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/Livre/{id}/edit', name: 'Livre_edit', methods: ['GET', 'POST'])]

    public function edit(Request $request, Livre $Livre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreType::class, $Livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('Livre_index');
        }

        return $this->render('Livre/edit.html.twig', [
            'Livre' => $Livre,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/Livre/{id}', name: 'Livre_show', methods: ['GET'])]
    public function show(Livre $Livre): Response
    {
        return $this->render('Livre/show.html.twig', [
            'Livre' => $Livre,
        ]);
    }
    #[Route('/Livre/{id}', name: 'Livre_delete')]
    public function deleteLivre($id, EntityManagerInterface $entityManager, LivreRepository $LivreRepository, Request $request)
    {
        $Livre = $LivreRepository->find($id);
        if (!$Livre) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $entityManager->remove($Livre);
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a été supprimé avec succès.');

        return $this->redirectToRoute('Livre_index');
    }
}
