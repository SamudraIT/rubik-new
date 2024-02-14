@extends('layouts.default')

@section('content')
<style>
  /* #carouselExampleFade .carousel-inner img {
    max-height: 600px;
    width: auto;
    margin: auto;
  }

  .myCarousel-container {
    margin: 0 10rem;
  }

  @media screen and (max-width: 576px) {
    .myCarousel-container {
      margin: 0;
    }
  } */

</style>

<div class="container py-4">
  <div class="p-5 mb-4 bg-body-tertiary rounded-3">
    <div class="container-fluid py-5">
      <h1 class="display-5 fw-bold">Rubik</h1>
      <p class="col-md-8 fs-4 mb-5">
        Aplikasi Laporan Pencatatan Malaria
      </p>
      <a href="/admin/login">
        <button class="btn btn-warning text-white btn-lg" type="button">Coba Aplikasi</button>
      </a>
    </div>
  </div>
  <div>
    <h1>Poster</h1>
    <div id="carouselExampleFade" class="carousel slide carousel-fade myCarousel-container">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="{{asset('img/1.jpg')}}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="{{asset('img/2.jpg')}}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="{{asset('img/3.jpg')}}" class="d-block w-100" alt="...">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</div>
@endsection
