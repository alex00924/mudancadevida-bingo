<div>
    <div class="block md:flex md:justify-end mt-5">
        <button type="button" class="block mt-2 md:ml-5 text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            wire:click="$dispatch('openModal', { component: 'admin.seller-edit' })">
            Novo vendedor
        </button>
        <button type="button" class="block mt-2 md:ml-5 text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2.5 text-center items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
            wire:click="clearData"
            wire:confirm="Você quer limpar os dados?">
            Redefinir vendedor
        </button>
    </div>
    <div class="overflow-auto w-full">
        <table class="w-full mt-5 text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        {{__('NOME')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('TELEFONE')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('Registrado em')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('Ação')}}
                    </th>
                </tr>
            </thead>
            <tbody>
                @if(empty($users) || count($users) < 1)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" colspan="4" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Sem dados
                        </th>
                    </tr>
                @else
                    @foreach ($users as $item)
                        <tr class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                                {{$item->name}}
                            </th>
                            <td class="px-6 py-4">
                                {{$item->phone}}
                            </td>
                            <td class="px-6 py-4">
                                {{$item->created_at}}
                            </td>
                            <td class="px-6 py-4">
                                <button type="button" class="inline-block mt-2 text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                    wire:click="$dispatch('openModal', { component: 'admin.seller-edit', arguments: { userId: {{ $item->id }} } })">
                                    Editar
                                </button>
                                <button type="button" class="inline-block mt-2 md:ml-2 text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2.5 text-center items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                    wire:click="deleteSeller({{$item->id}})" wire:confirm="Você quer excluir este vendedor?">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>
