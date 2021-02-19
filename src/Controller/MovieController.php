<?php

namespace App\Controller;

use App\Entity\Films;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/films", name="movie")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Films::class);

        $films = $repo->findAll();
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
            'films' => $films
        ]);
    }


    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('movie/home.html.twig');
    }

    /**
     * @Route("/films/new", name="SuMovies_new")
     * @Route("/films/{title}/edit", name="SuMovies_edit")
     
     */
    public function form(Films $film = null, Request $request,EntityManagerInterface $manager): Response
    {

        if (!$film){
            $film = new Films();
        }
        $form = $this->createFormBuilder($film)
                     ->add('title')
                     ->add('image')
                     ->add('createdAt',DateType::class,array(
                        'years' => range(date('Y'),1915)
                      ))
                     ->add('duree',TimeType::class)
                     ->add('synopsys')
                     ->add('resume')
                     ->getForm();

        $form->handleRequest($request);

        dump($film);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($film);
            $manager->flush();

            return $this->redirectToRoute('SuMovies_show',['title' => $film->getTitle()]);
            
        }

        return $this->render('movie/new.html.twig',[
            'formFilm' => $form->createView(),
            'editMode' => $film->getId() != null
        ]);
    }


    /**
     * @Route("/films/{title}", name="SuMovies_show")
     */
    public function show($title): Response
    {
        $repo = $this->getDoctrine()->getRepository(Films::class);
        $film = $repo-> findOneBy(
            ['title' => $title],
        );
        return $this->render('movie/show.html.twig',[
            'film' =>$film
        ]);
    }
}
