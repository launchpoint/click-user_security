<?

map('content', 'admin/roles', 'view', 'edit_roles');
map('content', 'admin/users/:id/roles', 'manage_user', 'manage_roles_for');

map('superlist_user_columns', 'admin/users', 'superlist_user_columns');