<?php
namespace App\Enum;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Catalogue;

enum RessourceType: string
{
    case EAU = 'Eau';
    case GRAINES = 'Graines';
    case OUTILS = 'Outils';
    case ENGRAIS = 'Engrais';
    public function label(): string
    {
        return match($this) {
            self::EAU => 'Eau',
            self::GRAINES => 'Graines',
            self::OUTILS => 'Outils',
            self::ENGRAIS => 'Engrais',
        };
    }
}