<?php

namespace App\Http\Controllers;

use App\Services\ApiModelService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiModelExampleController extends Controller
{
    protected ApiModelService $apiModelService;

    public function __construct(ApiModelService $apiModelService)
    {
        $this->apiModelService = $apiModelService;
    }

    /**
     * Exemple d'utilisation des modèles API
     */
    public function example(): JsonResponse
    {
        // Exemple 1: Créer un utilisateur avec son profil candidat
        $user = $this->apiModelService->getUserWithProfile(1);
        
        // Exemple 2: Créer une offre d'emploi avec ses détails
        $jobOffer = $this->apiModelService->getJobOfferWithDetails(1);

        // Exemple 3: Utiliser les méthodes utilitaires des modèles
        $userInfo = [
            'fullName' => $user->getFullName(),
            'accountType' => $user->getAccountTypeLabel(),
            'isActive' => $user->isActive(),
        ];

        $candidateInfo = [
            'age' => $user->candidate->getAge(),
            'skills' => $user->candidate->getSkillsArray(),
            'location' => $user->candidate->location,
        ];

        $jobOfferInfo = [
            'title' => $jobOffer->title,
            'status' => $jobOffer->getStatusLabel(),
            'employmentType' => $jobOffer->getEmploymentTypeLabel(),
            'remote' => $jobOffer->getRemoteLabel(),
            'isActive' => $jobOffer->isActive(),
            'isExpired' => $jobOffer->isExpired(),
        ];

        return response()->json([
            'message' => 'Exemples d\'utilisation des modèles API',
            'user' => $userInfo,
            'candidate' => $candidateInfo,
            'jobOffer' => $jobOfferInfo,
        ]);
    }

    /**
     * Exemple de création de modèles avec relations
     */
    public function createWithRelations(): JsonResponse
    {
        // Données simulées de l'API
        $userData = [
            'id' => 1,
            'firstName' => 'Marie',
            'lastName' => 'Martin',
            'email' => 'marie.martin@example.com',
            'accountType' => 'recruiter',
            'isActive' => true,
        ];

        $recruiterData = [
            'id' => 1,
            'userId' => 1,
            'companyName' => 'Tech Solutions',
            'siret' => '12345678901234',
            'location' => 'Lyon',
            'teamSize' => '11-50',
        ];

        $teamMembersData = [
            [
                'id' => 1,
                'recruiterId' => 1,
                'name' => 'Jean Dupont',
                'email' => 'jean.dupont@techsolutions.com',
                'role' => 'Responsable RH',
            ],
            [
                'id' => 2,
                'recruiterId' => 1,
                'name' => 'Sophie Bernard',
                'email' => 'sophie.bernard@techsolutions.com',
                'role' => 'Recruteuse',
            ],
        ];

        // Créer le recruteur avec ses relations
        $recruiter = $this->apiModelService->createRecruiterWithRelations(
            $recruiterData,
            $userData,
            $teamMembersData
        );

        return response()->json([
            'message' => 'Recruteur créé avec ses relations',
            'recruiter' => [
                'companyName' => $recruiter->companyName,
                'teamSize' => $recruiter->getTeamSizeLabel(),
                'user' => [
                    'fullName' => $recruiter->user->getFullName(),
                    'email' => $recruiter->user->email,
                ],
                'teamMembers' => $recruiter->teamMembers->map(function ($member) {
                    return [
                        'name' => $member->name,
                        'email' => $member->email,
                        'role' => $member->role,
                    ];
                }),
            ],
        ]);
    }

    /**
     * Exemple d'utilisation des modèles de communication
     */
    public function communicationExample(): JsonResponse
    {
        // Créer une conversation avec des messages
        $conversationData = [
            'id' => 1,
            'participant1Id' => 1,
            'participant2Id' => 2,
            'createdAt' => '2024-01-15 10:00:00',
            'lastMessageAt' => '2024-01-15 14:30:00',
        ];

        $messagesData = [
            [
                'id' => 1,
                'conversationId' => 1,
                'senderId' => 1,
                'content' => 'Bonjour, je suis intéressé par votre offre de développeur Laravel.',
                'sentAt' => '2024-01-15 10:00:00',
                'isRead' => true,
            ],
            [
                'id' => 2,
                'conversationId' => 1,
                'senderId' => 2,
                'content' => 'Merci pour votre intérêt ! Pouvez-vous me dire quand vous seriez disponible pour un entretien ?',
                'sentAt' => '2024-01-15 14:30:00',
                'isRead' => false,
            ],
        ];

        $conversation = $this->apiModelService->createConversationWithRelations(
            $conversationData,
            null,
            null,
            $messagesData
        );

        return response()->json([
            'message' => 'Exemple de conversation',
            'conversation' => [
                'id' => $conversation->id,
                'createdAt' => $conversation->getFormattedCreatedAt(),
                'lastMessageAt' => $conversation->lastMessageAt->format('d/m/Y H:i'),
                'messages' => $conversation->messages->map(function ($message) {
                    return [
                        'content' => $message->getShortContent(50),
                        'sentAt' => $message->getFormattedSentAt(),
                        'isRead' => $message->isRead,
                        'isUnread' => $message->isUnread(),
                    ];
                }),
            ],
        ]);
    }

    /**
     * Exemple d'utilisation des modèles de notifications
     */
    public function notificationExample(): JsonResponse
    {
        $notificationData = [
            'id' => 1,
            'userId' => 1,
            'type' => 'new_message',
            'relatedType' => 'message',
            'message' => 'Vous avez reçu un nouveau message de Tech Solutions',
            'isRead' => false,
            'createdAt' => '2024-01-15 15:00:00',
        ];

        $notification = $this->apiModelService->createNotificationWithRelations($notificationData);

        return response()->json([
            'message' => 'Exemple de notification',
            'notification' => [
                'type' => $notification->getTypeLabel(),
                'relatedType' => $notification->getRelatedTypeLabel(),
                'message' => $notification->message,
                'isUnread' => $notification->isUnread(),
                'createdAt' => $notification->createdAt->format('d/m/Y H:i'),
            ],
        ]);
    }
}
