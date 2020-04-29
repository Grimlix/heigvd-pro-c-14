<?php

namespace App\Controller;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class User_controller extends EasyAdminController{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function persistUserEntity($user)
    {
        // Avec FOSUserBundle, on faisait comme ça :
        // $this->get('fos_user.user_manager')->updateUser($user, false);
        $this->updatePassword($user);
        parent::persistEntity($user);
    }

    public function updateUserEntity($user)
    {
        // Avec FOSUserBundle, on faisait comme ça :
        //$this->get('fos_user.user_manager')->updateUser($user, false);
        $this->updatePassword($user);
        parent::updateEntity($user);
    }

    public function updatePassword(User $user)
    {
        if (!empty($user->getPlainPassword())) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
        }
    }

}
