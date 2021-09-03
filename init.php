<?php

$config = require("config.php");

//set local timezone to Vietnam
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Create a new database, if the file doesn't exist and open it for reading/writing.
// The extension of the file is arbitrary.
$db = new SQLite3($config['sqlite_filename'], SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

// Create tables.
// Base table for devices
$db->query('CREATE TABLE IF NOT EXISTS "devices" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "sn" TEXT,
    "comment" VARCHAR,
    "last_check" DATETIME,
    "last_tx" INT,
    "last_rx" INT
)');

// Base table for detailed traffic
$db->query('CREATE TABLE IF NOT EXISTS "traffic" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "device_id" INT,
    "timestamp" DATETIME,
    "tx" INT,
    "rx" INT
)');
