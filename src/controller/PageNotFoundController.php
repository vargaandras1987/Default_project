<?php


namespace controller;

class PageNotFoundController
{
  public function __construct()
  {
      header("Location:..\\..\\public\\html\\PageNotFound.html");
  }
}

