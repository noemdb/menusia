<?php   session_start();  $_SESSION["autentificado"]="NO";  session_write_close(); ?>
<body>
  <form action='index.php' method='POST' name='redirige'></form>
  <script type='text/javascript'>alert('Usted ha Salido del Modulo'); document.redirige.submit();
  </script>
</body>
</html>
