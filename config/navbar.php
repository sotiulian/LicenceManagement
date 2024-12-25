<!-- config/navbar.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">WWP</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <!-- System Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="systemDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          System
        </a>
        <div class="dropdown-menu" aria-labelledby="systemDropdown">
          <a class="dropdown-item" href="module/users/public/read_all.php">Users</a>
          <a class="dropdown-item" href="module/groups/public/read_all.php">Groups</a>
          <a class="dropdown-item" href="module/modules/public/read_all.php">Modules</a>
          <a class="dropdown-item" href="module/furnizori/public/read_all.php">Furnizori</a>
        </div>
      </li>
      <!-- Settings Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Settings
        </a>
        <div class="dropdown-menu" aria-labelledby="settingsDropdown">
          <a class="dropdown-item" href="module/programs/public/read_all.php">Programs</a>
          <a class="dropdown-item" href="module/versiuni/public/read_all.php">Versions</a>
        </div>
      </li>
      <!-- Work Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="workDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Work
        </a>
        <div class="dropdown-menu" aria-labelledby="workDropdown">
          <a class="dropdown-item" href="module/licence/public/read_all.php">Licences</a>
          <a class="dropdown-item" href="module/clienti/public/read_all.php">Clienti</a>
        </div>
      </li>
      <!-- History Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="historyDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          History
        </a>
        <div class="dropdown-menu" aria-labelledby="historyDropdown">
          <a class="dropdown-item" href="module/licencelog/public/read_all.php">Licence log</a>
        </div>
      </li>
      <!-- Logout Menu Item -->
      <li class="nav-item">
        <a class="nav-link" href="config/logout.php">Logout</a>
      </li>      
    </ul>
  </div>
</nav>
