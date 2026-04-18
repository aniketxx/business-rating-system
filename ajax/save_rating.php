<?php
require __DIR__ . '/../conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $business_id = $_POST['business_id'];
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $rating = $_POST['rating'];

    try {

        /* CHECK IF USER ALREADY RATED */
        $check = $conn->prepare("
            SELECT id FROM ratings
            WHERE business_id = ?
            AND (email = ? OR phone = ?)
        ");

        $check->execute([$business_id, $email, $phone]);

        if ($check->rowCount() > 0) {

            /* UPDATE EXISTING RATING */
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

            /* INSERT NEW RATING */
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