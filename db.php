<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
return new mysqli("127.0.0.1", "root", "1", "testproject");