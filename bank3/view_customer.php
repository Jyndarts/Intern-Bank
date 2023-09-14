<?php
// Database connection parameters
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "bank3";
                    
// Create a database connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch customer records from the database
$sql = "SELECT id, name, email, balance FROM customers";
$result = mysqli_query($conn, $sql);

// Check if the query was executed successfully
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Bank</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="images/icon.svg">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* CSS to style the table */
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .transfer-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Header section -->
    <header>
        <div class="brand">
            <img src="images/internbanklogo.png">
        </div>
        <div class="header-buttons">
            <a href="index.html">
                <button class="button button-active">Home</button>
            </a>
            <a href="transfer_history.php">
                <button class="button button-active">View Transfer</button>
            </a>
        </div>
    </header>
    <main>
        <section class="customer-section">
        <h2 class="heading-secondary" style="text-align: center;">Customer Records</h2>
        <br>
            <table class="customer-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Balance</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through the results and generate table rows
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>Rs. " . $row['balance'] . "</td>";
                        echo '<td><button class="transfer-button" onclick="transfer(\'' . $row['name'] . '\')">Transfer</button></td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
 
    <!-- Footer section -->
    <footer>
        <div class="footer-links">
            <div class="links-group copyright">
                <p>Developed By <a href="https://www.linkedin.com/in/muhammad-junaid-ali-ba6815210/" target="_blank" rel="noopener noreferrer">Muhammad Junaid Ali</a></p>
            </div>
        </div>
    </footer>
    <script>
        function transfer(customerName) {
            // Redirect to transaction.php with the selected customer's name
            window.location.href = 'transaction.php?customer=' + encodeURIComponent(customerName);
        }
    </script>
</body>
</html>
