<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"date is required")]
    #[Assert\GreaterThan("today")]
     #[Assert\Type("\DateTimeInterface")]   
    
    private ?\DateTimeInterface $DateRes = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message:"time is required")]
     #[Assert\Type("\DateTimeInterface")]
    
    private ?\DateTimeInterface $heure = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Etat is required")]
    private ?string $Etat = "-1";

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[Assert\NotBlank(message:"Etat is required")]
    private ?Anonnce $idA = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRes(): ?\DateTimeInterface
    {
        return $this->DateRes;
    }

    public function setDateRes(\DateTimeInterface $DateRes): self
    {
        $this->DateRes = $DateRes;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->Etat;
    }

    public function setEtat(string $Etat): self
    {
      $this->Etat = $Etat;

    return $this;
    }

    public function getIdA(): ?Anonnce
    {
        return $this->idA;
    }

    public function setIdA(?Anonnce $idA): self
    {
        $this->idA = $idA;

        return $this;
    }
   
    
}
