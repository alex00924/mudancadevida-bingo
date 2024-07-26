<div>
    <div class="block w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <div class="flex justify-center">
            <div class="w-full max-w-lg">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                    DETALHES DO PEDIDO
                </h5>

                <div class="bg-yellow-100 border-l-4 border-l-yellow_border rounded-lg mt-4 p-2">
                    <p class="text-yellow_border my-2 text-center">
                        Data Pedido: {{$order->created_at}}
                    </p>
                </div>

                <div class="bg-yellow-100 border-l-4 border-l-yellow_border rounded-lg mt-4 p-2">
                    <p class="text-yellow_border my-2 text-center">
                        Situação:
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
                </div>

                @if($order->payment_status != 1)
                    <div class="mt-4">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center underline">
                            QR Code
                        </h5>
                        <img src="data:image/jpeg;base64,{{$order->qr_code_base64}}" class="w-64 h-64 mx-auto mt-2"/>

                        <h6 class="text-xl text-gray-900 dark:text-white text-center mt-4">
                            Ou se preferir copie o código abaixo para realizar o pagamento:
                        </h6>
                        <div class="flex justify-center mt-2">
                            <button class="flex py-4 px-6 md:px-12 mx-auto text-white bg-yellow_border rounded-lg"
                                onclick="copyClipboard('{{$order->qr_code}}')">
                                <svg class="w-6 h-6"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff" version="1.1" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                                    <g>
                                        <path d="M53.9791489,9.1429005H50.010849c-0.0826988,0-0.1562004,0.0283995-0.2331009,0.0469999V5.0228   C49.7777481,2.253,47.4731483,0,44.6398468,0h-34.422596C7.3839517,0,5.0793519,2.253,5.0793519,5.0228v46.8432999   c0,2.7697983,2.3045998,5.0228004,5.1378999,5.0228004h6.0367002v2.2678986C16.253952,61.8274002,18.4702511,64,21.1954517,64   h32.783699c2.7252007,0,4.9414978-2.1725998,4.9414978-4.8432007V13.9861002   C58.9206467,11.3155003,56.7043495,9.1429005,53.9791489,9.1429005z M7.1110516,51.8661003V5.0228   c0-1.6487999,1.3938999-2.9909999,3.1062002-2.9909999h34.422596c1.7123032,0,3.1062012,1.3422,3.1062012,2.9909999v46.8432999   c0,1.6487999-1.393898,2.9911003-3.1062012,2.9911003h-34.422596C8.5049515,54.8572006,7.1110516,53.5149002,7.1110516,51.8661003z    M56.8888474,59.1567993c0,1.550602-1.3055,2.8115005-2.9096985,2.8115005h-32.783699   c-1.6042004,0-2.9097996-1.2608986-2.9097996-2.8115005v-2.2678986h26.3541946   c2.8333015,0,5.1379013-2.2530022,5.1379013-5.0228004V11.1275997c0.0769005,0.0186005,0.1504021,0.0469999,0.2331009,0.0469999   h3.9682999c1.6041985,0,2.9096985,1.2609005,2.9096985,2.8115005V59.1567993z"/>
                                        <path d="M38.6031494,13.2063999H16.253952c-0.5615005,0-1.0159006,0.4542999-1.0159006,1.0158005   c0,0.5615997,0.4544001,1.0158997,1.0159006,1.0158997h22.3491974c0.5615005,0,1.0158997-0.4542999,1.0158997-1.0158997   C39.6190491,13.6606998,39.16465,13.2063999,38.6031494,13.2063999z"/>
                                        <path d="M38.6031494,21.3334007H16.253952c-0.5615005,0-1.0159006,0.4542999-1.0159006,1.0157986   c0,0.5615005,0.4544001,1.0159016,1.0159006,1.0159016h22.3491974c0.5615005,0,1.0158997-0.454401,1.0158997-1.0159016   C39.6190491,21.7877007,39.16465,21.3334007,38.6031494,21.3334007z"/>
                                        <path d="M38.6031494,29.4603004H16.253952c-0.5615005,0-1.0159006,0.4543991-1.0159006,1.0158997   s0.4544001,1.0158997,1.0159006,1.0158997h22.3491974c0.5615005,0,1.0158997-0.4543991,1.0158997-1.0158997   S39.16465,29.4603004,38.6031494,29.4603004z"/>
                                        <path d="M28.4444485,37.5872993H16.253952c-0.5615005,0-1.0159006,0.4543991-1.0159006,1.0158997   s0.4544001,1.0158997,1.0159006,1.0158997h12.1904964c0.5615025,0,1.0158005-0.4543991,1.0158005-1.0158997   S29.0059509,37.5872993,28.4444485,37.5872993z"/>
                                    </g>
                                </svg>
                                &nbsp; COPIAR CÓDIGO
                            </button>
                        </div>
                        <p class="border border-gray-300 mt-2 p-2 break-all text-gray-900 dark:text-white">
                            {{$order->qr_code}}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <h5 class="mt-8 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
            Cartões de bingo
        </h5>

        <div class="mt-4 grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($order->orderDetails as $orderDetail)
                <div class="w-full border border-yellow_border">
                    <img src="/storage/imgs/card.jpeg?dummy={{$rand}}" class="w-full" />
                    <div class="bg-white p-4">
                        <p class="pl-4 md:pl-8 my-2 md:my-4 text-xl font-bold text-gray-900 dark:text-gray-200"><span class="underline">{{$orderDetail->bingoCard['card_number']}}-{{$orderDetail->bingoCard['card_digit']}}</p>
                        <table class="w-full text-xl text-center text-gray-900 dark:text-gray-200">
                            <thead class="text-xl md:text-3xl font-bold uppercase bg-gray-500 text-white">
                                <tr>
                                    <th scope="col" class="md:p-2 border-l border-l-gray-500 border-r border-r-gray-300">
                                        B
                                    </th>
                                    <th scope="col" class="md:p-2 border-r border-gray-300">
                                        I
                                    </th>
                                    <th scope="col" class="md:p-2 border-r border-gray-300">
                                        N
                                    </th>
                                    <th scope="col" class="md:p-2 border-r border-gray-300">
                                        G
                                    </th>
                                    <th scope="col" class="md:p-2 border-r border-gray-500">
                                        O
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($column=0; $column < 5; $column+=1)
                                    <tr class="bg-white">
                                        @for($row=0; $row < 5; $row+=1)
                                            <td class="md:p-2 border border-gray-500">
                                                {{$orderDetail->bingoCard['d' . ($row * 5 + $column + 1)]}}
                                            </td>
                                        @endfor
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    let copyClipboard = function(text) {
        navigator.clipboard.writeText(text);
        Livewire.dispatch('notify', [{'message': "Código QR copiado para a área de transferência!", 'title': "", 'type': "success"}]);
    }
</script>
@endpush
