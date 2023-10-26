<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>{{ config('app.name', 'Innowave') }}</title>

    <meta name="description" content="{{ config('app.name', 'Innowave') }}">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/logo.png') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/logo.png') }}">

    <!-- Modules -->
    @yield('css')
    @vite(['resources/sass/main.scss', 'resources/js/dashmix/app.js'])

    <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
    {{-- @vite(['resources/sass/main.scss', 'resources/sass/dashmix/themes/xwork.scss', 'resources/js/dashmix/app.js']) --}}
    @yield('js')
</head>

<body>
    <div id="page-container">
        <!-- Main Container -->
        <main id="main-container">
            <div class="bg-image" style="background-image: url('{{ asset('media/images/background.jpg') }}');">
				<div class="row g-0 justify-content-center bg-xmodern-dark-op">
					<div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
						<!-- Sign In Block -->
						<div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
							<div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-body-extra-light">
								<!-- Header -->
								<div class="mb-2 text-center">
									<span class="link-fx fw-bold fs-1 text-primary" href="{{ url('/') }}">
										{{ config('app.name', 'Innowave') }}
									</span>
									<p class="text-uppercase fw-bold fs-sm text-muted">{{ __('passwords.reset_password') }}</p>
								</div>

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="my-4">
										<div class="input-group input-group-lg">
											
											<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
											<span class="input-group-text">
												<i class="fa fa-user-circle"></i>
											</span>

											@error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
										</div>
									</div>

                                    <div class="d-sm-flex justify-content-sm-between align-items-sm-center text-center text-sm-start mb-4">
                                        

                                        @if (Route::has('password.request'))
                                        <div class="fw-semibold fs-sm py-1 ">
                                            <a href="/">
                                                <i class="fa-solid fa-circle-left me-1 text-muted"></i> <span class="text-muted">Back to Home</span> 
                                            </a>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="text-center mb-4">
										<button type="submit" class="btn btn-hero btn-primary">
											<i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i>{{ __('passwords.send_password_reset_link') }}
										</button>
									</div>
                                </form>
                            </div>
							<div class="block-content bg-body">
								<div class="d-flex justify-content-center text-center push order-sm-2 mb-3    ">
									Powered By <a class="fw-semibold ms-2" href="https://innowave.com.sg/" rel="noopener">Innowave Tech</a>
								</div>
							</div>
						</div>
                    </div>
				</div>
			</div>
		</main>
	</div>
    <!-- END Page Container -->
</body>