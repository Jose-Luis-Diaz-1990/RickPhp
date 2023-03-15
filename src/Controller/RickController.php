<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CharacterType;
use App\Manager\CharacterManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class RickController extends AbstractController{

    #[Route('/character/{id}', name:'showCharacter')]
    public function showCharacter(EntityManagerInterface $doctrine, $id){
        $repositorio=$doctrine->getRepository(Character::class);
        $character=$repositorio->find($id);
        return $this->render('characters/showCharacter.html.twig', ['character'=> $character]);
    }


    #[Route('/characters' , name:'listCharacter')]
    public function listCharacter(EntityManagerInterface $doctrine){
        $repositorio=$doctrine->getRepository(Character::class);
        $characters=$repositorio->findAll();
        return $this->render('characters/listCharacter.html.twig', ['characters' => $characters]);
    }


    #[Route("/new/characters")]
    public function newCharacter(EntityManagerInterface $doctrine){
        $character1= new Character();
        $character1-> setNombre("Rick Sanchez");
        $character1-> setEstado("Alive");
        $character1-> setImagen("https://rickandmortyapi.com/api/character/avatar/1.jpeg");
        $character1-> setCodigo(1);

        $character2= new Character();
        $character2-> setNombre("Morty Smith");
        $character2-> setEstado("Alive");
        $character2-> setImagen("https://rickandmortyapi.com/api/character/avatar/2.jpeg");
        $character2-> setCodigo(2);

        $character3= new Character();
        $character3-> setNombre("Summer Smith");
        $character3-> setEstado("Alive");
        $character3-> setImagen("https://rickandmortyapi.com/api/character/avatar/3.jpeg");
        $character3-> setCodigo(3);

        $character4= new Character();
        $character4-> setNombre("Beth Smith");
        $character4-> setEstado("Alive");
        $character4-> setImagen("https://rickandmortyapi.com/api/character/avatar/4.jpeg");
        $character4-> setCodigo(4);

        $character5= new Character();
        $character5-> setNombre("Jerry Smith");
        $character5-> setEstado("Alive");
        $character5-> setImagen("https://rickandmortyapi.com/api/character/avatar/5.jpeg");
        $character5-> setCodigo(5);
        
        $character6= new Character();
        $character6-> setNombre("Abadango Cluster Princess");
        $character6-> setEstado("Alive");
        $character6-> setImagen("https://rickandmortyapi.com/api/character/avatar/6.jpeg");
        $character6-> setCodigo(6);

        $character7= new Character();
        $character7-> setNombre("Abradolf Lincler");
        $character7-> setEstado("Dead");
        $character7-> setImagen("https://rickandmortyapi.com/api/character/avatar/7.jpeg");
        $character7-> setCodigo(7);

        $character8= new Character();
        $character8-> setNombre("Adjudicator Rick");
        $character8-> setEstado("Dead");
        $character8-> setImagen("https://rickandmortyapi.com/api/character/avatar/8.jpeg");
        $character8-> setCodigo(8);

        $character9= new Character();
        $character9-> setNombre("Agency Director");
        $character9-> setEstado("Dead");
        $character9-> setImagen("https://rickandmortyapi.com/api/character/avatar/9.jpeg");
        $character9-> setCodigo(9);

        $character10= new Character();
        $character10-> setNombre("Alan Rails");
        $character10-> setEstado("Dead");
        $character10-> setImagen("https://rickandmortyapi.com/api/character/avatar/10.jpeg");
        $character10-> setCodigo(10);

        $location1= new Location();
        $location1-> setLocalizacion("Planeta tierra");

        $location2= new Location();
        $location2-> setLocalizacion("La luna");
        
        $location3= new Location();
        $location3-> setLocalizacion("La galaxia oculta");

        $location4= new Location();
        $location4-> setLocalizacion("Planeta termopila");

        $location5= new Location();
        $location5-> setLocalizacion("La amazonica");

        $character1 -> addLocalizacione($location1);
        $character1 -> addLocalizacione($location5);
        $character2 -> addLocalizacione($location1);
        $character2 -> addLocalizacione($location2);
        $character3 -> addLocalizacione($location3);
        $character3 -> addLocalizacione($location1);
        $character4 -> addLocalizacione($location4);
        $character4 -> addLocalizacione($location3);
        $character5 -> addLocalizacione($location5);
        $character5 -> addLocalizacione($location1);
        $character6 -> addLocalizacione($location1);
        $character6 -> addLocalizacione($location2);
        $character7 -> addLocalizacione($location2);
        $character7 -> addLocalizacione($location4);
        $character8 -> addLocalizacione($location3);
        $character8 -> addLocalizacione($location2);
        $character9 -> addLocalizacione($location4);
        $character9 -> addLocalizacione($location5);
        $character10 -> addLocalizacione($location5);
        $character10 -> addLocalizacione($location1);
        

        $doctrine->persist($character1);
        $doctrine->persist($character2);
        $doctrine->persist($character3);
        $doctrine->persist($character4);
        $doctrine->persist($character5);
        $doctrine->persist($character6);
        $doctrine->persist($character7);
        $doctrine->persist($character8);
        $doctrine->persist($character9);
        $doctrine->persist($character10);

        $doctrine->persist($location1);
        $doctrine->persist($location2);
        $doctrine->persist($location3);
        $doctrine->persist($location4);
        $doctrine->persist($location5);

        $doctrine-> flush();
        return new Response("BD correctamenete escrita");
    }

    #[Route('/insert/character', name: 'insertCharacter')]
    public function insertCharacter(Request $request, EntityManagerInterface $doctrine, CharacterManager $manager){
        $form = $this -> createForm(CharacterType::class);
        $form->handleRequest($request);
        if ( $form-> isSubmitted() && $form-> isValid()){
            $character = $form-> getData();
            $characterImage = $form-> get('imagenCharacter')-> getData();
            if ($characterImage){
                $characterImg = $manager -> load($characterImage, $this->getParameter('kernel.project_dir').'/public/asset/image');
                $character -> setImagen('/asset/image/'.$characterImg);
            }
            $doctrine-> persist($character);
            $doctrine-> flush();
            $this-> addFlash('success', 'Personaje creado correctamente');
            return $this-> redirectToRoute('listCharacter');
        }
        return $this -> renderForm('characters/createCharacter.html.twig', [ 'characterForm' => $form ]);
    }

    #[Route('/edit/character/{id}', name: 'editCharacter')]
    public function editCharacter(Request $request, EntityManagerInterface $doctrine, $id){
        $repositorio=$doctrine->getRepository(Character::class);
        $character=$repositorio->find($id);
        $form = $this -> createForm(CharacterType::class, $character);
        $form->handleRequest($request);
        if ( $form-> isSubmitted() && $form-> isValid()){
            $character = $form-> getData();
            $doctrine-> persist($character);
            $doctrine-> flush();
            $this-> addFlash('success', 'Personaje creado correctamente');
            return $this-> redirectToRoute('listCharacter');
        }
        return $this -> renderForm('characters/createCharacter.html.twig', [ 'characterForm' => $form ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/delete/character/{id}', name:'deleteCharacter')]
    public function deleteCharacter(EntityManagerInterface $doctrine, $id){
        $repositorio=$doctrine->getRepository(Character::class);
        $character=$repositorio->find($id);
        $doctrine-> remove($character);
        $doctrine-> flush();
        $this-> addFlash('success', "Personaje borrado correctamente");
        return $this->redirectToRoute('listCharacter');
    }
}