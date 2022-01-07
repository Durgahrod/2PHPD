<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints as Assert;


class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner un nom d'utilisateur.")
     * @ORM\Column(type="string")
     */
    private string $username;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner un mot de passe.")
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner un email.")
     * @Assert\Email(message = "L'email n'est pas valide.")
     * @ORM\Column(type="string")
     */
    private string $email;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner votre prénom.")
     * @ORM\Column(type="string")
     */
    private string $firstName;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner votre nom de famille.")
     * @ORM\Column(type="string")
     */
    private string $lastName;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner votre date de naissance.")
     * @ORM\Column(type="datetime")
     */
    private DateTime $birthdate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\File", mappedBy="user")
     */
    private File $file;

    /**
     * @ORM\Column(type="string")
     */
    private string $avatarPath;

    /**
     * @ORM\Column(type="int")
     */
    private int $quota;
}