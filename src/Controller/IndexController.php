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
            'No brand found for id '.$id
        );
      }
      return $this->render('index/show.html.twig', [
          'brands' => array($brand),
      ]);
    }

    /**
    * @Route("/all_brands/", name="brands_show_all", methods="GET")
    */

    public function getAllBrands(): Response
    {
      $brand =$this->getDoctrine()->getRepository(Brands::class)->findAll();

      return $this->render('index/show.html.twig', [
        'brands' => $brand,
      ]);
    }

    /**
    *  @Route("/brand_page/{pageNumber}", name="brands_show_all_from_page")
    */
    public function getBrandsFromPage($pageNumber): Response
    {
      $brand = $this->getDoctrine()->getRepository(Brands::class)->getPage($pageNumber);

      return $this->render('index/show.html.twig', [
        'brands' => $brand,
      ]);
    }

    /**
    *  @Route("/brand_form", name="brands_form")
    */
    public function newBrandForm()
    {
      return $this->render('index/new.html.twig');
    }

    /**
    *  @Route("/brand_new", name="brands_new")
    */


    public function newBrand(Request $request, ApiService $apiService, FractalService $fractalService)
  {
          /** @var Brand $brandname */
          $brandname = $this->getBrand();

          /** @var UserRepository $rep */
          $em = $this->getDoctrine()->getManager();

          $data = $request->getContent();

          if(empty($data)) throw new CustomApiException(Response::HTTP_BAD_REQUEST, "Data sent null.");

          /** @var Meeting $test */
          $brand = $apiService->validateAndCreate($data, Brands::class);

          $brand->setBrand($brandname);

          $em->persist($brand);
          $em->flush();

          //Return data however you wish, I use a FractalService
          return new Response('Saved new brand with id '.$brand->getId());

      }

}
