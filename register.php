<?php

    require "core/DBManager.php";
    require "helpers/functions.php";
    
    session_start();

    guest();

    $pdo = new DBManager();

    if (server()->isPostRequest()) {

        $name = request()->get('name');
        $email = request()->get('email');
        $password = request()->get('password');
        $password_confirmation = request()->get('password_confirmation');
        $department_id = request()->get('department_id');

        if ($password_confirmation !== $password) {
            $_SESSION['errors'] = ['password confirmation is not valid'];
            header('Location: register.php');
            exit;
        }

        try {

            $sql = "INSERT INTO `admins` (`name`, `email`, `password`, `department_id`) VALUES (:name, :email, :password, :department_id)";
            $password = password_hash($password, PASSWORD_DEFAULT);
            $res = $pdo->query($sql, ...compact('name', 'email', 'password', 'department_id'));

            $sql = "SELECT * FROM admins WHERE email=:email";
            $res = $pdo->query($sql, ...compact('email'));
            $user = $res->fetch(PDO::FETCH_ASSOC);

            $_SESSION['user'] = serialize($user);
            $_SESSION['done'] = ['Account created successfully!'];
            header('Location: index.php');
            exit;

        } catch (\PDOException $e) {
            $_SESSION['errors'] = [$e->getMessage()];
            header("Location: register.php");
            die;
        }

    }

    $departments = $pdo->query("SELECT * FROM departments")->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-dark h-100">

    <?php include "components/messages/error.php" ?>
    <?php include "components/messages/success.php" ?>

    <section class="h-100 mt-5">
        <div class="card w-100 bg-transparent text-light text-center border border-light">
            <div class="card-title p-3">
                <h1>Create an account</h1>
            </div>
            <div class="card-body text-start">
                <form class="px-5" action="register.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <div class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Departments</label>
                        <select class="form-control" id="department_id" name="department_id">
                            <option value="-1">-- SELECT DEPARTMENT --</option>
                            <?php foreach ($departments as $department): ?>
                                <option value="<?= $department->id ?>"><?= $department->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"
        integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>