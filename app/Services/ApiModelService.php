<?php

namespace App\Services;

use App\Models\Api\BaseApiModel;
use App\Models\Api\User;
use App\Models\Api\Candidate;
use App\Models\Api\Recruiter;
use App\Models\Api\RecruiterTeamMember;
use App\Models\Api\JobOffer;
use App\Models\Api\Application;
use App\Models\Api\Media;
use App\Models\Api\Document;
use App\Models\Api\Notification;
use App\Models\Api\Conversation;
use App\Models\Api\Message;
use App\Models\Api\History;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class ApiModelService
{
    /**
     * Crée un modèle User à partir des données API
     */
    public function createUserFromApiData(array $data): User
    {
        return User::fromApiData($data);
    }

    /**
     * Crée une collection d'utilisateurs à partir des données API
     */
    public function createUsersFromApiData(array $data): Collection
    {
        return User::fromApiCollection($data);
    }

    /**
     * Crée un modèle Candidate avec ses relations
     */
    public function createCandidateWithRelations(array $candidateData, ?array $userData = null): Candidate
    {
        $candidate = Candidate::fromApiData($candidateData);

        if ($userData) {
            $candidate->setRelation('user', User::fromApiData($userData));
        }

        return $candidate;
    }

    /**
     * Crée un modèle Recruiter avec ses relations
     */
    public function createRecruiterWithRelations(array $recruiterData, $user = null, $teamMembersData = [], $mediasData = [], $jobOffersData = [])
    {
        // Crée le modèle recruteur principal
        $recruiter = new Recruiter();
        $recruiter->fill($recruiterData);
        $recruiter->id = $recruiterData['id'] ?? null;
        $recruiter->exists = true;

        // Rattache l'utilisateur si fourni
        if ($user) {
            $recruiter->setRelation('user', $user);
        }

        // ==========================
        // Team Members
        // ==========================
        $recruiter->teamMembers = collect($teamMembersData)
            ->map(fn($tm) => $tm instanceof RecruiterTeamMember ? $tm : RecruiterTeamMember::fromApiData((array)$tm));

        // ==========================
        // Medias
        // ==========================
        $recruiter->medias = collect($mediasData)
            ->map(fn($m) => $m instanceof Media ? $m : Media::fromApiData((array)$m));

        // Définir logo et banner
        $recruiter->logo = $recruiter->medias->firstWhere('type', 'company_logo');
        $recruiter->banner = $recruiter->medias->firstWhere('type', 'company_banner');

        // ==========================
        // Job Offers
        // ==========================
        $recruiter->jobOffers = collect($jobOffersData)
            ->map(fn($m) => tap($m instanceof JobOffer ? $m : JobOffer::fromApiData((array)$m), function ($job) {
                $job->formattedPublicationDate = Carbon::parse($job->publicationDate ?? now())
                    ->translatedFormat('d/m/Y');
            }));
        return $recruiter;
    }

    /**
     * Crée un modèle JobOffer avec ses relations
     */
    public function createJobOfferWithRelations(array $jobOfferData, ?array $recruiterData = null, ?array $applicationsData = null): JobOffer
    {
        $jobOffer = JobOffer::fromApiData($jobOfferData);

        if ($recruiterData) {
            $recruiter = $this->createRecruiterWithRelations($recruiterData, null, $recruiterData['teamMembers'], $recruiterData['medias']);
            $jobOffer->setRelation('recruiter', $recruiter);
        }

        if ($applicationsData) {
            $jobOffer->setRelation('applications', Application::fromApiCollection($applicationsData));
        }

        return $jobOffer;
    }

    /**
     * Crée un modèle Application avec ses relations
     */
    public function createApplicationWithRelations(array $applicationData, ?array $candidateData = null, ?array $jobOfferData = null): Application
    {
        $application = Application::fromApiData($applicationData);

        if ($candidateData) {
            $application->setRelation('candidate', Candidate::fromApiData($candidateData));
        }

        if ($jobOfferData) {
            $application->setRelation('jobOffer', JobOffer::fromApiData($jobOfferData));
        }

        return $application;
    }

    /**
     * Crée un modèle Media avec ses relations
     */
    public function createMediaWithRelations(array $mediaData, ?array $uploaderData = null): Media
    {
        $media = Media::fromApiData($mediaData);

        if ($uploaderData) {
            $media->setRelation('uploader', User::fromApiData($uploaderData));
        }

        return $media;
    }

    /**
     * Crée un modèle Document avec ses relations
     */
    public function createDocumentWithRelations(array $documentData, ?array $senderData = null): Document
    {
        $document = Document::fromApiData($documentData);

        if ($senderData) {
            $document->setRelation('sender', User::fromApiData($senderData));
        }

        return $document;
    }

    /**
     * Crée un modèle Conversation avec ses relations
     */
    public function createConversationWithRelations(array $conversationData, ?array $participant1Data = null, ?array $participant2Data = null, ?array $messagesData = null): Conversation
    {
        $conversation = Conversation::fromApiData($conversationData);

        if ($participant1Data) {
            $conversation->setRelation('participant1', User::fromApiData($participant1Data));
        }

        if ($participant2Data) {
            $conversation->setRelation('participant2', User::fromApiData($participant2Data));
        }

        if ($messagesData) {
            $messages = collect($messagesData)->map(function ($messageData) {
                return Message::fromApiData($messageData);
            });
            $conversation->setRelation('messages', $messages);
        }

        return $conversation;
    }

    /**
     * Crée un modèle Message avec ses relations
     */
    public function createMessageWithRelations(array $messageData, ?array $senderData = null, ?array $conversationData = null): Message
    {
        $message = Message::fromApiData($messageData);

        if ($senderData) {
            $message->setRelation('sender', User::fromApiData($senderData));
        }

        if ($conversationData) {
            $message->setRelation('conversation', Conversation::fromApiData($conversationData));
        }

        return $message;
    }

    /**
     * Crée un modèle Notification avec ses relations
     */
    public function createNotificationWithRelations(array $notificationData, ?array $userData = null): Notification
    {
        $notification = Notification::fromApiData($notificationData);

        if ($userData) {
            $notification->setRelation('user', User::fromApiData($userData));
        }

        return $notification;
    }

    /**
     * Crée un modèle History avec ses relations
     */
    public function createHistoryWithRelations(array $historyData, ?array $userData = null): History
    {
        $history = History::fromApiData($historyData);

        if ($userData) {
            $history->setRelation('user', User::fromApiData($userData));
        }

        return $history;
    }

    /**
     * Exemple d'utilisation : Récupérer un utilisateur avec ses relations
     */
    public function getUserWithProfile(int $userId): ?User
    {
        // Simulation de données API
        $userData = [
            'id' => $userId,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@example.com',
            'accountType' => 'candidate',
            'isActive' => true,
        ];

        $candidateData = [
            'id' => 1,
            'userId' => $userId,
            'dateOfBirth' => '1990-01-01',
            'location' => 'Paris',
            'skills' => json_encode(['PHP', 'Laravel', 'JavaScript']),
        ];

        $user = User::fromApiData($userData);
        $user->setRelation('candidate', Candidate::fromApiData($candidateData));

        return $user;
    }

    /**
     * Exemple d'utilisation : Récupérer une offre d'emploi avec ses relations
     */
    public function getJobOfferWithDetails(int $jobOfferId): ?JobOffer
    {
        // Simulation de données API
        $jobOfferData = [
            'id' => $jobOfferId,
            'title' => 'Développeur Laravel',
            'description' => 'Nous recherchons un développeur Laravel expérimenté',
            'status' => 'active',
            'employmentType' => 'cdi',
            'remote' => true,
        ];

        $recruiterData = [
            'id' => 1,
            'companyName' => 'Ma Société',
            'location' => 'Paris',
        ];

        $jobOffer = JobOffer::fromApiData($jobOfferData);
        $jobOffer->setRelation('recruiter', Recruiter::fromApiData($recruiterData));

        return $jobOffer;
    }
}
