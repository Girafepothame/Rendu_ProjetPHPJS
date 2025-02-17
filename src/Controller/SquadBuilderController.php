<?php

namespace App\Controller;

use App\Entity\Faction;
use App\Entity\Squadron;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use App\Repository\FactionRepository;
use App\Repository\ShipRepository;
use App\Repository\PilotRepository;
use App\Repository\ActionRepository;
use App\Repository\StatRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[IsGranted('ROLE_USER')] // Restrict access to authenticated users
final class SquadBuilderController extends AbstractController
{
    private FactionRepository $factionRepository;
    private ShipRepository $shipRepository;
    private PilotRepository $pilotRepository;
    private ActionRepository $actionRepository;
    private StatRepository $statRepository;

    // Dependency injection via the constructor
    public function __construct(
        FactionRepository $factionRepository,
        ShipRepository $shipRepository,
        PilotRepository $pilotRepository,
        ActionRepository $actionRepository,
        StatRepository $statRepository
    ) {
        $this->factionRepository = $factionRepository;
        $this->shipRepository = $shipRepository;
        $this->pilotRepository = $pilotRepository;
        $this->actionRepository = $actionRepository;
        $this->statRepository = $statRepository;
    }

    #[Route("/squadBuilder", name: "app_squad_builder")]
    public function squadBuilder(EntityManagerInterface $entityManager): Response
    {
        // Get the currently authenticated user
        $user = $this->getUser();

        // Redirect to login if the user is not authenticated
        if (!$user) {
            $this->addFlash('info', 'You must be logged in to access the Squad Builder.');
            return $this->redirectToRoute('app_auth'); // Redirect to login
        }

        // Fetch squadrons associated with the authenticated user
        $squadrons = $entityManager->getRepository(Squadron::class)->findBy(['user' => $user]);

        // Render the squad builder page with the necessary data
        return $this->render('squad_builder/index.html.twig', [
            'factions' => $this->factionRepository->findAllAsArray(),
            'ships' => $this->shipRepository->findAllAsArray(),
            'pilots' => $this->pilotRepository->findAllAsArray(),
            'actions' => $this->actionRepository->findAllAsArray(),
            'stats' => $this->statRepository->findAllAsArray(),
            'squadrons' => $squadrons,
        ]);
    }

    #[Route('/squadron/new', name: 'app_squadron_new', methods: ['POST'])]
    public function newSquadron(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Get the currently authenticated user
        $user = $this->getUser();

        // Redirect to login if the user is not authenticated
        if (!$user) {
            $this->addFlash('info', 'You must be logged in to access the Squad Builder.');
            return $this->redirectToRoute('app_auth'); // Redirect to login
        }

        // Get faction ID and squadron name from the request
        $factionId = $request->request->get('faction');
        $name = $request->request->get('name');

        // Validate input data
        if (empty($factionId) || empty($name)) {
            $this->addFlash('danger', 'Invalid data.');
            return $this->redirectToRoute('app_squad_builder');
        }

        // Fetch the faction entity by ID
        $faction = $entityManager->getRepository(Faction::class)->find($factionId);
        if (!$faction) {
            $this->addFlash('danger', 'Invalid faction.');
            return $this->redirectToRoute('app_squad_builder');
        }

        // Create a new squadron entity and set its properties
        $squadron = new Squadron();
        $squadron->setName($name);
        $squadron->setFaction($faction);
        $squadron->setUser($user);

        // Persist the new squadron entity to the database
        $entityManager->persist($squadron);
        $entityManager->flush();

        $this->addFlash('success', 'Successfully created squadron.');

        return $this->redirectToRoute('app_squad_builder');
    }

    #[Route('/squadron/{id}', name: 'app_squadron_delete', methods: ['DELETE'])]
    public function delete(Squadron $squadron, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        // Remove the squadron entity from the database
        $entityManager->remove($squadron);
        $entityManager->flush();
    
        // Add a flash message via the request session
        $request->getSession()->getFlashBag()->add('success', 'Squadron successfully deleted.');
    
        return new JsonResponse(['message' => 'Squadron deleted'], Response::HTTP_OK);
    }
}
