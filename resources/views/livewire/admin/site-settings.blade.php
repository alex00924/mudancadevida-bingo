<div>
    <div class="mt-8 p-5 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Iniciar/Parar Venda</h5>
        </a>
        <div class="mt-5">
            <button type="button" class="ml-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                wire:click="toggleEnableSelling">
                {{ $enabledSelling ? "Parar de vender o cartão" : "Iniciar a venda do cartão" }}
            </button>
        </div>
    </div>

    <div class="mt-8 p-5 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Preço do cartão</h5>
        </a>
        <div class="mt-5">
            <x-input-label for="card-price" :value="__('Preço do cartão')" />
            <x-text-input wire:model="price" id="card-price" class="block mt-1 w-full" name="card-price" required autofocus autocomplete="card-price" />
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>
        <div class="flex justify-end mt-5">
            <button type="button" class="ml-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                wire:click="setPriceValue">
                Salvar
            </button>
        </div>
    </div>

    <div class="mt-8 p-5 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Quantidade mínima de compra</h5>
        </a>
        <div class="mt-5">
            <x-input-label for="minimum-quantity" :value="__('Quantidade mínima de compra')" />
            <x-text-input type="number" wire:model="minimumQuantity" id="minimum-quantity" class="block mt-1 w-full" name="minimum-quantity" required autofocus autocomplete="minimum-quantity" />
            <x-input-error :messages="$errors->get('minimumQuantity')" class="mt-2" />
        </div>
        <div class="flex justify-end mt-5">
            <button type="button" class="ml-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                wire:click="setMinimumQuantity">
                Salvar
            </button>
        </div>
    </div>

    <div class="mt-8 p-5 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Índice de vendas inicial e final</h5>
        </a>
        <div class="mt-5">
            <x-input-label for="start-selling" :value="__('Índice de vendas iniciais')" />
            <x-text-input type="number" wire:model="startSelling" id="start-selling" class="block mt-1 w-full" name="start-selling" required autofocus autocomplete="start-selling" />
            <x-input-error :messages="$errors->get('startSelling')" class="mt-2" />
        </div>
        <div class="mt-5">
            <x-input-label for="end-selling" :value="__('Índice de vendas finais')" />
            <x-text-input type="number" wire:model="endSelling" id="end-selling" class="block mt-1 w-full" name="end-selling" required autofocus autocomplete="end-selling" />
            <x-input-error :messages="$errors->get('endSelling')" class="mt-2" />
        </div>
        <div class="flex justify-end mt-5">
            <button type="button" class="ml-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                wire:click="setStartEndSelling">
                Salvar
            </button>
        </div>
    </div>
</div>
