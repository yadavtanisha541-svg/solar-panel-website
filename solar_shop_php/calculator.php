<?php
$pageTitle = "Professional Solar Savings & System Size Calculator - SolarSphere";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<section class="py-4 bg-light border-bottom mb-4">
    <div class="container text-center">
        <h1 class="display-6 font-weight-bold text-dark mb-1">Solar System Size &amp; Savings Calculator</h1>
        <p class="text-muted mb-0">Estimate your required solar capacity, PM Surya Ghar subsidy, 575W panel count, and 25-year financial savings instantly.</p>
    </div>
</section>

<!-- Solar Savings & System Size Calculator Section -->
<section class="py-5 bg-white" id="solar-calculator">
    <div class="container py-2">
        <div class="row g-4 align-items-stretch justify-content-center">
            <!-- Left Side: Inputs, System Type & Mode Selector -->
            <div class="col-lg-6">
                <div class="p-4 bg-white rounded-1 shadow-sm border border-light-subtle h-100 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Mode Selector Tabs -->
                        <div class="nav nav-pills nav-fill bg-light p-1 rounded-1 mb-3 border" id="calcTabs" role="tablist">
                            <button class="nav-link active font-weight-semibold py-2 px-2 small" id="bill-tab" data-bs-toggle="tab" data-bs-target="#mode-bill" type="button" role="tab" onclick="switchCalcMode('bill')">
                                <i class="fa-solid fa-file-invoice-dollar me-1"></i> Monthly Bill
                            </button>
                            <button class="nav-link font-weight-semibold py-2 px-2 small" id="kw-tab" data-bs-toggle="tab" data-bs-target="#mode-kw" type="button" role="tab" onclick="switchCalcMode('kw')">
                                <i class="fa-solid fa-solar-panel me-1"></i> System Size
                            </button>
                            <button class="nav-link font-weight-semibold py-2 px-2 small" id="roof-tab" data-bs-toggle="tab" data-bs-target="#mode-roof" type="button" role="tab" onclick="switchCalcMode('roof')">
                                <i class="fa-solid fa-house-chimney me-1"></i> Roof Area
                            </button>
                            <button class="nav-link font-weight-semibold py-2 px-2 small" id="emi-tab" data-bs-toggle="tab" data-bs-target="#mode-emi" type="button" role="tab" onclick="switchCalcMode('emi')">
                                <i class="fa-solid fa-calculator me-1"></i> Solar Loan EMI
                            </button>
                        </div>

                        <!-- Tab 1: Monthly Bill Input -->
                        <div class="calc-mode-panel" id="panel-bill">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="font-weight-bold text-dark mb-0 fs-6">Monthly Electricity Bill (₹)</label>
                                    <span class="badge bg-dark fs-6 px-3 py-2" id="billValDisplay">₹5,000</span>
                                </div>
                                <input type="range" class="form-range" id="inputBillSlider" min="1000" max="50000" step="500" value="5000" oninput="calculateSolarMaster()">
                                <div class="d-flex justify-content-between text-muted small mt-1">
                                    <span>₹1,000</span>
                                    <span>₹25,000</span>
                                    <span>₹50,000+</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: System Size Input -->
                        <div class="calc-mode-panel d-none" id="panel-kw">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="font-weight-bold text-dark mb-0 fs-6">Desired Solar System Size (kW)</label>
                                    <span class="badge bg-dark fs-6 px-3 py-2" id="kwValDisplay">5.0 kW</span>
                                </div>
                                <input type="range" class="form-range" id="inputKwSlider" min="1" max="50" step="0.5" value="5" oninput="calculateSolarMaster()">
                                <div class="d-flex justify-content-between text-muted small mt-1">
                                    <span>1 kW</span>
                                    <span>25 kW</span>
                                    <span>50 kW</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 3: Roof Area Input -->
                        <div class="calc-mode-panel d-none" id="panel-roof">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="font-weight-bold text-dark mb-0 fs-6">Available Rooftop Area (sq.ft.)</label>
                                    <span class="badge bg-dark fs-6 px-3 py-2" id="roofValDisplay">500 sq.ft.</span>
                                </div>
                                <input type="range" class="form-range" id="inputRoofSlider" min="100" max="5000" step="50" value="500" oninput="calculateSolarMaster()">
                                <div class="d-flex justify-content-between text-muted small mt-1">
                                    <span>100 sq.ft.</span>
                                    <span>2,500 sq.ft.</span>
                                    <span>5,000 sq.ft.</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 4: Solar Loan EMI Input -->
                        <div class="calc-mode-panel d-none" id="panel-emi">
                            <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                                <h5 class="font-weight-bold text-dark mb-0 text-uppercase" style="letter-spacing: 0.5px; font-size: 1.05rem;">
                                    <i class="fa-solid fa-calculator text-success me-2"></i>Configure Solar Loan Financing
                                </h5>
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill font-weight-semibold small">
                                    Flexible EMI Options
                                </span>
                            </div>

                            <!-- 1. Down Payment Slider -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="font-weight-bold text-dark mb-0 small text-uppercase" style="letter-spacing: 0.5px;">Down Payment</label>
                                    <span class="badge bg-dark font-weight-bold fs-6 px-3 py-1" id="emiDownPayDisplay">₹30,000</span>
                                </div>
                                <input type="range" class="form-range" id="inputEmiDownPay" min="0" max="150000" step="5000" value="30000" oninput="calculateEmiMaster()">
                                <div class="d-flex justify-content-between text-muted small mt-1">
                                    <span id="emiDownMin">₹0</span>
                                    <span id="emiDownMax">₹1,56,000</span>
                                </div>
                            </div>

                            <!-- Derived Loan Amount Display Box -->
                            <div class="p-3 mb-4 rounded-1 border bg-light">
                                <small class="text-muted font-weight-bold d-block text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Derived Loan Amount (Cost - Down Payment)</small>
                                <h4 class="font-weight-bold text-dark mb-0" id="emiLoanAmountDisplay">₹1,26,000</h4>
                            </div>

                            <!-- 2. Interest Rate Slider -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="font-weight-bold text-dark mb-0 small text-uppercase" style="letter-spacing: 0.5px;">Interest Rate</label>
                                    <span class="badge bg-dark font-weight-bold fs-6 px-3 py-1" id="emiRateDisplay">8.5% P.A.</span>
                                </div>
                                <input type="range" class="form-range" id="inputEmiRate" min="6" max="15" step="0.25" value="8.5" oninput="calculateEmiMaster()">
                                <div class="d-flex justify-content-between text-muted small mt-1">
                                    <span>6%</span>
                                    <span>10%</span>
                                    <span>15%</span>
                                </div>
                            </div>

                            <!-- 3. Loan Duration Slider -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="font-weight-bold text-dark mb-0 small text-uppercase" style="letter-spacing: 0.5px;">Loan Duration</label>
                                    <span class="badge bg-dark font-weight-bold fs-6 px-3 py-1" id="emiTenureDisplay">5 Years</span>
                                </div>
                                <input type="range" class="form-range" id="inputEmiTenure" min="1" max="10" step="1" value="5" oninput="calculateEmiMaster()">
                                <div class="d-flex justify-content-between text-muted small mt-1">
                                    <span>1 Year</span>
                                    <span>5 Years</span>
                                    <span>10 Years</span>
                                </div>
                            </div>

                            <!-- Financing Highlights Badges -->
                            <div class="pt-3 border-top d-flex flex-wrap gap-2 text-muted small font-weight-semibold mb-3">
                                <span class="badge bg-light text-secondary border py-2 px-3"><i class="fa-solid fa-circle-check text-success me-1"></i> No Cost EMI Available</span>
                                <span class="badge bg-light text-secondary border py-2 px-3"><i class="fa-solid fa-circle-check text-success me-1"></i> 8.5% Low Interest</span>
                                <span class="badge bg-light text-secondary border py-2 px-3"><i class="fa-solid fa-circle-check text-success me-1"></i> Up to 10 Years Tenure</span>
                            </div>
                        </div>

                        <!-- Standard Inputs Wrapper (Hides when EMI mode is active) -->
                        <div id="standard-inputs-wrapper">
                            <!-- Property Type Selector -->
                            <div class="mt-3 mb-3">
                                <label class="form-label font-weight-semibold text-muted small text-uppercase" style="letter-spacing: 1px;">Property Type</label>
                                <div class="d-flex gap-2 flex-wrap" id="propertyTypeGroup">
                                    <button type="button" class="btn btn-property-type active" data-type="residential" onclick="selectPropertyType(this)">
                                        <i class="fa-solid fa-house me-1"></i> Residential
                                    </button>
                                    <button type="button" class="btn btn-property-type" data-type="commercial" onclick="selectPropertyType(this)">
                                        <i class="fa-solid fa-building me-1"></i> Commercial
                                    </button>
                                    <button type="button" class="btn btn-property-type" data-type="industrial" onclick="selectPropertyType(this)">
                                        <i class="fa-solid fa-industry me-1"></i> Industrial
                                    </button>
                                </div>
                            </div>

                            <!-- Tariff Rate & City Input -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label font-weight-semibold text-muted small">Electricity Rate (₹/unit)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">₹</span>
                                        <input type="number" class="form-control" id="inputRate" value="8" min="3" max="20" step="0.5" onchange="calculateSolarMaster()" onkeyup="calculateSolarMaster()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-semibold text-muted small">City / Location</label>
                                    <input type="text" class="form-control" id="inputCity" placeholder="e.g. New Delhi" value="Delhi / NCR">
                                </div>
                            </div>

                            <!-- PM Surya Ghar Govt. Subsidy Option Toggle -->
                            <div class="mt-3 p-3 bg-light rounded-1 border">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <label class="font-weight-bold text-dark mb-0 small d-block" for="inputSubsidyToggle" style="cursor: pointer;">
                                            <i class="fa-solid fa-hand-holding-dollar text-success me-1"></i> Apply PM Surya Ghar Govt. Subsidy
                                        </label>
                                        <small class="text-muted">Up to ₹78,000 Govt. Subsidy for Residential Solar</small>
                                    </div>
                                    <div class="form-check form-switch ms-3">
                                        <input class="form-check-input fs-5" type="checkbox" id="inputSubsidyToggle" checked onchange="calculateSolarMaster()" style="cursor: pointer;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lead Capture Form -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="font-weight-bold text-dark mb-3"><i class="fa-solid fa-headset text-warning me-2"></i>Get Free Solar Consultation &amp; Site Survey</h6>
                        <form id="calcLeadForm" onsubmit="handleCalcLead(event)">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" id="leadName" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="tel" class="form-control form-control-sm" id="leadPhone" placeholder="Mobile Number" required pattern="[0-9]{10}">
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-solar-primary w-100 font-weight-bold py-2">
                                        Get Free Solar Consultation <i class="fa-solid fa-paper-plane ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Side: Enhanced Results Grid & EMI View -->
            <div class="col-lg-6">
                <div class="p-4 bg-white rounded-1 shadow-sm border border-light-subtle h-100 d-flex flex-column justify-content-between">
                    <!-- Standard Results Panel -->
                    <div id="panel-results-standard">
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                            <h5 class="font-weight-bold text-dark mb-0">Professional Solar Summary</h5>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-3 py-2 rounded-pill font-weight-semibold">
                                <i class="fa-solid fa-sun me-1"></i> PM Surya Ghar Subsidy
                            </span>
                        </div>

                        <!-- Results Grid -->
                        <div class="row g-3">
                            <!-- 1. Recommended System Size -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Solar Size</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resSystemKw">5.2 kW</h4>
                                    <small class="text-muted" id="resRoofArea">Area: 520 sq.ft.</small>
                                </div>
                            </div>

                            <!-- 2. Daily Generation -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Daily Generation</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resDailyGen">21 Units</h4>
                                    <small class="text-muted">Avg / Day</small>
                                </div>
                            </div>

                            <!-- 3. Monthly Generation -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Monthly Units</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resMonthlyGen">624 Units</h4>
                                    <small class="text-muted" id="resYearlyGen">7,488 / Yr</small>
                                </div>
                            </div>

                            <!-- 4. Est. System Cost -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">System Cost</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resSystemCost">₹2,34,000</h4>
                                    <small class="text-muted">Without Subsidy</small>
                                </div>
                            </div>

                            <!-- 5. Subsidy Amount -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-success bg-opacity-10 rounded-1 border border-success border-opacity-20 h-100">
                                    <span class="text-success small d-block mb-1 font-weight-semibold">Govt. Subsidy</span>
                                    <h4 class="font-weight-bold text-success mb-0" id="resSubsidy">₹78,000</h4>
                                    <small class="text-success">PM Surya Ghar</small>
                                </div>
                            </div>

                            <!-- 6. Net Cost After Subsidy -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Final Net Cost</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resNetCost">₹1,56,000</h4>
                                    <small class="text-muted">After Subsidy</small>
                                </div>
                            </div>

                            <!-- 7. Panels Count (575W) -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Solar Panels</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resPanels">10 Panels</h4>
                                    <small class="text-muted">575W Mono PERC</small>
                                </div>
                            </div>

                            <!-- 8. Monthly Savings -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Monthly Savings</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resMonthlySavings">₹5,000</h4>
                                    <small class="text-muted">Bill Reduction</small>
                                </div>
                            </div>

                            <!-- 9. Yearly Savings -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Yearly Savings</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resYearlySavings">₹60,000</h4>
                                    <small class="text-muted">Annual Return</small>
                                </div>
                            </div>

                            <!-- 10. Payback Period -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Payback Period</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resPayback">2.6 Years</h4>
                                    <small class="text-muted">Fast ROI</small>
                                </div>
                            </div>

                            <!-- 11. 25-Year Savings -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">25-Yr Lifetime</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resLifetimeSavings">₹15,00,000</h4>
                                    <small class="text-muted">Total Benefit</small>
                                </div>
                            </div>

                            <!-- 12. CO2 Offset -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">🌱 CO₂ Offset</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resCo2">~6.2 Tons</h4>
                                    <small class="text-muted">Green Impact/Yr</small>
                                </div>
                            </div>
                        </div>

                        <!-- Highlight Guarantee Banner -->
                        <div class="mt-4 p-3 rounded-1 bg-dark text-white d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="font-weight-bold mb-1"><i class="fa-solid fa-circle-check text-warning me-2"></i>Residential Roof Suitable: <span id="resRoofSuitable">Yes (Ideal)</span></h6>
                                <small class="text-gray-300">Complete Net-Metering &amp; DISCOM Approval Included</small>
                            </div>
                            <button class="btn btn-sm btn-solar-accent" data-bs-toggle="modal" data-bs-target="#siteSurveyModal">
                                Claim Subsidy
                            </button>
                        </div>
                    </div>

                    <!-- EMI Results Panel (Shown when Solar Loan EMI tab is active) -->
                    <div id="panel-results-emi" class="d-none">
                        <div class="mb-4 pb-2 border-bottom">
                            <h5 class="font-weight-bold text-dark mb-1 text-uppercase" style="letter-spacing: 0.5px; font-size: 1.05rem;">
                                EMI Cost Breakdown
                            </h5>
                            <small class="text-muted text-uppercase d-block" style="font-size: 0.72rem; letter-spacing: 0.5px;">Estimates are based on reducing balance interest rates</small>
                        </div>

                        <!-- Big Estimated Monthly EMI Card -->
                        <div class="text-center py-4 px-3 mb-4 rounded-3 border" style="background: #FAFDFB;">
                            <span class="text-muted font-weight-bold text-uppercase d-block mb-1" style="font-size: 0.8rem; letter-spacing: 1px;">Estimated Monthly EMI</span>
                            <h2 class="display-5 font-weight-bold mb-1" style="color: #059669;" id="emiMonthlyDisplay">₹2,584</h2>
                            <small class="text-muted font-weight-semibold text-uppercase" id="emiTenureMonthsLabel">FOR 60 MONTHS TENURE</small>
                        </div>

                        <!-- Detailed Breakdown List -->
                        <div class="d-flex flex-column gap-3 mb-4 px-2">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-secondary small font-weight-semibold">Down Payment Made</span>
                                <span class="font-weight-bold text-dark" id="emiRowDownPayment">₹30,000</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-secondary small font-weight-semibold">Loan Principal Amount</span>
                                <span class="font-weight-bold text-dark" id="emiRowPrincipal">₹1,26,000</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-secondary small font-weight-semibold">Interest Rate Charged</span>
                                <span class="font-weight-bold text-dark" id="emiRowInterestRate">8.5% P.A.</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-secondary small font-weight-semibold">Total Interest Payable</span>
                                <span class="font-weight-bold text-dark" id="emiRowTotalInterest">₹29,040</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 pt-3">
                                <span class="font-weight-bold text-dark fs-6">Total Cost (Principal + Interest)</span>
                                <span class="font-weight-bold text-dark fs-5" id="emiRowTotalCost">₹1,55,040</span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-3 border-top">
                            <button class="btn btn-dark w-100 py-3 font-weight-bold text-white shadow-sm rounded-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#siteSurveyModal" style="background: #1F2937;">
                                <i class="fa-solid fa-file-pdf fs-5 text-warning"></i> Download Proposal &amp; Apply Loan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Property Type Toggle Buttons */
