<div>
    <div class="block md:flex md:justify-end mt-5">
        <div class="block relative w-72">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input wire:model.lazy="nameFilter" type="search" id="name-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Filtrar por nome"/>
            <button wire:click="filterOrders" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Procurar</button>
        </div>
        <div class="block relative w-72 md:ml-5">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input wire:model.lazy="cardFilter" type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Filtrar por cartão"/>
            <button wire:click="filterOrders" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Procurar</button>
        </div>
        <button type="button" class="block mt-2 md:ml-5 text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2.5 text-center items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
            wire:click="clearData"
            wire:confirm="Você quer limpar os dados?">
            Apagar os dados
        </button>
        <a type="button" class="inline-flex mt-2 md:ml-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            href="{{route('admin.order.export')}}">
            Exportar CSV
        </a>
    </div>
    <div class="overflow-auto w-full">
        <table class="w-full mt-5 text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        {{__('IDVENDA')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('CARTELAS')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('NOMECILENTE')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('FONECLIENTE')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('CIDADE')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('VALOR')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('Situação')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('DATA')}}
                    </th>
                </tr>
            </thead>
            <tbody>
                @if(empty($orders) || count($orders) < 1)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" colspan="8" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Sem dados
                        </th>
                    </tr>
                @else
                    @foreach ($orders as $item)
                        <tr class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                                {{$item->id}}
                            </th>
                            <td class="px-6 py-4">
                                {{$item->cardNumbers()}}
                            </td>
                            <td class="px-6 py-4">
                                {{$item->user->name}}
                            </td>
                            <td class="px-6 py-4">
                                {{$item->user->phone}}
                            </td>
                            <td class="px-6 py-4">
                                {{$item->user->city}}
                            </td>
                            <td class="px-6 py-4">
                                {{$item->price}}
                            </td>
                            <td class="px-6 py-4">
                                @switch($item->payment_status)
                                    @case(0)
                                        <p class="border border-yellow_text rounded-lg p-1">
                                            Aguardando Pagamento
                                        </p>
                                        @break
                                    @case(1)
                                        <p class="border border-sky-500 rounded-lg p-1">
                                            Pago
                                        </p>
                                        @break
                                    @case(2)
                                        <p class="border border-red-500 rounded-lg p-1">
                                            Falha no pagamento
                                        </p>
                                        @break
                                    @default
                                        <p class="border border-yellow_text rounded-lg p-1">
                                            Aguardando Pagamento
                                        </p>
                                    @endswitch
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                {{$item->created_at}}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $orders->links() }}
    </div>
</div>
