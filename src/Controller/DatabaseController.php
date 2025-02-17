<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Repository\FactionRepository;
use App\Repository\ShipRepository;
use App\Repository\PilotRepository;
use App\Repository\ActionRepository;
use App\Repository\StatRepository;

class DatabaseController extends AbstractController
{
    private $factionRepository;
    private $shipRepository;
    private $pilotRepository;
    private $actionRepository;
    private $statRepository;

    // Dependency injection via the constructor
    public function __construct(FactionRepository $factionRepository, ShipRepository $shipRepository,
        PilotRepository $pilotRepository, ActionRepository $actionRepository, StatRepository $statRepository)
    {
        $this->factionRepository = $factionRepository;
        $this->shipRepository = $shipRepository;
        $this->pilotRepository = $pilotRepository;
        $this->actionRepository = $actionRepository;
        $this->statRepository = $statRepository;
    }

    #[Route("/database", name: "app_database")]
    public function database(SessionInterface $session)
    {
        // Check if session data exists
        if (!$session->has('factions')) {
            // Fetch data from repositories
            $factionsArray = $this->factionRepository->findAllAsArray();
            $shipsArray = $this->shipRepository->findAllAsArray();
            $pilotsArray = $this->pilotRepository->findAllAsArray();
            $actionsArray = $this->actionRepository->findAllAsArray();
            $statsArray = $this->statRepository->findAllAsArray();

            // Store data in session
            $session->set('factions', $factionsArray);
            $session->set('ships', $shipsArray);
            $session->set('pilots', $pilotsArray);
            $session->set('actions', $actionsArray);
            $session->set('stats', $statsArray);
        } else {
            // Retrieve data from session
            $factionsArray = $session->get('factions');
            $shipsArray = $session->get('ships');
            $pilotsArray = $session->get('pilots');
            $actionsArray = $session->get('actions');
            $statsArray = $session->get('stats');
        }
        
        // Sort pilots by initiative in descending order
        usort($pilotsArray, function ($a, $b) {
            return $b['initiative'] <=> $a['initiative'];
        });

        // Pass data to Twig template
        return $this->render('database/index.html.twig', [
            'factions' => $factionsArray,
            'ships' => $shipsArray,
            'pilots' => $pilotsArray,
            'actions' => $actionsArray,
            'stats' => $statsArray
        ]);
    }

    #[Route('/back', name: 'go_back')]
    public function goBack(Request $request): RedirectResponse
    {
        $referer = $request->headers->get('referer');

        if ($referer) {
            return $this->redirect($referer);
        }

        // If no referer, redirect to a default page
        return $this->redirectToRoute('index');
    }
}
