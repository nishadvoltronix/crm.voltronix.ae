    <style>
        /* ===== PIPELINE LAYOUT ===== */
        /* Make each pipeline column full height */
.pipeline-wrapper {
    display: flex;
    gap: 1rem; /* spacing between columns */
}

/* Each column should be a flex container, vertical */
.pipeline-column {
    display: flex;
    flex-direction: column;
    height: 80vh; /* adjust as needed */
    background: #f4f6f9;
    border-radius: 12px;
}

/* Sticky header */
.pipeline-header {
    padding: 12px;
    border-radius: 12px 12px 0 0;
    z-index: 2;
}

.pipeline-body {
    padding: 10px;
    overflow-y: auto;
    flex-grow: 1;
}

/* Scrollbar width */
.pipeline-body::-webkit-scrollbar {
    width: 12px;
}

/* Track */
.pipeline-body::-webkit-scrollbar-track {
    background: #f0f2f5;           /* light background for track */
    border-radius: 10px;
    margin: 4px 0;                 /* vertical spacing */
}

/* Scrollbar thumb */
.pipeline-body::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #009ef7, #7460ee);  /* gradient thumb */
    border-radius: 10px;
    border: 3px solid #f0f2f5;    /* creates padding effect */
}

/* Thumb hover */
.pipeline-body::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #007acb, #5a3de0);
}

