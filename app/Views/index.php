<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Event Filter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

    <hr>

    <h2 class="mb-4">Booking Import</h2>

    <form id="filterForm" action="index.php" method="post" enctype="multipart/form-data">
        <div class="row g-3 mb-3">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="col-md-4">
                <input type="file" id="jsonFile" class="form-control mt-2" accept="application/json" name="json_file">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary mt-2">Upload JSON</button>
            </div>
        </div>
    </form>

</body>

</html>