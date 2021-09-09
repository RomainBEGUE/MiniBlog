<?php

namespace App\Controller;

use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */
    public function index(TopicRepository $topicRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'topics' => $topicRepository->findAllByOrder(),
        ]);
    }
}
