<?php

namespace App\Controller;

use App\Entity\Etudiants;
use App\Form\EtudiantsType;
use App\Repository\EtudiantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/etudiants")
 */
class EtudiantsController extends AbstractController
{
    /**
     * @Route("/", name="etudiants_index", methods={"GET"})
     */
    public function index(EtudiantsRepository $etudiantsRepository): Response
    {
        return $this->render('etudiants/index.html.twig', [
            'etudiants' => $etudiantsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="etudiants_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $etudiant = new Etudiants();
        $form = $this->createForm(EtudiantsType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();

            return $this->redirectToRoute('etudiants_index');
        }

        return $this->render('etudiants/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudiants_show", methods={"GET"})
     */
    public function show(Etudiants $etudiant): Response
    {
        return $this->render('etudiants/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="etudiants_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Etudiants $etudiant): Response
    {
        $form = $this->createForm(EtudiantsType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etudiants_index');
        }

        return $this->render('etudiants/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudiants_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Etudiants $etudiant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etudiant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etudiants_index');
    }
}
