<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields={"email"},
 * message="email  est déja utilisé ",
 * )
 * @UniqueEntity(
 * fields={"username"},
 * message="username  est déja utilisé ",
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "Your first name must be at least 4 characters long",
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "The email  is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *  @assert\EqualTo(propertyPath="password_confirm",message="Votre mot de passe doit étre le meme que celui que vous confirmez..")
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Your Password must be at least 8 characters long",
     * )
     */
    private $password;
   
     private $password_confirm;
     
 /**
 * @ORM\Column(name="roles", type="array")
 */
protected $roles;


    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
     public function getPasswordConfirm(): ?string
    {
        return $this->password_confirm;
    }

    public function setPasswordConfirm(string $password): self
    {
        $this->password_confirm = $password;

        return $this;
    }
    public function eraseCredentials(){
        
    }
    
        public function getRoles()
{
        if(!$this->roles ) return['ROLE_USER'];;
    return $this->roles;
}
public function setRoles(array $roles)
{
    
    $this->roles = $roles;
    return $this;
}
   
    public function getSalt(){
        
    }
}
