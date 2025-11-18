<?php

namespace App\Livewire;

use Livewire\Component;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\BingoCards;
use Illuminate\Http\Request;
use Efi\EfiPay;
use Efi\Exception\EfiException;

class NewOrder extends Component
{
    public string $name = '';
    public string $city = '';
    public string $phone = '';
    public int $quantity = 1;
    public int $processStatus = 1;
    public string $qr_code = '';
    public string $qr_code_base64 = '';
    public string $ticket_url = '';
    public string $payment_request_id = '';
    public $cardPrice = 10;
    public $isEnabledSelling = true;
    public $minimumPurchaseQuantity = 1;
    public $sellerId = null;

    public function mount(Request $request) {
        $sellerId = $request->get('vendedor');
        $seller = User::find($sellerId);
        if (!empty($seller) && $seller->hasRole('seller')) {
            $this->sellerId = $sellerId;
        }

        if (auth()->check()) {
            $this->name = auth()->user()->name??'';
            $this->city = auth()->user()->city??'';
            $this->phone = auth()->user()->phone??'';
        }

        $this->cardPrice = \App\Models\SiteSetting::getPrice();
        $this->isEnabledSelling = \App\Models\SiteSetting::isEnabledSelling();
        $this->minimumPurchaseQuantity = \App\Models\SiteSetting::getMinimumPurchaseQuantity();
        $this->quantity = $this->minimumPurchaseQuantity;
    }

    public function nextStep() {
        if ($this->processStatus == 1) {
            if (!$this->isEnabledSelling) {
                $this->notify('Aguarde o retorno', 'Advertência', 'warning');
                return;
            }

            $this->minimumPurchaseQuantity = \App\Models\SiteSetting::getMinimumPurchaseQuantity();
            // Fetch next n rows from BingoCard after last ordered number
            $lastOrder = OrderDetails::orderBy('id', 'desc')->first();
            $lastId = 0;
            if (!empty($lastOrder)) {
                $lastId = $lastOrder->bingo_card_id;
            }
            $startSelling = \App\Models\SiteSetting::getStartSelling();
            $lastId = max($lastId, $startSelling-1);

            $endSelling = \App\Models\SiteSetting::getEndSelling();

            if ($lastId + $this->quantity > $endSelling) {
                $this->notify('Aguarde o retorno', 'Advertência', 'warning');
                return;
            }

            $rules = [
                'name' => ['nullable', 'string', 'max:255'],
                'phone' => ['required', 'regex:/\([0-9]{2}\) [0-9]{5}-[0-9]{4}/'],
                'city' => ['nullable', 'string', 'max:255'],
                'quantity' => ['required', 'integer', "min:$this->minimumPurchaseQuantity"]
            ];


            $customMessage = [
                'quantity.min' => 'O campo quantidade deve ser pelo menos :min.'
            ];
            $this->validate($rules, $customMessage);

            $user = User::where('phone', $this->phone)->first();
            if (empty($user)) {
                $user = User::create([
                    'name' => $this->name ?? '',
                    'phone' => $this->phone,
                    'email' => $this->phone,
                    'password' => Hash::make('123456789'),
                    'city' => $this->city ?? ''
                ]);

                event(new Registered($user));
            } else {
                if (empty($user->name)) {
                    $user->name = $this->name;
                    $user->save();
                } else {
                    $this->name = $user->name;
                }

                if (empty($user->city)) {
                    $user->city = $this->city;
                    $user->save();
                } else {
                    $this->city = $user->city;
                }
            }


            Auth::login($user);
        }

        if ($this->processStatus == 2) {
            $createdPaymentRequest = $this->createPaymentRequestEfi();
            if (!$createdPaymentRequest) {
                $this->notify("Algo deu errado! Por favor, tente novamente", "Error", "error");
                return;
            }
            $this->createOrder();
        }
        $this->processStatus += 1;

    }

