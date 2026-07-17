<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_setting_has_fillable_fields(): void
    {
        $setting = new Setting();
        $fillable = $setting->getFillable();

        $this->assertContains('key', $fillable);
        $this->assertContains('value', $fillable);
        $this->assertContains('type', $fillable);
    }

    public function test_setting_get_method(): void
    {
        Setting::create(['key' => 'site_name', 'value' => 'Kitsuneoni', 'type' => 'text']);

        $value = Setting::get('site_name');
        $this->assertEquals('Kitsuneoni', $value);
    }

    public function test_setting_get_returns_default(): void
    {
        $value = Setting::get('nonexistent_key', 'default_value');
        $this->assertEquals('default_value', $value);
    }

    public function test_setting_set_method(): void
    {
        Setting::set('site_name', 'New Name');
        $this->assertEquals('New Name', Setting::get('site_name'));
    }

    public function test_setting_set_updates_existing(): void
    {
        Setting::create(['key' => 'site_name', 'value' => 'Old Name', 'type' => 'text']);
        Setting::set('site_name', 'New Name');

        $this->assertEquals('New Name', Setting::get('site_name'));
        $this->assertDatabaseCount('settings', 1);
    }
}
