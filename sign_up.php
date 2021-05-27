<html>

<head>
    <meta charset="utf-8" />
    <title>Track Base - Sign Up</title>
    <link rel="stylesheet" href="signup.css">
</head>

<body>

    <div class="grid-container">

            <div class="left-side">
                <img src = "assets/Track your favorite.svg"></img>
            </div>

            <div class="right-side">
                <div class="page-title">
                    Sign Up
                </div>

                <form action="login_actions.php" method="post">
                    <div class="username">
                        Username
                        <div class="username-input">
                            <input type="text", placeholder="Enter username", name="sign_up_username_insert" required/>
                        </div>
                    </div>

                    <div class="password">
                        Password
                        <div class=passsword-input">
                            <input type="password", placeholder="Enter password", name="sign_up_password_insert" required/>
                        </div>
                    </div>

                    <div class="link-to">
                        Already a user? Log in <a href="login.php">here</a>.
                    </div>

                    <div class="signup-button">
                        <button type="submit", name='sign_up'>Sign Up</button>
                    </div>
                </form>
            </div>

    </div>

</body>

</html>