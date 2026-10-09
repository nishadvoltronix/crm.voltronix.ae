<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
.attachment-card {
    border: 1px solid #e6e6e6;
    border-radius: 6px;
    background: #fff;
    overflow: hidden;
    height: 100%;
    transition: 0.2s;
}

.attachment-card:hover {
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
}


/* Thumbnail area */
.attachment-preview {
    width: 100%;
    height: 110px;
    background: #f7f7f7;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}


/* Image */
.attachment-image {
    width: 100%;
    height: 110px;
    object-fit: cover;
    display: block;
}


/* File icons */
.file-icon-wrapper {
    text-align: center;
}

.file-icon {
    font-size: 35px;
    color: #777;
    display: block;
    margin-bottom: 5px;
}


/* Information section */
.attachment-info {
    padding: 8px 10px;
}

.attachment-name {
    font-size: 12px;
    font-weight: 500;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;

    margin-bottom: 3px;
}

.attachment-info small {
    font-size: 10px;
}


/* Buttons */
.attachment-actions {
    margin-top: 7px;
    display: flex;
    gap: 4px;
}

.attachment-actions .btn {
    padding: 3px 7px;
    font-size: 11px;
}
</style>
<!-- [ Main Content ] start -->
        <div class="row">
            
     

            
          <!-- [ task-detail-left ] start -->
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
                  <div><?php echo $data['assigned_to_name'] ?></div>
                </li> 
                <li class="list-group-item d-flex justify-content-between">
                  <div class="h6 m-0"><i class="ti ti-currency-dirham align-middle f-20 text-dangers"></i> Amount:</div>
                  <div><?php echo $data['service_charge'] ?></div>
                </li>   
                <li class="list-group-item d-flex justify-content-between">
                  <div class="h6 m-0"><i class="ph ph ph-list-numbers align-middle f-20 text-dangers"></i> Deal No.:</div>
                  <div><?php echo $data['qual_deal_number'] ?></div>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <div class="h6 m-0"><i class="ph ph ph-list-numbers align-middle f-20 text-dangers"></i> Site No.:</div>
                  <div><?php echo $data['site_deal_number'] ?></div>
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
                      
                      <?php if ($data['status'] == 'Pending' || $data['status'] == 'Qualification'){?>  
                          <span class="badge bg-primary"><?php echo $data['status'] ?></div></span>
                    
                      <?php } elseif ($data['status'] == 'Site Visit'){?>
                          <span class="badge bg-red-500"><?php echo $data['status'] ?></div></span>
                
                      <?php } elseif ($data['status'] == 'Proposal' || $data['status'] == 'Proposal/Price Quote'){?>
                          <span class="badge bg-green-500"><?php echo $data['status'] ?></div></span>
                
                      <?php } elseif ($data['status'] == 'Close to Won' || $data['status'] == 'Closed Won'){?>
                          <span class="badge bg-yellow-500"><?php echo $data['status'] ?></div></span>
            
                      <?php } elseif ($data['status'] == "Close to Lost" || $data['status'] == 'Closed Lost' || $data['status'] == "Omitted" || $data['status'] == 'Proposal-Omitted'){?>
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
                                    <a href="#!"><span class="h6 file-name-design"><?php echo $file['file_name']; ?></span></a>
                                    <small class="text-muted d-block">Size: <?php echo formatFileSize($file['file_size']); ?>| Created At:<?php  echo $file['created_at']; ?></small>
                                  </div>
                                </div>
                              </div>
                   
                              <?php
                                $filePath = FCPATH . 'uploads/deal_attachments/' . $file['file_name'];
                                $fileUrl  = base_url('uploads/deal_attachments/' . $file['file_name']);
                              ?>

                              <?php if (file_exists($file['file_path'])) : ?>
                                  <a href="<?= base_url($file['file_path']); ?>" download="<?= $file['file_name']; ?>">
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
                                    <a href="#!"><span class="h6 file-name-design"><?php echo $file['file_name']; ?></span></a>
                                    <small class="text-muted d-block">Size: <?php echo formatFileSize($file['file_size']); ?>| Created At:<?php  echo $file['created_at']; ?></small>
                                  </div>
                                </div>
                              </div>
                              <?php
                                $filePath = FCPATH . 'uploads/deal_attachments/' . $file['file_name'];
                                $fileUrl  = base_url('uploads/deal_attachments/' . $file['file_name']);
                              ?>

                              <?php if (file_exists($file['file_path'])) : ?>
                                  <a href="<?= base_url($file['file_path']); ?>" download="<?= $file['file_name']; ?>">
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
                                    <a href="#!"><span class="h6 file-name-design"><?php echo $file['file_name']; ?></span></a>
                                    <small class="text-muted d-block">Size: <?php echo formatFileSize($file['file_size']); ?>| Created At:<?php  echo $file['created_at']; ?></small>
                                  </div>
                                </div>
                              </div>
                               <?php
                                $filePath = FCPATH . 'uploads/deal_attachments/' . $file['file_name'];
                                $fileUrl  = base_url('uploads/deal_attachments/' . $file['file_name']);
                              ?>

                              <?php if (file_exists($file['file_path'])) : ?>
                                  <a href="<?= base_url($file['file_path']); ?>" download="<?= $file['file_name']; ?>">
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
                                    <a href="#!"><span class="h6 file-name-design"><?php echo $file['file_name']; ?></span></a>
                                    <small class="text-muted d-block">Size: <?php echo formatFileSize($file['file_size']); ?>| Created At:<?php  echo $file['created_at']; ?></small>
                                  </div>
                                </div>
                              </div>
                               <?php
                                $filePath = FCPATH . 'uploads/deal_attachments/' . $file['file_name'];
                                $fileUrl  = base_url('uploads/deal_attachments/' . $file['file_name']);
                              ?>

                              <?php if (file_exists($file['file_path'])) : ?>
                                  <a href="<?= base_url($file['file_path']); ?>" download="<?= $file['file_name']; ?>">
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
                                    <a href="#!"><span class="h6 file-name-design"><?php echo $file['file_name']; ?></span></a>
                                    <small class="text-muted d-block">Size: <?php echo formatFileSize($file['file_size']); ?>| Created At:<?php  echo $file['created_at']; ?></small>
                                  </div>
                                </div>
                              </div>
                               <?php
                                $filePath = FCPATH . 'uploads/deal_attachments/' . $file['file_name'];
                                $fileUrl  = base_url('uploads/deal_attachments/' . $file['file_name']);
                              ?>

                              <?php if (file_exists($file['file_path'])) : ?>
                                  <a href="<?= base_url($file['file_path']); ?>" download="<?= $file['file_name']; ?>">
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
          <!-- [ task-detail-left ] end -->
          <!-- [ task-detail-right ] start -->
          <div class="col-xxl-9 col-xl-8 col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Deal Name: <?php echo $data['deal_name']; ?></h5>
                    <div class="d-flex gap-2 ms-auto">
                        <?php if (!empty($data['quote_number'])): ?>
                        <a href="<?php echo base_url('index.php/Admincrm/download_deal_pdf/' . $data['id']); ?>">
                            <button class="btn btn-danger btn-sm">
                                <i class="ph ph-download me-1"></i>Download Quotation
                            </button>
                        </a>
                        <?php else: ?>
                        <div class="alert alert-dangers py-1 px-2 mb-0" role="alert">
                            No quotation available
                        </div>
                        <?php endif; ?>

                        <?php if($data['assigned_to'] == $this->session->userdata('admin_id')){?>

                        <button class="btn btn-warning btn-sm"  data-bs-toggle="modal" data-bs-target="#exampleModalLive">
                          <i class="ph ph-pen align-right m-r-5"></i>Update Status
                        </button>

                        <?php if (empty($data['quote_number'])): ?>
                        <a href="<?php echo base_url('index.php/Admincrm/create_quotation/' . $data['deal_number']); ?>">
                        <button class="btn btn-purple btn-sm">
                          <i class="ph ph-receipt align-right m-r-5"></i>Create Quotation
                        </button>
                        </a>
                        <?php endif; ?>

                        <?php if (!empty($data['quote_number'])): ?>
                        <a href="<?php echo base_url('index.php/Admincrm/edit_quotation/' . $data['id']); ?>">
                            <button class="btn btn-info btn-sm">
                                <i class="ph ph-pencil-simple me-1"></i>Edit Quotation
                            </button>
                        </a>
                        <?php endif; ?>



                        <?php } ?>
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
                                    <?php if (empty($notes_details['note_content'])){ ?>
                                      <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addLeadNoteModal">
                                        <i class="ph ph-note-pencil me-1"></i> Add Note
                                      </button>
                                    <?php } ?>

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

          <!-- [ task-detail-right ] end -->
<div class="modal fade" id="addLeadNoteModal" tabindex="-1" aria-labelledby="addLeadNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="<?= base_url('index.php/Admincrm/add_leads_notes_details'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLeadNoteModalLabel">Add Notes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- local lead/task id -->
                    <input type="hidden" name="id" value="<?= $data['id']; ?>">
                    <input type="hidden" name="zoho_crm_id" value="<?= $data['zoho_crm_id']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Note Title <span class="text-danger">*</span></label>
                        <input type="text" name="note_title" class="form-control" placeholder="Enter note title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Note Content <span class="text-danger">*</span></label>
                        <textarea name="note_content" class="form-control" rows="5" placeholder="Enter note details" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ph ph-floppy-disk me-1"></i> Save Note
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

        <!-- Modal Content -->
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
                        <form method="post" action="<?= base_url('index.php/Admincrm/update_status') ?>">

                        <input type="hidden" name="Task_ID" value="<?php echo $data['id'];   ?>">

                        <?php if($data['status'] == 'Pending' || $data['status'] == 'Qualification'){ ?>
                            <div class="mb-3">
                                <label class="form-label" for="exampleFormControlSelect1">Status <span style="color:red;">*</span></label>
                                <select class="form-select" id="exampleFormControlSelect1" name="status">

                                  <option value="">--Select--</option>
                                  <option value="Site Visit" <?php if($data['status'] == 'Site Visit'): echo 'selected'; endif;?>>Site Visit</option>
                                  <option value="Closed Lost" <?php if($data['status'] == 'Close to Lost' || $data['status'] == 'Closed Lost'): echo 'selected'; endif;?>>Omitted</option>
            
                                </select>
                                <input type="text" name="zoho_id" value="<?php echo $data['zoho_crm_id']; ?>" hidden=""/>
                             </div>

                             <?php } ?>

                             <?php if($data['status'] == 'Site Visit'){ ?>

<?php
    $hasQuotation = !empty($data['quote_number']); // adjust if needed
?>

<div class="mb-3">
    <label class="form-label">Status <span style="color:red;">*</span></label>

    <select class="form-select" name="status">
        <option value="">--Select--</option>

        <!-- Proposal (RESTRICTED) -->
        <option value="Proposal/Price Quote"
            <?php if($data['status'] == 'Proposal' || $data['status'] == 'Proposal/Price Quote') echo 'selected'; ?>
            <?php if(!$hasQuotation) echo 'disabled'; ?>>
            Proposal <?php if(!$hasQuotation) echo '(Create quotation first)'; ?>
        </option>

        <!-- Closed Lost (ALWAYS ALLOWED) -->
        <option value="Closed Lost"
            <?php if($data['status'] == 'Close to Lost' || $data['status'] == 'Closed Lost') echo 'selected'; ?>>
            Omitted
        </option>

    </select>

    <?php if(!$hasQuotation){ ?>
        <small style="color:#dc3545;">
            Please create a quotation first to select Proposal.
        </small>
    <?php } ?>

    <input type="hidden" name="zoho_id" value="<?php echo $data['zoho_crm_id']; ?>">
</div>

<?php } ?>

                             <?php if($data['status'] == 'Proposal' || $data['status'] == 'Proposal/Price Quote'){ ?>

                             <div class="mb-3">
                                <label class="form-label" for="exampleFormControlSelect1">Status <span style="color:red;">*</span></label>
                                <select class="form-select" id="exampleFormControlSelect1" name="status">
                                  
                                  <option value="">--Select--</option>
                                  <option value="Closed Won" <?php if($data['status'] == 'Close to Won' || $data['status'] == 'Closed Won'): echo 'selected'; endif;?>>Closed Won</option>
                                  <option value="Closed Lost" <?php if($data['status'] == 'Close to Lost' || $data['status'] == 'Closed Lost'): echo 'selected'; endif;?>>Omitted</option>
                                
                                </select>
                                <input type="text" name="zoho_id" value="<?php echo $data['zoho_crm_id']; ?>" hidden=""/>
                             </div>

                             <?php } ?>


                           
                            <div class="mb-3">
                              <div class="form-group" id="amountField" style="display: none;">
                                  <label class="form-label">Amount <span style="color:red;">*</span></label>
                                  <input type="number" class="form-control" name="service_charge" step="any" 
                                        value="<?php echo isset($data['service_charge']) ? $data['service_charge'] : ''; ?>" 
                                        placeholder="Enter amount">
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

        <!-- Modal Content -->
        <div
                  id="notesedit"
                  class="modal fade"
                  tabindex="-1"
                  role="dialog"
                  aria-labelledby="exampleModalLiveLabel"
                  aria-hidden="true"
                >
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLiveLabel">Edit Your Notes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                    <form method="POST" action="<?php echo base_url('index.php/Admincrm/update_leads_notes_details'); ?>">
                      <div class="modal-body">
                          <input type="hidden" name="notes_id" value="<?php echo $notes_details['id']; ?>">
                          <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                        <textarea class="form-control" 
                          name="note_content"
                          rows="4"
                          placeholder="Write your notes here..."><?= isset($notes_details['note_content']) ? $notes_details['note_content'] : ''; ?>
                        </textarea>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Save changes</button>
                      </div>
                        </form>
                    </div>
                  </div>
                </div>
   
            
        </div>
        <!-- [ Main Content ] end -->

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
document.addEventListener("DOMContentLoaded", function () {
    const statusDropdown = document.getElementById("exampleFormControlSelect1");
    const amountField = document.getElementById("amountField");

    function toggleAmountField() {
        if (statusDropdown.value === "Closed Won") {
            amountField.style.display = "block";
        } else {
            amountField.style.display = "none";
        }
    }

    // Run on page load (important for edit mode)
    toggleAmountField();

    // Run on change
    statusDropdown.addEventListener("change", toggleAmountField);
});
</script>
