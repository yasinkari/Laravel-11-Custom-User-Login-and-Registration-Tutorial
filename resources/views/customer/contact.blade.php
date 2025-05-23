@extends('layout.layout')

@section('title', 'Contact Us')

@section('content')
<div class="container-fluid px-0">
    <!-- Hero Section -->
    <!-- Hero Section with Carousel -->
    <div class="contact-hero position-relative">
        <div id="contactCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#contactCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#contactCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#contactCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="carousel-image-container">
                        <img src="{{ asset('storage/product_images/DyF02AbGakdPrETCZiV4bg8y6jl8tD0kX2882AgB.jpg') }}" 
                             class="carousel-image" alt="NILL Collection 1">
                    </div>
                    <div class="carousel-overlay"></div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-image-container">
                        <img src="{{ asset('storage/product_images/JnM8tq2vEwu6JHPNjtupH7H2J8vEKAO97TpfPeh8.jpg') }}" 
                             class="carousel-image" alt="NILL Collection 2">
                    </div>
                    <div class="carousel-overlay"></div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-image-container">
                        <img src="{{ asset('storage/product_images/2KZJoJoynrUYbX984XD40XqS4lOEM3FNKqlvh5pW.jpg') }}" 
                             class="carousel-image" alt="NILL Collection 3">
                    </div>
                    <div class="carousel-overlay"></div>
                </div>
            </div>
            
            <style>
            /* Updated styles to properly align images */
            .contact-hero {
                height: 100%;
                position: relative;
                overflow: hidden;
                margin: 0;
                padding: 0;
            }
            
            .carousel, .carousel-inner, .carousel-item {
                height: 100%;
                width: 100%;
            }
            
            .carousel-image-container {
                width: 100%;
                height: 100%;
                overflow: hidden;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .carousel-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }
            
            .carousel-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.5));
            }
            
            /* Ensure no conflicting styles */
            .contact-hero::before,
            .contact-hero .overlay {
                display: none;
            }
            
            @media (max-width: 768px) {
                .contact-hero {
                    height: 450px;
                }
            }
            </style>
            <button class="carousel-control-prev" type="button" data-bs-target="#contactCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#contactCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    
        <div class="contact-content position-absolute w-100 h-100 d-flex align-items-center justify-content-center">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h1 class="display-4 text-white fw-bold mb-3">Get in Touch</h1>
                        <p class="lead text-white mb-4 px-4">Your satisfaction is our priority. Let us know how we can assist you.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#contact-section" class="btn btn-light px-4 py-2">Contact Us</a>
                            <a href="#business-hours" class="btn btn-outline-light px-4 py-2">Business Hours</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<style>
/* Additional styles to ensure content aligns with carousel images */
.contact-content {
    z-index: 10;
    top: 0;
    left: 0;
    /* background: rgba(0,0,0,0.2); */
}

.contact-content .container {
    max-width: 1200px;
}

