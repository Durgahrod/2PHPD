<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use http\Message;
use phpDocumentor\Reflection\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvatarRepository")
 */

class Avatar
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $path;

    private uploadedFile $file;
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @ORM\Column(type="string")
     */
    private string $greetingMessage;

    /**
     * @param string $path
     */
    public function setPath(string $path): File
    {
        $this->path = $path;

    }

    /**
     * @return string
     */
    public function getGreetingMessage(): string
    {
        return $this->greetingMessage;
    }

    /**
     * @param string $greetingMessage
     */
    public function setGreetingMessage(string $greetingMessage): string
    {
        $this->greetingMessage = $greetingMessage;
    }


}
