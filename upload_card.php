<?php
// ตรวจสอบการอัปโหลดไฟล์
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ตรวจสอบการอัปโหลดไฟล์
    if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] == 0) {
        $imageName = $_FILES['imageUpload']['name'];
        $imageTmpName = $_FILES['imageUpload']['tmp_name'];
        $imageSize = $_FILES['imageUpload']['size'];
        $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        
        // ตั้งชื่อใหม่สำหรับภาพ
        $newImageName = uniqid() . '.' . $imageExt;

        // เช็คประเภทไฟล์ที่อนุญาต
        $allowedExts = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($imageExt, $allowedExts)) {
            // กำหนดตำแหน่งที่เก็บภาพ
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . $newImageName;

            // ตรวจสอบขนาดไฟล์ (ไม่เกิน 5MB)
            if ($imageSize <= 5 * 1024 * 1024) {
                // ย้ายไฟล์ไปยังตำแหน่งที่กำหนด
                if (move_uploaded_file($imageTmpName, $uploadFile)) {
                    // รับข้อความจากฟอร์ม
                    $message = $_POST['message'];
                    
                    // แสดงข้อความยืนยัน
                    echo "การ์ดของคุณถูกสร้างเรียบร้อยแล้ว!";
                    echo "<br><img src='" . $uploadFile . "' alt='การ์ดวาเลนไทน์' style='width:300px;'><br>";
                    echo "<p>" . htmlspecialchars($message) . "</p>";

                    // สามารถบันทึกข้อมูลลงในฐานข้อมูลได้ในที่นี้
                } else {
                    echo "ไม่สามารถอัปโหลดไฟล์ได้.";
                }
            } else {
                echo "ไฟล์มีขนาดใหญ่เกินไป. ขนาดไฟล์ต้องไม่เกิน 5MB.";
            }
        } else {
            echo "ประเภทไฟล์ไม่ถูกต้อง. โปรดอัปโหลดไฟล์ประเภท jpg, jpeg, png, หรือ gif.";
        }
    } else {
        echo "กรุณาอัปโหลดไฟล์ภาพ.";
    }
}
?>
