<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">




<!-- [ Main Content ] start -->
        <div class="row">
          <!-- [ sample-page ] start -->
          <div class="col-sm-12">
            <div id="basicwizard" class="form-wizard row justify-content-center">
             
              <div class="col-12">
                <div class="card">
                  <div class="card-body p-3">
                    <ul class="nav nav-pills nav-justified">
                      <li class="nav-item" data-target-form="#contactDetailForm">
                        <a href="#LeadDetail" data-bs-toggle="tab" class="nav-link active">
                          <i class="ph ph-user-circle"></i>
                          <span class="d-none d-sm-inline">Details</span>
                        </a>
                      </li>
                      <!-- end nav item -->
                      <li class="nav-item" data-target-form="#jobDetailForm">
                        <a href="#ElectricalDetail" data-bs-toggle="tab" class="nav-link icon-btn">
                          <i class="ph ph-lightning"></i>
                          <span class="d-none d-sm-inline">Electrical</span>
                        </a>
                      </li>
                      <!-- end nav item -->
                      <li class="nav-item" data-target-form="#educationDetailForm">
                        <a href="#CivilDetail" data-bs-toggle="tab" class="nav-link icon-btn">
                          <i class="ph ph-buildings"></i>
                          <span class="d-none d-sm-inline">Civil</span>
                        </a>
                      </li>
                      <!-- end nav item -->
                      <li class="nav-item">
                        <a href="#PMDetail" data-bs-toggle="tab" class="nav-link icon-btn">
                          <i class="ph ph-user-gear"></i>
                          <span class="d-none d-sm-inline">Project Manager</span>
                        </a>
                      </li>
                      <!-- end nav item -->
                      <li class="nav-item">
                        <a href="#SWGDetail" data-bs-toggle="tab" class="nav-link icon-btn">
                          <i class="ph ph-plug"></i>
                          <span class="d-none d-sm-inline">Switchgear</span>
                        </a>
                      </li>
                      <!-- end nav item -->
                      <li class="nav-item">
                        <a href="#MTNDetail" data-bs-toggle="tab" class="nav-link icon-btn">
                          <i class="ph ph-wrench"></i>
                          <span class="d-none d-sm-inline">Maintenance</span>
                        </a>
                      </li>
                      <!-- end nav item -->
                    </ul>
                  </div>
                </div>
                <div class="card" style="background-color: #F4F7FA">
                  <div class="card-body">
                    <div class="tab-content">
                      <!-- START: Define your progress bar here -->
                      <div id="bar" class="progress mb-3" style="height: 7px">
                        <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                      </div>
                      <!-- END: Define your progress bar here -->
                      <!-- START: Define your tab pans here -->
                      <div class="tab-pane show active" id="LeadDetail">
                        <!-- [ task-detail-left ] start -->
                         <div class="row">
                            <div class="col-xxl-3 col-xl-4 col-lg-12">
                              
                              <div class="card">
                                <div class="card-header">
                                  <h5>Job Details</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                  <li class="list-group-item d-flex justify-content-between">
                                    <div class="h6 m-0"><i class="ph ph-code-block align-middle f-20 text-dangers"></i> Deal Name:</div>
                                    <div><a class="link-secondary"> <?php echo $data['deal_name'] ?></a></div>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between">
                                    <div class="h6 m-0"><i class="ph ph-user-circle align-middle f-20 text-dangers"></i> Assigned To:</div>
                                    <div><?php echo $data['agent_assigned_name'] ?></div>
                                  </li>  
                                  <li class="list-group-item d-flex justify-content-between">
                                    <div class="h6 m-0"><i class="ph ph ph-list-numbers align-middle f-20 text-dangers"></i> Deal No.:</div>
                                    <div><?php echo $data['qual_deal_number'] ?></div>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between">
                                    <div class="h6 m-0"><i class="ph ph ph-list-numbers align-middle f-20 text-dangers"></i> Quote No.:</div>
                                    <div><?php echo $data['quote_deal_number'] ?></div>
                                  </li> 
                                  <li class="list-group-item d-flex justify-content-between">
                                    <div class="h6 m-0"><i class="ph ph ph-list-numbers align-middle f-20 text-dangers"></i> Job No.:</div>
                                    <div><?php echo $data['job_deal_number'] ?></div>
                                  </li>  
                                  <li class="list-group-item d-flex justify-content-between">
                                    <div class="h6 m-0"><i class="ph ph-calendar-dots align-middle f-20 text-dangers"></i> Created :</div>
                                    <div><?php echo $data['created_at'] ?></div>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between">
                                    <div class="h6 m-0"><i class="ph ph-calendar-dots align-middle f-20 text-dangers"></i> Updated :</div>
                                    <div><?php echo $data['updated_at'] ?></div>
                                  </li>  
                                  <li class="list-group-item d-flex justify-content-between">
                                    <div class="h6 m-0"><i class="ph ph-flag-checkered align-middle f-20 text-dangers"></i> Status :</div>
                                    <div>
                                        
                                        <?php if ($data['status'] == 'Pending'){?>  
                                            <span class="badge bg-primary"><?php echo $data['status'] ?></div></span>
                                      
                                        <?php } elseif ($data['status'] == 'Site Visit'){?>
                                            <span class="badge bg-red-500"><?php echo $data['status'] ?></div></span>
                                  
                                        <?php } elseif ($data['status'] == 'Proposal'){?>
                                            <span class="badge bg-green-500"><?php echo $data['status'] ?></div></span>
                                  
                                        <?php } elseif ($data['status'] == 'Close to Won' || $data['status'] == 'Closed Won'){?>
                                            <span class="badge bg-yellow-500"><?php echo $data['status'] ?></div></span>
                              
                                        <?php } elseif ($data['status'] == "Close to Lost" || $data['status'] == "Omitted" || $data['status'] == 'Proposal-Omitted'){?>
                                            <span class="badge bg-pink-500"><?php echo $data['status'] ?></div></span>
                                
                                        <?php } ?>
                                        
                                  </li>
                                </ul>
                              </div>
                              <div class="card">
                                <div class="card-header">
                                  <h5>Attached Files</h5>
                                </div>
                                  
                                      <ul class="list-group list-group-flush">
                                  
                                          <?php if (!empty($attachments)): ?>
                                          <?php foreach ($attachments as $file): ?>

                                              <?php if ($file['file_type'] == 'image/png' || $file['file_type'] == 'image/jpeg' || $file['file_type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){ ?>
                                              <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                              <div class="row align-items-center">
                                                                <div class="col-auto pe-0">
                                                                  <i class="ph ph-image-square f-28 text-primary"></i>
                                                                </div>
                                                                <div class="col">
                                                                  <a href="#!"><span class="h6"><?php echo $file['file_name']; ?></span></a>
                                                                  <small class="text-muted d-block">Size: <?php echo formatFileSize($file['file_size']); ?>| Created At:<?php  echo $file['created_at']; ?></small>
                                                                </div>
                                                              </div>
                                                            </div>
                                                
                                                            <?php
                                                              $filePath = FCPATH . 'uploads/deal_attachments/' . $file['file_name'];
                                                              $fileUrl  = base_url('uploads/deal_attachments/' . $file['file_name']);
                                                            ?>

                                                            <?php if (file_exists($filePath)) : ?>
                                                                <a href="<?= $fileUrl ?>" class="link-secondary" download>
                                                                  <i class="ph ph-cloud-arrow-down f-26"></i>
                                                                </a>
                                                              <?php else : ?>
                                                                <a href="javascript:void(0)" 
                                                                  class="link-secondary"
                                                                  data-bs-toggle="modal" 
                                                                  data-bs-target="#fileNotFoundModal">
                                                                  <i class="ph ph-cloud-arrow-down f-26 text-muted"></i>
                                                                </a>
                                                              <?php endif; ?>

                                              </li>
                                              <?php } ?>
                                        
                                                          <div class="modal fade" id="fileNotFoundModal" tabindex="-1">
                                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                                              <div class="modal-content">
                                                                <div class="modal-header bg-dangers">
                                                                  <h6 class="modal-title text-white">
                                                                    <i class="fas fa-exclamation-triangle me-1"></i> File Not Found
                                                                  </h6>
                                                                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                  <p class="mb-0">
                                                                    This file is no longer available on the server or might deleted.
                                                                  </p>
                                                                </div>
                                                                <div class="modal-footer justify-content-center">
                                                                  <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">OK</button>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>

                                  
                                              <?php if ($file['file_type'] == 'application/pdf'){ ?>
                                              <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                              <div class="row align-items-center">
                                                                <div class="col-auto pe-0">
                                                                  <i class="ti ti-file-type-pdf f-28 text-warning"></i>
                                                                </div>
                                                                <div class="col">
                                                                  <a href="#!"><span class="h6"><?php echo $file['file_name']; ?></span></a>
                                                                  <small class="text-muted d-block">Size: <?php echo formatFileSize($file['file_size']); ?>| Created At:<?php  echo $file['created_at']; ?></small>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <?php
                                                              $filePath = FCPATH . 'uploads/deal_attachments/' . $file['file_name'];
                                                              $fileUrl  = base_url('uploads/deal_attachments/' . $file['file_name']);
                                                            ?>

                                                            <?php if (file_exists($filePath)) : ?>
                                                                <a href="<?= $fileUrl ?>" class="link-secondary" download>
                                                                  <i class="ph ph-cloud-arrow-down f-26"></i>
                                                                </a>
                                                              <?php else : ?>
                                                                <a href="javascript:void(0)" 
                                                                  class="link-secondary"
                                                                  data-bs-toggle="modal" 
                                                                  data-bs-target="#fileNotFoundModal">
                                                                  <i class="ph ph-cloud-arrow-down f-26 text-muted"></i>
                                                                </a>
                                                              <?php endif; ?>
                                              </li>
                                              <?php } ?>
                                  
                                              <?php if ($file['file_type'] == 'text/html'){ ?>
                                              <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                              <div class="row align-items-center">
                                                                <div class="col-auto pe-0">
                                                                  <i class="ph ph-file-html f-28 text-danger"></i>
                                                                </div>
                                                                <div class="col">
                                                                  <a href="#!"><span class="h6"><?php echo $file['file_name']; ?></span></a>
                                                                  <small class="text-muted d-block">Size: <?php echo formatFileSize($file['file_size']); ?>| Created At:<?php  echo $file['created_at']; ?></small>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <?php
                                                              $filePath = FCPATH . 'uploads/deal_attachments/' . $file['file_name'];
                                                              $fileUrl  = base_url('uploads/deal_attachments/' . $file['file_name']);
                                                            ?>

                                                            <?php if (file_exists($filePath)) : ?>
                                                                <a href="<?= $fileUrl ?>" class="link-secondary" download>
                                                                  <i class="ph ph-cloud-arrow-down f-26"></i>
                                                                </a>
                                                              <?php else : ?>
                                                                <a href="javascript:void(0)" 
                                                                  class="link-secondary"
                                                                  data-bs-toggle="modal" 
                                                                  data-bs-target="#fileNotFoundModal">
                                                                  <i class="ph ph-cloud-arrow-down f-26 text-muted"></i>
                                                                </a>
                                                              <?php endif; ?>
                                              </li>
                                              <?php } ?>
                                  
                                              <?php if ($file['file_type'] == 'application/zip' || $file['file_type'] == 'text/rtf' || $file['file_type'] == 'text/rtf' || $file['file_type'] == 'application/x-rar'){ ?>
                                              <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                              <div class="row align-items-center">
                                                                <div class="col-auto pe-0">
                                                                  <i class="ti ti-file-excel f-28 text-success"></i>
                                                                </div>
                                                                <div class="col">
                                                                  <a href="#!"><span class="h6"><?php echo $file['file_name']; ?></span></a>
                                                                  <small class="text-muted d-block">Size: <?php echo formatFileSize($file['file_size']); ?>| Created At:<?php  echo $file['created_at']; ?></small>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <?php
                                                              $filePath = FCPATH . 'uploads/deal_attachments/' . $file['file_name'];
                                                              $fileUrl  = base_url('uploads/deal_attachments/' . $file['file_name']);
                                                            ?>

                                                            <?php if (file_exists($filePath)) : ?>
                                                                <a href="<?= $fileUrl ?>" class="link-secondary" download>
                                                                  <i class="ph ph-cloud-arrow-down f-26"></i>
                                                                </a>
                                                              <?php else : ?>
                                                                <a href="javascript:void(0)" 
                                                                  class="link-secondary"
                                                                  data-bs-toggle="modal" 
                                                                  data-bs-target="#fileNotFoundModal">
                                                                  <i class="ph ph-cloud-arrow-down f-26 text-muted"></i>
                                                                </a>
                                                              <?php endif; ?>
                                              </li>
                                              <?php } ?>
                                  
                                              <?php if ($file['file_type'] == 'application/vnd.ms-excel' || $file['file_type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){ ?>
                                              <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                              <div class="row align-items-center">
                                                                <div class="col-auto pe-0">
                                                                  <i class="ti ti-file-excel f-28 text-success"></i>
                                                                </div>
                                                                <div class="col">
                                                                  <a href="#!"><span class="h6"><?php echo $file['file_name']; ?></span></a>
                                                                  <small class="text-muted d-block">Size: <?php echo formatFileSize($file['file_size']); ?>| Created At:<?php  echo $file['created_at']; ?></small>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <?php
                                                              $filePath = FCPATH . 'uploads/deal_attachments/' . $file['file_name'];
                                                              $fileUrl  = base_url('uploads/deal_attachments/' . $file['file_name']);
                                                            ?>

                                                            <?php if (file_exists($filePath)) : ?>
                                                                <a href="<?= $fileUrl ?>" class="link-secondary" download>
                                                                  <i class="ph ph-cloud-arrow-down f-26"></i>
                                                                </a>
                                                              <?php else : ?>
                                                                <a href="javascript:void(0)" 
                                                                  class="link-secondary"
                                                                  data-bs-toggle="modal" 
                                                                  data-bs-target="#fileNotFoundModal">
                                                                  <i class="ph ph-cloud-arrow-down f-26 text-muted"></i>
                                                                </a>
                                                              <?php endif; ?>
                                              </li>
                                              <?php } ?>

                                          <?php endforeach; ?>
                                          <?php else: ?>
                                          <div class="card-body">
                                            <p class="text-secondary">No attachments found.</p>
                                          </div>
                                          <?php endif; ?>   

                                        </ul>
                                  
                              
                              </div>
                            </div>
                            <div class="col-xxl-9 col-xl-8 col-lg-12">
                              <div class="card">
                                  <div class="card-header d-flex align-items-center justify-content-between">
                                      <h5 class="mb-0">Deal Name: <?php echo $data['deal_name']; ?></h5>
                                      <div class="d-flex gap-2 ms-auto">
                                          
                                          
                                      </div>
                                  </div>

                                  <div class="card-body border-bottom">
                                  <b class="text-dangers">Description:</b><p><?php echo $data['complaint_info']; ?></p>
                                  <b class="text-dangers">Account Name:</b><p><?php echo $data['account_name']; ?></p>
                                  </div>
                                  <div class="card-body py-3 border-bottom">
                                  <div class="row">
                                    <div class="col-sm-6 my-1">
                                      <div class="h6 d-inline-block"><i class="ph ph-calendar-blank align-middle f-18 text-dangers"></i> Inquiry Date: </div>
                                      <?php echo $data['enq_deal_date']; ?>
                                    </div>
                                    <div class="col-sm-6 my-1">
                                      <div class="h6 d-inline-block"><i class="ph ph-calendar-blank align-middle f-18 text-dangers"></i> Quotation Date: </div>
                                      <?php echo $data['quote_deal_date']; ?>
                                    </div>
                                    <div class="col-sm-6 my-1">
                                      <div class="h6 d-inline-block"><i class="ti ti-mail-filled align-middle f-18 text-dangers"></i> Customer Email: </div>
                                      <?php echo $data['customer_email']; ?>
                                    </div>
                                    <div class="col-sm-6 my-1">
                                      <div class="h6 d-inline-block"><i class="ti ti-phone-call align-middle f-18 text-dangers"></i> Contact Number: </div>
                                      <?php echo $data['customer_contact']; ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                                
                              <div class="col-sm-12">
              <div class="card">

                  <div class="card-header">
                      <h5>File Upload</h5>
                  </div>

                  <div class="card-body">

                      <!-- Upload Form -->
                      <form action="<?php echo base_url('Admincrm/update_attachments_files'); ?>"
                            method="post"
                            enctype="multipart/form-data"
                            class="dropzone">

                          <div class="fallback">

                              <input type="hidden"
                                    name="id"
                                    value="<?php echo $data['id']; ?>">

                              <input name="image"
                                    type="file"
                                    multiple required>

                          </div>

                          <div class="text-center m-t-20">
                              <button type="submit"
                                      class="btn btn-primary btn-sm">
                                  Upload Now
                              </button>
                          </div>

                      </form>


                      <!-- Uploaded Attachments -->
                      <hr class="mt-4 mb-4">

                      <div class="d-flex justify-content-between align-items-center mb-3">
                          <h5 class="mb-0">Uploaded Attachments</h5>

                          <span class="badge badge-primary">
                              <?php echo !empty($task_attachments) ? count($task_attachments) : 0; ?> Files
                          </span>
                      </div>


                      <div class="row">

                          <?php if (!empty($task_attachments)) { ?>

                              <?php foreach ($task_attachments as $file) { ?>

                                  <?php
                                      $extension = strtolower(
                                          pathinfo($file['file_name'], PATHINFO_EXTENSION)
                                      );

                                      $image_extensions = [
                                          'jpg',
                                          'jpeg',
                                          'png',
                                          'gif',
                                          'webp'
                                      ];

                                      $is_image = in_array(
                                          $extension,
                                          $image_extensions
                                      );
                                  ?>

                                  <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3">

                                      <div class="attachment-card">

                                          <div class="attachment-preview">

                                              <?php if ($is_image) { ?>

                                                  <a href="<?php echo base_url(
                                                      'uploads/task_attachments/' .
                                                      $file['file_name']
                                                  ); ?>"
                                                    target="_blank"
                                                    style="width:100%;">

                                                      <img
                                                          src="<?php echo base_url(
                                                              'uploads/task_attachments/' .
                                                              $file['file_name']
                                                          ); ?>"
                                                          class="attachment-image"
                                                          alt="Attachment"
                                                      >

                                                  </a>

                                              <?php } else { ?>

                                                  <div class="file-icon-wrapper">

                                                      <?php if ($extension == 'pdf') { ?>

                                                          <i class="feather icon-file-text file-icon"></i>

                                                      <?php } elseif (
                                                          $extension == 'xls' ||
                                                          $extension == 'xlsx' ||
                                                          $extension == 'csv'
                                                      ) { ?>

                                                          <i class="feather icon-grid file-icon"></i>

                                                      <?php } elseif (
                                                          $extension == 'doc' ||
                                                          $extension == 'docx'
                                                      ) { ?>

                                                          <i class="feather icon-file file-icon"></i>

                                                      <?php } elseif (
                                                          $extension == 'zip' ||
                                                          $extension == 'rar' ||
                                                          $extension == '7z'
                                                      ) { ?>

                                                          <i class="feather icon-archive file-icon"></i>

                                                      <?php } else { ?>

                                                          <i class="feather icon-paperclip file-icon"></i>

                                                      <?php } ?>

                                                      <small class="text-uppercase text-muted">
                                                          <?php echo $extension; ?>
                                                      </small>

                                                  </div>

                                              <?php } ?>

                                          </div>


                                          <div class="attachment-info">

                                              <div
                                                  class="attachment-name"
                                                  title="<?php echo htmlspecialchars(
                                                      $file['file_name']
                                                  ); ?>"
                                              >
                                                  <?php echo htmlspecialchars(
                                                      $file['file_name']
                                                  ); ?>
                                              </div>


                                              <?php if (!empty($file['created_at'])) { ?>

                                                  <small class="text-muted">
                                                      <i class="feather icon-clock"></i>

                                                      <?php
                                                          echo date(
                                                              'd M Y, h:i A',
                                                              strtotime($file['created_at'])
                                                          );
                                                      ?>
                                                  </small>

                                              <?php } ?>


                                              <div class="attachment-actions">

                                                  <a
                                                      href="<?php echo base_url(
                                                          'uploads/task_attachments/' .
                                                          $file['file_name']
                                                      ); ?>"
                                                      target="_blank"
                                                      class="btn btn-outline-primary btn-sm"
                                                  >
                                                      <i class="feather icon-eye"></i>
                                                      View
                                                  </a>

                                                  <a
                                                      href="<?php echo base_url(
                                                          'uploads/task_attachments/' .
                                                          $file['file_name']
                                                      ); ?>"
                                                      download
                                                      class="btn btn-success btn-sm"
                                                  >
                                                      <i class="ph ph-download"></i>
                                                  </a>

                                              </div>

                                          </div>

                                      </div>

                                  </div>

                              <?php } ?>

                          <?php } ?>

                      </div>

                  </div>

              </div>
            </div >

                             <div class="card">
                                            <div class="card-header">
                                              <h5><i class="ph ph-pencil-ruler align-middle f-20 text-dangers"></i> Notes</h5>
                                            </div>
                                            <div class="card-body">
                                              <div class="row">
                                                <div class="col-md-6 d-flex flex-column my-1">
                                                      <div class="mt-2">

                                                          <div class="mb-1">
                                                              <i class="ph ph-note-pencil text-primary me-1"></i>
                                                              <span class="fw-semibold text-dark">Notes:</span>
                                                              <span class="text-muted"><?= $data['notes'] ?? '—'; ?></span>
                                                          </div>

                                                          <div class="mb-1">
                                                              <i class="ph ph-user-check text-success me-1"></i>
                                                              <span class="fw-semibold text-dark">Assign Notes:</span>
                                                              <span class="text-muted"><?= $data['assign_notes'] ?? '—'; ?></span>
                                                          </div>
                                                          
                                                      <div>
                                                          </div>
                                                    </div>
                                                  </div>
                                                <div class="col-md-6 d-flex flex-column my-1">

                                                          <div class="mt-2">

                                                              <div class="d-flex align-items-center justify-content-between">
                                                                  <div>
                                                                      <i class="ph ph-chat-text text-warning me-1"></i>
                                                                      <span class="fw-semibold text-dark">Your Notes</span>
                                                                  </div>

                                                                  <?php if (!empty($notes_details['note_content'])): ?>
                                                                      <a href="<?= base_url('leads/edit-note/' . $notes_details['id']); ?>"
                                                                        class="btn btn-outline-warning btn-sm py-0 px-2"
                                                                        title="Edit Note" data-bs-toggle="modal" data-bs-target="#notesedit">
                                                                          <i class="ph ph-pencil-simple"></i>
                                                                      </a>
                                                                  <?php endif; ?>
                                                              </div>

                                                              <?php if (!empty($notes_details['note_content'])): ?>
                                                                  <div class="alert alert-light border mt-1 py-2 px-3">
                                                                      <?= $notes_details['note_content']; ?>
                                                                  </div>

                                                                  <small class="text-muted">
                                                                      <i class="ph ph-clock me-1"></i>
                                                                      <?= date('d M Y, h:i A', strtotime($notes_details['created_at'])); ?>
                                                                  </small>
                                                              <?php else: ?>
                                                                  <span class="badge bg-secondary mt-1">No notes available</span>
                                                              <?php endif; ?>

                                                          </div>


                                                      </div>
                                              </div>
                                            </div>
                          </div>
                                                        

                                                      </div>
                                                  </div>
                                </div>


                      <!-- Details Content End -->

                      </div>
                      <!-- end lead detail tab pane -->
                       <!-- Electric Pane -->
                       <?php if($data['department'] == "Electrical"){ ?>
                        <div class="tab-pane" id="ElectricalDetail">
                          <div class="col-12">
                            <div class="card">
                                <?php $electric_recent_data['electric_status'] = $electric_recent_data['electric_status'] ?? ''; ?>
                                        <div class="ribbon-wrapper ribbon-xl">
                                            <?php if($electric_recent_data['electric_status'] == 'Completed') { ?>
                                                <div class="ribbon bg-warning text-lg">
                                                    <?= $electric_recent_data['electric_status'] ?>
                                                </div>
                                            <?php } elseif ($electric_recent_data['electric_status'] == 'Process') { ?>
                                                <div class="ribbon bg-purple text-lg">
                                                    <?= $electric_recent_data['electric_status'] ?>
                                                </div>
                                            <?php } elseif ($electric_recent_data['electric_status'] == 'Assigned') { ?>
                                                <div class="ribbon bg-danger text-lg">
                                                    <?= $electric_recent_data['electric_status'] ?>
                                                </div>
                                            <?php } elseif ($electric_recent_data['electric_status'] == 'Hold') { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?= $electric_recent_data['electric_status'] ?>
                                                </div>
                                            <?php } elseif (empty($electric_recent_data['electric_status'])) { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?php echo "No Update"; ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                   <?php echo $data['Job_Status']; ?>
                                <div class="card-body">
                                    

                                    <div class="tab-content">
                                        <div class="card">
                                          <div class="row">
                                              <div class="col-8">
                                                <?php
                                                    $isElectricCompleted = (isset($electric_recent_data['electric_status']) && $electric_recent_data['electric_status'] === 'Completed');
                                                    $isHold = (isset($data['Job_Status']) && $data['Job_Status'] === 'Hold' || $data['Job_Status'] == 'Closed');
                                                ?>
                                                <form action= "<?php echo base_url('index.php/Electrical/update_electric_job'); ?>" method="post" enctype="multipart/form-data">
                                                  <input type="hidden" name="task_id" value="<?php echo $data['id']; ?>">
                                                  <input type="hidden" name="User_ID" value="<?php echo $this->session->userdata('id'); ?>">
                                                  <input type="hidden" name="departments_assign_id" value="<?php echo $data['department_assign_id']; ?>">
                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">DEWA Authority</label>
                                                                  <div class="col-lg-6">
                                                                      <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                                        <select class="form-select" id="inputGroupSelect01" name="DEWA_Authority">
                                                                          <option value="-">Choose...</option>
                                                                          <option value="DESIGN">DESIGN</option>
                                                                          <option value="FITOUT">FITOUT</option>
                                                                          <option value="GE">GE</option>
                                                                          <option value="GW">GW</option>
                                                                          <option value="INFRA">INFRA</option>
                                                                          <option value="NETWORK MODIFICATION">NETWORK MODIFICATION</option>
                                                                          <option value="POWER NOC">POWER NOC</option>
                                                                          <option value="POWER UPGRADATION">POWER UPGRADATION</option>
                                                                          <option value="TEMP POWER">TEMP POWER</option>
                                                                          <option value="WATER METER">WATER METER</option>
                                                                          <option value="WATER NOC">WATER NOC</option>
                                                                          <option value="ZERO KW">ZERO KW</option>
                                                                        </select>
                                                                      </div>
                                                                    
                                                                </div>
                                                              </div>
                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Status</label>
                                                                  <div class="col-lg-6">
                                                                  <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                                        <select class="form-select" id="inputGroupSelect01" name="Electric_Status">
                                                                          <option value="-">Choose...</option>
                                                                          <option value="DOCUMENTS PENDING">DOCUMENTS PENDING</option>
                                                                          <option value="POWER NOC SUBMITTED">POWER NOC SUBMITTED</option>
                                                                          <option value="POWER NOC APPROVED">POWER NOC APPROVED</option>
                                                                          <option value="GW">GW</option>
                                                                          <option value="COMMENT">COMMENT</option>
                                                                          <option value="DRAWING PREPARATION">DRAWING PREPARATION</option>
                                                                          <option value="DESIGN SUBMITTED">DESIGN SUBMITTED</option>
                                                                          <option value="DESIGN APPROVED">DESIGN APPROVED</option>
                                                                          <option value="INSPECTION">INSPECTION</option>
                                                                          <option value="Complete">COMPLETE</option>
                                                                          <option value="Hold">ON HOLD</option>
                                                                          <option value="SITE WORKS">SITE WORKS</option>
                                                                          <option value="W NOC APPROVED">W NOC APPROVED</option>
                                                                          <option value="PAYMENT PENDING">PAYMENT PENDING</option>
                                                                          <option value="SITE WORKS">SITE WORKS</option>
                                                                          <option value="INSPECTION APPROVED">INSPECTION APPROVED</option>
                                                                        </select>
                                                                      </div>
                                                                  </div>
                                                              </div>

                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Authority Comments</label>
                                                                  <div class="col-lg-6 form-floating">
                                                                  <textarea class="form-control" id="floatingTextarea" name="Authority_Comments" style="height: 120px"></textarea>
                                                                  <label for="floatingTextarea">Comments</label>
                                                                  </div>
                                                              </div>

                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Electrician Notes</label>
                                                                  <div class="col-lg-6 form-floating">
                                                                  <textarea class="form-control" id="floatingTextarea" name="Electrician_Notes" style="height: 120px"></textarea>
                                                                  <label for="floatingTextarea">Electrician Notes</label>
                                                                  </div>
                                                              </div>

                                                              <div class="row mb-3">
                                                                <label class="col-lg-4 col-form-label">Upload Document</label>
                                                                <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="file" class="form-control" id="inputGroupFile02" name="image" />
                                                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                                </div>
                                                                </div>


                                                                </div>
                                                
                                                        <div class="card-footer border-0">
                                                              <div class="row">
                                                                <label class="col-lg-4"></label>
                                                                <div class="col-lg-8">
                                                                    <button class="btn btn-primary me-2"
                                                                        <?= ($isElectricCompleted || $isHold) ? 'disabled' : '' ?>>
                                                                        Submit
                                                                    </button>
                                                                    <button class="btn btn-secondary">Clear</button>
                                                                </div>
                                                              </div>
                                                               <?php if($isElectricCompleted): ?>
                                                                <div class="alert alert-danger mt-2">
                                                                    This job is completed and cannot be edited.
                                                                </div>
                                                               <?php endif; ?>
                                                               <?php if($isHold): ?>
                                                                <div class="alert alert-dangers mt-2">
                                                                    This job is on Hold or Completed and cannot be edited.
                                                                </div>
                                                               <?php endif; ?>
                                                        </div>
                                                </form>
                                              </div><!-- Col 8 Closed -->
                                                      
                                              <div class="col-4">
                                            
                                                  <center><img src="<?php echo base_url('include/dist/assets/images/electricgif.gif'); ?>" width="80%" alt="logo" />
                                                  <button 
                                                  class="btn btn-warning btn-sm"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#exampleModalLive">
                                                    <i class="ph ph-pen align-right m-r-5"></i>
                                                    Update Status
                                                  </button></center>

                                                  <!-- Modal Content -->
        

                                              </div><!-- Col 4 Closed -->
                                          </div><!-- Row Closed -->
                                          
                                        </div><!-- Card Closed -->
                                        <!-- Logs Start -->
                              <div class="card shadow-sm border-0 mt-4">
                                  <div class="card-header bg-light">
                                      <h5 class="mb-0">
                                          <i class="ti ti-clipboard-list"></i>
                                          Logs
                                      </h5>
                                  </div>

                                  <div class="card-body p-0">

                                      <?php if (!empty($electric_logs)): ?>
                                          <div class="table-responsive">
                                              <table id="jobsTable" class="table table-hover mb-0 w-100" id="advanced-table">
                                                  <thead class="table-light">
                                                      <tr>
                                                          <th>Date</th>
                                                          <th>Authority</th>
                                                          <th>Status</th>
                                                          <th>Comments</th>
                                                          <th>Notes</th>
                                                          <th>File</th>
                                                          <th>Assigned User</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <?php foreach ($electric_logs as $log): ?>

                                                          <tr>
                                                              <td class="text-nowrap">
                                                                 <?= date('d M Y h:i A', strtotime($log['created_at'])); ?>
                                                              </td>

                                                              <td>
                                                                  <?= !empty($log['DEWA_Authority'])
                                                                      ? '<span class="badge bg-info">'.htmlspecialchars($log['DEWA_Authority']).'</span>'
                                                                      : '—'; ?>
                                                              </td>

                                                              <td>
                                                                  <?php
                                                                  $status = $log['Electric_Status'] ?? '';
                                                                  $badge  = 'bg-secondary';

                                                                  if (stripos($status, 'APPROVED') !== false) $badge = 'bg-success';
                                                                  elseif (stripos($status, 'PENDING') !== false) $badge = 'bg-warning';
                                                                  elseif (stripos($status, 'REJECT') !== false) $badge = 'bg-danger';
                                                                  ?>

                                                                  <span class="badge <?= $badge; ?>">
                                                                      <?= htmlspecialchars($status ?: '—'); ?>
                                                                  </span>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['Authority_Comments'])
                                                                      ? nl2br(htmlspecialchars($log['Authority_Comments']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['Electrician_Notes'])
                                                                      ? nl2br(htmlspecialchars($log['Electrician_Notes']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td class="text-nowrap">
                                                                  <?php if (!empty($log['File'])): ?>
                                                                      <a href="<?= base_url('uploads/Electric/'.$log['File']); ?>"
                                                                        target="_blank"
                                                                        class="btn btn-outline-primary btn-sm">
                                                                          <i class="ph ph-file-arrow-down"></i> View
                                                                      </a>
                                                                  <?php else: ?>
                                                                      <span class="text-muted">—</span>
                                                                  <?php endif; ?>
                                                              </td>

                                                              <td>
                                                                  <?php echo $log['electric_user_name']; ?>
                                                              </td>

                                                          </tr>

                                                      <?php endforeach; ?>
                                                  </tbody>
                                              </table>
                                          </div>
                                      <?php else: ?>
                                          <div class="p-4 text-center text-muted">
                                              <i class="ph ph-info"></i><br>
                                              No electrical submissions found for this task.
                                          </div>
                                      <?php endif; ?>

                                  </div>
                              </div>
                              <!-- Logs End -->
                                      </div><!-- Tab Content Closed -->
                                </div><!-- Card Body Closed -->
                            </div><!-- Card Closed -->
                            
                          </div><!-- Col 12 Closed -->
                        </div><!-- Pane Closed -->
                      <?php } ?>
                      <?php if($data['department'] != "Electrical"){ ?>
                        <div class="tab-pane" id="ElectricalDetail">
                        <div class="col-12">
                           <div class="card">
                               <div class="ribbon-wrapper ribbon-xl">
                                <?php $electric_recent_data['electric_status'] = $electric_recent_data['electric_status'] ?? ''; ?>
                                            <?php if($electric_recent_data['electric_status'] == 'Completed') { ?>
                                                <div class="ribbon bg-warning text-lg">
                                                    <?= $electric_recent_data['electric_status'] ?>
                                                </div>
                                            <?php } elseif ($electric_recent_data['electric_status'] == 'Process') { ?>
                                                <div class="ribbon bg-purple text-lg">
                                                    <?= $electric_recent_data['electric_status'] ?>
                                                </div>
                                            <?php } elseif ($electric_recent_data['electric_status'] == 'Assigned') { ?>
                                                <div class="ribbon bg-danger text-lg">
                                                    <?= $electric_recent_data['electric_status'] ?>
                                                </div>
                                            <?php } elseif ($electric_recent_data['electric_status'] == 'Hold') { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?= $electric_recent_data['electric_status'] ?>
                                                </div>
                                            <?php } elseif (empty($electric_recent_data['electric_status'])) { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?php echo "No Update"; ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                               <div class="card-body">
                                   <div class="tab-content">
                                      <div class="card shadow-sm border-0">
                                      <div class="card-header bg-light">
                                          <h5 class="mb-0">
                                              <i class="ph ph-lightning"></i>
                                              Electrical Department Submission
                                          </h5>
                                      </div>

                                      <div class="card-body">

                                          <!-- Authority -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">DEWA Authority</div>
                                              <div class="col-md-8">
                                                  <span class="badge bg-info">
                                                      <?php echo $electric_recent_data['DEWA_Authority'] ?? '—'; ?>

                                                  </span>
                                              </div>
                                          </div>

                                          <!-- Status -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Status</div>
                                              <div class="col-md-8">
                                                  <span class="badge bg-success">
                                                      <?php echo $electric_recent_data['Electric_Status'] ?? '—'; ?>
                                                  </span>
                                              </div>
                                          </div>

                                          <!-- Authority Comments -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Authority Comments</div>
                                              <div class="col-md-8">
                                                  <div class="p-2 border rounded bg-light">
                                                      <?= nl2br($electric_recent_data['Authority_Comments'] ?? 'No comments'); ?>
                                                  </div>
                                              </div>
                                          </div>

                                          <!-- Electrician Notes -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Electrician Notes</div>
                                              <div class="col-md-8">
                                                  <div class="p-2 border rounded bg-light">
                                                      <?= nl2br($electric_recent_data['Electrician_Notes'] ?? '—'); ?>
                                                  </div>
                                              </div>
                                          </div>

                                          <!-- Uploaded File -->
                                          <div class="row mb-2">
                                              <div class="col-md-4 text-muted fw-semibold">Uploaded Document</div>
                                              <div class="col-md-8">

                                                  <?php if (!empty($electric_recent_data['File'])): ?>
                                                      <a href="<?= base_url('uploads/Electric/' . $electric_recent_data['File']); ?>"
                                                        target="_blank"
                                                        class="btn btn-outline-primary btn-sm">
                                                          <i class="ph ph-file-arrow-down"></i>
                                                          View / Download File
                                                      </a>
                                                  <?php else: ?>
                                                      <span class="text-muted">No file uploaded</span>
                                                  <?php endif; ?>

                                              </div>
                                          </div>

                                      </div>
                                      <div class="card-footer text-muted small">
                                          Submitted on -
                                          <?php if (!empty($electric_recent_data) && !empty($electric_recent_data['created_at'])): ?>
                                              <?= date('d M Y, h:i A', strtotime($electric_recent_data['created_at'])); ?>
                                          <?php else: ?>
                                              Not submitted yet
                                          <?php endif; ?>
                                      </div>
                                      
                                  </div>

                                   </div>
                               </div>
                           </div>
                              <!-- Logs Start -->
                              <div class="card shadow-sm border-0 mt-4">
                                  <div class="card-header bg-light">
                                      <h5 class="mb-0">
                                          <i class="ti ti-clipboard-list"></i>
                                          Logs
                                      </h5>
                                  </div>

                                  <div class="card-body p-0">

                                      <?php if (!empty($electric_logs)): ?>
                                          <div class="table-responsive">
                                              <table id="jobsTable" class="table table-hover mb-0 w-100" id="advanced-table">
                                                  <thead class="table-light">
                                                      <tr>
                                                          <th>Date</th>
                                                          <th>Authority</th>
                                                          <th>Status</th>
                                                          <th>Comments</th>
                                                          <th>Notes</th>
                                                          <th>File</th>
                                                          <th>Assigned User</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <?php foreach ($electric_logs as $log): ?>

                                                          <tr>
                                                              <td class="text-nowrap">
                                                                 <?= date('d M Y h:i A', strtotime($log['created_at'])); ?>
                                                              </td>

                                                              <td>
                                                                  <?= !empty($log['DEWA_Authority'])
                                                                      ? '<span class="badge bg-info">'.htmlspecialchars($log['DEWA_Authority']).'</span>'
                                                                      : '—'; ?>
                                                              </td>

                                                              <td>
                                                                  <?php
                                                                  $status = $log['Electric_Status'] ?? '';
                                                                  $badge  = 'bg-secondary';

                                                                  if (stripos($status, 'APPROVED') !== false) $badge = 'bg-success';
                                                                  elseif (stripos($status, 'PENDING') !== false) $badge = 'bg-warning';
                                                                  elseif (stripos($status, 'REJECT') !== false) $badge = 'bg-danger';
                                                                  ?>

                                                                  <span class="badge <?= $badge; ?>">
                                                                      <?= htmlspecialchars($status ?: '—'); ?>
                                                                  </span>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['Authority_Comments'])
                                                                      ? nl2br(htmlspecialchars($log['Authority_Comments']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['Electrician_Notes'])
                                                                      ? nl2br(htmlspecialchars($log['Electrician_Notes']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td class="text-nowrap">
                                                                  <?php if (!empty($log['File'])): ?>
                                                                      <a href="<?= base_url('uploads/Electric/'.$log['File']); ?>"
                                                                        target="_blank"
                                                                        class="btn btn-outline-primary btn-sm">
                                                                          <i class="ph ph-file-arrow-down"></i> View
                                                                      </a>
                                                                  <?php else: ?>
                                                                      <span class="text-muted">—</span>
                                                                  <?php endif; ?>
                                                              </td>

                                                              <td>
                                                                  <?php echo $log['electric_user_name']; ?>
                                                              </td>


                                                          </tr>

                                                      <?php endforeach; ?>
                                                  </tbody>
                                              </table>
                                          </div>
                                      <?php else: ?>
                                          <div class="p-4 text-center text-muted">
                                              <i class="ph ph-info"></i><br>
                                              No electrical submissions found for this task.
                                          </div>
                                      <?php endif; ?>

                                  </div>
                              </div>
                              <!-- Logs End -->


                         </div>
                      </div>
                      <?php } ?>
                      <!-- end electrical detail tab pane -->
                      <!-- Civil Pane -->
                      <?php if($data['department'] == "Civil"){ ?>
                        <div class="tab-pane" id="CivilDetail">
                          <div class="col-12">
                            <div class="card">
                                <div class="ribbon-wrapper ribbon-xl">
                                    <?php $civil_recent_data['civil_status'] = $civil_recent_data['civil_status'] ?? ''; ?>
                                            <?php if($civil_recent_data['civil_status'] == 'Completed') { ?>
                                                <div class="ribbon bg-warning text-lg">
                                                    <?= $civil_recent_data['civil_status'] ?>
                                                </div>
                                            <?php } elseif ($civil_recent_data['civil_status'] == 'Process') { ?>
                                                <div class="ribbon bg-purple text-lg">
                                                    <?= $civil_recent_data['civil_status'] ?>
                                                </div>
                                            <?php } elseif ($civil_recent_data['civil_status'] == 'Assigned') { ?>
                                                <div class="ribbon bg-danger text-lg">
                                                    <?= $civil_recent_data['civil_status'] ?>
                                                </div>
                                            <?php } elseif ($civil_recent_data['civil_status'] == 'Hold') { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?= $civil_recent_data['civil_status'] ?>
                                                </div>
                                            <?php } elseif (empty($civil_recent_data['civil_status'])) { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?php echo "No Update"; ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="card">
                                          <div class="row">
                                              <div class="col-8">
                                                <?php
                                                    $isCivilCompleted = (isset($civil_recent_data['civil_status']) && $civil_recent_data['civil_status'] === 'Completed');
                                                    $isHold = (isset($data['Job_Status']) && $data['Job_Status'] === 'Hold' || $data['Job_Status'] == 'Closed');
                                                ?>
                                                <form action= "<?php echo base_url('index.php/Civil/update_civil_job'); ?>" method="post" enctype="multipart/form-data">
                                                  <input type="hidden" name="task_id" value="<?php echo $data['id']; ?>">
                                                  <input type="hidden" name="User_ID" value="<?php echo $this->session->userdata('id'); ?>">
                                                  <input type="hidden" name="departments_assign_id" value="<?php echo $data['department_assign_id']; ?>">
                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Civil Authority</label>
                                                                  <div class="col-lg-6">
                                                                      <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                                        <select class="form-select" id="inputGroupSelect01" name="Civil_Authority">
                                                                          <option value="-">Choose...</option>
                                                                          <option value="TRAKHEES">TRAKHEES</option>
                                                                          <option value="DCD">DCD</option>
                                                                          <option value="DM">DM</option>
                                                                          <option value="DDA">DDA</option>
                                                                          <option value="DM HSE">DM HSE</option>
                                                                          <option value="RTA">RTA</option>
                                                                          <option value="JAFZA">JAFZA</option>
                                                                          <option value="DM PLANNING">DM PLANNING</option>
                                                                          <option value="CONCORDIA">CONCORDIA</option>
                                                                          <option value="BM">BM</option>
                                                                          <option value="DEWA">DEWA</option>
                                                                          <option value="NAKHEEL">NAKHEEL</option>
                                                                          <option value="DSO">DSO</option>
                                                                          <option value="DESIGN">DESIGN</option>
                                                                        </select>
                                                                      </div>
                                                                    
                                                                </div>
                                                              </div>
                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Status</label>
                                                                  <div class="col-lg-6">
                                                                  <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                                        <select class="form-select" id="inputGroupSelect01" name="Civil_Status">
                                                                          <option value="-">Choose...</option>
                                                                          <option value="DOCUMENTS PENDING">DOCUMENTS PENDING</option>
                                                                          <option value="POWER NOC SUBMITTED">POWER NOC SUBMITTED</option>
                                                                          <option value="POWER NOC APPROVED">POWER NOC APPROVED</option>
                                                                          <option value="GW">GW</option>
                                                                          <option value="COMMENT">COMMENT</option>
                                                                          <option value="DRAWING PREPARATION">DRAWING PREPARATION</option>
                                                                          <option value="DESIGN SUBMITTED">DESIGN SUBMITTED</option>
                                                                          <option value="DESIGN APPROVED">DESIGN APPROVED</option>
                                                                          <option value="INSPECTION">INSPECTION</option>
                                                                          <option value="Completed">COMPLETED</option>
                                                                          <option value="Hold">ON HOLD</option>
                                                                          <option value="SITE WORKS">SITE WORKS</option>
                                                                          <option value="W NOC APPROVED">W NOC APPROVED</option>
                                                                          <option value="PAYMENT PENDING">PAYMENT PENDING</option>
                                                                          <option value="SITE WORKS">SITE WORKS</option>
                                                                          <option value="INSPECTION APPROVED">INSPECTION APPROVED</option>
                                                                        </select>
                                                                      </div>
                                                                  </div>
                                                              </div>

                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Authority Comments</label>
                                                                  <div class="col-lg-6 form-floating">
                                                                  <textarea class="form-control" id="floatingTextarea" name="Civil_Authority_Comments" style="height: 120px"></textarea>
                                                                  <label for="floatingTextarea">Comments</label>
                                                                  </div>
                                                              </div>

                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Civil Notes</label>
                                                                  <div class="col-lg-6 form-floating">
                                                                  <textarea class="form-control" id="floatingTextarea" name="Civil_Notes" style="height: 120px"></textarea>
                                                                  <label for="floatingTextarea">Civil Notes</label>
                                                                  </div>
                                                              </div>

                                                              <div class="row mb-3">
                                                                <label class="col-lg-4 col-form-label">Upload Document</label>
                                                                <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="file" class="form-control" id="inputGroupFile02" name="image" />
                                                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                                </div>
                                                                </div>


                                                                </div>
                                                
                                                        <div class="card-footer border-0">
                                                              <div class="row">
                                                                <label class="col-lg-4"></label>
                                                                <div class="col-lg-8">
                                                                    <button class="btn btn-primary me-2" <?= ($isCivilCompleted || $isHold) ? 'disabled' : '' ?>>Submit</button>
                                                                    <button class="btn btn-secondary">Clear</button>
                                                                </div>
                                                              </div>
                                                              <?php if($isCivilCompleted): ?>
                                                                <div class="alert alert-danger mt-2">
                                                                    This job is completed and cannot be edited.
                                                                </div>
                                                               <?php endif; ?>
                                                               <?php if($isHold): ?>
                                                                <div class="alert alert-dangers mt-2">
                                                                    This job is on Hold or Completed and cannot be edited.
                                                                </div>
                                                               <?php endif; ?>
                                                        </div>
                                                </form>
                                              </div><!-- Col 8 Closed -->
                                                      
                                              <div class="col-4">
                                            
                                                  <center><img src="<?php echo base_url('include/dist/assets/images/civilgif.gif'); ?>" width="100%" alt="logo" />
                                                  <button 
                                                  class="btn btn-warning btn-sm"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#civilstatusupdate">
                                                    <i class="ph ph-pen align-right m-r-5"></i>
                                                    Update Status
                                                  </button></center>

                                           
     

                                              </div><!-- Col 4 Closed -->
                                          </div><!-- Row Closed -->
                                        </div><!-- Card Closed -->
                                      </div><!-- Tab Content Closed -->
                                </div><!-- Card Body Closed -->
                            </div><!-- Card Closed -->
                            <!-- Logs Start -->
                              <div class="card shadow-sm border-0 mt-4">
                                  <div class="card-header bg-light">
                                      <h5 class="mb-0">
                                          <i class="ti ti-clipboard-list"></i>
                                          Logs
                                      </h5>
                                  </div>

                                  <div class="card-body p-0">

                                      <?php if (!empty($civil_logs)): ?>
                                          <div class="table-responsive">
                                              <table id="jobsTable" class="table table-hover mb-0 w-100" id="advanced-table">
                                                  <thead class="table-light">
                                                      <tr>
                                                          <th>Date</th>
                                                          <th>Authority</th>
                                                          <th>Status</th>
                                                          <th>Comments</th>
                                                          <th>Notes</th>
                                                          <th>File</th>
                                                          <th>Assigned User</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <?php foreach ($civil_logs as $log): ?>

                                                          <tr>
                                                              <td class="text-nowrap">
                                                                 <?= date('d M Y h:i A', strtotime($log['Civil_Created_At'])); ?>
                                                              </td>

                                                              <td>
                                                                  <?= !empty($log['Civil_Authority'])
                                                                      ? '<span class="badge bg-info">'.htmlspecialchars($log['Civil_Authority']).'</span>'
                                                                      : '—'; ?>
                                                              </td>

                                                              <td>
                                                                  <?php
                                                                  $status = $log['Civil_Status'] ?? '';
                                                                  $badge  = 'bg-secondary';

                                                                  if (stripos($status, 'APPROVED') !== false) $badge = 'bg-success';
                                                                  elseif (stripos($status, 'PENDING') !== false) $badge = 'bg-warning';
                                                                  elseif (stripos($status, 'REJECT') !== false) $badge = 'bg-danger';
                                                                  ?>

                                                                  <span class="badge <?= $badge; ?>">
                                                                      <?= htmlspecialchars($status ?: '—'); ?>
                                                                  </span>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['Civil_Authority_Comments'])
                                                                      ? nl2br(htmlspecialchars($log['Civil_Authority_Comments']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['Civil_Notes'])
                                                                      ? nl2br(htmlspecialchars($log['Civil_Notes']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td class="text-nowrap">
                                                                  <?php if (!empty($log['Civil_File'])): ?>
                                                                      <a href="<?= base_url('uploads/Civil/'.$log['Civil_File']); ?>"
                                                                        target="_blank"
                                                                        class="btn btn-outline-primary btn-sm">
                                                                          <i class="ph ph-file-arrow-down"></i> View
                                                                      </a>
                                                                  <?php else: ?>
                                                                      <span class="text-muted">—</span>
                                                                  <?php endif; ?>
                                                              </td>

                                                              <td>
                                                                  <?php echo $log['civil_user_name']; ?>
                                                              </td>



                                                          </tr>

                                                      <?php endforeach; ?>
                                                  </tbody>
                                              </table>
                                          </div>
                                      <?php else: ?>
                                          <div class="p-4 text-center text-muted">
                                              <i class="ph ph-info"></i><br>
                                              No civil submissions found for this task.
                                          </div>
                                      <?php endif; ?>

                                  </div>
                              </div>
                              <!-- Logs End -->
                          </div><!-- Col 12 Closed -->
                        </div><!-- Pane Closed -->
                      <?php } ?>
                      <?php if($data['department'] != "Civil"){ ?>
                        <div class="tab-pane" id="CivilDetail">
                         <div class="col-12">
                           <div class="card">
                            <div class="ribbon-wrapper ribbon-xl">
                                <?php $civil_recent_data['civil_status'] = $civil_recent_data['civil_status'] ?? ''; ?>
                                            <?php if($civil_recent_data['civil_status'] == 'Completed') { ?>
                                                <div class="ribbon bg-warning text-lg">
                                                    <?= $civil_recent_data['civil_status'] ?>
                                                </div>
                                            <?php } elseif ($civil_recent_data['civil_status'] == 'Process') { ?>
                                                <div class="ribbon bg-purple text-lg">
                                                    <?= $civil_recent_data['civil_status'] ?>
                                                </div>
                                            <?php } elseif ($civil_recent_data['civil_status'] == 'Assigned') { ?>
                                                <div class="ribbon bg-danger text-lg">
                                                    <?= $civil_recent_data['civil_status'] ?>
                                                </div>
                                            <?php } elseif ($civil_recent_data['civil_status'] == 'Hold') { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?= $civil_recent_data['civil_status'] ?>
                                                </div>
                                            <?php } elseif (empty($civil_recent_data['civil_status'])) { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?php echo "No Update"; ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                               <div class="card-body">
                                   <div class="tab-content">
                                      <div class="card shadow-sm border-0">
                                      <div class="card-header bg-light">
                                          <h5 class="mb-0">
                                              <i class="ph ph-lightning"></i>
                                              Civil Department Submission
                                          </h5>
                                      </div>

                                      <div class="card-body">

                                          <!-- Authority -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Civil Authority</div>
                                              <div class="col-md-8">
                                                  <span class="badge bg-info">
                                                      <?php echo $civil_recent_data['Civil_Authority'] ?? '—'; ?>

                                                  </span>
                                              </div>
                                          </div>

                                          <!-- Status -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Status</div>
                                              <div class="col-md-8">
                                                  <span class="badge bg-success">
                                                      <?php echo $civil_recent_data['Civil_Status'] ?? '—'; ?>
                                                  </span>
                                              </div>
                                          </div>

                                          <!-- Authority Comments -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Authority Comments</div>
                                              <div class="col-md-8">
                                                  <div class="p-2 border rounded bg-light">
                                                      <?= nl2br($civil_recent_data['Civil_Authority_Comments'] ?? 'No comments'); ?>
                                                  </div>
                                              </div>
                                          </div>

                                          <!-- Civil Notes -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Civil Notes</div>
                                              <div class="col-md-8">
                                                  <div class="p-2 border rounded bg-light">
                                                      <?= nl2br($civil_recent_data['Civil_Notes'] ?? '—'); ?>
                                                  </div>
                                              </div>
                                          </div>

                                          <!-- Uploaded File -->
                                          <div class="row mb-2">
                                              <div class="col-md-4 text-muted fw-semibold">Uploaded Document</div>
                                              <div class="col-md-8">

                                                  <?php if (!empty($civil_recent_data['Civil_File'])): ?>
                                                      <a href="<?= base_url('uploads/Civil/' . $civil_recent_data['Civil_File']); ?>"
                                                        target="_blank"
                                                        class="btn btn-outline-primary btn-sm">
                                                          <i class="ph ph-file-arrow-down"></i>
                                                          View / Download File
                                                      </a>
                                                  <?php else: ?>
                                                      <span class="text-muted">No file uploaded</span>
                                                  <?php endif; ?>

                                              </div>
                                          </div>

                                      </div>

                                      <div class="card-footer text-muted small">
                                          Submitted on -
                                          <?php if (!empty($civil_recent_data) && !empty($civil_recent_data['Civil_Created_At'])): ?>
                                              <?= date('d M Y, h:i A', strtotime($civil_recent_data['Civil_Created_At'])); ?>
                                          <?php else: ?>
                                              Not submitted yet
                                          <?php endif; ?>
                                      </div>

                                      
                                  </div>

                                   </div>
                               </div>
                           </div>
                              <!-- Logs Start -->
                              <div class="card shadow-sm border-0 mt-4">
                                  <div class="card-header bg-light">
                                      <h5 class="mb-0">
                                          <i class="ti ti-clipboard-list"></i>
                                          Logs
                                      </h5>
                                  </div>

                                  <div class="card-body p-0">

                                      <?php if (!empty($civil_logs)): ?>
                                          <div class="table-responsive">
                                              <table id="jobsTable" class="table table-hover mb-0 w-100" id="advanced-table">
                                                  <thead class="table-light">
                                                      <tr>
                                                          <th>Date</th>
                                                          <th>Authority</th>
                                                          <th>Status</th>
                                                          <th>Comments</th>
                                                          <th>Notes</th>
                                                          <th>File</th>
                                                          <th>Assigned User</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <?php foreach ($civil_logs as $log): ?>

                                                          <tr>
                                                              <td class="text-nowrap">
                                                                 <?= date('d M Y h:i A', strtotime($log['Civil_Created_At'])); ?>
                                                              </td>

                                                              <td>
                                                                  <?= !empty($log['Civil_Authority'])
                                                                      ? '<span class="badge bg-info">'.htmlspecialchars($log['Civil_Authority']).'</span>'
                                                                      : '—'; ?>
                                                              </td>

                                                              <td>
                                                                  <?php
                                                                  $status = $log['Civil_Status'] ?? '';
                                                                  $badge  = 'bg-secondary';

                                                                  if (stripos($status, 'APPROVED') !== false) $badge = 'bg-success';
                                                                  elseif (stripos($status, 'PENDING') !== false) $badge = 'bg-warning';
                                                                  elseif (stripos($status, 'REJECT') !== false) $badge = 'bg-danger';
                                                                  ?>

                                                                  <span class="badge <?= $badge; ?>">
                                                                      <?= htmlspecialchars($status ?: '—'); ?>
                                                                  </span>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['Civil_Authority_Comments'])
                                                                      ? nl2br(htmlspecialchars($log['Civil_Authority_Comments']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['Civil_Notes'])
                                                                      ? nl2br(htmlspecialchars($log['Civil_Notes']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td class="text-nowrap">
                                                                  <?php if (!empty($log['Civil_File'])): ?>
                                                                      <a href="<?= base_url('uploads/Civil/'.$log['Civil_File']); ?>"
                                                                        target="_blank"
                                                                        class="btn btn-outline-primary btn-sm">
                                                                          <i class="ph ph-file-arrow-down"></i> View
                                                                      </a>
                                                                  <?php else: ?>
                                                                      <span class="text-muted">—</span>
                                                                  <?php endif; ?>
                                                              </td>

                                                              <td>
                                                                  <?php echo $log['civil_user_name']; ?>
                                                              </td>



                                                          </tr>

                                                      <?php endforeach; ?>
                                                  </tbody>
                                              </table>
                                          </div>
                                      <?php else: ?>
                                          <div class="p-4 text-center text-muted">
                                              <i class="ph ph-info"></i><br>
                                              No civil submissions found for this task.
                                          </div>
                                      <?php endif; ?>

                                  </div>
                              </div>
                              <!-- Logs End -->


                         </div>
                      </div>
                      <?php } ?>
                      <!-- end civil detail tab pane -->
                      <!-- PM Pane -->
                      <?php if($data['department'] == "PM"){ ?>
                        <div class="tab-pane" id="PMDetail">
                          <div class="col-12">
                            <div class="card">
                                <div class="ribbon-wrapper ribbon-xl">
                                    <?php $pm_recent_data['pm_status'] = $pm_recent_data['pm_status'] ?? ''; ?>
                                            <?php if($pm_recent_data['pm_status'] == 'Completed') { ?>
                                                <div class="ribbon bg-warning text-lg">
                                                    <?= $pm_recent_data['pm_status'] ?>
                                                </div>
                                            <?php } elseif ($pm_recent_data['pm_status'] == 'Process') { ?>
                                                <div class="ribbon bg-purple text-lg">
                                                    <?= $pm_recent_data['pm_status'] ?>
                                                </div>
                                            <?php } elseif ($pm_recent_data['pm_status'] == 'Assigned') { ?>
                                                <div class="ribbon bg-danger text-lg">
                                                    <?= $pm_recent_data['pm_status'] ?>
                                                </div>
                                            <?php } elseif ($pm_recent_data['pm_status'] == 'Hold') { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?= $pm_recent_data['pm_status'] ?>
                                                </div>
                                            <?php } elseif (empty($pm_recent_data['pm_status'])) { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?php echo "No Update"; ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="card">
                                          <div class="row">
                                              <div class="col-8">
                                                <?php
                                                    $isPMCompleted = (isset($pm_recent_data['pm_status']) && $pm_recent_data['pm_status'] === 'Completed');
                                                    $isHold = (isset($data['Job_Status']) && $data['Job_Status'] === 'Hold' || $data['Job_Status'] == 'Closed');
                                                ?>
                                                <form action= "<?php echo base_url('index.php/Project_Manager/update_pm_job'); ?>" method="post" enctype="multipart/form-data">
                                                  <input type="hidden" name="task_id" value="<?php echo $data['id']; ?>">
                                                  <input type="hidden" name="User_ID" value="<?php echo $this->session->userdata('id'); ?>">
                                                  <input type="hidden" name="departments_assign_id" value="<?php echo $data['department_assign_id']; ?>">
                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Scope of Work</label>
                                                                  <div class="col-lg-6">
                                                                      <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                                        <select class="form-select" id="inputGroupSelect01" name="PM_Scope_of_Work">
                                                                          <option value="-">Choose...</option>
                                                                          <option value="Substation Construction">Substation Construction</option>
                                                                          <option value="Electrical Panel Works">Electrical Panel Works</option>
                                                                          <option value="Electrical Cabling Works">Electrical Cabling Works</option>
                                                                        </select>
                                                                      </div>
                                                                    
                                                                </div>
                                                              </div>
                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Status</label>
                                                                  <div class="col-lg-6">
                                                                  <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                                        <select class="form-select" id="inputGroupSelect01" name="PM_Status">
                                                                          <option value="-">Choose...</option>
                                                                          <option value="Process">Under Process</option>
                                                                          <option value="Completed">Completed</option>
                                                                        </select>
                                                                      </div>
                                                                  </div>
                                                              </div>

                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">PM Notes</label>
                                                                  <div class="col-lg-6 form-floating">
                                                                  <textarea class="form-control" id="floatingTextarea" name="PM_Notes" style="height: 120px"></textarea>
                                                                  <label for="floatingTextarea">PM Notes</label>
                                                                  </div>
                                                              </div>

                                                              <div class="row mb-3">
                                                                <label class="col-lg-4 col-form-label">Upload Document</label>
                                                                <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="file" class="form-control" id="inputGroupFile02" name="image" />
                                                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                                </div>
                                                                </div>


                                                                </div>
                                                
                                                        <div class="card-footer border-0">
                                                              <div class="row">
                                                                <label class="col-lg-4"></label>
                                                                <div class="col-lg-8">
                                                                    <button class="btn btn-primary me-2" <?= ($isPMCompleted || $isHold) ? 'disabled' : '' ?>>Submit</button>
                                                                    <button class="btn btn-secondary">Clear</button>
                                                                </div>
                                                              </div>
                                                              <?php if($isPMCompleted): ?>
                                                                <div class="alert alert-danger mt-2">
                                                                    This job is completed and cannot be edited.
                                                                </div>
                                                               <?php endif; ?>
                                                               <?php if($isHold): ?>
                                                                <div class="alert alert-dangers mt-2">
                                                                    This job is on Hold or Completed and cannot be edited.
                                                                </div>
                                                               <?php endif; ?>
                                                        </div>
                                                        
                                                </form>
                                              </div><!-- Col 8 Closed -->
                                                      
                                              <div class="col-4">
                                            
                                                  <center><img src="<?php echo base_url('include/dist/assets/images/PM.gif'); ?>" width="100%" alt="logo" />
                                                  <button 
                                                  class="btn btn-warning btn-sm"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#pmstatusupdate">
                                                    <i class="ph ph-pen align-right m-r-5"></i>
                                                    Update Status
                                                  </button></center>

                                              </div><!-- Col 4 Closed -->
                                          </div><!-- Row Closed -->
                                        </div><!-- Card Closed -->
                                      </div><!-- Tab Content Closed -->
                                </div><!-- Card Body Closed -->
                            </div><!-- Card Closed -->
                            <!-- Logs Start -->
                              <div class="card shadow-sm border-0 mt-4">
                                  <div class="card-header bg-light">
                                      <h5 class="mb-0">
                                          <i class="ti ti-clipboard-list"></i>
                                          Logs
                                      </h5>
                                  </div>

                                  <div class="card-body p-0">

                                      <?php if (!empty($pm_logs)): ?>
                                          <div class="table-responsive">
                                              <table id="jobsTable" class="table table-hover mb-0 w-100" id="advanced-table">
                                                  <thead class="table-light">
                                                      <tr>
                                                          <th>Date</th>
                                                          <th>Scope of Work</th>
                                                          <th>Status</th>
                                                          <th>Notes</th>
                                                          <th>File</th>
                                                          <th>Assigned User</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <?php foreach ($pm_logs as $log): ?>

                                                          <tr>
                                                              <td class="text-nowrap">
                                                                 <?= date('d M Y h:i A', strtotime($log['PM_Created_At'])); ?>
                                                              </td>

                                                              <td>
                                                                  <?= !empty($log['PM_Scope_of_Work'])
                                                                      ? '<span class="badge bg-info">'.htmlspecialchars($log['PM_Scope_of_Work']).'</span>'
                                                                      : '—'; ?>
                                                              </td>

                                                              <td>
                                                                  <?php
                                                                  $status = $log['PM_Status'] ?? '';
                                                                  $badge  = 'bg-secondary';

                                                                  if (stripos($status, 'APPROVED') !== false) $badge = 'bg-success';
                                                                  elseif (stripos($status, 'PENDING') !== false) $badge = 'bg-warning';
                                                                  elseif (stripos($status, 'REJECT') !== false) $badge = 'bg-danger';
                                                                  ?>

                                                                  <span class="badge <?= $badge; ?>">
                                                                      <?= htmlspecialchars($status ?: '—'); ?>
                                                                  </span>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['PM_Notes'])
                                                                      ? nl2br(htmlspecialchars($log['PM_Notes']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td class="text-nowrap">
                                                                  <?php if (!empty($log['PM_File'])): ?>
                                                                      <a href="<?= base_url('uploads/PM/'.$log['PM_File']); ?>"
                                                                        target="_blank"
                                                                        class="btn btn-outline-primary btn-sm">
                                                                          <i class="ph ph-file-arrow-down"></i> View
                                                                      </a>
                                                                  <?php else: ?>
                                                                      <span class="text-muted">—</span>
                                                                  <?php endif; ?>
                                                              </td>

                                                              <td>
                                                                  <?php echo $log['pm_user_name']; ?>
                                                              </td>

                                                          </tr>

                                                      <?php endforeach; ?>
                                                  </tbody>
                                              </table>
                                          </div>
                                      <?php else: ?>
                                          <div class="p-4 text-center text-muted">
                                              <i class="ph ph-info"></i><br>
                                              No PM submissions found for this task.
                                          </div>
                                      <?php endif; ?>

                                  </div>
                              </div>
                              <!-- Logs End -->
                          </div><!-- Col 12 Closed -->
                        </div><!-- Pane Closed -->
                      <?php } ?>
                      <?php if($data['department'] != "PM"){ ?>
                        <div class="tab-pane" id="PMDetail">
                        <div class="col-12">
                           <div class="card">
                            <div class="ribbon-wrapper ribbon-xl">
                                <?php $pm_recent_data['pm_status'] = $pm_recent_data['pm_status'] ?? ''; ?>
                                            <?php if($pm_recent_data['pm_status'] == 'Completed') { ?>
                                                <div class="ribbon bg-warning text-lg">
                                                    <?= $pm_recent_data['pm_status'] ?>
                                                </div>
                                            <?php } elseif ($pm_recent_data['pm_status'] == 'Process') { ?>
                                                <div class="ribbon bg-purple text-lg">
                                                    <?= $pm_recent_data['pm_status'] ?>
                                                </div>
                                            <?php } elseif ($pm_recent_data['pm_status'] == 'Assigned') { ?>
                                                <div class="ribbon bg-danger text-lg">
                                                    <?= $pm_recent_data['pm_status'] ?>
                                                </div>
                                            <?php } elseif ($pm_recent_data['pm_status'] == 'Hold') { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?= $pm_recent_data['pm_status'] ?>
                                                </div>
                                            <?php } elseif (empty($pm_recent_data['pm_status'])) { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?php echo "No Update"; ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                               <div class="card-body">
                                   <div class="tab-content">
                                      <div class="card shadow-sm border-0">
                                      <div class="card-header bg-light">
                                          <h5 class="mb-0">
                                              <i class="ph ph-lightning"></i>
                                              PM Department Submission
                                          </h5>
                                      </div>

                                      <div class="card-body">

                                          <!-- Scope of Work -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Scope of Work</div>
                                              <div class="col-md-8">
                                                  <span class="badge bg-info">
                                                      <?php echo $pm_recent_data['PM_Scope_of_Work'] ?? '—'; ?>

                                                  </span>
                                              </div>
                                          </div>

                                          <!-- Status -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Status</div>
                                              <div class="col-md-8">
                                                  <span class="badge bg-success">
                                                      <?php echo $pm_recent_data['PM_Status'] ?? '—'; ?>
                                                  </span>
                                              </div>
                                          </div>

                                          <!-- PM Notes -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">PM Notes</div>
                                              <div class="col-md-8">
                                                  <div class="p-2 border rounded bg-light">
                                                      <?= nl2br($pm_recent_data['PM_Notes'] ?? '—'); ?>
                                                  </div>
                                              </div>
                                          </div>

                                          <!-- Uploaded File -->
                                          <div class="row mb-2">
                                              <div class="col-md-4 text-muted fw-semibold">Uploaded Document</div>
                                              <div class="col-md-8">

                                                  <?php if (!empty($pm_recent_data['PM_File'])): ?>
                                                      <a href="<?= base_url('uploads/PM/' . $pm_recent_data['PM_File']); ?>"
                                                        target="_blank"
                                                        class="btn btn-outline-primary btn-sm">
                                                          <i class="ph ph-file-arrow-down"></i>
                                                          View / Download File
                                                      </a>
                                                  <?php else: ?>
                                                      <span class="text-muted">No file uploaded</span>
                                                  <?php endif; ?>

                                              </div>
                                          </div>

                                      </div>

                                      <div class="card-footer text-muted small">
                                          Submitted on -
                                          <?php if (!empty($pm_recent_data) && !empty($pm_recent_data['PM_Created_At'])): ?>
                                              <?= date('d M Y, h:i A', strtotime($pm_recent_data['PM_Created_At'])); ?>
                                          <?php else: ?>
                                              Not submitted yet
                                          <?php endif; ?>
                                      </div>

                                      
                                  </div>

                                   </div>
                               </div>
                           </div>
                              <!-- Logs Start -->
                              <div class="card shadow-sm border-0 mt-4">
                                  <div class="card-header bg-light">
                                      <h5 class="mb-0">
                                          <i class="ti ti-clipboard-list"></i>
                                          Logs
                                      </h5>
                                  </div>

                                  <div class="card-body p-0">

                                      <?php if (!empty($pm_logs)): ?>
                                          <div class="table-responsive">
                                              <table id="jobsTable" class="table table-hover mb-0 w-100" id="advanced-table">
                                                  <thead class="table-light">
                                                      <tr>
                                                          <th>Date</th>
                                                          <th>Scope of Work</th>
                                                          <th>Status</th>
                                                          <th>Notes</th>
                                                          <th>File</th>
                                                          <th>Assigned User</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <?php foreach ($pm_logs as $log): ?>

                                                          <tr>
                                                              <td class="text-nowrap">
                                                                 <?= date('d M Y h:i A', strtotime($log['PM_Created_At'])); ?>
                                                              </td>

                                                              <td>
                                                                  <?= !empty($log['PM_Scope_of_Work'])
                                                                      ? '<span class="badge bg-info">'.htmlspecialchars($log['PM_Scope_of_Work']).'</span>'
                                                                      : '—'; ?>
                                                              </td>

                                                              <td>
                                                                  <?php
                                                                  $status = $log['PM_Status'] ?? '';
                                                                  $badge  = 'bg-secondary';

                                                                  if (stripos($status, 'APPROVED') !== false) $badge = 'bg-success';
                                                                  elseif (stripos($status, 'PENDING') !== false) $badge = 'bg-warning';
                                                                  elseif (stripos($status, 'REJECT') !== false) $badge = 'bg-danger';
                                                                  ?>

                                                                  <span class="badge <?= $badge; ?>">
                                                                      <?= htmlspecialchars($status ?: '—'); ?>
                                                                  </span>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['PM_Notes'])
                                                                      ? nl2br(htmlspecialchars($log['PM_Notes']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td class="text-nowrap">
                                                                  <?php if (!empty($log['PM_File'])): ?>
                                                                      <a href="<?= base_url('uploads/PM/'.$log['PM_File']); ?>"
                                                                        target="_blank"
                                                                        class="btn btn-outline-primary btn-sm">
                                                                          <i class="ph ph-file-arrow-down"></i> View
                                                                      </a>
                                                                  <?php else: ?>
                                                                      <span class="text-muted">—</span>
                                                                  <?php endif; ?>
                                                              </td>

                                                              <td>
                                                                  <?php echo $log['pm_user_name']; ?>
                                                              </td>

                                                          </tr>

                                                      <?php endforeach; ?>
                                                  </tbody>
                                              </table>
                                          </div>
                                      <?php else: ?>
                                          <div class="p-4 text-center text-muted">
                                              <i class="ph ph-info"></i><br>
                                              No PM submissions found for this task.
                                          </div>
                                      <?php endif; ?>

                                  </div>
                              </div>
                              <!-- Logs End -->


                         </div>
                      </div>
                      <?php } ?>
                      <!-- End PM Pane -->
                      <!-- SWT Pane -->
                      <?php if($data['department'] == "Switchgear"){ ?>
                        <div class="tab-pane" id="SWGDetail">
                          <div class="col-12">
                            <div class="card">
                                <div class="ribbon-wrapper ribbon-xl">
                                    <?php $swt_recent_data['swt_status'] = $swt_recent_data['swt_status'] ?? ''; ?>
                                            <?php if($swt_recent_data['swt_status'] == 'Completed') { ?>
                                                <div class="ribbon bg-warning text-lg">
                                                    <?= $swt_recent_data['swt_status'] ?>
                                                </div>
                                            <?php } elseif ($swt_recent_data['swt_status'] == 'Process') { ?>
                                                <div class="ribbon bg-purple text-lg">
                                                    <?= $swt_recent_data['swt_status'] ?>
                                                </div>
                                            <?php } elseif ($swt_recent_data['swt_status'] == 'Assigned') { ?>
                                                <div class="ribbon bg-danger text-lg">
                                                    <?= $swt_recent_data['swt_status'] ?>
                                                </div>
                                            <?php } elseif ($swt_recent_data['swt_status'] == 'Hold') { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?= $swt_recent_data['swt_status'] ?>
                                                </div>
                                            <?php } elseif (empty($swt_recent_data['swt_status'])) { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?php echo "No Update"; ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="card">
                                          <div class="row">
                                              <div class="col-8">
                                                <?php
                                                    $isSWTCompleted = (isset($swt_recent_data['swt_status']) && $swt_recent_data['swt_status'] === 'Completed');
                                                    $isHold = (isset($data['Job_Status']) && $data['Job_Status'] === 'Hold' || $data['Job_Status'] == 'Closed');
                                                ?>
                                                <form action= "<?php echo base_url('index.php/Switchgear/update_swt_job'); ?>" method="post" enctype="multipart/form-data">
                                                  <input type="hidden" name="task_id" value="<?php echo $data['id']; ?>">
                                                  <input type="hidden" name="User_ID" value="<?php echo $this->session->userdata('id'); ?>">
                                                  <input type="hidden" name="departments_assign_id" value="<?php echo $data['department_assign_id']; ?>">
                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Scope of Work</label>
                                                                  <div class="col-lg-6">
                                                                      <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                                        <select class="form-select" id="inputGroupSelect01" name="Switchgear_Scope_of_Work">
                                                                          <option value="-">Choose...</option>
                                                                          <option value="Panel Design and Engineering">Panel Design and Engineering</option>
                                                                          <option value="Panel Manufacturing">Panel Manufacturing</option>
                                                                          <option value="Testing and Delivery">Testing and Delivery</option>
                                                                        </select>
                                                                      </div>
                                                                    
                                                                </div>
                                                              </div>
                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Status</label>
                                                                  <div class="col-lg-6">
                                                                  <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                                        <select class="form-select" id="inputGroupSelect01" name="Switchgear_Status">
                                                                          <option value="-">Choose...</option>
                                                                          <option value="Process">Under Process</option>
                                                                          <option value="Completed">Completed</option>
                                                                        </select>
                                                                      </div>
                                                                  </div>
                                                              </div>

                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Switchgear Notes</label>
                                                                  <div class="col-lg-6 form-floating">
                                                                  <textarea class="form-control" id="floatingTextarea" name="Switchgear_Notes" style="height: 120px"></textarea>
                                                                  <label for="floatingTextarea">Switchgear Notes</label>
                                                                  </div>
                                                              </div>

                                                              <div class="row mb-3">
                                                                <label class="col-lg-4 col-form-label">Upload Document</label>
                                                                <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="file" class="form-control" id="inputGroupFile02" name="image" />
                                                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                                </div>
                                                                </div>


                                                                </div>
                                                
                                                        <div class="card-footer border-0">
                                                              <div class="row">
                                                                <label class="col-lg-4"></label>
                                                                <div class="col-lg-8">
                                                                    <button class="btn btn-primary me-2" <?= ($isSWTCompleted || $isHold) ? 'disabled' : '' ?>>Submit</button>
                                                                    <button class="btn btn-secondary">Clear</button>
                                                                </div>
                                                              </div>
                                                              <?php if($isSWTCompleted): ?>
                                                                <div class="alert alert-danger mt-2">
                                                                    This job is completed and cannot be edited.
                                                                </div>
                                                               <?php endif; ?>
                                                               <?php if($isHold): ?>
                                                                <div class="alert alert-dangers mt-2">
                                                                    This job is on Hold or Completed and cannot be edited.
                                                                </div>
                                                               <?php endif; ?>
                                                        </div>
                                                        
                                                </form>
                                              </div><!-- Col 8 Closed -->
                                                      
                                              <div class="col-4">
                                            
                                                  <center><img src="<?php echo base_url('include/dist/assets/images/switchgear.gif'); ?>" width="80%" alt="logo" /><br>
                                                  <button 
                                                  class="btn btn-warning btn-sm"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#swtstatusupdate">
                                                    <i class="ph ph-pen align-right m-r-5"></i>
                                                    Update Status
                                                  </button></center>

                                              </div><!-- Col 4 Closed -->
                                          </div><!-- Row Closed -->
                                        </div><!-- Card Closed -->
                                      </div><!-- Tab Content Closed -->
                                </div><!-- Card Body Closed -->
                            </div><!-- Card Closed -->
                            <!-- Logs Start -->
                              <div class="card shadow-sm border-0 mt-4">
                                  <div class="card-header bg-light">
                                      <h5 class="mb-0">
                                          <i class="ti ti-clipboard-list"></i>
                                          Logs
                                      </h5>
                                  </div>

                                  <div class="card-body p-0">

                                      <?php if (!empty($swt_logs)): ?>
                                          <div class="table-responsive">
                                              <table id="jobsTable" class="table table-hover mb-0 w-100" id="advanced-table">
                                                  <thead class="table-light">
                                                      <tr>
                                                          <th>Date</th>
                                                          <th>Scope of Work</th>
                                                          <th>Status</th>
                                                          <th>Notes</th>
                                                          <th>File</th>
                                                          <th>Assigned User</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <?php foreach ($swt_logs as $log): ?>

                                                          <tr>
                                                              <td class="text-nowrap">
                                                                 <?= date('d M Y h:i A', strtotime($log['Switchgear_Created_At'])); ?>
                                                              </td>

                                                              <td>
                                                                  <?= !empty($log['Switchgear_Scope_of_Work'])
                                                                      ? '<span class="badge bg-info">'.htmlspecialchars($log['Switchgear_Scope_of_Work']).'</span>'
                                                                      : '—'; ?>
                                                              </td>

                                                              <td>
                                                                  <?php
                                                                  $status = $log['Switchgear_Status'] ?? '';
                                                                  $badge  = 'bg-secondary';

                                                                  if (stripos($status, 'APPROVED') !== false) $badge = 'bg-success';
                                                                  elseif (stripos($status, 'PENDING') !== false) $badge = 'bg-warning';
                                                                  elseif (stripos($status, 'REJECT') !== false) $badge = 'bg-danger';
                                                                  ?>

                                                                  <span class="badge <?= $badge; ?>">
                                                                      <?= htmlspecialchars($status ?: '—'); ?>
                                                                  </span>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['Switchgear_Notes'])
                                                                      ? nl2br(htmlspecialchars($log['Switchgear_Notes']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td class="text-nowrap">
                                                                  <?php if (!empty($log['Switchgear_File'])): ?>
                                                                      <a href="<?= base_url('uploads/Switchgear/'.$log['Switchgear_File']); ?>"
                                                                        target="_blank"
                                                                        class="btn btn-outline-primary btn-sm">
                                                                          <i class="ph ph-file-arrow-down"></i> View
                                                                      </a>
                                                                  <?php else: ?>
                                                                      <span class="text-muted">—</span>
                                                                  <?php endif; ?>
                                                              </td>

                                                              <td>
                                                                  <?php echo $log['swt_user_name']; ?>
                                                              </td>

                                                          </tr>

                                                      <?php endforeach; ?>
                                                  </tbody>
                                              </table>
                                          </div>
                                      <?php else: ?>
                                          <div class="p-4 text-center text-muted">
                                              <i class="ph ph-info"></i><br>
                                              No Switchgear submissions found for this task.
                                          </div>
                                      <?php endif; ?>

                                  </div>
                              </div>
                              <!-- Logs End -->
                          </div><!-- Col 12 Closed -->
                        </div><!-- Pane Closed -->
                      <?php } ?>
                      <?php if($data['department'] != "Switchgear"){ ?>
                        <div class="tab-pane" id="SWGDetail">
                           <div class="col-12">
                           <div class="card">
                                        <div class="ribbon-wrapper ribbon-xl">
                                            <?php $swt_recent_data['swt_status'] = $swt_recent_data['swt_status'] ?? ''; ?>
                                            <?php if($swt_recent_data['swt_status'] == 'Completed') { ?>
                                                <div class="ribbon bg-warning text-lg">
                                                    <?= $swt_recent_data['swt_status'] ?>
                                                </div>
                                            <?php } elseif ($swt_recent_data['swt_status'] == 'Process') { ?>
                                                <div class="ribbon bg-purple text-lg">
                                                    <?= $swt_recent_data['swt_status'] ?>
                                                </div>
                                            <?php } elseif ($swt_recent_data['swt_status'] == 'Assigned') { ?>
                                                <div class="ribbon bg-danger text-lg">
                                                    <?= $swt_recent_data['swt_status'] ?>
                                                </div>
                                            <?php } elseif ($swt_recent_data['swt_status'] == 'Hold') { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?= $swt_recent_data['swt_status'] ?>
                                                </div>
                                            <?php } elseif (empty($swt_recent_data['swt_status'])) { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?php echo "No Update"; ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                               <div class="card-body">
                                   <div class="tab-content">
                                      <div class="card shadow-sm border-0">
                                      <div class="card-header bg-light">
                                          <h5 class="mb-0">
                                              <i class="ph ph-lightning"></i>
                                              Switchgear Department Submission
                                          </h5>
                                      </div>

                                      <div class="card-body">

                                          <!-- Scope of Work -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Scope of Work</div>
                                              <div class="col-md-8">
                                                  <span class="badge bg-info">
                                                      <?php echo $swt_recent_data['Switchgear_Scope_of_Work'] ?? '—'; ?>

                                                  </span>
                                              </div>
                                          </div>

                                          <!-- Status -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Status</div>
                                              <div class="col-md-8">
                                                  <span class="badge bg-success">
                                                      <?php echo $swt_recent_data['Switchgear_Status'] ?? '—'; ?>
                                                  </span>
                                              </div>
                                          </div>

                                          <!-- PM Notes -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Switchgear Notes</div>
                                              <div class="col-md-8">
                                                  <div class="p-2 border rounded bg-light">
                                                      <?= nl2br($swt_recent_data['Switchgear_Notes'] ?? '—'); ?>
                                                  </div>
                                              </div>
                                          </div>

                                          <!-- Uploaded File -->
                                          <div class="row mb-2">
                                              <div class="col-md-4 text-muted fw-semibold">Uploaded Document</div>
                                              <div class="col-md-8">

                                                  <?php if (!empty($swt_recent_data['Switchgear_File'])): ?>
                                                      <a href="<?= base_url('uploads/Switchgear/' . $swt_recent_data['Switchgear_File']); ?>"
                                                        target="_blank"
                                                        class="btn btn-outline-primary btn-sm">
                                                          <i class="ph ph-file-arrow-down"></i>
                                                          View / Download File
                                                      </a>
                                                  <?php else: ?>
                                                      <span class="text-muted">No file uploaded</span>
                                                  <?php endif; ?>

                                              </div>
                                          </div>

                                      </div>

                                      <div class="card-footer text-muted small">
                                          Submitted on -
                                          <?php if (!empty($swt_recent_data) && !empty($swt_recent_data['Switchgear_Created_At'])): ?>
                                              <?= date('d M Y, h:i A', strtotime($swt_recent_data['Switchgear_Created_At'])); ?>
                                          <?php else: ?>
                                              Not submitted yet
                                          <?php endif; ?>
                                      </div>

                                      
                                  </div>

                                   </div>
                               </div>
                           </div>
                              <!-- Logs Start -->
                              <div class="card shadow-sm border-0 mt-4">
                                  <div class="card-header bg-light">
                                      <h5 class="mb-0">
                                          <i class="ti ti-clipboard-list"></i>
                                          Logs
                                      </h5>
                                  </div>

                                  <div class="card-body p-0">

                                      <?php if (!empty($swt_logs)): ?>
                                          <div class="table-responsive">
                                              <table id="jobsTable" class="table table-hover mb-0 w-100" id="advanced-table">
                                                  <thead class="table-light">
                                                      <tr>
                                                          <th>Date</th>
                                                          <th>Scope of Work</th>
                                                          <th>Status</th>
                                                          <th>Notes</th>
                                                          <th>File</th>
                                                          <th>Assigned User</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <?php foreach ($swt_logs as $log): ?>

                                                          <tr>
                                                              <td class="text-nowrap">
                                                                 <?= date('d M Y h:i A', strtotime($log['Switchgear_Created_At'])); ?>
                                                              </td>

                                                              <td>
                                                                  <?= !empty($log['Switchgear_Scope_of_Work'])
                                                                      ? '<span class="badge bg-info">'.htmlspecialchars($log['Switchgear_Scope_of_Work']).'</span>'
                                                                      : '—'; ?>
                                                              </td>

                                                              <td>
                                                                  <?php
                                                                  $status = $log['Switchgear_Status'] ?? '';
                                                                  $badge  = 'bg-secondary';

                                                                  if (stripos($status, 'APPROVED') !== false) $badge = 'bg-success';
                                                                  elseif (stripos($status, 'PENDING') !== false) $badge = 'bg-warning';
                                                                  elseif (stripos($status, 'REJECT') !== false) $badge = 'bg-danger';
                                                                  ?>

                                                                  <span class="badge <?= $badge; ?>">
                                                                      <?= htmlspecialchars($status ?: '—'); ?>
                                                                  </span>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['Switchgear_Notes'])
                                                                      ? nl2br(htmlspecialchars($log['Switchgear_Notes']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td class="text-nowrap">
                                                                  <?php if (!empty($log['Switchgear_File'])): ?>
                                                                      <a href="<?= base_url('uploads/Switchgear/'.$log['Switchgear_File']); ?>"
                                                                        target="_blank"
                                                                        class="btn btn-outline-primary btn-sm">
                                                                          <i class="ph ph-file-arrow-down"></i> View
                                                                      </a>
                                                                  <?php else: ?>
                                                                      <span class="text-muted">—</span>
                                                                  <?php endif; ?>
                                                              </td>

                                                              <td>
                                                                  <?php echo $log['swt_user_name']; ?>
                                                              </td>
                                                              
                                                          </tr>

                                                      <?php endforeach; ?>
                                                  </tbody>
                                              </table>
                                          </div>
                                      <?php else: ?>
                                          <div class="p-4 text-center text-muted">
                                              <i class="ph ph-info"></i><br>
                                              No SWT submissions found for this task.
                                          </div>
                                      <?php endif; ?>

                                  </div>
                              </div>
                                
                         </div>
                          <!-- end row -->
                      </div>
                      <?php } ?>
                      <!-- End SWT Pane -->
                      <!-- MTN Pane -->
                      <?php if($data['department'] == "Maintenance"){ ?>
                        <div class="tab-pane" id="MTNDetail">
                          <div class="col-12">
                            <div class="card">
                                <div class="ribbon-wrapper ribbon-xl">
                                    <?php $mtn_recent_data['mtn_status'] = $mtn_recent_data['mtn_status'] ?? ''; ?>
                                            <?php if($mtn_recent_data['mtn_status'] == 'Completed') { ?>
                                                <div class="ribbon bg-warning text-lg">
                                                    <?= $mtn_recent_data['mtn_status'] ?>
                                                </div>
                                            <?php } elseif ($mtn_recent_data['mtn_status'] == 'Process') { ?>
                                                <div class="ribbon bg-purple text-lg">
                                                    <?= $mtn_recent_data['mtn_status'] ?>
                                                </div>
                                            <?php } elseif ($mtn_recent_data['mtn_status'] == 'Assigned') { ?>
                                                <div class="ribbon bg-danger text-lg">
                                                    <?= $mtn_recent_data['mtn_status'] ?>
                                                </div>
                                            <?php } elseif ($mtn_recent_data['mtn_status'] == 'Hold') { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?= $mtn_recent_data['mtn_status'] ?>
                                                </div>
                                            <?php } elseif (empty($mtn_recent_data['mtn_status'])) { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?php echo "No Update"; ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="card">
                                          <div class="row">
                                              <div class="col-8">
                                                <?php
                                                    $isMTNCompleted = (isset($mtn_recent_data['Maintenance_Status']) && $mtn_recent_data['Maintenance_Status'] === 'Completed');
                                                    $isHold = (isset($data['Job_Status']) && $data['Job_Status'] === 'Hold' || $data['Job_Status'] == 'Closed');
                                                ?>
                                                <form action= "<?php echo base_url('index.php/Maintenance/update_mtn_job'); ?>" method="post" enctype="multipart/form-data">
                                                  <input type="hidden" name="task_id" value="<?php echo $data['id']; ?>">
                                                  <input type="hidden" name="User_ID" value="<?php echo $this->session->userdata('id'); ?>">
                                                  <input type="hidden" name="departments_assign_id" value="<?php echo $data['department_assign_id']; ?>">
                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Scope of Work</label>
                                                                  <div class="col-lg-6">
                                                                      <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                                        <select class="form-select" id="inputGroupSelect01" name="Maintenance_Scope_of_Work">
                                                                          <option value="-">Choose...</option>
                                                                          <option value="Preventive Maintenance Works">Preventive Maintenance Works</option>
                                                                          <option value="Breakdown Rectification">Breakdown Rectification</option>
                                                                          <option value="AMC Support Services">AMC Support Services</option>
                                                                        </select>
                                                                      </div>
                                                                    
                                                                </div>
                                                              </div>
                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Status</label>
                                                                  <div class="col-lg-6">
                                                                  <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                                                        <select class="form-select" id="inputGroupSelect01" name="Maintenance_Status">
                                                                          <option value="-">Choose...</option>
                                                                          <option value="Process">Under Process</option>
                                                                          <option value="Complete">Complete</option>
                                                                        </select>
                                                                      </div>
                                                                  </div>
                                                              </div>

                                                              <div class="row mb-3">
                                                                  <label class="col-lg-4 col-form-label">Maintenance Notes</label>
                                                                  <div class="col-lg-6 form-floating">
                                                                  <textarea class="form-control" id="floatingTextarea" name="Maintenance_Notes" style="height: 120px"></textarea>
                                                                  <label for="floatingTextarea">Maintenance Notes</label>
                                                                  </div>
                                                              </div>

                                                              <div class="row mb-3">
                                                                <label class="col-lg-4 col-form-label">Upload Document</label>
                                                                <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <input type="file" class="form-control" id="inputGroupFile02" name="image" />
                                                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                                </div>
                                                                </div>


                                                                </div>
                                                
                                                        <div class="card-footer border-0">
                                                              <div class="row">
                                                                <label class="col-lg-4"></label>
                                                                <div class="col-lg-8">
                                                                    <button class="btn btn-primary me-2" <?= ($isMTNCompleted || $isHold) ? 'disabled' : '' ?>>Submit</button>
                                                                    <button class="btn btn-secondary">Clear</button>
                                                                </div>
                                                              </div>
                                                              <?php if($isMTNCompleted): ?>
                                                                <div class="alert alert-danger mt-2">
                                                                    This job is completed and cannot be edited.
                                                                </div>
                                                               <?php endif; ?>
                                                               <?php if($isHold): ?>
                                                                <div class="alert alert-dangers mt-2">
                                                                    This job is on Hold or Completed and cannot be edited.
                                                                </div>
                                                               <?php endif; ?>
                                                        </div>
                                                        
                                                </form>
                                              </div><!-- Col 8 Closed -->
                                                      
                                              <div class="col-4">
                                            
                                                  <center><img src="<?php echo base_url('include/dist/assets/images/Maintenancemtn.gif'); ?>" width="100%" alt="logo" />
                                                  <button 
                                                  class="btn btn-warning btn-sm"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#mtnstatusupdate">
                                                    <i class="ph ph-pen align-right m-r-5"></i>
                                                    Update Status
                                                  </button></center>

                                              </div><!-- Col 4 Closed -->
                                          </div><!-- Row Closed -->
                                        </div><!-- Card Closed -->
                                      </div><!-- Tab Content Closed -->
                                </div><!-- Card Body Closed -->
                            </div><!-- Card Closed -->
                            <!-- Logs Start -->
                              <div class="card shadow-sm border-0 mt-4">
                                  <div class="card-header bg-light">
                                      <h5 class="mb-0">
                                          <i class="ti ti-clipboard-list"></i>
                                          Logs
                                      </h5>
                                  </div>

                                  <div class="card-body p-0">

                                      <?php if (!empty($mtn_logs)): ?>
                                          <div class="table-responsive">
                                              <table id="jobsTable" class="table table-hover mb-0 w-100" id="advanced-table">
                                                  <thead class="table-light">
                                                      <tr>
                                                          <th>Date</th>
                                                          <th>Scope of Work</th>
                                                          <th>Status</th>
                                                          <th>Notes</th>
                                                          <th>File</th>
                                                          <th>Assigned User</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <?php foreach ($mtn_logs as $log): ?>

                                                          <tr>
                                                              <td class="text-nowrap">
                                                                 <?= date('d M Y h:i A', strtotime($log['Maintenance_Created_At'])); ?>
                                                              </td>

                                                              <td>
                                                                  <?= !empty($log['Maintenance_Scope_of_Work'])
                                                                      ? '<span class="badge bg-info">'.htmlspecialchars($log['Maintenance_Scope_of_Work']).'</span>'
                                                                      : '—'; ?>
                                                              </td>

                                                              <td>
                                                                  <?php
                                                                  $status = $log['Maintenance_Status'] ?? '';
                                                                  $badge  = 'bg-secondary';

                                                                  if (stripos($status, 'APPROVED') !== false) $badge = 'bg-success';
                                                                  elseif (stripos($status, 'PENDING') !== false) $badge = 'bg-warning';
                                                                  elseif (stripos($status, 'REJECT') !== false) $badge = 'bg-danger';
                                                                  ?>

                                                                  <span class="badge <?= $badge; ?>">
                                                                      <?= htmlspecialchars($status ?: '—'); ?>
                                                                  </span>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['Maintenance_Notes'])
                                                                      ? nl2br(htmlspecialchars($log['Maintenance_Notes']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td class="text-nowrap">
                                                                  <?php if (!empty($log['Maintenance_File'])): ?>
                                                                      <a href="<?= base_url('uploads/Maintenance/'.$log['Maintenance_File']); ?>"
                                                                        target="_blank"
                                                                        class="btn btn-outline-primary btn-sm">
                                                                          <i class="ph ph-file-arrow-down"></i> View
                                                                      </a>
                                                                  <?php else: ?>
                                                                      <span class="text-muted">—</span>
                                                                  <?php endif; ?>
                                                              </td>

                                                              <td>
                                                                  <?php echo $log['mtn_user_name']; ?>
                                                              </td>

                                                          </tr>

                                                      <?php endforeach; ?>
                                                  </tbody>
                                              </table>
                                          </div>
                                      <?php else: ?>
                                          <div class="p-4 text-center text-muted">
                                              <i class="ph ph-info"></i><br>
                                              No Maintenance submissions found for this task.
                                          </div>
                                      <?php endif; ?>

                                  </div>
                              </div>
                              <!-- Logs End -->
                          </div><!-- Col 12 Closed -->
                        </div><!-- Pane Closed -->
                      <?php } ?>
                      <?php if($data['department'] != "Maintenance"){ ?>
                        <div class="tab-pane" id="MTNDetail">
                        <div class="col-12">
                           <div class="card">
                                        <div class="ribbon-wrapper ribbon-xl">
                                            <?php $mtn_recent_data['mtn_status'] = $mtn_recent_data['mtn_status'] ?? ''; ?>
                                            <?php if($mtn_recent_data['mtn_status'] == 'Completed') { ?>
                                                <div class="ribbon bg-warning text-lg">
                                                    <?= $mtn_recent_data['mtn_status'] ?>
                                                </div>
                                            <?php } elseif ($mtn_recent_data['mtn_status'] == 'Process') { ?>
                                                <div class="ribbon bg-purple text-lg">
                                                    <?= $mtn_recent_data['mtn_status'] ?>
                                                </div>
                                            <?php } elseif ($mtn_recent_data['mtn_status'] == 'Assigned') { ?>
                                                <div class="ribbon bg-danger text-lg">
                                                    <?= $mtn_recent_data['mtn_status'] ?>
                                                </div>
                                            <?php } elseif ($mtn_recent_data['mtn_status'] == 'Hold') { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?= $mtn_recent_data['mtn_status'] ?>
                                                </div>
                                            <?php } elseif (empty($mtn_recent_data['mtn_status'])) { ?>
                                                <div class="ribbon bg-dangers text-lg">
                                                    <?php echo "No Update"; ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                               <div class="card-body">
                                   <div class="tab-content">
                                      <div class="card shadow-sm border-0">
                                      <div class="card-header bg-light">
                                          <h5 class="mb-0">
                                              <i class="ph ph-lightning"></i>
                                              Maintenance Department Submission
                                          </h5>
                                      </div>

                                      <div class="card-body">

                                          <!-- Scope of Work -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Scope of Work</div>
                                              <div class="col-md-8">
                                                  <span class="badge bg-info">
                                                      <?php echo $mtn_recent_data['Maintenance_Scope_of_Work'] ?? '—'; ?>

                                                  </span>
                                              </div>
                                          </div>

                                          <!-- Status -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Status</div>
                                              <div class="col-md-8">
                                                  <span class="badge bg-success">
                                                      <?php echo $mtn_recent_data['Maintenance_Status'] ?? '—'; ?>
                                                  </span>
                                              </div>
                                          </div>

                                          <!-- PM Notes -->
                                          <div class="row mb-3">
                                              <div class="col-md-4 text-muted fw-semibold">Maintenance Notes</div>
                                              <div class="col-md-8">
                                                  <div class="p-2 border rounded bg-light">
                                                      <?= nl2br($mtn_recent_data['Maintenance_Notes'] ?? '—'); ?>
                                                  </div>
                                              </div>
                                          </div>

                                          <!-- Uploaded File -->
                                          <div class="row mb-2">
                                              <div class="col-md-4 text-muted fw-semibold">Uploaded Document</div>
                                              <div class="col-md-8">

                                                  <?php if (!empty($mtn_recent_data['Maintenance_File'])): ?>
                                                      <a href="<?= base_url('uploads/Maintenance/' . $mtn_recent_data['Maintenance_File']); ?>"
                                                        target="_blank"
                                                        class="btn btn-outline-primary btn-sm">
                                                          <i class="ph ph-file-arrow-down"></i>
                                                          View / Download File
                                                      </a>
                                                  <?php else: ?>
                                                      <span class="text-muted">No file uploaded</span>
                                                  <?php endif; ?>

                                              </div>
                                          </div>

                                      </div>

                                      <div class="card-footer text-muted small">
                                          Submitted on -
                                          <?php if (!empty($mtn_recent_data) && !empty($mtn_recent_data['Maintenance_Created_At'])): ?>
                                              <?= date('d M Y, h:i A', strtotime($mtn_recent_data['Maintenance_Created_At'])); ?>
                                          <?php else: ?>
                                              Not submitted yet
                                          <?php endif; ?>
                                      </div>

                                      
                                  </div>

                                   </div>
                               </div>
                           </div>
                              <!-- Logs Start -->
                              <!-- Logs Start -->
                              <div class="card shadow-sm border-0 mt-4">
                                  <div class="card-header bg-light">
                                      <h5 class="mb-0">
                                          <i class="ti ti-clipboard-list"></i>
                                          Logs
                                      </h5>
                                  </div>

                                  <div class="card-body p-0">

                                      <?php if (!empty($mtn_logs)): ?>
                                          <div class="table-responsive">
                                              <table id="jobsTable" class="table table-hover mb-0 w-100" id="advanced-table">
                                                  <thead class="table-light">
                                                      <tr>
                                                          <th>Date</th>
                                                          <th>Scope of Work</th>
                                                          <th>Status</th>
                                                          <th>Notes</th>
                                                          <th>File</th>
                                                          <th>Assigned User</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <?php foreach ($mtn_logs as $log): ?>

                                                          <tr>
                                                              <td class="text-nowrap">
                                                                 <?= date('d M Y h:i A', strtotime($log['Maintenance_Created_At'])); ?>
                                                              </td>

                                                              <td>
                                                                  <?= !empty($log['Maintenance_Scope_of_Work'])
                                                                      ? '<span class="badge bg-info">'.htmlspecialchars($log['Maintenance_Scope_of_Work']).'</span>'
                                                                      : '—'; ?>
                                                              </td>

                                                              <td>
                                                                  <?php
                                                                  $status = $log['Maintenance_Status'] ?? '';
                                                                  $badge  = 'bg-secondary';

                                                                  if (stripos($status, 'APPROVED') !== false) $badge = 'bg-success';
                                                                  elseif (stripos($status, 'PENDING') !== false) $badge = 'bg-warning';
                                                                  elseif (stripos($status, 'REJECT') !== false) $badge = 'bg-danger';
                                                                  ?>

                                                                  <span class="badge <?= $badge; ?>">
                                                                      <?= htmlspecialchars($status ?: '—'); ?>
                                                                  </span>
                                                              </td>

                                                              <td style="max-width: 250px;">
                                                                  <?= !empty($log['Maintenance_Notes'])
                                                                      ? nl2br(htmlspecialchars($log['Maintenance_Notes']))
                                                                      : '<span class="text-muted">—</span>'; ?>
                                                              </td>

                                                              <td class="text-nowrap">
                                                                  <?php if (!empty($log['Maintenance_File'])): ?>
                                                                      <a href="<?= base_url('uploads/Maintenance/'.$log['Maintenance_File']); ?>"
                                                                        target="_blank"
                                                                        class="btn btn-outline-primary btn-sm">
                                                                          <i class="ph ph-file-arrow-down"></i> View
                                                                      </a>
                                                                  <?php else: ?>
                                                                      <span class="text-muted">—</span>
                                                                  <?php endif; ?>
                                                              </td>

                                                              <td>
                                                                  <?php echo $log['mtn_user_name']; ?>
                                                              </td>
                                                              
                                                          </tr>

                                                      <?php endforeach; ?>
                                                  </tbody>
                                              </table>
                                          </div>
                                      <?php else: ?>
                                          <div class="p-4 text-center text-muted">
                                              <i class="ph ph-info"></i><br>
                                              No Maintenance submissions found for this task.
                                          </div>
                                      <?php endif; ?>

                                  </div>
                              </div>
                                
                         </div>
                        <!-- end row -->
                      </div>
                      <?php } ?>
                      <!-- End MTN Pane -->
                      <!-- END: Define your tab pans here -->
                      <!-- START: Define your controller buttons here-->
                      
                      <!-- END: Define your controller buttons here-->
                    </div>
                  </div>
                </div>
                <!-- end tab content-->
              </div>

            </div>
          </div>

          <!-- Electric Status Update Modal Start -->
          <div
                  id="exampleModalLive"
                  class="modal fade"
                  tabindex="-1"
                  role="dialog"
                  aria-labelledby="exampleModalLiveLabel"
                  aria-hidden="true"
                >
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLiveLabel">Update Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form method="post" action="<?= base_url('index.php/Electrical/update_status_job') ?>">
                            <div class="mb-3">
                              <label class="form-label" for="exampleFormControlSelect1">Status <span style="color:red;">*</span></label>
                                <select class="form-select" id="exampleFormControlSelect1" name="Status">
                                  <option value="">--Select--</option>
                                  <option value="Process" <?php if($data['status'] == 'Process'): echo 'selected'; endif;?>>Under Process</option>
                                  <option value="Completed" <?php if($data['status'] == 'Completed'): echo 'selected'; endif;?>>Completed</option>
                                </select>
                                <input type="text" name="ID" value="<?php echo $data['department_assign_id']; ?>" hidden=""/>
                                <input type="hidden" name="task_id" value="<?php echo $data['id']; ?>">
                          </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Save changes" name="submit_update"/>
                          </div>
                        </form>
                        
                    </div>
                  </div>
                </div>
          </div>
          <!-- Electric Status Update Modal End-->
          <!-- Civil Status Update Modal Start -->
          <div
                  id="civilstatusupdate"
                  class="modal fade"
                  tabindex="-1"
                  role="dialog"
                  aria-labelledby="exampleModalLiveLabel"
                  aria-hidden="true"
                >
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLiveLabel">Update Civil Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form method="post" action="<?= base_url('index.php/Civil/update_civil_status_job') ?>">
                            <div class="mb-3">
                              <label class="form-label" for="exampleFormControlSelect1">Status <span style="color:red;">*</span></label>
                                <select class="form-select" id="exampleFormControlSelect1" name="Status">
                                  <option value="">--Select--</option>
                                  <option value="Process" <?php if($data['status'] == 'Process'): echo 'selected'; endif;?>>Under Process</option>
                                  <option value="Completed" <?php if($data['status'] == 'Completed'): echo 'selected'; endif;?>>Completed</option>
                                </select>
                                <input type="text" name="ID" value="<?php echo $data['department_assign_id']; ?>" hidden=""/>
                                <input type="hidden" name="task_id" value="<?php echo $data['id']; ?>">
                          </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Save changes" name="submit_update"/>
                          </div>
                        </form>
                        
                    </div>
                  </div>
                </div>
          </div>
          <!-- Civil Status Update Modal End-->
          <!-- PM Status Update Modal Start -->
          <div
                  id="pmstatusupdate"
                  class="modal fade"
                  tabindex="-1"
                  role="dialog"
                  aria-labelledby="exampleModalLiveLabel"
                  aria-hidden="true"
                >
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLiveLabel">Update PM Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form method="post" action="<?= base_url('index.php/Project_Manager/update_pm_status_job') ?>">
                            <div class="mb-3">
                              <label class="form-label" for="exampleFormControlSelect1">Status <span style="color:red;">*</span></label>
                                <select class="form-select" id="exampleFormControlSelect1" name="Status">
                                  <option value="">--Select--</option>
                                  <option value="Process" <?php if($data['status'] == 'Process'): echo 'selected'; endif;?>>Under Process</option>
                                  <option value="Completed" <?php if($data['status'] == 'Completed'): echo 'selected'; endif;?>>Completed</option>
                                </select>
                                <input type="text" name="ID" value="<?php echo $data['department_assign_id']; ?>" hidden=""/>
                                <input type="hidden" name="task_id" value="<?php echo $data['id']; ?>">
                          </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Save changes" name="submit_update"/>
                          </div>
                        </form>
                        
                    </div>
                  </div>
                </div>
          </div>
          <!-- PM Status Update Modal End-->
          <!-- SWT Status Update Modal Start -->
          <div
                  id="swtstatusupdate"
                  class="modal fade"
                  tabindex="-1"
                  role="dialog"
                  aria-labelledby="exampleModalLiveLabel"
                  aria-hidden="true"
                >
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLiveLabel">Update Switchgear Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form method="post" action="<?= base_url('index.php/Switchgear/update_swt_status_job') ?>">
                            <div class="mb-3">
                              <label class="form-label" for="exampleFormControlSelect1">Status <span style="color:red;">*</span></label>
                                <select class="form-select" id="exampleFormControlSelect1" name="Status">
                                  <option value="">--Select--</option>
                                  <option value="Process" <?php if($data['status'] == 'Process'): echo 'selected'; endif;?>>Under Process</option>
                                  <option value="Completed" <?php if($data['status'] == 'Completed'): echo 'selected'; endif;?>>Completed</option>
                                </select>
                                <input type="text" name="ID" value="<?php echo $data['department_assign_id']; ?>" hidden=""/>
                                <input type="hidden" name="task_id" value="<?php echo $data['id']; ?>">
                          </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Save changes" name="submit_update"/>
                          </div>
                        </form>
                        
                    </div>
                  </div>
                </div>
          </div>
          <!-- SWT Status Update Modal End-->
           <!-- MTN Status Update Modal Start -->
          <div
                  id="mtnstatusupdate"
                  class="modal fade"
                  tabindex="-1"
                  role="dialog"
                  aria-labelledby="exampleModalLiveLabel"
                  aria-hidden="true"
                >
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLiveLabel">Update Maintenance Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form method="post" action="<?= base_url('index.php/Maintenance/update_mtn_status_job') ?>">
                            <div class="mb-3">
                              <label class="form-label" for="exampleFormControlSelect1">Status <span style="color:red;">*</span></label>
                                <select class="form-select" id="exampleFormControlSelect1" name="Status">
                                  <option value="">--Select--</option>
                                  <option value="Process" <?php if($data['status'] == 'Process'): echo 'selected'; endif;?>>Under Process</option>
                                  <option value="Completed" <?php if($data['status'] == 'Completed'): echo 'selected'; endif;?>>Completed</option>
                                </select>
                                <input type="text" name="ID" value="<?php echo $data['department_assign_id']; ?>" hidden=""/>
                                <input type="hidden" name="task_id" value="<?php echo $data['id']; ?>">
                          </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Save changes" name="submit_update"/>
                          </div>
                        </form>
                        
                    </div>
                  </div>
                </div>
          </div>
          <!-- MTN Status Update Modal End-->


          <!-- [ sample-page ] end -->
        </div>




<script src="<?php echo base_url('include/dist/assets/js/plugins/wizard.min.js')?>"></script>
<?php
function formatFileSize($bytes, $decimals = 2)
{
    if ($bytes <= 0) return '0 B';

    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f %s", $bytes / pow(1024, $factor), $units[$factor]);
}
?>
<script>
      new Wizard('#basicwizard', {
        validate: true,
        progress: true
      });
</script>

                   
                
                