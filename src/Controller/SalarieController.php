<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Salarie;
use App\Repository\SalarieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salaries")
 */
class SalarieController extends AbstractController
{
    /**
     * @Route("/add", name="salarie_add")
     * @Route("/{id}/edit", name="salarie_edit")
     */
    public function addSalarie(Salarie $salarie = null, Request $request, EntityManagerInterface $manager){
        if(!$salarie){
            $salarie = new Salarie();
        }

        $form = $this->createFormBuilder($salarie)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('datenaissance', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('adresse', TextType::class)
            ->add('cp', TextType::class)
            ->add('ville', TextType::class)
            ->add('dateEmbauche', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('Entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'raisonSociale',
            ])
            ->add('Valider', SubmitType::class)
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($salarie);
            $manager->flush();

            return $this->redirectToRoute('salaries_index');
        }

        return $this->render('salarie/add_edit.html.twig', [
            'form' => $form->createView(),
            'editMode' => $salarie->getId() !== null
        ]);

    }

    /**
     * @Route("/delete/{id}", name="salarie_del")
     */
    public function delSalarie(Salarie $salarie = null, EntityManagerInterface $em) : Response
    {
        if($salarie) {
            $em->remove($salarie);
            $em->flush();
        }
        return $this->redirectToRoute("salaries_index");
    }

    /**
     * @Route("/", name="salaries_index")
     */
    public function index(SalarieRepository $repo): Response
    {
                $salaries = $repo->getAll();

        return $this->render('salarie/index.html.twig', [
            'salaries' => $salaries,
        ]);
    }

    /**
     * @Route("/{id}", name="salarie_show", methods="GET")
     */
    public function show(Salarie $salarie): Response {
        return $this->render('salarie/show.html.twig', ['salarie' => $salarie]);
    }


}