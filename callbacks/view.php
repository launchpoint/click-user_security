<?

$roles = Role::find_all( array('order'=>'name asc') );

$meta = array(
  'klass'=>'Role',
  'objects='=>$roles,
  'list'=>array('name'),
);

superlist($meta);