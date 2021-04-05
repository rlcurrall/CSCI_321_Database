<?php

include('model/database.php');
include('model/user_db.php');

$keyword = 'c';
$username = 'jsuarez';

$users = search_users($keyword);

$test = get_user($username);

foreach ($users as $user):
    ?>
<p>
<?php    

echo $user['email'];
endforeach;
?>
</p>
<?php

echo $test['email'];
?>