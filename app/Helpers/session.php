<?php
session_start();

if (isset($_SESSION['username'])){
    return true;
}else{
    return false;
}