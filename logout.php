<?php
if(!session_id()) session_start();
session_destroy();

header("Location: login.php");