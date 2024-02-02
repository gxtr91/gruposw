<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">Informacion general</h2>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div>
                            <label for="first_name">Nickname</label>
                            <input class="form-control" id="first_name" type="text" value="{{ $user->name }}"
                                disabled>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" id="email" type="email" disabled
                                value="{{ $user->email }}">
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-body border-0 shadow mb-4">

                <h2 class="h5 mb-4">Cambiar contrasena</h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Asegurate que tienes una contrasena larga, random y dificil de descifrar.') }}
                </p>

                <form method="post" action="{{ route('password.update') }}" class="mt-3 space-y-6">
                    @csrf
                    @method('put')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="first_name">Contrasena actual</label>
                                <x-text-input id="update_password_current_password" name="current_password"
                                    type="password" class="form-control" autocomplete="current-password" />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="first_name">Nueva contrasena</label>
                                <x-text-input id="update_password_password" name="password" type="password"
                                    class="form-control" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="first_name">Confirmar contrasena</label>
                                <x-text-input id="update_password_password_confirmation" name="password_confirmation"
                                    type="password" class="form-control" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <x-primary-button
                            class="btn btn-gray-800 mt-2 animate-up-2">{{ __('Guardar') }}</x-primary-button>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
