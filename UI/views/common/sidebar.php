<?php
    echo"
    <div class='sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary'>
        <div class='offcanvas-md offcanvas-end bg-body-tertiary' tabindex='-1' id='sidebarMenu' aria-labelledby='sidebarMenuLabel'>
            <div class='offcanvas-header'>
                <h5 class='offcanvas-title' id='sidebarMenuLabel'>
                    Health Management
                </h5>
                <button type='button' class='btn-close' data-bs-dismiss='offcanvas' data-bs-target='#sidebarMenu' aria-label='Close'></button>
            </div>
            <div class='offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto'>
                <ul class='nav flex-column'>
                    <li class='nav-item'>
                        <a class='nav-link d-flex align-items-center gap-2 active' aria-current='page' href='../index.php'>
                            <svg class='bi'>
                                <use xlink:href='#house-fill' />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link d-flex align-items-center gap-2' href='./Prescription.php'>
                            <svg class='bi'>
                                <use xlink:href='#file-earmark' />
                            </svg>
                            Prescriptions
                        </a>
                    </li>
                        <a class='nav-link d-flex align-items-center gap-2' href='./Pharmacist.php'>
                            <svg class='bi'>
                                <use xlink:href='#list' />
                            </svg>
                            Dispenser
                        </a>
                    <li>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link d-flex align-items-center gap-2' href='./Patients.php'>
                            <svg class='bi'>
                                <use xlink:href='#people' />
                            </svg>
                            Patients
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link d-flex align-items-center gap-2' href='./Inventory.php'>
                            <svg class='bi'>
                                <use xlink:href='#circle-half' />
                            </svg>
                            Inventory
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link d-flex align-items-center gap-2' href='./sign-out.php'>
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
    ";
?>