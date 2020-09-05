import {
  ROLE_INFORMATION_READ_COLLECTION,
  ROLE_USER_READ_COLLECTION,
  ROLE_USER_READ,
  ROLE_ROLE_READ_COLLECTION,
  ROLE_ROLE_READ
} from '../constants/roles'

import RoleService from '../services/RolesService'

const getNav = user => {
  let nav = [
    {
      _tag: 'CSidebarNavItem',
      name: 'Dashboard',
      to: '/dashboard',
      icon: 'cil-speedometer',
    }
  ]

  let subItems = getNavItems(user)
    .filter(item => RoleService.intersects(user.roles, item.roles))

  const userNav = user.channels.map(channel => (
    nav = [...nav, {
      _tag: 'CSidebarNavDropdown',
      name: channel,
      route: '',
      icon: 'cil-basket',
      _children: subItems
    }]
  ))

  return nav
}

const getNavItems = user => {
  return [
    {
      name: 'Channels',
      roles: [ROLE_INFORMATION_READ_COLLECTION],
      _tag: 'CSidebarNavItem',
      to: '/users',
      icon: 'cil-spreadsheet'
    },

    {
      name: 'Users',
      roles: [
        ROLE_USER_READ_COLLECTION,
        ROLE_USER_READ
      ],
      _tag: 'CSidebarNavItem',
      to: '/users',
      icon: 'cil-user'
    },

    {
      name: 'Roles',
      roles: [
        ROLE_ROLE_READ_COLLECTION,
        ROLE_ROLE_READ
      ],
      _tag: 'CSidebarNavItem',
      to: '/users',
      icon: 'cil-people'
    }
  ]
}

export default {
  getNav
}
