@extends('layout.admin_layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar is included in admin_layout and occupies fixed space -->
        <!-- Main Content -->
        <main class="ms-sm-auto px-md-4" style="margin-left: 200px;">
            <div class="pt-4">
                <!-- Dashboard Cards -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Total Sales</h5>
                                <h3 class="card-text">$ 100.00</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Total Orders</h5>
                                <h3 class="card-text"> 600</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Total Products</h5>
                                <h3 class="card-text">90</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales and Visitor Statistics -->
                <div class="row g-4 mt-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Sales Statistics</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Visitor Statistics</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="visitorChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest Orders -->
                <div class="row g-4 mt-4">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Latest Orders</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td class="truncate" title="John Doe">John Doe</td>
                                            <td>john.doe@example.com</td>
                                            <td>$50.00</td>
                                            <td><span class="badge bg-success">Delivered</span></td>
                                            <td>01/01/2025</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="truncate" title="Jane Smith">Jane Smith</td>
                                            <td>jane.smith@example.com</td>
                                            <td>$30.00</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                            <td>02/01/2025</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td class="truncate" title="Bob Johnson">Bob Johnson</td>
                                            <td>bob.johnson@example.com</td>
                                            <td>$20.00</td>
                                            <td><span class="badge bg-danger">Canceled</span></td>
                                            <td>03/01/2025</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js logic here
</script>
@endsection
