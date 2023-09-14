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

// Fetch transfer details from the transfers table
$sql = "SELECT sender, receiver, amount FROM transfers";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Bank - Transaction History</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="images/icon.svg">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Add your table styles here */
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto; /* Center the table horizontally */
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc; /* Add border to table cells */
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
            <a href="view_customer.php">
                <button class="button button-active">View Customer</button>
            </a>
    </header>

    <main>
        <section class="transaction-history-section">
            <h2 class="heading-secondary" style="text-align: center;">Transaction History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['sender'] . "</td>";
                        echo "<td>" . $row['receiver'] . "</td>";
                        echo "<td>Rs. " . $row['amount'] . "</td>";
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
</body>

</html>
