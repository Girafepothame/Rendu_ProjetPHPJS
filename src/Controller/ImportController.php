<?php

namespace App\Controller;

use App\Service\ImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;

// This controller handles the import of data from JSON files to MySQL using Doctrine
class ImportController extends AbstractController
{
    private $importService;

    // Dependency injection of the ImportService
    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    #[Route("/import-factions", name: "app_import_factions", methods: ["GET"])]
    public function importFactions(): JsonResponse
    {
        // Define the directory where the factions JSON file is located
        $directory = $this->getParameter('kernel.project_dir') . '/assets/data/factions';

        // Use Symfony Finder to locate the factions.json file in the directory
        $finder = new Finder();
        $finder->files()->name('factions.json')->in($directory);

        // Convert the Finder result to an array
        $files = iterator_to_array($finder);
        if (empty($files)) {
            // Return a JSON response if no factions file is found
            return new JsonResponse([
                'message' => 'No factions file found',
                'success' => 0,
                'failure' => 1
            ]);
        }

        // Get the first file found
        $file = reset($files);

        // Read the content of the JSON file
        $jsonContent = file_get_contents($file->getRealPath());
        // Decode the JSON content to an associative array
        $data = json_decode($jsonContent, true);

        if ($data) {
            // Import the factions data using the ImportService
            $result = $this->importService->importFactions($data);
            // Return a JSON response with the result of the import
            return new JsonResponse([
                'message' => $result,
                'success' => $result === "Data imported successfully!" ? 1 : 0,
                'failure' => $result === "Data imported successfully!" ? 0 : 1
            ]);
        } else {
            // Return a JSON response if there is an error in the JSON format
            return new JsonResponse([
                'message' => 'Error in factions file format',
                'success' => 0,
                'failure' => 1
            ]);
        }
    }

    #[Route("/import-pilots", name: "app_import_pilots", methods: ["GET"])]
    public function importPilots(): JsonResponse
    {
        // Define the directory where the pilots JSON files are located
        $directory = $this->getParameter('kernel.project_dir') . '/assets/data/pilots';
        // List of faction directories to search for pilot files
        $factionDir = ['galactic-empire', 'rebel-alliance', 'scum-and-villainy'];

        $finder = new Finder();

        foreach ($factionDir as $faction) {
            // Construct the path to the faction directory
            $factionPath = $directory . '/' . $faction;

            if (is_dir($factionPath)) {
                // Use Symfony Finder to locate all JSON files in the faction directory
                $finder->files()->in($factionPath)->name('*.json');

                foreach ($finder as $file) {
                    // Read the content of the JSON file
                    $jsonContent = file_get_contents($file->getRealPath());
                    // Decode the JSON content to an associative array
                    $data = json_decode($jsonContent, true);

                    if ($data) {
                        // Import the ships and pilots data using the ImportService
                        $this->importService->importShipsAndPilots($data);
                    } else {
                        // Return a JSON response if there is an error in the JSON format
                        return new JsonResponse(['error' => 'JSON decoding error in ' . $file->getFilename()]);
                    }
                }
            } else {
                // Return a JSON response if the faction directory is not found
                return new JsonResponse(['error' => 'Faction folder ' . $faction . ' not found.']);
            }
        }

        // Return a JSON response indicating the import process is completed
        return new JsonResponse(['message' => 'Pilot import completed successfully']);
    }
}
