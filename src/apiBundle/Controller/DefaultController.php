<?php

namespace apiBundle\Controller;

use apiBundle\Entity\Categorieprod;
use apiBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getallcatAction()
    {
        $tasks=$this->getDoctrine()->getManager()
            ->getRepository(Categorieprod::class)
            ->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    /**
     * @return JsonResponse
     */
    public function getallprodAction()
    {
        $tasks=$this->getDoctrine()->getManager()
            ->getRepository(Produit::class)
            ->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    /**
     * @param $idcp
     * @return JsonResponse
     */
    public function findcatAction($idcp){
        $tasks=$this->getDoctrine()->getManager()
            ->getRepository(Categorieprod::class)
            ->find($idcp);
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    /**
     * @param $idpr
     * @return JsonResponse
     */
    public function findprodAction($idpr){
        $produit = new Produit();
        $tasks=$this->getDoctrine()->getManager()
            ->getRepository(Produit::class)
            ->findByidpr($idpr);
        $task=$this->getDoctrine()->getManager()
            ->getRepository(Produit::class)
            ->find($idpr);
        $produit = $task ;
        $produit = $this->incrementviews($produit);
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function newcatAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $task=new Categorieprod();
        $task->setNomcp($request->get('nomcp'));
        $em->persist($task);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($task);
        return new JsonResponse($formatted);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function newprodAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $task=new Produit();
        $task->setNomp($request->get('nomp'));
        $task->setPrix($request->get('prix'));
        $task->setDescription($request->get('description'));
        $task->setImagep($request->get('imagep'));
        $task->setEtatpr(0);
        $task->setDateExp($request->get('dateExp'));
        $task->setViews(0);
        $task->setIduser(2);
        $task->setIdcp($request->get('idcp'));
        $em->persist($task);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($task);
        return new JsonResponse($formatted);
    }
    /**
     * @param $idcp
     * @return JsonResponse
     */
    public function deletecatAction($idcp)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository(Categorieprod::class)->find($idcp);
        $em->remove($cat);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($cat);
        return new JsonResponse($formatted);
    }
    /**
     * @param $idpr
     * @return JsonResponse
     */
    public function deleteprodAction($idpr)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository(Produit::class)->find($idpr);
        $em->remove($cat);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($cat);
        return new JsonResponse($formatted);
    }

    public function getmyprodAction($iduser){
        $tasks=$this->getDoctrine()->getManager()
            ->getRepository(Produit::class)
            ->findByiduser($iduser);
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
  public function incrementviews(Produit $produit ){
        $produit->addView();
        $em=$this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();
        return $produit;
  }

    /**
     * @param Request $request
     * @param $idpr
     * @return JsonResponse
     */
    public function updateprodAction(Request $request , $idpr){
        $em=$this->getDoctrine()->getManager();
        $task = $em->getRepository(Produit::class)->find($idpr);
        $task->setNomp($request->get('nomp'));
        $task->setPrix($request->get('prix'));
        $task->setDescription($request->get('description'));
        $task->setViews(0);
        $em->persist($task);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($task);
        return new JsonResponse($formatted);
    }


    
}
