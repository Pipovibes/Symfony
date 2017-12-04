<?php
/**
 * Created by PhpStorm.
 * User: bp
 * Date: 7/11/2017
 * Time: 15:10
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function homepageAction()
    {
        return $this->render('main/homepage.html.twig');
    }
}