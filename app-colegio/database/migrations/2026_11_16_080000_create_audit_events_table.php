<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Bitácora de auditoría append-only (ADR-005 §6, HU-013).
 *
 * actor_id no tiene clave foránea a propósito: un ON DELETE SET NULL sería un
 * UPDATE sobre audit_events y el trigger de inmutabilidad lo rechazaría; además
 * el registro debe sobrevivir a la cuenta que lo generó.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('occurred_at', precision: 6)->index();
            // Valores de App\Enums\AuditEventType; literal para no depender del enum.
            $table->string('event_type', 64)->index();
            $table->uuid('actor_id')->nullable()->index();
            $table->string('subject_type')->nullable();
            $table->string('subject_id', 64)->nullable();
            $table->string('email_attempted')->nullable();
            $table->string('result', 32);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('context')->nullable();

            $table->index(['subject_type', 'subject_id']);
            $table->index(['actor_id', 'occurred_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_events');
    }
};
