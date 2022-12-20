<style>
    .navbar{
        background-color: #880015;
        font-size: large;
        color: white;
        white-space: nowrap;
        transition: .8s;
        padding: .5rem;
    }
    li {
        float: left;
        color: #E3E2E2 !important;
    }

    li a, .dropbtn {
       display: inline-block;
       color: white;
       text-align: center;
       padding: 14px 16px;
       text-decoration: none;
   }

    li a:hover, .dropdown:hover .dropbtn {
       color: #FFFFFF;
   }

    li.dropdown {
       display: inline-block;
   }

   .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
   }

   .dropdown-content a {
     color: #1f302e;
     padding: 12px 16px;
     text-decoration: none;
     display: block;
     text-align: left;
   }

   .dropdown-content a:hover {background-color: #f1f1f1;}

   .dropdown:hover .dropdown-content {
     display: block;
   }

</style>
<nav class="navbar navbar-expand-xl navbar-light px-3" style="width: 100%;">
<img src="assets/pmi_logo.png" width="auto" height="40" class="d-inline-block align-top" alt="">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="dropbtn" aria-current="page" href="displayAllEvent.php">Home</a>
          </li> 
          <li class="nav-item">
            <a class="dropbtn" href="table.php">RFM</a>
          </li>
          <li class="nav-item">
            <a class="dropbtn" href="rfm.php">Hasil Clustering</a>
          </li>
          <li class="nav-item">
            <a class="dropbtn" aria-current="page" href="data.php">RFM Modif</a>
          </li> 
        </ul>
    </div>
</nav>
