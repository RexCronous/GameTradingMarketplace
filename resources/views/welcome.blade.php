@extends('layouts.app') {{-- Uses AdminLTE layout but hides sidebar for guests --}}

@section('page-title', 'Welcome')

@push('styles')
<style>
    .landing-header {
        background: linear-gradient(90deg, #1f2d3d, #343a40);
        padding: 80px 20px;
        text-align: center;
        color: white;
    }
    .landing-header h1 {
        font-size: 40px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .feature-box {
        background: #fff;
        border-radius: 8px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        transition: 0.3s;
        height: 100%;
    }
    .feature-box:hover {
        transform: translateY(-5px);
    }
    .btn-main {
        background-color: #00b894;
        border: none;
        font-size: 18px;
        padding: 12px 30px;
        border-radius: 6px;
        color: white;
    }
    .btn-main:hover {
        background-color: #019374;
    }
</style>
@endpush

@section('content')
<div class="landing-header">
    <h1>🎮 Game Trading Marketplace</h1>
    <p>Buy, Sell, and Trade Game Assets Easily</p>

    <a href="{{ route('marketplace.index') }}" class="btn btn-main mt-3">
        Explore Marketplace
    </a>

    @guest
        <a href="{{ route('login') }}" class="btn btn-outline-light ml-2 mt-3">
            Login / Register
        </a>
    @endguest
</div>

<div class="container py-5">
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="feature-box">
                <i class="fas fa-store fa-3x text-primary mb-3"></i>
                <h4>Open Marketplace</h4>
                <p>Browse item listings freely without authentication.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="feature-box">
                <i class="fas fa-gamepad fa-3x text-success mb-3"></i>
                <h4>Trade Game Items</h4>
                <p>Login only when you want to trade or manage assets.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="feature-box">
                <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
                <h4>Secure Transactions</h4>
                <p>Built using Laravel Authentication & Role System.</p>
            </div>
        </div>
    </div>
</div>
@endsection
