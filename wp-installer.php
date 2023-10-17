<!DOCTYPE html>
<html>
<head>
    <title>Install WordPress</title>
    <link rel="apple-touch-icon" sizes="60x60" href="https://myvestacp.com/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://myvestacp.com/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://myvestacp.com/favicon-16x16.png">
    <style>
        body {
            background-color: #fff;
            text-align: center;
        }

        h1 {
            margin-top: 20px;
        }

        #logo {
            margin-top: 20px;
        }

        #console {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            margin-top: 20px;
        }

        .blue-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <img id="logo" src="https://myvestacp.com/myvesta.png" alt="myVestacp Logo" width="118" height="41">

    <h1>Install WordPress</h1>

    <form method="post">
        <input type="submit" name="install_wordpress" value="Install WordPress" class="blue-button">
    </form>

    <div id="console"></div>

    <p>This is created for MyVestaCP control panel, allowing you to install WordPress quickly without using the command line. (If the automatic removal of wp-installer.php fails, please remove it manually from your web directory.)</p>

    <a href="https://myvestacp.com/" target="_blank"><button class="blue-button">Find More About MyVestaCP</button></a>

    <p>Created By T4B - <a href="https://github.com/t4ba/Fast-WP-Installer-For-myVestacp" target="_blank">GitHub Repository</a></p>
    
    <?php
    if (isset($_POST['install_wordpress'])) {
        // download the latest wordPress file
        $wordpress_zip_url = 'https://wordpress.org/latest.zip';
        $downloaded_file = 'latest.zip';

        echo '<script>document.getElementById("console").innerHTML += "Downloading WordPress...<br>";</script>';

        if (file_put_contents($downloaded_file, file_get_contents($wordpress_zip_url))) {
            echo '<script>document.getElementById("console").innerHTML += "WordPress downloaded successfully.<br>";</script>';

            // unzip the downloaded WordPress file to the current directory
            $zip = new ZipArchive;
            if ($zip->open($downloaded_file) === TRUE) {
                // extract contents of the 'wordpress' folder to the root directory
                $zip->extractTo('./');
                $zip->close();
                echo '<script>document.getElementById("console").innerHTML += "WordPress unzipped successfully.<br>";</script>';

                // move files from the 'wordpress' folder to the root
                $wordpress_folder = 'wordpress';
                $files = scandir($wordpress_folder);
                foreach ($files as $file) {
                    if ($file != "." && $file != "..") {
                        rename($wordpress_folder . '/' . $file, $file);
                    }
                }
                // remove 'wordpress' folder
                rmdir($wordpress_folder);
                echo '<script>document.getElementById("console").innerHTML += "WordPress files moved to the root directory.<br>";</script>';

                // delete ZIP file
                unlink($downloaded_file);

                // success message
                echo '<script>document.getElementById("console").innerHTML += "WordPress has been successfully installed.<br>";</script>';

                // Delete self
                if (unlink(__FILE__)) {
                    echo '<script>document.getElementById("console").innerHTML += "Script was successfully deleted.<br>";</script>';
                } else {
                    echo '<script>document.getElementById("console").innerHTML += "An error occurred while deleting the script.<br>";</script>';
                }

                // Exit after deleting the script
                exit;
            } else {
                echo '<script>document.getElementById("console").innerHTML += "Error: Unable to unzip the WordPress file.<br>";</script>';
            }
        } else {
            echo '<script>document.getElementById("console").innerHTML += "Error: Unable to download the WordPress file.<br>";</script>';
        }
    }
    ?>

</body>
</html>
