<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/Contact", name="api_Contact_")
 */
class ApiContactController extends AbstractController
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
        ContactRepository $contactRepository
    ): Response
    {
        if($request->query->has('term')) {
            $contact = $contactRepository->findByTerm($request->query->get('term'));

            return $this->json($contact);
        }

        return $this->json($contactRepository->findAll());
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
    public function show(Contact $contact): Response
    {
        return $this->json($contact);
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
        // $data = $request->request;
        $data = json_decode($request->getContent(), true);

        $contact = new Contact();

        // $contact->setName($data->get('name'));
        $contact->setName($data['name']);

        // $contact->setEmail($data->get('email'));
        $contact->setEmail($data['email']);

        // $contact->setInformation($data->get('information'));
        $contact->setInformation($data['information']);


        $errors = $validator->validate($contact);

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

        $entityManagerInterface->persist($contact); 
        $entityManagerInterface->flush();

        return $this->json(
            $contact,
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'api_Contact_get',
                    [
                        'id' => $contact->getId()
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
        Contact $contact,
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ):Response{
        
        $data = $request->request;

        $contact->setName($data->get('name'));
        $contact->setEmail($data->get('email'));
        $contact->setInformation($data->get('information'));


        $entityManagerInterface->persist($contact);
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
        Contact $contact,
        EntityManagerInterface $entityManagerInterface
    ):Response {

        $entityManagerInterface->remove($contact);
        $entityManagerInterface->flush();
        return  $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
