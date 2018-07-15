<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class BlogController extends Controller
{
    /**
     * @Route("/blog", name="articles")
     */
    public function index(ArticleRepository $repo)
    {
       
        $articles=$repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles'=> $articles
        ]);
    }
     /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    /**
     * @Route("/blog/new", name="new_article")
     * @Route("/blog/{id}/edit", name="edit_article")
     */
     public function form(Article $article=null,Request $request, ObjectManager $manager)
    {
       if(!$article )
           $article=new Article();
     /*  $form=$this->createFormBuilder($article)
               ->add('title',TextType::class)
               ->add('content',TextareaType::class)
               ->add('image',TextType::class)
           
               ->getForm();*/
       $form=$this->createForm(ArticleType::class,$article);
      $form->handleRequest($request);
      dump($article);
     
      if($form->isSubmitted()&& $form->isValid()){
          if(!$article->getId())
          $article->setCreatedAt(new DateTime());
          $manager->persist($article);
          $manager->flush();
          return $this->redirectToRoute('show_article',['id'=>$article->getId()]);
      }
        return $this->render('blog/create.html.twig', [
            'controller_name' => 'BlogController',
            'formarticle'=>$form->createView(),
            'editbool'=>$article->getId()==null,
        ]);
    }
     /**
     * @Route("/blog/{id}", name="show_article")
     */
    public function show($id,Request $request, ObjectManager $manager)
    {
        $repo=$this->getDoctrine()->getRepository(Article::class);
        $article=$repo->findOneById($id);
        dump($article);
        $comment=new Comment();
        $form=$this->createForm(CommentType::class,$comment);
      $form->handleRequest($request); 
      if($form->isSubmitted()&& $form->isValid()){
         
          $comment->setCreatedAt(new \DateTime());
          $comment->setArticle($article);
          $manager->persist($comment);
          $manager->flush();
          return $this->redirectToRoute('show_article',['id'=>$article->getId()]);
      }
      
        return $this->render('blog/show.html.twig', [
            'controller_name' => 'BlogController',
            'formcomment'=>$form->createView(),
            'article'=>$article
        ]);
    }
   
}
