@extends('layout.layout')

@section('title', 'Frequently Asked Questions')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="text-center mb-5">Frequently Asked Questions</h1>
            
            <div class="accordion" id="faqAccordion">
                <!-- FAQ Item 1 -->
                <div class="accordion-item mb-3 border">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            How do I place an order?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            To place an order, browse our products, select the items you want, add them to your cart, and proceed to checkout. Follow the instructions to complete your purchase.
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="accordion-item mb-3 border">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            What payment methods do you accept?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We accept various payment methods including credit/debit cards and online banking through our secure payment gateway.
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="accordion-item mb-3 border">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            How long does shipping take?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Shipping typically takes 3-5 business days for domestic orders and 7-14 business days for international orders, depending on your location.
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="accordion-item mb-3 border">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            What is your return policy?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We offer a 30-day return policy. If you're not satisfied with your purchase, you can return it within 30 days for a full refund or exchange.
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 5 -->
                <div class="accordion-item mb-3 border">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            How can I track my order?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Once your order is shipped, you will receive a tracking number via email. You can use this number to track your package on our website or the courier's website.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .accordion-button:not(.collapsed) {
        background-color: rgba(15, 44, 31, 0.05);
        color: #0f2c1f;
    }
    
    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(15, 44, 31, 0.25);
        border-color: rgba(15, 44, 31, 0.5);
    }
    
    .accordion-item {
        border-radius: 0 !important;
        overflow: hidden;
    }
</style>
@endsection