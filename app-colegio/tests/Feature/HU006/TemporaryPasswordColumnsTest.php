<?php

declare(strict_types=1);

use App\Models\Concerns\HasTemporaryPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

/*
 * HU-006 · Base de "Contraseña temporal" y "Contraseña temporal vencida":
 * columnas en users y trait HasTemporaryPassword (T-1-06). Se prueba con un
 * modelo sobre la tabla users hasta que User use el trait (T-1-10, Dev 2).
 */

function temporaryPasswordModel(): Model
{
    return new class extends Model
    {
        use HasTemporaryPassword;

        protected $table = 'users';
    };
}

it('agrega las columnas de contraseña temporal a users', function () {
    expect(Schema::hasColumns('users', ['must_change_password', 'temporary_password_expires_at']))->toBeTrue();
});

it('aplica los casts de contraseña temporal', function () {
    $model = temporaryPasswordModel()->forceFill([
        'must_change_password' => 1,
        'temporary_password_expires_at' => '2026-11-20 10:00:00',
    ]);

    expect($model->must_change_password)->toBeTrue()
        ->and($model->temporary_password_expires_at)->toBeInstanceOf(Carbon::class);
});

it('marca la contraseña como temporal con vigencia de 72 horas', function () {
    $this->freezeSecond();

    $model = temporaryPasswordModel()->markPasswordAsTemporary();

    expect($model->must_change_password)->toBeTrue()
        ->and($model->temporary_password_expires_at->equalTo(now()->addHours(72)))->toBeTrue()
        ->and($model->temporaryPasswordExpired())->toBeFalse();
});

it('Contraseña temporal vencida: vence pasadas las 72 horas', function () {
    $model = temporaryPasswordModel()->markPasswordAsTemporary();

    $this->travel(72)->hours();
    $this->travel(1)->minutes();

    expect($model->temporaryPasswordExpired())->toBeTrue();
});

it('no se considera vencida si ya no es temporal', function () {
    $model = temporaryPasswordModel()->markPasswordAsTemporary();
    $this->travel(100)->hours();

    $model->clearTemporaryPassword();

    expect($model->temporaryPasswordExpired())->toBeFalse()
        ->and($model->must_change_password)->toBeFalse()
        ->and($model->temporary_password_expires_at)->toBeNull();
});
