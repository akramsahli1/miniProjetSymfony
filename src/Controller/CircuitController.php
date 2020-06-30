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

class CircuitController extends AbstractController{

    /*
     * @var CircuitRepository
     */
    private $circuit;


    /*
     * @var EntityManagerInterface
     */
    private $em;

    public function __Construct(CircuitRepository $repository,EntityManagerInterface $em)
    {
        //circuit
        $this->circuit = $repository;
        //Entity manager
        $this->em = $em;
    }

    /**
     * @Route("/circuit", name="circuit")
     * @return Response
     */
    public function Circuit()
    {
        $circuits = $this->circuit->findAll();
        return $this->render('circuit/circuit.html.twig', [
            'controller_name' => 'CircuitController',
            'circuits' => $circuits
        ]);
    }


    /**
     * @Route("/circuit/create", name="newcircuit")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request):Response
    {
        $circuit = new Circuit();

        $form = $this->createForm(CircuitType::class,$circuit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($circuit);
            $this->em->flush();
            return $this->redirectToRoute('circuit');
        }

        return $this->render('administration/newCircuit.html.twig',[
            'circuit' => $circuit,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/circuitDelete/{id}", name="deletecircuit")
     * @param Circuit $circuit
     * @param Request $request
     * @return RedirectResponse;
     */
    public function delete(Circuit $circuit,Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$circuit->getId(),$request->get('_token'))){
            $this->em->remove($circuit);
            $this->em->flush();
        }
        return $this->redirectToRoute('circuit');
    }


    /**
     * @Route("/circuitedit/{id}", name="editcircuit")
     * @param Circuit $circuit
     * @param Request $request
     * @return Response
     */
    public function edit(Circuit $circuit,Request $request):Response
    {
        $form = $this->createForm(CircuitType::class,$circuit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('circuit');
        }

        return $this->render('administration/editCircuit.html.twig',[
            'circuit' => $circuit,
            'form' => $form->createView()
        ]);
    }

}
?>