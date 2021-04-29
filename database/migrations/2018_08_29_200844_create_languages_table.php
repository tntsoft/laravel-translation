<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use JoeDixon\Translation\Language;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		// create the table only if it doesn't exist
		if(!Schema::connection(config('translation.database.connection'))->hasTable(config('translation.database.translations_table')))
		{
			Schema::connection(config('translation.database.connection'))->create(config('translation.database.languages_table'), function(Blueprint $table)
				{
					$table->increments('id');
					$table->string('name')->nullable();
					$table->string('language');
					$table->timestamps();
				});

			$initialLanguages = array_unique([config('app.fallback_locale'), config('app.locale'),]);

			foreach($initialLanguages as $language)
			{
				Language::firstOrCreate(['language' => $language,]);
			}
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	// never drop the schema
//        Schema::connection(config('translation.database.connection'))
//            ->dropIfExists(config('translation.database.languages_table'));
    }
}
