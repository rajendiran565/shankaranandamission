<script>

var status = "<?php echo $payment_status; ?>"

alertresponse(status);

androidToast(status); 

function androidToast(status) {
    
Android.triggerToast('Payment'+status);

}

function alertresponse(status) {
    alert('Payment'+status);
}



</script>