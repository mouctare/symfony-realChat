<?php

namespace App\Controller;

use Exception;
use App\Entity\Participant;
use App\Entity\Conversation;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ConversationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


 /**
 * @Route("/conversations", name="conversations")
 */
class CoversationController extends AbstractController
{
    private  $entityManager;

    private  $conversationRepository;

    private  $userRepository;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, ConversationRepository $conversationRepository)
    {
        $this->entityManager = $entityManager;
        $this->conversationRepository = $conversationRepository;
        $this->userRepository = $userRepository;
    }
    /**
     * @Route("/{id}", name="getConversations")
     */
    public function index(Request $request, int $id)
    {
        $otherUser = $request->get('otherUser', 0);
        $otherUser = $this->userRepository->find($id);

        if (is_null($otherUser)) {
            throw new Exception("L'utilisateur n'a pas été trouvé");
        }
    
        // cannot create a conversation with myself

        if($otherUser->getId() === $this->getUser()->getId()){
            throw new Exception("Désolé, mais vous ne pouvez pas créer une conversation avec vous-même.");
        }


        // Check if conversatiopn already exists

        $conversation = $this->conversationRepository->findConversationByParticipants($otherUser->getId(), $this->getUser()->getId());
        
        if (count($conversation)) {
            throw new \Exception("The conversation already exists");
        }

        $conversation = new Conversation();
        
        $participant = new Participant();
        $participant->setUser($this->getUser());
        $participant->setConversation($conversation);


        $otherParticipant = new Participant();
        $otherParticipant->setUser($otherUser);
        $otherParticipant->setConversation($conversation);

        $this->entityManager->getConnection()->beginTransaction();
        try {
            $this->entityManager->persist($conversation);
            $this->entityManager->persist($participant);
            $this->entityManager->persist($otherParticipant);

            $this->entityManager->flush();
            $this->entityManager->commit();

        } catch(\Exception $e){
            $this->entityManager->rollback();

            throw $e;
        }

      return $this->json([
          'id' => $conversation->getId()
      ], Response::HTTP_CREATED, [], []);
    }
       /**
     * @Route("/", name="")
     */
  
}
