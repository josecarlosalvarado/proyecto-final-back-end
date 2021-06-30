<?php

namespace App\Controller;

use App\Entity\Vegetable;
use App\Repository\VegetableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/vegetables", name="api_vegetables_")
 */
class ApiVegetableController extends AbstractController
{
    /**
     * @Route(
     *      "",
     *      name="cget",
     *      methods={"GET"}
     * )
     */
    public function index(
        Request $request,
        VegetableRepository $vegetableRepository   
    ): Response
    {
        if($request->query->has('term')) {
            $vegetable = $vegetableRepository->findByTerm($request->query->get('term'));

            return $this->json($vegetable);
        }

        return $this->json($vegetableRepository->findAll());
    }

    /**
     * @Route(
     *      "/{id}",
     *      name="get",
     *      methods={"GET"},
     *      requirements={
     *          "id": "\d+"
     *      }
     * )
     */
    public function show(Vegetable $vegetable): Response
    {
        return $this->json($vegetable);
    }

      /**
     * @Route(
     *      "",
     *      name="post",
     *      methods={"POST"}
     * )
     */
    public function add(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        ValidatorInterface $validator
    ): Response

    {
        $data = $request->request;

        $vegetable = new Vegetable();

        $vegetable->setName($data->get('name'));
        $vegetable->setScientificName($data->get('scientific_name'));
        $vegetable->setFamily($data->get('family'));
        $vegetable->setSowingTemperateClimates($data->get('sowing_temperate_climates'));
        $vegetable->setSowOtherClimates($data->get('sow_other_climates'));
        $vegetable->setPlantation($data->get('plantation'));
        $vegetable->setHarvest($data->get('harvest'));
        $vegetable->setFlowerpot($data->get('flowerpot'));
        $vegetable->setSubstrateFertilizer($data->get('substrate_fertilizer'));
        $vegetable->setIrrigation($data->get('irrigation'));
        $vegetable->setLight($data->get('light'));
        $vegetable->setWeather($data->get('weather'));
        $vegetable->setNotes($data->get('notes'));
        $vegetable->setProperties($data->get('properties'));
        $vegetable->setAssociations($data->get('associations'));
        $vegetable->setPests($data->get('pests'));
        $vegetable->setFilterMonth($data->get('filter_month'));
        $vegetable->setimage($data->get('image'));

        $errors = $validator->validate($vegetable);

        if(count($errors) > 0){
            $dataError = [];

            /** @var \Symfony\Component\Validator\ConstraintViolation $error */
            foreach($errors as $error) {
                $dataError[] = $error->getMessage();
            }

            return $this->json([
                'status' => 'error',
                'data' => [
                    'errors' => $dataError
                ]
            ],
            Response::HTTP_BAD_REQUEST);
        }

        $entityManagerInterface->persist($vegetable); 
        $entityManagerInterface->flush();

        return $this->json(
            $vegetable,
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'api_vegetables_get',
                    [
                        'id' => $vegetable->getId()
                    ]
                )
            ]
        );
    }

        /**
     * @Route(
     * "/{id}",
     *  name="update",  
     *  methods={"PUT"},
     *   requirements={
     *          "id": "\d+" 
     * })
     */
    public function update(
        Vegetable $vegetable,
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ):Response{
        
        $data = $request->request;

        $vegetable->setName($data->get('name'));
        $vegetable->setScientificName($data->get('scientific_name'));
        $vegetable->setFamily($data->get('family'));
        $vegetable->setSowingTemperateClimates($data->get('sowing_temperate_climates'));
        $vegetable->setSowOtherClimates($data->get('sow_other_climates'));
        $vegetable->setPlantation($data->get('plantation'));
        $vegetable->setHarvest($data->get('harvest'));
        $vegetable->setFlowerpot($data->get('flowerpot'));
        $vegetable->setSubstrateFertilizer($data->get('substrate_fertilizer'));
        $vegetable->setIrrigation($data->get('irrigation'));
        $vegetable->setLight($data->get('light'));
        $vegetable->setWeather($data->get('weather'));
        $vegetable->setNotes($data->get('notes'));
        $vegetable->setProperties($data->get('properties'));
        $vegetable->setAssociations($data->get('associations'));
        $vegetable->setPests($data->get('pests'));
        $vegetable->setFilterMonth($data->get('filter_month'));
        $vegetable->setimage($data->get('image'));


        $entityManagerInterface->persist($vegetable);
        $entityManagerInterface->flush();

        return  $this->json([
            
        ]);

    }
            /**
     * @Route(
     * "/{id}",
     *  name="delete",
     *  methods={"DELETE"},
     *   requirements={
     *          "id": "\d+" 
     * })
     */
    public function DeleteVegetable(
        Vegetable $vegetable,
        EntityManagerInterface $entityManagerInterface
    ):Response {

        $entityManagerInterface->remove($vegetable);
        $entityManagerInterface->flush();
        return  $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
