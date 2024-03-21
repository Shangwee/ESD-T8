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
  <div id="prescription">
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
        <div class="col-md-3 ms-sm-auto col-lg-5 col-sm-12 px-md-4">
          <div class="row mt-4">
            <div class="col-md-12"> 
                <h1 class="h2">Available Medicine</h1>
                <hr>
                <div class="my-3">
                </div>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(item, index) in inventory">
                        <div>
                            <span class="item-name">{{item.inventoryID}}. </span>
                            <span class="item-name">{{item.medicine}}</span>
                            <span class="badge bg-info rounded-pill ms-2">Qty: {{item.quantity}}</span>
                        </div>
                        <div>
                            <button class="btn btn-primary btn-sm edit-item mx-1" @click="addPrescription(item.inventoryID, item.medicine)">add</button>
                        </div>
                    </li>
                </ul>
            </div>
          </div>
        </div>

        <main class="col-md-6 ms-sm-auto col-lg-5 col-sm-12 px-md-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Prescription Form</h1>
          </div>
            <div class="mb-3">
              <label for="doctorID" class="form-label">Doctor ID</label>
              <input readonly type="number" class="form-control" id="doctorID" v-model="doctorID" placeholder="Enter Doctor's ID" value="1" min="1" max="3">
            </div>
            <div class="mb-3">
              <div v-if="patientID <= 3 && Number.isInteger(patientID)">
                <p style="color: red;">Not a Patient</p>
              </div>
              <label for="patientID" class="form-label">Patient ID</label>
              <input required type="number" class="form-control" id="patientID" v-model="patientID" @keyup="getallergicTo()" placeholder="Enter Patient's ID" min="4">
            </div>
            <div v-if = "allergicTo.length > 0" >
                <p>Allergies:</p>
                <ul>
                  <li v-for="item in allergicTo">{{item}}</li>
                </ul>
            </div>
            <button class="btn text-white mx-1" style='background-color:#0c1559' @click="savePrescription()" >Save Prescription</button>
          <div class="row mt-4">
              <div class="col-md-12"> 
                  <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center"  v-for="(item, index) in prescriptions">
                          <div v-if="editlist.includes(item.medicineID)">
                            <span class="item-name">{{item.medicineName}}</span>
                            <div class="my-3">
                              <input type="text" class="form-control" v-model="item.instruction" placeholder="Enter instruction here">
                            </div>
                            <div class="mb-3">
                              <input type="number" class="form-control" v-model="item.quantity">
                            </div>
                          </div>
                          <div v-else>
                            <span class="item-name">{{item.medicineName}}</span>
                            <span class="badge bg-secondary rounded-pill ms-2">{{item.instruction}}</span>
                            <span class="badge bg-info rounded-pill ms-2">Qty: {{item.quantity}}</span>
                          </div>
                          <div>
                            <button v-if="editlist.includes(item.medicineID)" class="btn btn-success btn-sm edit-item mx-1" @click="saveMedicine(item)">Save</button>
                            <div v-else>
                              <button class="btn btn-primary btn-sm edit-item mx-1" v-on:click="editMedicine(item)">Edit</button>
                              <button class="btn btn-danger btn-sm delete-item mx-1" v-on:click="removePrescription(item.medicineID)">Delete</button>
                            </div>
                          </div>
                      </li>
                  </ul>
              </div>
          </div>
        </main>
        <!-- end of Mainpage -->
      </div>
    </div>
  </div>
  <!-- scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
  <script src="../js/prescription.js"></script>
  <script src="../js/protect.js"></script>
</body>

</html>