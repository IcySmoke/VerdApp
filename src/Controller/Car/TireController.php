<?php

namespace App\Controller\Car;

use App\Entity\Car\Tire;
use App\Form\Car\TireType;
use App\Repository\Car\TireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tire')]
class TireController extends AbstractController
{
    #[Route('/', name: 'app_car_tire_index', methods: ['GET'])]
    public function index(TireRepository $tireRepository): Response
    {
        $tires = $tireRepository->createQueryBuilder('t')
            ->addSelect('t.brand', 't.type', 't.width', 't.aspectRatio', 't.rim', 't.loadIndex', 't.speedRating', 't.dot', 'count(t.id) as count', 't.groupId')
            ->addGroupBy('t.groupId')
            ->getQuery()->getArrayResult();

        return $this->render('car/tire/index.html.twig', [
            'tires' => $tires,
        ]);
    }

    #[Route('/new', name: 'app_car_tire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TireRepository $tireRepository): Response
    {
        $form = $this->createForm(TireType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupId = $this->generateGroupId($form);
            for ($i=0; $i<$form->get('count')->getData(); $i++) {
                $tire = new Tire();
                $tire->setBrand($form->get('brand')->getData())
                    ->setType($form->get('type')->getData())
                    ->setWidth($form->get('width')->getData())
                    ->setAspectRatio($form->get('aspectRatio')->getData())
                    ->setRim($form->get('rim')->getData())
                    ->setLoadIndex($form->get('loadIndex')->getData())
                    ->setSpeedRating(strtoupper($form->get('speedRating')->getData()))
                    ->setDot($form->get('dot')->getData())
                    ->setGroupId($groupId)
                ;
                $tireRepository->save($tire, true);
            }

            return $this->redirectToRoute('app_car_tire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/tire/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{groupId}', name: 'app_car_tire_show', methods: ['GET'])]
    public function show(string $groupId, TireRepository $tireRepository): Response
    {
        $tires = $tireRepository->createQueryBuilder('t')
            ->addSelect('t.id', 't.brand', 't.type', 't.width', 't.aspectRatio', 't.rim', 't.loadIndex', 't.speedRating', 't.dot', 't.distance')
            ->where('t.groupId = :groupId')
            ->setParameter(':groupId', $groupId)
            ->getQuery()->getArrayResult();
//        dd($tires);
        return $this->render('car/tire/show.html.twig', [
            'tires' => $tires,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_car_tire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tire $tire, TireRepository $tireRepository): Response
    {
        $form = $this->createForm(TireType::class, $tire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tireRepository->save($tire, true);

            return $this->redirectToRoute('app_car_tire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/tire/edit.html.twig', [
            'tire' => $tire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_car_tire_delete', methods: ['POST'])]
    public function delete(Request $request, Tire $tire, TireRepository $tireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tire->getId(), $request->request->get('_token'))) {
            $tireRepository->remove($tire, true);
        }

        return $this->redirectToRoute('app_car_tire_index', [], Response::HTTP_SEE_OTHER);
    }

    private function generateGroupId(FormInterface $form): string
    {
        $width = $form->get('width')->getData();
        if (strlen($width) != 3) {
            if (strlen($width) > 3) {
                $width = substr($width, 0, 3);
            } else {
                $length = strlen($width);
                for ($i = 0; $i <= $length; $i++) {
                    $width = '0'.$width;
                }
            }
        }

        $aspect = $form->get('aspectRatio')->getData();
        if (strlen($aspect) != 2) {
            if (strlen($aspect) > 2) {
                $aspect = substr($aspect, 0, 2);
            } else {
                $aspect = '0'.$aspect;
            }
        }

        $rim = $form->get('rim')->getData();
        if (strlen($rim) != 2) {
            if (strlen($rim) > 2) {
                $rim = substr($rim, 0, 2);
            } else {
                $rim = '0'.$rim;
            }
        }

        return
            substr($form->get('brand')->getData(), 0, 1).
            substr($form->get('type')->getData(), 0, 1).
            $width.
            $aspect.
            $rim.
            $form->get('dot')->getData()
        ;
    }
}
