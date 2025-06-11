<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-200">
            {{ __('Eliminar cuenta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('Una vez que su cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Antes de eliminar su cuenta, descargue cualquier dato o información que desee conservar.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('Eliminar cuenta') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-gray-800 rounded-lg shadow-lg border border-gray-700 text-white">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-200">
                {{ __('¿Está seguro de que desea eliminar su cuenta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                {{ __('Una vez que su cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Por favor, introduzca su contraseña para confirmar que desea eliminar su cuenta permanentemente.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4
                           bg-gray-800 border-gray-600 text-white placeholder-gray-500
                           focus:border-gray-600 focus:ring-gray-600"
                    placeholder="{{ __('Contraseña') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                {{-- ***** CAMBIO AQUÍ ***** --}}
                <x-secondary-button
                    x-on:click.prevent="window.location.href = '{{ route('profile.clear-deletion-errors') }}'"
                    class="bg-gray-700 text-white border border-transparent hover:bg-gray-600 focus:ring-gray-500 focus:ring-offset-gray-900"
                >
                    {{ __('Cancelar') }}
                </x-secondary-button>
                {{-- ***** FIN DEL CAMBIO ***** --}}

                <x-danger-button class="ms-3
                    bg-red-700 text-white hover:bg-red-600 focus:ring-red-500 focus:ring-offset-gray-900"
                >
                    {{ __('Eliminar cuenta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>