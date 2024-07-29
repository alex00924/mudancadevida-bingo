<div>
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
                        {{__('CIDADE')}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{__('Registrado em')}}
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
                                {{$item->city}}
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
        {{ $users->links() }}
    </div>
</div>
