<?php
    
    namespace Source\App\Cron;
    
    use Source\Models\Subscriber;
    
    class Cron
    {
        /**
         * VERIFICA ASSINATURAS VENCIDAS DA PLATAFORMA
         */
        public function subscribers()
        {
            $today = date('Y-m-d');
            $subscribers = (new Subscriber())->find("end_date < :today", "today={$today}")->fetch(true);
            if ($subscribers):
                foreach ($subscribers as $s):
                    $sub = (new Subscriber())->findById($s->id);
                    $sub->status = 2;
                    $sub->save();
                endforeach;
            endif;
        }
    }