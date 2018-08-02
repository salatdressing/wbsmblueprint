<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Brands;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("/add", name="add")
     */

    public function add()
    {
      $entityManager = $this->getDoctrine()->getManager();

      $brand = new Brands();
      $brand->setBrand("abcdef");

      $entityManager->persist($brand);
      $entityManager->flush();

      return new Response('Saved new brand with id '.$brand->getId());
    }

     /**
     * @Route("/brands/{id}", name="brands_show", methods="GET")
     */
    public function get($id): Response
    {
      $brand = $this->getDoctrine()->getRepository(Brands::class)->find($id);
      if (!$brand) {
        throw $this->createNotFoundException(
            'No product found for id '.$id
        );
      }
      return new Response("You requested the brand " . $brand->getBrand() );
    }
}
