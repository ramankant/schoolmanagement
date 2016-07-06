<?php
/*
  Plugin Name: School Management tracker
  Plugin URI: http://www.evoxyz.com
  Description: short code user for all bus [school_management_type_bus]. and short code user for all bus route [school_management_bus_route] and short code user for all bus route location  [school_management_route_location]
  Version: 1.0
  Author: Raman Kant Kamboj
  Author URI: http://google.co.in
 */
ob_start();
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>


<script>
    $(function () {
        $("#tabs").tabs();
    });
</script>
<?php
// UPDATE CASE
if (isset($_POST['update_allbus'])) {
    allbus_validation($_POST['vehicleno'], $_POST['routeid'], $_POST['evoreaderid'], $_POST['gps_url'], $_POST['get_title_name']);
    // sanitize user form input
    global $vehicleno, $routeid, $evoreaderid, $editid, $gps_url;
    $vehicleno = $_POST['vehicleno'];
    $routeid = $_POST['routeid'];
    $evoreaderid = $_POST['evoreaderid'];
    $editid = $_POST['edit_id'];
    $gps_url = $_POST['gps_url'];
    $get_titlename = $_POST['get_title_name'];
    // call @function complete_registration to create the user
    // only when no WP_error is found
    update_complete_allbus($vehicleno, $routeid, $evoreaderid, $editid, $gps_url);
    ?><script>
            window.location = "<?php echo site_url(); ?>/<?php echo $get_titlename; ?>";
    </script>
    <?php
}

if (isset($_POST['update_allbusroute'])) {
    allbusroute_validation(
            $_POST['vehicleid'], $_POST['route_num'], $_POST['activeslot'], $_POST['driverid'], $_POST['conductorid'], $_POST['teacherid'], $_POST['bus_stop_list_id'], $_POST['gidone'], $_POST['gidtwo'], $_POST['gidthree'], $_POST['get_title_name']);

    // sanitize user form input
    global $editid, $vehicleid, $route_num, $activeslot, $driverid, $conductorid, $teacherid, $bus_stop_list_id, $gidone, $gidtwo, $gidthree;
    $vehicleid = $_POST['vehicleid'];
    $route_num = $_POST['route_num'];
    $activeslot = $_POST['activeslot'];
    $driverid = $_POST['driverid'];
    $editid = $_POST['edit_id'];
    $conductorid = $_POST['conductorid'];
    $teacherid = $_POST['teacherid'];
    $bus_stop_list_id = $_POST['bus_stop_list_id'];
    $gidone = $_POST['gidone'];
    $gidtwo = $_POST['gidtwo'];
    $gidthree = $_POST['gidthree'];
    $get_titlename = $_POST['get_title_name'];

    // call @function complete_registration to create the user
    // only when no WP_error is found
    update_complete_allbusroute($editid, $vehicleid, $route_num, $activeslot, $driverid, $conductorid, $teacherid, $bus_stop_list_id, $gidone, $gidtwo, $gidthree);
    ?>
    <script>
        window.location = "<?php echo site_url(); ?>/<?php echo $get_titlename; ?>";
    </script>
    <?php
}

if (isset($_POST['update_allrouteloc'])) {
    allbus_validation(
            $_POST['busroute_id'], $_POST['route_lat'], $_POST['route_len'], $_POST['route_status']
    );

    // sanitize user form input
    global $editid, $busrouteid, $route_lat, $route_len, $route_status;
    $busrouteid = $_POST['busroute_id'];
    $route_lat = $_POST['route_lat'];
    $route_len = $_POST['route_len'];
    $route_status = $_POST['route_status'];
    $editid = $_POST['edit_id'];


    // call @function complete_registration to create the user
    // only when no WP_error is found
    update_complete_allrouteloc($editid, $busrouteid, $route_lat, $route_len, $route_status);
}

// DELETE CASE
if (isset($_GET['code'])) {
    if ($_GET['action'] == 'del' && $_GET['code'] == '1') {
        $del_id = $_GET['id'];
        global $del_id;
        $table_name = $wpdb->prefix . "evo_bus";
        $wpdb->delete($table_name, array('id' => $del_id), array('%d'));
    }
}


// DELETE CASE
if (isset($_GET['code'])) {
    if ($_GET['action'] == 'del' && $_GET['code'] == '2') {
        $del_id = $_GET['id'];
        global $del_id;
        $table_name = $wpdb->prefix . "evo_bus_routes";
        $wpdb->delete($table_name, array('id' => $del_id), array('%d'));
    }
}

// DELETE CASE
if (isset($_GET['code'])) {
    if ($_GET['action'] == 'del' && $_GET['code'] == '3') {
        $del_id = $_GET['id'];
        global $del_id;
        $table_name = $wpdb->prefix . "route_location";
        $wpdb->delete($table_name, array('id' => $del_id), array('%d'));
    }
}

