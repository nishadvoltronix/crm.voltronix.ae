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

.bg-success-dark {
    background: #1b8f4d;
}

.text-success-closed {
    color: #ffffff;
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
                          <th>Date Created</th>
                          <th>Deal No.</th>
                          <th>Job No.</th>
                          <th>Account Name</th>
                          <th>Deal Status</th>
                          <th>Salesperson</th>
                          <th>Amount</th>
                          <th>Action</th>
                      </tr>
                  </thead>

                  <tbody>
                      <?php foreach ($records as $row): ?>
                      <tr>
                          <td><?= $row['created_at']; ?></td>
                          <td><?= $row['qual_deal_number']; ?></td>
                          <td><?= $row['job_deal_number']; ?></td>
                          <td><div class="cell-scroll"><?= $row['account_name']; ?></div></td>
                          <td><span class="badge bg-success">Pending</span></td>
                          <td><?= $row['assigned_username']; ?></td>
                          
                          <td><?= number_format($row['service_charge'], 2); ?></td>
                          <td><a href="<?php echo base_url('index.php/admincrm/lead_detail/'.$row['id']); ?>">
                             <button class="btn btn-sm btn-outline-secondary">
                              <i class="ph ph-eye"></i>
                            </button></a>
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