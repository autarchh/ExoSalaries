<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/entreprises")
 */
class EntrepriseController extends AbstractController
{
    /**
     * @Route("/", name="entreprises_index")
     */
    public function index(EntrepriseRepository $repo): Response
    {
        $entreprises = $repo->getAll();

        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }

     /**
     * @Route("/{id}", name="entreprise_show", methods={"GET"})
     */
    public function show(Entreprise $entreprise): Response {
        return $this->render('entreprise/show.html.twig', ['entreprise' => $entreprise]);
    }
}


