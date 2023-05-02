<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RulesSeeder extends Seeder
{
    public function run(){

        $rules =<<<TEMPLATES
[
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/articles\/items",
		"v2" : "(GET)|(POST)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/articles\/items\/*",
		"v2" : "(GET)|(PUT)|(DELETE)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/citation-styles",
		"v2" : "GET",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/citation-styles\/:id",
		"v2" : "GET",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/references\/definitions",
		"v2" : "GET",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/references\/definitions\/*",
		"v2" : "GET",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/references\/items",
		"v2" : "(GET)|(POST)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/references\/items\/*",
		"v2" : "GET",
		"v3" : "deny"
	},
	{
		"ptype" : "g",
		"v0" : "root",
		"v1" : "root",
		"v2" : null,
		"v3" : null
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "ReferenceItem::isOwner(\/references\/items\/*)",
		"v2" : "(PUT)|(DELETE)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/layouts",
		"v2" : "(GET)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/layouts\/*",
		"v2" : "(GET)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/articles",
		"v2" : "(GET)|(POST)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/articles\/*",
		"v2" : "(GET)|(PUT)|(DELETE)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "isOwner(\/references\/definitions\/*)",
		"v2" : "(PUT)|(DELETE)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/event-dispatcher\/tasks",
		"v2" : "(GET)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/articles\/items\/{id}\/pdf\/export",
		"v2" : "(POST)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/collaborators\/invite",
		"v2" : "(PUT)|(POST)|(DELETE)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/cdn\/{version}\/upload",
		"v2" : "(POST)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "root",
		"v1" : "\/collaborators\/comment",
		"v2" : "(POST)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/articles\/sections",
		"v2" : "(GET)|(POST)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/articles\/sections\/*",
		"v2" : "(GET)|(PUT)|(DELETE)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/articles\/templates",
		"v2" : "(GET)|(POST)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/articles\/templates\/*",
		"v2" : "(GET)|(PUT)|(DELETE)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/articles",
		"v2" : "GET",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/articles\/*",
		"v2" : "GET",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/citation-styles",
		"v2" : "GET",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/citation-styles\/:id",
		"v2" : "GET",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/layouts",
		"v2" : "(GET)|(POST)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/layouts\/*",
		"v2" : "(GET)|(PUT)|(DELETE)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/references\/definitions",
		"v2" : "(GET)|(POST)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/references\/definitions\/*",
		"v2" : "(GET)",
		"v3" : "deny"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/references\/items",
		"v2" : "GET",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/references\/items\/*",
		"v2" : "GET",
		"v3" : "allow"
	},
	},
		{
		"ptype" : "p",
		"v0" : "admin",
		"v1" : "\/event-dispatcher\/tasks",
		"v2" : "(GET)",
		"v3" : "allow"
	},
	{
		"ptype" : "g",
		"v0" : "admin",
		"v1" : "root",
		"v2" : null,
		"v3" : null
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/articles\/items",
		"v2" : "(GET)|(POST)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/articles\/items\/*",
		"v2" : "(GET)|(PUT)|(DELETE)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/citation-styles",
		"v2" : "GET",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/citation-styles\/:id",
		"v2" : "GET",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/references\/definitions",
		"v2" : "GET",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/references\/definitions\/*",
		"v2" : "GET",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/references\/items",
		"v2" : "(GET)|(POST)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/references\/items\/*",
		"v2" : "GET",
		"v3" : "allow"
	},
	{
		"ptype" : "g",
		"v0" : "author",
		"v1" : "root",
		"v2" : null,
		"v3" : null
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "ReferenceItem::isOwner(\/references\/items\/*)",
		"v2" : "(PUT)|(DELETE)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/layouts",
		"v2" : "(GET)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/layouts\/*",
		"v2" : "(GET)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/articles",
		"v2" : "(GET)|(POST)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/articles\/*",
		"v2" : "(GET)|(PUT)|(DELETE)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "isOwner(\/references\/definitions\/*)",
		"v2" : "(PUT)|(DELETE)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/event-dispatcher\/tasks",
		"v2" : "(GET)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/articles\/items\/{id}\/pdf\/export",
		"v2" : "(POST)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/collaborators\/invite",
		"v2" : "(PUT)|(POST)|(DELETE)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/cdn\/{version}\/upload",
		"v2" : "(POST)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "author",
		"v1" : "\/collaborators\/comment",
		"v2" : "(POST)",
		"v3" : "allow"
	},
	{
		"ptype" : "p",
		"v0" : "ServiceExecutionRole",
		"v1" : "*",
		"v2" : ".*",
		"v3" : "allow"
	},
	{
		"ptype" : "g",
		"v0" : "ServiceExecutionRole",
		"v1" : "root",
		"v2" : null,
		"v3" : null
	},
	{
		"ptype" : "p",
		"v0" : "SuperAdmin",
		"v1" : "*",
		"v2" : ".*",
		"v3" : "allow"
	},
	{
		"ptype" : "g",
		"v0" : "SuperAdmin",
		"v1" : "root",
		"v2" : null,
		"v3" : null
	}
]
TEMPLATES;
        collect(json_decode($rules, true))->each(function($rule){
            $statemenet = DB::table('rules')
                ->where('ptype', $rule['ptype'])
                ->where('v0', $rule['v0'])
                ->where('v1', $rule['v1'])
                ->where('v2', $rule['v2']);
            if($statemenet->exists()){
                $statemenet->update(['v3'=>$rule['v3']]);
            } else {
                DB::table('rules')->insert($rule);
            }
        });
        DB::table('rules')->whereNotIn('v0', ['root','admin','author','editor','reader','SuperAdmin','ServiceExecutionRole'])->whereIn('v1', ['editor','reader'])
            ->update(['v1' => 'author']);
    }
}
