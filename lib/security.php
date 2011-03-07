<?

function has_access()
{
  global $current_user;
  
  if (!$current_user) return false;
  $roles = func_get_args();
  return call_user_func_array( array($current_user, 'has_access'), $roles);
}

function require_access()
{
  global $full_request_path;
  $roles = func_get_args();
  if (!call_user_func_array('has_access', $roles)) redirect_to(login_url(array('r'=>home_url().$full_request_path)));
}