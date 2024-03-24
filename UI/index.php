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
  <link href="./css/common.css" rel="stylesheet" />
  <link href="./css/dashboard.css" rel="stylesheet" />
  </head>

  <body>
    <div id="protect">
    </div>
    <div id="index">
      <?php
        //  SVG icon for the navbar
        require_once("./views/common/svg.php");
        //start of NavBar
        require_once("./views/common/navbar.php");
      ?>
      <div class="container-fluid">
        <div class="row">
          <!-- start of side bar -->
          <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
            <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="sidebarMenuLabel">
                  Health Management
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="./index.php">
                      <svg class="bi">
                        <use xlink:href="#house-fill" />
                      </svg>
                      Dashboard
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="./views/Prescription.php">
                      <svg class="bi">
                        <use xlink:href="#file-earmark" />
                      </svg>
                      Prescriptions
                    </a>
                  </li>
                  <a class='nav-link d-flex align-items-center gap-2' href='./views/Pharmacist.php'>
                              <svg class='bi'>
                                  <use xlink:href='#list' />
                              </svg>
                              Dispenser
                          </a>
                  <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="./views/Patients.php">
                      <svg class="bi">
                        <use xlink:href="#people" />
                      </svg>
                      Patients
                    </a>
                  </li>
                  <li class='nav-item'>
                      <a class='nav-link d-flex align-items-center gap-2' href='./views/sign-out-index.php'>
                          <svg class='bi'>
                              <use xlink:href='#door-closed' />
                          </svg>
                          Sign Out
                      </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          
          <!-- Start of Main page -->
          <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Dashboard</h1>
              <!-- welcome message -->
                <div class="btn-group me-2">
                  <button type="button" class="btn btn-sm btn-outline-secondary">Welcome, {{name}}</button>
                </div>
            </div>
            <div class="container">
              <!-- table of all the Prescription by the doctor -->
              <table class="table">
                <thead>
                  <tr>
                      <th scope="col">Prescription ID</th>
                      <th scope="col">Doctors ID</th>
                      <th scope="col">Medicines</th>
                      <th scope="col">Process By Pharmacist</th>
                  </tr>
                </thead>
                <tbody v-if="prescriptions.length > 0">
                  <tr v-for = "(item, index) in prescriptions">
                    <th scope="row">{{item.prescriptionID}}</th>
                    <td>{{item.doctorID}}</td>
                    <td>
                      <ul>
                        <li v-for="(med, index) in item.medicine">Name: {{med.medicineName}}, Qty: {{med.quantity}}</li>
                      </ul>
                    </td>
                    <td>{{item.process}}</td></td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td colspan="4">No Prescription</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="container">
              <div class="row my-2">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Prescription</h5>
                      <p class="card-text">View and Create Prescriptions.</p>
                      <a href="./views/Prescription.php" class="btn btn-primary">Go to Prescriptions</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Patients</h5>
                      <p class="card-text">Manage patient records and information.</p>
                      <a href="./views/Patients.php" class="btn btn-primary">Go to Patients</a>
                    </div>
                  </div>
                </div>
              </div>           
              <div class="row my-2">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Dispenser</h5>
                      <p class="card-text">View Prescription that needs to be prepared.</p>
                      <a href="./views/Pharmacist.php" class="btn btn-primary">Go to Dispenser</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Inventory</h5>
                      <p class="card-text">Manage medicine and information.</p>
                      <a href="#" class="btn btn-primary">Go to Inventory</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </main>
          <!-- end of Mainpage -->
          </div>
      </div>
    </div>
    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
    <script src="./js/dashboard.js"></script>
    <script src="./js/protectindex.js"></script>
  </body>
</html>

