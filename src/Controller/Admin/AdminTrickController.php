<?php

namespace App\Controller\Admin;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function edit(Trick $trick, Request $request)
    // public function edit(Trick $trick, Request $request, ObjectManager $objectManager)
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
        //     $objectManager->persist($trick);
        //     $objectManager->flush();
            $objectManager = $this->getDoctrine()->getManager();
            $objectManager->flush();
            return $this->redirectToRoute("admin.trick.index");
        }

        return $this->render('Admin/trick/edit.html.twig', [
            'trick' => $trick,
            'form'  => $form->createview()
        ]); 
    }
}
