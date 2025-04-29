<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Web Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styling.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.html">CRUD App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/T1/todolist.html">To-Do List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="habits.html">Habit Tracker</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reading.html">Reading List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="budget.html">Budget Tracker</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Assignment CRUD</h1>
        <p>Choose among the following tasks:</p>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">To-Do List</h5>
                        <p class="card-text"><strong>Objective:</strong> Develop an interactive to‑do list manager web application that enables users to efficiently create, manage, and track their tasks.</p>
                        <a href="/T1/todolist.html" class="btn btn-primary">Go to To-Do List</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Habit Tracker</h5>
                        <p class="card-text"><strong>Objective:</strong> Design and implement a web-based habit tracker that allows users to create, monitor, and sustain daily or weekly habits.</p>
                        <a href="habits.html" class="btn btn-primary">Go to Habit Tracker</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reading List</h5>
                        <p class="card-text"><strong>Objective:</strong> Develop an interactive Reading List.</p>
                        <a href="reading.html" class="btn btn-primary">Go to Reading List</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Budget Tracker</h5>
                        <p class="card-text"><strong>Objective:</strong> Create a web-based budget tracker that allows users to log expenses, categorize spending, and monitor their total balance.</p>
                        <a href="budget.html" class="btn btn-primary">Go to Budget Tracker</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 