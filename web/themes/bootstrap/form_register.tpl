<form name="register" action="{{ register.post_url }}" method="post">
	<h4>Sign Up</h4>
	<div class="form-group">
	 	<input type="text" class="form-control" placeholder="Username" name="username">
	</div>

	<div class="form-group">
	 	<input type="password" class="form-control" placeholder="Password" name="password">
	</div>

	<div class="form-group">
	 	<input type="text" class="form-control" placeholder="Email" name="email">
	</div>

	<button type="submit" class="btn btn-default">Sign Up</button>
</form>

