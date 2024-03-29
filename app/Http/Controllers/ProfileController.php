<?php

namespace App\Http\Controllers;


use App\Models\orders;
use App\Models\user;
use App\Models\payment;
use Illuminate\Support\Facades\Log;
use PayXpert\Connect2Pay\Connect2PayClient;
use PayXpert\Connect2Pay\containers\request\PaymentPrepareRequest;
use PayXpert\Connect2Pay\containers\Order;
use PayXpert\Connect2Pay\containers\Shipping;
use PayXpert\Connect2Pay\containers\Shopper;
use PayXpert\Connect2Pay\containers\Account;
use PayXpert\Connect2Pay\containers\constant\OrderType;
use PayXpert\Connect2Pay\containers\constant\PaymentMethod;
use PayXpert\Connect2Pay\containers\constant\PaymentMode;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class ProfileController extends Controller
{
    /**
     * redirect you to the payment page
     *
     * @return void
     */
    public function payment()
    {
        $connect2pay = "https://paiement.payzone.ma";
        $originator  = 107123;
        $password    = "6h8a@CzbVRzKex7x";
        $c2pClient = new Connect2PayClient($connect2pay, $originator, $password);
        $prepareRequest = new PaymentPrepareRequest();
        $shopper = new Shopper();
        $account = new Account();
        $order = new Order();
        $shipping = new Shipping();
        $user = Auth::user();
        $userOrder = orders::where('user_id', $user->id)->get();
        // Calculate the total price and quantity for the user's orders
        $total_price = $userOrder->sum('total_price');
        // Set all information for the payment
        $prepareRequest->setPaymentMethod(PaymentMethod::CREDIT_CARD);
        $prepareRequest->setPaymentMode(PaymentMode::SINGLE);
        $total_price_cn = intval($total_price * 100);
        $prepareRequest->setCurrency("MAD");
        $prepareRequest->setAmount($total_price_cn);
        $prepareRequest->setCtrlRedirectURL("https://6dc9-102-53-10-153.ngrok-free.app/redirect");
        $prepareRequest->setCtrlCallbackURL("https://6dc9-102-53-10-153.ngrok-free.app/costumercallback");
        $prepareRequest->setMerchantNotification(true);
        $order->setId($user->id); 
        $order->setType(OrderType::GOODS_SERVICE);
        $order->setDescription($total_price . "MAD"); 
        $shopper->setFirstName($user->name);   
        $shopper->setEmail($user->email); 
        $shopper->setAccount($account);
        $prepareRequest->setShopper($shopper);
        $prepareRequest->setOrder($order);
        $prepareRequest->setShipping($shipping);
        $result = $c2pClient->preparePayment($prepareRequest);

        if ($result !== false) {
            $merchantToken = Session::get('merchantToken');
            Session::put('merchantToken', $merchantToken);
            // The merchantToken must also be used later to validate the callback to avoid that anyone
            // could call it and abusively validate the payment. It may be stored in local database for this.
           
            // Now redirect the customer to the payment page
            return redirect()->away($c2pClient->getCustomerRedirectURL());
        } else {
            echo "Payment preparation error occurred: ";
        }
    }
    /**
     * redirect you to the merchant website after payment
     *
     * @return void
     */
    public function redirect()
    {
        return Redirect::to('/');
    }
    /**
     * the callback after payment
     * @param Request $request
     */

    public function costumercallback(Request $request)
    {
        $connect2pay = "https://paiement.payzone.ma/";
        $originator  = "107123";
        $password    = "6h8a@CzbVRzKex7x";

        // Extract data received from the payment page

        $c2pClient = new Connect2PayClient($connect2pay, $originator, $password);

        if ($c2pClient->handleCallbackStatus()) {
            // Get the PaymentStatus object
            $status = $request->status;
            // The payment status code
            $errorCode = $request->errorCode;
            // Custom data that could have been provided in ctrlCustomData when creating
            $merchantToken = $request->merchantToken;
            Log::info('Merchant Token: ' . $merchantToken);
            Log::error($merchantToken);
            // Get the last transaction processed for this payment
            $transaction = $request->transactions;
            $transactionJson = json_encode($transaction);
            $transactions = json_decode($transactionJson, true);

            Log::error($transactions[0]['transactionID']);
            $transactionId = null;
            if ($transaction !== null) {
                // The transaction ID generated for this payment
                $transactionId = $request->transactionId;
            }

            // /!\ /!\
            // The received callback must be authenticated by checking that the merchant
            // token matches with a previous known transaction. If this check is not done,
            // anyone can manipulate the payment status by providing fake data to this
            // script.
            // For example the merchant token can be stored with the application order
            // system (ctrlCustomData could also be used to authenticate in other ways)
            if ($merchantToken != null) {
                //add payment in database
                $transactionId = $request->transactionId;
                $user = Auth::user();
                Log::error($user);
                $payment = Payment::where('user_id', 1)->first();
                $payment->merchantToken = $merchantToken;
                $payment->TransactionId = $transactions[0]['transactionID'];
                $payment->paymentmethod = "credit card";
                $payment->save();
                // errorCode = 000 => payment transaction is successful
                if ($errorCode == '000') {
                } else {
                    // Add here the code in case the payment is denied
                }

                // Some debug statement example
                $log = "Received a new transaction status from " . $_SERVER["REMOTE_ADDR"] . ". Merchant token: " . $merchantToken . ", Status: " .
                    $status . ", Error code: " . $errorCode;
                if ($errorCode >= 0) {
                    $log .= ", Error message: " . $request->errorMessage; // $status->getErrorMessage();
                    $log .= ", Transaction ID: " . $transactionId;
                }
                syslog(LOG_INFO, $log);

                // Send back a response to mark this transaction as notified on the payment
                // page
                $response = array("status" => "OK", "message" => "Status recorded");
                header("Content-type: application/json");
                echo json_encode($response);
            } else {
                syslog(LOG_ERR, "Error. No order found for token " . $merchantToken . " in callback from " . $_SERVER["REMOTE_ADDR"] . ".");
            }
        } else {
            syslog(LOG_ERR, "Error. Received an incorrect status from " . $_SERVER["REMOTE_ADDR"] . ".");
        }

        // Send back a default error response
        $response = array("status" => "KO", "message" => "Error handling the callback");
        header("Content-type: application/json");
        echo json_encode($response);
    }
}
