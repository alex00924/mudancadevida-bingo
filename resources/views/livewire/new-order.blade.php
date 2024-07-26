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
    @switch($processStatus)
        @case(1)
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
                            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
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
                            <x-text-input wire:model="city" id="city" class="block mt-1 w-full" type="text" name="city" required autocomplete="city" />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>

                        <!-- Quantity -->
                        <div class="mt-4">
                            <div class="text-center"><x-input-label :value="__('QUANTIDADE')" /></div>
                            <div class="relative px-2 py-1 mt-1 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <a class="absolute inset-y-0 start-0 flex items-center px-3.5 cursor-pointer hover:bg-gray-200"
                                    wire:click="changeQuantity(-1)">
                                    <svg stroke="#ef4444" fill="#ef4444" class="w-5 h-5" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12L18 12" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </a>
                                <p class="text-center text-2xl font-bold">
                                    {{$quantity}}
                                </p>
                                <a class="absolute inset-y-0 end-0 flex items-center px-3.5 cursor-pointer hover:bg-gray-200"
                                    wire:click="changeQuantity(1)">
                                    <svg fill="#ef4444" class="w-5 h-5" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 45.402 45.402" xml:space="preserve" stroke="#fff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M41.267,18.557H26.832V4.134C26.832,1.851,24.99,0,22.707,0c-2.283,0-4.124,1.851-4.124,4.135v14.432H4.141 c-2.283,0-4.139,1.851-4.138,4.135c-0.001,1.141,0.46,2.187,1.207,2.934c0.748,0.749,1.78,1.222,2.92,1.222h14.453V41.27 c0,1.142,0.453,2.176,1.201,2.922c0.748,0.748,1.777,1.211,2.919,1.211c2.282,0,4.129-1.851,4.129-4.133V26.857h14.435 c2.283,0,4.134-1.867,4.133-4.15C45.399,20.425,43.548,18.557,41.267,18.557z"></path> </g> </g></svg>
                                </a>
                            </div>
                            <div class="mt-2 grid grid-cols-3 gap-2 sm:gap-4">
                                <a class="flex justify-center items-center border border-gray-300 rounded-lg p-2 hover:bg-gray-200 cursor-pointer"
                                    wire:click="changeQuantity(5)">
                                    <svg fill="#111827" class="w-5 h-5" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 45.402 45.402" xml:space="preserve" stroke="#fff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M41.267,18.557H26.832V4.134C26.832,1.851,24.99,0,22.707,0c-2.283,0-4.124,1.851-4.124,4.135v14.432H4.141 c-2.283,0-4.139,1.851-4.138,4.135c-0.001,1.141,0.46,2.187,1.207,2.934c0.748,0.749,1.78,1.222,2.92,1.222h14.453V41.27 c0,1.142,0.453,2.176,1.201,2.922c0.748,0.748,1.777,1.211,2.919,1.211c2.282,0,4.129-1.851,4.129-4.133V26.857h14.435 c2.283,0,4.134-1.867,4.133-4.15C45.399,20.425,43.548,18.557,41.267,18.557z"></path> </g> </g></svg>
                                    &nbsp; 5 un.
                                </a>
                                <a class="flex justify-center items-center border border-gray-300 rounded-lg p-2 hover:bg-gray-200 cursor-pointer"
                                    wire:click="changeQuantity(10)">
                                    <svg fill="#111827" class="w-5 h-5" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 45.402 45.402" xml:space="preserve" stroke="#fff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M41.267,18.557H26.832V4.134C26.832,1.851,24.99,0,22.707,0c-2.283,0-4.124,1.851-4.124,4.135v14.432H4.141 c-2.283,0-4.139,1.851-4.138,4.135c-0.001,1.141,0.46,2.187,1.207,2.934c0.748,0.749,1.78,1.222,2.92,1.222h14.453V41.27 c0,1.142,0.453,2.176,1.201,2.922c0.748,0.748,1.777,1.211,2.919,1.211c2.282,0,4.129-1.851,4.129-4.133V26.857h14.435 c2.283,0,4.134-1.867,4.133-4.15C45.399,20.425,43.548,18.557,41.267,18.557z"></path> </g> </g></svg>
                                    &nbsp; 10 un.
                                </a>
                                <a class="flex justify-center items-center border border-gray-300 rounded-lg p-2 hover:bg-gray-200 cursor-pointer"
                                    wire:click="changeQuantity(15)">
                                    <svg fill="#111827" class="w-5 h-5" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 45.402 45.402" xml:space="preserve" stroke="#fff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M41.267,18.557H26.832V4.134C26.832,1.851,24.99,0,22.707,0c-2.283,0-4.124,1.851-4.124,4.135v14.432H4.141 c-2.283,0-4.139,1.851-4.138,4.135c-0.001,1.141,0.46,2.187,1.207,2.934c0.748,0.749,1.78,1.222,2.92,1.222h14.453V41.27 c0,1.142,0.453,2.176,1.201,2.922c0.748,0.748,1.777,1.211,2.919,1.211c2.282,0,4.129-1.851,4.129-4.133V26.857h14.435 c2.283,0,4.134-1.867,4.133-4.15C45.399,20.425,43.548,18.557,41.267,18.557z"></path> </g> </g></svg>
                                    &nbsp; 15 un.
                                </a>
                            </div>
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <!-- <div>
                            <label for="identificationType">Tipo de documento</label>
                            <select id="form-checkout__identificationType" name="identificationType" type="text"></select>
                        </div> -->
                        <!-- Submit -->
                        <button class="w-full rounded-lg py-2 px-8 mt-4 flex justify-between bg-bright_yellow text-gray-900">
                            <span>COMPRAR</span>
                            <span>R$ {{$quantity * $cardPrice}}</span>
                        </button>
                    </form>

                </div>
            </div>
            @break

        @case(2)
            <div class="flex justify-center">
                <div class="block w-full max-w-lg p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center underline">
                        SHOW DE PRÉMIOS D'BILHAR
                    </h5>
                    <p class="m5-4 text-xl font-bold text-gray-900 text-center">
                        TOTAL DE CARTELAS: {{$quantity}}
                    </P>
                    <p class="mt-2 text-xl font-bold text-gray-900 text-center">
                        VALOR TOTAL: R$ {{$quantity*$cardPrice}}
                    </P>

                    <div class="bg-sky-100 border-l-4 border-l-sky-600 rounded-lg mt-8 p-2">
                        <h6 class="font-bold text-sky-600 text-center">
                            Clique no botão "Pagar" para gerar o PIX e concluir sua compra.
                        </h6>
                        <p class="text-sky-600 my-2 text-center">
                            Você pode verificar seu pedido em acessos futuros acessando "Meus Pedidos" no menu ou clicando no seu nome.
                        </p>
                        <div class="flex justify-center">
                            <button class="py-2 px-6 md:px-12 mx-auto text-white bg-sky-600 rounded-lg"
                                wire:click="nextStep">
                                PAGAR
                            </button>
                        </div>
                    </div>

                    <p class="mt-8 text-xl font-bold text-gray-900 text-center">
                        RESUMO DO PEDIDO
                    </P>
                    <div class="bg-yellow-100 border-l-4 border-l-yellow_border rounded-lg mt-4 p-2">
                        <h6 class="font-bold text-yellow_border text-center">
                            Pedido Gerado
                        </h6>
                        <p class="text-yellow_border my-2 text-center">
                            Aguardando confirmação de pagamento!
                        </p>
                    </div>
                </div>
            </div>
            @break

        @case(3)
            <div class="flex justify-center">
                <div class="block w-full max-w-lg p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center underline">
                        QR Code
                    </h5>
                    <img src="data:image/jpeg;base64,{{$qr_code_base64}}" class="w-64 h-64 mx-auto mt-2"/>

                    <h6 class="text-xl text-gray-900 dark:text-white text-center mt-4">
                        Ou se preferir copie o código abaixo para realizar o pagamento:
                    </h6>
                    <div class="flex justify-center mt-2">
                        <button class="flex py-4 px-6 md:px-12 mx-auto text-white bg-yellow_border rounded-lg"
                            onclick="copyClipboard('{{$qr_code}}')">
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
                        {{$qr_code}}
                    </p>

                    <div class="flex justify-end">
                        <button class="py-2 px-6 md:px-12 mt-4 text-white bg-sky-600 rounded-lg"
                            wire:click="processOrder">
                            VER CARTELA
                        </button>
                    </div>
                </div>
            </div>
            @break
    @endswitch
