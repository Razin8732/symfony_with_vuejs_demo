<?php

namespace App\Controller;

use App\Entity\Student;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

#[Rest\Route("/api")]
#[IsGranted("IS_AUTHENTICATED_FULLY")]
class StudentController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    #[Rest\Get("/students", name: "findAllStudent")]
    public function findAllAction(): JsonResponse
    {
        $students = $this->em->getRepository(Student::class)->findBy([], ['id' => 'ASC']);
        $data = $this->serializer->serialize($students, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Rest\Post("/students/create", name: "createStudent")]
    public function createStudent(Request $request): JsonResponse
    {
        $input  = $request->request->all();
        $student = new Student();
        $student->setName($input['name']);
        $student->setDob(new DateTime($input['dob']));
        $student->setGender($input['gender']);
        $student->setCountry($input['country']);
        $student->setCreatedAt(new DateTime());
        $this->em->persist($student);
        $this->em->flush();
        $data = $this->serializer->serialize($student, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_CREATED, [], true);
    }

    #[Rest\Get("/students/{id}", name: "getStudent")]
    public function getStudent($id): JsonResponse
    {
        $students = $this->em->getRepository(Student::class)->findOneBy(['id' => $id]);
        $data = $this->serializer->serialize($students, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Rest\Post("/students/{id}", name: "updateStudent")]
    public function updateStudent($id, Request $request): JsonResponse
    {
        $input  = $request->request->all();
        $student = $this->em->getRepository(Student::class)->findOneBy(['id' => $id]);
        $student->setName($input['name']);
        $student->setDob(new DateTime($input['dob']));
        $student->setGender($input['gender']);
        $student->setCountry($input['country']);
        $this->em->persist($student);
        $this->em->flush();

        $data = $this->serializer->serialize($student, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Rest\Delete("/students/{id}", name: "deleteStudent")]
    public function deleteStudent($id, Request $request): JsonResponse
    {
        $input  = $request->request->all();
        $student = $this->em->getRepository(Student::class)->findOneBy(['id' => $id]);
        $this->em->remove($student);
        $this->em->flush();
        $data = $this->serializer->serialize(['response' => 'success'], JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
