<?php

namespace App\Controller;

use App\Entity\Contacto;
use App\Form\ContactoFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'inicio')]
    public function inicio(): Response
    {
        $this->getUser();
        return $this->render("page/inicio.html.twig");
    }

    #[Route('/contacto/{id}', name: 'ficha_contacto')]
    public function index(ManagerRegistry $doc, $id): Response {
        $repo = $doc->getRepository(Contacto::class);
        $contacto = $repo->find($id);

        if($contacto){return $this->render('ficha_contacto.html.twig', ['contacto' => $contacto]);
        } else return new Response("<html><body>manzana $id no encontrada.</body>");
    }

    #[Route('/contacto/nuevo', name: 'nuevo')]
    public function nuevo(ManagerRegistry $doctrine, Request $request)
    {
        $contacto = new Contacto();
        $formulario = $this->createForm(ContactoFormType::class, $contacto);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $contacto = $formulario->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($contacto);
            $entityManager->flush();
            return $this->redirectToRoute('ficha_contacto', ["id" => $contacto->getId()]);
        }
        return $this->render('page/nuevo.html.twig', array(
            'formulario' => $formulario->createView()
        ));
    }
    /**
     * @Route("/contacto/delete/{id}", name="eliminar_contacto")
     **/
    public function delete(ManagerRegistry $doctrine, $id): Response{
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Contacto::class);
        $contacto = $repositorio->find($id);

        if ($contacto) {
            try {
                $entityManager->remove($contacto);
                $entityManager->flush();
                return new Response("Contacto eliminado");
            } catch (\Exception $e) {
                return new Response("Error eliminado objeto");
            }
        } else return $this->render('ficha_contacto.html.twig', ['contacto' => null]);
    }
}

