<?php
/**
 * Created by PhpStorm.
 * User: bp
 * Date: 6/11/2017
 * Time: 12:00
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GenusController
 * @package AppBundle\Controller
 */
class GenusController extends Controller
{
    /**
     * @Route("/genus")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $genuses = $em->getRepository('AppBundle:Genus')
            ->findAllPublishedOrderedByRecentlyActive();
        return $this->render('genus/list.html.twig', [
            'genuses' => $genuses
        ]);
    }

    /**
     * @Route("/genus/new")
     */
    public function newAction()
    {
        $genus = new Genus();
        $genus->setName('Octopus'.rand(1, 100));
        $genus->setSubFamily('Octopodinae');
        $genus->setSpeciesCount(rand(100,99999));

        $note = new GenusNote();
        $note->setUsername('AquaWeaver');
        $note->setUserAvatarFilename('ryan.jpeg');
        $note->setNote('I counted 8 legs... as they wrapped around me');
        $note->setCreatedAt(new \DateTime('-1 month'));
        $note->setGenus($genus);

        $em = $this->getDoctrine()->getManager();
        $em->persist($genus);
        $em->persist($note);
        $em->flush();
        return new Response('<html><body>Genus created!</body></html>');

    }

    /**
     * @Route("/genus/{genusName}", name="genus_show")
     * @param $genusName
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($genusName)
    {
        $em = $this->getDoctrine()->getManager();
        $genus = $em->getRepository('AppBundle:Genus')->findOneBy(['name'=>$genusName]);

        $recentNotes = $em->getRepository('AppBundle:GenusNote')->findAllRecentNotesForGenus($genus);

        $time = new \DateTime(null, new \DateTimeZone('Europe/Brussels'));
        $time = $time->format('Y-m-d H:i');

        if(!$genus){
            throw $this->createNotFoundException('Genus not found');
        }

        return $this->render('genus/show.html.twig', [
            'genus' => $genus,
            'time' => $time,
            'recentNoteCount' => count($recentNotes)
        ]);
    }

    /**
     * @Route("/genus/{name}/notes", name="genus_show_notes")
     * @Method("GET")
     * @param Genus $genus
     * @return JsonResponse
     */
    public function getNotesAction(Genus $genus)
    {
        $notes = [];

        foreach ($genus->getNotes() as $note){
            $notes[] = [
              'id' => $note->getId(),
              'username' => $note->getUsername(),
              'avatarUri' => '/images/'.$note->getUserAvatarFilename(),
              'note' => $note->getNote(),
              'date' => $note->getCreatedAt()->format('M d, Y'),
            ];
        }

        $data = [
            'notes' => $notes
        ];

        return new JsonResponse($data);
    }
}