<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArticlesRepository;
use App\Repository\VoitureRepository;
use App\Entity\Articles;
use phpDocumentor\Reflection\Types\Null_;
use App\Entity\Voiture;

class SearchController extends AbstractController
{
  /**
     * @Route("/search", name="search")
     */
  public function search(ArticlesRepository $articlesRepository, VoitureRepository $voitureRepository, Request $request)
  {
    $search = explode(" ", $request->get('_search'));

    $tab = Null;
    $allarticles = $articlesRepository->findAll();
    $allvoitures = $voitureRepository->findAll();
    $size =  count($search);
    foreach($allarticles as $Article)
    {
      $introduction = $Article->getIntroduction()." ".$Article->getParagraphe1()." ".$Article->getParagraphe2()." ".$Article->getParagraphe3()." ".$Article->getParagraphe4()." ".$Article->getParagraphe5()." ".$Article->getParagraphe6()." ".$Article->getParagraphe7()." ".$Article->getParagraphe8()." ".$Article->getParagraphe9()." ".$Article->getParagraphe10();
      
      $introduction = explode(" ",$introduction);
      $i=0;
      $sizeintroduction =  count($introduction);
      while($i<$size)
      {
       $j=0;
        while($j<$sizeintroduction)
        {
          if(strtolower($introduction[$j]) === strtolower($search[$i])) //compare mon intro au champs recherche
          {
          $tab [] = $Article;
          $j++;
          }
          else
          {
            $j++;
          }
        }
        $i++;
    }
    }

    foreach ($allvoitures as $Voiture) {
      $i = 0;
      while ($i < $size) {
        if (strtolower($Voiture->getMarque()) === strtolower($search[$i]))
        {
          $tab[] = $Voiture;
          $i++;
        } elseif (strtolower($Voiture->getModele()) === strtolower($search[$i]))
        {
          $tab[] = $Voiture;
          $i++;
        }
        elseif(strval($Voiture->getAnnee()) === strtolower($search[$i]))
        {
          $tab[] = $Voiture;
          $i++;
        }
        elseif (strtolower($Voiture->getCarburant()) === strtolower($search[$i]))
         {
          $tab[] = $Voiture;
          $i++;
         }
        elseif (strtolower($Voiture->getType()) === strtolower($search[$i]))
         {
          $tab[] = $Voiture;
          $i++;
         }
         elseif (strtolower($Voiture->getCarrosserie()) === strtolower($search[$i]))
         {
           $tab[] = $Voiture;
          $i++;
         }
         else
         {
          $i++;
        }
      }
    }
    dump($tab);
    return $this->render('search/index.html.twig', [
      'tab' => $tab
      ]);
  }
}
