<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       dcastalia.com
 * @since      1.0.0
 *
 * @package    Appointments_Shanta_Life_Style
 * @subpackage Appointments_Shanta_Life_Style/admin/partials
 */
?>

<?php
global $wpdb;
$tablename = $wpdb->prefix . 'appointments_slot';
$tablename_schedule = $wpdb->prefix . 'appointments_schedule';

if (isset($_POST['submit'])) {

    $start = $_POST['start_slot'];
    $end = $_POST['end_slot'];
    $ampm1 = $_POST['ampm1'];
    $ampm2 = $_POST['ampm2'];
//
//    $start_slot = $start . $ampm1;
//    $end_slot = $end . $ampm2;

    $appoint_time = $start . $ampm1 . '-' . $end . $ampm2;

    $full_time = array();
    $flag = false;

    if (current_user_can('manage_options')) {
        if (!empty($start) and !empty($end) and !empty($ampm1) and !empty($ampm2)) {
            $success = $wpdb->insert(
                $tablename,
                array(
                    'slot_time' => esc_attr($appoint_time),
                    'slot_start' => esc_attr($start . $ampm1),
                    'slot_end' => esc_attr($end . $ampm2),
                )
            );

            if ($success) {
            } else {
                $wpdb->print_error();
                echo "Not inserted";
            }
        } elseif (empty($start)) {
            echo "Please Select all Fields";
        }
    }
}

?>

