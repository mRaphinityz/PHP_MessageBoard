<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Message</title>
</head>
<body>
    <?php
        if(isset($_POST["submit"])) {
            $Subject = stripslashes($_POST["subject"]);
            $Name = stripslashes($_POST["name"]);
            $Message = stripslashes($_POST["message"]);

            // Replace any '~' characters with '-'
            $Subject = str_replace("~", "-", $Subject);
            $Name = str_replace("~", "-", $Name);
            $Message = str_replace("~", "-", $Message);

            // Create a variable that serves a single line of data for us to save to the file
            $MessageRecord = "$Subject~$Name~$Message\n";

            // open up the file messages.txt and save the file data to the variable
            $MessageFile = fopen("MessageBoard/messages.txt", "ab");

            // check to see if there are any issues accessing that file, if so handle the error, if not post the message
            if($MessageFile === FALSE) {
                echo "There was an error saving your message!\n";
            }
            else {
                fwrite($MessageFile, $MessageRecord);
                fclose($MessageFile);
                echo "Your message has been saved!\n";
            }
        }
    ?>

        <h1>Post New Message</h1>
        <hr/>
        <form action = "PostMessage.php" method="POST">
            <label style="font-weight: bold;" for="subject">Subject:</label>
            <input type="text" name="subject" />
            <label style="font-weight: bold;" for="name">Name:</label>
            <input type="text" name="name" /> <br/>
            <textarea name="message" cols="80" rows="6"></textarea><br/>
            <input type="submit" name="submit" value="Post Message" />
            <input type="reset" name="reset" value="Reset Form" />
        </form>
        <hr/>

        <p><a href="MessageBoard.php">View Messages</a></p>

</body>
</html>