<?php

namespace App\Entity;

use App\Repository\ContactoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactoRepository::class)]
class Contacto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $telefono = null;

    #[ORM\ManyToOne(inversedBy: 'contactos')]
    private ?provedor $provedor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

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

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }
    public function constr(string $nombre, string $email, string $telefono): self{

        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->email = $email;

        return $this;
    }

    public function getProvedor(): ?provedor
    {
        return $this->provedor;
    }

    public function setProvedor(?provedor $provedor): self
    {
        $this->provedor = $provedor;

        return $this;
    }
}
