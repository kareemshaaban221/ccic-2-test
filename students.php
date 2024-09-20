<?php

    require "core/DBManager.php";
    require "models/Student.php";
    require "helpers/functions.php";
    
    session_start();

    $user = auth();

    $pdo = new DBManager();

    if (server()->isGetRequest()) {
        if (request()->has('action') && request()->equal('action', 'delete')) {
            $student_id = request()->get('id');
            // delete file
            $sql = "SELECT picture FROM students WHERE id=?";
            $std = $pdo->query($sql, $student_id)->fetch(PDO::FETCH_ASSOC);
            if (! fileManager()->delete($std['picture'])) {
                throw new Exception("Error while deleting file");
            }

            // delete student record itself
            $sql = "DELETE FROM `students` WHERE id=?";
            $stmt = $pdo->query($sql, $student_id);
            if ($stmt->rowCount() <= 0) {
                $_SESSION['errors'] = ['No student with provided id!'];
            } else {
                $_SESSION['done'] = ['student deleted successfully!'];
            }
        }
    }

    $sql = "SELECT * FROM `students` WHERE department_id = ?";
    $stmt = $pdo->query($sql, $user->department_id);
    $students = $stmt->fetchAll(PDO::FETCH_CLASS, 'Student');

    // dd($students);

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

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">School Website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="students.php">Students</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="teachers.php">Teachers</a>
                    </li>
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li> -->
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>

                </form>
                <?php include "components/logout-btn.php" ?>
            </div>
        </div>
    </nav>

    <section class="h-100 mt-5">
        <div class="card w-100 bg-transparent text-light text-center border border-light">
            <div class="card-title text-start p-3 d-flex justify-content-between" style="align-items: baseline;">
                <h1>Students</h1>
                <a href="students-create.php" class="btn btn-success">Add Student <i class="fa fa-plus"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-dark">
                    <thead>
                        <tr class="table-light">
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Picture</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= $student->id ?></td>
                            <td><?= $student->fname ?></td>
                            <td><?= $student->lname ?></td>
                            <td><a href="mailto:<?= $student->email ?>"><?= $student->email ?></a></td>
                            <td><a href="tel:<?= $student->phone ?>"><?= $student->phone ?></a></td>
                            <td><img src="<?= 'uploads/' . $student->picture ?>" width="50" height="50" alt="profile image"></td>
                            <td>
                                <a href="students-edit.php?id=<?= $student->id ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="students.php?action=delete&id=<?= $student->id ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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