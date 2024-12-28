$(document).ready(function () {
    let stripe, elements, cardNumber, cardExpiry, cardCvc;

    if (window.selectedPayMethod === 'card') {
        stripe = Stripe(window.stripePublicKey);
        elements = stripe.elements();

        cardNumber = elements.create('cardNumber');
        cardNumber.mount('#card-number');

        cardExpiry = elements.create('cardExpiry');
        cardExpiry.mount('#card-expiry');

        cardCvc = elements.create('cardCvc');
        cardCvc.mount('#card-cvc');
    }

    $('#purchase-form').on('submit', async function (e) {
        e.preventDefault();

        if (!confirm('購入を確定しますか？')) return;
        // サーバーへ item_id と payment_method を送信し、PaymentIntent作成
        const initiateResponse = await fetch(window.purchaseInitiateUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken
            },
            body: JSON.stringify({
                item_id: window.itemId,
                payment_method: window.selectedPayMethod
            })
        });

        const initiateData = await initiateResponse.json();
        const clientSecret = initiateData.client_secret;
        const paymentIntentId = initiateData.payment_intent_id;
        // PaymentIntent はまだ requires_confirmation 状態（もしくはrequires_payment_method）なので、ここでconfirmCardPaymentを実行
        if (window.selectedPayMethod === 'card') {
            const { paymentIntent, error } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: { card: cardNumber }
            });

            completeOrder(paymentIntentId);

        } else {
            alert('購入が完了しました！');
        }
        

       
    });

    async function completeOrder(paymentIntentId) {
            const response = await fetch(window.purchaseConfirmUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                body: JSON.stringify({
                    paymentIntentId: paymentIntentId,
                    item_id: window.itemId
                })
            });
            console.log('bbbaa', response);

            const data = await response.json();

        if (data.success) {
            alert('購入が完了しました！');
            window.location.href = "/";
        } else {
            $('#card-errors').text(data.error || '注文確定に失敗しました。');
        }
        
    }
});
