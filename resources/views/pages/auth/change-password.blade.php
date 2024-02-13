@extends('layouts.auth')

@section('content')
<style>
  .myContainer {
    background-color: #fafafa;
    width: 100%;
    height: 100%;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .myCard {
    background-color: #ffffff;
    width: 512px;
    height: fit-content;
    min-height: 349px;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    border-radius: 0.75rem;
    padding: 48px;
  }

  .myCard-header {
    text-align: center;
    display: flex;
    align-items: center;
    flex-direction: column;
    margin-bottom: 20px;
  }

  .myCard-header a {
    display: flex;
    align-items: center;
    gap: 4px;
    color: rgb(249 115 22);

  }

  .myCard-content .btn-submit {
    width: 100%;
    height: 36px;
    border: none;
    background-color: #d97706;
    border-radius: 0.45rem;
    color: white;
    font-size: 0.875rem;
    line-height: 1.25rem;
    padding: 0.5rem 0.75rem;
    transition: all .6s ease;
  }

  .myCard-content .btn-submit:hover {
    background-color: #f59e0b;
  }

</style>
<section class="myContainer">
  <div class="myCard">
    <div class="myCard-header">
      <h4>Rubik</h4>
      <h3>Ubah Password</h3>
      <a href="/admin/login">
        <i class="lni lni-arrow-left"></i>
        Back to login
      </a>
    </div>
    <div class="myCard-content">
      <form method="POST" action="{{ url('change-password') }}" id="changePasswordForm">
        @csrf
        <div class="mb-4">
          <label for="no_kk" class="form-label">No KK</label>
          <input type="text" class="form-control" id="no_kk" name="no_kk" value="{{$card_number}}" readonly>
        </div>
        <div class="mb-4">
          <label for="password" class="form-label">Password Baru</label>
          <input type="password" class="form-control @error('password') is-invalid @enderror" id="card_number" name="password" autofocus required>
          @error('password')
          <span class="invalid-feedback" role="alert">
            <strong>{{$message}}</strong>
          </span>
          @enderror
        </div>
        <div class="mb-4">
          <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
          <input type="password" class="form-control @error('password') is-invalid @enderror" id="card_number" name="password_confirmation" autofocus required>
          <div class="invalid-feedback" id="passwordConfirmationError"></div>
        </div>
        <div>
          <button type="submit" class="btn-submit">
            Send Request
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
