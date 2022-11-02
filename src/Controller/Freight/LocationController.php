<?php

namespace App\Controller\Freight;

use App\Entity\Freight\Location;
use App\Form\Freight\LocationType;
use App\Repository\Freight\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/location')]
class LocationController extends AbstractController
{
    #[Route('/', name: 'app_freight_location_index', methods: ['GET'])]
    public function index(LocationRepository $locationRepository): Response
    {
        return $this->render('freight/location/index.html.twig', [
            'locations' => $locationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_freight_location_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LocationRepository $locationRepository): Response
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->get('name')->getData()){
                $companyName = $form->get('companyName')->getData();
                $city = $form->get('city')->getData();
                $location->setName($companyName ? $companyName . ' ' . $city : $city . ' ' . $form->get('address')->getData());
            }

            $locationRepository->add($location, true);

            return $this->redirectToRoute('app_freight_location_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('freight/location/new.html.twig', [
            'location' => $location,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_freight_location_show', methods: ['GET'])]
    public function show(Location $location): Response
    {
        return $this->render('freight/location/show.html.twig', [
            'location' => $location,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_freight_location_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Location $location, LocationRepository $locationRepository): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $locationRepository->add($location, true);

            return $this->redirectToRoute('app_freight_location_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('freight/location/edit.html.twig', [
            'location' => $location,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_freight_location_delete', methods: ['POST'])]
    public function delete(Request $request, Location $location, LocationRepository $locationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$location->getId(), $request->request->get('_token'))) {
            $locationRepository->remove($location, true);
        }

        return $this->redirectToRoute('app_freight_location_index', [], Response::HTTP_SEE_OTHER);
    }
}
