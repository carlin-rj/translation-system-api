<?php

namespace App\Console;

use App\Console\Commands\AutoSyncAcknowledgeOrder;
use App\Console\Commands\AutoSyncPlatformProduct;
use App\Console\Commands\AutoTranslate;
use App\Console\Commands\AutoVerifyOrdinaryOrder;
use App\Console\Commands\AutoVerifyPlatformOrder;
use App\Console\Commands\PickUpPlatformOrder;
use App\Console\Commands\PullPlatformOrder;
use App\Console\Commands\QueueLogBackup;
use App\Console\Commands\SyncPlatformInventory;
use App\Console\Commands\TiktokSyncBatchPutaway;
use App\Console\Commands\UpdatePlatformUserAuthStatus;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Handler
{
    public function handle(Schedule $schedule)
    {
        //导出任务检查
        //$this->exec($schedule, 'export:check-failed', '*/10 * * * *');

        //账号授权定时任务
        //$this->exec($schedule, 'platform-user:update_auth_status', '*/2 * * * *');

        //平台载单
        //$this->exec($schedule, 'platform-orders:pull', '0,15,30,50 * * * *');
        //
        ////补载平台订单
        //$this->exec($schedule, 'platform-orders:pick-up', '0,30 * * * *');
        //
        ////自动审核平台订单
        //$this->exec($schedule, 'platform-orders:verify', '0,15,30,50 * * * *');
        //
        ////自动审核普通订单
        //$this->exec($schedule, 'ordinary-orders:verify', '0,15,30,50 * * * *');
        //
        ////自动同步库存
        //$this->exec($schedule, 'platform-product:inventory', '0,15,30,50 * * * *');
        //
        ////增量同步库存
        //$this->exec($schedule, 'platform-product:incremental_inventory', '0,10,20,30,40,50 * * * *');
        //
        ////自动同步平台商品
        //$this->exec($schedule, 'platform-product:sync', '11 * * * *');
        //
        ////自动确认平台订单
        //$this->exec($schedule, 'platform-order:ack', '0,15,30,50 * * * *');
        //
        ////自动翻译
        //$this->exec($schedule, 'translate:sync', '* * * * *');
        //
        ////平台账号站点映射同步 ca 同步
        //$this->exec($schedule, 'platform-site:update_site_mapping', '0 7 * * *');
        //
        ////tiktok库存快照通知
        //$this->exec($schedule, 'tiktok-sync:inventory-snapshot', '0 2 * * *');
        //
        ////sps交易文件列表文件删除
        //$this->exec($schedule, 'delete-transactions-list:file', '21,41 * * * *');
        //
        ////平台账号授权信息获取
        //$this->exec($schedule, 'platform-user:reauth', '*/2 * * * *');
        //
        ////队列日志备份
        //$this->exec($schedule, 'backup:gd_queue_log', '0 12 * * *');
        //
        ////openapi调用记录统计
        //$this->exec($schedule, 'openApi:stats', '*/1 * * * *');
        //
        ////更新shipstation平台账号标签
        //$this->exec($schedule, 'platform-tags:update_tags', '0 0 * * *');
        //
        ////tiktok上架批次同步
        //$this->exec($schedule, 'tiktok-sync:batch-putaway', '00 2,6,20 * * *');
    }

    /**
     * 执行命令
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @param string $command
     * @param string $cron
     * @return \Illuminate\Console\Scheduling\Event
     */
    private function exec(Schedule $schedule, string $command, string $cron)
    {
        return $schedule->command($command)
            ->cron($cron)
            ->withoutOverlapping(3 * 60)//3个小时内只允许一个相同任务执行(时间太长可能会有进程突然挂掉而一直无法执行定时任务)
            ->onOneServer()//只允许在一台服务器上执行
            ->runInBackground();//后台执行
    }
}
