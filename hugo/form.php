<html>

  <head>	
    <title>Ma page de traitement</title>
  </head>

  <body>
    <?php
       if (strlen($_POST['player']) < 0)
				      {
				      echo "Votre nom est " . $_POST['player'];
				      }
				      else
				      echo "Veillez entrer un nom";
				     
       ?>
  </body>
</html>
