<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/Users", name="api_Users_")
 */
class ApiUserController extends AbstractController
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
        UsersRepository $usersRepository
    ): Response
    {
        if($request->query->has('term')) {
            $users = $usersRepository->findByTerm($request->query->get('term'));

            return $this->json($users);
        }

        return $this->json($usersRepository->findAll());
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
    public function show(Users $users): Response
    {
        return $this->json($users);
    }

    /**
     * @Route(
     *      "",
     *      name="post",
     *      methods={"POST"}
     * )
     */
    public function add(
        // Request $request,
        // EntityManagerInterface $entityManagerInterface,
        // ValidatorInterface $validator
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        ValidatorInterface $validator
    ): Response

    {
        $data = $request->request;

        $user = new Users();

        $user->setName($data->get('name'));
        $user->setEmail($data->get('email'));
        $user->setPassword($data->get('password'));

        $errors = $validator->validate($user);

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

        $entityManagerInterface->persist($user); 
        $entityManagerInterface->flush();

        return $this->json(
            $user,
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'api_Users_get',
                    [
                        'id' => $user->getId()
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
        // Contact $contact,
        // EntityManagerInterface $entityManagerInterface,
        // Request $request
        Users $users,
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ):Response{
        
        $data = $request->request;

        $users->setName($data->get('name'));
        $users->setEmail($data->get('email'));
        $users->setPassword($data->get('password'));


        $entityManagerInterface->persist($users);
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
        Users $users,
        EntityManagerInterface $entityManagerInterface
    ):Response {

        $entityManagerInterface->remove($users);
        $entityManagerInterface->flush();
        return  $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
