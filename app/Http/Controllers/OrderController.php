<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    protected $placetopay;

    public function __construct() 
    {
        // Fetch the Site Settings object
        $this->placetopay = new \Dnetix\Redirection\PlacetoPay([
            'login' => '6dd490faf9cb87a9862245da41170ff2', // Provided by PlacetoPay
            'tranKey' => '024h1IlD', // Provided by PlacetoPay
            'baseUrl' => 'https://dev.placetopay.com/redirection/',
            'timeout' => 10, // (optional) 15 by default
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->remembered_user == 0){
            $user = new User($request->all());
            $user->email = $request->hidden_email;
            $user->save();
        }else{
            $user = User::find($request->remembered_user);
        }

        $order = new Order();
        $order->user_id = $user->id;
        $order->product_id = 1;
        $order->amount = 50;
        $order->status = 'CREATED';
        $order->save();

        $reference = 'Payment_'.$order->id;
        $paymentRequest = [
            'payment' => [
                'reference' => $reference,
                'description' => 'Pago en Shop Test',
                'amount' => [
                    'currency' => 'USD',
                    'total' => $order->amount,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => 'http://localhost:8000/orders/payment-response/'.$reference,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];

        $response = $this->placetopay->request($paymentRequest);
        if ($response->isSuccessful()) {
            // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
            // Redirect the client to the processUrl or display it on the JS extension
            /*$response->processUrl();*/
            $order->payment_id = $response->requestId();
            $order->payment_url = $response->processUrl();
            $order->save();
        }else {
            // There was some error so check the message and log it
            \Log::info('Error al crear pago con PlacetoPay'. $response->status()->message());
        }

        return redirect()->route('orders.show', $order->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('id', '=', $id)
                    ->with('user', 'product')
                    ->first();

        return view('step2')->with(compact('order'));
    }

    /**
     * Url de retorno al finalizar el pago en wl Web Checkout de PlacetoPay
     *
     * @param  string  $reference
     * @return \Illuminate\Http\Response
     */
    public function payment_response($reference){
        $orderId = explode("_", $reference);
        $order = Order::find($orderId[1]);

        $response = $this->placetopay->query($order->payment_id);

        if ($response->isSuccessful()) {
            // In order to use the functions please refer to the Dnetix\Redirection\Message\RedirectInformation class
            if ($response->status()->isApproved()) {
                // The payment has been approved
                $order->status = 'PAYED';
                $order->payed_at = date('Y-m-d H:i:s');
                $order->save();

                return redirect()->route('orders.show', $order->id);
            }
        } else {
            // There was some error with the connection so check the message
            \Log::info('Error al consultar un pago con PlacetoPay'. $response->status()->message());
        }
    }
}
