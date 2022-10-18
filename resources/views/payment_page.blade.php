<script src="https://secure-egypt.paytabs.com/payment/js/paylib.js"></script>
<form action="{{route('after_payment')}}" id="payform" method="post">
    <span id="paymentErrors"></span>
    @csrf
    <div class="row">
        <label>Card Number</label>
        <input type="text" data-paylib="number" size="20">
    </div>
    <div class="row">
        <label>Expiry Date (MM/YYYY)</label>
        <input type="text" data-paylib="expmonth" size="2">
        <input type="text" data-paylib="expyear" size="4">
    </div>
    <div class="row">
        <label>Security Code</label>
        <input type="text" data-paylib="cvv" size="4">
    </div>
    <input type="submit" value="Place order">
</form>

<script type="text/javascript">
    var myform = document.getElementById('payform');

    paylib.inlineForm({
        'key': 'CDKMVV-6QBH6T-G676QK-2H9BRK',
        'form': myform,
        'theme': '2639',

        'autoSubmit': true,
        'callback': function(response) {
            document.getElementById('paymentErrors').innerHTML = '';
            if (response.error) {
                paylib.handleError(document.getElementById('paymentErrors'), response);
            }
        }
    });
</script>
