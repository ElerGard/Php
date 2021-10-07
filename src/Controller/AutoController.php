<?php

namespace App\Controller;

use App\Entity\Auto;
use App\Form\AutoFormType;
use App\Repository\AutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AutoController extends AbstractController
{
    /**
     * @Route("/auto", name="auto")
     * @param AutoRepository $autoRepository
     *
     */
    public function index(AutoRepository $autoRepository): Response
    {
        $auto = $autoRepository->findAll();

        //dump($auto);

        return $this->render('auto/index.html.twig', [
            'autos' => $auto
        ]);
    }

    /**
     * @Route("/auto/create", name="sas")
     */
    public function create(Request $request) {
        $auto = new Auto();

        $form = $this->createForm(AutoFormType::class, $auto);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($auto);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('auto'));
    }


    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function remove(Auto $auto){
        $em = $this->getDoctrine()->getManager();

        $em->remove($auto);
        $em->flush();

        return $this->redirect($this->generateUrl('auto'));
    }
}
