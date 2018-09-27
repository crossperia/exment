<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class DCustomDataTest extends DuskTestCase
{

// precondition : login success
    public function testLoginSuccessWithTrueUsername()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/auth/login')
                ->type('username', 'testuser')
                ->type('password', 'test123456')
                ->press('Login')
                ->waitForText('Login successful')
                ->assertPathIs('/admin')
                ->assertTitle('Dashboard')
                ->assertSee('Dashboard');
        });
    }

    // AutoTest_Data_01
    public function testCreateTable1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/table')
                ->waitForText('New')
                ->clickLink('New')
                ->pause(5000)
                ->type('table_name', 'ntq_data')
                ->type('table_view_name', 'NTQ Data')
                ->type('description', 'NTQ Test data table')
                ->type('color', '#ff0000')
                ->type('icon', 'fa-automobile')
                ->click('.fa.fa-automobile');
            $browser->press('Submit')
                ->pause(5000)
                ->assertMissing('.has-error')
                ->assertPathIs('/admin/table')
                ->assertSee('ntq_data')
                ->assertSee('NTQ Data');
        });
    }

    // AutoTest_Data_02
    public function testAddIntegerColumnTable1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'integer')
                ->type('column_view_name', 'Integer')
                ->select('column_type', 'integer')
                ->type('options[number_min]', '10')
                ->type('options[number_max]', '100');
            $browser->script('document.querySelector(".options_search_enabled.la_checkbox").click();');
            $browser->script('document.querySelector(".options_number_format.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('integer');
        });
    }

    // AutoTest_Data_03
    public function testAddOneLineTextColumnTable1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'onelinetext')
                ->type('column_view_name', 'One Line Text')
                ->select('column_type', 'text')
                ->type('options[string_length]', '256');
            $browser->script('document.querySelector(".options_search_enabled.la_checkbox").click();');
            $browser->click('#available_characters label.checkbox-inline:nth-child(1) div.icheckbox_minimal-blue')
                ->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('onelinetext');
        });
    }

    // AutoTest_Data_04
    public function testAddDateAndTimeColumnTable1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'dateandtime')
                ->type('column_view_name', 'Date and Time')
                ->select('column_type', 'datetime');
            $browser->script('document.querySelector(".options_search_enabled.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('dateandtime');
        });
    }

    // AutoTest_Data_05
    public function testAddSelectFromStaticValueColumnTable1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'selectfromstaticvalue')
                ->type('column_view_name', "Select Froom Static Value")
                ->select('column_type', 'select')
                ->keys('.form-control.options_select_item', 'Option 1', '{ENTER}', 'Option 2');
            $browser->script('document.querySelector(".options_multiple_enabled.la_checkbox").click();');
            $browser->script('document.querySelector(".options_search_enabled.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('selectfromstaticvalue');
        });
    }

    // AutoTest_Data_06
    public function testAddSelect2ValueColumnTable1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'select2value')
                ->type('column_view_name', "Select 2 value")
                ->select('column_type', 'boolean')
                ->type('options[true_value]', "value1")
                ->type('options[true_label]', "label1")
                ->type('options[false_value]', "value2")
                ->type('options[false_label]', "label2");
            $browser->script('document.querySelector(".options_multiple_enabled.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('select2value');
        });
    }

    // AutoTest_Data_07
    public function testAddYesNoColumnTable1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'yesno')
                ->type('column_view_name', 'Yes No')
                ->select('column_type', 'yesno')
                ->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('yesno');
        });
    }