    private function createPaymentRequest_New() {
        // Step 2: Set production or sandbox access token
        MercadoPagoConfig::setAccessToken(env('PIX_ACCESS_TOKEN'));
        // Step 2.1 (optional - default is SERVER): Set your runtime enviroment from MercadoPagoConfig::RUNTIME_ENVIROMENTS
        // In case you want to test in your local machine first, set runtime enviroment to LOCAL
        MercadoPagoConfig::setRuntimeEnviroment(env('PIX_RUN_TIME'));

        // Step 3: Initialize the API client
        $client = new PaymentClient();

        try {
            $name_parts = explode(" ", $this->name);
            $lastname = array_pop($name_parts);
            $firstname = implode(" ", $name_parts);

            $expireDate = date("Y-m-d\TH:i:s.000P", strtotime("+30 minutes"));

            // $area_code =
            // Step 4: Create the request array
            $requestData = [
                "transaction_amount" => $this->quantity * $this->cardPrice,
                // "token" => "YOUR_CARD_TOKEN",
                "description" => "Pagamento de Prêmios D'BILHAR",
                "payment_method_id" => "pix",
                "date_of_expiration" => $expireDate,
                "payer" => [
                    "email" => "dijalmapaulodasilva7@gmail.com",
                    "first_name" => $firstname,
                    "last_name" => $lastname,
                    "phone" => [
                        "area_code" => 11,
                        "number" => "987654321"
                    ],
                    "address" => [
                        "city" => $this->city
                    ]
                ]
            ];

            // Step 5: Create the request options, setting X-Idempotency-Key
            $request_options = new RequestOptions();
            $idempotency_key = Str::random(10);

            $request_options->setCustomHeaders(["X-Idempotency-Key: " . $idempotency_key]);

            // Step 6: Make the request
            $payment = $client->create($requestData, $request_options);
            $this->payment_request_id = $payment->id;
            $this->qr_code_base64 = $payment->point_of_interaction->transaction_data->qr_code_base64;
            $this->qr_code = $payment->point_of_interaction->transaction_data->qr_code;
            $this->ticket_url = $payment->point_of_interaction->transaction_data->ticket_url;
        // Step 7: Handle exceptions
        } catch (MPApiException $e) {
            $this->notify(json_encode($e->getApiResponse()->getContent()), "Error", "error");
        } catch (\Exception $e) {
            $this->notify($e->getMessage(), "Error", "error");
        }
    }

    private function createPaymentRequest() {
        // Step 2: Set production or sandbox access token
        \MercadoPago\SDK::setAccessToken(env('PIX_ACCESS_TOKEN'));

        // MercadoPagoConfig::setAccessToken(env('PIX_ACCESS_TOKEN'));
        // Step 2.1 (optional - default is SERVER): Set your runtime enviroment from MercadoPagoConfig::RUNTIME_ENVIROMENTS
        // In case you want to test in your local machine first, set runtime enviroment to LOCAL
        // \MercadoPago\SDK::setRuntimeEnviroment(env('PIX_RUN_TIME'));

        // Step 3: Initialize the API client
        $payment = new \MercadoPago\Payment();//new PaymentClient();

        try {
            $name_parts = explode(" ", $this->name);
            $lastname = array_pop($name_parts);
            $firstname = implode(" ", $name_parts);
            $phoneNumber = preg_replace('/[^\d]/i', "", $this->phone);
            $area_code = substr($this->phone, 0, 2);
            $phoneNumber = substr($phoneNumber, 2);

            $expireDate = date("Y-m-d\TH:i:s.000P", strtotime("+30 minutes"));
            $payment->transaction_amount = number_format($this->quantity * $this->cardPrice, 2);
            $payment->description = "Pagamento de Prêmios D'BILHAR";
            $payment->payment_method_id = "pix";
            $payment->date_of_expiration = $expireDate;

            $payment->payer = [
                "email" => "dijalmapaulodasilva7@gmail.com",
                "first_name" => $firstname,
                "last_name" => $lastname,
                "phone" => [
                    "area_code" => $area_code,
                    "number" => $phoneNumber
                ],
                "address" => [
                    "city" => $this->city
                ]
            ];

            $createdRequest = $payment->save();
            if (!$createdRequest || empty($payment->id)) {
                $this->notify($payment->__get("error")->__toString(), "error");
                return false;
            }

            $this->payment_request_id = $payment->id;
            $this->qr_code_base64 = $payment->point_of_interaction->transaction_data->qr_code_base64;
            $this->qr_code = $payment->point_of_interaction->transaction_data->qr_code;
            $this->ticket_url = $payment->point_of_interaction->transaction_data->ticket_url;
        // Step 7: Handle exceptions
        } catch (\Exception $e) {
            $this->notify($e->getMessage(), "Error", "error");
            return false;
        }

        return true;
    }

