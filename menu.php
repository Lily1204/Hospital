
        <nav>
            <?php
				if (isset($_SESSION["tipo"])){
					if ($_SESSION["tipo"]=="Administrador"){
			
					}
			?>
        <ul>
          <li><a href="tabpersonal.php" class="menu">ABC personal</a></li>
          <li><a href="tabpacientes.php" class="menu">ABC pacientes</a></li>
  				<li><a href="logout.php" class="menu">Salir</a></li>
        </ul>

			<?php
				} else {
			?>
			<ul>
				<li> <a href="#" class="menu">Opcion 1</a> </li>
				<li> <a href="#" class="menu">Opcion 2</a> </li>
				<li> <a href="#" class="menu">Opcion 3</a> </li>
			</ul>
			<?php
				}
			?>
        </nav>
