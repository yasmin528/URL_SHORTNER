<?php
include("db.php");

function GetShortUrl($url)
{
    global $conn;
    $query = "SELECT * FROM urls WHERE long_url = '" . $url . "'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_assoc();
            return $row['short_url'];
        } else {
            $short_url = unique_ID_generator();
            $query = "INSERT INTO urls (long_url, short_url) VALUES ('" . $url . "','" . $short_url . "')";
            if (mysqli_query($conn, $query) === true) {
                return $short_url;
            } else {
                echo "Error executing query";
            }
        }
    } else {
        echo "Error executing query ";
    }
}
function unique_ID_generator()
{
    global $conn;
    global $base_url;
    $short_code = substr(md5(uniqid(rand(), true)), 0, 6);
    $short_url = $base_url . $short_code;
    $query = "SELECT * FROM urls where short_url = '" . $short_url . "'";
    try {
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            unique_ID_generator();
        } else {
            return $short_url;
        }
    } catch (Exception $e) {
        echo "Error executing query";
    }
}

function previous_urls_entered()
{
    global $conn;
    $query = "SELECT * FROM urls";
    $result = mysqli_query($conn, $query);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = array(
                'long_url' => $row['long_url'],
                'short_url' => $row['short_url']
            );
        }
    }
    return $data;
}

function Redirect_URL($url)
{
    global $conn;
    $query = "SELECT * FROM urls WHERE short_url = '" . $url . "' ";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['long_url'];
    }
}
