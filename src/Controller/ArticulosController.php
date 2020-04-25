<?php

namespace App\Controller;

use App\Entity\Articulos;
use App\Form\ArticulosType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticulosController extends AbstractController
{
    /**
     * @Route("/articulos", name="articulos")
     */
    public function index()
    {
        $articulosRepository = $this->getDoctrine()->getRepository(Articulos::class);
        $articulos = $articulosRepository->findAll();

        return $this->render('articulos/index.html.twig', [
            'articulos' => $articulos,
        ]);
    }

    /**
     * @Route("/articulos/{id}", name="mostrar_un_articulo", requirements={"id"="\d+"})
     *
     * @param null|mixed $id
     */
    public function mostrarArticulo($id = null)
    {
        $articuloRepository = $this->getDoctrine()->getRepository(Articulos::class);
        $articulo = $articuloRepository->find($id);

        return $this->render('articulos/unArticulo.html.twig', [
            'art' => $articulo,
        ]);
    }

    /**
     * @Route("/articulos/nuevoArticulo", name="insertar_articulo")
     */
    public function nuevoArticulo(Request $request)
    {
        $articulos = new Articulos();
        $form = $this->createForm(ArticulosType::class, $articulos);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $articulos = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($articulos);
            $em->flush();

            return $this->redirectToRoute('mostrar_un_articulo', ['id' => $articulos->getId()]);
        }

        return $this->render('articulos/nuevoArticulo.html.twig', ['form' => $form->createView()]);
    }
}
