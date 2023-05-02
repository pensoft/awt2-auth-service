<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsSeeder extends Seeder
{
    public function run(){
        $params = collect([
            'auth.credentials.swagger.pkce.client_id',
            'auth.credentials.article_editor.pkce.client_id',
            'auth.credentials.article_editor.pg.client_id',
            'auth.credentials.article_editor.pg.client_secret',
            'auth.credentials.article_backoffice.pkce.client_id',
            'auth.credentials.article_backoffice.pg.client_id',
            'auth.credentials.article_backoffice.pg.client_secret',
            'auth.credentials.service_connector.client_id',
            'auth.credentials.service_connector.client_secret',
            'services.pensoft.url.article_editor',
            'services.pensoft.url.article_editor_stage',
            'services.pensoft.url.article_backoffice',
            'services.pensoft.url.article_backoffice_stage',
            'services.pensoft.services.article',
            'services.pensoft.services.auth',
            'services.pensoft.services.event_dispatcher',
            'services.pensoft.services.article_storage',
            'services.pensoft.services.cdn',
        ])->reduce(fn (&$carry, $item) => [...$carry, ...[$item => config($item)]], []);

        $clients = <<<TEMPLATE
[
	{
		"id" : "{$params['auth.credentials.article_editor.pg.client_id']}",
		"name" : "ARTICLE_EDITOR_PG_CLIENT",
		"secret" : "{$params['auth.credentials.article_editor.pg.client_secret']}",
		"provider" : "users",
		"redirect" : "http:\/\/localhost",
		"personal_access_client" : 0,
		"password_client" : 1,
		"revoked" : 0
	},
	{
		"id" : "{$params['auth.credentials.article_backoffice.pg.client_id']}",
		"name" : "ARTICLE_BACKOFFICE_PG_CLIENT",
		"secret" : "{$params['auth.credentials.article_backoffice.pg.client_secret']}",
		"provider" : "users",
		"redirect" : "http:\/\/localhost",
		"personal_access_client" : 0,
		"password_client" : 1,
		"revoked" : 0
	},
	{
		"id" : "{$params['auth.credentials.service_connector.client_id']}",
		"name" : "SERVICE_CONNECTOR_CLIENT",
		"secret" : "{$params['auth.credentials.service_connector.client_secret']}",
		"provider" : "services",
		"redirect" : "http:\/\/localhost",
		"personal_access_client" : 0,
		"password_client" : 1,
		"revoked" : 0
	},
	{
		"id" : "{$params['auth.credentials.article_backoffice.pkce.client_id']}",
		"name" : "BackOffice Client",
		"secret" : null,
		"provider" : null,
		"redirect" : "{$params['services.pensoft.url.article_backoffice']}\/auth\/callback,{$params['services.pensoft.url.article_backoffice_stage']}\/auth\/callback",
		"personal_access_client" : 0,
		"password_client" : 0,
		"revoked" : 0
	},
	{
		"id" : "{$params['auth.credentials.article_editor.pkce.client_id']}",
		"name" : "Article Editor Client",
		"secret" : null,
		"provider" : null,
		"redirect" : "{$params['services.pensoft.url.article_editor']}\/callback,{$params['services.pensoft.url.article_editor_stage']}\/callback",
		"personal_access_client" : 0,
		"password_client" : 0,
		"revoked" : 0
	},
	{
		"id" : "{$params['auth.credentials.swagger.pkce.client_id']}",
		"name" : "SWAGGER",
		"secret" : null,
		"provider" : null,
		"redirect" : "{$params['services.pensoft.services.auth']}\/api\/oauth2-callback,{$params['services.pensoft.services.article']}\/api\/oauth2-callback,{$params['services.pensoft.services.cdn']}\/api\/oauth2-callback,{$params['services.pensoft.services.event_dispatcher']}\/api\/oauth2-callback,{$params['services.pensoft.services.article_storage']}\/api\/oauth2-redirect.html",
		"personal_access_client" : 0,
		"password_client" : 0,
		"revoked" : 0
	}
]
TEMPLATE;

        collect(json_decode($clients, true))->each(function($client){
            if(env('FORCE_HTTPS')) {
                $client['redirect'] = str_replace('http://', 'https://', $client['redirect']);
            }
            $statemenet = DB::table('oauth_clients')
                ->where('id', $client['id']);
            if($statemenet->exists()){
                unset($client['id']);
                $statemenet->update($client);
            } else {
                DB::table('oauth_clients')->insert($client);
            }
        });
    }

}
