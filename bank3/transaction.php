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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender = $_POST["sender"];
    $receiver = $_POST["receiver"];
    $amount = $_POST["amount"];
    
    // Check if sender has sufficient balance
    $check_balance_sql = "SELECT balance FROM customers WHERE name='$sender'";
    $balance_result = mysqli_query($conn, $check_balance_sql);
    
    if ($balance_result && mysqli_num_rows($balance_result) > 0) {
        $sender_balance = mysqli_fetch_assoc($balance_result)["balance"];
        
        if ($sender_balance >= $amount) {
            // Deduct the amount from sender's balance
            $deduct_sql = "UPDATE customers SET balance=balance-$amount WHERE name='$sender'";
            mysqli_query($conn, $deduct_sql);
            
            // Add the amount to receiver's balance
            $add_sql = "UPDATE customers SET balance=balance+$amount WHERE name='$receiver'";
            mysqli_query($conn, $add_sql);
            
            // Record the transaction in the transfers table
            $record_sql = "INSERT INTO transfers (sender, receiver, amount) VALUES ('$sender', '$receiver', $amount)";
            mysqli_query($conn, $record_sql);
            
            echo "Transaction successful!";
            header("Location: transfer_history.php");
        } else {
            echo "Insufficient balance.";
        }
    } else {
        echo "Sender not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Bank - Transaction</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="images/icon.svg">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        select,
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        select {
            appearance: none;
            background: url('images/arrow.png') no-repeat right;
        }

        /* Style the send button */
        input[type="submit"] {
            background-color: #000000;
            color: white;
            border: 2px;
            border-radius: 20px;
            padding: 10px 20px;
            cursor: pointer;
            margin-left: 20rem;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
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
        </div>
    </header>
    <main>
    <section class="transaction-section">
        <h2 class="heading-secondary">Fund Transfer</h2>
        <form id="transfer-form" method="post" action="" style="text-align: center;">
            <div class="form-group">
                <label for="sender">Sender:</label>
                <input type="text" id="sender" name="sender" readonly>
            </div>
            <div class="form-group">
                <label for="receiver">Receiver:</label>
                <select id="receiver" name="receiver" required style="padding: 5px; width: 100%;">
                    <option value="" disabled selected>Select Receiver &#9662;</option>
                    <?php
                    // Fetch a list of available receivers from the database
                    $receiver_query = "SELECT name FROM customers WHERE name != '$customerName'";
                    $receiver_result = mysqli_query($conn, $receiver_query);

                    if ($receiver_result) {
                        while ($receiver_row = mysqli_fetch_assoc($receiver_result)) {
                            echo "<option value='" . $receiver_row['name'] . "'>" . $receiver_row['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" min="1" required>
            </div>
            <button type="submit" style="background-color: #007bff; color: white; border: none; padding: 5px 10px; cursor: pointer;">Transfer</button>
        </form>
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
        // JavaScript to set sender and receiver names
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const customerName = urlParams.get("customer");

        if (customerName) {
            document.getElementById("sender").value = customerName;
            document.getElementById("receiver").value = ""; // You can set this based on your application logic
        }

        // JavaScript to validate and handle the form submission
        const transferForm = document.getElementById("transfer-form");

        transferForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const amount = parseFloat(document.getElementById("amount").value);

            if (amount <= 0 || isNaN(amount)) {
                alert("Invalid amount. Please enter a valid amount.");
                return;
            }

            if (!confirm("Confirm the fund transfer?")) {
                return;
            }

            // Submit the form
            this.submit();
        });
    </script>
</body>

</html>
