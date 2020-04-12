<?php
        // src/AppBundle/Entity/User.php

        namespace App\Entity;

        use FOS\UserBundle\Model\User as BaseUser;
        use Doctrine\ORM\Mapping as ORM;

        /**
        * @ORM\Entity
        *@ORM\Table(name="`user`")
        */
        class User extends BaseUser
        {
            /**
             * @ORM\Id
             *@ORM\GeneratedValue(strategy="AUTO")
             *@ORM\Column(type="integer")
             */
            protected $id;

        }


