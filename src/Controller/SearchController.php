<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArticlesRepository;
use App\Repository\VoitureRepository;
use phpDocumentor\Reflection\Types\Null_;

class SearchController extends AbstractController
{
  /**
  * @Route("/search", name="search")
  */
  public function search(ArticlesRepository $articlesRepository, VoitureRepository $voitureRepository, Request $request)
  {
    $tabsArticle = Null;
    $tabsVoiture = Null;

    $search = explode(" ", trim($request->get('_search')));
    
    if($request->get('_search') != null && $search[0] != "")
    {
      $allarticles = $articlesRepository->findAll();
      $allvoitures = $voitureRepository->findAll();

      $size =  count($search);

      foreach($allarticles as $Article)
      {
        $introduction = $Article->getTitre()." ".$Article->getIntroduction()." ".$Article->getParagraphe1()." ".$Article->getParagraphe2()." ".$Article->getParagraphe3()." ".$Article->getParagraphe4()." ".$Article->getParagraphe5()." ".$Article->getParagraphe6()." ".$Article->getParagraphe7()." ".$Article->getParagraphe8()." ".$Article->getParagraphe9()." ".$Article->getParagraphe10();
        
        $order = array("\n\r","\r\n","\n","\r", "\t","<",">","br","\\","/");
        $replace = ' ';

        $introduction = str_replace($order, $replace, $introduction);
        $introduction = str_replace($order, $replace, $introduction);
        $introduction = rtrim($introduction);
        
        $introduction = explode(" ",$introduction);
        $sizeintroduction =  count($introduction);

        $i=0;
        while($i<$size)
        {
          $j=0;
          while($j<$sizeintroduction)
          {
            if(strtolower($introduction[$j]) === strtolower($search[$i]))
            {
              $tabsArticle [] = $Article;
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

      foreach ($allvoitures as $Voiture)
      {
        $i = 0;
        while ($i < $size)
        {
          if (strtolower($Voiture->getMarque()) === strtolower($search[$i]))
          {
            $tabsVoiture[] = $Voiture;
            $i++;
          }
          elseif (strtolower($Voiture->getModele()) === strtolower($search[$i]))
          {
            $tabsVoiture[] = $Voiture;
            $i++;
          }
          elseif(strval($Voiture->getAnnee()) === strtolower($search[$i]))
          {
            $tabsVoiture[] = $Voiture;
            $i++;
          }
          elseif (strtolower($Voiture->getCarburant()) === strtolower($search[$i]))
          {
            $tabsVoiture[] = $Voiture;
            $i++;
          }
          elseif (strtolower($Voiture->getType()) === strtolower($search[$i]))
          {
            $tabsVoiture[] = $Voiture;
            $i++;
          }
          elseif (strtolower($Voiture->getCarrosserie()) === strtolower($search[$i]))
          {
            $tabsVoiture[] = $Voiture;
            $i++;
          }
          elseif (strtolower($Voiture->getCouleurCarrosserie()) === strtolower($search[$i]))
          {
            $tabsVoiture[] = $Voiture;
            $i++;
          }
          elseif (strtolower($Voiture->getCouleurInterieur()) === strtolower($search[$i]))
          {
            $tabsVoiture[] = $Voiture;
            $i++;
          }
          elseif (strtolower($Voiture->getOrigine()) === strtolower($search[$i]))
          {
            $tabsVoiture[] = $Voiture;
            $i++;
          }
          elseif (strtolower($Voiture->getBoiteDeVitesse()) === strtolower($search[$i]))
          {
            $tabsVoiture[] = $Voiture;
            $i++;
          }
          else
          {
            $i++;
          }
        }
      }
      if($tabsVoiture != null)
      {
        $tabsVoiture = array_unique($tabsVoiture, SORT_REGULAR);

        foreach ($tabsVoiture as $voiture) 
        {
            $idVoitures[] = $voiture->getId();
        }
        array_multisort($idVoitures, SORT_DESC, $tabsVoiture);
      }
      if($tabsArticle != null)
      {
        foreach ($tabsArticle as $article) 
        {
            $idArticles[] = $article->getId();
        }
        array_multisort($idArticles, SORT_DESC, $tabsArticle);
        $tabsArticle = array_unique($tabsArticle, SORT_REGULAR);
      }
      

    }
  return $this->render('search/index.html.twig', [
    'tabsArticle' => $tabsArticle,
    'tabsVoiture' => $tabsVoiture,
    'search' => $request->get('_search')
    ]);
  }
}