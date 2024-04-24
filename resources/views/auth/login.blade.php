<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }

        .custom-border {
            border: 1cm solid red;
            padding: 1cm;
            border-radius: 1cm;
        }

        #profile-image {
            max-height: 100%;
            max-width: 100%;
            /* Menambahkan properti max-width */
            height: auto;
            /* Menambahkan properti height */
        }
    </style>
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="row">
                    <div class="col-md-6" style="
                        margin-top: 6cm;">
                        <div class="row" style="
                        margin-left: 3cm;
                    ">
                            <div class="col-md-12 text-center mb-4">
                                <h2 class="mb-0">Login Form</h2>
                            </div>
                            <div class="col-md-12">
                                <form class="my-3" action="{{ route('login.process') }}" method="POST">
                                    @csrf
                                    <div
                                        class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                                        <p class="lead fw-normal mb-0 me-3">Sign in with</p>
                                        <button type="button" class="btn btn-primary btn-floating mx-1">
                                            <i class="fab fa-linkedin-in"></i>
                                        </button>
                                    </div>

                                    <div class="divider d-flex align-items-center my-4">
                                        <p class="text-center fw-bold mx-3 mb-0">Or</p>
                                    </div>

                                    <!-- Username input -->
                                    <div class="form-outline mb-4">
                                        <input type="text" id="form3Example3" class="form-control form-control-lg"
                                            placeholder="Username" name="username" />
                                        <label class="form-label" for="form3Example3">Username</label>
                                    </div>

                                    <!-- Password input -->
                                    <div class="form-outline mb-3">
                                        <input type="password" id="form3Example4" class="form-control form-control-lg"
                                            placeholder="Password" name="password" />
                                        <label class="form-label" for="form3Example4">Password</label>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary bg-danger "
                                            style="padding-left: 6rem; padding-right: 6rem; color">Masuk</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Gambar -->
                                <img id="profile-image" src="{{ asset('CMS/Frame 98699.png') }}" class="img-fluid"
                                    alt="Sample image"
                                    style="
                                    margin-left: 4.5cm;
                                ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>

</html>
