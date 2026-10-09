<div class="container-fluid mt-4">
  <div class="card shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-2">
  <div>
    <strong>Records on this page:</strong> <?= (int)$page_count ?>
  </div>

  <div>
    <?php if ((int)$page > 1): ?>
      <a class="btn btn-sm btn-secondary"
         href="<?= base_url('index.php/Items/view_items?page=' . ((int)$page - 1)) ?>">
        ? Previous
      </a>
    <?php endif; ?>

    <?php if (!empty($more_records)): ?>
      <a class="btn btn-sm btn-primary"
         href="<?= base_url('index.php/Items/view_items?page=' . ((int)$page + 1)) ?>">
        Next ?
      </a>
    <?php endif; ?>
  </div>
</div>
    <div class="card-body">

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
          <strong>Zoho Error</strong>
          <pre style="white-space:pre-wrap;"><?= htmlspecialchars(print_r($error, true)) ?></pre>
        </div>
      <?php endif; ?>

      <?php if (empty($items)): ?>
        <div class="alert alert-warning">No items found.</div>
      <?php else: ?>

      <div class="table-responsive">
        <table id="itemsTable" class="table table-bordered table-hover table-sm w-100">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>Item Name (best guess)</th>
              <th>Modified</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $i => $it): ?>
              <?php
                // Best-guess name field (since you said "leave it")
                $name = $it['Name'] ?? $it['Item_Name'] ?? $it['Product_Name'] ?? $it['item_name'] ?? $it['name'] ?? '';
                $modified = $it['Modified_Time'] ?? $it['modified_time'] ?? '';
                $rawJson = json_encode($it, JSON_PRETTY_PRINT);
              ?>
              <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($name) ?></td>
              <!--  <td><?= htmlspecialchars($it['id'] ?? '') ?></td> -->
                <td><?= htmlspecialchars($modified) ?></td>
                
              </tr>
              <tr class="collapse" id="raw<?= $i ?>">
                <td colspan="5">
                  <pre style="white-space:pre-wrap; margin:0;"><?= htmlspecialchars($rawJson) ?></pre>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <?php endif; ?>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
  const t = $('#itemsTable').DataTable({
    pageLength: 10,
    searching: true,
    ordering: true,
    info: true,
    language: {
      search: "Search Items:",
      info: "Showing _START_ to _END_ of _TOTAL_ items"
    }
  });

  // Update total count on search filter
  t.on('draw', function () {
    $('#totalCount').text(t.rows({ filter: 'applied' }).count());
  });
});
</script>
