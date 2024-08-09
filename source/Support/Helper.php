<?php
    
    namespace Source\Support;
    
    class Helper
    {
        private static $Data;
        private static $Format;
        
        /**
         * HELPER
         * <b>uri:</b> Tranforma uma string no formato de URL amigável e retorna o a string convertida!
         */
        public static function uri($string)
        {
            if (is_string($string)) {
                $string = strtolower(trim(utf8_decode($string)));
                
                $before = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr';
                $after = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
                $string = strtr($string, utf8_decode($before), $after);
                
                $replace = array(
                    '/[^a-z0-9.-]/' => '-',
                    '/-+/' => '-',
                    '/\-{2,}/' => ''
                );
                $string = preg_replace(array_keys($replace), array_values($replace), $string);
            }
            return $string;
        }
        
        /**
         * HELPER
         * <b>real:</b> Tranforma um número inteiro em formato de moeda real brasileiro.
         */
        public static function real($valor)
        {
            $valor = number_format($valor, 2, ",", ".");
            return $valor;
        }
        
        /**
         * HELPER
         * <b>dollar:</b> Tranforma um número inteiro em formato de moeda dollar americano.
         */
        public static function dollar($valor)
        {
            $valor = str_replace(".", "", $valor);
            $valor = str_replace(",", ".", $valor);
            return $valor;
        }
        
        /**
         * HELPER
         * <b>Limita as Palavras:</b> Limita a quantidade de palavras a serem exibidas em uma string!
         */
        public static function lmWord($string, $words = '100')
        {
            $string = strip_tags($string);
            $count = strlen($string);
            
            if ($count <= $words) {
                return $string;
            }
            else {
                $strpos = strrpos(substr($string, 0, $words), ' ');
                return substr($string, 0, $strpos) . '(...)';
            }
        }
        
        /**
         * HELPER
         * <b>Verifica E-mail:</b> Executa validação de formato de e-mail. Se for um email válido retorna true, ou retorna false.
         */
        public static function email($Email)
        {
            self::$Data = (string)$Email;
            self::$Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';
            
            if (preg_match(self::$Format, self::$Data)):
                return true;
            else:
                return false;
            endif;
        }
        
        /**
         * HELPER
         * <b>Checa CPF:</b> Informe um CPF para checar sua validade via algoritimo!
         */
        public static function cpf($Cpf)
        {
            self::$Data = preg_replace('/[^0-9]/', '', $Cpf);
            
            $digitoA = 0;
            $digitoB = 0;
            
            for ($i = 0, $x = 10; $i <= 8; $i++, $x--) {
                $digitoA += self::$Data[$i] * $x;
            }
            
            for ($i = 0, $x = 11; $i <= 9; $i++, $x--) {
                if (str_repeat($i, 11) == self::$Data) {
                    return false;
                }
                $digitoB += self::$Data[$i] * $x;
            }
            
            $somaA = (($digitoA % 11) < 2) ? 0 : 11 - ($digitoA % 11);
            $somaB = (($digitoB % 11) < 2) ? 0 : 11 - ($digitoB % 11);
            
            if ($somaA != self::$Data[9] || $somaB != self::$Data[10]) {
                return false;
            }
            else {
                return true;
            }
        }
        
        /**
         * HELPER
         * <b>Checa CNPJ:</b> Informe um CNPJ para checar sua validade via algoritimo!
         */
        public static function cnpj($Cnpj)
        {
            self::$Data = str_replace([
                ".",
                "-",
                "/"
            ], "", $Cnpj);
            
            $j = 0;
            for ($i = 0; $i < (strlen(self::$Data)); $i++) {
                if (is_numeric(self::$Data[$i])) {
                    $num[$j] = self::$Data[$i];
                    $j++;
                }
            }
            
            if (count($num) != 14) {
                $isCnpjValid = false;
            }
            
            if ($num[0] == 0 && $num[1] == 0 && $num[2] == 0 && $num[3] == 0 && $num[4] == 0 && $num[5] == 0 && $num[6] == 0 && $num[7] == 0 && $num[8] == 0 && $num[9] == 0 && $num[10] == 0 && $num[11] == 0) {
                $isCnpjValid = false;
            }
            
            else {
                $j = 5;
                for ($i = 0; $i < 4; $i++) {
                    $multiplica[$i] = $num[$i] * $j;
                    $j--;
                }
                $soma = array_sum($multiplica);
                $j = 9;
                for ($i = 4; $i < 12; $i++) {
                    $multiplica[$i] = $num[$i] * $j;
                    $j--;
                }
                $soma = array_sum($multiplica);
                $resto = $soma % 11;
                if ($resto < 2) {
                    $dg = 0;
                }
                else {
                    $dg = 11 - $resto;
                }
                if ($dg != $num[12]) {
                    $isCnpjValid = false;
                }
            }
            
            if (!isset($isCnpjValid)) {
                $j = 6;
                for ($i = 0; $i < 5; $i++) {
                    $multiplica[$i] = $num[$i] * $j;
                    $j--;
                }
                $soma = array_sum($multiplica);
                $j = 9;
                for ($i = 5; $i < 13; $i++) {
                    $multiplica[$i] = $num[$i] * $j;
                    $j--;
                }
                $soma = array_sum($multiplica);
                $resto = $soma % 11;
                if ($resto < 2) {
                    $dg = 0;
                }
                else {
                    $dg = 11 - $resto;
                }
                if ($dg != $num[13]) {
                    $isCnpjValid = false;
                }
                else {
                    $isCnpjValid = true;
                }
            }
            
            return $isCnpjValid;
        }
        
        /**
         * HELPER
         * <b>Tranforma Data:</b> Transforma uma data no formato DD/MM/YY em uma data no formato YYYY-MM-DD!
         */
        public static function date($Data)
        {
            self::$Format = explode(' ', $Data);
            self::$Data = explode('/', self::$Format[0]);
            
            if (checkdate(self::$Data[1], self::$Data[0], self::$Data[2])):
                self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0];
                return self::$Data;
            else:
                return false;
            endif;
        }
        
        /**
         * HELPER
         * <b>Tranforma TimeStamp:</b> Transforma uma data no formato DD/MM/YY em uma data no formato TIMESTAMP!
         */
        public static function timestamp($Data)
        {
            self::$Format = explode(' ', $Data);
            self::$Data = explode('/', self::$Format[0]);
            
            if (!checkdate(self::$Data[1], self::$Data[0], self::$Data[2])):
                return false;
            else:
                if (empty(self::$Format[1])):
                    self::$Format[1] = date('H:i:s');
                endif;
                
                self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0] . ' ' . self::$Format[1];
                return self::$Data;
            endif;
        }
    
        /**
         * HELPER
         * <b>Imagem Upload:</b> Ao executar este HELPER, ele automaticamente verifica a existencia da imagem na pasta
         * uploads. Se existir retorna a imagem redimensionada!
         */
        public static function image($imagePath, $imageDesc, $class = null)
        {
            self::$Data = $imagePath;
            $path = HOME;
            $image = self::$Data;
            return "<img src=\"{$path}/{$image}\" class=\"{$class}\" alt=\"{$imageDesc}\" title=\"{$imageDesc}\"/>";
        }
    
        /**
         * HELPER
         * <b>Video Frame:</b> Ao executar este HELPER, ele automaticamente adiciona o embed/iframe do youtube ou vimeo
         */
        public static function video($VideoCod, $TypeEmbed, $Params = null)
        {
            self::$Data = $VideoCod;
            $Video = self::$Data;
            $Paramet = (empty($Params) ? null : $Params);
            $Type = $TypeEmbed;
        
            if ($Type == "youtube"):
                return "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/{$Video}{$Paramet}\" frameborder=\"0\" allow=\"accelerometer; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
            elseif ($Type == "vimeo"):
                return "<iframe src=\"https://player.vimeo.com/video/{$Video}{$Paramet}\" width=\"640\" height=\"360\" frameborder=\"0\" allow=\"fullscreen\" allowfullscreen></iframe>";
            endif;
        }
    
        public static function zero($data, $zero = 5)
        {
            return str_pad($data, $zero, '0', STR_PAD_LEFT);
        }
    
        public static function code($size = 10, $count = 1, $types = "lower_case,upper_case,numbers")
        {
            /*
             * $size - the length of the generated password
             * $count - number of passwords to be generated
             * $types - types of characters to be used in the password
             */
            $symbols = array();
            $passwords = array();
            $usedSymbols = '';
            $pass = null;
        
            $symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
            $symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $symbols["numbers"] = '1234567890';
            $symbols["special_symbols"] = '!?~@#-_+<>[]{}';
        
            $characters = explode(",", $types);
            foreach ($characters as $key => $value):
                $usedSymbols .= $symbols[$value];
            endforeach;
            $symbolsLength = strlen($usedSymbols) - 1;
        
            if ($count == 1):
                $pass = null;
                for ($i = 0; $i < $size; $i++):
                    $n = rand(0, $symbolsLength);
                    $pass .= $usedSymbols[$n];
                endfor;
                $passwords = $pass;
            else:
                for ($p = 0; $p < $count; $p++):
                    $pass = null;
                    for ($i = 0; $i < $size; $i++):
                        $n = rand(0, $symbolsLength);
                        $pass .= $usedSymbols[$n];
                    endfor;
                    $passwords[] = $pass;
                endfor;
            endif;
        
            return $passwords;
        }
    }