// allbus show form
function allbus_form($vehicleno, $routeid, $evoreaderid, $gps_url) {
    ?>



    <style>
        div {
            margin-bottom:2px;
        }

        input{
            margin-bottom:4px;
        }
        label { width: 200px; float: left; margin: 0 20px 0 0; }
        span { display: block; margin: 0 0 3px; font-size: 1.2em; font-weight: bold; }
        input { width: 200px; border: 1px solid #000; padding: 5px; margin-bottom: 2px;}
        select { width: 200px; border: 1px solid #000; padding: 5px; }
        .form-group{float: left;}
    </style>


    <script type="text/javascript">
        $(function () {
            $('#txtNumeric').keyup(function () {
                if (this.value.match(/[^0-9]/g)) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                }
            });


            $('#txtNumerictwo').keyup(function () {
                if (this.value.match(/[^0-9]/g)) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                }
            });



            $('#txtAlphabet').keyup(function () {
                if (this.value.match(/[^a-zA-Z]/g)) {
                    this.value = this.value.replace(/[^a-zA-Z]/g, '');
                }
            });
            $('#txtAlphaNumeric').keyup(function () {
                if (this.value.match(/[^a-zA-Z0-9]/g)) {
                    this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
                }
            });
        });
        function textonly(e)
        {
            var code;
            if (!e)
                var e = window.event;
            if (e.keyCode)
                code = e.keyCode;
            else if (e.which)
                code = e.which;
            var character = String.fromCharCode(code);
    //alert('Character was ' + character);
    //alert(code);
    //if (code == 8) return true;
            var AllowRegex = /[^0-9]/g;
            if (AllowRegex.test(character))
                return true;
            return false;
        }

        function validate(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
            var regex = /[0-9]/;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault)
                    theEvent.preventDefault();
            }
        }
        /* for text only */


    </script>

    <a href="<?php echo site_url(); ?>/<?php echo get_the_title(); ?>" style="padding: 5px 10px; background-color: #cccccc; color: #327dbd; border-radius: 4px;">ALL Bus</a>
    <a href='<?php echo site_url(); ?>/<?php echo get_the_title(); ?>/?action=addnew&code=1' style="padding: 5px 10px; background-color: #cccccc; color: #327dbd; border-radius: 4px;">Add new</a>

    <?php
    if (!$_GET['action'] == 'edit' && !$_GET['code'] == '1') {
        $start = 0;
        $limit = 5;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $start = ($id - 1) * $limit;
        }
        global $wpdb;
        $table_name = $wpdb->prefix . "evo_bus";
        $allresultbus = $wpdb->get_results("SELECT * FROM  $table_name LIMIT $start, $limit");
        ?>
        <center><h2>All Bus Details</h2></center>
        <table>
            <th>ID</th>
            <th>Vehicle No.</th>
            <th>Route Id</th>
            <th>EvoReader Id</th>
            <th>Gps url </th>
            <th>Action</th>

            <?php foreach ($allresultbus as $busresult) { ?>
                <tr>
                    <td><?php echo $busresult->id; ?></td>
                    <td><?php echo $busresult->vehicleNo; ?></td>
                    <td><?php echo $busresult->routeId; ?></td>
                    <td><?php echo $busresult->evoReaderId; ?></td>
                    <td><?php echo $busresult->gps_url; ?></td>
                    <td>  <a href='<?php echo site_url(); ?>/<?php echo get_the_title(); ?>/?action=edit&code=1&id=<?php echo $busresult->id; ?>'><img src="<?php echo WP_PLUGIN_URL; ?>/schoolmanagement/image/edit-icon.png" alt="edit" height="26" width="26"> </a>
                        &nbsp;&nbsp;<a href='<?php echo site_url(); ?>/<?php echo get_the_title(); ?>/?action=del&code=1&id=<?php echo $busresult->id; ?>' onclick="return confirm('Do you want to delete this item')"><img src="<?php echo WP_PLUGIN_URL; ?>/schoolmanagement/image/remove.png" alt="edit" height="26" width="26"></a></td>
                </tr>
            <?php } ?>
        </table>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "evo_bus";
        $rows = $wpdb->get_row("SELECT count(id) as cid FROM  $table_name");
        $totalrows = $rows->cid;
        $total = ceil($totalrows / $limit);

        if ($id > 1) {
            echo "<a href='?id=" . ($id - 1) . "' class='button' style='padding: 5px 10px;background-color: #cccccc;color: #327dbd;border-radius: 4px;float: left;'>PREVIOUS</a>";
        }


        echo "<div class='page' >";
        for ($i = 1; $i <= $total; $i++) {
            if ($i == $id) {
                echo "<div class='current' style='float: left;margin-left: 10px;'>" . $i . "</div>";
            } else {
                echo "<div style='float: left;margin-left: 10px;'><a href='?id=" . $i . "'>" . $i . "</a></div>";
            }
        }
        echo "</div>";
        if ($id != $total) {
            echo "<a href='?id=" . ($id + 1) . "' class='button' style='padding: 5px 10px;background-color: #cccccc;color: #327dbd;border-radius: 4px; margin-left: 10px;'>NEXT</a>";
        }
        ?>

    <?php } ?>

    <br><?php
    if ($_GET['action'] == 'edit' && $_GET['code'] == '1') {
        $id = $_GET['id'];
        global $wpdb;
        $table_name = $wpdb->prefix . "evo_bus";
        $getallbus = $wpdb->get_row("SELECT * FROM  $table_name where id='$id'");
        ?>
        <div class="container">
            <form action="" class="form-horizontal" method="post" role="form">


                <div class="form-group">
                    <label for="vehicleno" class="control-label col-sm-2">VehicleNo <strong>*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" required name="vehicleno" class="form-control" value="<?php echo $getallbus->vehicleNo; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="routeid" class="control-label col-sm-2">RouteId<strong>*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" required name="routeid" onkeypress='validate(event)' class="form-control" value="<?php echo $getallbus->routeId; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="evoreaderid" class="control-label col-sm-2">EvoReaderId <strong>*</strong></label>
                    <div class="col-sm-4">
                        <input type="text"  required onkeypress='validate(event)' name="evoreaderid" class="form-control" value="<?php echo $getallbus->evoReaderId; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="gps_url" class="control-label col-sm-2">Gps_url <strong>*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" required name="gps_url" class="form-control" value="<?php echo $getallbus->gps_url; ?>">
                    </div>
                </div>


                <input type="hidden" name="edit_id" value="<?php echo $getallbus->id; ?>">
                <input type="hidden" name="get_title_name" value="<?php echo get_the_title(); ?>">
                <input type="submit" name="update_allbus" class="btn btn-default" value="Submit"/>
            </form>
        </div>
    <?php } else if ($_GET['action'] == 'addnew' && $_GET['code'] == '1') { ?>
        <div class="container">
            <form action="" class="form-horizontal" method="post" role="form">
                <div class="form-group">
                    <label for="vehicleno" class="control-label col-sm-2">VehicleNo <strong>*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" required  name="vehicleno" class="form-control" value="<?php echo( isset($_POST['vehicleno']) ? $vehicleno : null ); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="routeid" class="control-label col-sm-2">RouteId<strong>*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" required onkeypress='validate(event)' name="routeid" class="form-control" value="<?php echo( isset($_POST['routeid']) ? $routeid : null ); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="evoreaderid" class="control-label col-sm-2">EvoReaderId <strong>*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" required onkeypress='validate(event)' name="evoreaderid"  class="form-control" value="<?php echo( isset($_POST['evoreaderid']) ? $evoreaderid : null ); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="gps_url" class="control-label col-sm-2">Gps_url <strong>*</strong></label>
                    <div class="col-sm-4">
                        <input type="text" required name="gps_url"  class="form-control" value="<?php echo( isset($_POST['gps_url']) ? $gps_url : null ); ?>">
                    </div>
                </div>


                <input type="hidden" name="get_title_name" value="<?php echo get_the_title(); ?>">
                <input type="submit" name="submit_allbus" class="btn btn-default" value="Submit"/>
            </form>
        </div>
        <?php
    }
}

