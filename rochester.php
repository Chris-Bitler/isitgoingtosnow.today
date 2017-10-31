<!-- This file is a joke. It is never not snowing in Rochester, New York, except for when it's under construction -->
<html>
    <body>
    <?php
        $month = (int) date('n');
        if($month >= 11 || $month <= 5) {
            echo '<h1 style="font-size:100px; margin-top:250px; text-align: center;">YES</h1>';
        } else {
            echo '<h1 style="font-size:50px; margin-top:250px; text-align: center;">No, It\'s construction season</h1>';
        }
    ?>

    </body>
</html>