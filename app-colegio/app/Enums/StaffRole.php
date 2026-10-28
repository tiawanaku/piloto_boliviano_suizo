<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Roles del colegio (nombres técnicos de "Stack tecnologico" en el vault).
 * Los roles viven como datos en las tablas de spatie/laravel-permission;
 * este enum es la única fuente de sus nombres en el código.
 */
enum StaffRole: string
{
    case Director = 'director';
    case AcademicSecretary = 'academic_secretary';
    case PedagogicalCoordinator = 'pedagogical_coordinator';
    case ItSupport = 'it_support';
    case InformationOffice = 'information_office';
    case Teacher = 'teacher';
    case Student = 'student';

    public function label(): string
    {
        return __('roles.'.$this->value);
    }

    /**
     * Roles del grupo administrativo: dan acceso al panel `admin` y exigen MFA.
     */
    public function isAdministrative(): bool
    {
        return match ($this) {
            self::Director,
            self::AcademicSecretary,
            self::PedagogicalCoordinator,
            self::ItSupport,
            self::InformationOffice => true,
            self::Teacher, self::Student => false,
        };
    }

    /**
     * Prioridad para elegir el rol principal cuando `primary_role` está vacío
     * (ADR-005 §3): mayor número = mayor jerarquía. Primero los administrativos
     * en el orden de la matriz RBAC, luego Docente.
     */
    public function priority(): int
    {
        return match ($this) {
            self::Director => 100,
            self::AcademicSecretary => 90,
            self::PedagogicalCoordinator => 80,
            self::ItSupport => 70,
            self::InformationOffice => 60,
            self::Teacher => 50,
            self::Student => 10,
        };
    }

    /**
     * @return list<self>
     */
    public static function administrative(): array
    {
        return array_values(array_filter(self::cases(), fn (self $role): bool => $role->isAdministrative()));
    }
}
