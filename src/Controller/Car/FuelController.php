<?php

namespace App\Controller\Car;

use App\Entity\Car\Fuel;
use App\Form\Car\FuelType;
use App\Repository\Car\FuelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/fuel')]
class FuelController extends AbstractController
{
    #[Route('/', name: 'app_car_fuel_index', methods: ['GET'])]
    public function index(FuelRepository $fuelRepository): Response
    {
        return $this->render('car/fuel/index.html.twig', [
            'fuels' => $fuelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_car_fuel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fuel = new Fuel();
        $form = $this->createForm(FuelType::class, $fuel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fuel);
            $entityManager->flush();

            return $this->redirectToRoute('app_car_fuel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/fuel/new.html.twig', [
            'fuel' => $fuel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_car_fuel_show', methods: ['GET'])]
    public function show(Fuel $fuel): Response
    {
        return $this->render('car/fuel/show.html.twig', [
            'fuel' => $fuel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_car_fuel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fuel $fuel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FuelType::class, $fuel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_car_fuel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/fuel/edit.html.twig', [
            'fuel' => $fuel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_car_fuel_delete', methods: ['POST'])]
    public function delete(Request $request, Fuel $fuel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fuel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fuel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_car_fuel_index', [], Response::HTTP_SEE_OTHER);
    }
}
