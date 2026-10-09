<style>
.pipeline-wrapper {
    display: flex;
    gap: 1rem;
}

.pipeline-column {
    display: flex;
    flex-direction: column;
    height: 80vh;
    background: #f4f6f9;
    border-radius: 12px;
}

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

.pipeline-body::-webkit-scrollbar {
    width: 12px;
}

.pipeline-body::-webkit-scrollbar-track {
    background: #f0f2f5;
    border-radius: 10px;
    margin: 4px 0;
}

.pipeline-body::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #009ef7, #7460ee);
    border-radius: 10px;
    border: 3px solid #f0f2f5;
}

.pipeline-body::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #007acb, #5a3de0);
}

.pipeline-count {
    background: rgba(255,255,255,0.25);
    color: #fff;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

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

.lead-price {
    font-size: 1.05rem;
}

.d-none {
    display: none !important;
}
</style>

<div class="container-fluid">

    <div class="row mb-3">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="d-flex justify-content-end" style="gap:10px;">

                <select id="agentFilter" class="form-control" style="max-width:220px;">
                    <option value="">All Agents</option>
                    <option value="not assigned">Not Assigned</option>

                    <?php
                        $agents = [];

                        foreach ($records as $record) {
                            if (!empty($record['assigned_username'])) {
                                $agents[] = trim($record['assigned_username']);
                            }
                        }

                        $agents = array_unique($agents);
                        sort($agents);

                        foreach ($agents as $agent) {
                    ?>
                        <option value="<?php echo htmlspecialchars(strtolower(trim($agent))); ?>">
                            <?php echo htmlspecialchars($agent); ?>
                        </option>
                    <?php } ?>
                </select>

                <div class="input-group" style="max-width:300px;">
                    <span class="input-group-text bg-white">
                        <i class="ph ph-magnifying-glass"></i>
                    </span>
                    <input type="text" id="leadSearch" class="form-control" placeholder="Search leads...">
                </div>

            </div>
        </div>
    </div>

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
                    <?php foreach($records as $record) { ?>
                    <?php if($record['status'] == "Pending" || $record['status'] == "Qualification"){ ?>

                    <div class="lead-card searchable"
                         data-agent="<?php echo htmlspecialchars(strtolower(trim(!empty($record['assigned_username']) ? $record['assigned_username'] : 'not assigned'))); ?>"
                         data-search="<?php echo htmlspecialchars(strtolower(
                            ($record['account_name'] ?? '') . ' ' .
                            ($record['deal_name'] ?? '') . ' ' .
                            ($record['assigned_username'] ?? '') . ' ' .
                            ($record['status'] ?? '') . ' ' .
                            ($record['qual_deal_number'] ?? '')
                         )); ?>">

                        <div class="lead-title"><?php echo $record['account_name']; ?></div>
                        <div class="lead-title"><?php echo $record['deal_name']; ?></div>

                        <div class="lead-sub">
                            <i class="ph ph-hash me-1"></i>
                            <?php echo !empty($record['qual_deal_number']) ? $record['qual_deal_number'] : 'No deal number'; ?>
                        </div>

                        <div class="lead-meta mt-2">
                            <span>
                                <i class="ph ph-user-check ph-lg text-success"></i>
                                <?php echo !empty($record['assigned_username']) ? $record['assigned_username'] : 'Not Assigned'; ?>
                            </span>
                        </div>

                        <div class="lead-price mt-2 fw-semibold text-success">
                            <i class="ph ph-currency-dollar me-1"></i>
                            <?php echo !empty($record['service_charge']) ? number_format($record['service_charge'], 2) : '0.00'; ?>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge bg-primary"><?php echo $record['status']; ?></span>

                            <a href="<?php echo base_url('index.php/admincrm/lead_detail/'.$record['id']); ?>"
                               class="btn btn-sm btn-outline-secondary">
                                View Details
                            </a>
                        </div>
                    </div>

                    <?php } ?>
                    <?php } ?>
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
                    <?php foreach($records as $record) { ?>
                    <?php if($record['status'] == "Site Visit"){ ?>

                    <div class="lead-card searchable"
                         data-agent="<?php echo htmlspecialchars(strtolower(trim(!empty($record['assigned_username']) ? $record['assigned_username'] : 'not assigned'))); ?>"
                         data-search="<?php echo htmlspecialchars(strtolower(
                            ($record['account_name'] ?? '') . ' ' .
                            ($record['deal_name'] ?? '') . ' ' .
                            ($record['assigned_username'] ?? '') . ' ' .
                            ($record['status'] ?? '') . ' ' .
                            ($record['site_deal_number'] ?? '')
                         )); ?>">

                        <div class="lead-title"><?php echo $record['account_name']; ?></div>
                        <div class="lead-title"><?php echo $record['deal_name']; ?></div>

                        <div class="lead-sub">
                            <i class="ph ph-hash me-1"></i>
                            <?php echo !empty($record['site_deal_number']) ? $record['site_deal_number'] : 'No site number'; ?>
                        </div>

                        <div class="lead-meta mt-2">
                            <span>
                                <i class="ph ph-user-check ph-lg text-success"></i>
                                <?php echo !empty($record['assigned_username']) ? $record['assigned_username'] : 'Not Assigned'; ?>
                            </span>
                        </div>

                        <div class="lead-price mt-2 fw-semibold text-success">
                            <i class="ph ph-currency-dollar me-1"></i>
                            <?php echo !empty($record['service_charge']) ? number_format($record['service_charge'], 2) : '0.00'; ?>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge bg-red-500"><?php echo $record['status']; ?></span>

                            <a href="<?php echo base_url('index.php/admincrm/lead_detail/'.$record['id']); ?>"
                               class="btn btn-sm btn-outline-secondary">
                                View Details
                            </a>
                        </div>
                    </div>

                    <?php } ?>
                    <?php } ?>
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
                    <?php foreach($records as $record) { ?>
                    <?php if($record['status'] == "Proposal" || $record['status'] == "Proposal/Price Quote"){ ?>

                    <div class="lead-card searchable"
                         data-agent="<?php echo htmlspecialchars(strtolower(trim(!empty($record['assigned_username']) ? $record['assigned_username'] : 'not assigned'))); ?>"
                         data-search="<?php echo htmlspecialchars(strtolower(
                            ($record['account_name'] ?? '') . ' ' .
                            ($record['deal_name'] ?? '') . ' ' .
                            ($record['assigned_username'] ?? '') . ' ' .
                            ($record['status'] ?? '') . ' ' .
                            ($record['quote_deal_number'] ?? '')
                         )); ?>">

                        <div class="lead-title"><?php echo $record['account_name']; ?></div>
                        <div class="lead-title"><?php echo $record['deal_name']; ?></div>

                        <div class="lead-sub">
                            <i class="ph ph-hash me-1"></i>
                            <?php echo !empty($record['quote_deal_number']) ? $record['quote_deal_number'] : 'No quote number'; ?>
                        </div>

                        <div class="lead-meta mt-2">
                            <span>
                                <i class="ph ph-user-check ph-lg text-success"></i>
                                <?php echo !empty($record['assigned_username']) ? $record['assigned_username'] : 'Not Assigned'; ?>
                            </span>
                        </div>

                        <div class="lead-price mt-2 fw-semibold text-success">
                            <i class="ph ph-currency-dollar me-1"></i>
                            <?php echo !empty($record['service_charge']) ? number_format($record['service_charge'], 2) : '0.00'; ?>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge bg-green-500">Proposal</span>

                            <a href="<?php echo base_url('index.php/admincrm/lead_detail/'.$record['id']); ?>"
                               class="btn btn-sm btn-outline-secondary">
                                View Details
                            </a>
                        </div>
                    </div>

                    <?php } ?>
                    <?php } ?>
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
                    <?php foreach($records as $record) { ?>
                    <?php if($record['status'] == "Close to Won" || $record['status'] == "Closed Won"){ ?>

                    <div class="lead-card searchable"
                         data-agent="<?php echo htmlspecialchars(strtolower(trim(!empty($record['assigned_username']) ? $record['assigned_username'] : 'not assigned'))); ?>"
                         data-search="<?php echo htmlspecialchars(strtolower(
                            ($record['account_name'] ?? '') . ' ' .
                            ($record['deal_name'] ?? '') . ' ' .
                            ($record['assigned_username'] ?? '') . ' ' .
                            ($record['status'] ?? '') . ' ' .
                            ($record['job_deal_number'] ?? '')
                         )); ?>">

                        <div class="lead-title"><?php echo $record['account_name']; ?></div>
                        <div class="lead-title"><?php echo $record['deal_name']; ?></div>

                        <div class="lead-sub">
                            <i class="ph ph-hash me-1"></i>
                            <?php echo !empty($record['job_deal_number']) ? $record['job_deal_number'] : 'No job number'; ?>
                        </div>

                        <div class="lead-meta mt-2">
                            <span>
                                <i class="ph ph-user-check ph-lg text-success"></i>
                                <?php echo !empty($record['assigned_username']) ? $record['assigned_username'] : 'Not Assigned'; ?>
                            </span>
                        </div>

                        <div class="lead-price mt-2 fw-semibold text-success">
                            <i class="ph ph-currency-dollar me-1"></i>
                            <?php echo !empty($record['service_charge']) ? number_format($record['service_charge'], 2) : '0.00'; ?>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge bg-yellow-500"><?php echo $record['status']; ?></span>

                            <a href="<?php echo base_url('index.php/admincrm/lead_detail/'.$record['id']); ?>"
                               class="btn btn-sm btn-outline-secondary">
                                View Details
                            </a>
                        </div>
                    </div>

                    <?php } ?>
                    <?php } ?>
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
                    <?php foreach($records as $record) { ?>
                    <?php if($record['status'] == "Close to Lost" || $record['status'] == "Closed Lost" || $record['status'] == "Omitted" || $record['status'] == "Proposal-Omitted"){ ?>

                    <div class="lead-card searchable"
                         data-agent="<?php echo htmlspecialchars(strtolower(trim(!empty($record['assigned_username']) ? $record['assigned_username'] : 'not assigned'))); ?>"
                         data-search="<?php echo htmlspecialchars(strtolower(
                            ($record['account_name'] ?? '') . ' ' .
                            ($record['deal_name'] ?? '') . ' ' .
                            ($record['assigned_username'] ?? '') . ' ' .
                            ($record['status'] ?? '') . ' ' .
                            ($record['lost_deal_number'] ?? '')
                         )); ?>">

                        <div class="lead-title"><?php echo $record['account_name']; ?></div>
                        <div class="lead-title"><?php echo $record['deal_name']; ?></div>

                        <div class="lead-sub">
                            <i class="ph ph-hash me-1"></i>
                            <?php echo !empty($record['lost_deal_number']) ? $record['lost_deal_number'] : 'No lost number'; ?>
                        </div>

                        <div class="lead-meta mt-2">
                            <span>
                                <i class="ph ph-user-check ph-lg text-success"></i>
                                <?php echo !empty($record['assigned_username']) ? $record['assigned_username'] : 'Not Assigned'; ?>
                            </span>
                        </div>

                        <div class="lead-price mt-2 fw-semibold text-success">
                            <i class="ph ph-currency-dollar me-1"></i>
                            <?php echo !empty($record['service_charge']) ? number_format($record['service_charge'], 2) : '0.00'; ?>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge bg-pink-500"><?php echo $record['status']; ?></span>

                            <a href="<?php echo base_url('index.php/admincrm/lead_detail/'.$record['id']); ?>"
                               class="btn btn-sm btn-outline-secondary">
                                View Details
                            </a>
                        </div>
                    </div>

                    <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('leadSearch');
    const agentFilter = document.getElementById('agentFilter');

    function filterLeads() {
        const searchValue = searchInput.value.trim().toLowerCase();
        const agentValue = agentFilter.value.trim().toLowerCase();

        const cards = document.querySelectorAll('.lead-card.searchable');

        cards.forEach(function(card) {
            const searchText = card.getAttribute('data-search') || '';
            const agentName = card.getAttribute('data-agent') || '';

            const matchSearch = searchValue === '' || searchText.includes(searchValue);
            const matchAgent = agentValue === '' || agentName === agentValue;

            if (matchSearch && matchAgent) {
                card.classList.remove('d-none');
            } else {
                card.classList.add('d-none');
            }
        });
    }

    searchInput.addEventListener('input', filterLeads);
    agentFilter.addEventListener('change', filterLeads);

});
</script>