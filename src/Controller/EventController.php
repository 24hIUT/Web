<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
    /**
     * @Route("/event/{name}", name="event")
     */
    public function index($name)
    {
        return $this->render('event/event.html.twig', [
        ]);
    }
}
