<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if(!$this->getUser()){ // si l'utilisateur n'est pas connecté, on le redige vers etudiant index

            $this->addFlash('danger', 'Désolé, vous devez être connecter avant d\'acceder à cette page'); // 2 parametres, "danger" pour symfony et l'autre pour afficher à l'utilisaeur

            
            return $this->redirectToRoute('etudiant_index');
        }

        if ($form->isSubmitted() && $form->isValid()) { // vérifie si tous les champs du formulaire sont bien renseignés
            $entityManager = $this->getDoctrine()->getManager(); // cp,nexion à la base de donnée

            $post->setUser($this->getUser()); //associe l'id de l'utilisateur courant pour le mettre dans l'utilsateur dans Post

            $entityManager->persist($post); // recupérer les données
            $entityManager->flush(); // insertion en base

            $this->addFlash('success', 'Bravo, votre article vient d\'etre créer avec succes');

            return $this->redirectToRoute('post_index'); // effectue la redirection 
        }

        return $this->render('post/new.html.twig', [ // pour l'affichage
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
      
    }
}