//     AutoTest_Data_08
    public function testAddSelectSaveValueAndLabelColumnSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'selectsavevalueandlabel')
                ->type('column_view_name', "Select Save Value and Lable")
                ->select('column_type', 'select_valtext')
                ->keys('.form-control.options_select_item_valtext', '1,Value 1', '{ENTER}', '2,Value 2');
            $browser->script('document.querySelector(".options_multiple_enabled.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data');
        });
    }

    // AutoTest_Data_09
    public function testAddMultiLineTextColumnTable1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'multiplelinetext')
                ->type('column_view_name', 'Multiple Line Text')
                ->select('column_type', 'textarea')
                ->type('options[string_length]', '256');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('multiplelinetext');
        });
    }

    // AutoTest_Data_10
    public function testAddDecimalColumnSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'decimal')
                ->type('column_view_name', 'Decimal')
                ->select('column_type', 'decimal')
                ->type('options[number_min]', '10')
                ->type('options[number_max]', '100');
            $browser->script('document.querySelector(".options_search_enabled.la_checkbox").click();');
            $browser->script('document.querySelector(".options_number_format.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('decimal');
        });
    }

    // AutoTest_Data_11
    public function testAddURLColumnSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'url')
                ->type('column_view_name', 'URL')
                ->select('column_type', 'url');
            $browser->script('document.querySelector(".options_search_enabled.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('url');
        });
    }

    // AutoTest_Data_12
    public function testAddEmailColumnSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'email')
                ->type('column_view_name', 'Email')
                ->select('column_type', 'email');
            $browser->script('document.querySelector(".options_search_enabled.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('email');
        });
    }

    // AutoTest_Data_13
    public function testAddCalcResultColumnSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'calcresult')
                ->type('column_view_name', 'Calc Result')
                ->select('column_type', 'calc')
                ->press('変更')
                ->pause(2000)
                ->assertSee('Calc Formula');
            $browser
                ->pause(2000)
                ->click('button[data-type="fixed"]')
                ->click('button[data-val="plus"]')
                ->click('button[data-val="minus"]')
                ->click('button[data-val="times"]')
                ->click('button[data-val="div"]')
                ->press('Setting')
                ->pause(2000);
            $browser->script('document.querySelector(".options_number_format.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('calcresult');
        });
    }

    // AutoTest_Data_14
    public function testAddDateColumnSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'date')
                ->type('column_view_name', 'Date')
                ->select('column_type', 'date')
                ->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('date');
        });
    }

    // AutoTest_Data_15
    public function testAddTimeColumnSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'time')
                ->type('column_view_name', 'Time')
                ->select('column_type', 'time');
            $browser->script('document.querySelector(".options_search_enabled.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('time');
        });
    }

    // AutoTest_Data_16
    public function testAddSelectFromTableColumnSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'selectfromtable')
                ->type('column_view_name', "Select Froom Table")
                ->assertDontSee('Select Target Table')
                ->assertDontSee('Approval Multiple Select')
                ->select('column_type', 'select_table')
                ->assertSee('Select Target Table')
                ->assertSee('Approval Multiple Select')
                ->select('options[select_target_table]', 3);
            $browser->script('document.querySelector(".options_multiple_enabled.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('selectfromtable');
        });
    }

    // AutoTest_Data_17
    public function testAddAutoNumberColumnSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'autonumber')
                ->type('column_view_name', 'Auto Number')
                ->assertDontSee('Auto Number Type')
                ->select('column_type', 'auto_number')
                ->assertSee('Auto Number Type')
                ->select('options[auto_number_type]', 'random25')
                ->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('autonumber');
        });
    }

    // AutoTest_Data_18
    public function testAddImageColumnSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'image')
                ->type('column_view_name', 'Image')
                ->assertDontSee('Approval Multiple Select')
                ->select('column_type', 'image')
                ->assertSee('Approval Multiple Select');
            $browser->script('document.querySelector(".options_multiple_enabled.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('image');
        });
    }

    // AutoTest_Data_19
    public function testAddFileColumnSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'file')
                ->type('column_view_name', 'File')
                ->assertDontSee('Approval Multiple Select')
                ->select('column_type', 'file')
                ->assertSee('Approval Multiple Select');
            $browser->script('document.querySelector(".options_multiple_enabled.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('file');
        });
    }

    // AutoTest_Data_20
    public function testAddUserColumnSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'user')
                ->type('column_view_name', 'User')
                ->assertDontSee('Approval Multiple Select')
                ->select('column_type', 'user')
                ->assertSee('Approval Multiple Select');
            $browser->script('document.querySelector(".options_multiple_enabled.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('user');
        });
    }

    // AutoTest_Data_21
    public function testAddOrganizationColumnSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/column/ntq_data/create')
                ->type('column_name', 'organization')
                ->type('column_view_name', 'Organization')
                ->assertDontSee('Approval Multiple Select')
                ->select('column_type', 'organization')
                ->assertSee('Approval Multiple Select');
            $browser->script('document.querySelector(".options_multiple_enabled.la_checkbox").click();');
            $browser->press('Submit')
                ->pause(5000)
                ->assertPathIs('/admin/column/ntq_data')
                ->assertSee('organization');
        });
    }

