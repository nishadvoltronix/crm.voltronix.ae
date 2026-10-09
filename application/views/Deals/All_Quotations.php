<style>
#jobsTable td {
    line-height: 2.8;
}

.wrap-text {
 /* white-space: normal !important;
    word-break: break-word;
 */
}

.cell-scroll {
  max-width: 260px;
  max-height: 60px;
  overflow-y: auto;
  overflow-x: hidden;
  white-space: normal;
  word-break: break-word;
  line-height: 1.4;
}

.status-box {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.bg-success-light {
    background: #e9f7ef;
}

.text-success {
    color: #198754;
}

.bg-hold-light {
    background: #f6c5ca;
}

.text-hold {
    color: #ce0b0b;
}

</style>
<?php
function status_badge($status)
{
    if (empty($status)) {
        return 'secondary';
    }

    switch ($status) {
        case 'Completed':
            return 'warning';

        case 'Process':
            return 'purple';

        case 'Hold':
            return 'dangers';

        case 'Assigned':
            return 'danger';

        default:
            return 'secondary';
    }
}
?>


<div class="col-sm-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                <div class="dt-responsive">
                 <table id="jobsTable" class="table table-hover mb-0 w-100" id="advanced-table">
                  
                  <thead>
                      <tr>
                          <th>Quote Created</th>
                          <th>Quote Number</th>
                          <th>Deal Number</th>
                          <th>Account Name</th>
                          <th>Deal Status</th>
                          <th>Overall Status</th>
                          <th>Salesperson</th>
                          <th>Amount</th>
                          <th>Action</th>
                      </tr>
                  </thead>

                  <tbody>
                      <?php foreach ($records as $row): ?>
                      <tr>
                          <td><?= $row['quote_created_time']; ?></td>
                          <td><?= $row['quote_number']; ?></td>
                          <td><?= $row['deal_number']; ?></td>
                          <td><div class="cell-scroll"><?= $row['account_name']; ?></div></td>
                          <td>
                            <?php if ($row['status'] == 'Pending' || $row['status'] == 'Qualification'){?>  
                          <span class="badge bg-primary"><?php echo $row['status'] ?></span>
                    
                            <?php } elseif ($row['status'] == 'Site Visit'){?>
                                <span class="badge bg-red-500"><?php echo $row['status'] ?></span>
                        
                            <?php } elseif ($row['status'] == 'Proposal' || $row['status'] == 'Proposal/Price Quote'){?>
                                <span class="badge bg-green-500"><?php echo $row['status'] ?></span>
                        
                            <?php } elseif ($row['status'] == 'Close to Won' || $row['status'] == 'Closed Won'){?>
                                <span class="badge bg-yellow-500"><?php echo $row['status'] ?></span>
                    
                            <?php } elseif ($row['status'] == "Close to Lost" || $row['status'] == 'Closed Lost' || $row['status'] == "Omitted" || $row['status'] == 'Proposal-Omitted'){?>
                                <span class="badge bg-pink-500"><?php echo $row['status'] ?></span>
                    
                            <?php } ?>
                            
                          </td>
                          <?php if (empty($row['Job_Status']) || $row['Job_Status'] === 'Active') { ?>
                                <td>
                                    <div class="status-box bg-success-light text-success">
                                        Active
                                    </div>
                                </td>
                          <?php } elseif ($row['Job_Status'] == 'Hold') { ?>
                                <td>
                                    <div class="status-box bg-hold-light text-hold">
                                        <?php echo $row['Job_Status']; ?>
                                    </div>
                                </td>
                          <?php } ?>

                          <td><?= $row['assigned_username']; ?></td>
                          
                          <td><?= number_format($row['service_charge'], 2); ?></td>
                          <td>
                            <a href="<?php echo base_url('index.php/Admincrm/download_deal_pdf/' . $row['id']); ?>">
                             <button class="btn btn-sm btn-danger">
                              <i class="ph ph-download me-1"></i>
                            </button>
                            </a>

                            <a href="<?php echo base_url('index.php/Admincrm/lead_detail/'.$row['id']); ?>">
                             <button class="btn btn-sm btn-secondary">
                              <i class="ph ph-eye me-1"></i>
                            </button>
                            </a>
                            
                          </td>
                      </tr>
                      <?php endforeach; ?>
                  </tbody>

                 </table>
                </div>
                </div>
              </div>
            </div>
          </div>

<script src="<?php echo base_url('include/dist/assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/jquery.dataTables.min.js'); ?>"></script>

<script>
$(function () {
    $('#jobsTable').DataTable({
        searching: true,
        paging: true,
        ordering: true,
        info: true,
        order: [[0, 'desc']]
    });
});
</script>

 <script>
      var animateModal = document.getElementById('animateModal-<?php echo $row['id']; ?>');
      animateModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var recipient = button.getAttribute('data-pc-animate');
   //   var modalTitle = animateModal.querySelector('.modal-title');
        modalTitle.textContent = 'Animate Modal : ' + recipient;
        animateModal.classList.add('anim-' + recipient);
        if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
          document.body.classList.add('anim-' + recipient);
        }
      });
      animateModal.addEventListener('hidden.bs.modal', function (event) {
        removeClassByPrefix(animateModal, 'anim-');
        removeClassByPrefix(document.body, 'anim-');
      });

      function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
          let value = node.classList[i];
          if (value.startsWith(prefix)) {
            node.classList.remove(value);
          }
        }
      }
    </script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
      );

      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
    </script>

    <script id="qv8h1m">
        var tooltipTriggerList = document.querySelectorAll('[title]');
        tooltipTriggerList.forEach(function (el) {
          new bootstrap.Tooltip(el);
        });
    </script>