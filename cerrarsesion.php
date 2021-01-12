<?php
    session_start();  
    $_SESSION["Usuario"] = "";
    echo "<script>
    location.href = 'index.php';</script>";
?>