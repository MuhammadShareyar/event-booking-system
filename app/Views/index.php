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

    <hr>

    <form action="index.php" method="get">
        <div class="row g-3">
            <h2>
                <span class=" ">Events</span>
            </h2>
            <div class="col-md-3">
                <input type="text" id="employeeFilter" name="employee_name" value="<?= $_GET['employee_name'] ?? ''  ?>" class="form-control" placeholder="Filter by Employee Name">
            </div>
            <div class="col-md-3">
                <input type="text" id="eventFilter" name="event_name" value="<?= $_GET['event_name'] ?? ''  ?>" class="form-control" placeholder="Filter by Event Name">
            </div>
            <div class="col-md-3">
                <input type="date" id="event_date" name="event_date" value="<?= $_GET['event_date'] ?? ''  ?>" class="form-control">
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-6">
                        <input type="submit" id="dateFilter" class="form-control btn btn-primary" value="Search">
                    </div>
                    <div class="col-md-6">
                        <input type="reset" id="resetBtn" class="form-control btn btn-primary" value="Reset">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Event Name</th>
                <th>Date</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody id="eventTable">
            <?php $total = 0; ?>
            <?php foreach ($bookings as $booking) : ?>
                <?php $total += $booking['fees']; ?>
                <tr>
                    <td><?= $booking['name'] ?></td>
                    <td><?= $booking['event_name'] ?></td>
                    <td><?= $booking['event_date'] ?></td>
                    <td class="price"><?= number_format($booking['fees'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                <td id="totalPrice"><?= number_format($total, 2) ?></td>
            </tr>
        </tfoot>
    </table>

    <hr>


    <script>
        document.getElementById("resetBtn").addEventListener("click", function() {
            document.getElementById("event_date").value = "";
        });
    </script>
</body>

</html>