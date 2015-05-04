<form name="login" action="{{ login.post_url }}" method="post">
	<h4>Login</h4>
	<div class="form-group">
	 	<input type="text" class="form-control" placeholder="Username" name="username">
	</div>

	<div class="form-group">
	 	<input type="password" class="form-control" placeholder="Password" name="password">
	</div>

	<div class="checkbox">
	    <label>
	    	<input type="checkbox" name="remember"> Remember me
	    </label>
  	</div>

	<button type="submit" class="btn btn-default">Login</button>
</form>