</div>

@push('scripts')
<!-- <script src="https://sdk.mercadopago.com/js/v2"></script> -->

<script>
    let copyClipboard = function(text) {
        navigator.clipboard.writeText(text);
        Livewire.dispatch('notify', [{'message': "Código QR copiado para a área de transferência!", 'title': "", 'type': "success"}]);
    }

    // const mp = new MercadoPago("{{env('PIX_PUBLIC_KEY')}}");
    // (async function getIdentificationTypes() {
    //     try {
    //         const identificationTypes = await mp.getIdentificationTypes();
    //         const identificationTypeElement = document.getElementById('form-checkout__identificationType');

    //         createSelectOptions(identificationTypeElement, identificationTypes);
    //     } catch (e) {
    //         return console.error('Error getting identificationTypes: ', e);
    //     }
    //     })();

    //     function createSelectOptions(elem, options, labelsAndKeys = { label: "name", value: "id" }) {
    //         const { label, value } = labelsAndKeys;

    //         elem.options.length = 0;

    //         const tempOptions = document.createDocumentFragment();

    //         options.forEach(option => {
    //             const optValue = option[value];
    //             const optLabel = option[label];

    //             const opt = document.createElement('option');
    //             opt.value = optValue;
    //             opt.textContent = optLabel;

    //             tempOptions.appendChild(opt);
    //         });

    //         elem.appendChild(tempOptions);
    //     }
</script>
@endpush
