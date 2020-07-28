<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    
    /**
     * repository
     * @var TrickRepository
     */
    private $repository;

    public function __construct(TrickRepository $TrickRepo){
        $this->repository = $TrickRepo;
    }

    /**
     * @Route("/trick", name="trick.index")
     */
    public function index()
    { 
        return $this->render('trick/index.html.twig', [
            'controller_name' => 'TrickController',
            'tricks'    => $tricks = $this->repository->findAllDesc()
        ]);
    }

        
    /**
     *  @Route("/trick/{id}", name="trick.show")
     *
     * @return void
     */
    public function show($id)
    { 
        return $this->render('trick/show.html.twig', [
            'tricks'    => $tricks = $this->repository->find($id)
        ]);
    }
    

}
