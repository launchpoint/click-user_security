<?

$u = User::find_by_id($params['id']);
$roles = Role::find_all(array(
  'order'=>'name asc'
));

$sections = array(
  'selected roles'=>array(
    'roles'=>array('type'=>'mutex', 'item_array'=>$roles, 'selected_items_array'=>$u->roles),
  ),
);

$u->superform_sections = $sections;

if(is_postback())
{
  $u->update_attributes($params['user']);
  if($u->is_valid)
  {
    flash_next('User Updated');
    redirect_to(admin_manage_users_url());
  }
}

$u->superform();