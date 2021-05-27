<html>

<head>
    <meta charset="utf-8" />
    <title>Track Base - Log in</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>

    <div class="grid-container">

            <div class="left-side">
                <img src = "assets/Track your favorite.svg"></img>
            </div>
            
            <div class="right-side">
                <div class="page-title">
                    Log In
                </div>
                
                <form action="login_actions.php" method="post">
                <div class="username">
                    Username
                    <div class="username-input">
                        <input type="text", placeholder="Enter username", name="login_username_insert" required/>
                    </div>
                </div>

                <div class="password">
                    Password
                    <div class=passsword-input">
                        <input type="password", placeholder="Enter password", name="login_password_insert" required/>
                    </div>
                </div>

                <div class="link-to">
                    New user? Sign up <a href="sign_up.php">here</a>.
                </div>

                <div class="login-button">
                    <button type="submit", name='log-in'>Log in</button>
                </div>
                </form>

            </div>

    </div>

</body>

</html>