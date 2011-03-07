<?
$roles = $user->roles;
$user->purge('roles');
foreach($roles as $role)
{
  $user->add_role($role->name);
}

foreach($user->roles as $role)
{
  event($role->name .'_account_activated', array('user'=>$user));
}