.contact-content h1 {
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.contact-content p {
    text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    max-width: 700px;
    margin: 0 auto;
}

.contact-content .btn {
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}
</style>
    </div>

    <!-- Add this to your existing style section -->
    <style>
    .contact-hero {
        /* background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),  */
                    /* url('{{ asset('image/contact-bg.jpg') }}') center/cover no-repeat fixed; */
        padding: 0;
        margin-top: -2rem;
        position: relative;
        overflow: hidden;
    }

    .contact-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        /* background: linear-gradient(45deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 100%); */
    }

    .contact-hero .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        /* background: rgba(0,0,0,0.2); */
    }

    .z-index-1 {
        position: relative;
        z-index: 1;
    }

    .contact-hero h1 {
        font-size: 3.5rem;
        letter-spacing: -1px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .contact-hero p {
        font-size: 1.25rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        max-width: 800px;
        margin: 0 auto;
    }

    .contact-hero .btn {
        font-weight: 500;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .contact-hero .btn-light:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
    }

    .contact-hero .btn-outline-light:hover {
        background-color: rgba(255,255,255,0.1);
        transform: translateY(-2px);
    }
    </style>

    <div class="container">
        <!-- Contact Cards -->
        <div class="row justify-content-center g-4 mb-5">
            <!-- WhatsApp -->
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body d-flex flex-column text-center p-4">
                        <div class="icon-circle mb-4">
                            <i class="fab fa-whatsapp fa-2x text-dark"></i>
                        </div>
                        <h4 class="fw-bold mb-3">WhatsApp Us</h4>
                        <p>Instantly connect with our representative via WhatsApp.</p>
                        <p class="text-muted small">(Available 24/7)</p>
                        <div class="mt-auto">
                            <a href="https://wa.me/+601110280504" class="btn btn-outline-dark w-100">Chat With Us</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call Us -->
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body d-flex flex-column text-center p-4">
                        <div class="icon-circle mb-4">
                            <i class="fas fa-phone fa-2x text-dark"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Call Us</h4>
                        <p>Speak with us from:</p>
                        <p class="text-muted">9:00AM - 5:00PM, Mon - Fri</p>
                        <div class="mt-auto">
                            <a href="tel:+601110280504" class="btn btn-outline-dark w-100">Call Us</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Us -->
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body d-flex flex-column text-center p-4">
                        <div class="icon-circle mb-4">
                            <i class="fas fa-envelope fa-2x text-dark"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Email Us</h4>
                        <p>Reach out for any business inquiries or opportunities.</p>
                        <div class="mt-auto">
                            <a href="mailto:yasinibrahim304@gmail.com" class="btn btn-outline-dark w-100">Email Us</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Locate Us -->
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body d-flex flex-column text-center p-4">
                        <div class="icon-circle mb-4">
                            <i class="fas fa-map-marker-alt fa-2x text-dark"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Locate Us</h4>
                        <p>Find our nearby stores and visit us.</p>
                        <div class="mt-auto">
                            <a href="https://www.google.com/maps/place/Southville+City/@2.9030841,101.7600734,18z" 
                               class="btn btn-outline-dark w-100">Locate Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Business Information & Map Section -->
        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <div class="business-info p-4 bg-white shadow-sm rounded-3">
                    <h3 class="fw-bold mb-4">Business Information</h3>
                    <div class="mb-4">
                        <h5 class="fw-bold">NILLCONCEPTSTORE SDN. BHD.</h5>
                        <p class="text-muted mb-1">(Registration No. 198201008749 [104000-V])</p>
                        <p class="mb-1">Southville City</p>
                        <p class="mb-1">Dengkil</p>
                        <p>43800 Selangor</p>
                    </div>
                    
                    <!-- Enhanced Social Media Section -->
                    <div class="social-links">
                        <h5 class="fw-bold mb-3">Connect With Us</h5>
                        <div class="d-flex gap-3">
                            <a href="https://www.facebook.com/nillforman" class="social-icon" target="_blank" title="Facebook">
                                <i class="fab fa-facebook-f fa-lg"></i>
                            </a>
                            <a href="https://www.instagram.com/nillforman/" class="social-icon" target="_blank" title="Instagram">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                            <a href="https://twitter.com/nillforman" class="social-icon" target="_blank" title="Twitter">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                            <a href="https://www.tiktok.com/@nillforman" class="social-icon" target="_blank" title="TikTok">
                                <i class="fab fa-tiktok fa-lg"></i>
                            </a>
                        </div>
                    </div>

                    <style>
                    .social-icon {
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: #333;
                        text-decoration: none;
                        transition: all 0.3s ease;
                        background-color: #f8f9fa;
                    }
                    
                    .social-icon:hover {
                        transform: translateY(-3px);
                        color: #fff;
                    }
                    
                    /* Specific colors for each social media on hover */
                    .social-icon:hover .fa-facebook-f {
                        color: #1877f2;
                    }
                    
                    .social-icon:hover .fa-instagram {
                        color: #e4405f;
                    }
                    
                    .social-icon:hover .fa-twitter {
                        color: #1da1f2;
                    }
                    
                    .social-icon:hover .fa-tiktok {
                        color: #000000;
                    }
                    
                    .social-links {
                        margin-top: 2rem;
                    }
                    </style>

                    <!-- Operating Hours -->
                    <div class="mt-4">
                        <h5 class="fw-bold mb-3">Operating Hours</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Monday - Friday</span>
                            <span>9:00 AM - 6:00 PM</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Saturday</span>
                            <span>10:00 AM - 4:00 PM</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Sunday</span>
                            <span>Closed</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="map-container rounded-3 overflow-hidden">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d31790.91844893754!2d101.72125543476563!3d2.903083400000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x31cdb5a8af1ac3c1%3A0x95cae85e882948df!2sSouthville%20City!3m2!1d2.9030841!2d101.7624552!4m5!1s0x31cdb5a8af1ac3c1%3A0x95cae85e882948df!2sSouthville%20City%2C%2043800%20Dengkil%2C%20Selangor!3m2!1d2.9030841!2d101.7624552!5e0"
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    
</div>

<style>
.contact-hero {
    margin-top: -2rem;
    padding: 8rem 0;
}

.icon-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    transition: transform 0.3s ease;
}

.hover-card:hover .icon-circle {
    transform: scale(1.1);
}

.hover-card {
    transition: transform 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
}

.social-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #333;
    text-decoration: none;
    transition: transform 0.3s ease;
    background-color: #f8f9fa;
}

.social-icon:hover {
    transform: translateY(-3px);
    color: #0d6efd;
}

.business-info {
    height: 100%;
    border-left: 4px solid #f8f9fa;
}

.map-container {
    height: 100%;
    min-height: 450px;
}

.map-container iframe {
    height: 100%;
}
</style>
@endsection