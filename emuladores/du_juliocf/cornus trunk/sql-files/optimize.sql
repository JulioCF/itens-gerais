# Optimize Cronus database (por Banned)
# Atualizado por Rafael (adicionadas 5 tabelas; removidas 28 tabelas)
# Novamente atualizado por Mara (adicionado 4 tabelas; removida 1 tabela)

OPTIMIZE TABLE `auction`
# ,`atcommandlog`
# ,`branchlog`
,`cart_inventory`
,`char`
,`charlog`
# ,`chatlog`
,`friends`
,`global_reg_value`
,`guild`
,`guild_alliance`
,`guild_castle`
,`guild_expulsion`
,`guild_member`
,`guild_position`
,`guild_skill`
,`guild_storage`
,`homunculus`
,`hotkey`
,`interlog`
,`inventory`
,`ipbanlist`
,`item_db`
,`item_db2`
,`login`
,`loginlog`
,`mail`
,`mapreg`
,`memo`
,`mercenary`
,`mercenary_owner`
,`mob_db`
,`mob_db2`
# ,`mvplog`
# ,`npclog`
,`party`
,`pet`
# ,`picklog`
,`quest`
,`ragsrvinfo`
,`sc_data`
,`skill`
,`skill_homunculus`
,`sstatus`
,`storage`
# ,`zenylog`