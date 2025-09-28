@extends("easyadmin::frontend.parent")
@push('mtitle')
{{$title}}
@endpush
@section("contentfrontend")
<div class="auth-main">
    <div class="auth-wrapper v3">
        <div class="auth-form">
            <div class="card my-5">
                <div class="card-body">

                    <a href="https://Sampharindo.id" class="d-flex justify-content-center">
                        <img src="{{asset('easyadmin/idev/img/logo-idev.png')}}" class="img-responsive" style="width:300px;">
                    </a>
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <div class="auth-header">
                                <h2 class="my-3"><b>Login to your account</b></h2>
                            </div>
                        </div>
                    </div>

                    <form id="form-login" action="{{url('login')}}" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Email address / Username" />
                            <label for="floatingInput">Email address / Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" />
                            <label for="floatingInput">Password</label>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="button" class="btn btn-outline-secondary" id="btn-for-form-login" onclick="submitAfterValid('form-login', '-login')">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Menangani peristiwa tekan tombol Enter pada elemen formulir
    document.getElementById("form-login").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Mencegah aksi default formulir (mengirimkan formulir)
            submitAfterValid('form-login', '-login'); // Panggil fungsi yang menangani pengiriman formulir
        }
    });
</script>

@endsection