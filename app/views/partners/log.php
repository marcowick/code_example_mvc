<?php if (!$this->check_acl('View Logs')){
    redirect('noaccess');}
?>

<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="app-body">

<?php require APPROOT . '/views/inc/navbar-side.php'; ?>

  <main class="main">
  
  <?php require APPROOT . '/views/inc/breadcrumbs.php'; ?>

    <div class="container-fluid">

    <div class="jumbotron">
    <h1 class="display-4"><?php echo _logs_heading; ?></h1>
    <p class="lead"><?php echo _logs_lead; ?></p>
    <hr class="my-4">
    <p><?php echo _logs_intro; ?></p>
    </div>

        <?php flash('log_message'); ?>

        <!-- Pagination -->
        <?php if($data['total_pages'] > 1): ?> 
            <nav aria-label="Page navigation">
            <ul class="pagination">

            <li class="page-item">
            <a class="page-link" href="<?php echo URLROOT; ?>/companies/viewlog/<?php echo $data['previous_link'] ; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
            </li>

            <?php for($i=1; $i <= $data['total_pages']; $i++): ?> 
                <li class="page-item <?php if ($data['current_page'] ==  $i) : ?>active<?php endif;?>"><a class="page-link" href="<?php echo URLROOT; ?>/companies/viewlog/<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor;?>

            <li class="page-item">
            <a class="page-link" href="<?php echo URLROOT; ?>/companies/viewlog/<?php echo $data['next_link'] ; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
            </li>
                    
                </ul>
            </nav>
        <?php endif;?>
        <!-- Pagination -->


        <div class="card">
        <div class="card-header"><?php echo _logs; ?>
        </div>

            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                    </div>

                    <div class="col-md-6">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col"><?php echo _user; ?></th>
                        <th scope="col"><?php echo _company; ?></th>
                        <th scope="col"><?php echo _message; ?></th>
                        <th scope="col"><?php echo _created; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <?php foreach($data['logs'] as $log) : ?>
                        <tr>
                            <th scope="row"><?php echo $log->log_id; ?></th>
                            <td>(<?php echo $log->user_id; ?>) <?php echo $log->firstname; ?> <?php echo $log->lastname; ?></td>
                            <td>(<?php echo $log->company_id; ?>) <?php echo $log->company; ?></td>
                            <td><?php echo $log->message; ?></td>
                            <td><?php echo $log->created; ?></td>
                            <td>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                    </tbody>
                    </table>
                </div>
            </div>

    </div>

        <!-- Pagination -->
        <?php if($data['total_pages'] > 1): ?> 
            <nav aria-label="Page navigation">
            <ul class="pagination">

            <li class="page-item">
            <a class="page-link" href="<?php echo URLROOT; ?>/companies/viewlog/<?php echo $data['previous_link'] ; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
            </li>

            <?php for($i=1; $i <= $data['total_pages']; $i++): ?> 
                <li class="page-item <?php if ($data['current_page'] ==  $i) : ?>active<?php endif;?>"><a class="page-link" href="<?php echo URLROOT; ?>/companies/viewlog/<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor;?>

            <li class="page-item">
            <a class="page-link" href="<?php echo URLROOT; ?>/companies/viewlog/<?php echo $data['next_link'] ; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
            </li>
                    
                </ul>
            </nav>
        <?php endif;?>
        <!-- Pagination -->


<?php require APPROOT . '/views/inc/footer.php'; ?>