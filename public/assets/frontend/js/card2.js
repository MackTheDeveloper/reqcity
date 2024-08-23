var stripeKey = document.querySelector('#card-element').dataset.consumerKey;
let stripe = Stripe(stripeKey)
let elements = stripe.elements()
let style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
}
let card = elements.create('card', {style: style})
card.mount('#card-element')
let paymentMethod = null
$('.card-form').on('submit', function (e) {
    e.preventDefault();
    console.log(card);
    $('button.pay').attr('disabled', true)
    if (paymentMethod) {
        return true
    }
    stripe.confirmCardSetup(
        "1",
        {
            payment_method: {
                card: card,
                billing_details: {name: $('.card_holder_name').val()}
            }
        }
    ).then(function (result) {
        console.log(result)
        if (result.error) {
            $('#card-errors').text(result.error.message)
            $('button.pay').removeAttr('disabled')
        } else {
            paymentMethod = result.setupIntent.payment_method
            $('.payment-method').val(paymentMethod)
            $('.card-form').submit()
        }
    })
    // return false
})