<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\TopicType;
use App\Repository\TopicRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/topic")
 */
class TopicController extends AbstractController
{

    /**
     * @Route("/new", name="topic_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        if ($this->getUser())
            {
                $topic = new Topic();
                $author = $userRepository->find($this->getUser()->getId());
                $topic->setCreationDate(new \DateTime());
                $topic->setAuthor($author);
                $form = $this->createForm(TopicType::class, $topic);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($topic);
                    $entityManager->flush();

                    return $this->redirectToRoute('topic_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->renderForm('topic/new.html.twig', [
                    'topic' => $topic,
                    'form' => $form,
                ]);
            }
        else
            {
                $this->addFlash('error', 'Vous devez être identifié pour publier un topic');
                return $this->redirectToRoute('main_home', [], Response::HTTP_SEE_OTHER);
            }
    }

    /**
     * @Route("/{id}", name="topic_show", methods={"GET"})
     */
    public function show(Topic $topic): Response
    {
        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
        ]);
    }

}
