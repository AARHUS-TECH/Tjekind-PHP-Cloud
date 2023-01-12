<?php
require_once('../core/init.php');

$user = new User();
?>
 
                        <?php
                        $data  = $user->getAllElever();

                        foreach($data as $row) {
                            if ($row->tjekind_timestamp > 0) {
                                $time = date('H:i - j F, Y', strtotime($row->tjekind_timestamp));
                            } else {
                                $time = 'Mangler første tjek ind!';
                            }

                            $status = $user->getStatusString($row->status);
                            $statusClass = $user->getStatusClass($row->status);
                            
                            echo '<tr class="content ' . $statusClass . '">';
                            echo '<td>' . $row->fornavn . ' ' . $row->efternavn . '</td>';
                            echo '<td>' . $time . '</td>';
                            echo '<td>' . $status . '</td>';
                            echo '<td>' . $row->bemning . '</td>';
                            echo '<td><button class="btn btn-outline-white" href="#" onclick="editStudent('.$row->userID.');" >Rediger</button></td>';//href="/admin/redigerElev.php?id=' .  . '&scrollpos="
                            echo '</tr>'; 
                        }
                    ?>
