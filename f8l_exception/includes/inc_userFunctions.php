<?php
function login ($userName){
    $sql = "CALL logUser('$userName')";
    $result = queryMysql($sql);
}

function getChecking($Login){
    echo    "<fieldset style='margin-bottom: 50px; margin-top: 20px'>
                <legend><b>Checking</b></legend>
                <tr>
                    <table width='50%' border='1'>
                    <th>Date</th>
                    <th>Transaction Type</th>
                    <th>From Account</th>
                    <th>To Account</th>
                    <th>Amount</th>
                </tr>
                <p>
            ";
    
    $sql = "SELECT * from transaction WHERE '$Login'=username and acctype='Checking'";
            $result = queryMysql($sql);
            $num = $result->num_rows;
            for ($j = 0; $j < $num; $j++){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                echo    "<tr>
                        <td class='statements'>" . $row['transdate'] . "</td>" .
                        "<td class='statements'>" . $row['transtype'] . "</td>";
                
                if ($row['transtype'] == "Deposit"){
                    echo "<td class='statements'> </td>";
                
                } else{
                    echo "<td class='statements'>" . $row['accid'] . "</td>";
                }
                
                if ($row['transtype'] == "Withdraw"){
                    echo "<td class='statements'></td>";
                }else {
                    echo "<td class='statements'>" . $row['toid'] . "</td>";
                }
                echo "<td class='statements'>$ " . number_format($row['amount'], 2, ".", ",")."</td>" .
                     "</tr>";
            }
            echo "  </table>
                    </p>
                    </fieldset>
            ";
}

function getSavings($Login){
    echo    "<fieldset style='margin-bottom: 50px; margin-top: 20px'>
                <legend><b>Savings</b></legend>
                <tr>
                    <table width='50%' border='1'>
                    <th>Date</th>
                    <th>Transaction Type</th>
                    <th>From Account</th>
                    <th>To Account</th>
                    <th>Amount</th>
                </tr>
                <p>
            ";
    
    $sql = "SELECT * from transaction WHERE '$Login'=username and acctype='Savings'";
            $result = queryMysql($sql);
            $num = $result->num_rows;
            for ($j = 0; $j < $num; $j++){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                echo    "<tr>
                        <td class='statements'>" . $row['transdate'] . "</td>" .
                        "<td class='statements'>" . $row['transtype'] . "</td>";
                
                if ($row['transtype'] == "Deposit"){
                    echo "<td class='statements'> </td>";
                }else{
                    echo "<td class='statements'>" . $row['accid'] . "</td>";
                }
                
                if ($row['transtype'] == "Withdraw"){
                    echo "<td class='statements'></td>";
                }else {
                    echo "<td class='statements'>" . $row['toid'] . "</td>";
                }
                echo "<td class='statements'>$ " . number_format($row['amount'], 2, ".", ",")."</td>" .
                     "</tr>";
            }
            echo "  </table>
                    </p>
                    </fieldset>
            ";
}

function getCredit($Login){
    echo    "<fieldset style='margin-bottom: 50px; margin-top: 20px'>
                <legend><b>Credit Card</b></legend>
                <tr>
                    <table width='50%' border='1'>
                    <th>Date</th>
                    <th>Transaction Type</th>
                    <th>To Account</th>
                    <th>Amount</th>
                </tr>
                <p>
            ";
    
    $sql = "SELECT * from transaction WHERE '$Login'=username and acctype='Credit Card'";
            $result = queryMysql($sql);
            $num = $result->num_rows;
            for ($j = 0; $j < $num; $j++){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                echo    "<tr>
                        <td class='statements'>" . $row['transdate'] . "</td>" .
                        "<td class='statements'>" . $row['transtype'] . "</td>";
                
                echo "<td class='statements'>" . $row['toid'] . "</td>";
                echo "<td class='statements'>$ " . number_format($row['amount'], 2, ".", ",")."</td>" .
                     "</tr>";
            }
            echo "  </table>
                    </p>
                    </fieldset>
            ";
}

function getLoan($Login){
    echo    "<fieldset style='margin-bottom: 50px; margin-top: 20px'>
                <legend><b>Loan</b></legend>
                <tr>
                    <table width='50%' border='1'>
                    <th>Date</th>
                    <th>Transaction Type</th>
                    <th>To Account</th>
                    <th>Amount</th>
                </tr>
                <p>
            ";
    
    $sql = "SELECT * from transaction WHERE '$Login'=username and acctype='Loan'";
            $result = queryMysql($sql);
            $num = $result->num_rows;
            for ($j = 0; $j < $num; $j++){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                echo    "<tr>
                        <td class='statements'>" . $row['transdate'] . "</td>" .
                        "<td class='statements'>" . $row['transtype'] . "</td>";
                
                echo "<td class='statements'>" . $row['toid'] . "</td>";
                echo "<td class='statements'>$ " . number_format($row['amount'], 2, ".", ",")."</td>" .
                     "</tr>";
            }
            echo "  </table>
                    </p>
                    </fieldset>
            ";
}
?>

