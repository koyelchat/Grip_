<?php
require_once('razorpay-php/Razorpay.php'); // Include the Razorpay PHP library

use Razorpay\Api\Api;

$api_key = "rzp_test_wAy2wJE0eGygch";
$api_secret = "YlRuNWUq9uJkh5lzIyiUzNtL";
$api = new Api($rzp_test_wAy2wJE0eGygch, $YlRuNWUq9uJkh5lzIyiUzNtL); // Initialize the Razorpay API with your API key and secret

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donation_amount = $_POST["amount"]; // Get the donation amount from the form

    // Create a Razorpay order
    $order = $api->order->create([
        'amount' => $donation_amount * 100, // Razorpay accepts amount in paisa, so convert the amount to paisa
        'currency' => 'INR',
        'payment_capture' => 1,
        'notes' => [
            'purpose' => 'Donation'
        ]
    ]);

    $order_id = $order->id; // Get the Razorpay order ID

    // Display the payment form with the Razorpay order ID
    <form action="" method="POST">
              <script src="https://checkout.razorpay.com/v1/checkout.js"
                      data-key=" <? php echo $api_Key;?> "
                      data-amount= " . $donation_amount * 100 . "
                      data-currency='INR'
                      data-order_id='" . $order_id . "'
                      data-buttontext='Donate'
                      data-name='My Donation Page'
                      data-description='Donation'
                      data-image='https://example.com/logo.png'
                      data-prefill.name='John Doe'
                      data-prefill.email='johndoe@example.com'
                      data-theme.color='#F37254'>
              </script>
              <input type='hidden' name='razorpay_order_id' value='" . $order_id . "'>
              <input type='hidden' name='donation_amount' value='" . $donation_amount . "'>
          </form>";
} else {
    // Display the donation form
    echo "<form action='donation.php' method='POST'>
              <label for='amount'>Donation Amount:</label>
              <input type='number' name='amount' id='amount'>
              <button type='submit'>Donate</button>
          </form>";
}

if (isset($_POST['razorpay_order_id']) && isset($_POST['donation_amount'])) {
    $razorpay_order_id = $_POST['razorpay_order_id'];
    $donation_amount = $_POST['donation_amount'];

    $payment_id = $_POST['razorpay_payment_id'];
    $signature = $_POST['razorpay_signature'];

    // Verify the payment signature
    $attributes = array(
        'razorpay_order_id' => $razorpay_order_id,
        'razorpay_payment_id' => $payment_id,
        'razorpay_signature' => $signature
    );
    if ($payment->status == 'captured') {
        // Payment successful, redirect to home page
        header('Location: https://rzp.io/l/lwXtj3M12');
        exit();
    } else {
        // Payment failed, display error message
        echo 'Payment failed. Please try again.';
    }
}
?>
