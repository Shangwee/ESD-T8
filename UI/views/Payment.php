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
            <h1 class="h2">Prescription Payment</h1>
          </div>
          <div class="mb-3">
            <h4>Items:</h4>
            <hr>
            <ul class="list-group">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Medication A
                <span class="badge bg-primary">$50</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Medication B
                <span class="badge bg-primary">$30</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Medication C
                <span class="badge bg-primary">$20</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Total
                <span class="badge bg-primary">$100</span>
              </li>
            </ul>
          </div>
          <h4>Payment Details:</h4>
          <hr>
          <form>
            <div class="mb-3">
              <label for="cardNumber" class="form-label">Card Number</label>
              <input type="text" class="form-control" id="cardNumber" placeholder="Enter card number" required>
            </div>
            <div class="row mb-3">
              <div class="col">
                <label for="expiryDate" class="form-label">Expiry Date</label>
                <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" required>
              </div>
              <div class="col">
                <label for="cvv" class="form-label">CVV</label>
                <input type="text" class="form-control" id="cvv" placeholder="CVV" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="cardHolderName" class="form-label">Cardholder Name</label>
              <input type="text" class="form-control" id="cardHolderName" placeholder="Enter cardholder name" required>
            </div>
            <div class="mb-3">
              <label for="amount" class="form-label">Amount</label>
              <input type="text" class="form-control" id="amount" placeholder="Enter amount" required>
            </div>
            <button type="submit" class="btn btn-primary">Pay</button>
          </form>
        </main>
        <!-- end of Mainpage -->
      </div>
    </div>
    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
    <script src="../js/protect.js"></script>
  </body>
</html>
