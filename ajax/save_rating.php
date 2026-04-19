<?php
require __DIR__ . '/../conn.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $business_id = $_POST['business_id'];
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $rating = $_POST['rating'];

    if (empty($name)) {
        exit(json_encode(["status" => "error", "message" => "Name required"]));
    }

    if (empty($email) && empty($phone)) {
        exit(json_encode(["status" => "error", "message" => "Email or Phone required"]));
    }

    if ($rating < 0 || $rating > 5) {
        exit(json_encode(["status" => "error", "message" => "Invalid rating"]));
    }

    try {

        
        $check = $conn->prepare("
            SELECT id FROM ratings
            WHERE business_id = ?
            AND (email = ? OR phone = ?)
        ");

        $check->execute([$business_id, $email, $phone]);

        if ($check->rowCount() > 0) {

            
            $update = $conn->prepare("
                UPDATE ratings
                SET rating = ?
                WHERE business_id = ?
                AND (email = ? OR phone = ?)
            ");

            $update->execute([
                $rating,
                $business_id,
                $email,
                $phone
            ]);
        } else {

            
            $insert = $conn->prepare("
                INSERT INTO ratings
                (business_id, name, email, phone, rating)
                VALUES (?, ?, ?, ?, ?)
            ");

            $insert->execute([
                $business_id,
                $name,
                $email,
                $phone,
                $rating
            ]);
        }

        echo json_encode([
            "status" => "success",
            "message" => "Rating saved successfully"
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
    }
}
