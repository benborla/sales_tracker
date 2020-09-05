
export const intersects = (userRoles, requiredRoles) => (
  requiredRoles.filter(role => userRoles.includes(role)).length > 0
)

export default {
  intersects
}
