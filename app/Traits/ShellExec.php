<?php

namespace App\Traits;

trait ShellExec
{
    /**
     * Run Application in background
     *
     * @param unknown_type $Command
     * @param unknown_type $Priority
     * @return     PID
     */
    public function background($process)
    {
       pclose(popen("cd .. && nohup php artisan queue:list --tries=3 --sleep=0 --queue=$process >/dev/null 2>&1 &","r"));
        //$PID = `cd .. && nohup php artisan queue:list --tries=3 --queue=$process > /dev/null & echo $!`;
        return true;
        /* if ($Priority)
             $PID = shell_exec("nohup nice -n $Priority $Command > /dev/null & echo $!");
         else
             $PID = shell_exec("nohup $Command > /dev/null & echo $!");
         return ($PID);*/
    }

    /**
     * Check if the Application running !
     *
     * @return     boolen
     */
    public function is_running()
    {
        //exec("ps $PID", $ProcessState);
        exec("ps -aux", $ProcessState);
        return ($ProcessState);
        /* exec("ps $PID", $ProcessState);
         return (count($ProcessState) >= 2);*/
    }

    /**
     * Kill Application PID
     *
     * @param unknown_type $PID
     * @return boolen
     */
    public function kill($PID)
    {
        if ($this->is_running($PID)) {
            exec("kill -KILL $PID");
            return true;
        } else return false;
    }
}
