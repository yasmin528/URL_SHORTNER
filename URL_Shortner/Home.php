<?php
include("db.php");
include("shortURL.php");
$urls = previous_urls_entered();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <link rel="stylesheet" href="Home.css">
    <title>URL Shortener</title>
</head>

<body>
    <form action="Home.php" method="post" class="centered-form">
        <h2>URL Shortener</h2>
        <div class="input-container">
            <input type="text" name="long_url" placeholder="Input the URL you want to shorten">
            <span class="icon">
                <i class="fas fa-link"></i>
            </span>
        </div>
        <input type="submit" name="shortenbtn" value="Shorten">
    </form>
    <table>
        <tr>
            <th>Shorten URL</th>
            <th>Long URL</th>
        </tr>
        <?php foreach ($urls as $url) : ?>
            <tr>
                <td><?php echo $url['short_url']; ?></td>
                <td><?php echo $url['long_url']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url = filter_input(INPUT_POST, "long_url", FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($_POST["long_url"])) {
        echo "Please enter a URL";
    } else {
        $long_url = urldecode($url);
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $short_url = GetShortUrl($long_url);
            header("Refresh:0");
        }
    }
}

if ($_SERVER['REQUEST_URI'] != "/URL_Shortner/Home.php") {
    $redirect = "http://localhost" . $_SERVER['REQUEST_URI'];
    $url = Redirect_URL($redirect);
    if ($url !== false) {
        header("Location: " . $url);
        exit;
    } else {
        echo "Invalid Link!";
        exit;
    }
}

?>