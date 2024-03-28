<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <title>Health Management Hub</title>
  
    <!-- js script -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
  
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    
    <!-- Custom styles for this template -->
    <link href="../css/common.css" rel="stylesheet" />
    <link href="../css/dashboard.css" rel="stylesheet" />
  </head>

  <body>
    <div id="protect">
    </div>
    <div id="Inventory">
      <?php
        //  SVG icon for the navbar
        require_once("./common/svg.php");
        //start of NavBar
        require_once("./common/navbar.php");
      ?>
      <div class="container-fluid">
        <div class="row">
          <!-- start of side bar -->
          <?php
            require_once("./common/sidebar.php");
          ?>
          
          <!-- Start of Main page -->
          <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Inventory</h1>
            </div>
            <div class="container mt-5">
              <table class="table">
                <thead>
                  <tr>
                    <th>Inventory ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                  </tr>
                </thead>
                <tbody id="patientsList">
                  <!-- Predefined data -->
                  <tr v-for="(item, index) in inventory">
                    <td>{{item.inventoryID}}</td>
                    <td>{{item.medicine}}</td>
                    <td>{{item.price}}</td>
                    <td>{{item.quantity}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </main>
          <!-- end of Mainpage -->
        </div>
      </div>
    </div>
    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
    <script src="../js/inventory.js"></script>
    <script src="../js/protect.js"></script>
  </body>
</html>
