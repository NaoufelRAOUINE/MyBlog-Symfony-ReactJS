<?php


namespace App\Controller;


use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    
    /**
     * @Route("/{page}", name="blog_list", defaults={"page":5}, requirements={"page"="\d+"}, methods={"GET"})
     * @param int $page
     * @param Request $request
     * @return JsonResponse
     */
    public function list($page=1, Request $request)
    {
        $limit = $request->get('limit', 10);
        $repository = $this->getDoctrine()->getRepository(BlogPost::class);
        $items = $repository->findAll();

        return new JsonResponse([
            'page' => $page,
            'limit' => $limit,
            'data' => array_map(function (BlogPost $item){
                return $this->generateUrl('blog_by_id',['id' => $item->getId()]);
            },$items)
        ]);
    }

    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"}, methods={"GET"})
     * @paramConverter("post", class = "App:BlogPost")
     * @return JsonResponse
     */
    public function post($post){
        // find($id)
        return $this->json($post);
    }

    /**
     * @Route("/post/{slug}", name="blog_by_slug", methods={"GET"})
     * @paramConverter("post", class = "App:BlogPost", options = {"mapping": {"slug" : "slug"}})
     * @return JsonResponse
     */
    public function postBySlug($post){
        // findOneBy(["slug"] => $slug)
        return $this->json($post);
    }

    /**
     * @Route("/add", name="blog_add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request)
    {
        /** @var Serializer $serializer*/
        $serializer = $this->get('serializer');
        $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');
        $em = $this->getDoctrine()->getManager();
        /** @var TYPE_NAME $blogPost */
        $em->persist($blogPost);
        $em->flush();

        return $this->json($blogPost);
    }

    /**
     * @Route("/post/{id}", name="blog_delete", methods={"DELETE"})
     * @param BlogPost $post
     * @return void
     */
    public function delete(BlogPost $post)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var TYPE_NAME $blogPost */
        $em->remove($post);
        $em->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}