<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Board</title>
</head>

<body>
    <h1>Message Board</h1>
    <?php
    if (isset($_GET["action"])) {
        if ((file_exists("MessageBoard/messages.txt")) && (filesize("MessageBoard/messages.txt") != 0)) {
            // a button has been clicked on and the file message.txt exists with content
            $MessageArray = file("Messageboard/messages.txt");

            switch ($_GET["action"]) {
                case "Delete First":
                    array_shift($MessageArray);
                break;
                case "Delete Last":
                    array_pop($MessageArray);
                break;
                case "Delete Message":
                    if(isset($_GET["message"])) {
                        array_splice($MessageArray, $_GET["message"], 1);
                    }
                    break;
                case 'Delete Duplicate':
                    
                    break;
                
            } // end of switch

            if (count($MessageArray) > 0) {
                $NewMessages = implode($MessageArray);
                $MessageStore = fopen("MessageBoard/messages.txt", "wb");
                // check if the file is not accessable
                if ($MessageStore === FALSE) {
                    echo "There was an error updating the message file!\n";
                } else {
                    fwrite($MessageStore, $NewMessages);
                    fclose($MessageStore);
                }
            } else {
                // if no messages, delete that file
                unlink("MessageBoard/messages.txt");
            }
        }
    }

    if ((!file_exists("MessageBoard/messages.txt")) || (filesize("MessageBoard/messages.txt") == 0)) {
        echo "<p>There are no messages</p>\n";
    } else {
        // use the file() method to create an array out of each message in the text file
        $MessageArray = file("MessageBoard/messages.txt");

        echo "<table style = \"background-color: lightgray;\" border = \"1\" width = \"100%\">\n";

        // variable that simply counts the number of items in the $MessageArray
        $count = count($MessageArray);
        // for every message that array has, we will loop to create a new <tr> element and create the content
        for ($i = 0; $i < $count; ++$i) {
            $CurrMsg = explode("~", $MessageArray[$i]);
            echo "<tr>\n";
            echo "<td width = \"5%\" style = \"text-align: center; font-weight: bold;\">" . ($i + 1) . "</td>\n";

            echo "<td width = \"85%\"><span style = \"font-weight: bold;\">Subject: </span> " . htmlentities($CurrMsg[0]) . "<br/>\n";

            echo "<span style = \"font-weight:bold;\">Name:</span><br/>\n " . htmlentities($CurrMsg[1]) . "<br/>\n";

            echo "<span style = \"font-weight:bold;\">Message: </span><br/>\n " . htmlentities($CurrMsg[2]) . "</td>\n";

            echo "<td width=\"10%\"style=\"text-align:center;\">" . "<a href='MessageBoard.php?" . "action=Delete%20Message&" . "message=$i'>" . "Delete this message</a></td>\n";

            echo "</tr>\n";
        }
        echo "</table>\n";
    }
    ?>
    <p><a href="PostMessage.php">Post New Message</a></p>
    <p><a href="MessageBoard.php?action=Delete%20First">Delete First Message</a></p>
    <p><a href="MessageBoard.php?action=Delete%20Last">Delete Last Message</a></p>
</body>
</html>