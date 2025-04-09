@extends("layout.layout")
@section("css")
<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
    }

    /* Navbar styling */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #ddd;
    }
    .navbar .logo img {
        width: 150px;
    }
    .navbar .nav-links a {
        text-decoration: none;
        color: #000;
        margin: 0 15px;
        font-weight: bold;
    }
    .navbar .nav-actions button {
        margin-left: 10px;
    }

    /* Main container */
    .container-fluid {
        display: flex;
        flex-wrap: nowrap;
        margin-top: 20px;
    }

    /* Sidebar styling */
    .sidebar {
        width: 20%;
        border-right: 1px solid #ddd;
        padding: 20px;
    }
    .sidebar h4 {
        font-size: 18px;
        margin-bottom: 15px;
    }
    .sidebar ul {
        list-style: none;
        padding: 0;
    }
    .sidebar ul li {
        margin-bottom: 10px;
    }
    .sidebar ul li input {
        margin-right: 10px;
    }

    /* Content area */
    .main-content {
        width: 80%;
        padding: 20px;
    }

    /* Special buttons aligned to the left */
    .special-buttons {
        display: flex;
        justify-content: flex-start; /* Align to the left */
        gap: 15px; /* Add spacing between buttons */
        margin-bottom: 20px;
    }
    .special-buttons button {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 14px;
        transition: background-color 0.2s;
    }
    .special-buttons button:hover {
        background-color: #444;
    }

    /* Product section */
    .product-section {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: flex-start;
    }
    .product-card {
        width: 220px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .product-card img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .product-card select,
    .product-card input {
        width: 100%;
        margin: 10px 0;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    .btn-black {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 5px;
    }
    .btn-black:hover {
        background-color: #444;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .container-fluid {
            flex-direction: column;
        }
        .sidebar, .main-content {
            width: 100%;
        }
    }
</style>
@endsection

@section("content")
<!-- Main Container -->
<div class="container-fluid">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Filters</h4>
        <ul>
            <li><input type="checkbox"> Filter 1</li>
            <li><input type="checkbox"> Filter 2</li>
            <li><input type="checkbox"> Filter 3</li>
            <li><input type="checkbox"> Filter 4</li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Special Buttons -->
        <div class="special-buttons">
            <button>SPECIAL PROMO</button>
            <button>SUGGESTION</button>
        </div>

        <!-- Product Section -->
        <div class="product-section">
            @foreach ($products as $product)
                <div class="product-card">

                    <img src="{{asset('image/IMG_7282.jpg')}}" height="50px" alt="Baju Melayu Jauhar">
                    <h5>{{ $product['name'] }}</h5>
                    <p>Color: {{ $product['color'] }}</p>
                    <p>Price: RM{{ $product['price'] }}</p>
                    <select>
                        <option value="1">S</option>
                        <option value="2">M</option>
                        <option value="2">L</option>
                        <option value="2">XL</option>
                    </select>
                    <input type="number" value="1" min="1">
                    <button class="btn-black">Add to Cart</button>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
