<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends Fixture
{
    public const DEFAULT_USER_LOGIN = 'demo';
    public const DEFAULT_USER_PASSWORD = 'demo';

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername(self::DEFAULT_USER_LOGIN);
        $user->setPassword(
            $this->passwordEncoder->hashPassword(
                $user,
                'demo'
            )
        );
        // $user->setPassword(self::DEFAULT_USER_PASSWORD);
        $user->setRoles(['ROLE_USER']);
        $user->setCreated(new \DateTime());

        $manager->persist($user);
        $manager->flush();
    }
}
