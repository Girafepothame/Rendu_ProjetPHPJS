<?php

namespace App\Controller;

use App\Repository\FactionRepository;
use App\Repository\ShipRepository;
use App\Repository\PilotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    private $factionRepository;
    private $shipRepository;
    private $pilotRepository;

    // Dependency injection via the constructor
    public function __construct(
        FactionRepository $factionRepository,
        ShipRepository $shipRepository,
        PilotRepository $pilotRepository
    ) {
        $this->factionRepository = $factionRepository;
        $this->shipRepository = $shipRepository;
        $this->pilotRepository = $pilotRepository;
    }

    #[Route("/load-data", name: "load_data", methods: ["GET"])]
    public function loadData(SessionInterface $session)
    {
        // Check if session data exists
        if (!$session->has('factions')) {
            // Fetch data from repositories
            $factions = $this->factionRepository->findAll();
            $ships = $this->shipRepository->findAll();
            $pilots = $this->pilotRepository->findAll();

            // Store data in session
            $session->set('factions', $factions);
            $session->set('ships', $ships);
            $session->set('pilots', $pilots);
        }

        // Redirect to the home page
        return $this->redirectToRoute('index');
    }
}
