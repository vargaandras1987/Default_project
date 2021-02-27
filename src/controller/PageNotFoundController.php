<?php


namespace controller;

use core\twig\TwigConfigure;

class PageNotFoundController
{
  public static function getPageNotFoundPath()
  {
      echo TwigConfigure::getTwigEnviroment()->render('pagenotfound.twig');



     // header("Location:..\\..\\public\\html\\PageNotFound.html");

  }
}

