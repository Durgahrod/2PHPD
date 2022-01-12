<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Date;
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
     * @ORM\Column(type="date")
     */
    private Date $birthdate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\File", mappedBy="user")
     */
    private File $file;

//    /**
//     * @ORM\Column(type="string")
//     */
//    private string $avatarPath;


    /**
     * @ORM\Column(type="int")
     */
    private int $quota;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return Date
     */
    public function getBirthdate(): Date
    {
        return $this->birthdate;
    }

    /**
     * @param Date $birthdate
     */
    public function setBirthdate(Date $birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile(File $file): void
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getAvatarPath(): string
    {
        return $this->avatarPath;
    }

    /**
     * @param string $avatarPath
     */
    public function setAvatarPath(string $avatarPath): void
    {
        $this->avatarPath = $avatarPath;
    }

    /**
     * @return int
     */
    public function getQuota(): int
    {
        return $this->quota;
    }

    /**
     * @param int $quota
     */
    public function setQuota(int $quota): void
    {
        $this->quota = $quota;
    }
}