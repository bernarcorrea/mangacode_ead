<?php
    
    namespace Source\App\Web;
    
    class Hotmart
    {
        public function request($data)
        {
            $getHotmart = $data;
            
            if ($getHotmart && !empty($getHotmart['hottok']) && $getHotmart['hottok'] == HOTMART['token']):
                /*
                 * LIMPA DADOS
                 */
                array_map('strip_tags', $getHotmart);
                array_map('trim', $getHotmart);
                array_map('rtrim', $getHotmart);
                /*
                 * EXECUTA OBJETO HOTMART
                 */
                $hotmart = new \Source\Models\Hotmart($getHotmart);
                echo '<pre>';
                var_dump($hotmart->result());
                echo '</pre>';
            else:
                echo $getHotmart['hottok'];
                return false;
            endif;
        }
    }