<div>
    <div class="grid grid-cols-2 gap-4">
        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Imagem de cabeçalho</h5>
            </a>
            <div class="mt-5 hover:border border-gray-500">
                <label for="header-image" class="cursor-pointer">
                    <img src="/storage/imgs/header.jpeg?dummy={{rand()}}" class="m-auto"/>
                </label>
                <input type="file" id="header-image" class="hidden" accept="image/*" wire:model="headerImage"/>
            </div>
        </div>
        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Imagem do cartão</h5>
            </a>
            <div class="mt-5 hover:border border-gray-500">
                <label for="card-image" class="cursor-pointer">
                    <img src="/storage/imgs/card.jpeg?dummy={{rand()}}" class="m-auto"/>
                </label>
                <input type="file" id="card-image" class="hidden" accept="image/*" wire:model="cardImage"/>
            </div>
        </div>
    </div>
</div>
