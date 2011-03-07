<?

if(count($user->roles)==0)
{
  $r = Role::find_or_create_by_name($account_settings['default_role']);
  if(!$r) click_error("Error. Default role '{$account_settings['default_role']}' was specified, but is not defined.");
  $user->roles = array($r);
} 

if (isset($__core['session']['signup_info']['roles']))
{
  $role_names = is_array($__core['session']['signup_info']['roles']) ? $__core['session']['signup_info']['roles'] : array($__core['session']['signup_info']['roles']);
  foreach($role_names as $role_name)
  {
    $r = Role::find_or_create_by_name($role_name);
    if(!$r) click_error("Error. Role $role_name not found.");
    $user->roles[] = $r;
  }
}

foreach($user->roles as $role)
{
  event("init_{$role->name}_role", array('user'=>$user));
}
