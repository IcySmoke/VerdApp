<?php

namespace App\Controller\Freight;

use App\Entity\Freight\Freight;
use App\Form\Freight\FreightType;
use App\Repository\Freight\FreightRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FreightController extends AbstractController
{
    #[Route('/freight', name: 'app_freight_freight_index', methods: ['GET'])]
    public function index(FreightRepository $freightRepository): Response
    {
        return $this->render('freight/freight/index.html.twig', [
            'freights' => $freightRepository->findAll(),
        ]);
    }

    #[Route('/freight/new', name: 'app_freight_freight_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FreightRepository $freightRepository): Response
    {
        $freight = new Freight();
        $form = $this->createForm(FreightType::class, $freight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $freight->setDistance(random_int(10, 1000));
            $freight->setStatus(0);
            $freightRepository->add($freight, true);

            return $this->redirectToRoute('app_freight_freight_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('freight/freight/new.html.twig', [
            'freight' => $freight,
            'form' => $form,
        ]);
    }

    #[Route('/freight/{id}', name: 'app_freight_freight_show', methods: ['GET'])]
    public function show(Freight $freight): Response
    {
        return $this->render('freight/freight/show.html.twig', [
            'freight' => $freight,
        ]);
    }

    #[Route('/freight/{id}/edit', name: 'app_freight_freight_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Freight $freight, FreightRepository $freightRepository): Response
    {
        $form = $this->createForm(FreightType::class, $freight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $freightRepository->add($freight, true);

            return $this->redirectToRoute('app_freight_freight_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('freight/freight/edit.html.twig', [
            'freight' => $freight,
            'form' => $form,
        ]);
    }

    #[Route('/freight/{id}', name: 'app_freight_freight_delete', methods: ['POST'])]
    public function delete(Request $request, Freight $freight, FreightRepository $freightRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$freight->getId(), $request->request->get('_token'))) {
            $freightRepository->remove($freight, true);
        }

        return $this->redirectToRoute('app_freight_freight_index', [], Response::HTTP_SEE_OTHER);
    }
}
