<?php

namespace App\Controller;


use App\Entity\Destination;
use App\Entity\Ville;
use App\Form\DestinationType;
use App\Form\VilleType;
use App\Repository\DestinationRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class VilleController extends AbstractController
{

    /**
     * @var VilleRepository
     */
    private $ville;

    /*
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(VilleRepository $ville, EntityManagerInterface $em)
    {
        $this->ville = $ville;
        $this->em = $em;
    }

    /**
     * @Route("/ville/{id}", name="ville")
     * @param Destination $des
     * @return Response
     */
    public function index(Destination $des): Response
    {
        $villes = $this->ville->findBy(['code_dest' => $des]);
        return $this->render('ville/ville.html.twig', [
            'controller_name' => 'VilleController',
            'villes' => $villes,
            'des' => $des
        ]);
    }

    /**
     * @Route("/ville/create/{id}", name="newVille")
     * @param Destination $des
     * @param Request $request
     * @return Response
     */
    public function newVille(Destination $des,Request $request):Response
    {
        $ville = new Ville();
        $ville->setCodeDest($des);
        $form = $this->createForm(VilleType::class,$ville);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em1 = $this->getDoctrine()->getManager();
            $em1->persist($ville);
            $em1->flush();
            return $this->redirectToRoute('ville',['id' => $des->getId()]);
            //    return $this->redirectToRoute('ville/{id}');
        }

        return $this->render('administration/newVille.html.twig',[
            'des' => $des,
            'ville' => $ville,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/villeDelete/{id}/{des}", name="deleteVille")
     * @param Ville $ville
     * @param Destination $des
     * @param Request $request
     * @return RedirectResponse;
     */

    public function deleteVille(Ville $ville,Destination $des,Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$ville->getId(),$request->get('_token'))){
            $this->em->remove($ville);
            $this->em->flush();
        }
       return $this->redirectToRoute('ville',['id' => $des->getId()]);
    }


    /**
     * @Route("/editville/{id}/{des}", name="editVille")
     * @param Ville $ville
     * @param Destination $des
     * @param Request $request
     * @return Response
     */
    public function editVille(Ville $ville,Destination $des,Request $request):Response
    {


        $form = $this->createForm(VilleType::class,$ville);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('ville',['id' => $des->getId()]);
        }

        return $this->render('administration/editVille.html.twig',[
            'des' => $des,
            'ville' => $ville,
            'form' => $form->createView()
        ]);
    }
}
?>