// allbus route show form
function allbusrotue_form($vehicleid, $route_num, $activeslot, $driverid, $conductorid, $teacherid, $bus_stop_list_id, $gidone, $gidtwo, $gidthree) {
    ?>

    <style>
        div {
            margin-bottom:2px;
        }

        input{
            margin-bottom:4px;
        }
        label { width: 200px; float: left; margin: 0 20px 0 0; }
        span { display: block; margin: 0 0 3px; font-size: 1.2em; font-weight: bold; }
        input { width: 200px; border: 1px solid #000; padding: 5px; margin-bottom: 2px;}
        select { width: 200px; border: 1px solid #000; padding: 5px; }
        .form-group{float: left;}
    </style>
    <script type="text/javascript">
        $(function () {
            $('#txtNumeric').keyup(function () {
                if (this.value.match(/[^0-9]/g)) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                }
            });


            $('#txtNumerictwo').keyup(function () {
                if (this.value.match(/[^0-9]/g)) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                }
            });



            $('#txtAlphabet').keyup(function () {
                if (this.value.match(/[^a-zA-Z]/g)) {
                    this.value = this.value.replace(/[^a-zA-Z]/g, '');
                }
            });
            $('#txtAlphaNumeric').keyup(function () {
                if (this.value.match(/[^a-zA-Z0-9]/g)) {
                    this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
                }
            });
        });
        function textonly(e)
        {
            var code;
            if (!e)
                var e = window.event;
            if (e.keyCode)
                code = e.keyCode;
            else if (e.which)
                code = e.which;
            var character = String.fromCharCode(code);
            //alert('Character was ' + character);
            //alert(code);
            //if (code == 8) return true;
            var AllowRegex = /[^0-9]/g;
            if (AllowRegex.test(character))
                return true;
            return false;
        }

        function validate(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
            var regex = /[0-9]/;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault)
                    theEvent.preventDefault();
            }
        }
        /* for text only */


    </script>
    <a href="<?php echo site_url(); ?>/<?php echo get_the_title(); ?>" style="padding: 5px 10px; background-color: #cccccc; color: #327dbd; border-radius: 4px;">ALL Bus Root</a>
    <a href='<?php echo site_url(); ?>/<?php echo get_the_title(); ?>/?action=addnew&code=2' style="padding: 5px 10px; background-color: #cccccc; color: #327dbd; border-radius: 4px;">Add Bus Root</a>

    <br>
    <br>
    <?php
    if ($_GET['action'] == 'edit' && $_GET['code'] == '2') {

        $id = $_GET['id'];
        global $wpdb;
        $table_name = $wpdb->prefix . "evo_bus_routes";
        $getallbus = $wpdb->get_row("SELECT * FROM  $table_name where id='$id'");
        $bus_id = $getallbus->bus_id;
        $vehicle_id = $getallbus->vehicleId;
        $driver_id = $getallbus->driverId;
        $conductor_id = $getallbus->conductorId;
        $teacher_id = $getallbus->teacherId;
        ?>

        <form action="" class="form-horizontal" method="post" role="form">

            <div class="form-group">

                <label for="vehicleid" class="control-label col-sm-2">vehicle select <strong>*</strong></label>
                <div class="col-sm-4">
                    <select name="vehicleid" >
                        <?php
                        global $wpdb;
                        $table_name = $wpdb->prefix . "evo_bus";
                        $vechicle = $wpdb->get_row("SELECT * FROM  $table_name where id='$vehicle_id'");
                        ?>
                        <option value="<?php echo $vechicle->id; ?>"><?php echo $vechicle->vehicleNo; ?></option>
                        <?php
                        global $wpdb;
                        $table_name = $wpdb->prefix . "evo_bus";
                        $allbus = $wpdb->get_results("SELECT * FROM  $table_name where id not in($vehicle_id)");
                        foreach ($allbus as $result) {
                            ?>
                            <option value="<?php echo $result->id; ?>"><?php echo $result->vehicleNo; ?></option>

                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="route_num" class="control-label col-sm-2">Route Num<strong>*</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="route_num" required onkeypress='validate(event)' value="<?php echo $getallbus->route_num; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="activeslot" class="control-label col-sm-2">ActiveSlot <strong>*</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="activeslot" required onkeypress='validate(event)' value="<?php echo $getallbus->activeSlot; ?>">
                </div>
            </div>

            <div class="form-group">

                <label for="driverid" class="control-label col-sm-2">Driver select <strong>*</strong></label>
                <div class="col-sm-4">
                    <select name="driverid">
                        <?php
                        global $wpdb;
                        $table_name = $wpdb->prefix . "users";
                        $getdriver = $wpdb->get_row("SELECT * FROM  $table_name where ID='$driver_id'");
                        ?>
                        <option value="<?php echo $getdriver->ID; ?>"><?php echo $getdriver->display_name; ?></option>
                        <?php
                        global $wpdb;
                        $role = $wpdb->get_results("SELECT user_id FROM wp_usermeta WHERE meta_key = 'wp_capabilities' and meta_value like '%driver%'");
                        $fresult = array();
                        foreach ($role as $ro) {
                            $fresult[] = $ro->user_id;
                        }
                        $con_str = implode(',', $fresult);


                        $table_name = $wpdb->prefix . "users";
                        $allbus = $wpdb->get_results("SELECT * FROM  $table_name where ID IN($con_str)");
                        foreach ($allbus as $result) {
                            ?>
                            <option value="<?php echo $result->ID; ?>"><?php echo $result->display_name; ?></option>

                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">

                <label for="conductorid" class="control-label col-sm-2">Conductor select <strong>*</strong></label>
                <div class="col-sm-4">
                    <select name="conductorid">
                        <?php
                        global $wpdb;
                        $table_name = $wpdb->prefix . "users";
                        $getconductor = $wpdb->get_row("SELECT * FROM  $table_name where ID='$conductor_id'");
                        ?>
                        <option value="<?php echo $getconductor->ID; ?>"><?php echo $getconductor->display_name; ?></option>
                        <?php
                        global $wpdb;
                        $role = $wpdb->get_results("SELECT user_id FROM wp_usermeta WHERE meta_key = 'wp_capabilities' and meta_value like '%conductor%'");
                        $fresult = array();
                        foreach ($role as $ro) {
                            $fresult[] = $ro->user_id;
                        }
                        $con_str = implode(',', $fresult);


                        $table_name = $wpdb->prefix . "users";
                        $allbus = $wpdb->get_results("SELECT * FROM  $table_name where ID IN($con_str)");
                        foreach ($allbus as $result) {
                            ?>
                            <option value="<?php echo $result->ID; ?>"><?php echo $result->display_name; ?></option>

                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">

                <label for="teacherid" class="control-label col-sm-2">Teacher select <strong>*</strong></label>
                <div class="col-sm-4">
                    <select name="teacherid">

                        <?php
                        global $wpdb;
                        $table_name = $wpdb->prefix . "users";
                        $getteacher = $wpdb->get_row("SELECT * FROM  $table_name where ID='$teacher_id'");
                        ?>
                        <option value="<?php echo $getteacher->ID; ?>"><?php echo $getteacher->display_name; ?></option>
                        <?php
                        global $wpdb;
                        $role = $wpdb->get_results("SELECT user_id FROM wp_usermeta WHERE meta_key = 'wp_capabilities' and meta_value like '%teacher%'");
                        $fresult = array();
                        foreach ($role as $ro) {
                            $fresult[] = $ro->user_id;
                        }
                        $con_str = implode(',', $fresult);


                        $table_name = $wpdb->prefix . "users";
                        $allbus = $wpdb->get_results("SELECT * FROM  $table_name where ID IN($con_str)");
                        foreach ($allbus as $result) {
                            ?>
                            <option value="<?php echo $result->ID; ?>"><?php echo $result->display_name; ?></option>

                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="bus_stop_list_id" class="control-label col-sm-2">Bus Stop List id <strong>*</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="bus_stop_list_id" required onkeypress='validate(event)' value="<?php echo $getallbus->bus_stop_list_id; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="gidone" class="control-label col-sm-2">Gid1 <strong>*</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="gidone" required onkeypress='validate(event)' value="<?php echo $getallbus->gid1; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="gidtwo" class="control-label col-sm-2">Gid2 <strong>*</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="gidtwo" required onkeypress='validate(event)' value="<?php echo $getallbus->gid2; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="gidthree" class="control-label col-sm-2">Gid3 <strong>*</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="gidthree" required onkeypress='validate(event)' value="<?php echo $getallbus->gid3; ?>">
                </div>
            </div>
            <input type="hidden" name="edit_id" value="<?php echo $getallbus->id; ?>">
            <input type="hidden" name="get_title_name" value="<?php echo get_the_title(); ?>">
            <input type="submit" name="update_allbusroute" class="btn btn-default" value="Submit"/>
        </form>
    <?php } else if ($_GET['action'] == 'addnew' && $_GET['code'] == '2') { ?>
        <form action="" class="form-horizontal" method="post" role="form">
            <div class="form-group">

                <label for="vehicleid" class="control-label col-sm-2">Vehicle select  <strong>*</strong></label>
                <div class="col-sm-4">
                    <select name="vehicleid" required>
                        <option value="">select vehicleid</option>
                        <?php
                        global $wpdb;
                        $table_name = $wpdb->prefix . "evo_bus";
                        $allbus = $wpdb->get_results("SELECT * FROM  $table_name");
                        foreach ($allbus as $result) {
                            ?>
                            <option value="<?php echo $result->id; ?>"><?php echo $result->vehicleNo; ?></option>

                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="route_num" class="control-label col-sm-2">Route Num<strong>*</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="route_num" required onkeypress='validate(event)' value="<?php echo( isset($_POST['route_num']) ? $route_num : null ); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="activeslot" class="control-label col-sm-2">ActiveSlot <strong>*</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="activeslot" required onkeypress='validate(event)' value="<?php echo( isset($_POST['activeslot']) ? $activeslot : null ); ?>">
                </div>
            </div>
            <?php ?>
            <div class="form-group">

                <label for="driverid" class="control-label col-sm-2">Driver Name <strong>*</strong></label>
                <div class="col-sm-4">
                    <select name="driverid" required>
                        <option value="">Select Driver</option>
                        <?php
                        global $wpdb;
                        $role = $wpdb->get_results("SELECT user_id FROM wp_usermeta WHERE meta_key = 'wp_capabilities' and meta_value like '%driver%'");
                        $fresult = array();
                        foreach ($role as $ro) {
                            $fresult[] = $ro->user_id;
                        }
                        $con_str = implode(',', $fresult);


                        $table_name = $wpdb->prefix . "users";
                        $allbus = $wpdb->get_results("SELECT * FROM  $table_name where ID IN($con_str)");
                        foreach ($allbus as $result) {
                            ?>

                            <option value="<?php echo $result->ID; ?>"><?php echo $result->display_name; ?></option>

                        <?php } ?>
                        <option value="0">Other</option>
                    </select>
                </div>
            </div>

            <div class="form-group">

                <label for="conductorid" class="control-label col-sm-2">Conductor Name <strong>*</strong></label>
                <div class="col-sm-4">
                    <select name="conductorid" required>
                        <option value="">Select Conductor</option>
                        <?php
                        global $wpdb;
                        $role = $wpdb->get_results("SELECT user_id FROM wp_usermeta WHERE meta_key = 'wp_capabilities' and meta_value like '%conductor%'");
                        $fresult = array();
                        foreach ($role as $ro) {
                            $fresult[] = $ro->user_id;
                        }
                        $con_str = implode(',', $fresult);


                        $table_name = $wpdb->prefix . "users";
                        $allbus = $wpdb->get_results("SELECT * FROM  $table_name where ID IN($con_str)");
                        foreach ($allbus as $result) {
                            ?>

                            <option value="<?php echo $result->ID; ?>"><?php echo $result->display_name; ?></option>

                        <?php } ?>
                        <option value="0">Other</option>
                    </select>
                </div>
            </div>

            <div class="form-group">

                <label for="teacherid" class="control-label col-sm-2">Teacher Name <strong>*</strong></label>
                <div class="col-sm-4">
                    <select name="teacherid" required>
                        <option value="">Select Teacher</option>
                        <?php
                        global $wpdb;
                        $role = $wpdb->get_results("SELECT user_id FROM wp_usermeta WHERE meta_key = 'wp_capabilities' and meta_value like '%teacher%'");
                        $fresult = array();
                        foreach ($role as $ro) {
                            $fresult[] = $ro->user_id;
                        }
                        $con_str = implode(',', $fresult);


                        $table_name = $wpdb->prefix . "users";
                        $allbus = $wpdb->get_results("SELECT * FROM  $table_name where ID IN($con_str)");
                        foreach ($allbus as $result) {
                            ?>

                            <option value="<?php echo $result->ID; ?>"><?php echo $result->display_name; ?></option>

                        <?php } ?>
                        <option value="0">Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="bus_stop_list_id" class="control-label col-sm-2">Bus Stop list id <strong>*</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="bus_stop_list_id" required onkeypress='validate(event)' value="<?php echo( isset($_POST['bus_stop_list_id']) ? $bus_stop_list_id : null ); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="gidone" class="control-label col-sm-2">Gid1 <strong>*</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="gidone" required onkeypress='validate(event)' value="<?php echo( isset($_POST['gidone']) ? $gidone : null ); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="gidtwo" class="control-label col-sm-2">Gid2 <strong>*</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="gidtwo" required onkeypress='validate(event)' value="<?php echo $getallbus->gid2; ?><?php echo( isset($_POST['gidtwo']) ? $gidtwo : null ); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="gidthree" class="control-label col-sm-2">Gid3 <strong>*</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="gidthree" required onkeypress='validate(event)' value="<?php echo $getallbus->gid3; ?><?php echo( isset($_POST['gidthree']) ? $gidthree : null ); ?>">
                </div>
            </div>
            <input type="hidden" name="get_title_name" value="<?php echo get_the_title(); ?>">
            <input type="submit" name="submit_allbusroute" class="btn btn-primary" value="Submit"/>
        </form>
        <?php
    }

    if (!$_GET['action'] == 'edit' && !$_GET['code'] == '2') {
        $start = 0;
        $limit = 5;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $start = ($id - 1) * $limit;
        }
        global $wpdb;
        $table_name = $wpdb->prefix . "evo_bus_routes";
        $allbusroute = $wpdb->get_results("SELECT * FROM  $table_name LIMIT $start, $limit");
        ?>
        <center><h2>Bus Route Details</h2></center>
        <table>
            <th>Id</th>
            <th>VehicleNo</th>
            <th>Route No</th>
            <th>activeSlot</th>
            <th>Driver</th>
            <th>Conductor</th>
            <th>Teacher</th>
            <th>Bus Stop</th>
            <th>Gid1</th>
            <th>Gid2</th>
            <th>Gid3</th>
            <th>Action</th>
            <?php
            foreach ($allbusroute as $busroute) {
                $vehleid = $busroute->vehicleId;
                $driverId = $busroute->driverId;
                $teacherId = $busroute->teacherId;
                $conductorId = $busroute->conductorId;
                $table_name = $wpdb->prefix . "evo_bus";
                $getname = $wpdb->get_row("SELECT vehicleNo FROM  $table_name where id='$vehleid'");
                $table_name = $wpdb->prefix . "users";
                $getname_driver = $wpdb->get_row("SELECT display_name FROM  $table_name where id='$driverId'");

                $getname_conductor = $wpdb->get_row("SELECT display_name FROM  $table_name where id='$conductorId'");

                $getname_teacher = $wpdb->get_row("SELECT display_name FROM  $table_name where id='$teacherId'");
                ?>
                <tr>
                    <td><?php echo $busroute->id; ?></td>
                    <td><?php echo $getname->vehicleNo; ?></td>
                    <td><?php echo $busroute->route_num; ?></td>
                    <td><?php echo $busroute->activeSlot; ?></td>
                    <td><?php echo $getname_driver->display_name; ?></td>
                    <td><?php echo $getname_conductor->display_name; ?></td>
                    <td><?php echo $getname_teacher->display_name; ?></td>
                    <td><?php echo $busroute->bus_stop_list_id; ?></td>
                    <td><?php echo $busroute->gid1; ?></td>
                    <td><?php echo $busroute->gid2; ?></td>
                    <td><?php echo $busroute->gid3; ?></td>
                    <td>  <a href='<?php echo site_url(); ?>/<?php echo get_the_title(); ?>/?action=edit&code=2&id=<?php echo $busroute->id; ?>'><img src="<?php echo WP_PLUGIN_URL; ?>/schoolmanagement/image/edit-icon.png" alt="edit" height="26" width="26"></a>
                        &nbsp;&nbsp;<a href='<?php echo site_url(); ?>/<?php echo get_the_title(); ?>/?action=del&code=2&id=<?php echo $busroute->id; ?>' onclick="return confirm('Do you want to delete this item')"><img src="<?php echo WP_PLUGIN_URL; ?>/schoolmanagement/image/remove.png" alt="edit" height="26" width="26"></a></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "evo_bus_routes";
        $rows = $wpdb->get_row("SELECT count(id) as cid FROM  $table_name");
        $totalrows = $rows->cid;
        $total = ceil($totalrows / $limit);

        if ($id > 1) {
            echo "<a href='?id=" . ($id - 1) . "' class='button' style='padding: 5px 10px;background-color: #cccccc;color: #327dbd;border-radius: 4px;float: left;'>PREVIOUS</a>";
        }


        echo "<div class='page' >";
        for ($i = 1; $i <= $total; $i++) {
            if ($i == $id) {
                echo "<div class='current' style='float: left;margin-left: 10px;'>" . $i . "</div>";
            } else {
                echo "<div style='float: left;margin-left: 10px;'><a href='?id=" . $i . "'>" . $i . "</a></div>";
            }
        }
        echo "</div>";
        if ($id != $total) {
            echo "<a href='?id=" . ($id + 1) . "' class='button' style='padding: 5px 10px;background-color: #cccccc;color: #327dbd;border-radius: 4px; margin-left: 10px;'>NEXT</a>";
        }
        ?>

        <?php
    }
}

// allbus show form
function allrouteloc_form($busrouteid, $route_lat, $route_len, $route_status) {
    ?>

    <style>
        div {
            margin-bottom:2px;
        }

        input{
            margin-bottom:4px;
        }
    </style>

    <a href="<?php echo site_url(); ?>/<?php echo get_the_title(); ?>">Bus Route Loc.</a>
    <a href='<?php echo site_url(); ?>/<?php echo get_the_title(); ?>/?action=addnew&code=3'>ADD Bus Route Loc.</a>

    <br><?php
    if ($_GET['action'] == 'edit' && $_GET['code'] == '3') {
        $id = $_GET['id'];
        global $wpdb;
        $table_name = $wpdb->prefix . "route_location";
        $getallbus = $wpdb->get_row("SELECT * FROM  $table_name where id='$id'");
        $bus_id = $getallbus->bus_route_id;
        ?>

        <form action="" method="post">

            <div>

                <label for="bus_name">Route Select<strong>*</strong></label>

                <select name="busroute_id">
                    <?php
                    global $wpdb;
                    $table_name = $wpdb->prefix . "evo_bus_routes";
                    $allbus = $wpdb->get_results("SELECT * FROM  $table_name");
                    foreach ($allbus as $result) {
                        ?>
                        <option value="<?php echo $result->id; ?>"><?php echo $result->route_name; ?></option>

                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="route_lat">Route latitude<strong>*</strong></label>
                <input type="text" name="route_lat" value="<?php echo $getallbus->lat; ?>">
            </div>
            <div>
                <label for="route_len">Route longitude <strong>*</strong></label>
                <input type="text" name="route_len" value="<?php echo $getallbus->len; ?>">
            </div>

            <div>
                <label for="route_destination">Route Status <strong>*</strong></label>


                <select name="route_status">

                    <option value="1">1</option>
                    <option value="0">0</option>
                </select>
            </div>

            <input type="hidden" name="edit_id" value="<?php echo $getallbus->id; ?>">
            <input type="submit" name="update_allrouteloc" value="Submit"/>
        </form>
    <?php } else if ($_GET['action'] == 'addnew' && $_GET['code'] == '3') { ?>
        <form action="" method="post">
            <div>

                <label for="bus_name">Bus Name <strong>*</strong></label>

                <select name="busroute_id">
                    <?php
                    global $wpdb;
                    $table_name = $wpdb->prefix . "evo_bus_routes";
                    $allbus = $wpdb->get_results("SELECT * FROM  $table_name");
                    foreach ($allbus as $result) {
                        ?>
                        <option value="<?php echo $result->id; ?>"><?php echo $result->route_name; ?></option>

                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="route_lat">Route latitude<strong>*</strong></label>
                <input type="text" name="route_lat" value="">
            </div>
            <div>
                <label for="route_len">Route longitude <strong>*</strong></label>
                <input type="text" name="route_len" value="">
            </div>

            <div>
                <label for="route_destination">Route Status <strong>*</strong></label>


                <select name="route_status">

                    <option value="1">1</option>
                    <option value="0">0</option>
                </select>
            </div>
            <input type="submit" name="submit_allrouteloc" value="Submit"/>
        </form>
        <?php
    }

    if (!$_GET['action'] == 'edit' && !$_GET['code'] == '3') {
        global $wpdb;
        $allroutelocation = $wpdb->get_results("SELECT * FROM  wp_route_location");
        ?>
        <center><h2>Bus Route Location</h2></center>
        <table>
            <th>ID</th>
            <th>Bus Route ID</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Status</th>
            <th>Action</th>
            <?php
            foreach ($allroutelocation as $routeloc) {
                ?>
                <tr>
                    <td><?php echo $routeloc->id; ?></td>
                    <td><?php echo $routeloc->bus_route_id; ?></td>
                    <td><?php echo $routeloc->lat; ?></td>
                    <td><?php echo $routeloc->len; ?></td>
                    <td><?php echo $routeloc->status; ?></td>
                    <td>  <a href='<?php echo site_url(); ?>/<?php echo get_the_title(); ?>/?action=edit&code=3&id=<?php echo $routeloc->id; ?>'><img src="<?php echo WP_PLUGIN_URL; ?>/schoolmanagement/image/edit-icon.png" alt="edit" height="26" width="26"></a>
                        &nbsp;&nbsp;<a href='<?php echo site_url(); ?>/<?php echo get_the_title(); ?>/?action=del&code=3&id=<?php echo $routeloc->id; ?>' onclick="return confirm('Do you want to delete this item')"><img src="<?php echo WP_PLUGIN_URL; ?>/schoolmanagement/image/remove.png" alt="edit" height="26" width="26"></a></td>

                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }
}

function allbus_validation($vehicleno, $routeid, $evoreaderid, $gps_url) {
    global $reg_errors;
    $reg_errors = new WP_Error;

    if (empty($vehicleno)) {
        $reg_errors->add('field', 'Required form field is missing');
    }

    if (is_wp_error($reg_errors)) {

        foreach ($reg_errors->get_error_messages() as $error) {

            echo '<div>';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';
            echo '</div>';
        }
    }
}

function allbusroute_validation($vehicleid, $route_num, $activeslot, $driverid, $conductorid, $teacherid, $bus_stop_list_id, $gidone, $gidtwo, $gidthree) {
    global $reg_errors;
    $reg_errors = new WP_Error;

    if (empty($vehicleid)) {
        $reg_errors->add('field', 'Required form field is missing');
    }

    if (empty($route_num)) {
        $reg_errors->add('field', 'Required form field is missing');
    }
    if (empty($driverid)) {
        $reg_errors->add('field', 'Required form field is missing');
    }

    if (empty($conductorid)) {
        $reg_errors->add('field', 'Required form field is missing');
    }

    if (empty($teacherid)) {
        $reg_errors->add('field', 'Required form field is missing');
    }

    if (is_wp_error($reg_errors)) {

        foreach ($reg_errors->get_error_messages() as $error) {

            echo '<div>';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';
            echo '</div>';
        }
    }
}

function allrouteloc_validation($routelat) {
    global $reg_errors;
    $reg_errors = new WP_Error;

    if (empty($routelat)) {
        $reg_errors->add('field', 'Required form field is missing');
    }

    if (is_wp_error($reg_errors)) {

        foreach ($reg_errors->get_error_messages() as $error) {

            echo '<div>';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';
            echo '</div>';
        }
    }
}

function plugin_allbus_activation() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;
    $db_table_name = $wpdb->prefix . 'evo_bus';
    if ($wpdb->get_var("SHOW TABLES LIKE '$db_table_name'") != $db_table_name) {
        if (!empty($wpdb->charset))
            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if (!empty($wpdb->collate))
            $charset_collate .= " COLLATE $wpdb->collate";

        $sql = "CREATE TABLE " . $db_table_name . " (
			`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			`vehicleNo` varchar(255),
			`routeId` int(20),
			`evoReaderId` int(20),
			`gps_url` varchar(255),
			PRIMARY KEY (`id`)
		) $charset_collate;";
        dbDelta($sql);
    }
}

register_activation_hook(__FILE__, 'plugin_allbus_activation');

function plugin_allbus_route_activation() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;
    $db_table_name = $wpdb->prefix . 'evo_bus_routes';
    if ($wpdb->get_var("SHOW TABLES LIKE '$db_table_name'") != $db_table_name) {
        if (!empty($wpdb->charset))
            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if (!empty($wpdb->collate))
            $charset_collate .= " COLLATE $wpdb->collate";

        $sql = "CREATE TABLE " . $db_table_name . " (
			`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			`route_num` int(20),
			`vehicleId` int(20),
			`activeSlot` ENUM('0', '1', '2', '3'),
			`driverId` int(20),
			`conductorId` int(20),
			`teacherId` int(20),
			`bus_stop_list_id` int(20),
			`gid1` int(20),
			`gid2` int(20),
		    `gid3` int(20),
			PRIMARY KEY (`id`)
		) $charset_collate;";
        dbDelta($sql);
    }
}

register_activation_hook(__FILE__, 'plugin_allbus_route_activation');

function plugin_route_location_activation() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb;
    $db_table_name = $wpdb->prefix . 'route_location';
    if ($wpdb->get_var("SHOW TABLES LIKE '$db_table_name'") != $db_table_name) {
        if (!empty($wpdb->charset))
            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if (!empty($wpdb->collate))
            $charset_collate .= " COLLATE $wpdb->collate";

        $sql = "CREATE TABLE " . $db_table_name . " (
		`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			`bus_route_id` varchar(100),
			`lat` varchar(100),
			`len` varchar(100),
			`status` int(11),
			`creation_date` DATETIME,
			PRIMARY KEY (`id`)
		) $charset_collate;";
        dbDelta($sql);
    }
}

register_activation_hook(__FILE__, 'plugin_route_location_activation');

function complete_allbus() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb, $reg_errors, $vehicleno, $routeid, $evoreaderid, $gps_url, $get_site_name;
    if (1 > count($reg_errors->get_error_messages())) {
        $userdata = array(
            'vehicleNo' => $vehicleno,
            'routeId' => $routeid,
            'evoReaderId' => $evoreaderid,
            'gps_url' => $gps_url,
        );

        global $wpdb;
        $table_name = $wpdb->prefix . "evo_bus";
        $getbusdetials = $wpdb->get_row("SELECT * FROM  $table_name where vehicleNo='$vehicleno'");
        $vechicle_id = $getbusdetials->vehicleNo;
        if ($vechicle_id != $vehicleno) {

            $table_name = $wpdb->prefix . "evo_bus";
            $wpdb->insert($table_name, $userdata);
            ?>
            <script>
                window.location = "<?php echo site_url(); ?>/<?php echo $get_site_name; ?>";
            </script>
            <?php
        } else {
            echo 'vechicle NO already exit';
        }
    }
}

function complete_allbusroute() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb, $reg_errors, $vehicleid, $route_num, $activeslot, $driverid, $conductorid, $teacherid, $bus_stop_list_id, $gidone, $gidtwo, $gidthree, $get_titlename;
    if (1 > count($reg_errors->get_error_messages())) {
        $userdata = array(
            'vehicleId' => $vehicleid,
            'route_num' => $route_num,
            'activeSlot' => $activeslot,
            'driverId' => $driverid,
            'conductorId' => $conductorid,
            'teacherId' => $teacherid,
            'bus_stop_list_id' => $bus_stop_list_id,
            'gid1' => $gidone,
            'gid2' => $gidtwo,
            'gid3' => $gidthree,
        );
        global $wpdb;
        $table_name = $wpdb->prefix . "evo_bus_routes";
        $getbusdetials = $wpdb->get_row("SELECT * FROM  $table_name where route_num='$route_num'");
        $route_num_chk = $getbusdetials->route_num;

        if ($route_num_chk != $route_num) {
            $table_name = $wpdb->prefix . "evo_bus_routes";
            $wpdb->insert($table_name, $userdata);
            ?>
            <script>
                window.location = "<?php echo site_url(); ?>/<?php echo $get_titlename; ?>";
            </script>

            <?php
        } else {
            echo 'Route num already exit';
        }
        //$insert_sql ="
        //INSERT INTO wp_my_register(name,password,email,website,firstname,lastname,nikename,description) VALUES ('$username','$password','$email','$website','$first_name','$last_name','$nickname','$bio')";
        // dbDelta($insert_sql);
    }
}

function complete_allrouteloc() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb, $reg_errors, $busrouteid, $route_lat, $route_len, $route_status;
    if (1 > count($reg_errors->get_error_messages())) {
        $userdata = array(
            'bus_route_id' => $busrouteid,
            'lat' => $route_lat,
            'len' => $route_len,
            'status' => $route_status,
        );
        $table_name = $wpdb->prefix . "route_location";
        $wpdb->insert($table_name, $userdata);
    }
}

function update_complete_allbus() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb, $reg_errors, $vehicleno, $routeid, $evoreaderid, $editid, $gps_url;
    if (1 > count($reg_errors->get_error_messages())) {
        $userdata = array(
            'vehicleNo' => $vehicleno,
            'routeId' => $routeid,
            'evoReaderId' => $evoreaderid,
            'gps_url' => $gps_url,
        );
        $table_name = $wpdb->prefix . "evo_bus";

        $wpdb->update(
                $table_name, //table
                array('vehicleNo' => $vehicleno, 'routeId' => $routeid, 'evoReaderId' => $evoreaderid, 'gps_url' => $gps_url), //data
                array('id' => $editid), //where
                array('%s'), //data format
                array('%d') //where format
        );
    }
}

function update_complete_allbusroute() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb, $reg_errors, $editid, $vehicleid, $route_num, $activeslot, $driverid, $conductorid, $teacherid, $bus_stop_list_id, $gidone, $gidtwo, $gidthree;
    if (1 > count($reg_errors->get_error_messages())) {
        $userdata = array(
            'vehicleId' => $vehicleid,
            'route_num' => $route_num,
            'activeSlot' => $activeslot,
            'driverId' => $driverid,
            'conductorId' => $conductorid,
            'teacherId' => $teacherid,
            'bus_stop_list_id' => $bus_stop_list_id,
            'gid1' => $gidone,
            'gid2' => $gidtwo,
            'gid3' => $gidthree,
        );
        $table_name = $wpdb->prefix . "evo_bus_routes";

        $wpdb->update(
                $table_name, //table
                array('vehicleId' => $vehicleid, 'route_num' => $route_num, 'activeSlot' => $activeslot, 'driverId' => $driverid, 'conductorId' => $conductorid, 'teacherId' => $teacherid, 'bus_stop_list_id' => $bus_stop_list_id, 'gid1' => $gidone, 'gid2' => $gidtwo, 'gid3' => $gidthree), //data
                array('id' => $editid), //where
                array('%s'), //data format
                array('%d') //where format
        );
    }
}

function update_complete_allrouteloc() {
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    global $wpdb, $reg_errors, $editid, $busrouteid, $route_lat, $route_len, $route_status;
    if (1 > count($reg_errors->get_error_messages())) {
        $userdata = array(
            'bus_route_id' => $busrouteid,
            'lat' => $route_lat,
            'len' => $route_source,
            'status' => $route_len,
            'route_description' => $route_status,
        );
        $table_name = $wpdb->prefix . "route_location";

        $wpdb->update(
                $table_name, //table
                array('bus_route_id' => $busrouteid, 'lat' => $route_lat, 'len' => $route_len, 'status' => $route_status), //data
                array('id' => $editid), //where
                array('%s'), //data format
                array('%d') //where format
        );
    }
}

function custom_allbus_function() {
    if (isset($_POST['submit_allbus'])) {
        allbus_validation(
                $_POST['vehicleno'], $_POST['routeid'], $_POST['evoreaderid'], $_POST['gps_url'], $_POST['get_title_name']);

        // sanitize user form input
        global $vehicleno, $routeid, $evoreaderid, $gps_url, $get_site_name;
        $vehicleno = $_POST['vehicleno'];
        $routeid = $_POST['routeid'];
        $evoreaderid = $_POST['evoreaderid'];
        $gps_url = $_POST['gps_url'];
        $get_site_name = $_POST['get_title_name'];

        // call @function complete_schoolmanagement to create the user
        // only when no WP_error is found
        complete_allbus($vehicleno, $routeid, $evoreaderid, $gps_url, $get_site_name);
    }
    global $vehicleno, $routeid, $evoreaderid, $gps_url;
    allbus_form($vehicleno, $routeid, $evoreaderid, $gps_url);
}

function custom_allbusroute_function() {
    if (isset($_POST['submit_allbusroute'])) {
        allbusroute_validation(
                $_POST['vehicleid'], $_POST['route_num'], $_POST['activeslot'], $_POST['driverid'], $_POST['conductorid'], $_POST['teacherid'], $_POST['bus_stop_list_id'], $_POST['gidone'], $_POST['gidtwo'], $_POST['gidthree'], $_POST['get_title_name']);

        // sanitize user form input
        global $vehicleid, $route_num, $activeslot, $driverid, $conductorid, $teacherid, $bus_stop_list_id, $gidone, $gidtwo, $gidthree, $get_titlename;
        $vehicleid = $_POST['vehicleid'];
        $route_num = $_POST['route_num'];
        $activeslot = $_POST['activeslot'];
        $driverid = $_POST['driverid'];
        $conductorid = $_POST['conductorid'];
        $teacherid = $_POST['teacherid'];
        $bus_stop_list_id = $_POST['bus_stop_list_id'];
        $gidone = $_POST['gidone'];
        $gidtwo = $_POST['gidtwo'];
        $gidthree = $_POST['gidthree'];
        $get_titlename = $_POST['get_title_name'];

        // call @function complete_schoolmanagement to create the user
        // only when no WP_error is found
        complete_allbusroute($vehicleid, $route_num, $activeslot, $driverid, $conductorid, $teacherid, $bus_stop_list_id, $gidone, $gidtwo, $gidthree, $get_titlename);
    }
    global $vehicleid, $route_num, $activeslot, $driverid, $conductorid, $teacherid, $bus_stop_list_id, $gidone, $gidtwo, $gidthree;
    allbusrotue_form($vehicleid, $route_num, $activeslot, $driverid, $conductorid, $teacherid, $bus_stop_list_id, $gidone, $gidtwo, $gidthree);
}

function custom_allrouteloc_function() {
    if (isset($_POST['submit_allrouteloc'])) {
        allrouteloc_validation(
                $_POST['busroute_id'], $_POST['route_lat'], $_POST['route_len'], $_POST['route_status']
        );

        // sanitize user form input
        global $busrouteid, $route_lat, $route_len, $route_status;
        $busrouteid = $_POST['busroute_id'];
        $route_lat = $_POST['route_lat'];
        $route_len = $_POST['route_len'];
        $route_status = $_POST['route_status'];


        // call @function complete_schoolmanagement to create the user
        // only when no WP_error is found
        complete_allrouteloc($busrouteid, $route_lat, $route_len, $route_status);
    }
    global $busrouteid, $route_lat, $route_len, $route_status;
    allrouteloc_form($busrouteid, $route_lat, $route_len, $route_status);
}

// The callback function that will replace [book]
function custom_gpsmanagement_shortcode() {
    ob_start();
    custom_allbus_function();
    return ob_get_clean();
}

function custom1_gpsmanagement_shortcode() {
    ob_start();
    custom_allbusroute_function();

    return ob_get_clean();
}

function custom2_gpsmanagement_shortcode() {
    ob_start();
    custom_allrouteloc_function();
    return ob_get_clean();
}

// Register a new shortcode: [school_management]
add_shortcode('school_management_type_bus', 'custom_gpsmanagement_shortcode');
add_shortcode('school_management_bus_route', 'custom1_gpsmanagement_shortcode');
add_shortcode('school_management_route_location', 'custom2_gpsmanagement_shortcode');
?>