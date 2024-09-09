<!-- Main page content-->
<div class="container mt-4" id="app">
    <!-- Wizard card example with navigation-->
    <div class="card">
        <div class="card-header border-bottom">
            <!-- Wizard navigation-->
            <div class="nav nav-pills nav-justified flex-column flex-xl-row nav-wizard" id="cardTab" role="tablist">
                <!-- Wizard navigation item 1-->
                <a class="nav-item nav-link active" id="wizard1-tab" href="#wizard1" data-toggle="tab" role="tab" aria-controls="wizard1" aria-selected="true">
                    <div class="wizard-step-icon">1</div>
                    <div class="wizard-step-text">
                        <div class="wizard-step-text-name">Personal information</div>
                        <div class="wizard-step-text-details"></div>
                    </div>
                </a>
                <!-- Wizard navigation item 2-->
                <a class="nav-item nav-link" id="wizard2-tab" href="#wizard2" data-toggle="tab" role="tab" aria-controls="wizard2" aria-selected="true">
                    <div class="wizard-step-icon">2</div>
                    <div class="wizard-step-text">
                        <div class="wizard-step-text-name">Address</div>
                        <div class="wizard-step-text-details"></div>
                    </div>
                </a>
                <!-- Wizard navigation item 3-->
                <a class="nav-item nav-link" id="wizard2-tab" href="#wizard3" data-toggle="tab" role="tab" aria-controls="wizard2" aria-selected="true">
                    <div class="wizard-step-icon">2</div>
                    <div class="wizard-step-text">
                        <div class="wizard-step-text-name">Logs</div>
                        <div class="wizard-step-text-details"></div>
                    </div>
                </a>
               
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="cardTabContent">
                <!-- Wizard tab pane item 1-->
                <div class="tab-pane py-5 py-xl-10 fade show active" id="wizard1" role="tabpanel" aria-labelledby="wizard1-tab">
                    <div class="row justify-content-center" style="margin-top: -10%;">
                        <div class="col-xl-4">
                            <image-uploader></image-uploader>
                            
                        </div>
                        <div class="col-xl-8">
                            <!-- Account details card-->
                            <account-details-card></account-details-card>
                            
                        </div>
                    </div>
                </div>


                <!-- Wizard tab pane item 2-->
                <div class="tab-pane py-5 py-xl-10 fade" id="wizard2" role="tabpanel" aria-labelledby="wizard2-tab">

                    <div class="row justify-content-center" style="margin-top: -10%;">
                           <account-address-card></account-address-card>
                    </div>
                </div>
               
                <!-- Wizard tab pane item 2-->
                <div class="tab-pane py-5 py-xl-10 fade" id="wizard3" role="tabpanel" aria-labelledby="wizard2-tab">
                    <div class="row justify-content-center" style="margin-top: -5%;">
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>