<x-modal formAction="updateSeller">
    <x-slot name="title">
        Detalhes do vendedor
    </x-slot>

    <x-slot name="content">
        <!-- Name -->
        <div class="px-3">
            <x-input-label for="name" value="Nome" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" wire:model.lazy="name" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <!-- Phone -->
        <div class="px-3">
            <x-input-label for="phone" value="Telefone" />
            <x-text-input x-mask="(99) 99999-9999" wire:model="phone" id="phone" class="block mt-1 w-full" name="phone" required placeholder="(__) _____-____"/>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        <!-- Password -->
        <div class="px-3">
            <x-input-label for="password" value="Senha" />
            <x-text-input id="password" class="block mt-1 w-full" type="text" name="password" wire:model.lazy="password"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="buttons">
        <button class="inline-block mt-2 md:ml-5 text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Salvar
        </button>
    </x-slot>
</x-modal>