    private function createPaymentRequestEfi(): bool
    {
        // init client
        $efi = new EfiPay(config('efi'));

        try {
            // Format amount as string with dot decimal (e.g. "25.90")
            $amount = number_format($this->quantity * $this->cardPrice, 2, '.', '');

            // Mercado Pago used a timestamp expiration; Efí uses seconds (e.g. 1800 = 30 min)
            $expirationSeconds = 30 * 60;

            // ---- 1) Create immediate charge (Cob) ----
            $body = [
                'calendario' => ['expiracao' => $expirationSeconds],
                'devedor'    => array_filter([
                    // Provide if you have them; Pix allows anonymous payer too
                    'nome' => empty($this->name) ? "Cliente" : $this->name,
                    'cpf'  => '17212309800', // if you collected it
                ]),
                'valor'      => ['original' => $amount],
                'chave'      => env('EFI_PIX_KEY'), // your Pix key (evp/cnpj/email)
                'solicitacaoPagador' => "Pagamento de Prêmios D'BILHAR",
            ];

            $cob = $efi->pixCreateImmediateCharge($params = [], $body);

            if ($cob['txid']) {
                // ---- 2) Generate QR for the charge location ----
                $locId = $cob['loc']['id'];
                $qr    = $efi->pixGenerateQRCode(['id' => $locId]);
                // Mirror Mercado Pago fields into your object:
                $this->payment_request_id = $cob['txid']; // Efí doesn’t give "payment id" like MP; use txid
                $this->qr_code_base64     = $qr['imagemQrcode'];  // base64 PNG (data:image/png;base64,...)
                $this->qr_code            = $qr['qrcode'];        // EMV payload string
                $this->ticket_url         = $qr['linkVisualizacao'] ?? null; // optional short link if present
                return true;
            } else {
                $this->notify($cob['error'] ?? 'Unknown error', "Error", "error");
                return false;
            }
            // Persist to DB (example if you're building an Order here)
            // \App\Models\Orders::create([... 'txid' => $txid, 'loc_id' => $locId, 'qr_code_text' => $qr['qrcode'], 'qr_code_base64' => $qr['imagemQrcode'], 'payment_status' => 0, ...]);


        } catch (EfiException $e) {
            $this->notify($e->getMessage(), "Error", "error");
            return false;
        } catch (\Throwable $e) {
            $this->notify($e->getMessage(), "Error", "error");
            return false;
        }
    }

    public function changeQuantity($amount = 1) {
        $this->quantity += $amount;
        $this->quantity = max($this->minimumPurchaseQuantity, $this->quantity);
    }

    private function createOrder() {
        $user_id = auth()->user()->id;

        $newOrder = [
            'user_id' => $user_id,
            'quantity' => $this->quantity,
            'price' => $this->quantity * $this->cardPrice,
            'payment_status' => 0,
            'payment_id' => $this->payment_request_id,
            'qr_code' => $this->qr_code,
            'qr_code_base64' => $this->qr_code_base64,
            'ticket_url' => $this->ticket_url
        ];
        if ($this->sellerId > 0) {
            $newOrder['seller_id'] = $this->sellerId;
        }
        // Create Orders
        $order = Orders::create($newOrder);

        // Fetch bingo cards according to random/sequential order setting
        $isRandomOrder = \App\Models\SiteSetting::isCardRandomOrder();
        $bingoCards = collect();
        $startSelling = \App\Models\SiteSetting::getStartSelling();
        if ($isRandomOrder) {
            // Fetch random unsold cards with id >= startSelling
            // $soldCardIds = OrderDetails::pluck('bingo_card_id')->toArray();
            // $bingoCards = BingoCards::whereNotIn('id', $soldCardIds)
            //     ->where('id', '>=', $startSelling)
            //     ->inRandomOrder()
            //     ->limit($this->quantity)
            //     ->get();
            $bingoCards = BingoCards::whereNotIn('id', function($query) {
                $query->select('bingo_card_id')->from('order_details');
            })
            ->where('id', '>=', $startSelling)
            ->inRandomOrder()
            ->limit($this->quantity)
            ->get();
        } else {
            // Fetch sequential cards after the largest sold card or startSelling-1
            $soldCardId = OrderDetails::max('bingo_card_id');
            $lastId = max($soldCardId ?? 0, $startSelling-1);
            $bingoCards = BingoCards::where('id', '>', $lastId)
                ->orderBy('id')
                ->limit($this->quantity)
                ->get();
        }

        foreach($bingoCards as $bingoCard) {
            OrderDetails::create([
                'order_id' => $order->id,
                'bingo_card_id' => $bingoCard->id,
                'user_id' => $user_id
            ]);
        }
    }

    public function processOrder() {
        // redirect to order list page
        $this->redirectRoute('order.list');
    }

    public function render()
    {
        return view('livewire.new-order');
    }
}
