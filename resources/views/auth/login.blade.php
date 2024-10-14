<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>login page</title>
</head>
<body>

                <section class="vh-100" style="background-color: #eee;">
                    <div class="container h-100">
                      <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-lg-12 col-xl-11">
                          <div class="card text-black" style="border-radius: 25px;">
                            <div class="card-body p-md-5">
                              <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                  
                                  @if(Session::has('error'))
                                  <div class="text-danger" role="alert">
                                      {{ Session::get('error') }}
                                  </div>
                              @endif
                              @if(Session::has('success'))
                                  <div class="text-success" role="alert">
                                      {{ Session::get('success') }}
                                  </div>
                              @endif
                  
                                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-1">Login</p>
                  
                                  <form class="mx-1 mx-md-1" method="POST" action="{{ route('login') }}">
                                    @csrf   
                                          <div class="d-flex flex-row align-items-center mb-2">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                          <input type="email" id="email" name="email" required class="form-control" placeholder="Enter your email..."/>
                                          <label class="form-label" for="email">Your Email</label>
                                        </div>
                                      </div>
                  
                                      <div class="d-flex flex-row align-items-center mb-2">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                          <input type="password"  id="password" name="password" required class="form-control" placeholder="Enter your password..."/>
                                          <label class="form-label" for="password">Password</label>
                                        </div>
                                      </div>

                  
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                      <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary">Login</button> &nbsp; &nbsp;
                                      <a href="{{ route('loginPage') }}">Register</a>

                                    </div>
                                    <a href="{{ route('auth.google') }}">
                                      <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png">
                                  </a>
                  
                                  </form>
                  
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                  
                                  <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                    class="img-fluid" alt="Sample image">
                  
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>