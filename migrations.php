<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("127.0.0.1", "root", "1");

$mysqli->query("create database if not exists testproject");
$mysqli->query("DROP TABLE if exists testproject.users");
$mysqli->query("CREATE TABLE if not exists testproject.users (
     id int NOT NULL AUTO_INCREMENT,
     login varchar(255) NOT NULL,
     password varchar(255) NOT NULL,
     age int NULL default NULL,
     token varchar(255) NOT NULL,
     PRIMARY KEY (id)
);");
