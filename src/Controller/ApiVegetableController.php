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
        $data = json_decode($request->getContent(), true);

        $vegetable = new Vegetable();

        $vegetable->setName($data['name']);
        $vegetable->setScientificName($data['scientific_name']);
        $vegetable->setFamily($data['family']);
        $vegetable->setSowingTemperateClimates($data['sowing_temperate_climates']);
        $vegetable->setSowOtherClimates($data['sow_other_climates']);
        $vegetable->setPlantation($data['plantation']);
        $vegetable->setHarvest($data['harvest']);
        $vegetable->setFlowerpot($data['flowerpot']);
        $vegetable->setSubstrateFertilizer($data['substrate_fertilizer']);
        $vegetable->setIrrigation($data['irrigation']);
        $vegetable->setLight($data['light']);
        $vegetable->setWeather($data['weather']);
        $vegetable->setNotes($data['notes']);
        $vegetable->setProperties($data['properties']);
        $vegetable->setAssociations($data['associations']);
        $vegetable->setPests($data['pests']);
        $vegetable->setFilterMonth($data['filter_month']);
        $vegetable->setimage($data['image']);

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
        
        $data = json_decode($request->getContent(), true);

        $vegetable->setName($data['name']);
        $vegetable->setScientificName($data['scientific_name']);
        $vegetable->setFamily($data['family']);
        $vegetable->setSowingTemperateClimates($data['sowing_temperate_climates']);
        $vegetable->setSowOtherClimates($data['sow_other_climates']);
        $vegetable->setPlantation($data['plantation']);
        $vegetable->setHarvest($data['harvest']);
        $vegetable->setFlowerpot($data['flowerpot']);
        $vegetable->setSubstrateFertilizer($data['substrate_fertilizer']);
        $vegetable->setIrrigation($data['irrigation']);
        $vegetable->setLight($data['light']);
        $vegetable->setWeather($data['weather']);
        $vegetable->setNotes($data['notes']);
        $vegetable->setProperties($data['properties']);
        $vegetable->setAssociations($data['associations']);
        $vegetable->setPests($data['pests']);
        $vegetable->setFilterMonth($data['filter_month']);
        $vegetable->setimage($data['image']);


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
