<?php

namespace App\Controller;

use App\Entity\Aromatic;
use App\Repository\AromaticRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/Aromatic", name="api_Aromatic_")
 */
class ApiAromaticController extends AbstractController
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
        AromaticRepository $aromaticRepository
    ): Response
    {
        if($request->query->has('term')) {
            $aromatic = $aromaticRepository->findByTerm($request->query->get('term'));

            return $this->json($aromatic);
        }

        return $this->json($aromaticRepository->findAll());
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
    public function show(Aromatic $aromatic): Response
    {
        return $this->json($aromatic);
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

        $aromatic = new Aromatic();

        $aromatic->setName($data->get('name'));
        $aromatic->setScientificName($data->get('scientific_name'));
        $aromatic->setFamily($data->get('family'));
        $aromatic->setSowingTemperatureClimates($data->get('sowing_temperature_climates'));
        $aromatic->setSowOtherClimates($data->get('sow_other_climates'));
        $aromatic->setHarvest($data->get('harvest'));
        $aromatic->setFlowerpot($data->get('flowerpot'));
        $aromatic->setSubtrateFertilizer($data->get('subtrate_fertilizer'));
        $aromatic->setIrrigation($data->get('irrigation'));
        $aromatic->setLight($data->get('light'));
        $aromatic->setWeather($data->get('weather'));
        $aromatic->setDifficulty($data->get('difficulty'));
        $aromatic->setNotes($data->get('notes'));
        $aromatic->setProperties($data->get('properties'));
        $aromatic->setPests($data->get('pests'));

        $errors = $validator->validate($aromatic);

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

        $entityManagerInterface->persist($aromatic); 
        $entityManagerInterface->flush();

        return $this->json(
            $aromatic,
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'api_Aromatic_get',
                    [
                        'id' => $aromatic->getId()
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
        Aromatic $aromatic,
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ):Response{
        
        $data = $request->request;

        $aromatic->setName($data->get('name'));
        $aromatic->setScientificName($data->get('scientific_name'));
        $aromatic->setFamily($data->get('family'));
        $aromatic->setSowingTemperatureClimates($data->get('sowing_temperature_climates'));
        $aromatic->setSowOtherClimates($data->get('sow_other_climates'));
        $aromatic->setHarvest($data->get('harvest'));
        $aromatic->setFlowerpot($data->get('flowerpot'));
        $aromatic->setSubtrateFertilizer($data->get('subtrate_fertilizer'));
        $aromatic->setIrrigation($data->get('irrigation'));
        $aromatic->setLight($data->get('light'));
        $aromatic->setWeather($data->get('weather'));
        $aromatic->setDifficulty($data->get('difficulty'));
        $aromatic->setNotes($data->get('notes'));
        $aromatic->setProperties($data->get('properties'));
        $aromatic->setPests($data->get('pests'));


        $entityManagerInterface->persist($aromatic);
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
    public function deleteAromatic(
        Aromatic $aromatic,
        EntityManagerInterface $entityManagerInterface
    ):Response {

        $entityManagerInterface->remove($aromatic);
        $entityManagerInterface->flush();
        return  $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
