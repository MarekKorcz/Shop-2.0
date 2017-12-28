<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        if (is_object($user)) {
            return $this->render('default/homepage.html.twig', [
                'user' => $user->getName()
            ]);
        } else {
            return $this->render('default/homepage.html.twig');
        }
    }
    
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction()
    {
        return $this->render('default/contact.html.twig');
    }
    
    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
        return $this->render('default/about.html.twig');
    }
}
