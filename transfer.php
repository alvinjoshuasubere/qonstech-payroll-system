<?php
// Database configuration
$mysqlConfig = [
    'host' => 'localhost',
    'dbname' => 'payroll-master',
    'username' => 'root',
    'password' => ''
];

try {
    // Connect to MySQL
    $mysqlDsn = "mysql:host={$mysqlConfig['host']};dbname={$mysqlConfig['dbname']}";
    $mysqlPDO = new PDO($mysqlDsn, $mysqlConfig['username'], $mysqlConfig['password']);
    $mysqlPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get data from POST request
    // $id = $_POST['id'] ?? null;
    $Employee_ID = $_POST['Employee_ID'] ?? null;
    $Checkin_One = $_POST['Checkin_One'] ?? null;

    // Check if data is valid
    if ($Employee_ID !== null) {
        // Prepare and execute insert statement in MySQL
        $insertSQL = "INSERT INTO attendance (Employee_ID, Checkin_One) VALUES (:Employee_ID, :Checkin_One) ON DUPLICATE KEY UPDATE Employee_ID = :Employee_ID";
        $stmt = $mysqlPDO->prepare($insertSQL);
        $stmt->execute([':Employee_ID' => $Employee_ID, ':Checkin_One' => $Checkin_One]);
        
        echo "Data transferred successfully.";
    } else {
        echo "Invalid data.";
    }
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
