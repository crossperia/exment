<?php

namespace Exceedone\Exment\Console;

use Illuminate\Console\Command;
use Exceedone\Exment\Model\Notify;
use Exceedone\Exment\Model\CustomTable;
use Exceedone\Exment\Model\CustomColumn;
use Exceedone\Exment\Model\System;
use Exceedone\Exment\Enums\SystemTableName;
use Exceedone\Exment\Services\MailSender;
use Carbon\Carbon;


class ScheduleCommand extends Command
{
    use CommandTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'exment:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute Schedule Batch';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->notify();
        $this->backup();
    }

    /**
     * notify user flow
     */
    protected function notify()
    {
        // get notifies data for notify_trigger is 1(time), and notify_hour is executed time
        $hh = Carbon::now()->format('G');
        $notifies = Notify::where('notify_trigger', '1')
            ->where('trigger_settings->notify_hour', $hh)
            ->get();

        // loop for $notifies
        foreach ($notifies as $notify) {
            // get target date number.
            $before_after_number = intval(array_get($notify->trigger_settings, 'notify_beforeafter'));
            $notify_day = intval(array_get($notify->trigger_settings, 'notify_day'));

            // calc target date
            $target_date = Carbon::today()->addDay($before_after_number * $notify_day * -1);
            $target_date_str = $target_date->format('Y-m-d');

            // get target table and column
            $table = CustomTable::find(array_get($notify, 'custom_table_id'));
            $column = CustomColumn::find(array_get($notify->trigger_settings, 'notify_target_column'));
    

            // find data. where equal target_date
            $datalist = getModelName(array_get($notify, 'custom_table_id'))
                ::where('value->'.$column->column_name, $target_date_str)
                ->get();

            // send mail
            foreach ($datalist as $data) {
                // get user list
                $value_authoritable_users = $data->value_authoritable_users->toArray();
        
                // get organization
                if (System::organization_available()) {
                    $value_authoritable_organizations = System::organization_available() ? $data->value_authoritable_organizations : [];
                    foreach ($value_authoritable_organizations as $value_authoritable_organization) {
                        $children_users = $value_authoritable_organization->getChildrenValues(SystemTableName::USER)->toArray() ?? [];
                        $value_authoritable_users = array_merge($value_authoritable_users, $children_users);
                    }
                }
        
                foreach ($value_authoritable_users as $user) {
                    $notify_target_table = CustomTable::find($notify->custom_table_id);
                    $notify_target_column = CustomColumn::find(array_get($notify->toArray(), 'trigger_settings.notify_target_column'));
                    $prms = [
                'user' => $user,
                'notify' => $notify->toArray(),
                'target_table' => $notify_target_table->table_view_name,
                'target_value' => $data->getLabel(),
                'notify_target_column_key' => $notify_target_column->column_view_name,
                'notify_target_column_value' => $data->getValue($notify_target_column),
                'data_url' => admin_urls("data", $notify_target_table->table_name, $data->id),
            ];

                    // send mail
                    MailSender::make(array_get($notify->action_settings, 'mail_template_id'), array_get($user, 'value.email'))
            ->prms($prms)
            ->send();
                }
            }
        }
    }

    protected function backup(){
        if(!boolval(System::backup_enable_automatic())){
            return;
        }

        $now = Carbon::now();
        $hh = $now->hour;        
        if($hh != System::backup_automatic_hour()){
            return;
        }

        $last_executed = System::backup_automatic_executed();
        if(isset($last_executed)){
            $term = System::backup_automatic_term();
            if($last_executed->addDay($term)->today()->gt($now->today())){
                return;
            }
        }

        // get target
        $target = System::backup_target();
        \Artisan::call('exment:backup', isset($target) ? ['--target' => $target] : []);

        System::backup_automatic_executed($now);
    }
}
