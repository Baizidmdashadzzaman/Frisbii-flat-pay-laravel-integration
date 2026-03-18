<!DOCTYPE html>
<html>
<head>
    <title>Pay Now</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 50px; }
        .container { max-width: 500px; margin: auto; text-align: center; }
        button { padding: 15px 30px; font-size: 16px; cursor: pointer; }
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        .alert-error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Payment Page</h2>

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <p>Amount: 1 DKK</p>

        <form action="{{ route('pay') }}" method="GET">
            <button type="submit">Pay with Frisbii</button>
        </form>
    </div>
</body>
</html>