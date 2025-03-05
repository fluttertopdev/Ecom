<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stripe Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        #card-element {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Stripe Payment</h2>
    <form id="payment-form">
        <input type="hidden" id="amount" value="10"> <!-- Amount in USD -->
        <div id="card-element"></div>
        <button id="submit-button">Pay Now</button>
    </form>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
    if (!window.Stripe) {
        console.error("Stripe.js failed to load!");
        return;
    }

    const stripe = Stripe('pk_test_51OhmuuJYPu5h8N8f1vYGxpHyxliqz77ghUX4k8umvwG4MvPMrTOH6Dt10yRQ4Ce1d32aNBl15Yrgh58SDxLFdFdz00POrhCOeT');
    const elements = stripe.elements();
    const card = elements.create("card");
    card.mount("#card-element");

    document.getElementById("payment-form").addEventListener("submit", async function (e) {
        e.preventDefault();
        const amount = document.getElementById("amount").value;
         alert(amount)
        try {
            // Check for CSRF token
            const csrfMetaTag = document.querySelector('meta[name="csrf-token"]');
            if (!csrfMetaTag) {
                console.error("CSRF token meta tag is missing!");
                alert("CSRF token not found. Make sure it's included in your HTML head.");
                return;
            }

            const csrfToken = csrfMetaTag.getAttribute("content");

            const response = await fetch("/NewEcom/create-payment-intent", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ amount: amount })
            });

            const data = await response.json();

            if (data.error) {
                alert("Payment error: " + data.error.message);
                return;
            }

            const clientSecret = data.client_secret;

            if (!clientSecret) {
                console.error("Error: No client_secret received");
                return;
            }

            const result = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card
                }
            });

            if (result.error) {
                alert(result.error.message);
            } else if (result.paymentIntent.status === "succeeded") {
                alert("Payment Successful!");
            }
        } catch (error) {
            console.error("Error processing payment:", error);
        }
    });
});
    </script>
</body>
</html>
