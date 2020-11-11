<?php

namespace App\Feature;

use App\Entity\Link;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class Friend
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function addFriend(User $targetUser, User $connectedUser): string
    {
        $links = $this->manager->getRepository(Link::class);

        $criteria = ['receiver' => $targetUser->getId(), 'sender' => $connectedUser->getId()];
        $criteria2 = ['receiver' => $connectedUser->getId(), 'sender' => $targetUser->getId()];

        $invit = $links->FindOneby($criteria);
        $request = $links->FindOneby($criteria2);

        if ($targetUser->getId() === $connectedUser->getId()) {

            return "Vous ne pouvez pas vous ajoutez vous-même !";
        }
        else {
            if (empty($invit) && empty($request))
            {
                $link = new Link();
                $link->setReceiver($targetUser)
                    ->setSender($connectedUser);

                $this->manager->persist($link);
                $this->manager->flush();

                return"Invitations bien envoyé !";
            }

            return "Vous êtes déjà ami !";
        }
    }
}