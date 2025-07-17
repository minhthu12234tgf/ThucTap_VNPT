@extends('layouts.user') 
@section('title', 'Xin Chào')

@section('content')
<header>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</header>
<div class="app-content">
  <!--begin::Container-->
  <div class="container-fluid">
    <div class="carousel-wrapper">
      <div id="vnptCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="/images/slide1.jpg" alt="Ảnh 1">
          </div>
          <div class="carousel-item">
            <img src="/images/slide2.png" alt="Ảnh 2">
          </div>
          <div class="carousel-item">
            <img src="/images/slide3.jpg" alt="Ảnh 3">
          </div>
        </div>

        <!-- Nút chuyển -->
        <!-- Nút điều hướng trái -->
        <a class="carousel-control-prev custom-control" href="#vnptCarousel" role="button" data-bs-slide="prev">
          <i class="bi bi-arrow-left custom-icon"></i>
        </a>

        <!-- Nút điều hướng phải -->
        <a class="carousel-control-next custom-control" href="#vnptCarousel" role="button" data-bs-slide="next">
          <i class="bi bi-arrow-right custom-icon"></i>
        </a>

      </div>
    </div>
  </div>
</div>
<style>
  .custom-control {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.25); /* Bán trong suốt */
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease;
    cursor: pointer;
  }

  .custom-control:hover {
    background-color: rgba(0, 0, 0, 0.4);
  }

  .carousel-control-prev.custom-control {
    left: 20px;
  }

  .carousel-control-next.custom-control {
    right: 20px;
  }

  .custom-icon {
    font-size: 32px;  /* To hơn */
    color: white;
    font-weight: bold;
  }


  .carousel-wrapper {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 20px;
    background-color: #f8f9fa;
    overflow: hidden;
  }

  #vnptCarousel {
    width: 100%;
    position: relative;
  }

  .carousel-inner {
    border-radius: 12px;
    overflow: hidden;
  }

  .carousel-item {
    text-align: center;
    position: relative;
  }

  .carousel-item img {
    width: 100%;
    height: auto;
    object-fit: contain;
    max-height: 600px;
    margin: auto;
    display: block;
  }

  .carousel-item::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 25%;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.3), transparent);
    z-index: 1;
  }
</style>
@endsection