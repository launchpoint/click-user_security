<?

/*
function user_get_roles__d($user)
{
  dprint(User::$has_many_through);
  $roles = Role::find_all( array(
    'joins'=> 'join user_roles ur on ur.role_id = roles.id join users u on u.id = ur.user_id',
    'conditions'=>array( 'u.id = ?', $user->id)
  ));
  return $roles;
}
*/

function user_has_access__d($user)
{
  $roles = $user->roles;
  $args = func_get_args();
  array_shift($args);
  foreach($args as $role_name)
  {
    foreach($roles as $role)
    {
      if ($role->name == $role_name || $role->name=='admin') return true;
    }
  }
  return false;
}

function user_is__d($user)
{
  $args = func_get_args();
  array_shift($args);
  $acceptable_roles = array();
  for($i=0;$i<count($args);$i++)
  {
    $v = $args[$i];
    if(is_array($v))
    {
      foreach($v as $e)
      {
        if(is_object($e))
        {
          $e = $e->name;
        } else {
          $e = strtolower($e);
        }
        $acceptable_roles[] = $e;
      }
    } else {
      if(is_object($v))
      {
        $v = $v->name;
      } else {
        $v = strtolower($v);
      }
      $acceptable_roles[] = $v;
    }
  }
  $roles = $user->roles;
  foreach($roles as $role)
  {
    if (array_search(strtolower($role->name), $acceptable_roles)!==false) return true;
  }
  return false;
}

function user_add_role($user)
{
  $args = func_get_args();
  array_shift($args);
  foreach($args as $role_name)
  {
    if ($user->is($role_name)) continue;
    $role = Role::find_or_create_by( array(
      'conditions'=>array('name = ?', $role_name),
      'attributes'=>array(
        'name'=>$role_name
      )
    ));
    $ur = UserRole::find_or_create_by( array(
      'conditions'=>array('role_id = ? and user_id = ?', $role->id, $user->id),
      'attributes'=>array(
        'role_id'=>$role->id,
        'user_id'=>$user->id
      )
    ));
  }
  $user->purge('roles');
}

function user_commit_roles($u)
{
  foreach($u->roles as $role)
  {
    if(is_object($role))
    {
      $id = $role->id;
    } else {
      $id = $role;
    }
    UserRole::find_or_create_by(array(
      'conditions'=>array('user_id = ? and role_id = ?', $u->id, $id),
      'attributes'=>array(
        'user_id'=>$u->id,
        'role_id'=>$id
      )
    ));
  }
}

function user_update_roles($u, $ids)
{
  update_junction('user_roles', 'user_id', $u->id, 'role_id', $ids);
  $u->purge('roles');
}