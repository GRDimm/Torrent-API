# Torrent-API
A simple PHP to get all possible torrents as JSON tree.

##license

tAPI Copyright © 2017 Antoine Raulin & Dimitri Mades

You are allowed to use, modify and redistribute the project as long as original credits are kept and changes are documented. You are not allowed to redistribute the project without attribution and credits or prior permission. You can only redistribute this project under open source license.

Vous êtes autorisé à utiliser, modifier et redistribuer le projet tant que les crédits d'origine sont conservés et que les changements sont documentés. Vous n'êtes pas autorisé à redistribuer le projet sans attribution et crédits aux auteurs ou autorisation préalable. Vous ne pouvez redistribuer ce projet que sous une license open source.

<h1>Arguments</h1>

index.php searches torrents on different sites. Use it with these arguments :

'name' is the thing you search, 't9', 'x1337' and 'eztv' are the websites you are going to search on, put false on every website you don't want it to go.

'x1337pages' is the number of pages you want the API to explore on 'x1337'.

name=< YOURSEARCH >&t9=< true OR false >&x1337=< true OR false >&eztv=< true OR false >&x1337pages=< INTEGER >

<h1>Example Usage</h1>

GET : PATH TO API/index.php?name=The%20Walking%20Dead&t9=false&x1337=false&eztv=true&x1337pages=1
