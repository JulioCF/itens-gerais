# Repara o Banco de Dados do Cronus (por Banned)
# Atualizado por Rafael (adicionadas 5 tabelas; removidas 28 tabelas)
# Novamente atualizado por Mara (adicionado 3 tabelas; removida 1 tabela)
# Apenas use se alguma tabela estiver corrompida.
# Funciona apenas para tabelas do tipo MyISAM.

REPAIR TABLE `auction`
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
#,`skill_homunculus`
,`sstatus`
,`storage`
# ,`zenylog`