.btn-property-type {
    border: 1.5px solid #D1D5DB;
    background: #F9FAFB;
    color: #374151;
    font-weight: 600;
    font-size: 0.85rem;
    padding: 8px 20px;
    border-radius: 50px;
    transition: all 0.22s ease;
    outline: none !important;
    box-shadow: none !important;
}
.btn-property-type:hover {
    border-color: #9CA3AF;
    background: #F3F4F6;
    color: #111827;
}
.btn-property-type.active {
    background: #1F2937;
    color: #ffffff !important;
    border-color: #1F2937;
    box-shadow: 0 4px 14px rgba(31,41,55,0.22) !important;
}
</style>

<!-- Solar Calculator JS Script -->
<script>
let currentCalcMode = 'bill';
let currentSystemType = 'grid';
let currentPropertyType = 'residential';

function switchCalcMode(mode) {
    currentCalcMode = mode;

    // Hide all mode panels
    document.getElementById('panel-bill').classList.add('d-none');
    document.getElementById('panel-kw').classList.add('d-none');
    document.getElementById('panel-roof').classList.add('d-none');
    document.getElementById('panel-emi').classList.add('d-none');

    const standardInputs = document.getElementById('standard-inputs-wrapper');
    const panelStandardResults = document.getElementById('panel-results-standard');
    const panelEmiResults = document.getElementById('panel-results-emi');

    if (mode === 'emi') {
        // EMI Mode: Show EMI input panel, hide standard inputs, show EMI results on right
        document.getElementById('panel-emi').classList.remove('d-none');
        if (standardInputs) standardInputs.classList.add('d-none');
        if (panelStandardResults) panelStandardResults.classList.add('d-none');
        if (panelEmiResults) panelEmiResults.classList.remove('d-none');
        calculateEmiMaster();
    } else {
        // Standard Solar Mode: Show selected input panel, show standard inputs, show standard results on right
        document.getElementById('panel-' + mode).classList.remove('d-none');
        if (standardInputs) standardInputs.classList.remove('d-none');
        if (panelStandardResults) panelStandardResults.classList.remove('d-none');
        if (panelEmiResults) panelEmiResults.classList.add('d-none');
        calculateSolarMaster();
    }
}

