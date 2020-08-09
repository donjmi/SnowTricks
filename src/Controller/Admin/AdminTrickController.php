<?php

namespace App\Controller\Admin;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(TrickRepository $TrickRepo, EntityManagerInterface $em){
        $this->repository = $TrickRepo;
        $this->em = $em;
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
     * @Route("/admin/trick/create", name="admin.trick.create")
     */
    public function new(Request $request)
    {
        $trick = new Trick();


        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $date = new \DateTime();
            
            $trick->setDateCreate($date);
            $trick->setDateUpdate($date);

            $this->em->persist($trick);
            $this->em-> flush();

            return $this->redirectToRoute("admin.trick.index");
        }

        return $this->render('Admin/trick/new.html.twig', [
            'trick' => $trick,
            'form'  => $form->createview(),
            'actionForm' => 'Création'
        ]); 
    }
    
    /**
     * @Route("/admin/trick/{id}", name="admin.trick.edit")
     */
    public function edit(Trick $trick, Request $request)
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            // $this->em->persist($trick);
            $this->em-> flush();
            // $objectManager = $this->getDoctrine()->getManager();
            // $objectManager->flush();
            return $this->redirectToRoute("admin.trick.index");
        }

        return $this->render('Admin/trick/edit.html.twig', [
            'trick' => $trick,
            'form'  => $form->createview(),
            'actionForm' => 'Modification'
        ]); 
    }
    
    /**
     * @Route("/admin/trick/{id}/delete", name="admin.trick.delete")
     */
    public function delete(Trick $trick)
    {
        $this->em->remove($trick);
        $this->em-> flush();
        
        return $this->redirectToRoute("admin.trick.index");
    }
}
