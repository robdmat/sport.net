<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <h3 class="title"><span class="icon-dashboard"></span>&nbsp;&nbsp;<?php echo $this->lang->line("user_dashboard"); ?></h3>
        </div>
        <!-- /row-fluid --></div>

    <!--User Transaction History-->

    <div class="row-fluid">
        <div class="span12">
            <div class="span8 wrapper">
                <h3 class="title"><span class="icon-dashboard"></span>TITLE&nbsp;&nbsp;</h3><?php
                $userData = $this->session->all_userdata();
                if (isset($userData['user_id'])) {
                    $history = salesquery::create()->filterByuserid($userData['user_id'])->find();
                    if (isset($history) && !empty($history)) {
                        $count = 1;
                        echo '<table class="table table-bordered">
                        <thead>
                          <tr>
                          <th>#</th>
                         <th>Item Name</th>
                         <th>Transaction Id</th>
                         <th>Amount</th>
                         <th>Date</th>
                         </tr>
                        </thead>
                        <tbody>';
                        foreach ($history as $transaction_history) {
                            echo '<tr><td>' . $count . '</td><td>';
                            echo getNameById($transaction_history->getitemid());
                            echo '</td>';
                            echo '<td>';
                            echo $transaction_history->gettransactionid();
                            echo '</td>';
                            echo '<td>';
                            echo $transaction_history->getamount();
                            echo '</td>';
                            echo '<td>';
                            echo $transaction_history->getdate();
                            echo '</td></tr>';
                            $count ++;
                        }
                        echo '</tbody> </table>';
                    }
                }

                function getNameById($itemId) {

                    $itemName = itemsquery::create()->filterByid($itemId)->findOne();
                    $itemname = isset($itemName) ? $itemName->getitemname() : 'error_code';
                    return $itemname;
                }
                ?>
            </div>
            <?php echo $user_sidebar; ?>
        </div>
        <!-- /row-fluid --></div>
    <!-- /container --></div>
