<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
// use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\SerializerInterface;


#[Rest\Route("/api")]
#[IsGranted("IS_AUTHENTICATED_FULLY")]
class PostController extends AbstractController
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

    #[Rest\Post("/posts", name: "createPost")]
    #[IsGranted("ROLE_USER")]
    public function createAction(Request $request): JsonResponse
    {
        $input = (object) json_decode($request->getContent(), true);

        $post = new Post();
        $post->setTitle($input->title);
        $post->setDescription($input->description);

        $this->em->persist($post);
        $this->em->flush();
        $data = $this->serializer->serialize($post, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_CREATED, [], true);
    }

    #[Rest\Get("/posts", name: "findAllPost")]
    public function findAllAction(): JsonResponse
    {
        $post = $this->em->getRepository(Post::class)->findBy([], ['id' => 'DESC']);
        $data = $this->serializer->serialize($post, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