/* Optional: scrollbar corners (bottom-right) */
.pipeline-body::-webkit-scrollbar-corner {
    background: transparent;
}


        .pipeline-count {
            background: rgba(255,255,255,0.25);
            color: #fff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }


        /* ===== LEAD CARD ===== */
        .lead-card {
            background: #fff;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .lead-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(0,0,0,0.08);
        }

        .lead-title {
            font-weight: 600;
            font-size: 14px;
        }

        .lead-sub {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 6px;
        }

        .lead-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .lead-value {
            font-size: 13px;
            font-weight: 600;
        }

        .lead-won {
            border-left: 4px solid #28a745;
        }
        
        .lead-lost {
            border-left: 4px solid #dc3545;
        }
        
    </style>


<div class="container-fluid">

    <!-- ===== PAGE HEADER ===== -->
    <div class="row mb-3">
        <div class="col-md-6">
            
        </div>

        <!-- SEARCH BAR -->
        <div class="col-md-6">
            <div class="input-group float-end" style="max-width:300px;">
                <span class="input-group-text bg-white">
                    <i class="ph ph-magnifying-glass"></i>
                </span>
                <input type="text" id="leadSearch" class="form-control"
                       placeholder="Search leads...">
            </div>
        </div>
    </div>

    <!-- ===== PIPELINE ===== -->
    <div class="row gx-3 pipeline-wrapper">

        <!-- QUALIFICATION -->
        <div class="col-md">
            <div class="pipeline-column">
                <div class="pipeline-header bg-secondary d-flex justify-content-between align-items-center sticky-top">
                    <div>
                        <h6 class="mb-0 text-white">Qualification</h6>
                        <small class="text-gray-100">Early discussion</small>
                    </div>
                    <span class="pipeline-count"><?php echo $pending_qualification_count; ?></span>
                </div>

                <div class="pipeline-body">
                   
                    <?php 
                        foreach($records as $record) {
                    ?>
                    <?php if($record['status'] == "Pending" || $record['status'] == "Qualification"){ ?>
                    
                    <div class="lead-card searchable">

                        <div class="lead-title fw-semibold">
                            <?php echo $record['account_name']; ?>
                        </div>

                        <!-- Deal Title -->
                        <div class="lead-title fw-semibold">
                            <?php echo $record['deal_name']; ?>
                        </div>

                        <!-- Deal Number -->
                        <div class="lead-sub text-muted" style="font-size: 0.95rem;">
                            <i class="ph ph-hash me-1"></i>
                            <?php echo !empty($record['qual_deal_number']) ? $record['qual_deal_number'] : 'No deal number'; ?>
                        </div>

                        <!-- Assigned User --> 
                        <div class="lead-meta mt-2"> 
                            <span> <i class="ph ph-user-check ph-lg text-success"></i> 
                                <?php echo !empty($record['assigned_username']) ? $record['assigned_username'] : 'Not Assigned'; ?>
                            </span> </span> </div>


                        <!-- Price -->
                        <div class="lead-price mt-2 fw-semibold text-success" style="font-size: 1.05rem;">
                            <i class="ph ph-currency-dollar me-1"></i>
                            <?php echo !empty($record['service_charge']) ? number_format($record['service_charge'], 2) : '0.00'; ?>
                        </div>

                        <!-- Footer -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge bg-primary"><?php echo $record['status']; ?></span>

                            <a href="<?php echo base_url('index.php/admincrm/lead_detail/'.$record['id']); ?>"
                               class="btn btn-sm btn-outline-secondary">
                                View Details
                            </a>
                        </div>

                    </div>


                    
                    <?php } } ?>

                </div>
            </div>
        </div>

        <!-- SITE VISIT -->
        <div class="col-md">
            <div class="pipeline-column">
                <div class="pipeline-header bg-secondary d-flex justify-content-between align-items-center sticky-top">
                    <div>
                        <h6 class="mb-0 text-white">Site Visit</h6>
                        <small class="text-gray-100">Inspection</small>
                    </div>
                    <span class="pipeline-count"><?php echo $pending_site_visit_count; ?></span>
                </div>

                <div class="pipeline-body">
                    
                    <?php 
                        foreach($records as $record) {
                    ?>
                    <?php if($record['status'] == "Site Visit"){ ?>
                    
                    <div class="lead-card searchable">

                        <div class="lead-title fw-semibold">
                            <?php echo $record['account_name']; ?>
                        </div>

                        <!-- Deal Title -->
                        <div class="lead-title fw-semibold">
                            <?php echo $record['deal_name']; ?>
                        </div>

                        <!-- Site Number -->
                        <div class="lead-sub text-muted" style="font-size: 0.95rem;">
                            <i class="ph ph-hash me-1"></i>
                            <?php echo !empty($record['site_deal_number']) ? $record['site_deal_number'] : 'No site number'; ?>
                        </div>

                        <!-- Assigned User --> 
                        <div class="lead-meta mt-2"> 
                            <span> <i class="ph ph-user-check ph-lg text-success"></i> 
                                <?php echo !empty($record['assigned_username']) ? $record['assigned_username'] : 'Not Assigned'; ?>
                            </span> </span> </div>


                        <!-- Price -->
                        <div class="lead-price mt-2 fw-semibold text-success" style="font-size: 1.05rem;">
                            <i class="ph ph-currency-dollar me-1"></i>
                            <?php echo !empty($record['service_charge']) ? number_format($record['service_charge'], 2) : '0.00'; ?>
                        </div>

                        <!-- Footer -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge bg-red-500"><?php echo $record['status']; ?></span>

                            <a href="<?php echo base_url('index.php/admincrm/lead_detail/'.$record['id']); ?>"
                               class="btn btn-sm btn-outline-secondary">
                                View Details
                            </a>
                        </div>

                    </div>
                
                    <?php } } ?>
                    
                </div>
            </div>
        </div>

        <!-- PROPOSAL -->
        <div class="col-md">
            <div class="pipeline-column">
                <div class="pipeline-header bg-secondary d-flex justify-content-between align-items-center sticky-top">
                    <div>
                        <h6 class="mb-0 text-white">Proposal</h6>
                        <small class="text-gray-100">Awaiting approval</small>
                    </div>
                    <span class="pipeline-count"><?php echo $pending_proposal_count; ?></span>
                </div>

                <div class="pipeline-body">
                    <div class="pipeline-body">
                    
                    <?php 
                        foreach($records as $record) {
                    ?>
                    <?php if($record['status'] == "Proposal" || $record['status'] == "Proposal/Price Quote"){ ?>
                    
                    <div class="lead-card searchable">

                        <div class="lead-title fw-semibold">
                            <?php echo $record['account_name']; ?>
                        </div>

                        <!-- Deal Title -->
                        <div class="lead-title fw-semibold">
                            <?php echo $record['deal_name']; ?>
                        </div>

                        <!-- Deal Number -->
                        <div class="lead-sub text-muted" style="font-size: 0.95rem;">
                            <i class="ph ph-hash me-1"></i>
                            <?php echo !empty($record['quote_deal_number']) ? $record['quote_deal_number'] : 'No quote number'; ?>
                        </div>

                        <!-- Assigned User --> 
                        <div class="lead-meta mt-2"> 
                            <span> <i class="ph ph-user-check ph-lg text-success"></i> 
                                <?php echo !empty($record['assigned_username']) ? $record['assigned_username'] : 'Not Assigned'; ?>
                            </span> </span> </div>


                        <!-- Price -->
                        <div class="lead-price mt-2 fw-semibold text-success" style="font-size: 1.05rem;">
                            <i class="ph ph-currency-dollar me-1"></i>
                            <?php echo !empty($record['service_charge']) ? number_format($record['service_charge'], 2) : '0.00'; ?>
                        </div>

                        <!-- Footer -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge bg-green-500">Proposal</span>

                            <a href="<?php echo base_url('index.php/admincrm/lead_detail/'.$record['id']); ?>"
                               class="btn btn-sm btn-outline-secondary">
                                View Details
                            </a>
                        </div>

                    </div>
                
                    <?php } } ?>
                    
                </div>
                    
                </div>
            </div>
        </div>

        <!-- CLOSED WON -->
        <div class="col-md">
            <div class="pipeline-column">
                <div class="pipeline-header bg-yellow-500 d-flex justify-content-between align-items-center sticky-top">
                    <div>
                        <h6 class="mb-0 text-white">Closed Won</h6>
                        <small class="text-gray-100">Confirmed</small>
                    </div>
                    <span class="pipeline-count"><?php echo $pending_won_count; ?></span>
                </div>

                <div class="pipeline-body">
                    
                    <?php 
                        foreach($records as $record) {
                    ?>
                    <?php if($record['status'] == "Close to Won" || $record['status'] == "Closed Won"){ ?>
                    
                    <div class="lead-card searchable">

                        <div class="lead-title fw-semibold">
                            <?php echo $record['account_name']; ?>
                        </div>

                        <!-- Deal Title -->
                        <div class="lead-title fw-semibold">
                            <?php echo $record['deal_name']; ?>
                        </div>

                        <!-- Job Number -->
                        <div class="lead-sub text-muted" style="font-size: 0.95rem;">
                            <i class="ph ph-hash me-1"></i>
                            <?php echo !empty($record['job_deal_number']) ? $record['job_deal_number'] : 'No job number'; ?>
                        </div>

                        <!-- Assigned User --> 
                        <div class="lead-meta mt-2"> 
                            <span> <i class="ph ph-user-check ph-lg text-success"></i> 
                                <?php echo !empty($record['assigned_username']) ? $record['assigned_username'] : 'Not Assigned'; ?>
                            </span> </span> </div>


                        <!-- Price -->
                        <div class="lead-price mt-2 fw-semibold text-success" style="font-size: 1.05rem;">
                            <i class="ph ph-currency-dollar me-1"></i>
                            <?php echo !empty($record['service_charge']) ? number_format($record['service_charge'], 2) : '0.00'; ?>
                        </div>

                        <!-- Footer -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge bg-yellow-500"><?php echo $record['status']; ?></span>

                            <a href="<?php echo base_url('index.php/admincrm/lead_detail/'.$record['id']); ?>"
                               class="btn btn-sm btn-outline-secondary">
                                View Details
                            </a>
                        </div>

                    </div>
                
                    <?php } } ?>
                    
                </div>
            </div>
        </div>
        
        <!-- LOST -->
        <div class="col-md">
            <div class="pipeline-column">
                <div class="pipeline-header bg-pink-500 d-flex justify-content-between align-items-center sticky-top">
                    <div>
                        <h6 class="mb-0 text-white">Lost</h6>
                        <small class="text-gray-100">Confirmed</small>
                    </div>
                    <span class="pipeline-count"><?php echo $pending_ommitted_count; ?></span>
                </div>

                <div class="pipeline-body">
                    
                    <?php 
                        foreach($records as $record) {
                    ?>
                    <?php if($record['status'] == "Close to Lost" || $record['status'] == "Closed Lost" || $record['status'] == "Omitted" || $record['status'] == 'Proposal-Omitted'){ ?>
                    
                    <div class="lead-card searchable">

                        <div class="lead-title fw-semibold">
                            <?php echo $record['account_name']; ?>
                        </div>

                        <!-- Deal Title -->
                        <div class="lead-title fw-semibold">
                            <?php echo $record['deal_name']; ?>
                        </div>

                        <!-- Lost Number -->
                        <div class="lead-sub text-muted" style="font-size: 0.95rem;">
                            <i class="ph ph-hash me-1"></i>
                            <?php echo !empty($record['lost_deal_number']) ? $record['lost_deal_number'] : 'No lost number'; ?>
                        </div>

                        <!-- Assigned User --> 
                        <div class="lead-meta mt-2"> 
                            <span> <i class="ph ph-user-check ph-lg text-success"></i> 
                                <?php echo !empty($record['assigned_username']) ? $record['assigned_username'] : 'Not Assigned'; ?>
                            </span> </span> </div>


                        <!-- Price -->
                        <div class="lead-price mt-2 fw-semibold text-success" style="font-size: 1.05rem;">
                            <i class="ph ph-currency-dollar me-1"></i>
                            <?php echo !empty($record['service_charge']) ? number_format($record['service_charge'], 2) : '0.00'; ?>
                        </div>

                        <!-- Footer -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge bg-pink-500"><?php echo $record['status']; ?></span>

                            <a href="<?php echo base_url('index.php/admincrm/lead_detail/'.$record['id']); ?>"
                               class="btn btn-sm btn-outline-secondary">
                                View Details
                            </a>
                        </div>

                    </div>
                
                    <?php } } ?>
                    
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ===== SEARCH SCRIPT ===== -->
<script>
document.getElementById('leadSearch').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    let cards = document.querySelectorAll('.searchable');

    cards.forEach(card => {
        card.style.display = card.innerText.toLowerCase().includes(value)
            ? 'block'
            : 'none';
    });
});
</script>