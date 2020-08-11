import Permission from './../components/auth/permission/index';
import PermissionForm from './../components/auth/permission/form';

import Role from './../components/auth/role/index';
import RoleForm from './../components/auth/role/form';

import UserList from './../components/auth/user/index';
import UserCreateForm from './../components/auth/user/create';
import UserUpdateForm from './../components/auth/user/update';
const currentLocale = '/' + window.MonCMS.currentLocale;

export default [
    {
        path: '/admin/auth/permissions',
        name: 'admin.auth.permissions.index',
        component: Permission,
    },
    {
        path: '/admin/auth/permissions/create',
        name: 'admin.auth.permissions.create',
        component: PermissionForm,
        props: {
            pageTitle: 'permission.label.create_permission',
        },
    },

    {
        path: '/admin/auth/permissions/:permissionId/edit',
        name: 'admin.auth.permissions.edit',
        component: PermissionForm,
        props: {
            pageTitle: 'permission.label.update_permission',
        },
    },
    // role
    {
        path: '/admin/auth/roles',
        name: 'admin.auth.roles.index',
        component: Role,
    },
    {
        path: '/admin/auth/roles/create',
        name: 'admin.auth.roles.create',
        component: RoleForm,
        props: {
            pageTitle: 'role.label.create_role',
        },
    },

    {
        path: '/admin/auth/roles/:roleId/edit',
        name: 'admin.auth.roles.edit',
        component: RoleForm,
        props: {
            pageTitle: 'role.label.update_role',
        },
    },
    // user
    {
        path: '/admin/auth/users',
        name: 'admin.auth.users.index',
        component: UserList,
    },
    {
        path: '/admin/auth/users/create',
        name: 'admin.auth.users.create',
        component: UserCreateForm,
        props: {
            pageTitle: 'user.label.create_user',
        },
    },

    {
        path: '/admin/auth/users/:userId/edit',
        name: 'admin.auth.users.edit',
        component: UserUpdateForm,
        props: {
            pageTitle: 'user.label.update_user',
        },
    },
];
