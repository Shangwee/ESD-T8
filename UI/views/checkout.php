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
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, 0.1);
      border: solid rgba(0, 0, 0, 0.15);
      border-width: 1px 0;
      box-shadow: inset 0 0.5em 1.5em rgba(0, 0, 0, 0.1),
        inset 0 0.125em 0.5em rgba(0, 0, 0, 0.15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -0.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }
  </style>
  <link href="../css/checkout.css" rel="stylesheet" />
</head>

<body>
  <div>

    <div>
    </div>

    <header class='navbar sticky-top flex-md-nowrap p-0' data-bs-theme='dark' style='background-color:#2d5db1;'>
        <div class='container-fluid d-flex justify-content-center'>
          <ul class='navbar-nav flex-row'>
            <li class='nav-item'>
                <a class='nav-link me-3 fs-3 text-white' href='#'>Consultation &nbsp &nbsp;</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link me-3 fs-3 text-white' href='./ViewAllMC.php'>MC &nbsp; &nbsp;</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link fs-3 text-white' href='./checkout.php'>Invoice &nbsp; &nbsp;</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link fs-3 text-white' href='./sign-out.php'>Sign Out &nbsp; &nbsp;</a>
            </li>
          </ul>
        </div>
    </header>

    <div class="container-fluid" id="invoice">
      <div class="row">
        <!-- start of side bar -->
        <div>
            hihi {{name}}
        </div>
        <!-- end of NavBar -->

        <!-- Start of Main page -->
        <main class="col-md-8 ms-sm-auto col-lg-10 col-sm-12 px-md-4">
        
            <div v-if="invoices.length > 0">
                <div class="container mt-4" v-for="(invoice, index) in invoices">
                    <div class="invoice">
                        <h3>Invoice No. : {{invoice.invoice_id}}</h3>

                        <br>

                        <table class="table table-hover">
                            <thead>
                                <tr class="table-secondary">
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(medicine, index) in invoice.medicine">
                                    <td>{{medicine.medicineName}}</td>
                                    <td>{{medicine.quantity}}</td>
                                    <td class="text-right">{{medicine.price}}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-8"></div>
                            <div class="col-4">
                            <table class="table table-sm text-right table-warning">
                                <tr>
                                <td><strong>Total Price</strong></td>
                                <td class="text-right"><strong>$ {{invoice.total_price}}</strong></td>
                                </tr>
                            </table>
                            </div>
                        </div>

                        <input type="hidden" id="invoice_id" v-bind:value="invoice.invoice_id">
                        <input type="hidden" id="total_price" v-bind:value="invoice.total_price">
                        <button type="submit" v-on:click="createCheckout()" v-bind:data-invoice="JSON.stringify(invoice)">Make Payment</button>
                        <button type="submit" id="invoice_detail" v-on:click="test" v-bind:data-invoice="JSON.stringify(invoice)">Send invoice to complex microservice</button>

                    </div>
                </div>
            </div>

            <div v-else>
                <h2 class="mt-4">Congrats! No payment to make</h2>
            </div>

        </main>
        <!-- end of Mainpage -->
      </div>
    </div>
  </div>
  <!-- scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
  <script src="../js/invoice.js"></script>
</body>

</html>