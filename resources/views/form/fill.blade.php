@extends('layouts.main')
@section('title', __('Form'))
@section('breadcrumb')
<div class="col-md-12">
    <div class="page-header-title">
        <h4 class="m-b-10">{{ __('Fill Forms') }}</h4>
    </div>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('forms.index') }}">{{ __('Form') }}</a></li>
        <li class="breadcrumb-item"> {{ __('Fill') }} </li>
    </ul>
</div>
@endsection
@section('content')

            @include('form.multi_form')

@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jqueryform/css/demo.css') }}">
    <link href="{{ asset('vendor/jqueryform/css/jquery.rateyo.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    <style>
        /* Mark input boxes that gets an error on validation: */
        /* input.invalid {background-color: #ffdddd; } */

        .invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        #prevBtn {
            background-color: #bbbbbb;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #394EEA;
        }

    </style>
@endpush

@push('script')
    <script src="{{ asset('vendor/jqueryform/js/jquery.rateyo.min.js') }}"></script>
    <script src="{{ asset('vendor/js/jquery.payment.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/dist/js/select2.full.min.js') }}"></script>



    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID') }}&currency={{ $form->currency_name }}">
    </script>
    <script>
        var form_value_id = $('#form_value_id').val();
        var SITEURL = '{{ URL::to('') }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        ('restrictNumeric');
        $('.cc-number').payment('formatCardNumber');
        $('.cc-exp').payment('formatCardExpiry');
        $('.cc-cvc').payment('formatCardCVC');


        $.fn.toggleInputError = function(erred) {
            this.parent('.form-group').toggleClass('has-error', erred);
            return this;
        };




        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab


        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                $('.cap').show();
                $('.strip').show();
                $('.razorpay').show();
                $('.paypal').show();


                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                $('.cap').hide();
                $('.strip').hide();
                $('.razorpay').hide();
                $('.paypal').hide();


                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            $('.step-' + currentTab).find('.tel').each(function() {
                if ($(this).attr('type') == 'tel') {
                    var tel = $(this).val();
                    var filter = /^\d*(?:\.\d{1,2})?$/;
                    if (filter.test(tel)) {
                        valid = true;
                    } else {
                        valid = false;
                        $(this).addClass('invalid');
                        return false;
                    }
                }
            });
            $('.step-' + currentTab).find('.email').each(function() {
                if ($(this).attr('type') == 'email') {
                    var emailStr = $(this).val();
                    var regex = /^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i;
                    if (regex.test(emailStr)) {
                        valid = true;
                    } else {
                        $(this).addClass('invalid');
                        valid = false;
                        return false;
                    }
                }
            });
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            $('.tab').hide();
            // x[currentTab].style.display = "none";

            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            // alert(x.length);
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                var formData = new FormData($('#fill-form')[0]);
                var $this = $("#nextBtn");
                var loadingText = '<i class="ti ti-circle-dashed"></i> Submiting form';
                if ($("#nextBtn").html() !== loadingText) {
                    $this.data('original-text', $("#nextBtn").html());
                    $this.html(loadingText);
                }
                @if ($form->payment_type == 'paypal')
                    if($('#payment_id').val() == ''){
                    var errorElement = document.getElementById('paypal-errors');
                    notifier.show('Error!', "{{ __('Please make payment') }}", 'danger', '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
                    $('#nextBtn').removeAttr('disabled');
                        $('#nextBtn').html(' Submit')
                        showTab(n);

                    return false;

                    }
                @endif
                make_payment();
                setLoading(false);
                // $("#fill-form").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {

            var valid = true;
            $('.step-' + currentTab).find('.required').each(function() {
                var name = $(this).attr('name');
                if ($(this).val() == "") {
                    $(this).addClass('invalid');

                    valid = false;
                } else {
                    valid = true;
                }
                if ($(this).attr('type') == 'email') {
                    var emailStr = $(this).val();
                    var regex = /^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i;
                    if (regex.test(emailStr)) {
                        valid = true;
                    } else {
                        $(this).addClass('invalid');
                        valid = false;
                        return false;
                    }
                }
                if ($(this).attr('type') == 'tel') {
                    var tel = $(this).val();
                    var filter = /^\d*(?:\.\d{1,2})?$/;
                    if (filter.test(tel)) {
                        valid = true;
                    } else {
                        $(this).addClass('invalid');
                        valid = false;
                            return false;
                    }
                }
                if ($(this).attr('type') == 'radio') {
                    if ($('input[name="' + name + '"]:checked').length <= 0) {
                        $(this).addClass('invalid');
                        $('.required-msg').html('Select any one');
                        valid = false;
                    } else {
                        valid = true;

                    }
                }
                if ($(this).attr('type') == 'checkbox') {

                    if ($('input[name="' + name + '"]:checked').length <= 0) {

                        $(this).addClass('invalid');
                        $('.required-msg').html('Select any one');
                        valid = false;
                    } else {
                        valid = true;

                    }
                }
                if ($(this).attr('type') == 'number') {
                    if ($(this).val() == "") {
                        $(this).addClass('invalid');
                        valid = false;
                    } else {
                        valid = true;

                    }
                }
                if ($(this).attr('type') == 'file') {
                    var inp = $(this).attr('name');

                    if (inp.length == 0) {
                        $(this).addClass('invalid');
                        valid = false;
                        alert("Attachment Required");
                        inp.focus();

                    } else {
                        valid = true;

                    }
                }

            });
            // alert(valid);
            if (valid) {
                $('.step-' + currentTab).addClass('finish');
                // document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function make_payment() {
            var formData = new FormData($('#fill-form')[0]);
            if (form_value_id == '') {

                @if ($form->payment_status == 1)
                    @if ($form->payment_type == 'stripe')
                        stripe.createToken(card).then(function(result) {
                        if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                        } else {
                        formData.append('stripeToken', result.token.id);
                        }
                        }).then(function(){
                        submitForm(formData);
                        });
                    @elseif ($form->payment_type == 'razorpay')
                        var amount = '{{ $form->amount }}';
                        var name = '{{ $form->title }}';
                        var currency = '{{ $form->currency_name }}';
                        var form_id = '{{ $form->id }}';


                        var data = {
                        "_token": "{{ csrf_token() }}",
                        'price': amount,
                        'name': name,
                        'currency': currency,
                        'form_id': form_id,

                        }
                        // console.log(data);

                        var options = {
                        "key": "{{ env('RAZORPAY_KEY') }}",
                        "amount": (amount * 100),
                        "name": name,
                        'currency': currency,
                        "description": "",
                        "image": '',
                        "handler": function(response) {
                        console.log(response);
                        // $('#payment_id').val(response.razorpay_payment_id);
                        formData.append('payment_id', response.razorpay_payment_id);

                        submitForm(formData);

                        // var data =
                        '{{ Crypt::encrypt(['payment_id' => ',response.razorpay_payment_id,','plan_id' => 'plan_id','request_user_id' => 'user_id','order_id' => 'order_id','type' => 'razorpay']) }}';

                        // window.location.href = SITEURL + '/' + 'pre-payment-success/' + data;
                        },
                        "theme": {
                        "color": "#528FF0"
                        }
                        };
                        // console.log(options);

                        // setLoading(true);
                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                        // e.preventDefault();
                    @else
                        submitForm(formData);
                    @endif
                @else
                    submitForm(formData);
                @endif
            } else {
                submitForm(formData);
            }
        }

        function submitForm(formData) {
            formData.append('ajax', true);
            $.ajax({
                type: "POST",
                url: '{{ route('forms.fill.store', $form->id) }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    if (response.is_success) {
                        $('.card-body').html(
                            '<div class="text-center gallery" id="success_loader"> <img src="{{ asset('assets/images/success.gif') }}" class="" /><br><br><h2 class="w-100 ">' +
                            response.message + '</h2></div>');
                        // alert('here');

                        $('#nextBtn').removeAttr('disabled');
                        $('#nextBtn').html(' Submit');
                    } else {
                        notifier.show('Error!',response.message, 'danger', '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
                        $('#nextBtn').removeAttr('disabled');
                        $('#nextBtn').html(' Submit')
                        showTab(0);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        $(document).on("click", "input[type='checkbox']", function() {
            var name = $(this).attr('name');
            checkCheckbox(name);
        });
        $("body input[type='checkbox']").each(function(i, item) {
            var name = $(item).attr('name');
            checkCheckbox(name);
        });

        function checkCheckbox(name) {

            if ($("input[name='" + name + "']:checked").length) {
                $("input[name='" + name + "']").removeAttr('required');
            } else {
                $("input[name='" + name + "']").attr('required', 'required');
            }
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $("#setData").trigger('click');
            }, 30);

        });


        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'Select Option',
                    searchPlaceholderValue: 'Select Option',
                });
            }
        });



        $(function() {
            $(document).on("submit", "#fill-form", function(e) {

                e.preventDefault();
                var $this = $("#nextBtn");
                var loadingText = '<i class="ti ti-circle-dashed"></i> Submiting form';
                if ($("#nextBtn").html() !== loadingText) {
                    $this.data('original-text', $("#nextBtn").html());
                    $this.html(loadingText);
                }
                var formData = new FormData($('#fill-form')[0]);


                if (form_value_id == '') {
                    @if ($form->payment_status == 1)
                        @if ($form->payment_type == 'stripe')
                            stripe.createToken(card).then(function(result) {
                            if (result.error) {
                            // Inform the user if there was an error
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                            } else {
                            formData.append('stripeToken', result.token.id);
                            }
                            }).then(function(){
                            submitForm(formData);
                            });
                        @elseif ($form->payment_type == 'razorpay')
                            var amount = '{{ $form->amount }}';
                            var name = '{{ $form->title }}';
                            var currency = '{{ $form->currency_name }}';
                            var form_id = '{{ $form->id }}';


                            var data = {
                            "_token": "{{ csrf_token() }}",
                            'price': amount,
                            'name': name,
                            'currency': currency,
                            'form_id': form_id,


                            }
                            // console.log(data);



                            var options = {
                            "key": "{{ env('RAZORPAY_KEY') }}",
                            "amount": (amount * 100),
                            "name": name,
                            "description": "",
                            "image": '',
                            "handler": function(response) {
                            console.log(response);
                            // $('#payment_id').val(response.razorpay_payment_id);
                            formData.append('payment_id', response.razorpay_payment_id);

                            submitForm(formData);

                            // var data =
                            '{{ Crypt::encrypt(['payment_id' => ',response.razorpay_payment_id,','plan_id' => 'plan_id','request_user_id' => 'user_id','order_id' => 'order_id','type' => 'razorpay']) }}';

                            // window.location.href = SITEURL + '/' + 'pre-payment-success/' + data;
                            },
                            "theme": {
                            "color": "#528FF0"
                            }
                            };
                            // console.log(options);

                            // setLoading(true);
                            var rzp1 = new Razorpay(options);
                            rzp1.open();
                            // e.preventDefault();
                        @else
                            submitForm(formData);
                        @endif
                    @else
                        submitForm(formData);
                    @endif
                } else {
                    submitForm(formData);
                }

            });


        });
    </script>
    <script>
        $(document).ready(function() {
            $(".custom_select").select2();
        })
        var $starRating = $('.starRating');
        if ($starRating.length) {
            $starRating.each(function() {
                var val = $(this).attr('data-value');
                var num_of_star = $(this).attr('data-num_of_star');
                $(this).rateYo({
                    rating: val,
                    halfStar: true,
                    numStars: num_of_star,
                    precision: 2,
                    onSet: function(rating, rateYoInstance) {
                        num_of_star = $(rateYoInstance.node).attr('data-num_of_star');
                        var input = ($(rateYoInstance.node).attr('id'));
                        if (num_of_star == 10) {
                            rating = rating * 2;
                        }
                        $('input[name="' + input + '"]').val(rating);
                    }
                })
            });
        }
        if ($(".ck_editor").length) {
            CKEDITOR.replace($('.ck_editor').attr('name'), {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
        }
    </script>
    @if ($form->payment_status == 1)
        <script>
            var stripe, card;
            $(document).ready(function() {

                @if ($form->payment_status == 1)
                    @if ($form->payment_type == 'stripe')
                        stripe = Stripe('{{ env('STRIPE_KEY') }}');
                        var elements = stripe.elements();
                        var style = {
                        base: {
                        color: '#32325d',
                        lineHeight: '24px',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '18px',
                        '::placeholder': {
                        color: '#aab7c4'
                        }
                        },
                        invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                        }
                        };
                        // Create an instance of the card Element
                        card = elements.create('card', {
                        style: style
                        });
                        // Add an instance of the card Element into the `card-element` <div>
                            card.mount('#card-element');
                            // Handle real-time validation errors from the card Element.
                            card.addEventListener('change', function(event) {
                            var displayError = document.getElementById('card-errors');
                            if (event.error) {
                            displayError.textContent = event.error.message;
                            } else {
                            displayError.textContent = '';
                            }
                            });
                    @endif
                    @if ($form->payment_type == 'paypal')
                        var amount = '{{ $form->amount }}';
                        var name = '{{ $form->title }}';
                        var currency = '{{ $form->currency_name }}';
                        var form_id = '{{ $form->id }}';

                        paypal.Buttons({

                        // Set up the transaction
                        createOrder: function(data, actions) {
                        return actions.order.create({
                        purchase_units: [{
                        amount: {
                        value: amount
                        }
                        }]
                        });
                        },

                        // Finalize the transaction
                        onApprove: function(data, actions) {
                        return actions.order.capture().then(function(orderData) {
                        // Successful capture! For demo purposes:
                        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                        var transaction = orderData.purchase_units[0].payments.captures[0];

                        // alert(transaction.id);
                        // alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                        // var formData = new FormData($('#fill-form')[0]);
                        // formData.append('payment_id', transaction.id);

                        $('#payment_id').val(transaction.id);

                        var errorElement = document.getElementById('paypal-errors');
                        errorElement.textContent = '';

                        $('#paypal-button-container').html('')

                        // submitForm(formData);
                        // Replace the above to show a success message within this page, e.g.
                        // const element = document.getElementById('paypal-button-container');
                        // element.innerHTML = '';
                        // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                        // Or go to another URL: actions.redirect('thank_you.html');
                        });
                        }


                        }).render('#paypal-button-container');
                    @endif
                @endif

            })
        </script>
           <script>
            document.addEventListener('DOMContentLoaded', function() {
                var genericExamples = document.querySelectorAll('[data-trigger]');
                for (i = 0; i < genericExamples.length; ++i) {
                    var element = genericExamples[i];
                    new Choices(element, {
                        placeholderValue: 'Select Option',
                        searchPlaceholderValue: 'Select Option',
                    });
                }
            });
        </script>
        <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
        <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    @endif
@endpush
