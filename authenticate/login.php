<?php
session_start();
$page_title = "Login";
include_once "login-header.php";
if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && isset($_SESSION['name'])){
	include_once "logged_in_as.php";
	exit();
}else if (isset($_COOKIE['user_id']) && isset($_COOKIE['email']) && isset($_COOKIE['name'])){
	$_SESSION['user_id'] = $_COOKIE['user_id'];
	$_SESSION['email'] = $_COOKIE['email'];
	$_SESSION['name'] = $_COOKIE['name'];
	include_once "logged_in_as.php";
	exit();
};
?>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<!-- <img src="../gallery/36.png" alt="logo"> -->
						<img src="../assets/img/bootstrap/bootstrap.svg" alt="Bootstrap" width="32" height="32">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Login</h4>
							<?php
								echo isset($_SESSION['msg']) ? 
								"<div class = 'alert alert-danger' role = 'alert'>".$_SESSION['msg']."</div>" : "";
								unset($_SESSION['msg']);
							?>
							<form method="POST" action="../p/login.php" class="my-login-validation" id="login-form" novalidate="">
								<div class="form-group">
									<label for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" value="" required autofocus>
									<div class="invalid-feedback">
										Email is invalid
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password
										<a href="" class="float-right">
											Forgot Password?
										</a>
									</label>
									<input id="password" type="password" class="form-control" name="password" required data-eye>
								    <div class="invalid-feedback">
								    	Password is required
							    	</div>
								</div>

								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="remember" id="remember" class="custom-control-input">
										<label for="remember" class="custom-control-label">Remember Me</label>
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block" id = "login-btn" name = "login">
										Login
									</button>
								</div>
								<div class="mt-4 text-center">
									Don't have an account? <a href="signup.php">Create One</a>
								</div>
							</form>
						</div>
					</div>

<?php include_once "login-footer.php";?>