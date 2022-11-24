<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation')]
class ReservationController extends AbstractController
{

    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    #[Route('/affichage_front', name: 'affichage_front')]
    public function index_affichage_front(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/affichage_front.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }



    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('affichage_front', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $reservationRepository->remove($reservation, true);
        }

        return $this->redirectToRoute('affichage_front', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'actions', methods: ['POST'])]
    public function actions(Request $request, Reservation $reservation, $id)
    {
        $action = new Reservation($id);
        $action = $this->getDoctrine()->getRepository(Reservation::class)->find($id);
        
    }

    #[Route('/{id}/changetat', name: 'app_reservation_edits', methods: ['GET', 'POST'])]
    public function edit_etat_true(Request $request, Reservation $reservation, ReservationRepository $reservationRepository,\Swift_Mailer $mailer): Response
    {
             $reservation->setEtat(1);
             $reservationRepository->save($reservation, true);
             $message = (new \Swift_Message('Hello Email'))
             ->setFrom('sbaih238@gmail.com')
             ->setTo('sbai.hamza@esprit.tn')
             ->setBody(
                 $this->renderView(
                     'reservation/mailling.html.twig'
                 ),
                 'text/html'
             )
         ;
         $mailer->send($message);
            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    

     }

     #[Route('/{id}/changetatfalse', name: 'app_reservation_edits_false', methods: ['GET', 'POST'])]
     public function edit_etat_false(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
     {
              $reservation->setEtat(0);
              $reservationRepository->save($reservation, true);
 
             return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
     
 
      }

}