function selectPropertyType(btn) {
    // Update active state
    document.querySelectorAll('#propertyTypeGroup .btn-property-type').forEach(b => {
        b.classList.remove('active');
    });
    btn.classList.add('active');
    currentPropertyType = btn.getAttribute('data-type');

    // Auto-toggle PM Subsidy based on property type
    const subsidyToggle = document.getElementById('inputSubsidyToggle');
    if (subsidyToggle) {
        subsidyToggle.checked = (currentPropertyType === 'residential');
    }
    calculateSolarMaster();
}

function setSystemType(type) {
    currentSystemType = type;
    document.querySelectorAll('.system-type-btn').forEach(btn => {
        btn.classList.remove('active', 'btn-dark');
        btn.classList.add('btn-outline-dark');
    });
    
    const activeBtn = document.getElementById('type-' + type);
    if (activeBtn) {
        activeBtn.classList.remove('btn-outline-dark');
        activeBtn.classList.add('active', 'btn-dark');
    }

    const descElem = document.getElementById('sysTypeDesc');
    if (type === 'grid') descElem.innerText = 'Lowest Cost Grid Connected';
    else if (type === 'hybrid') descElem.innerText = 'Grid Connected + Battery Backup';
    else if (type === 'offgrid') descElem.innerText = 'Standalone Battery System';

    calculateSolarMaster();
}

