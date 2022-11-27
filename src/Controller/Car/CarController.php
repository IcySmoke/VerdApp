<?php

namespace App\Controller\Car;

use App\Entity\Car\Car;
use App\Form\Car\CarType;
use App\Repository\Car\CarRepository;
use App\Service\FileUploader;
use App\Service\ImageOptimizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car_index', methods: ['GET'])]
    public function index(CarRepository $carRepository): Response
    {
        return $this->render('car/car/index.html.twig', [
            'cars' => $carRepository->findAll(),
        ]);
    }

    #[Route('/car/new', name: 'app_car_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader, ImageOptimizer $imageOptimizer): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();

            if ($image) {
                $image = $fileUploader->upload($image, $this->getParameter('car_image_directory'));
                $imageOptimizer->resize('uploads/cars/'.$image, 480, 270);
                $car->setImage($image);
            }

            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/car/new.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/car/{id}', name: 'app_car_show', methods: ['GET'])]
    public function show(Car $car): Response
    {
        return $this->render('car/car/show.html.twig', [
            'car' => $car,
        ]);
    }

    #[Route('/car/{id}/edit', name: 'app_car_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Car $car, EntityManagerInterface $entityManager, FileUploader $fileUploader, ImageOptimizer $imageOptimizer): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();

            if ($image) {
                $oldImage = $this->getParameter('car_image_directory') . '/' . $car->getImage();
                $newImage = $fileUploader->upload($image, $this->getParameter('car_image_directory'));
                $imageOptimizer->resize('uploads/cars/'.$newImage, 480, 270);
                $car->setImage($newImage);
                unlink($oldImage);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/car/{id}/tires', name: 'app_car_edit_tires', methods: ['GET', 'POST'])]
    public function manageTires(Request $request, Car $car): Response
    {
        return $this->render('car/car/edit_tire.html.twig', [
            'car' => $car
        ]);
    }

    #[Route('/car/{id}', name: 'app_car_delete', methods: ['POST'])]
    public function delete(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
    }
}