// AutoTest_Data_22
    public function testCreatForm()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/form/ntq_data') ;
            $browser->script('$(".table-hover td").filter(function(){return $.trim($(this).text()) == "NTQ Data"}).closest("tr").click();');
            $browser->pause(5000)
                ->with('form div:nth-child(1)', function ($block1) {
                    $block1->type('form_view_name', 'NTQ Data View');
                });
            $browser->with('form div:nth-child(2)', function ($block2) {
                $block2->keys('div.box-body .form-inline input[name*="form_block_view_name"]', ['{CONTROL}', 'a'], 'NTQ Form Data');
                $block2->with('div.box-body div[id*="suggests_default"]', function ($block_suggest) {
                    $block_suggest->press('Add All Items');
                });
            });
            $browser->press('Submit');
        });
    }
    // AutoTest_Data_23
    public function testAddRecordSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data/create')
                ->type('value[integer]', 99)
                ->type('value[onelinetext]', 'NTQ Test Data 1')
                ->type('value[multiplelinetext]','NTQ Test Data Multiline Text')
                ->click('#embed-value input.select2-search__field')
                ->click('ul.select2-results__options li:first-child');
            $browser->script('document.querySelector(".value_select2value.la_checkbox").click();');
            $browser->script('document.querySelector(".value_yesno.la_checkbox").click();');
            $browser->keys('input[name*="value[dateandtime]"]', " 2018-09-26 09:00:00", '{ENTER}');
            $browser->type('value[decimal]',99.99)
                ->keys('input[name*="value[date]"]', "2018-09-26", '{ENTER}')
                ->keys('input[name*="value[time]"]', "09:00:00", '{ENTER}')
                ->type('value[calcresult]','+,-,x,:')
                ->type('value[email]','admin@admin.com')
                ->type('value[url]','https://google.com')
            ;
            $browser->press('Submit')
                ->pause(5000)
                ->waitForText('Save succeeded !')
                ->assertPathIs('/admin/data/ntq_data')
                ->assertSee('Showing 1 to 1 of 1 entries')
            ;
        });
    }

    // AutoTest_Data_24
    public function testVerifyRecord1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data')
                       ->assertSee('NTQ Test Data 1');
            $browser->script('$(".table-hover td").filter(function(){return $.trim($(this).text()) == "NTQ Test Data 1"}).closest("tr").click();');
           $browser->assertSee('99')
               ->assertSee('NTQ Test Data 1')
               ->assertSee('NTQ Test Data Multiline Text')
               ->assertSee('Value1')
               ->assertSee('YES')
               ->assertSee('Option 1')
               ->assertSee('99.99')
               ->assertSee('2018-09-26')
               ->assertSee('09:00:00')
               ->assertSee('+,-,x,:')
               ->assertSee('testuser')
           ;
        });
    }

    // AutoTest_Data_25
    public function testAddRecord2Success()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data/create')
                ->type('value[integer]', 99)
                ->type('value[onelinetext]', 'NTQ Test Data 2')
                ->type('value[multiplelinetext]','NTQ Test Data Multi line Text')


                ->click('#embed-value input.select2-search__field')
                ->click('ul.select2-results__options li:last-child');
            $browser->keys('input[name*="value[dateandtime]"]', "2018-09-26 09:00:00", '{ENTER}');
            $browser->type('value[decimal]',99.99)
                ->keys('input[name*="value[date]"]', "2018-09-26", '{ENTER}')
                ->keys('input[name*="value[time]"]', "09:00:00", '{ENTER}')
                ->type('value[calcresult]','+,-,x,:')
                ->type('value[email]','admin@admin.com')
                ->type('value[url]','https://google.com')
            ;
            $browser->press('Submit')
                ->pause(5000)
                ->waitForText('Save succeeded !')
                ->assertPathIs('/admin/data/ntq_data')
                ->assertSee('Showing 1 to 2 of 2 entries')
            ;
        });
    }

    // AutoTest_Data_26
    public function testVerifyRecord2()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data')
                ->assertSee('NTQ Test Data 2');
            $browser->script('$(".table-hover td").filter(function(){return $.trim($(this).text()) == "NTQ Test Data 2"}).closest("tr").click();');
            $browser->assertSee('99')
                ->assertSee('NTQ Test Data 2')
                ->assertSee('NTQ Test Data Multiline Text')
                ->assertSee('Value2')
                ->assertSee('NO')
                ->assertSee('Option 2')
                ->assertSee('99.99')
                ->assertSee('2018-09-26')
                ->assertSee('09:00:00')
                ->assertSee('+,-,x,:')
                ->assertSee('testuser')
            ;
        });
    }

    // AutoTest_Data_27
    public function testEditRecord1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data')
                ->assertSee('NTQ Test Data 1');
            $browser->script('$(".table-hover td").filter(function(){return $.trim($(this).text()) == "NTQ Test Data 1"}).closest("tr").click();');
            $browser->type('value[integer]', 100)
                ->type('value[onelinetext]', 'NTQ Test Data 1 Edited')
                ->type('value[multiplelinetext]','NTQ Test Data Multiline Text')
                ->click('#embed-value input.select2-search__field')
                ->click('ul.select2-results__options li:last-child');
            $browser->script('document.querySelector(".value_select2value.la_checkbox").click();');
            $browser->script('document.querySelector(".value_yesno.la_checkbox").click();');

            $browser->keys('input[name*="value[dateandtime]"]', " 2018-09-26 19:00:00", '{ENTER}');
            $browser->type('value[decimal]',9.9)
                ->keys('input[name*="value[date]"]', "2018-09-27", '{ENTER}')
                ->keys('input[name*="value[time]"]', "09:00:00", '{ENTER}')
                ->type('value[calcresult]','+,-,x,:')
                ->type('value[email]','admin@admin.com')
                ->type('value[url]','https://google.com')
            ;
            $browser->press('Submit')
                ->pause(5000)
                ->waitForText('Save succeeded !')
                ->assertPathIs('/admin/data/ntq_data')
                ->assertSee('Showing 1 to 2 of 2 entries')
            ;
        });
    }
	
	// AutoTest_Data_28
    public function testFilterAll()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data');
            $browser->script('$(\'label[title="Filter"]\').click()');
            $browser->pause(1000)
                ->assertSee('Search');
            $browser->script('$(\'.btn-info.submit i.fa.fa-search\').click()');
            $browser->pause(2000)
                ->assertSee('Showing 1 to 2 of 2 entries');
        });
    }

    // AutoTest_Data_29
    public function testFilterOneLineText()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data');
            $browser->script('$(\'label[title="Filter"]\').click()');
            $browser->pause(1000)
                ->assertSee('Search')
                ->keys('input[placeholder="One Line Tex"]', 'NTQ Test Data 1');
            $browser->script('$(\'.btn-info.submit i.fa.fa-search\').click()');
            $browser->pause(2000)
                ->assertSee('Showing 1 to 1 of 1 entries');
        });
    }

    // AutoTest_Data_30
    public function testFilterInterger()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data');
            $browser->script('$(\'label[title="Filter"]\').click()');
            $browser->pause(1000)
                ->assertSee('Search')
                ->keys('input[placeholder="Interger"]', '100');
            $browser->script('$(\'.btn-info.submit i.fa.fa-search\').click()');
            $browser->pause(2000)
                ->assertSee('Showing 1 to 1 of 1 entries');
        });
    }

    // AutoTest_Data_31
    public function testFilterSelectFromStaticValue()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data');
            $browser->script('$(\'label[title="Filter"]\').click()');
            $browser->pause(1000)
                ->assertSee('Search')
                ->keys('input[placeholder="Select From Static Value"]', 'Option 2');
            $browser->script('$(\'.btn-info.submit i.fa.fa-search\').click()');
            $browser->pause(2000)
                ->assertSee('Showing 1 to 1 of 1 entries');
        });
    }

    // AutoTest_Data_32
    public function testFilterURL()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data');
            $browser->script('$(\'label[title="Filter"]\').click()');
            $browser->pause(1000)
                ->assertSee('Search')
                ->keys('input[placeholder="URL"]', 'https://google.com');
            $browser->script('$(\'.btn-info.submit i.fa.fa-search\').click()');
            $browser->pause(2000)
                ->assertSee('Showing 1 to 1 of 1 entries');
        });
    }

    // AutoTest_Data_33
    public function testFilterEmail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data');
            $browser->script('$(\'label[title="Filter"]\').click()');
            $browser->pause(1000)
                ->assertSee('Search')
                ->keys('input[placeholder="Email"]', 'admin@admin.com');
            $browser->script('$(\'.btn-info.submit i.fa.fa-search\').click()');
            $browser->pause(2000)
                ->assertSee('Showing 1 to 1 of 1 entries');
        });
    }

    // AutoTest_Data_34
    public function testFilterDecimal()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data');
            $browser->script('$(\'label[title="Filter"]\').click()');
            $browser->pause(1000)
                ->assertSee('Search')
                ->keys('input[placeholder="Decimal"]', '9.9');
            $browser->script('$(\'.btn-info.submit i.fa.fa-search\').click()');
            $browser->pause(2000)
                ->assertSee('Showing 1 to 1 of 1 entries');
        });
    }

    // AutoTest_Data_35
    public function testFilterDate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data');
            $browser->script('$(\'label[title="Filter"]\').click()');
            $browser->pause(1000)
                ->assertSee('Search')
                ->keys('input[placeholder="Date"]', '2018-09-27');
            $browser->script('$(\'.btn-info.submit i.fa.fa-search\').click()');
            $browser->pause(2000)
                ->assertSee('Showing 1 to 1 of 1 entries');
        });
    }

    // AutoTest_Data_36
    public function testFilterDateAndTime()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data');
            $browser->script('$(\'label[title="Filter"]\').click()');
            $browser->pause(1000)
                ->assertSee('Search')
                ->keys('input[placeholder="Date and Time"]', '2018-09-26 19:00:00');
            $browser->script('$(\'.btn-info.submit i.fa.fa-search\').click()');
            $browser->pause(2000)
                ->assertSee('Showing 1 to 1 of 1 entries');
        });
    }

    // AutoTest_Data_36
    public function testFilterTime()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/ntq_data');
            $browser->script('$(\'label[title="Filter"]\').click()');
            $browser->pause(1000)
                ->assertSee('Search')
                ->keys('input[placeholder="Time"]', '19:00:00');
            $browser->script('$(\'.btn-info.submit i.fa.fa-search\').click()');
            $browser->pause(2000)
                ->assertSee('Showing 1 to 1 of 1 entries');
        });
    }

    // AutoTest_Data_37
    public function testDeleteUsingColumnAction()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/nhanvien');
            $browser->script('$(".table-hover td").filter(function(){return $.trim($(this).text()) == "NTQ Test Data 1 Edited"}).closest("tr").find("a.grid-row-delete").click();');
            $browser->pause(2000)
                ->press('Confirm')
                ->pause(2000)
                ->assertSee('Showing 1 to 1 of 1 entries');
        });
    }

    // AutoTest_Data_38
    public function testDeleteUsingActionDropdown()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/data/nhanvien');
            $browser->script('$(\'span\').parent().parent().find("button.dropdown-toggle:nth-child(2)").click();');
            $browser->script('$(\'span\').parent().parent().find("button.dropdown-toggle:nth-child(2)").parent().find("ul li a").click();');
            $browser->pause(2000)
                ->press('Confirm')
                ->pause(2000)
                ->assertSee('Showing 0 to 0 of 0 entries');
        });
    }
}
