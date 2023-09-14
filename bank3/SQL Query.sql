CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    balance DECIMAL(10, 2) NOT NULL
);

CREATE TABLE transfers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender VARCHAR(255) NOT NULL,
    receiver VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
);
