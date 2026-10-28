<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Tercera capa de inmutabilidad de audit_events (ADR-005 §6): la base de datos
 * rechaza cualquier UPDATE o DELETE, incluso los que no pasan por Eloquent.
 *
 * - sqlite: motor del piloto (local, CI y demostración).
 * - pgsql: preparada para una implementación real; no se ejecuta en el piloto.
 *
 * Sin purga por retención: queda fuera del alcance del piloto.
 */
return new class extends Migration
{
    private const MESSAGE = 'audit_events es de solo insercion: no se permite UPDATE ni DELETE';

    public function up(): void
    {
        match (DB::getDriverName()) {
            'sqlite' => $this->upSqlite(),
            'pgsql' => $this->upPgsql(),
            default => null,
        };
    }

    public function down(): void
    {
        match (DB::getDriverName()) {
            'sqlite' => $this->downSqlite(),
            'pgsql' => $this->downPgsql(),
            default => null,
        };
    }

    private function upSqlite(): void
    {
        foreach (['UPDATE' => 'audit_events_no_update', 'DELETE' => 'audit_events_no_delete'] as $operation => $name) {
            DB::unprepared(<<<SQL
                CREATE TRIGGER {$name}
                BEFORE {$operation} ON audit_events
                BEGIN
                    SELECT RAISE(ABORT, '{$this->message()}');
                END;
                SQL);
        }
    }

    private function downSqlite(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS audit_events_no_update');
        DB::unprepared('DROP TRIGGER IF EXISTS audit_events_no_delete');
    }

    private function upPgsql(): void
    {
        DB::unprepared(<<<SQL
            CREATE OR REPLACE FUNCTION audit_events_reject_change() RETURNS trigger AS \$\$
            BEGIN
                RAISE EXCEPTION '{$this->message()}' USING ERRCODE = 'insufficient_privilege';
            END;
            \$\$ LANGUAGE plpgsql;

            CREATE TRIGGER audit_events_no_update_delete
                BEFORE UPDATE OR DELETE ON audit_events
                FOR EACH ROW EXECUTE FUNCTION audit_events_reject_change();

            CREATE TRIGGER audit_events_no_truncate
                BEFORE TRUNCATE ON audit_events
                FOR EACH STATEMENT EXECUTE FUNCTION audit_events_reject_change();
            SQL);
    }

    private function downPgsql(): void
    {
        DB::unprepared(<<<'SQL'
            DROP TRIGGER IF EXISTS audit_events_no_truncate ON audit_events;
            DROP TRIGGER IF EXISTS audit_events_no_update_delete ON audit_events;
            DROP FUNCTION IF EXISTS audit_events_reject_change();
            SQL);
    }

    private function message(): string
    {
        return self::MESSAGE;
    }
};
