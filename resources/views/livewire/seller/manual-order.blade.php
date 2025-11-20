<div>
    @if(!$isEnabledSelling)
        <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div>
                <span class="font-medium text-3xl">Aguarde o retorno</span>
            </div>
        </div>
    @endif
    <div class="flex justify-center">
        <div class="block w-full max-w-lg p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <img src="/storage/imgs/header.jpeg?dummy={{rand()}}" class="w-full"/>
            <h5 class="mt-4 mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                SHOW DE PRÉMIOS D'BILHAR
            </h5>
            <h5 class="mb-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                COMPRAR CARTELA
            </h5>
            <p class="my-2 text-xl font-bold text-red-500 text-center">
                VALOR DA CARTELA R$: {{ $cardPrice }}
            </P>
            <form wire:submit="nextStep" class="text-xl">
                <!-- Name -->
                <div>
                    <div class="text-center"><x-input-label for="name" :value="__('NOME')" /></div>
                    <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Phone Number -->
                <div class="mt-4">
                    <div class="text-center"><x-input-label for="phone" :value="__('TELEFONE')" /></div>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 18">
                                <path d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z"/>
                            </svg>
                        </div>
                        <x-text-input x-mask="(99) 99999-9999" wire:model="phone" id="phone" class="block mt-1 w-full ps-10 p-2.5" name="phone" required placeholder="(__) _____-____"/>
                    </div>
                    <span class="text-red-500 text-sm">* Insira o formato exato como (12) 12345-6789</span>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- City -->
                <div class="mt-4">
                    <div class="text-center"><x-input-label for="city" :value="__('CIDADE')" /></div>
                    <x-text-input wire:model="city" id="city" class="block mt-1 w-full" type="text" name="city" autocomplete="city" />
                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                </div>

                <!-- Submit -->
                <div class="flex items-end gap-4 mt-4">
                    <!-- Quantity -->
                    <div class="grow">
                        <div class="text-center"><x-input-label for="card_number" :value="__('№ DA CARTELA')" /></div>
                        <x-text-input wire:model="card_number" id="card_number" class="block mt-1 w-full" name="card_number" autocomplete="card_number" />
                        <x-input-error :messages="$errors->get('card_number')" class="mt-2" />
                    </div>
                    <button class="flex-none rounded-lg py-2 px-8 bg-green-500 text-white font-semibold hover:bg-green-600" type="button" wire:click="orderManually">
                        CONFIRMA
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
