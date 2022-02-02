<?php declare(strict_types = 1); ?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="custom.css">
    </head>
    <body>
        <fieldset id="userForm">
            <legend style="text-align: center">User</legend>
                <form action="usera.php" method="post">
                    <span id="s" align="center">
                        <p>User name: <input id="user" name="userName" type="text" placeholder="user name" autocomplete="off" required></p>
                        <p>Password: <input id="password" name="password" type="password" placeholder="password" min="8" required></p>
                        <p>
                            User Mode:
                            <select style="width: " name="userMode">
                                <option value="none">None</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </p>
                        <p>
                            <input name="Send" type="submit">
                            <input name="Reset" type="reset">
                        </p>
                    </span>
                </form>
        </fieldset>
        <strong>
            <?php

                $userName = isset($_POST['userName']) && strlen($_POST['userName']) > 0 ? $_POST['userName'] : 'undefined';
                $password = isset($_POST['password']) && strlen($_POST['password']) > 0 ? $_POST['password'] : 'undefined';
                $userMode = isset($_POST['userMode']) && strlen($_POST['userMode']) > 0 ? $_POST['userMode'] : 'undefined';

                $set = [
                        "User is $userName",
                        "Password is $password",
                        "User mode is $userMode"
                ];
                foreach ($set as $str)
                    echo "<p>$str</p>"
            ?>
        </strong>

    </body>
</html>
