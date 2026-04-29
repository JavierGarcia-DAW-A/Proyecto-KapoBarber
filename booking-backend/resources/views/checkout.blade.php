<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - KapoBarber</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body { background-color: #1a1a1a; color: #fff; font-family: 'Inter', sans-serif; }
        .wizard-container { max-width: 800px; margin: 50px auto; background: #262626; padding: 40px; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .step-indicator { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; position: relative; }
        .step-indicator::before { content: ''; position: absolute; top: 20px; left: 0; width: 100%; height: 2px; background: #444; z-index: 1; }
        .step { position: relative; z-index: 2; text-align: center; flex: 1; }
        .step .circle { width: 40px; height: 40px; background: #444; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: bold; transition: all 0.3s; }
        .step.active .circle { background: #dcaa63; color: #111; box-shadow: 0 0 10px #dcaa63; }
        .step.completed .circle { background: #dcaa63; color: #111; }
        .step .label { font-size: 14px; color: #aaa; transition: all 0.3s; }
        .step.active .label, .step.completed .label { color: #dcaa63; }
        .form-control { background: #111; border: 1px solid #333; color: #fff; }
        .form-control:focus { background: #111; border-color: #dcaa63; color: #fff; box-shadow: 0 0 5px rgba(220,170,99,0.5); }
        .btn-primary { background-color: #dcaa63; border-color: #dcaa63; color: #111; font-weight: bold; }
        .btn-primary:hover { background-color: #c49654; border-color: #c49654; color: #000; }
        .btn-secondary { background-color: #444; border-color: #444; color: #fff; }
        .btn-secondary:hover { background-color: #555; border-color: #555; }
        .step-content { display: none; }
        .step-content.active { display: block; animation: fadeIn 0.5s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        /* Stripe Elements */
        #card-element { background: #111; padding: 15px; border-radius: 5px; border: 1px solid #333; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container">
    <div class="wizard-container" style="position: relative;">
        <!-- Botón Salir -->
        <a href="/Proyecto-KapoBarber/shop/" style="position: absolute; top: 15px; right: 20px; color: #94a3b8; text-decoration: none; font-size: 14px; font-weight: bold;">&#10005; Cancel and Exit</a>

        <h2 class="text-center mb-4" style="color: #dcaa63; margin-top: 10px;">Checkout - {{ $productName }}</h2>
        
        <div class="step-indicator">
            <div class="step active" id="indicator-1"><div class="circle">1</div><div class="label">Details</div></div>
            <div class="step" id="indicator-2"><div class="circle">2</div><div class="label">Review</div></div>
            <div class="step" id="indicator-3"><div class="circle">3</div><div class="label">Payment</div></div>
            <div class="step" id="indicator-4"><div class="circle">4</div><div class="label">Confirmation</div></div>
        </div>

        <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_name" value="{{ $productName }}">
            <input type="hidden" name="price" value="{{ $price }}">

            <!-- Paso 1: Datos -->
            <div class="step-content active" id="step-1">
                <h4>Shipping Information</h4>
                <div class="mb-3">
                    <label>Full Name</label>
                    <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" readonly>
                </div>
                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" readonly>
                </div>
                <div class="mb-3">
                    <label>Shipping Address</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="e.g. 123 Main St" required>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-primary" onclick="nextStep(1)">Next</button>
                </div>
            </div>

            <!-- Paso 2: Revisión -->
            <div class="step-content" id="step-2">
                <h4>Order Review</h4>
                <div class="card bg-dark text-light border-secondary mb-4">
                    <div class="card-body">
                        <p><strong>Product:</strong> {{ $productName }}</p>
                        <p><strong>Total Price:</strong> ${{ $price }}</p>
                        <hr class="border-secondary">
                        <p><strong>Ship to:</strong> <span id="review-address"></span></p>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Back</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(2)">Proceed to Payment</button>
                </div>
            </div>

            <!-- Paso 3: Pago -->
            <div class="step-content" id="step-3">
                <h4>Payment Method</h4>
                <p class="text-muted small">Test mode (Stripe Test Mode). Use card 4242 4242...</p>
                <div id="card-element"></div>
                <div id="card-errors" role="alert" style="color: #f87171; margin-bottom: 15px;"></div>
                
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(3)">Back</button>
                    <button type="submit" class="btn btn-primary" id="submit-btn">Pay ${{ $price }}</button>
                </div>
            </div>

            <!-- Paso 4: Confirmación -->
            <div class="step-content" id="step-4">
                <div class="text-center">
                    <h1 style="color: #dcaa63; font-size: 60px;">&#10003;</h1>
                    <h4>Payment Completed!</h4>
                    <p>Your order has been placed successfully.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Go to my orders</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let currentStep = 1;

    function nextStep(step) {
        if (step === 1) {
            const addr = document.getElementById('address').value;
            if (!addr) { alert('Please enter your address.'); return; }
            document.getElementById('review-address').innerText = addr;
        }
        document.getElementById(`step-${step}`).classList.remove('active');
        document.getElementById(`indicator-${step}`).classList.add('completed');
        
        currentStep = step + 1;
        document.getElementById(`step-${currentStep}`).classList.add('active');
        document.getElementById(`indicator-${currentStep}`).classList.add('active');
    }

    function prevStep(step) {
        document.getElementById(`step-${step}`).classList.remove('active');
        document.getElementById(`indicator-${step}`).classList.remove('active');
        document.getElementById(`indicator-${step-1}`).classList.remove('completed');
        
        currentStep = step - 1;
        document.getElementById(`step-${currentStep}`).classList.add('active');
    }

    // Stripe Setup (Ficticio)
    const stripe = Stripe('pk_test_TYooMQauvdEDq54NiTphI7jx'); // Stripe test key public
    const elements = stripe.elements();
    const style = {
      base: { color: "#fff", fontFamily: 'Inter, sans-serif', fontSmoothing: "antialiased", fontSize: "16px", "::placeholder": { color: "#aab7c4" } },
      invalid: { color: "#fa755a", iconColor: "#fa755a" }
    };
    const card = elements.create("card", { style: style });
    card.mount("#card-element");

    const form = document.getElementById('checkout-form');
    form.addEventListener('submit', async function(ev) {
        ev.preventDefault();
        document.getElementById('submit-btn').disabled = true;
        document.getElementById('submit-btn').innerText = 'Processing...';

        // Fake createToken for testing
        const {token, error} = await stripe.createToken(card);

        if (error) {
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            document.getElementById('submit-btn').disabled = false;
            document.getElementById('submit-btn').innerText = 'Pay ${{ $price }}';
        } else {
            // Send token to backend via fetch
            const formData = new FormData(form);
            formData.append('stripeToken', token.id);

            fetch('{{ route('checkout.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            }).then(response => response.json())
              .then(data => {
                  if(data.success) {
                      // Move to confirmation step
                      document.getElementById(`step-3`).classList.remove('active');
                      document.getElementById(`indicator-3`).classList.add('completed');
                      document.getElementById(`step-4`).classList.add('active');
                      document.getElementById(`indicator-4`).classList.add('active');
                  } else {
                      alert('Error processing payment');
                      document.getElementById('submit-btn').disabled = false;
                  }
              });
        }
    });
</script>

</body>
</html>
