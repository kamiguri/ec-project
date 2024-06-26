<p>決済ページにリダイレクトします。<p>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const publicKey = '{{ $publicKey }}'
        const stripe = Stripe(publicKey)

        window.onload = () => {
            stripe.redirectToCheckout({
                sessionId: '{{ $checkout_session->id }}'
            }).then(result => {
                window.location.href = '{{ route('index') }}';
            })
        }

    </script>