function calculateSolarMaster() {
    let rate = parseFloat(document.getElementById('inputRate').value) || 8;
    let systemKw = 5.0;
    let monthlyBill = 5000;

    if (currentCalcMode === 'bill') {
        monthlyBill = parseFloat(document.getElementById('inputBillSlider').value) || 5000;
        document.getElementById('billValDisplay').innerText = '₹' + monthlyBill.toLocaleString('en-IN');
        let monthlyUnits = monthlyBill / rate;
        systemKw = monthlyUnits / 120;
    } else if (currentCalcMode === 'kw') {
        systemKw = parseFloat(document.getElementById('inputKwSlider').value) || 5.0;
        document.getElementById('kwValDisplay').innerText = systemKw.toFixed(1) + ' kW';
        monthlyBill = Math.round(systemKw * 120 * rate);
    } else if (currentCalcMode === 'roof') {
        let area = parseFloat(document.getElementById('inputRoofSlider').value) || 500;
        document.getElementById('roofValDisplay').innerText = area.toLocaleString('en-IN') + ' sq.ft.';
        systemKw = area / 100;
        monthlyBill = Math.round(systemKw * 120 * rate);
    }

    if (systemKw < 0.5) systemKw = 0.5;
    let roundedKw = parseFloat(systemKw.toFixed(1));
    
    // Core Power Metrics
    let monthlyGen = Math.round(roundedKw * 120);
    let dailyGen = Math.round(monthlyGen / 30);
    let yearlyGen = Math.round(monthlyGen * 12);
    let monthlySavings = Math.round(monthlyGen * rate);
    let yearlySavings = Math.round(monthlySavings * 12);
    let lifetimeSavings = Math.round(yearlySavings * 25);
    
    // Roof Area & Panel Count (575W Panel)
    let reqArea = Math.round(roundedKw * 100);
    let panelsReq = Math.ceil((roundedKw * 1000) / 575);
    let isRoofSuitable = reqArea <= 2500 ? "Yes (Ideal)" : "Commercial Roof Req.";

    // System Type Pricing (per kW)
    let pricePerKw = 45000; // Grid-Tied default
    if (currentSystemType === 'hybrid') pricePerKw = 65000;
    if (currentSystemType === 'offgrid') pricePerKw = 75000;

    let systemCost = Math.round(roundedKw * pricePerKw);

    // Subsidy Calculation (PM Surya Ghar / MNRE Guidelines)
    let isSubsidyApplied = document.getElementById('inputSubsidyToggle') ? document.getElementById('inputSubsidyToggle').checked : true;
    let subsidy = 0;
    if (isSubsidyApplied) {
        if (roundedKw <= 1) subsidy = 30000;
        else if (roundedKw <= 2) subsidy = 60000;
        else subsidy = 78000; // Capped at ₹78,000
    }

    let netCost = Math.max(0, systemCost - subsidy);
    let paybackYears = yearlySavings > 0 ? (netCost / yearlySavings).toFixed(1) : "3.5";
    let co2Tons = (roundedKw * 1.2).toFixed(1);

    // Update UI elements
    document.getElementById('resSystemKw').innerText = roundedKw + ' kW';
    document.getElementById('resRoofArea').innerText = 'Area: ' + reqArea.toLocaleString('en-IN') + ' sq.ft.';
    document.getElementById('resDailyGen').innerText = dailyGen.toLocaleString('en-IN') + ' Units';
    document.getElementById('resMonthlyGen').innerText = monthlyGen.toLocaleString('en-IN') + ' Units';
    document.getElementById('resYearlyGen').innerText = yearlyGen.toLocaleString('en-IN') + ' / Yr';
    
    document.getElementById('resMonthlySavings').innerText = '₹' + monthlySavings.toLocaleString('en-IN');
    document.getElementById('resYearlySavings').innerText = '₹' + yearlySavings.toLocaleString('en-IN');
    document.getElementById('resLifetimeSavings').innerText = '₹' + lifetimeSavings.toLocaleString('en-IN');
    
    document.getElementById('resSystemCost').innerText = '₹' + systemCost.toLocaleString('en-IN');
    document.getElementById('resSubsidy').innerText = '₹' + subsidy.toLocaleString('en-IN');
    document.getElementById('resNetCost').innerText = '₹' + netCost.toLocaleString('en-IN');
    
    document.getElementById('resPanels').innerText = panelsReq + ' Panels';
    document.getElementById('resPayback').innerText = paybackYears + ' Years';
    document.getElementById('resCo2').innerText = '~' + co2Tons + ' Tons';
    document.getElementById('resRoofSuitable').innerText = isRoofSuitable;

    // Sync Net Cost to Loan Calculator & Recalculate EMI
    currentNetSystemCost = netCost;
    calculateEmiMaster();
}

