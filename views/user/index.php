<table>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Money</th>
    </tr>
<?php foreach($this->users as $user): ?>
    <tr>
        <td><?php echo $user['id'] ?></td>
        <td><?php echo $user['username'] ?></td>
        <td><?php echo $user['money'] ?></td>
    </tr>
<?php endforeach; ?>
</table>