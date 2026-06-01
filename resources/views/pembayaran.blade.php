<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Inspeksi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}">
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h3>Pembayaran Biaya Inspeksi</h3>
    <p>Total: <strong>Rp 300.000</strong></p>

    <div class="mt-4">
        <button id="pay-button" class="btn btn-dark">
            Bayar Sekarang
        </button>

        <a href="{{ route('jual2') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

<script>
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            window.location.href = "/payment/finish?order_id=" + result.order_id;
        },
        onPending: function(result){
            window.location.href = "/payment/finish?order_id=" + result.order_id;
        },
        onError: function(result){
            window.location.href = "/payment/failed";
        },
        onClose: function(){
            window.location.href = "/payment/failed";
        }
    });
</script>
</body>
</html>
