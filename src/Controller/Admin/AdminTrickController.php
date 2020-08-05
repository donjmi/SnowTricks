<?php

namespace App\Controller\Admin;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminTrickController extends AbstractController
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
     * @Route("/admin/trick", name="admin.trick.index")
     */
    public function index()
    {
        $tricks = $this->repository->findAll();
        
        return $this->render('Admin/trick/index.html.twig', compact('tricks'));
    }
    
    /**
     * @Route("/admin/trick/{id}", name="admin.trick.edit")
     */
    public function edit(Trick $trick)
    {
        $form = $this->createForm(TrickType::class, $trick);
        return $this->render('Admin/trick/edit.html.twig', [
            'trick' => $trick,
            'form'  => $form->createview()
        ]); 
    }
}
