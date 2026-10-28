<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Permisos funcionales de la matriz "Roles y permisos RBAC" (Fase 1–3),
 * con nombres técnicos `recurso.accion` (ADR-005 §5).
 */
enum Permission: string
{
    case StaffPortalAccess = 'staff_portal.access';
    case StaffInvite = 'staff.invite';
    case RolesAssignHigh = 'roles.assign_high';
    case RolesAssignStandard = 'roles.assign_standard';
    case AccountsDeactivate = 'accounts.deactivate';
    case AccountsUnlock = 'accounts.unlock';
    case MfaReset = 'mfa.reset';
    case AuditView = 'audit.view';
    case AcademicStructureManage = 'academic_structure.manage';
    case SubjectsManage = 'subjects.manage';
    case ClassroomsCreate = 'classrooms.create';
    case ClassroomsAssign = 'classrooms.assign';
    case StaffView = 'staff.view';
    case StaffEdit = 'staff.edit';
    case StaffEditEmail = 'staff.edit_email';
    case StudentsRegister = 'students.register';
    case StudentsEnroll = 'students.enroll';
    case StudentCredentialsManage = 'student_credentials.manage';
    case DirectoryViewBasic = 'directory.view_basic';
    case ClassroomsViewOwn = 'classrooms.view_own';
    case OwnAccountManage = 'own_account.manage';

    public function label(): string
    {
        return __('permissions.'.$this->value);
    }
}
