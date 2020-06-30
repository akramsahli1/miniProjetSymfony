<?php

namespace App\Controller;


use App\Entity\Circuit;
use App\Entity\EtapeCircuit;
use App\Form\CircuitType;
use App\Form\EtapeCircuitType;
use App\Repository\CircuitRepository;
use App\Repository\EtapeCircuitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtapeCircuitController extends AbstractController
{
   /*
    * @var EtapeCircuitRepository
    */
    private $Etapecircuit;


    /*
     * @var EntityManagerInterface
     */
    private $em;

    public function __Construct(EtapeCircuitRepository $repository,EntityManagerInterface $em)
    {
        //Etapecircuit
        $this->Etapecircuit = $repository;
        //Entity manager
        $this->em = $em;
    }

    /**
     * @Route("/etapeCircuit/{id}", name="etapeCircuit")
     * @param Circuit $Circuit
     * @return Response
     */
    public function index(Circuit $Circuit): Response
    {
        $etapeCircuits = $this->Etapecircuit->findBy(['code_circuit_etape' => $Circuit]);
        return $this->render('etapecircuit/etapecircuit.html.twig', [
            'controller_name' => 'EtapeCircuitController',
            'etapeCircuits' => $etapeCircuits,
            'cir' => $Circuit
        ]);
    }

    /**
     * @Route("/etapeCircuit/create/{id}", name="newEtapeCircuit")
     * @param Circuit $cir
     * @param Request $request
     * @return Response
     */
    public function newEtapeCircuit(Circuit $cir,Request $request):Response
    {
        $etapeCircuit = new EtapeCircuit();
        $etapeCircuit->setCodeCircuitEtape($cir);
        $form = $this->createForm(EtapeCircuitType::class,$etapeCircuit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($etapeCircuit);
            $this->em->flush();
            return $this->redirectToRoute('etapeCircuit',['id' => $cir->getId()]);
        }

        return $this->render('administration/newEtapeCircuit.html.twig',[
            'cir' => $cir,
            'etapeCircuit' => $etapeCircuit,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/etapeCircuit/{id}/{cir}", name="editEtapeCircuit")
     * @param EtapeCircuit $etapeCircuit
     * @param Circuit $cir
     * @param Request $request
     * @return Response
     */
    public function editEtapeCircuit(EtapeCircuit $etapeCircuit, Circuit $cir, Request $request):Response
    {
        $form = $this->createForm(EtapeCircuitType::class,$etapeCircuit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('etapeCircuit',['id' => $cir->getId()]);
        }

        return $this->render('administration/editEtapeCircuit.html.twig',[
            'cir' => $cir,
            'etapeCircuit' => $etapeCircuit,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/etapeCircuitDelete/{id}/{cir}", name="deleteEtapeCircuit")
     * @param EtapeCircuit $etapeCircuit
     * @param Circuit $cir
     * @param Request $request
     * @return RedirectResponse;
     */
    public function deleteEtapeCircuit(EtapeCircuit $etapeCircuit, Circuit $cir, Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$etapeCircuit->getId(),$request->get('_token'))){
            $this->em->remove($etapeCircuit);
            $this->em->flush();
        }
        return $this->redirectToRoute('etapeCircuit',['id' => $cir->getId()]);
    }
}
?>