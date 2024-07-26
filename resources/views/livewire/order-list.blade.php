<div>
    <div class="flex justify-end">
        <a href="{{route('order.new')}}"
            class="cursor-pointer text-white border bg-blue-600 hover:bg-blue-700 rounded-lg p-2.5 text-center inline-flex items-center me-2">
            <svg fill="#fff" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="w-5 h-5" viewBox="0 0 45.402 45.402" xml:space="preserve" stroke="#fff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M41.267,18.557H26.832V4.134C26.832,1.851,24.99,0,22.707,0c-2.283,0-4.124,1.851-4.124,4.135v14.432H4.141 c-2.283,0-4.139,1.851-4.138,4.135c-0.001,1.141,0.46,2.187,1.207,2.934c0.748,0.749,1.78,1.222,2.92,1.222h14.453V41.27 c0,1.142,0.453,2.176,1.201,2.922c0.748,0.748,1.777,1.211,2.919,1.211c2.282,0,4.129-1.851,4.129-4.133V26.857h14.435 c2.283,0,4.134-1.867,4.133-4.15C45.399,20.425,43.548,18.557,41.267,18.557z"></path> </g> </g></svg>
            &nbsp; Nova Pedido
        </a>
    </div>
    <div class="mt-4 w-full overflow-auto">
        <table class="w-full text-sm md:text-lg text-left rtl:text-right text-gray-500 dark:text-gray-400 border-separate border-spacing-y-1">
            <thead class="text-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Ver
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Sorteio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        COD.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Qtd.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Valor
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Data Pedido
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Situação
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="bg-yellow_tr text-yellow_text">
                        <td class="px-6 py-1 border-l-4 border-yellow_border rounded-l-2xl">
                            <a href="{{route('order.detail', $order->id)}}"
                                class="cursor-pointer text-white border bg-blue-600 hover:bg-blue-700 rounded-lg p-2.5 text-center inline-flex items-center me-2">
                                Ver
                            </a>
                        </td>
                        <td class="px-6 py-1">
                            <img src="/storage/imgs/card.jpeg?dummy={{rand()}}" class="h-12">
                        </td>
                        <td class="px-6 py-1">
                            {{$order->id}}
                        </td>
                        <td class="px-6 py-1">
                            {{$order->quantity}}
                        </td>
                        <td class="px-6 py-1">
                            R$ {{$order->price}}
                        </td>
                        <td class="px-6 py-1">
                            {{$order->created_at}}
                        </td>
                        <td class="px-6 py-1">
                            <p class="border border-yellow_text rounded-lg p-1">
                                @switch($order->payment_status)
                                    @case(0)
                                        Aguardando Pagamento
                                        @break
                                    @case(1)
                                        Pago
                                        @break
                                    @case(2)
                                        Falha no pagamento
                                        @break

                                    @default
                                        Aguardando Pagamento
                                @endswitch
                            </p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
