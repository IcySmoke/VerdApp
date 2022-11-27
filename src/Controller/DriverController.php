<?php

namespace App\Controller;

use App\Entity\Driver;
use App\Form\DriverType;
use App\Repository\DriverRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DriverController extends AbstractController
{
    #[Route('/driver', name: 'app_driver_index', methods: ['GET'])]
    public function index(DriverRepository $driverRepository): Response
    {
        return $this->render('driver/index.html.twig', [
            'drivers' => $driverRepository->findAll(),
        ]);
    }

    #[Route('/driver/new', name: 'app_driver_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DriverRepository $driverRepository, FileUploader $fileUploader): Response
    {
        $driver = new Driver();
        $form = $this->createForm(DriverType::class, $driver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();

            if ($image) {
                $driver->setImage($fileUploader->upload($image, $this->getParameter('driver_image_directory')));
            }

            $driverRepository->save($driver, true);

            return $this->redirectToRoute('app_driver_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('driver/new.html.twig', [
            'driver' => $driver,
            'form' => $form,
        ]);
    }

    #[Route('/driver/{id}', name: 'app_driver_show', methods: ['GET'])]
    public function show(Driver $driver): Response
    {
        return $this->render('driver/show.html.twig', [
            'driver' => $driver,
        ]);
    }

    #[Route('/driver/{id}/edit', name: 'app_driver_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Driver $driver, DriverRepository $driverRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(DriverType::class, $driver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();

            if ($image) {
                $oldImage = $this->getParameter('driver_image_directory') . '/' . $driver->getImage();
                $driver->setImage($fileUploader->upload($image, $this->getParameter('driver_image_directory')));

                if (!is_dir($oldImage)) {
                    unlink($oldImage);
                }
            }

            $driverRepository->save($driver, true);

            return $this->redirectToRoute('app_driver_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('driver/edit.html.twig', [
            'driver' => $driver,
            'form' => $form,
        ]);
    }

    #[Route('/driver/{id}', name: 'app_driver_delete', methods: ['POST'])]
    public function delete(Request $request, Driver $driver, DriverRepository $driverRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$driver->getId(), $request->request->get('_token'))) {
            $driverRepository->remove($driver, true);
        }

        return $this->redirectToRoute('app_driver_index', [], Response::HTTP_SEE_OTHER);
    }
}
