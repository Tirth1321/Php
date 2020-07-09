<html>
    <head>
        <title>Tirth Patel</title>
    </head>
    <body>
        <h1>Welcome to my number guessing game</h1>
        
        <?php
        $cn = 78;
        
        if($_GET['guess'])
        {
            if(is_numeric($_GET['guess'])== FALSE)
            {
                echo "Your guess is not a number";
            }
          //   else if($_GET['guess'] == null)
            //{
              //  echo "your guess is too low";
            //}
            else if($_GET['guess'] < $cn)
            {
                echo "your guess is too low";
            }
            else if($_GET['guess']> $cn)
            {
                echo "Your guess is too high";
            }
            else if($_GET['guess'] == $cn)
            {
                echo "Congratulations - You are right";
            }
        }
        else
        {
            echo "Missing guess parameter <br> Your guess is too short";
        }
    ?>    
    </body>
</html>    