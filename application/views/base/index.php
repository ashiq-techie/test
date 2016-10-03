<form action="" method="post" id="detailsForm">
    <table>
        <tr>
            <th>First name</th>
            <th>Last name</th>
            <th>Email Address</th>
            <th>Job Role</th>
            <th>Delete</th>
        </tr>
        <?php 
        if (!empty($aEmployees)) {
        foreach ($aEmployees as $aEmployee) : ?>
        <tr class="list">
            <?php foreach ($aEmployee as $sAttribute => $sValue):
                if ($sAttribute == 'employee_id') :?>
                <input type="hidden" name="peopleUpdate[<?= $aEmployee['employee_id'] ?>][<?= $sAttribute ?>]" value="<?= $aEmployee['employee_id'] ?>" />   
                <input type="hidden" name="peopleUpdate[<?= $aEmployee['employee_id'] ?>][is_deleted]" value="<?= $aEmployee['employee_id'] ?>" />
            <?php        continue;
                endif
            ?>
            <td><input type="text" name="peopleUpdate[<?= $aEmployee['employee_id'] ?>][<?= $sAttribute ?>]" value="<?= $sValue ?>" /></td>
            <?php endforeach ?>
            <td><input type="checkbox" name="peopleUpdate[<?= $aEmployee['employee_id'] ?>][is_deleted]" value="<?= $aEmployee['employee_id'] ?>" /></td>
            <td><span id="error_<?= $aEmployee['employee_id'] ?>" style="color:red"></span></td>
        </tr>
        <?php endforeach; 
        } 
        ?>
        
        <tr>
            <td><input type="text" name="people[first_name]" placeholder="Add new..." /></td>
            <td><input type="text" name="people[last_name]" placeholder="Add new..." /></td>
            <td><input type="text" name="people[email]" placeholder="Add new..." /></td>
            <td><input type="text" name="people[job_role]" placeholder="Add new..." /></td>
            <td><span id="insertError" style="color:red"></span></td>
        </tr>
    </table>
    <input type="submit" id="check" value="Submit!" />
</form>