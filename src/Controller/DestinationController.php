<?php

namespace App\Controller;
use App\Entity\Destination;
use App\Entity\Ville;
use App\Form\DestinationType;
use App\Form\VilleType;
use App\Repository\DestinationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

class DestinationController extends AbstractController
{

    /**
     * @var DestinationRepository
     */
    private $destination;

    /*
     * @var EntityManagerInterface
     */
    private $em;
    
    public function __construct(DestinationRepository $destination, EntityManagerInterface $em)
    {
        $this->destination = $destination;
        $this->em = $em;
    }

    /**
     * @Route("/destination", name="destination")
     * @return Response
     */
    public function destination():Response
    {
        $destinations = $this->destination->findAll();
        return $this->render('destination/destination.html.twig', [
            'controller_name' => 'DestinationController',
            'destinations' => $destinations
        ]);
    }

    /**
     * @Route("/destination/create", name="newdestination")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request):Response
    {
        $destination = new Destination();

        $form = $this->createForm(DestinationType::class,$destination);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($destination);
            $this->em->flush();
            return $this->redirectToRoute('destination');
        }

        return $this->render('administration/newDestination.html.twig',[
            'destination' => $destination,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/destinationDelete/{id}", name="deletedestination")
     * @param Destination $destination
     * @param Request $request
     * @return RedirectResponse;
     */

    public function delete(Destination $destination,Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$destination->getId(),$request->get('_token'))){
            $this->em->remove($destination);
            $this->em->flush();
        }
        return $this->redirectToRoute('destination');
    }
    /**
     * @Route("/editDestination/{id}", name="editdestination")
     * @param Destination $destination
     * @param Request $request
     * @return Response
     */
    public function edit(Destination $destination,Request $request):Response
    {
        $form = $this->createForm(DestinationType::class,$destination);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('destination');
        }

        return $this->render('administration/editDestination.html.twig',[
            'destination' => $destination,
            'form' => $form->createView()
        ]);
    }

}

?>