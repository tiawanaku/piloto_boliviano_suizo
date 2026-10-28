<?php

declare(strict_types=1);

use App\Models\User;
use Filament\Auth\Pages\Login;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Validator;
use Livewire\Livewire;

it('usa español como idioma de la aplicación', function () {
    expect(app()->getLocale())->toBe('es');
});

it('muestra en español el error de campo requerido con el nombre del campo traducido', function () {
    $validator = Validator::make([], ['email' => 'required']);

    expect($validator->errors()->first('email'))
        ->toBe('El campo correo electrónico es obligatorio.');
});

it('muestra en español el mensaje de credenciales incorrectas', function () {
    expect(__('auth.failed'))->toBe('El correo o la contraseña no son correctos.');
});

it('muestra en español los errores del login del panel :dataset', function (string $panel) {
    Filament::setCurrentPanel(Filament::getPanel($panel));

    User::factory()->create(['email' => 'docente@colegio-piloto.test']);

    Livewire::test(Login::class)
        ->fillForm(['email' => 'docente@colegio-piloto.test', 'password' => 'incorrecta'])
        ->call('authenticate')
        ->assertHasFormErrors(['email'])
        ->assertSee('Estas credenciales no coinciden con nuestros registros.');

    Livewire::test(Login::class)
        ->fillForm(['email' => '', 'password' => ''])
        ->call('authenticate')
        ->assertHasFormErrors(['email' => 'required', 'password' => 'required'])
        ->assertSee('es obligatorio');
})->with(['admin', 'docente']);

it('muestra en español la página de login de Filament', function () {
    $this->get('/admin/login')
        ->assertOk()
        ->assertSee('Entre a su cuenta')
        ->assertSee('Contraseña');
});
