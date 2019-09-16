<nav class="navbar navbar-inverse">

  <div class="container">

    <div class="navbar-header">

      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

      </button>

      <a class="navbar-brand" href="dashboard.php">Home Page</a>

    </div>

    <div class="collapse navbar-collapse" id="app-nav">

      <ul class="nav navbar-nav">

        <li><a href="users.php">Users</a></li>

        <li><a href="books.php">Robots</a></li>

      </ul>

      <ul class="nav navbar-nav navbar-right">

        <li class="dropdown">

          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION["UserName"]; //print SESSSION NAME ?> <span class="caret"></span></a>

          <ul class="dropdown-menu">

            <li><a href="users.php?do=edit&UserID=<?php echo $_SESSION['AdminID']?> " >Edit Profile</a></li>

            <li><a href="logout.php">Logout</a></li>

          </ul>

        </li>

      </ul>

    </div>

  </div>

</nav>