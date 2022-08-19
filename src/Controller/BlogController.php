<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class BlogController extends AbstractController
{
    #[Route('/', name: 'app_blog')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $articleRepository = $entityManager->getRepository(Article::class);
        $categories = $articleRepository->findAll();
        $articles = $articleRepository->findAll();
        $articles = $articleRepository->findBy([], ["id" => "DESC"]);
        
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }

    #[Route('/home', name: 'my_articles')]
    public function myArticles(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $articleRepository = $entityManager->getRepository(Article::class);
        $categories = $articleRepository->findAll();
        $articles = $articleRepository->findAll();
        $articles = $articleRepository->findBy([], ["id" => "DESC"]);
        
        return $this->render('blog/home.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }

    //Cette méthode créé un nouveau article dont les différentes informations sont passées de l'utilisateur à l'application par l'intermédiaire d'un formulaire
    #[Route('article/create', name: 'article_create')]
    public function createArticle(Request $request, ManagerRegistry $doctrine,  SluggerInterface $slugger): Response
    {
        //On récupère l'Entity Manager pour envoyer un article vers notre base de données
        $entityManager = $doctrine->getManager();
        //On crée une instance d'Entity article que nous allons lier à notre formulaire
        $article = new Article;
        $article->clearFields(); //On vide les champs de notre article
        $articleForm = $this->createForm(ArticleType::class, $article);
        //Nous appliquons les valeurs de notre objet Request à notre article
        $articleForm->handleRequest($request);
        //Si notre formulaire est rempli et valide, nous portons le article vers notre Base de données

        if($articleForm->isSubmitted() && $articleForm->isValid()){     
            
            /** @var UploadedFile $uploadFile */
            $uploadFile = $articleForm->get('upload')->getData();

            // this condition is needed because the 'upload' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($uploadFile) {
                $originalFilename = pathinfo($uploadFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadFile->guessExtension();

                // Move the file to the directory where uploads are stored
                try {
                    $uploadFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'uploadFilename' property to store the PDF file name
                // instead of its contents
                $article->setUpload($newFilename);
            }

            $entityManager->persist($article); //Etant donné que le article est lié au formulaire, il est automatiquement rempli avec les valeurs du formulaire
            $entityManager->flush();

            // flashbag (affiché dans base.html.twig)
            $this->addflash('success','L\'article a bien été créé.');

            //Nous retournons à l'accueil
            return $this->redirectToRoute('my_articles');
        }

        //Nous transmettons notre formulaire de article à Twig
        return $this->render('blog/dataform.html.twig', [
            'formName' => 'Créer un élément',
            'dataForm' => $articleForm->createView(), //createView() prépare l'affichage du form
        ]);
    }

    //Cette méthode permet de modifier grâce à un formulaire le contenu d'un article identifié via son ID transmis via notre URL
    #[Route('/article/update/{articleId}', name: 'article_update')]
    public function updateArticle(int $articleId, Request $request, ManagerRegistry $doctrine,  SluggerInterface $slugger): Response
    {
        //Afin de récupérer l'article désiré, nous avons besoin de l'Entity Manager et du Repository de l'article
        $entityManager = $doctrine->getManager();
        $articleRepository = $entityManager->getRepository(Article::class);
        $article = $articleRepository->find($articleId);
        //Si l'article n'existe pas, nous retournons à l'index
        if(!$article){
            return $this->redirectToRoute('article_modify');
        }

        $articleForm = $this->createForm(ArticleType::class, $article);
        //Nous appliquons les valeurs de notre objet Request à notre article
        $articleForm->handleRequest($request);
        //Si notre formulaire est rempli et valide, nous portons le article vers notre Base de données
        if($articleForm->isSubmitted() && $articleForm->isValid()){     
            
            /** @var UploadedFile $uploadFile */
            $uploadFile = $articleForm->get('upload')->getData();

            // this condition is needed because the 'upload' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($uploadFile) {
                $originalFilename = pathinfo($uploadFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadFile->guessExtension();

                // Move the file to the directory where uploads are stored
                try {
                    $uploadFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'uploadFilename' property to store the PDF file name
                // instead of its contents
                $article->setUpload($newFilename);
            }
            
            $entityManager->persist($article); //Etant donné que l'article est lié au formulaire, il est automatiquement rempli avec les valeurs du formulaire
            $entityManager->flush();

            // flashbag (affiché dans base.html.twig)
            $this->addflash('success','L\'article a bien été modifié.');

            //Nous retournons à l'accueil
            return $this->redirectToRoute('article_modify');
        }

        //Nous transmettons notre formulaire de article à Twig
        return $this->render('blog/dataform.html.twig', [
            'formName' => 'Modification de l\'article',
            'dataForm' => $articleForm->createView(), //createView() prépare l'affichage du form
        ]);
    }

    //Cette méthode permet de supprimer un article dont l'ID nous est transmis via l'URL
    #[Route('/article/delete/{articleId}', name: 'article_delete')]
    public function deleteArticle(ManagerRegistry $doctrine, int $articleId): Response
    {
        //Afin de récupérer l'Article désiré, nous avons besoin de l'Entity Manager et du Repository de Article
        $entityManager = $doctrine->getManager();
        $articleRepository = $entityManager->getRepository(Article::class);
        //Nous utilisons la méthode find() du Repository, laquelle permet de récupérer un élément de la base de données en utilisant l'ID, passé en paramètre. Si aucun élément ne correspond à l'ID indiqué, la valeur renvoyée sera null
        $article = $articleRepository->find($articleId);
        //Si l'article n'existe pas, nous retournons à l'index
        if(!$article){
            return $this->redirectToRoute('my_articles');
        }
        //Si notre article est récupéré, nous procédons à sa suppression avant de revenir sur notre page d'accueil
        $entityManager->remove($article);
        $entityManager->flush();

        // flashbag (affiché dans base.html.twig)
        $this->addflash('success','L\'article a bien été supprimé.');

        return $this->redirectToRoute('article_modify');
    }

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/article/admin', name: 'article_modify')]
    public function ArticleAdmin(ManagerRegistry $doctrine): Response
    {
        //Afin de mener une recherche dans notre BDD, nous avons besoin de l'Entity Manager ainsi que du Repository de l'article
        $entityManager = $doctrine->getManager();
        $articleRepository = $entityManager->getRepository(article::class);
        //Nous recherchons l'article via son ID en utilisant la méthode find() du Repository.
        $articles = $articleRepository->findAll();
        $articles = $articleRepository->findBy([], ["id" => "DESC"]);
        
        //On transmet l'article à modify.html.twig
        return $this->render('admin/modify.html.twig', [
            'articles' => $articles,
        ]);
    }

}
