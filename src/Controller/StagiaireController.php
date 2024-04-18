<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Repository\StagiaireRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StagiaireController extends AbstractController
{
    #[Route('/stagiaire', name: 'app_stagiaire_index')]
    public function index(Request $request,StagiaireRepository $repository): Response
    {
        $stagiaires = $repository->findAll();
        // $stagiaire = new Stagiaire;

        return $this->render('stagiaire/index.html.twig',[ 
        'stagiaires'=>$stagiaires]);
    }
    #[Route(path: '/stagiaire/{slug}-{id}', name: 'app_stagiaire_show', requirements : ['id'=>'\d+','slug'=>'[a-z0-9-]+'])]
    public function show(Request $request, string $slug, int $id,StagiaireRepository $repository): Response
    {
        $stagiaire = $repository->find($id);
        if(strtolower($stagiaire->getNom()) !== $slug){
            return $this->redirectToRoute('app_stagiaire_show',['id'=>$stagiaire->getId(),'slug' =>$stagiaire->getNom()]);
        }
        return $this->render('stagiaire/show.html.twig', [
             'slug' => $slug,
             'id' => $id,
            'stagiaire'=>$stagiaire
        ]);
    }

    #[Route(path: '/stagiaire/create', name: 'app_stagiaire_create')]
    public function create(Request $request,StagiaireRepository $repository,EntityManagerInterface $em): Response
    {
        $stagiaire = new Stagiaire();
        $stagiaire->setNom('vitor');
        $stagiaire->setPrenom('wahid');
        $stagiaire->setAdresse('koekelberg');
        $stagiaire->setAge(30);
        $stagiaire->setEmail("vitor@gmail.com");
        $stagiaire->setDateOfBirth(new DateTimeImmutable("10-06-1990"));
        $em ->persist($stagiaire);
        // $em->flush();
        
        return $this->render('stagiaire/create.html.twig', [
            
            'stagiaire'=>$stagiaire
        ]);
    }

}
