<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BlogController extends AbstractController
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger=$slugger;
    }

    #[Route('/', name: 'app_blog')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        
        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/home', name: 'my_articles')]
    public function myArticles(ArticleRepository $articleRepository): Response
    {       
        $articles = $articleRepository->findby([], ['id'=>'DESC']);
        
        return $this->render('blog/home.html.twig', [
            'articles' => $articles,
        ]);
    }

    //Cette méthode créé un nouveau article dont les différentes informations sont passées de l'utilisateur à l'application par l'intermédiaire d'un formulaire
    #[Route('article/create', name: 'article_create')]
    public function createArticle(Request $request, ManagerRegistry $doctrine): Response
    {
        //On récupère l'Entity Manager pour envoyer un article vers notre base de données
        //On crée une instance d'Entity article que nous allons lier à notre formulaire
        $article = new Article;
        $articleForm = $this->createForm(ArticleType::class, $article);
        //Nous appliquons les valeurs de notre objet Request à notre article
        $articleForm->handleRequest($request);
        //Si notre formulaire est rempli et valide, nous portons le article vers notre Base de données

        if($articleForm->isSubmitted() && $articleForm->isValid()){     
            
            /** @var UploadedFile $uploadFile */
            $uploadFile = $articleForm->get('upload')->getData();

            if ($uploadFile) {
                $article->setUpload($this->upload($uploadFile));
            }

            $entityManager = $doctrine->getManager();
            $entityManager->persist($article); //Etant donné que le article est lié au formulaire, il est automatiquement rempli avec les valeurs du formulaire
            $entityManager->flush();

            // flashbag (affiché dans base.html.twig)
            $this->addflash('success','L\'article a bien été créé.');

            //Nous retournons à l'accueil
            return $this->redirectToRoute('my_articles');
        }

        //Nous transmettons notre formulaire de article à Twig
        return $this->render('blog/dataform.html.twig', [
            'formName' => 'Create content',
            'dataForm' => $articleForm->createView(), //createView() prépare l'affichage du form
        ]);
    }

    //Cette méthode permet de modifier grâce à un formulaire le contenu d'un article identifié via son ID transmis via notre URL
    #[Route('/article/update/{id}', name: 'article_update')]
    public function updateArticle(Article $article, Request $request, ManagerRegistry $doctrine, Filesystem $filesystem): Response
    {
        $oldImage = $article->getUpload();
        
        $articleForm = $this->createForm(ArticleType::class, $article);
        //Nous appliquons les valeurs de notre objet Request à notre article
        $articleForm->handleRequest($request);
        //Si notre formulaire est rempli et valide, nous portons le article vers notre Base de données
        if($articleForm->isSubmitted() && $articleForm->isValid()){     
            
            /** @var UploadedFile $uploadFile */
            $uploadFile = $articleForm->get('upload')->getData();

            if ($uploadFile) {
                $filesystem->remove($this->getParameter('upload_directory').'/'.$oldImage);
                $article->setUpload($this->upload($uploadFile));
            }
            
            $entityManager = $doctrine->getManager();
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

    private function upload(UploadedFile $uploadedFile):string
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

        // Move the file to the directory where uploads are stored
        try {
            $uploadedFile->move(
                $this->getParameter('upload_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            throw new RuntimeException($e->getMessage());
        }

        return $newFilename;
    }

    //Cette méthode permet de supprimer un article dont l'ID nous est transmis via l'URL
    #[Route('/article/delete/{id}', name: 'article_delete')]
    public function deleteArticle(Article $article, EntityManagerInterface $entityManager, Filesystem $filesystem): Response
    {
        //Si notre article est récupéré, nous procédons à sa suppression avant de revenir sur notre page d'accueil
        $filesystem->remove($this->getParameter('upload_directory').'/'.$article->getUpload());
        $entityManager->remove($article);
        $entityManager->flush();

        // flashbag (affiché dans base.html.twig)
        $this->addflash('success','L\'article a bien été supprimé.');

        return $this->redirectToRoute('article_modify');
    }

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/article/admin', name: 'article_modify')]
    public function ArticleAdmin(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        
        //On transmet l'article à modify.html.twig
        return $this->render('admin/modify.html.twig', [
            'articles' => $articles,
        ]);
    }

}