function calculateEmiMaster() {
    const downPayElem = document.getElementById('inputEmiDownPay');
    const rateElem = document.getElementById('inputEmiRate');
    const tenureElem = document.getElementById('inputEmiTenure');
    if (!downPayElem || !rateElem || !tenureElem) return;

    if (currentNetSystemCost > 0) {
        downPayElem.max = currentNetSystemCost;
        if (parseInt(downPayElem.value, 10) > currentNetSystemCost) {
            downPayElem.value = Math.round(currentNetSystemCost * 0.2);
        }
    }

    const downPayment = parseInt(downPayElem.value, 10) || 0;
    const annualRate = parseFloat(rateElem.value) || 8.5;
    const tenureYears = parseInt(tenureElem.value, 10) || 5;

    const principal = Math.max(0, currentNetSystemCost - downPayment);
    const tenureMonths = tenureYears * 12;
    const monthlyRate = annualRate / (12 * 100);

    let monthlyEmi = 0;
    if (principal > 0 && monthlyRate > 0) {
        monthlyEmi = Math.round(
            (principal * monthlyRate * Math.pow(1 + monthlyRate, tenureMonths)) /
            (Math.pow(1 + monthlyRate, tenureMonths) - 1)
        );
    }

    const totalPaid = (monthlyEmi * tenureMonths) + downPayment;
    const totalInterest = Math.max(0, (monthlyEmi * tenureMonths) - principal);

    // Update UI Elements
    document.getElementById('emiDownPayDisplay').innerText = '₹' + downPayment.toLocaleString('en-IN');
    document.getElementById('emiDownMin').innerText = '₹0';
    document.getElementById('emiDownMax').innerText = '₹' + currentNetSystemCost.toLocaleString('en-IN');
    document.getElementById('emiLoanAmountDisplay').innerText = '₹' + principal.toLocaleString('en-IN');
    document.getElementById('emiRateDisplay').innerText = annualRate + '% P.A.';
    document.getElementById('emiTenureDisplay').innerText = tenureYears + (tenureYears === 1 ? ' Year' : ' Years');

    document.getElementById('emiMonthlyDisplay').innerText = '₹' + monthlyEmi.toLocaleString('en-IN');
    document.getElementById('emiTenureMonthsLabel').innerText = 'FOR ' + tenureMonths + ' MONTHS TENURE';

    document.getElementById('emiRowDownPayment').innerText = '₹' + downPayment.toLocaleString('en-IN');
    document.getElementById('emiRowPrincipal').innerText = '₹' + principal.toLocaleString('en-IN');
    document.getElementById('emiRowInterestRate').innerText = annualRate + '% P.A.';
    document.getElementById('emiRowTotalInterest').innerText = '₹' + totalInterest.toLocaleString('en-IN');
    document.getElementById('emiRowTotalCost').innerText = '₹' + totalPaid.toLocaleString('en-IN');
}

function handleCalcLead(e) {
    e.preventDefault();
    const name = document.getElementById('leadName').value;
    const phone = document.getElementById('leadPhone').value;
    const city = document.getElementById('inputCity').value || 'Delhi / NCR';
    const kw = document.getElementById('resSystemKw').innerText;

    alert(`Thank you ${name}! Your free consultation request for a ${kw} solar system in ${city} has been received. Our engineer will call you at ${phone} shortly.`);
    document.getElementById('calcLeadForm').reset();
}

document.addEventListener('DOMContentLoaded', function() {
    calculateSolarMaster();

    const inputs = ['inputBillSlider', 'inputKwSlider', 'inputRoofSlider', 'inputRate', 'inputCity', 'inputEmiDownPay', 'inputEmiRate', 'inputEmiTenure'];
    inputs.forEach(id => {
        const elem = document.getElementById(id);
        if (elem) {
            elem.addEventListener('input', calculateSolarMaster);
            elem.addEventListener('change', calculateSolarMaster);
            elem.addEventListener('keyup', calculateSolarMaster);
        }
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