<!-- Latest compiled and minified CSS -->
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<section class="appointments">
    <h3 class="title"><?= $this->plugin_name ?></h3>
    <div class="container-fluid">
        <!-- Content here -->
        <div class="row" style="display: flex;">
            <div class="col-md-6" style="width: 50%; float: left; padding-right: 15px;">
                <div class="card" style="margin-top: 0;margin-right: 0;width: 100%; border-radius: 3px;">
                    <div class="card-body">
                        <p class="current_api"><strong>Add New Appointment Time</strong></p>
                        <form action="<?php plugin_dir_path(__FILE__) . "/admin/partials/class-appointments_admin-content.php"; ?>"
                              method="post">

                            <div class="flex-column" style="display: flex;
    justify-content: space-between;">
                                <div class="form-group">
                                    <label for="slot_start" class="label"> Slot Start</label>
                                    <select name="start_slot" id="slot_start">
                                        <option selected="selected">0</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="ampm1" id="ampm1">
                                        <option>AM</option>
                                        <option selected="selected">PM</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="end_start" class="label"> Slot End</label>
                                    <select name="end_slot" id="end_start">
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option selected="selected">12</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="ampm2" id="ampm2">
                                        <option>AM</option>
                                        <option selected="selected">PM</option>
                                    </select>
                                </div>
                            </div>

                            <?php
                            submit_button('Add Appointment Time');
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="width: 50%; float: left; padding-left: 15px;">
                <div class="card" style="margin-top: 0;margin-right: 0;width: 100%; border-radius: 3px;">
                    <h3 class="Title">Appointment Time</h3>
                    <ul>
                        <?php
                        $user_nicenames = $wpdb->get_results("SELECT * FROM {$tablename} ", ARRAY_A);
                        if (!empty($user_nicenames)) {
                            foreach ($user_nicenames as $nicename) {
                        ?>
                                <li style="background: #e5e5e5; padding: 15px 15px; border-radius: 3px; margin-bottom: 10px;">
                                    <span><?= $nicename['slot_time'] ?></span>
                                    <button class="btn btn-sm btn-danger slot_delete" style="float: right;" data-id="<?= $nicename['id'] ?>" class="slot_delete">Delete</button>
                                </li>
                        <?php
                            }
                        } else {
                            echo "<li>No List Available Right Now</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 40px;">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Filter Data
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse <?= (isset($_GET['name'])) ? 'in' : ''; ?>" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">

                            <form method="get" action="<?php plugin_dir_path(__FILE__) . "/admin/partials/class-appointments_admin-content.php"; ?>">
                                <input type="hidden" name="page" value="appointment_admin_page"/>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Name" value="<?= !empty($_GET['name']) ? $_GET['name'] : '';?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="phone" class="form-control" placeholder="Phone" value="<?= !empty($_GET['phone']) ? $_GET['phone'] :''; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control" placeholder="Email Address" value="<?= !empty($_GET['email']) ? $_GET['email'] : ''; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="visit_type" class="form-control">
                                                <option value="">Select</option>
                                                <option value="online" <?= isset($_GET['visit_type']) && $_GET['visit_type'] == 'online' ? "selected" : ''; ?>>Online</option>
                                                <option value="physical" <?= isset($_GET['visit_type']) && $_GET['visit_type'] == 'physical' ? "selected" : ''; ?>>Physical</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="from_date" placeholder="From Date" class="datepicker form-control" value="<?= !empty($_GET['from_date']) ? date('d-m-Y', strtotime($_GET['from_date'])) : '';?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="to_date" placeholder="To Date" class="datepicker form-control" value="<?= !empty($_GET['to_date']) ? date('d-m-Y', strtotime($_GET['to_date'])) : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="status" class="form-control">
                                                <option value="">Select</option>
                                                <option value="2" <?= isset($_GET['status']) && $_GET['status'] == 2 ? "selected" : ''; ?>>Active</option>
                                                <option value="3" <?= isset($_GET['status']) && $_GET['status'] == 3 ? "selected" : ''; ?>>Close</option>
                                                <option value="4" <?= isset($_GET['status']) && $_GET['status'] == 4 ? "selected" : ''; ?>>Cancel</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="submit" class="form-control btn-primary" value="Search">
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <?php
                    $condition = '';
                    $c = 0;
                    if(!empty($_GET['name'])) {
                        $condition .= $c == 0 ? '' : 'AND';
                        $condition .= 'appoint_name LIKE "%'.$_GET['name'].'%" ';
                        $c++;
                    }
                    if(!empty($_GET['phone'])) {
                        $condition .= $c == 0 ? '' : ' AND ';
                        $condition .= 'appoint_phone LIKE "%'.$_GET['phone'].'%" ';
                        $c++;
                    }
                    if(!empty($_GET['email'])) {
                        $condition .= $c == 0 ? '' : ' AND ';
                        $condition .= 'apoint_email LIKE "%'.$_GET['email'].'%" ';
                    }
                    if(!empty($_GET['visit_type'])) {
                        $condition .= $c == 0 ? '' : ' AND ';
                        $condition .= 'appoint_visit_type LIKE "%'.$_GET['visit_type'].'%" ';
                        $c++;
                    }
                    if(!empty($_GET['from_date'])) {
                        $condition .= $c == 0 ? '' : ' AND ';
                        $condition .= 'appoint_date >= "'.date('Y-m-d', strtotime($_GET['from_date'])).'"';
                        $c++;
                    }
                    if(!empty($_GET['to_date'])) {
                        $condition .= $c == 0 ? '' : ' AND ';
                        $condition .= 'appoint_date <= "'.date('Y-m-d', strtotime($_GET['to_date'])).'"';
                        $c++;
                    }
                    if(!empty($_GET['status'])) {
                        $condition .= $c == 0 ? '' : ' AND ';
                        $condition .= 'appoint_status = '.$_GET['status'].'';
                        $c++;
                    }


                    $condition = !empty($condition) ? ' WHERE '. $condition : '';
                    $search_query = "SELECT * FROM  {$tablename_schedule} " . $condition;

                    // ------------------------ Pagination -------------------
                    $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
                    $limit = 10; // number of rows in page
                    $offset = ( $pagenum - 1 ) * $limit;
                    $data = $wpdb->get_results( $search_query);
                    $num_of_pages = ceil( count($data) / $limit );

                    $appointment_data = $wpdb->get_results($search_query . " ORDER BY id DESC LIMIT $offset, $limit ", ARRAY_A);

                    $page_links = paginate_links( array(
                        'base' => add_query_arg( 'pagenum', '%#%' ),
                        'format' => '',
                        'prev_text' => __( '«', 'text-domain' ),
                        'next_text' => __( '»', 'text-domain' ),
                        'total' => $num_of_pages,
                        'current' => $pagenum
                    ));
                ?>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4>Customer Schedule Information</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Customer Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Visit Type</th>
                                    <th>Slot</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php
                                if(!empty($appointment_data)) {
                            ?>
                                    <tbody>
                                    <?php
                                        $i = 1;
                                        foreach ($appointment_data as $key => $appoint_data){
                                    ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $appoint_data['appoint_name']; ?></td>
                                                <td><?= $appoint_data['appoint_phone']; ?></td>
                                                <td><?= $appoint_data['apoint_email']; ?></td>
                                                <td><?= $appoint_data['appoint_visit_type']; ?></td>
                                                <td><?= !empty($appoint_data['appoint_date']) ? date('d-m-Y',strtotime($appoint_data['appoint_date'])) : '-'; ?></td>
                                                <td><?= $appoint_data['appoint_slot_time']; ?></td>
                                                <td>
                                                    <?php
                                                        if($appoint_data['appoint_status'] == 2){
                                                            echo "Active";
                                                        }
                                                        else if($appoint_data['appoint_status'] == 3) {
                                                            echo "Close";
                                                        }
                                                        else if($appoint_data['appoint_status'] == 4) {
                                                            echo "Cancel";
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($appoint_data['appoint_status'] == 2) {
                                                    ?>
                                                            <button class="btn btn-sm btn-primary appoint_close" data-confirm="Are you sure ?" data-id="<?= $appoint_data ['id']; ?>">Close</button>
                                                            <button class="btn btn-sm btn-danger appoint_cancel" data-confirm="Are you sure ?" data-id="<?= $appoint_data ['id']; ?>">Cancel</button>
                                                    <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                    <?php
                                            $i++;
                                        }
                                    ?>
                                    </tbody>
                            <?php
                                }
                            ?>
                        </table>

                        <?php
                        if ( $page_links ) {
                            echo'<nav aria-label="Page navigation example">
                              <ul class="pagination">'.
                                $page_links
                              .'</ul>
                            </nav>';
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>

    </div>

</section>

<script>

</script>