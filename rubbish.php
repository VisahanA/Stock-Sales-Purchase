 $mthch= mysqli_query($con, "SELECT t_product.p_name,t_product.p_desc,t_product.p_brand, t_product.p_cost,t_product.p_quantity FROM
                                           t_purtrans INNER JOIN t_product ON t_purtrans.p_id=t_product.p_id WHERE p_tdate LIKE '%$mnthsel%'");
                                           echo "<br><hr><center>MONTHLY PURCHASES</center>" ;
                                           echo "<hr>" ;
                                            ?> 
                                        <select name="mnthsel" id="mnthsel">
                                            <option>----SELECT MONTH----</option>
                                            <option>Jan</option>
                                            <option>Feb</option>
                                            <option>Mar</option>
                                            <option>Apr</option>
                                            <option>May</option>
                                            <option>Jun</option>
                                            <option>Jul</option>
                                            <option>Aug</option>
                                            <option>Sep</option>
                                            <option>Oct</option>
                                            <option>Nov</option>
                                            <option>Dec</option>
                                        </select>
                                        
                                        <input type="submit" name="showmprd" id="showmprd" value="Show">
                                        <?php
                                        if(isset($_REQUEST["showmprd"]))
                                        {
                                                echo "<table class='table table-bordered'>";
                                           
                                           echo "<th>Category</th>";
                                           echo "<th>Brand</th>";
                                           echo "<th>Model Details</th>";
                                           echo "<th>Cost per Item</th>";
                                           echo "<th>Quantity</th>";
                                           while($mthc = mysqli_fetch_array($mthch))              
                                           {
                                              echo "<tr>";
                                              echo "<td>". $mthc[0]."</td>";
                                              echo "<td>". $mthc[1]."</td>";
                                              echo "<td>". $mthc[2]."</td>";
                                              echo "<td>". $mthc[3]."</td>";
                                              echo "<td>". $mthc[4]."</td>";
                                              echo "</tr>";
                                           }
                                           echo "<tr>";
                                              echo "<td colspan=5>";
                                              echo '<center><a href="mnthlyrcd.php" class="btn btn-default" style="color:black;"> Download Excel File </a></center>';
                                              echo "</td>";
                                              echo "</tr>";
                                           echo "</table>";
                                        }