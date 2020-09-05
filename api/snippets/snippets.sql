/** Retrieve user, channel, profile and roles *//
Select 
	user.id,
	user.email, 
	concat(user.last_name, ', ', user.first_name) as full_name,
	channel.name,
	channel_profile.name,
	role.role_key,
	role.entity,
	role.method
from user 
left join user_profile on user_profile.user_id = user.id
left join channel_profile on channel_profile.id = user_profile.profile_id
left join channel_role on channel_role.channel_profile_id = channel_profile.id
left join role on role.id = channel_role.role_id
left join channel on channel.id = channel_profile.channel_id
