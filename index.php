<html>
<head>
  <link rel="stylesheet" href="index.css">
</head>
<body>

   <h2>Sign In</h2>

  <form action="login_actions.php" method="post">
  <div class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="login_username_insert" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="login_password_insert" required>

    <button type="submit", name='sign_in'>Login</button>
   </form>
  </div>
    <h2>Sign Up</h2>

  <form action="login_actions.php" method="post">
  <div class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="sign_up_username_insert" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="sign_up_password_insert" required>

    <button type="submit", name='sign_up'>Sign Up</button>
  </div>
</form>
    
</body>
</html>