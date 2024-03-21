<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <title>Health Management Hub</title>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sockjs-client/1.6.1/sockjs.min.js" integrity="sha512-1QvjE7BtotQjkq8PxLeF6P46gEpBRXuskzIVgjFpekzFVF4yjRgrQvTG1MTOJ3yQgvTteKAcO7DSZI92+u/yZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/stomp-websocket@2.3.4-next/lib/stomp.min.js" integrity="sha256-J/Fmm7sRV2Xl80GnYljc6S/bKiEMLzDKDlu488D9TFs=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet"/>
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
        <?php
          require_once("./common/sidebar.php");
        ?>
        
        <!-- Start of Main page -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dispenser</h1>
          </div>
          <div class="mb-3" id="dispenser">
            <h4>Prescription to prepare:</h4>
            <hr>

            <!-- new prescription notification toasts -->
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
              <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <!-- <img src="..." class="rounded me-2" alt="..."> -->
                  <strong class="me-auto">New prescription</strong>
                  <small>11 mins ago</small>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                  Received a new prescription to prepare!
                </div>
              </div>
            </div>

            <!-- loading modal -->
            <div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered text-center" style="width: fit-content">
                <div class="modal-content">
                  <div class="modal-body">
                    <span class="spinner-border spinner-border" aria-hidden="true"></span>
                  </div>
                </div>
              </div>
            </div>
          
            <table class="table">
              <thead class="table-light">
                <tr>
                  <th></th>
                  <th class="text-center" scope="col">Date</th>
                  <th class="text-center" scope="col">PrescriptionID</th>
                  <th class="text-center" scope="col">DoctorID</th>
                  <th class="text-center" scope="col">PatientID</th>
                  <th class="text-center" scope="col">Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody v-if="checkMessages" v-for="m in messages">
                <tr data-bs-toggle="collapse" :href="'#' + m.prescriptionID" role="button" aria-expanded="false" :aria-controls="m.prescriptionID">
                  <td class="text-center"><i class="bi bi-caret-down-fill"></i></td>
                  <td class="text-center">{{ m.date }}</td>
                  <th class="text-center" scope="row">#{{ m.prescriptionID }}</th>
                  <td class="text-center">{{ m.doctorID }}</td>
                  <td class="text-center">{{ m.patientID }}</td>
                  <td class="text-center" :style="m.process ? { 'color': 'green'} : { 'color': 'red'}">{{ m.process ? 'Completed' : 'Pending'}}</td>
                </tr>
                <tr class="collapse" :id="m.prescriptionID">
                  <td colspan="5">   
                    <table class="table table-hover table-bordered rounded-3 text-center">
                      <thead>
                        <tr>
                          <th scope="col">MedicineID</th>
                          <th scope="col">Name</th>
                          <th scope="col">Quantity</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tr v-for="med in m.medicine">
                        <td>#{{ med.medicineID }}</td>
                        <td>{{ med.medicineName }}</td>
                        <td>{{ med.quantity }}</td>
                        <td><input class="form-check-input me-1" type="checkbox" value="" aria-label="..."></td>
                      </tr>
                    </table>   
                    <span class="float-right">
                      <modal-component :prescription="m" @update-messages="updateMessages(m.prescriptionID)"></modal-component>
                      <!-- <button v-if="!m.process" class="btn btn-success float-end" @click="processPrescription(m.prescriptionID)">Process</button> -->
                      <button class="btn btn-success float-end" @click="processPrescription(m.prescriptionID)">Process</button>
                    </span>  
                  </td>
                </tr>        
              </tbody>
              <tbody v-else>
                <tr><td colspan="5">There are no prescriptions to prepare now.</td></tr>
              </tbody>
            </table>
          </div>
          
        </main>
        <!-- end of Mainpage -->
      </div>
    </div>
    <!-- scripts -->
    <script>
      const dispenser = Vue.createApp({
          data() {
              return {
                  messages: [],
              }
          },
          methods: {
            // sort messages
            sortMessages: function () {
              console.log(this.messages)
              this.messages.sort(function(a, b){return new Date(b.date) - new Date(a.date)})
              console.log(this.messages)

            },
            // remove messages after process complete
            updateMessages: function (id) {
              // 1. remove from messages array
              this.messages.splice(this.messages.findIndex(m => m.prescriptionID === id) , 1)
              this.getUnprocessedPrescription()
            },
            // get all unprocessed prescription
            getUnprocessedPrescription: function () {
              url = "http://localhost:5004/prescription/filter_process/0"

              axios.get(url)
              .then(r => {
                if(r.data.code == 200) {
                  this.messages = r.data.data.prescriptions
                  this.sortMessages()
                }
              })
              .catch(e => {
                console.log(e.response.data.message)
              })
              
            },
            // get prescription function
            getPrescription: (id) => {
              let url = "http://localhost:5004/prescription/" + id

              return axios.get(url)
              .then(r => {
                return r.data.data
              })
              .catch(e => {
                console.log(e)
              })
              
            },
            // process prescription function - complex microservice
            processPrescription: (id) => {
              let url = "http://localhost:6001/process"
              let params = {
                "id": id
              }
              
              return axios.post(url, params)
              .then(r => {
                console.log(r.data)
                if(r.data.code == 201) {

                  // 2. display notification modal
                  const loadingModal = document.getElementById('loadingModal')
                  const loadModal = new bootstrap.Modal(loadingModal)
                  loadModal.toggle()
                  return setTimeout(() => {
                    loadModal.hide()
                    const modal = document.getElementById('modal' + r.data.data.update_prescription_process.data.prescriptionID)
                    const myModal = new bootstrap.Modal(modal)
                    myModal.toggle()
                  }, 1000);
                }
              })
              .catch(e => {
                console.log(e)
              })
            }
          },
          computed: {
            checkMessages() {
              return this.messages.length > 0
            }
          },
          mounted() {

            var ws = new WebSocket('ws://127.0.0.1:15674/ws');
            var client = Stomp.over(ws);
            
            var on_connect = () => {

              console.log('connected');
              
              var onmessage = async (message) => {
              // called every time the client receives a message
                message = JSON.parse(message.body)

                // 1. Show toasts (notification) when receive new prescription
                const toastLiveExample = document.getElementById('liveToast')
                const toast = new bootstrap.Toast(toastLiveExample)
                toast.show()

                // 2. display retrieved messages                  
                var prescription = await this.getPrescription(message.prescription_id)
                this.messages.push(prescription)
                this.sortMessages()
                
                // 3. for each prescription, retrieve medicines and total price
                
              }

            var sub1 = client.subscribe("Dispenser_Queue", onmessage);
            }

            var on_error =  function() {
                console.log('error');
            };

            client.connect('guest', 'guest', on_connect, on_error, '/');
          },
          created() {
            this.getUnprocessedPrescription()
          }
      })

      dispenser.component('modal-component', {
        data() {
          return {

          }
        },
        props: ['prescription'],
        emits: ['update-messages'],
        template: `
          <!-- Modal -->
          <div class="modal fade" :id="'modal'+prescription.prescriptionID" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Processing Complete</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="$emit('update-messages')"></button>
                </div>
                <div class="modal-body">
                  <b>Prescription ID:</b> {{prescription.prescriptionID}}
                  <br>
                  <b>Medicines prepared:</b>
                  <br>
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Qty</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(m, index) in prescription.medicine">
                        <th scope="row">{{ index+1 }}.</th>
                        <td>{{ m.medicineID }}</td>
                        <td>{{ m.medicineName }}</td>
                        <td>{{ m.quantity }}</td>
                      </tr>
                    </tbody>
                  </table>
                  <br>
                  <b>Inventory updated..</b>
                  <br>
                  <b>Invoice created..</b>
                  <br>
                  <br>
                  <b>Prescription is ready for collection!</b>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="$emit('update-messages');">Close</button>
                </div>
              </div>
            </div>
          </div>
        `
      })

      const vm = dispenser.mount('#dispenser')
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
    <script src="../js/protect.js"></script>
  </body>
</html>
