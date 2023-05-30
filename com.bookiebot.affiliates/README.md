Affiliate Portal API Protocol
====================

- - -

# Add User

	POST https://affiliates.betplanet.win/api/add_user

### Request Body Params:

1. `user_id` (int) Unique user id in casino
1. `parent_id` (int) Unique user id in casino
1. `email` (string) User email in casino
1. `country` (string) User City or Country
1. `hash` (string) See hash algorithm in this README.

### Response:
IF true: `JSON {code: 10, msg: 'inserted new user'}`

IF false: `JSON {code: [SQL ERROR CODE], msg: [SQL ERROR MSG]}`

- - -

# Add Log

	POST https://affiliates.betplanet.win/api/add_log

### Request Body Params:

1. `user_id` (int) Unique user id in casino
1. `product_id` (int) 1 - Betting Exchange, 2 - Slots, 3 - Live Casino, 4 - Sports Book, 5 - Skill Games.
1. `amount` (int) Money amount for share in cents.
1. `transaction_id` (string) transaction Identification.
1. `hash` (string) See hash algorithm in this README.

### Response:
IF true: `JSON {code: 10, msg: 'INSERTED PROFIT LOGS.', profits: {...}}`

IF false: `JSON {code: [ERROR CODE], msg: [ERROR MSG]}`

- - -

# Hash Algorithm

	sha256( Param1 + Param2 + Param3 + Param4 + KEY  )

KEY is located at `routes/api.js` on line 14.


- - -

# Affiliate ID

Affilliate id is encyripted user_id.

encyription method is HashIds ( http://hashids.org/ )

For PHP:

	$hashids = new Hashids\Hashids(SALT,6,"abcdefghijklmnpqrstuvwxyz123456789"); // "1", "l", "0" and "o" are missed, for better UX
	$user_id = $hashids->decode(AFFILIATE_ID);



SALT is located at `routes/user.js` on line 7.
