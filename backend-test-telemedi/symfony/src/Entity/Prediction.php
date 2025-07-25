<?php

namespace App\Entity;

use App\Repository\PredictionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PredictionRepository::class)]
class Prediction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $date;

    #[ORM\ManyToOne(targetEntity: Department::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Department $department;

    #[ORM\Column(type: 'float')] private float $h00;
    #[ORM\Column(type: 'float')] private float $h01;
    #[ORM\Column(type: 'float')] private float $h02;
    #[ORM\Column(type: 'float')] private float $h03;
    #[ORM\Column(type: 'float')] private float $h04;
    #[ORM\Column(type: 'float')] private float $h05;
    #[ORM\Column(type: 'float')] private float $h06;
    #[ORM\Column(type: 'float')] private float $h07;
    #[ORM\Column(type: 'float')] private float $h08;
    #[ORM\Column(type: 'float')] private float $h09;
    #[ORM\Column(type: 'float')] private float $h10;
    #[ORM\Column(type: 'float')] private float $h11;
    #[ORM\Column(type: 'float')] private float $h12;
    #[ORM\Column(type: 'float')] private float $h13;
    #[ORM\Column(type: 'float')] private float $h14;
    #[ORM\Column(type: 'float')] private float $h15;
    #[ORM\Column(type: 'float')] private float $h16;
    #[ORM\Column(type: 'float')] private float $h17;
    #[ORM\Column(type: 'float')] private float $h18;
    #[ORM\Column(type: 'float')] private float $h19;
    #[ORM\Column(type: 'float')] private float $h20;
    #[ORM\Column(type: 'float')] private float $h21;
    #[ORM\Column(type: 'float')] private float $h22;
    #[ORM\Column(type: 'float')] private float $h23;

    public function getId(): ?int { return $this->id; }

    public function getDate(): \DateTimeInterface { return $this->date; }

    public function setDate(\DateTimeInterface $date): static {
        $this->date = $date;
        return $this;
    }

    public function getDepartment(): Department { return $this->department; }

    public function setDepartment(Department $department): static {
        $this->department = $department;
        return $this;
    }

    public function getH00(): float { return $this->h00; } public function setH00(float $v): static { $this->h00 = $v; return $this; }
    public function getH01(): float { return $this->h01; } public function setH01(float $v): static { $this->h01 = $v; return $this; }
    public function getH02(): float { return $this->h02; } public function setH02(float $v): static { $this->h02 = $v; return $this; }
    public function getH03(): float { return $this->h03; } public function setH03(float $v): static { $this->h03 = $v; return $this; }
    public function getH04(): float { return $this->h04; } public function setH04(float $v): static { $this->h04 = $v; return $this; }
    public function getH05(): float { return $this->h05; } public function setH05(float $v): static { $this->h05 = $v; return $this; }
    public function getH06(): float { return $this->h06; } public function setH06(float $v): static { $this->h06 = $v; return $this; }
    public function getH07(): float { return $this->h07; } public function setH07(float $v): static { $this->h07 = $v; return $this; }
    public function getH08(): float { return $this->h08; } public function setH08(float $v): static { $this->h08 = $v; return $this; }
    public function getH09(): float { return $this->h09; } public function setH09(float $v): static { $this->h09 = $v; return $this; }
    public function getH10(): float { return $this->h10; } public function setH10(float $v): static { $this->h10 = $v; return $this; }
    public function getH11(): float { return $this->h11; } public function setH11(float $v): static { $this->h11 = $v; return $this; }
    public function getH12(): float { return $this->h12; } public function setH12(float $v): static { $this->h12 = $v; return $this; }
    public function getH13(): float { return $this->h13; } public function setH13(float $v): static { $this->h13 = $v; return $this; }
    public function getH14(): float { return $this->h14; } public function setH14(float $v): static { $this->h14 = $v; return $this; }
    public function getH15(): float { return $this->h15; } public function setH15(float $v): static { $this->h15 = $v; return $this; }
    public function getH16(): float { return $this->h16; } public function setH16(float $v): static { $this->h16 = $v; return $this; }
    public function getH17(): float { return $this->h17; } public function setH17(float $v): static { $this->h17 = $v; return $this; }
    public function getH18(): float { return $this->h18; } public function setH18(float $v): static { $this->h18 = $v; return $this; }
    public function getH19(): float { return $this->h19; } public function setH19(float $v): static { $this->h19 = $v; return $this; }
    public function getH20(): float { return $this->h20; } public function setH20(float $v): static { $this->h20 = $v; return $this; }
    public function getH21(): float { return $this->h21; } public function setH21(float $v): static { $this->h21 = $v; return $this; }
    public function getH22(): float { return $this->h22; } public function setH22(float $v): static { $this->h22 = $v; return $this; }
    public function getH23(): float { return $this->h23; } public function setH23(float $v): static { $this->h23 = $v; return $this; }
}
